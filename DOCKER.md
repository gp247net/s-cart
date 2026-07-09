# Docker Guide for S-Cart (GP247 / Laravel 13)

*(Vietnamese version: [DOCKER_vi.md](DOCKER_vi.md))*

This guide gets you from zero to a running S-Cart site with Docker, for both
a local dev environment and a production server. Follow the steps in order.

## Requirements

- Docker Desktop (Windows/Mac) or Docker Engine + Compose plugin (Linux)
- A copy of this repository on your machine (or server)

---

## Part 1 — Run the DEV environment

**1. Copy the environment file**

```bash
cp .env.example .env
```

`.env.example` already ships with working defaults (a local dockerized
MySQL database), so you don't need to edit anything to get started.

**2. Start the containers**

```bash
docker compose up -d --build
```

This builds the PHP image and starts everything: the app, Nginx, MySQL,
the queue worker, and the scheduler.

**3. Install S-Cart**

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan sc:install
docker compose exec app php artisan sc:sample   # optional: adds sample data
```

**4. Open the site**

- Website: http://localhost:8000
- Vite dev server (asset hot-reload): http://localhost:5173

Both ports and the database credentials can be changed in `.env` before step 2
— see `APP_PORT`, `DB_*` and `COMPOSE_PROFILES`. If you want to connect to a
remote/managed database instead of the built-in one, see [Q: How do I use a
remote database instead of the built-in one?](#q-how-do-i-use-a-remote-database-instead-of-the-built-in-one)

That's it — dev is running. For day-to-day commands see [Part 3](#part-3--everyday-commands).

---

## Part 2 — Run the PROD environment

**1. Prepare `.env` on the server**

Copy `.env.example` to `.env` and set at minimum:

```env
APP_ENV=production
APP_DEBUG=false

# Database — pick ONE of the two options below
DB_CONNECTION=mysql
DB_HOST=your-remote-mysql-host   # or "mysql-local" if using the built-in DB — see 4.2
DB_PORT=3306
DB_DATABASE=scart-db-prod
DB_USERNAME=scar-user
DB_PASSWORD=********

# Required for prod: match the user Docker runs as on this server
WWWUSER=1000    # run `id -u` on the server
WWWGROUP=1000   # run `id -g` on the server
```

**2. Start the containers**

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

**3. Install S-Cart (first time only)**

```bash
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan sc:install
docker compose -f docker-compose.prod.yml exec app php artisan sc:sample   # optional
```

**4. Build frontend assets**

```bash
docker compose -f docker-compose.prod.yml run --rm node
```

Assets aren't pre-built into the image, so run this once after install and
again any time CSS/JS changes.

Your site is now live. Two database options and their exact `.env` values
are detailed in the Q&A below: [Q: What are my two database options in
prod, and what exact `.env` do they need?](#q-what-are-my-two-database-options-in-prod-and-what-exact-env-do-they-need)

Every command above spells out `-f docker-compose.prod.yml` in full, on
purpose. A command that's missing it silently falls back to
`docker-compose.yml` (the DEV file) instead of erroring — see [Q: I
accidentally ran `docker compose up -d --build` on prod (forgot `-f
docker-compose.prod.yml`) — what happens
now?](#q-i-accidentally-ran-docker-compose-up-d---build-on-prod-forgot--f-docker-composeprodyml--what-happens-now)
for what that actually does. Copy these commands as-is rather than
retyping them from memory.

**(Optional) Shorten your commands**

If you don't want to type `-f docker-compose.prod.yml` every time, you can
export it once per shell session:

```bash
export COMPOSE_FILE=docker-compose.prod.yml   # bash/zsh
# $env:COMPOSE_FILE = "docker-compose.prod.yml"   # PowerShell
```

This is a convenience for interactive sessions only — it doesn't persist
across a new SSH login, a new terminal tab, a cron job, or a deploy script
run non-interactively. **Don't assume it's already set** just because you
(or someone else) exported it once before. When in doubt, in a script, or
in CI, always use the explicit `-f docker-compose.prod.yml` form instead
of relying on `COMPOSE_FILE`.

---

## Part 3 — Everyday commands

The commands below omit `-f` for readability — they apply to whichever
environment your current shell is already targeting. **On a production
server, add `-f docker-compose.prod.yml` to every `docker compose` command
below.** Don't assume `COMPOSE_FILE` is already exported for this shell
session (see the note in Part 2) — check with `docker compose config
--services` first if unsure, or just always type `-f docker-compose.prod.yml`
explicitly.

**Updating code after a `git pull`:**

```bash
git pull
docker compose exec app composer install --no-interaction --optimize-autoloader   # if composer.lock changed
docker compose run --rm node                                                       # if assets changed
docker compose exec app php artisan migrate --force                                # if there are new migrations
docker compose exec app php artisan config:cache
```

No `docker compose build` or `restart` needed for plain code changes — see
[Q: When do I actually need to rebuild or restart?](#q-when-do-i-actually-need-to-rebuild-or-restart)

**Other common commands:**

```bash
# Run any artisan command
docker compose exec app php artisan <command>

