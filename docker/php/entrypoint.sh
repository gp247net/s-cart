#!/bin/sh
set -e

cd /var/www/html

# ---- First-run convenience: create .env if missing -------------------------
if [ ! -f .env ] && [ -f .env.example ]; then
    echo "[entrypoint] .env not found, copying from .env.example"
    cp .env.example .env
fi

# ---- Wait for the database to accept connections (mysql only) --------------
if [ "${DB_CONNECTION:-mysql}" = "mysql" ] && [ -n "${DB_HOST}" ]; then
    echo "[entrypoint] Waiting for database at ${DB_HOST}:${DB_PORT:-3306}..."
    tries=0
    until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT:-3306}', '${DB_USERNAME}', '${DB_PASSWORD}');" >/dev/null 2>&1; do
        tries=$((tries + 1))
        if [ "$tries" -ge 30 ]; then
            echo "[entrypoint] Database did not become available in time, continuing anyway..."
            break
        fi
        sleep 2
    done
fi

# ---- Install PHP dependencies if vendor/ is missing (first run only) -------
# Only the app (php-fpm) container runs `composer install`; queue/scheduler
# just wait for it to finish, to avoid two containers writing into the same
# vendor/ volume at once.
if [ ! -f vendor/autoload.php ]; then
    if [ "$1" = "php-fpm" ]; then
        echo "[entrypoint] vendor/ not found, running composer install (this can take a while on first run)..."
        # vendor/ is a named Docker volume (see docker-compose.yml), which
        # Docker creates owned by root on first mount - fix that (and any
        # leftovers from a previous failed install) before writing to it as
        # www-data.
        mkdir -p vendor
        chown -R www-data:www-data vendor
        gosu www-data composer install --no-interaction --prefer-dist --optimize-autoloader
    else
        echo "[entrypoint] Waiting for vendor/ to be installed by the app container..."
        tries=0
        until [ -f vendor/autoload.php ]; do
            tries=$((tries + 1))
            if [ "$tries" -ge 150 ]; then
                echo "[entrypoint] Timed out waiting for vendor/autoload.php, continuing anyway..."
                break
            fi
            sleep 2
        done
    fi
fi

# ---- Ensure Laravel writable directories exist and have correct owner -----
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage/framework storage/logs bootstrap/cache

# app/GP247, public/GP247, resources/views/vendor and storage/app are created
# by `sc:install`/`sc:sample` and live on the bind-mounted host filesystem, so
# they survive image rebuilds automatically. We only fix ownership on the
# framework/cache dirs above to avoid an expensive recursive chown over
# potentially large product-image uploads on every container start.

# ---- Symlink storage (idempotent) ------------------------------------------
if [ -f artisan ] && [ ! -L public/storage ]; then
    echo "[entrypoint] Linking storage..."
    gosu www-data php artisan storage:link || true
fi

echo "[entrypoint] Starting: $*"

# php-fpm's master process must stay root (that's how the official image is
# designed to run) so it can open its own stdout/stderr; it drops privileges
# to www-data internally per-worker via the pool config (user/group in
# www.conf). Only non-php-fpm commands (queue:work, the scheduler loop) are
# dropped to www-data here.
if [ "$1" = "php-fpm" ]; then
    if [ "${PHP_FPM_ALLOW_ROOT:-false}" = "true" ]; then
        # php-fpm refuses to configure a worker pool whose resolved
        # user/group is UID/GID 0 unless told it's intentional. Only reached
        # when PHP_FPM_ALLOW_ROOT=true is explicitly set (dev docker-compose,
        # WSL2 workaround) - prod's docker-compose.prod.yml never sets this,
        # so a stray WWWUSER=0 there fails loudly instead of silently
        # running workers as root.
        exec "$@" --allow-to-run-as-root
    else
        exec "$@"
    fi
else
    exec gosu www-data "$@"
fi
