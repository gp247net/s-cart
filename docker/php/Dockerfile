# =============================================================================
# PHP-FPM image for S-Cart (GP247 / Laravel 13)
#
# This image intentionally does NOT COPY application code, vendor/ or
# node_modules/ into it. The source code is bind-mounted from the host at
# runtime (see docker-compose.yml -> volumes: ./:/var/www/html), so:
#   - `git pull` on the host is instantly visible inside the container
#   - This image only needs to be rebuilt when PHP version/extensions change
# =============================================================================
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-fpm-bookworm

ARG WWWUSER=1000
ARG WWWGROUP=1000
ARG INSTALL_XDEBUG=false

# ---- System packages & PHP extensions required by Laravel 13 + GP247 -------
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        gnupg \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
        default-mysql-client \
        gosu \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
        intl \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/*

# ---- Xdebug (dev only, controlled by build arg) -----------------------------
RUN if [ "$INSTALL_XDEBUG" = "true" ]; then \
        pecl install xdebug && docker-php-ext-enable xdebug; \
    fi

# ---- Composer ----------------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Bind-mounting the project from a Windows host (e.g. /mnt/d/... under WSL2)
# makes filesystem I/O for large package extraction (aws-sdk-php, etc.) slow
# enough to exceed Composer's default 300s process-timeout. Raise it here so
# a slow `unzip` doesn't fail the whole install.
ENV COMPOSER_PROCESS_TIMEOUT=900

# www-data's $HOME (/var/www) isn't writable by www-data by default, which
# makes Composer fail to create its cache dir there. Point it at /tmp
# instead, which is always writable regardless of host UID/GID mapping.
ENV COMPOSER_CACHE_DIR=/tmp/composer-cache

# ---- PHP / OPcache configuration ---------------------------------------------
COPY php.ini /usr/local/etc/php/conf.d/99-scart.ini

# ---- Entrypoint ---------------------------------------------------------------
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# ---- Match container user to host user (avoids bind-mount permission issues
#      on Linux hosts; harmless on Docker Desktop for Windows/Mac) -----------
RUN groupmod -o -g "${WWWGROUP}" www-data \
    && usermod -o -u "${WWWUSER}" www-data

# On WSL2, files bind-mounted from a Windows drive (/mnt/c, /mnt/d, ...) are
# owned by a UID that generally won't match www-data/root inside the
# container. Git >=2.35.2 refuses to operate on a repo it doesn't own
# ("dubious ownership") unless explicitly told it's safe - Composer shells
# out to git during install/update, so this would otherwise break on every
# WSL2 host. --system applies regardless of which user (root or www-data)
# runs the command.
RUN git config --system --add safe.directory /var/www/html

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
