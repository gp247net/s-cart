```
  _____  _____     ___  _  _   _____ 
 / ____|  __ \   |__ \| || | |___  |
| |  __| |__) |     ) | || |_   / / 
| | |_ |  ___/     / /|__   _| / /  
| |__| | |        / /_   | |  / /   
 \_____|_|       |____|  |_| /_/    
```

> 🌐 **Language:** 🇬🇧 English (current) · [🇻🇳 Tiếng Việt](README_vi.md)

# S-Cart

**The free, open-source e-commerce platform for everyone** — businesses, individuals, developers, and students. Built on the GP247 ecosystem (Laravel) with a clean, AI-agent-friendly structure.

```bash
composer create-project gp247/s-cart
```

[🏠 Homepage](https://gp247.net) · [🚀 Live demo](https://demo.s-cart.org) · [📚 Documentation](https://github.com/gp247net/gp247-docs) · [🤖 Agent skills](https://github.com/gp247net/gp247-skills) · [💬 Facebook group](https://www.facebook.com/groups/scart.opensource)

[![Packagist Downloads](https://poser.pugx.org/gp247/s-cart/d/total)](https://packagist.org/packages/gp247/s-cart)
[![Latest Stable Version](https://poser.pugx.org/gp247/s-cart/v/stable.svg)](https://github.com/gp247net/s-cart/releases)
[![License](https://poser.pugx.org/gp247/s-cart/license)](https://github.com/gp247net/s-cart/blob/master/LICENSE)
[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/gp247net/s-cart)

---

## 📖 Table of contents

- [Overview](#-overview)
- [Screenshots](#-screenshots)
- [Features](#-features)
- [Quick start](#-quick-start)
  - [Method 1 — Composer (recommended)](#method-1--composer-recommended)
  - [Method 2 — Git clone](#method-2--git-clone)
  - [Method 3 — Docker](#method-3--docker)
  - [Folder permissions](#-folder-permissions)
- [Project structure](#-project-structure)
- [FAQ](#-faq)

---

## 🎯 Overview

S-Cart is the best free e-commerce website project for individuals and
businesses, built on the GP247 ecosystem (the Laravel Framework) and the
latest technologies.

Our mission is **"Effective and friendly for everyone"**:

| Principle | What it means |
|---|---|
| **Effective** | Meets even the smallest customer requirements. |
| **Friendly** | Easy to use, easy to maintain, easy to extend. |
| **Everyone** | Businesses, individuals, developers, students. |
| **AI-agent-friendly** | Clear structure and standardized docs/skills so AI agents can understand the project and assist development. |

**S-Cart 3.x tech stack**

| Layer | Technology |
|---|---|
| Ecosystem | [GP247](https://github.com/gp247net) |
| Framework | [Laravel 13.x](https://github.com/laravel/laravel) |
| UI | Tailwind CSS 4 |

---

## 🖼️ Screenshots

![S-Cart screenshot 1](https://static.gp247.net/page/sc-1.jpg)

![S-Cart screenshot 2](https://static.gp247.net/page/sc-2.jpg)

---

## ✨ Features

### 🧩 Platform & developer experience

- Plugin packages built on the **HMVC** pattern
- Command-line **upgrades and patches** for S-Cart
- Full documentation for developers and customers
- Online **marketplace** for plugins and templates
- **Secured API** for apps and mobile integrations

### 🛒 Storefront

| Area | Capabilities |
|---|---|
| **Commerce** | Shopping cart, orders, products, customers |
| **Localization** | Multi-language, multi-currency |
| **Content (CMS)** | Categories, news, content pages |
| **Extensions** | Payment plugins, shipping methods, discount system, tax calculation |
| **Pro plugins** | [Multi-vendor](https://gp247.net/en/docs/s-cart/multi-vendor.html), [Multi-store](https://gp247.net/en/docs/s-cart/multi-store.html) |

### 🛠️ Administration

| Area | Capabilities |
|---|---|
| **Access & security** | Role-based permissions (admin, manager, marketing…), full audit logging, access control, authentication, CAPTCHA |
| **Business tools** | Product management, order processing, customer management, analytics & reporting, activity tracking |

---

## 🚀 Quick start

> **In a hurry?** Go with **Method 1 (Composer)** — one command, no local
> server setup required beyond PHP + MySQL.

### Method 1 — Composer (recommended)

```bash
# 1. Create the project
composer create-project gp247/s-cart

# 2. Check .env (DB settings). Generate the app key if missing:
php artisan key:generate

# 3. Install S-Cart
php artisan gp247:install

# 4. (Optional) Install sample data
php artisan gp247:shop-sample
```

### Method 2 — Git clone

```bash
# 1. Clone
git clone https://github.com/gp247net/s-cart.git
cd s-cart

# 2. Set up env & dependencies
cp .env.example .env
php artisan key:generate
composer install
```

Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then install:

```bash
php artisan gp247:install
php artisan gp247:shop-sample   # optional, sample data
```

### Method 3 — Docker

*Supported from S-Cart 2.* No need to install PHP/Composer/MySQL on your
machine — Docker is all you need. There are **two clearly separate** compose
files; always use the right one for the environment:

| File | Environment |
|---|---|
| `docker-compose.yml` | **dev** (your local machine) |
| `docker-compose.prod.yml` | **prod** (your server) |

**DEV setup**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan gp247:install --force=1
docker compose exec app php artisan gp247:shop-sample   # optional
```

Open the site: <http://localhost:8000>

**PROD setup**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# Configure .env for prod: APP_ENV, DB_*, SC_DOCKER_WWWUSER/SC_DOCKER_WWWGROUP — see DOCKER.md
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan gp247:install --force=1
docker compose -f docker-compose.prod.yml exec app php artisan gp247:shop-sample   # optional
docker compose -f docker-compose.prod.yml run --rm node                    # build CSS/JS assets
```

> ⚠️ Always include `-f docker-compose.prod.yml` on prod — forgetting it
> accidentally applies the dev config (debug mode on, runs as root, installs
> Xdebug…). See the Q&A in [DOCKER.md](DOCKER.md) for that failure mode in
> detail.

For the full step-by-step guide and a detailed troubleshooting Q&A covering
both dev and prod, see [DOCKER.md](DOCKER.md).

### 🔐 Folder permissions

If you installed with **Method 1 or 2** (no Docker), make sure the following
folders are writable — otherwise installation and various features won't work
correctly:

`app/GP247` · `public/GP247` · `public/vendor` · `resources/views/vendor` · `storage` · `vendor`

---

## 📂 Project structure

Folder layout for a GP247-based website (`(+)` = created/managed by GP247):

```text
Website-folder/
│
├── app
│     └── GP247
│           ├── Core(+)       // Override Core controllers
│           ├── Helpers(+)    // Auto-loads Helpers/*.php into the system
│           ├── Front(+)      // Override GP247/Front controllers
│           ├── Shop(+)       // Override GP247/Shop controllers
│           ├── Plugins(+)    // php artisan gp247:make-plugin --name=NameOfPlugin
│           └── Templates(+)  // php artisan gp247:make-template --name=NameOfTemplate
├── public
│     └── GP247
│           ├── Core(+)
│           ├── Plugins(+)
│           └── Templates(+)
├── resources
│     └── views/vendor
│           ├── gp247-admin(+)        // Core view overrides
│           ├── gp247-shop-admin(+)   // Shop view overrides
│           └── gp247-front-admin(+)  // Front view overrides
├── vendor
│     ├── gp247/core
│     ├── gp247/front
│     └── gp247/shop
└── ...
```

---

## ❓ FAQ

> 📖 **Full command-line reference.** The commands below cover the common cases.
> For every GP247 artisan command, its options and examples, see the official
> reference: [English](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference.md)
> · [Tiếng Việt](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference_vi.md).

### How do I check the installed S-Cart version?

```bash
php artisan gp247:info
```

### How do I update S-Cart?

Update each package with Composer:

```bash
composer update gp247/core
composer update gp247/front
composer update gp247/shop
```

Then run the safe, non-destructive refresh (updates core, updates the shop
schema when the shop module is installed, and rebuilds the caches):

```bash
php artisan gp247:update
```

**Optional — refresh language files.** By default `gp247:update` leaves your
translations untouched. Add `--overwrite-lang` to also run
`gp247:language-update`, which pulls the latest translations and **overwrites
any language strings you edited**:

```bash
php artisan gp247:update --overwrite-lang
```

**Optional — refresh published assets/views to the latest version.**
`composer update` and `gp247:update` only refresh the code under `vendor/`; the
files already copied to `public/GP247` and `app/GP247` are **not** overwritten
automatically. If a new release ships updated compiled CSS/JS or default
template/views and you want them on your site, re-publish with `--force`:

```bash
php artisan vendor:publish --tag=gp247:core-public --force    # -> public/GP247 (admin build: CSS/JS, ...)
php artisan vendor:publish --tag=gp247:front-public --force   # -> public/GP247/Templates/GP247Front (storefront CSS/JS)
php artisan vendor:publish --tag=gp247:front-view --force     # -> app/GP247/Templates/GP247Front (default template views)
```

> ⚠️ `--force` **overwrites** the destination files — including any local
> customizations you made there (custom logo/images, edited template Blade
> files, etc.). **Back up `public/GP247` and `app/GP247` first**, and publish
> only the tag you actually need.

You can also fold the re-publish into the refresh itself with the **opt-in**
`--publish=<tokens>` option (default publishes nothing). Only `core-public` is
safe (compiled admin assets); the view/template tokens overwrite your
customizations, so back up first:

```bash
php artisan gp247:update --publish=core-public          # safe: refresh admin CSS/JS
php artisan gp247:update --publish=core-public,front-view # also overwrite storefront templates (DESTRUCTIVE)
```

There is no `--force` flag on `gp247:update` — typing a destructive token is
the consent, and an interactive run still warns and asks to confirm. See the
[CLI reference](gp247-docs/system/command-line-reference.md) for the full
token → destination → impact table.

### How do I create a new plugin?

```bash
php artisan gp247:make-plugin --name=PluginName
```

Also generate a zip file for distribution:

```bash
php artisan gp247:make-plugin --name=PluginName --download=1
```

### How do I create a new template?

```bash
php artisan gp247:make-template --name=TemplateName
```

Also generate a zip file for distribution:

```bash
php artisan gp247:make-template --name=TemplateName --download=1
```

### How do I customize the upload (lfm) configuration?

```bash
php artisan vendor:publish --tag=config-lfm
```

### How do I customize the admin UI?

Each package publishes its admin views into its own `views/vendor/<namespace>`
folder — publish only the tag you actually need to override:

```bash
php artisan vendor:publish --tag=gp247:core-view        # -> views/vendor/gp247-admin
php artisan vendor:publish --tag=gp247:front-admin      # -> views/vendor/gp247-front-admin
php artisan vendor:publish --tag=gp247:shop-view-admin  # -> views/vendor/gp247-shop-admin
```

Add `--force` if you need to overwrite files already published there.

### How do I customize the default template?

```bash
php artisan vendor:publish --tag=gp247:front-view       # -> app/GP247/Templates/GP247Front
php artisan vendor:publish --tag=gp247:front-public     # -> public/GP247/Templates/GP247Front
php artisan vendor:publish --tag=gp247:shop-view-front  # -> app/GP247/Templates/GP247Front
```

Add `--force` if you need to overwrite files already published there.

### How do I override the `gp247_*` helper functions?

1. Add the list of functions you want to override to `config/gp247_functions_except.php`
2. Create new PHP files containing the new functions in `app/GP247/Helpers`, e.g. `app/GP247/Helpers/myfunction.php`

### How do I override controllers in GP247/Core, GP247/Front, or GP247/Shop?

S-Cart lets you override **any** controller (including API controllers) in
`GP247/Core`, `GP247/Front`, and `GP247/Shop` using the same mechanism:
create the corresponding controller in `app/GP247/{Core|Front|Shop}`,
**extend the original controller**, and prepend `App` to the original
namespace.

Example, overriding a Core controller:

1. Create the matching file under `app/GP247/Core/Controllers/...` (keep the
   same sub-path and filename as in the original package).
2. Make the new controller `extend` the original controller from
   `vendor/gp247/core/...`.
3. Change the namespace from `GP247\Core\Controllers` to
   `App\GP247\Core\Controllers` (just prepend `App`, keep the rest as-is).

The same pattern applies to `GP247\Front\*` and `GP247\Shop\*` (becoming
`App\GP247\Front\*` and `App\GP247\Shop\*`) and to API controllers
(`GP247\Core\Api\Controllers` becomes `App\GP247\Core\Api\Controllers`).

### How do I add new routes for the admin area?

Use the `GP247_ADMIN_PREFIX` and `GP247_ADMIN_MIDDLEWARE` prefix/middleware
constants in your route declarations.

Reference: <https://github.com/gp247net/core/blob/master/src/routes.php>

### What environment variables in `.env` should I know about?

**Disable the API:**
```env
GP247_API_MODE=1   // set to 0 to disable
```

**Database table prefix** (cannot be changed after gp247 is installed):
```env
GP247_DB_PREFIX=gp247_
```

**Admin page path prefix:**
```env
GP247_ADMIN_PREFIX=gp247_admin
```

---

Made with the ❤️ GP247 ecosystem — [gp247.net](https://gp247.net)