# View logs
docker compose logs -f app
docker compose logs -f webserver

# Shell into a container
docker compose exec app sh

# Stop everything (data is kept — see Q&A)
docker compose down

# Backup MySQL (when using the built-in database)
docker compose exec mysql-local mysqldump -u root -p"$DB_ROOT_PASSWORD" scart > backup.sql

# Update PHP dependencies
docker compose exec app composer update --no-interaction --optimize-autoloader
docker compose restart queue scheduler   # so background workers pick up the new code
```

**Viewing the Laravel log:**

```powershell
# PowerShell
Get-Content storage\logs\laravel.log -Wait -Tail 50
```

```bash
# Git Bash / WSL / Linux / Mac
tail -f storage/logs/laravel.log
```

---

## Q&A

### Q: Why doesn't a `git pull` require rebuilding the Docker image?

Because the image never bakes in your application code. The whole project
folder is bind-mounted straight from your machine into the containers:

```yaml
volumes:
  - ./:/var/www/html
```

So new code on disk is immediately visible inside the containers — no
rebuild step. The image only contains PHP-FPM and its extensions; you only
rebuild when you change `docker/php/Dockerfile` (e.g. a new PHP version or
extension).

### Q: Will I lose my customizations (`app/GP247`, uploaded images, etc.) if I rebuild or recreate containers?

No. Because the whole project lives on your disk (not inside the image),
these folders persist automatically, with nothing extra to configure:

- `app/GP247` — your overrides of core/front/shop controllers, helpers,
  plugins, templates
- `public/GP247`, `public/vendor`
- `resources/views/vendor`
- `storage/app/public` — product images and uploads

When deploying to another server, just make sure these folders travel with
the code (git, rsync, or a backup, if not committed to git).

### Q: Why can't I browse `vendor/` or `node_modules/` from my file explorer?

`vendor/` and `node_modules/` are the one exception to the bind-mount above
— they live in Docker-managed named volumes (`scart-vendor`,
`scart-node-modules`) instead:

```yaml
volumes:
  - ./:/var/www/html
  - scart-vendor:/var/www/html/vendor
