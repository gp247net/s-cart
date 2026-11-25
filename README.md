> 🌐 **Language:** [🇻🇳 Tiếng Việt](./README_vi.md) · 🇬🇧 English (current) · [🇯🇵 日本語](./README_ja.md)

<div align="center">

<img src="https://raw.githubusercontent.com/gp247net/s-cart/master/public/s-cart/logo.png" alt="S-Cart" width="280">

`composer create-project gp247/s-cart my-shop`

**Free, open-source e-commerce software built on GP247 and Laravel**

[![Tests](https://github.com/gp247net/s-cart/actions/workflows/product.yml/badge.svg?branch=master)](https://github.com/gp247net/s-cart/actions/workflows/product.yml) [![Packagist Downloads](https://poser.pugx.org/gp247/s-cart/d/total)](https://packagist.org/packages/gp247/s-cart) [![Latest Stable Version](https://poser.pugx.org/gp247/s-cart/v/stable.svg)](https://github.com/gp247net/s-cart/releases) [![License](https://poser.pugx.org/gp247/s-cart/license)](./LICENSE) [![Ask DeepWiki](https://img.shields.io/badge/Ask-DeepWiki-blue)](https://deepwiki.com/gp247net/s-cart)

[🏠 Homepage](https://gp247.net) · [🚀 Demo](https://demo.s-cart.org) · [📚 Documentation](https://gp247.net/en/docs) · [🤖 AI agent skills](https://github.com/gp247net/gp247-skills) · [💬 Facebook group](https://www.facebook.com/groups/scart.opensource)

<img src="https://static.gp247.net/page/sc-1.jpg" alt="S-Cart storefront" width="49%"> <img src="https://static.gp247.net/page/sc-2.jpg" alt="S-Cart admin dashboard" width="49%">

</div>

## Introduction

S-Cart is **free, open-source** online-store software (MIT license) for store owners, businesses and developers. Once installed, you have a complete online shop (products, cart, orders, customers, content pages) plus an admin panel. All of S-Cart is free to use, modify and integrate into your own system; Pro plugins are optional add-ons for when a shop needs to grow, such as several stores or a marketplace with many sellers.

> ℹ️ The old S-Cart 10.x (`s-cart/s-cart`) continues as S-Cart (`gp247/s-cart`), renumbered from 1.0 and now on the 3.x line.

S-Cart is built on four principles:

| Principle | What you get |
|---|---|
| 🎯 **Solves the seller's real work** | SEO, backup & restore, role-based permissions and reports are built in from the first install, no plugin needed. Install and update with a few commands. |
| 🌍 **Runs in many environments** | From shared hosting without cron to VPS and Docker. |
| 🔐 **Secure** | One layer of permissions and activity logs shared by the admin panel, the API and AI agents; passwords and third-party keys are stored encrypted. |
| 🧩 **Easy to customize** | Extend with plugins and templates, and override screens or logic without touching the original code — updates keep your changes. |

After reading this page you will be able to install S-Cart on your machine or server, and know how to update and customize it.

**S-Cart 3.x tech stack:** PHP ≥ 8.3 · [Laravel 13](https://github.com/laravel/laravel) · Tailwind CSS 3 · MySQL / MariaDB

### What S-Cart is made of

**S-Cart = `gp247/core` + `gp247/front` + `gp247/shop` + `gp247/mcp`**

S-Cart is made of four packages:

| Package | Provides |
|---|---|
| [`gp247/core`](https://github.com/gp247net/core) | Core: admin panel, permissions, configuration, plugins & templates |
| [`gp247/front`](https://github.com/gp247net/front) | Storefront, content (CMS) |
| [`gp247/shop`](https://github.com/gp247net/shop) | Products, cart, orders, customers |
| [`gp247/mcp`](https://github.com/gp247net/mcp) | MCP server for AI agents |

You only install **S-Cart** — all four packages come with it; there is nothing else to install.

## ✨ What's in S-Cart

| Area | Features |
|---|---|
| 🛍️ **Commerce** | Products, cart, orders, customers |
| 🌏 **International** | Multi-language, multi-currency |
| 📰 **Content (CMS)** | Categories, content pages; news (free News plugin) |
| 💳 **Payment & shipping** | Payment plugins, shipping methods, discount codes, tax calculation |
| 🔐 **Admin & security** | Role-based permissions (admin, manager, marketing…), activity log, CAPTCHA |
| 📊 **Business tools** | Order processing, customer management, analytics & reports |
| 🤖 **AI-ready (MCP server)** | Built-in **MCP server** (off until you turn it on): connect AI agents (Claude, Cursor, VS Code…) to your shop via the [Model Context Protocol](https://modelcontextprotocol.io) and just ask — *"how much did we sell this week?"*, *"which products are low on stock?"*, *"is order OR-1024 paid?"*. The agent acts as one admin account with the same permissions, token-secured, customer data masked, every call logged |
| 🧩 **Extensibility** | HMVC plugins, online plugin/template marketplace, secured API for mobile apps |
| ⭐ **Pro plugins** | [Multi-vendor](https://gp247.net/en/product/multi-vendor-pro.html) (marketplace with many sellers) · [Multi-store](https://gp247.net/en/product/multi-store-pro.html) (several stores) · [InOut](https://gp247.net/en/product/plugin-inout-purchase-return.html) (purchases, returns, cash flow & debts) |

## 🛡️ Security for businesses — ISO/IEC 27001 support

S-Cart comes with the controls a business needs to build an ISMS under ISO/IEC 27001 and to protect its customers' personal data:

- **Permissions & audit log** for the admin, the API and AI agents
- **Encryption** of passwords and secret keys; password policy, two-factor authentication
- **Personal data**: customers download and delete their own data; old data cleaned on a retention schedule
- **Encrypted backups**, partial restore
- **Configuration self-check** and **timely security fixes**

> ISO/IEC 27001 certifies organizations, not software — [security docs](https://gp247.net/en/docs/security/security-introduction.html).

## 🧰 Requirements

| Component | Requirement |
|---|---|
| PHP | **8.3 or newer** |
| Composer | Version 2.x |
| Database | MySQL or MariaDB — create an empty database first |
| Writable folders | `storage` · `bootstrap/cache` · `app/GP247` · `public/GP247` · `public/vendor` · `resources/views/vendor` · `vendor` |

> 💡 With Docker you **don't need** PHP, Composer or MySQL on your machine — see [Option 3](#option-3--docker).

## 🚀 Installation

> 📘 **Full installation guide** — choosing a package set (S-Cart, GP247 CMS, core only), hosting without a command line, adding front/shop to an existing site, troubleshooting: [Installing GP247 and S-Cart](https://gp247.net/en/docs/install-update/install.html).

Pick **one** of three options:

| Option | Best when |
|---|---|
| [**1. Composer**](#option-1--composer-recommended) ⭐ | Installing on hosting, a VPS, or a machine with Laragon/XAMPP — **recommended** |
| [**2. Git clone**](#option-2--git-clone) | You want the latest source from GitHub to develop or contribute |
| [**3. Docker**](#option-3--docker) | You don't want to install PHP/MySQL on your machine |

## Option 1 — Composer (recommended)

1. Open a **Terminal** (on Windows: "Command Prompt" or the Laragon terminal) and check which PHP Composer runs on:

   ```bash
   composer diagnose
   ```

   The `PHP version` line must be **8.3 or newer**.

   > ⚠️ On a PHP older than 8.3, Composer does **not** fail — it silently installs a very old S-Cart 1.x. Switch Composer to PHP 8.3 or newer before step 2.

2. Create the project (replace `my-shop` with the folder name you want):

   ```bash
   composer create-project gp247/s-cart my-shop
   cd my-shop
   ```

3. Open the `.env` file in the project folder and set the database section to match the database you created:

   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

   > The default `DB_HOST=mysql-local` is for Docker only — for a direct install change it to `127.0.0.1`.

4. Install S-Cart:

   ```bash
   php artisan gp247:install
   ```

   The command asks for confirmation — type `yes`. When the install finishes, the **last block** on the screen shows the admin
   path, the user name `admin` and a **random password**.

   > ⚠️ **The password is shown only once**, right after a successful install — it is not stored anywhere and never printed
   > again. Save it in a password manager **before** you close the Terminal.

5. *(Optional)* Add sample data to try it out:

   ```bash
   php artisan gp247:shop-sample
   ```

6. Open your browser:

   | Page | Address | Login |
   |---|---|---|
   | Storefront | `http://your-domain` | — |
   | Admin | `http://your-domain/gp247_admin` | `admin` / the password printed in step 4 |

   > 🔑 **After signing in, change the account email to a real one** (Setting account at the top) so Forgot password works.

## Option 2 — Git clone

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
composer install
```

Then continue with **steps 3 → 6 of [Option 1](#option-1--composer-recommended)** (edit `.env`, run `gp247:install`, open the browser).

## Option 3 — Docker

There are two **separate** compose files — always use the right one for the environment:

| File | Environment |
|---|---|
| `docker-compose.yml` | **dev** — your local machine |
| `docker-compose.prod.yml` | **prod** — a real server |

**Local machine (dev):**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan gp247:install
docker compose exec app php artisan gp247:shop-sample   # optional
```

Open the site at <http://localhost:8000>.

**Real server (prod):**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# Edit .env: APP_ENV=production, APP_DEBUG=false, DB_*, SC_DOCKER_WWWUSER/SC_DOCKER_WWWGROUP — see DOCKER.md
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan gp247:install
docker compose -f docker-compose.prod.yml run --rm node   # build CSS/JS
```

> ⚠️ On prod **always** add `-f docker-compose.prod.yml`. Forgetting it runs the dev config by mistake (debug on, running as root, Xdebug installed…).

📘 Step-by-step guide and Docker troubleshooting: [DOCKER.md](./DOCKER.md).

## 🔄 Updating

> 📘 **Full guide:** [Updating GP247 and S-Cart](https://gp247.net/en/docs/install-update/update.html) · site still on 2.x: [Upgrading to the 3.x line](https://gp247.net/en/docs/install-update/upgrade.html).

1. **Back up** the database and the `app/GP247`, `public/GP247` folders before updating.
2. Download the new code:

   ```bash
   composer update gp247/core gp247/front gp247/shop gp247/mcp
   ```

   Site installed before S-Cart 3.5 (no MCP server yet): run `composer require gp247/mcp -W` once.

3. Apply the changes to the site (safe: deletes no data, does not overwrite translations or templates you edited):

   ```bash
   php artisan gp247:update
   ```

4. Check the result:

   ```bash
   php artisan gp247:info
   ```

> ⚠️ Running `composer update` alone is **not enough** — always run step 3 too.

Advanced options (overwrite translations with `--overwrite-lang`, refresh assets/views with `--publish=…`) can **overwrite your customizations** — read the [Updating GP247 and S-Cart — Advanced options](https://gp247.net/en/docs/install-update/update.html) carefully before using them.

## 🎨 Customization & extension

| You want to… | How |
|---|---|
| Create a new plugin | `php artisan gp247:make-plugin --name=PluginName` |
| Create a new template | `php artisan gp247:make-template --name=TemplateName` |
| Package a zip for distribution | Add `--download=1` to either command above |
| Edit **one** screen of the default template | `php artisan gp247:template-publish GP247Front --file=screen/home.blade.php`, then edit the file in `app/GP247/Templates/GP247Front/` |
| Customize the admin UI | `php artisan vendor:publish --tag=gp247:core-view` (core) · `--tag=gp247:front-admin` (front) · `--tag=gp247:shop-view-admin` (shop) |
| Change the file-upload config (lfm) | `php artisan vendor:publish --tag=config-lfm` |
| Override a `gp247_*` helper | List the function names in `config/gp247_functions_except.php`, then write the new functions in `app/GP247/Helpers/*.php` |
| Override a controller | See [below](#override-a-controller) |
| Add routes to the admin area | Use the `GP247_ADMIN_PREFIX` and `GP247_ADMIN_MIDDLEWARE` constants — see the [core routes.php](https://github.com/gp247net/core/blob/master/src/routes.php) |

> 💡 The default `GP247Front` template is loaded **directly from the package**, so files you have not published pick up new versions automatically when you update. Publish only the files you need to edit.

## Override a controller

Works for every controller (API included) in `GP247/Core`, `GP247/Front`, `GP247/Shop`:

1. Create a file with the same sub-path and name under `app/GP247/{Core|Front|Shop}/...`.
2. Make the new class `extends` the original controller in `vendor/gp247/...`.
3. Prepend `App\` to the original namespace, keeping the rest as-is:

   | Original namespace | New namespace |
   |---|---|
   | `GP247\Core\Controllers` | `App\GP247\Core\Controllers` |
   | `GP247\Core\Api\Controllers` | `App\GP247\Core\Api\Controllers` |
   | `GP247\Front\...` / `GP247\Shop\...` | `App\GP247\Front\...` / `App\GP247\Shop\...` |

📘 Detailed docs: [Create a plugin](https://gp247.net/en/docs/user-guide-extension/create-new-plugin.html) · [Create a template](https://gp247.net/en/docs/user-guide-extension/create-new-template.html) · [Full CLI reference](https://gp247.net/en/docs/system/gp247-system-command-line.html)

## 📂 Folder structure

`(+)` = folder created and managed by S-Cart.

```text
my-shop/
├── app/GP247/
│   ├── Core(+)        ← Core controller overrides
│   ├── Front(+)       ← Front controller overrides
│   ├── Shop(+)        ← Shop controller overrides
│   ├── Helpers(+)     ← *.php files here are auto-loaded
│   ├── Plugins(+)     ← plugins (gp247:make-plugin)
│   └── Templates(+)   ← templates (gp247:make-template) + template files published for editing
├── public/GP247/
│   ├── Core(+)        ← admin CSS/JS
│   ├── Plugins(+)
│   └── Templates(+)
├── resources/views/vendor/
│   ├── gp247-admin(+)        ← published Core admin views
│   ├── gp247-front-admin(+)  ← published Front admin views
│   └── gp247-shop-admin(+)   ← published Shop admin views
└── vendor/gp247/
    ├── core           ← core: admin, permissions, configuration
    ├── front          ← storefront, CMS
    ├── shop           ← products, cart, orders
    └── mcp            ← MCP server for AI agents
```

## 🔧 Common environment variables

Set these in the `.env` file:

| Variable | Default | Meaning |
|---|---|---|
| `GP247_ADMIN_PREFIX` | `gp247_admin` | Admin path, e.g. `your-domain.com/gp247_admin` |
| `GP247_API_MODE` | `1` | Enable (`1`) / disable (`0`) the API |
| `GP247_DB_PREFIX` | `gp247_` | Table name prefix — ⚠️ **cannot be changed after install** |
| `GP247_ADMIN_LOG` | `1` | Log admin access |
| `GP247_SEO_LANG` | `0` | Add the language code to storefront URLs (`/en/...`, `/vi/...`) |
| `GP247_ENCRYPTION_KEY` | *(empty)* | Dedicated key for encrypting SMTP passwords, licenses… — see the notes in `.env.example` |
