> 🌐 **言語:** [🇻🇳 Tiếng Việt](./README_vi.md) · [🇬🇧 English](./README.md) · 🇯🇵 日本語（現在）

<div align="center">

# 🛒 S-Cart

```bash
composer create-project gp247/s-cart my-shop "^3.0"
```

**無料のオープンソース EC プラットフォーム — GP247 エコシステムと Laravel で構築**

[![Packagist Downloads](https://poser.pugx.org/gp247/s-cart/d/total)](https://packagist.org/packages/gp247/s-cart) [![Latest Stable Version](https://poser.pugx.org/gp247/s-cart/v/stable.svg)](https://github.com/gp247net/s-cart/releases) [![License](https://poser.pugx.org/gp247/s-cart/license)](./LICENSE) [![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/gp247net/s-cart)

[🏠 ホーム](https://gp247.net) · [🚀 デモ](https://demo.s-cart.org) · [📚 ドキュメント](https://gp247.net/en/docs) · [🤖 AI エージェント用スキル](https://github.com/gp247net/gp247-skills) · [💬 Facebook グループ](https://www.facebook.com/groups/scart.opensource)

<img src="https://static.gp247.net/page/sc-1.jpg" alt="S-Cart ストアフロント" width="49%"> <img src="https://static.gp247.net/page/sc-2.jpg" alt="S-Cart 管理画面" width="49%">

</div>

## 概要

S-Cart は、企業、個人事業主、開発者、学生のための**無料・オープンソース**のネットショップ構築ソフトウェアです。商品、カート、注文、顧客、ニュースを備えた完成済みのオンラインストアと管理画面がすぐに使え、プラグインやテンプレートで機能を拡張できます。このページを読み終えると、S-Cart を手元のパソコンやサーバーにインストールし、アップデートやカスタマイズの方法がわかるようになります。

**S-Cart 3.x の技術スタック：** PHP ≥ 8.3 · [Laravel 13](https://github.com/laravel/laravel) · [GP247](https://github.com/gp247net) · Tailwind CSS 4 · MySQL / MariaDB

## ✨ S-Cart の機能

| 分類 | 機能 |
|---|---|
| 🛍️ **販売** | 商品、カート、注文、顧客 |
| 🌏 **多国対応** | 多言語、多通貨 |
| 📰 **コンテンツ（CMS）** | カテゴリー、ニュース、コンテンツページ |
| 💳 **決済と配送** | 決済プラグイン、配送方法、クーポンコード、税計算 |
| 🔐 **管理とセキュリティ** | ロールによる権限管理（管理者、マネージャー、マーケティング…）、操作ログ、CAPTCHA |
| 📊 **ビジネスツール** | 注文処理、顧客管理、統計とレポート |
| 🤖 **AI 対応（MCP サーバー）** | 無料の **MCP Server** プラグイン：AI エージェント（Claude、Cursor、VS Code…）を [Model Context Protocol](https://modelcontextprotocol.io) 標準でストアに接続し、自然な言葉で質問できます —「*今週の売上はいくら？*」「*在庫切れが近い商品は？*」「*注文 OR-1024 は支払い済み？*」。エージェントは 1 つの管理者アカウントの代理として、そのアカウントと同じ権限で動作し、トークンで認証され、顧客情報はマスクされ、すべての呼び出しがログに記録されます |
| 🧩 **拡張性** | HMVC モデルのプラグイン、オンラインのプラグイン／テンプレートマーケットプレイス、モバイルアプリ向けのセキュアな API |
| ⭐ **Pro プラグイン** | [Multi-vendor](https://gp247.net/en/product/multi-vendor-pro.html)（複数の販売者が出店するマーケットプレイス）· [Multi-store](https://gp247.net/en/product/multi-store-pro.html)（複数ストア）· [入出金管理](https://gp247.net/en/product/plugin-inout-purchase-return.html)（仕入れ、返品、入出金と債権債務） |

## 🧰 システム要件

| 項目 | 要件 |
|---|---|
| PHP | **8.3 以上** |
| Composer | 2.x 系 |
| データベース | MySQL または MariaDB — 空のデータベースを事前に作成してください |
| 書き込み権限が必要なディレクトリ | `storage` · `bootstrap/cache` · `app/GP247` · `public/GP247` · `public/vendor` · `resources/views/vendor` · `vendor` |

> 💡 Docker を使う場合、パソコンに PHP、Composer、MySQL をインストールする**必要はありません** — [方法 3](#方法-3--docker) をご覧ください。

## 🚀 インストール

次の 3 つの方法から**いずれか 1 つ**を選んでください：

| 方法 | 適しているケース |
|---|---|
| [**1. Composer**](#方法-1--composer推奨) ⭐ | レンタルサーバー、VPS、または Laragon／XAMPP を使っているパソコンにインストールする場合 — **推奨** |
| [**2. Git clone**](#方法-2--git-clone) | 開発やコントリビュートのために GitHub から最新のソースコードを取得したい場合 |
| [**3. Docker**](#方法-3--docker) | パソコンに PHP／MySQL をインストールしたくない場合 |

## 方法 1 — Composer（推奨）

1. **ターミナル**（Windows では「コマンドプロンプト」または Laragon のターミナル）を開き、Composer がどの PHP で動いているかを確認します：

   ```bash
   composer diagnose
   ```

   `PHP version` の行が **8.3 以上**である必要があります。

   > ⚠️ PHP が古い場合、Composer は**エラーを出さず**、非常に古い S-Cart 1.x を黙ってインストールしてしまいます。誤ったバージョンがインストールされる代わりに Composer がはっきりエラーを出すよう、手順 2 のコマンドでは必ず `"^3.0"` を付けたままにしてください。

2. プロジェクトを作成します（`my-shop` は任意のディレクトリ名に置き換えてください）：

   ```bash
   composer create-project gp247/s-cart my-shop "^3.0"
   cd my-shop
   ```

3. プロジェクトディレクトリ内の `.env` ファイルを開き、作成したデータベースに合わせてデータベースの項目を編集します：

   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

   > デフォルト値の `DB_HOST=mysql-local` は Docker 専用です — 直接インストールする場合は `127.0.0.1` に変更してください。

4. S-Cart を初期化します：

   ```bash
   php artisan gp247:install
   ```

   確認を求められたら `yes` と入力します。完了すると、管理画面の URL とログイン用アカウントが表示されます。

5. *（任意）* 試しに見てみるためのサンプルデータを追加します：

   ```bash
   php artisan gp247:shop-sample
   ```

6. ブラウザを開きます：

   | ページ | アドレス | ログイン |
   |---|---|---|
   | ストア | `http://your-domain` | — |
   | 管理画面 | `http://your-domain/gp247_admin` | `admin` / `admin` |

   > 🔑 **初回ログイン後、すぐに `admin` のパスワードを変更してください。**

## 方法 2 — Git clone

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
composer install
```

その後、**[方法 1](#方法-1--composer推奨) の手順 3 → 6** を続けて行います（`.env` の編集、`gp247:install` の実行、ブラウザで開く）。

## 方法 3 — Docker

**別々の** 2 つの設定ファイルがあります — 必ず環境に合ったファイルを使ってください：

| ファイル | 環境 |
|---|---|
| `docker-compose.yml` | **dev** — 個人のパソコン |
| `docker-compose.prod.yml` | **prod** — 本番サーバー |

**個人のパソコン（dev）：**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan gp247:install
docker compose exec app php artisan gp247:shop-sample   # 任意
```

<http://localhost:8000> でサイトを開きます。

**本番サーバー（prod）：**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# .env を編集：APP_ENV=production, APP_DEBUG=false, DB_*, SC_DOCKER_WWWUSER/SC_DOCKER_WWWGROUP — DOCKER.md を参照
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan gp247:install
docker compose -f docker-compose.prod.yml run --rm node   # build CSS/JS
```

> ⚠️ 本番環境では**必ず** `-f docker-compose.prod.yml` を付けてください。付け忘れると dev 用の設定で動いてしまいます（デバッグ有効、root 権限で実行、Xdebug がインストールされる…）。

📘 手順ごとのガイドと Docker のトラブルシューティング：[DOCKER.md](./DOCKER.md)。

## 🔄 バージョンアップデート

1. アップデートの前に、データベースと `app/GP247`、`public/GP247` ディレクトリを**バックアップ**してください。
2. 新しいソースコードを取得します：

   ```bash
   composer update gp247/core gp247/front gp247/shop
   ```

3. 変更をサイトに反映します（安全です：データは削除されず、編集済みの翻訳やテンプレートも上書きされません）：

   ```bash
   php artisan gp247:update
   ```

4. 結果を確認します：

   ```bash
   php artisan gp247:info
   ```

> ⚠️ `composer update` を実行するだけでは**不十分です** — 必ず手順 3 も実行してください。

高度なオプション（`--overwrite-lang` による翻訳の上書き、`--publish=…` によるアセット／ビューの更新）は、**あなたのカスタマイズを上書きする**可能性があります — 使用する前に [GP247 アップデートガイド](https://gp247.net/en/docs/system/how-to-update-gp247.html) をよくお読みください。

## 🎨 カスタマイズと拡張

| やりたいこと | 方法 |
|---|---|
| 新しいプラグインを作成する | `php artisan gp247:make-plugin --name=PluginName` |
| 新しいテンプレートを作成する | `php artisan gp247:make-template --name=TemplateName` |
| 配布用の zip ファイルにパッケージ化する | 上記 2 つのコマンドに `--download=1` を追加 |
| デフォルトテンプレートの画面を **1 つだけ** 編集する | `php artisan gp247:template-publish GP247Front --file=screen/home.blade.php` を実行し、`app/GP247/Templates/GP247Front/` のファイルを編集 |
| 管理画面の UI を編集する | `php artisan vendor:publish --tag=gp247:core-view`（core）· `--tag=gp247:front-admin`（front）· `--tag=gp247:shop-view-admin`（shop） |
| ファイルアップロード設定（lfm）を変更する | `php artisan vendor:publish --tag=config-lfm` |
| ヘルパー関数 `gp247_*` をオーバーライドする | `config/gp247_functions_except.php` に関数名を宣言し、`app/GP247/Helpers/*.php` に新しい関数を記述 |
| コントローラーをオーバーライドする | [下記](#コントローラーのオーバーライド) を参照 |
| 管理画面にルートを追加する | 定数 `GP247_ADMIN_PREFIX` と `GP247_ADMIN_MIDDLEWARE` を使用 — [core の routes.php](https://github.com/gp247net/core/blob/master/src/routes.php) を参照 |

> 💡 デフォルトテンプレート `GP247Front` は**パッケージから直接**読み込まれるため、publish していないファイルはアップデート時に自動で新しいバージョンになります。編集が必要なファイルだけを publish してください。

## コントローラーのオーバーライド

`GP247/Core`、`GP247/Front`、`GP247/Shop` のすべてのコントローラー（API を含む）に適用できます：

1. `app/GP247/{Core|Front|Shop}/...` に、同じサブパスと同じ名前のファイルを作成します。
2. 新しいクラスを、`vendor/gp247/...` にある元のコントローラーから `extends` させます。
3. 元の名前空間の先頭に `App\` を追加し、残りはそのままにします：

   | 元の名前空間 | 新しい名前空間 |
   |---|---|
   | `GP247\Core\Controllers` | `App\GP247\Core\Controllers` |
   | `GP247\Core\Api\Controllers` | `App\GP247\Core\Api\Controllers` |
   | `GP247\Front\...` / `GP247\Shop\...` | `App\GP247\Front\...` / `App\GP247\Shop\...` |

📘 詳細ドキュメント：[プラグインの作成](https://gp247.net/en/docs/user-guide-extension/create-new-plugin.html) · [テンプレートの作成](https://gp247.net/en/docs/user-guide-extension/create-new-template.html) · [CLI コマンド一覧](https://gp247.net/en/docs/system/gp247-system-command-line.html)

## 📂 ディレクトリ構成

`(+)` = GP247 が作成・管理するディレクトリ。

```text
my-shop/
├── app/GP247/
│   ├── Core(+)        ← Core のコントローラーのオーバーライド
│   ├── Front(+)       ← Front のコントローラーのオーバーライド
│   ├── Shop(+)        ← Shop のコントローラーのオーバーライド
│   ├── Helpers(+)     ← ここにある *.php ファイルは自動で読み込まれる
│   ├── Plugins(+)     ← プラグイン（gp247:make-plugin）
│   └── Templates(+)   ← テンプレート（gp247:make-template）+ 編集用に publish したテンプレートファイル
├── public/GP247/
│   ├── Core(+)        ← 管理画面の CSS/JS
│   ├── Plugins(+)
│   └── Templates(+)
├── resources/views/vendor/
│   ├── gp247-admin(+)        ← publish 済みの Core 管理画面ビュー
│   ├── gp247-front-admin(+)  ← publish 済みの Front 管理画面ビュー
│   └── gp247-shop-admin(+)   ← publish 済みの Shop 管理画面ビュー
└── vendor/gp247/
    ├── core           ← コア：管理画面、権限管理、設定
    ├── front          ← ストアフロント、CMS
    └── shop           ← 商品、カート、注文
```

## 🔧 よく使う環境変数

`.env` ファイルで設定します：

| 変数 | デフォルト | 意味 |
|---|---|---|
| `GP247_ADMIN_PREFIX` | `gp247_admin` | 管理画面のパス。例：`your-domain.com/gp247_admin` |
| `GP247_API_MODE` | `1` | API を有効（`1`）／無効（`0`）にする |
| `GP247_DB_PREFIX` | `gp247_` | テーブル名のプレフィックス — ⚠️ **インストール後は変更できません** |
| `GP247_ADMIN_LOG` | `1` | 管理画面へのアクセスログを記録する |
| `GP247_SEO_LANG` | `0` | ストアの URL に言語コードを付ける（`/vi/...`、`/en/...`） |
| `GP247_ENCRYPTION_KEY` | *（空）* | SMTP パスワードやライセンスなどを暗号化するための専用キー — `.env.example` の注記を参照 |

## ❓ よくある質問（Q&A）

**Q1：Composer でインストールが終わった後に `Access denied for user 'root'` と表示されました。どういうことですか？**

→ Composer が 8.3 より古い PHP で動いていたため、誤って S-Cart 1.x がインストールされています。作成したディレクトリを削除し、Composer を PHP 8.3 以上に切り替えて（`composer diagnose` で確認）、`"^3.0"` を付けて再インストールしてください。

**Q2：管理画面はどこにあり、何でログインしますか？**

→ `http://your-domain/gp247_admin`、ユーザー `admin`／パスワード `admin` です。すぐにパスワードを変更してください。

**Q3：使っているバージョンを確認するにはどうすればよいですか？**

→ `php artisan gp247:info` を実行してください。

**Q4：サイトでエラーが出る、またはインストールできない場合、まず何を確認すればよいですか？**

→ `php artisan gp247:doctor` を実行してください。環境（PHP、ディレクトリの書き込み権限、設定…）をチェックし、修正すべき箇所を示してくれます。[システム要件](#-システム要件) に記載したディレクトリの書き込み権限も忘れずに確認してください。

**Q5：バージョンアップデートでデータや自分で編集した部分が失われることはありますか？**

→ `php artisan gp247:update` はデータを削除せず、編集済みの翻訳やテンプレートもそのまま保持します。上書きする可能性があるのは `--overwrite-lang` と `--publish=…` オプションだけです — 使用する前にバックアップを取ってください。

**Q6：デフォルトテンプレートを編集しましたが、アップデートで消えてしまいますか？**

→ `gp247:template-publish GP247Front --file=...` で編集が必要なファイルだけを publish していれば、消えません。編集したファイルはそのまま保持され、残りのファイルはパッケージから自動で新しいバージョンになります。

**Q7：管理画面のパスを変更するにはどうすればよいですか？**

→ `.env` の `GP247_ADMIN_PREFIX` を変更します（例：`backoffice`）。`public/` に既にあるディレクトリ名（`vendor`、`GP247` など）と同じ名前にしないでください。同じにすると、ページが 403 エラーになります。

**Q8：インストール後にテーブル名のプレフィックス（`GP247_DB_PREFIX`）を変更できますか？**

→ できません。このプレフィックスは `gp247:install` を実行する前に決めておく必要があります。

**Q9：モバイルアプリを使っていませんが、API は無効にしたほうがよいですか？**

→ 無効にしてもかまいません。`.env` で `GP247_API_MODE=0` を設定してください。

**Q10：ほかに質問がある場合はどこで聞けばよいですか？**

→ [GP247 ドキュメント](https://gp247.net/en/docs) を読むか、[DeepWiki](https://deepwiki.com/gp247net/s-cart) に質問するか、[S-Cart の Facebook グループ](https://www.facebook.com/groups/scart.opensource) に質問を投稿してください。

---

<sub>📅 **最終更新:** 2026-10-22 · ✍️ **作成者 (Author):** GP247</sub>