```

These folders contain tens of thousands of small files (`aws-sdk-php`
alone ships ~150 package definitions). Reading/writing that many small
files through a **Windows bind-mount** is slow enough that `composer
install`/`npm ci` can time out. A named volume lives in Docker's native
Linux storage instead, so it's fast — and it still survives container
recreation and image rebuilds (only lost via `docker compose down -v`). The
trade-off is you can't browse these folders directly from the host, which
is fine since you shouldn't hand-edit them anyway.

MySQL data is likewise stored in its own named volume
(`scart-mysql-local-data-dev` / `scart-mysql-local-data-prod`), so it also
survives `docker compose down` (only lost via `docker compose down -v`).

All three prod volumes (`scart-vendor`, `scart-node-modules`,
`scart-mysql-local-data-prod`) have an explicit `name:` pinned in
`docker-compose.prod.yml` (since modification `20260709T090000`), matching
these exact literal strings — this is independent of the compose project
name, so it doesn't change when the project name does.

> **Upgrading an existing prod deployment that predates this pin?** Run
> `docker volume ls` *before* pulling the updated `docker-compose.prod.yml`
> and confirm the actual volume names already match the ones above. If your
> existing prod install instead has project-prefixed volume names (e.g.
> `scart_scart-mysql-local-data-prod`), either rename them to match with
> `docker volume ls` + a one-time data copy, or override the `name:` field
> in `docker-compose.prod.yml` to match your existing volume before running
> `up`, so MySQL doesn't get mounted onto a new, empty volume. `vendor`/
> `node_modules` are safe either way — they rebuild automatically on
> container start (see `docker/php/entrypoint.sh`).

### Q: `composer install` fails with "process timeout" on first run — what do I do?

Symptom:

```
Install of aws/aws-sdk-php failed
The following exception is caused by a process timeout
...exceeded the timeout of 300 seconds.
```

This happens on Windows when the project lives under a Windows path mounted
into WSL2 (e.g. `/mnt/d/...`) — I/O through that bridge is slow for
packages with many small files. `docker/php/Dockerfile` already raises the
timeout (`COMPOSER_PROCESS_TIMEOUT=900`) and keeps `vendor/`/`node_modules/`
off the slow bind-mount (see previous Q&A), but if you still hit it:

- Just retry — it only needs to finish once:
  `docker compose exec app composer install --no-interaction --optimize-autoloader`
- For the best I/O performance, keep the project inside WSL2's native
  filesystem (e.g. `~/projects/s-cart-project`) instead of under
  `/mnt/c/...` or `/mnt/d/...`, and open it from Windows via
  `\\wsl$\<distro>\...` or VS Code's WSL Remote extension.

### Q: How do I use a remote database instead of the built-in one?

Whether the built-in `mysql-local` container starts at all is controlled
by `COMPOSE_PROFILES` in `.env`. To skip it and point at a remote/managed
database:

```env
DB_HOST=your-remote-mysql-host
COMPOSE_PROFILES=
```

To use the built-in database instead, set `COMPOSE_PROFILES=db-local` and
`DB_HOST=mysql-local` (this is the `.env.example` default for dev).

### Q: What are my two database options in prod, and what exact `.env` do they need?

**Option A — Remote/managed database (default, e.g. RDS/Cloud SQL):**

```env
DB_CONNECTION=mysql
DB_HOST=your-remote-mysql-host
DB_PORT=3306
DB_DATABASE=scart-db-prod
DB_USERNAME=scar-user
DB_PASSWORD=********
COMPOSE_PROFILES=
```

The `mysql-local` container will not be created.

**Option B — Dockerized MySQL:**

```env
DB_CONNECTION=mysql
DB_HOST=mysql-local
DB_PORT=3306
DB_DATABASE=scart-db
DB_USERNAME=scar-user
DB_PASSWORD=********
DB_ROOT_PASSWORD=********
COMPOSE_PROFILES=db-local
```

Either way, start with the same command:

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

### Q: When do I actually need to rebuild or restart?

General rule: files that get **copied into the image** (in
`docker/php/Dockerfile`) need a rebuild after editing. Files that are only
**mounted** (nginx/mysql config, `docker-compose*.yml`) just need the
container recreated/restarted — no rebuild. Application code (PHP, blade,
JS, CSS) needs neither, thanks to the bind mount and
`opcache.validate_timestamps=1`.

| Change | Rebuild? | Restart/recreate? | Command |
|---|---|---|---|
| `docker/php/Dockerfile` (PHP version, new extension) | **Yes** | Yes | `docker compose build app && docker compose up -d` |
| `docker/php/php.ini` | **Yes** | Yes | `docker compose build app && docker compose up -d` |
| `docker/php/entrypoint.sh` | **Yes** | Yes | `docker compose build app && docker compose up -d` |
| `.env` build args (`PHP_VERSION`, `WWWUSER`, `WWWGROUP`, `INSTALL_XDEBUG`) | **Yes** | Yes | `docker compose up -d --build` |
| `.env` runtime vars (`APP_ENV`, `APP_DEBUG`, `DB_HOST`, `APP_PORT`...) | No | Yes | `docker compose up -d` |
| `docker-compose.yml` / `docker-compose.prod.yml` (new service, volume/command change) | No | Yes | `docker compose up -d` |
| `docker/nginx/default.conf` | No | Yes | `docker compose restart webserver` |
| `docker/mysql/my.cnf` | No | Yes | `docker compose restart mysql` |
| Application PHP/blade code | No | **No** | Nothing (re-run `config:cache` if you use it) |
| `composer.json` / `composer.lock` | No | No | `docker compose exec app composer install ...` |
| `package.json` / JS-CSS assets | No | No | `docker compose run --rm node` |
| New migration | No | No | `docker compose exec app php artisan migrate --force` |

**Note:** if you've run `php artisan config:cache` before, `.env` changes
won't take effect until you re-run `config:cache` (or `config:clear`) —
this is unrelated to Docker itself.

### Q: I'm getting file permission errors — what's going on?

Dev runs the `app` container as root by default, specifically so you don't
hit bind-mount permission errors regardless of your OS. The trade-off:
files the container creates (logs, compiled views, published files) end up
owned by root on your disk. This is invisible on WSL2/Windows, but on
**native Linux** you may need `sudo` to edit/delete those files from
outside the container.

If that bothers you on native Linux, edit the `app` service in
`docker-compose.yml`:

```yaml
build:
  args:
    WWWUSER: "1000"   # your `id -u`
    WWWGROUP: "1000"  # your `id -g`
environment:
  PHP_FPM_ALLOW_ROOT: "false"
```

then:

```bash
docker compose build app
docker compose up -d
```

(This is what prod always uses — see Part 2.)

⚠️ On Windows, if you switch to a non-root user this way **and** your
project sits under a Windows drive mounted into WSL2 (`/mnt/c/...`,
`/mnt/d/...`), you'll likely hit `touch(): Utime failed: Operation not
permitted` from Laravel's Blade compiler — WSL2's bridge for Windows-drive
paths doesn't honor `utime()` for non-root UIDs. Fix: revert to the
hardcoded root default, or move the project into WSL2's native filesystem.

### Q: I deploy to prod as root and get `Permission denied` writing `composer.lock`/`vendor/` — how do I fix it?

Symptom:

```
file_put_contents(./composer.lock): Failed to open stream: Permission denied
```

Cause: in prod, `www-data` inside the container runs as the UID/GID from
`WWWUSER`/`WWWGROUP` (default `1000`). If you deploy/`git pull` as **root**,
the project files end up owned by root, and `www-data` can't write to them.

**Recommended fix** — set a default ACL once, so every future file root
creates is automatically writable by UID 1000:

```bash
apt-get install -y acl
cd /path/to/project
setfacl -R  -m u:1000:rwx .
setfacl -R -d -m u:1000:rwx .
```

After this, keep deploying as root as usual — no more `chown` needed.
Replace `1000` with your actual `WWWUSER` if it differs.

**Alternative** — change ownership outright (only if you can dedicate a
UID 1000 user to deployment, since every future write must then use that
same user):

```bash
chown -R 1000:1000 /path/to/project
```

### Q: Does re-running `sc:install` overwrite my customized files?

- If the destination file doesn't exist yet: it's just created.
- If it already exists: whether it's overwritten depends on whether the
  underlying publish command uses `--force` (only `gp247:core-install`
  does — see [Install.php](app/Console/Commands/Install.php:33)). This is
  standard S-Cart behavior, identical with or without Docker.
  **Back up `app/GP247` before re-running `sc:install`** if you've
  customized it.
- On Linux hosts, newly published files carry the container's UID/GID
  (mapped from `WWWUSER`/`WWWGROUP`) — you may need `chown` to edit them
  if that differs from your own user (reading still works, since published
  files are typically world-readable).

### Q: Where do the other logs live, and how do I see them?

`storage/logs/laravel.log` is already on your host (see Part 3). Two other
logs are **not**, since they aren't mounted out by default:

| Log | Where | How to view |
|---|---|---|
| Nginx access/error | Inside the `webserver` container | `docker compose logs -f webserver` |
| PHP-FPM stdout/stderr | Inside the `app` container | `docker compose logs -f app` |

To also get Nginx logs on the host, add this volume to the `webserver`
service in `docker-compose.yml`:

```yaml
volumes:
  - ./storage/logs/nginx:/var/log/nginx
```

Tip: switch to daily log rotation with `LOG_STACK=daily` in `.env` to avoid
one ever-growing `laravel.log` file.

### Q: How does the dockerized MySQL know what database/user to create?

From your `.env`, forwarded by Compose into the `mysql-local` container:

| `.env` variable | Becomes | Dev default if unset |
|---|---|---|
| `DB_DATABASE` | `MYSQL_DATABASE` | `scart` |
| `DB_USERNAME` | `MYSQL_USER` | `scart` |
| `DB_PASSWORD` | `MYSQL_PASSWORD` | `secret` |
| `DB_ROOT_PASSWORD` | `MYSQL_ROOT_PASSWORD` | `root_secret` |

(Prod has no defaults — you must set all four.) Since Laravel reads its own
`DB_*` variables from that same `.env`, they always match automatically.
Just remember `DB_HOST=mysql-local` (the Compose service name, not a real
hostname) when using the built-in database.

**Important:** MySQL only runs this creation step **once**, the first time
it starts with an empty data volume. If you change `DB_DATABASE`/user/
password in `.env` *after* it has already started once, nothing changes
inside the container — the old volume still has the old values.

To check what's actually inside the running container:

```bash
docker compose exec mysql-local mysql -u root -p"$DB_ROOT_PASSWORD" -e "SHOW DATABASES;"
```

If it doesn't match your `.env`, either add what's missing without
touching existing data:

```bash
docker compose exec mysql-local mysql -u root -p"$DB_ROOT_PASSWORD" -e \
  "CREATE DATABASE IF NOT EXISTS your_db; \
   CREATE USER IF NOT EXISTS 'your_user'@'%' IDENTIFIED BY 'your_pass'; \
   GRANT ALL ON your_db.* TO 'your_user'@'%';"
```

or reset entirely (⚠️ deletes all data in that volume):

```bash
docker compose down
docker volume rm scart-mysql-local-data-dev   # or scart-mysql-local-data-prod
docker compose up -d
```

### Q: I accidentally ran `docker compose up -d --build` on prod (forgot `-f docker-compose.prod.yml`) — what happens now?

**Since modification `20260709T090000` (RISK-OPS-006 / NFR-SEC-005 / ADR
`installer-deploy_docker-dev-prod-safeguards`), this is no longer able to
silently overwrite your running prod containers or image.** Dev
(`docker-compose.yml`) and prod (`docker-compose.prod.yml`) now use
distinct project names (`scart` vs `scart-prod`), distinct image tags
(`scart-app:${PHP_VERSION}` vs `scart-app:${PHP_VERSION}-prod`), and
distinct container names (prod's all end in `-prod`). Docker's container
name uniqueness constraint can no longer be tripped across environments.

What actually happens if you run the plain dev command on a host that's
already running the prod stack:

- A **separate, independently-named dev stack** (`scart-app`,
  `scart-nginx`, ... — no `-prod` suffix) starts up alongside the untouched
  prod stack (`scart-app-prod`, `scart-nginx-prod`, ...). Nothing about the
  running prod containers or the prod image tag changes.
- You may hit a **port conflict** instead (e.g. if `APP_PORT`/`DB_PORT`/
  `VITE_PORT` resolve to the same host ports on both stacks) — Docker will
  refuse to start the colliding dev service and tell you so loudly, rather
  than silently replacing anything.
- The dockerized MySQL volumes are also fully separate
  (`scart-mysql-local-data-dev` vs `scart-mysql-local-data-prod`, both
  pinned by explicit `name:` in their respective compose files), so there's
  no risk of the prod app pointing at an empty dev volume either.

**Fix — just stop the stray dev stack** (nothing needs rebuilding on the
prod side, it was never touched):

```bash
docker compose -f docker-compose.yml down
```

If you want to double check nothing prod-side was affected:

```bash
docker compose -f docker-compose.prod.yml ps   # prod containers, still -prod, still running
docker images | grep scart-app                  # scart-app:<ver> (dev) and scart-app:<ver>-prod (prod) are separate images
```

### Q: What services make up this stack?

| Service | Role | Image |
|---------|------|-------|
| `app` | PHP-FPM running Laravel | built from `docker/php` |
| `webserver` | Nginx, serves `public/`, forwards `.php` to `app` | `nginx:1.27-alpine` |
| `queue` | `php artisan queue:work` (emails, background jobs) | shares the `app` image |
| `scheduler` | Loop calling `php artisan schedule:run` every 60s | shares the `app` image |
| `mysql-local` | MySQL 8.4 (optional) | `mysql:8.4` |
| `node` | Builds/watches assets (Vite) — run on demand | `node:22-alpine` |

Only `app` is ever custom-built; nginx/mysql/node use official images with
config files mounted in.
