> 🌐 **Ngôn ngữ:** 🇻🇳 Tiếng Việt (hiện tại) · [🇬🇧 English](./README.md)

<div align="center">

# 🛒 S-Cart

```bash
composer create-project gp247/s-cart my-shop "^3.0"
```

**Nền tảng thương mại điện tử mã nguồn mở, miễn phí — xây dựng trên hệ sinh thái GP247 & Laravel**

[![Packagist Downloads](https://poser.pugx.org/gp247/s-cart/d/total)](https://packagist.org/packages/gp247/s-cart) [![Latest Stable Version](https://poser.pugx.org/gp247/s-cart/v/stable.svg)](https://github.com/gp247net/s-cart/releases) [![License](https://poser.pugx.org/gp247/s-cart/license)](./LICENSE) [![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/gp247net/s-cart)

[🏠 Trang chủ](https://gp247.net) · [🚀 Demo](https://demo.s-cart.org) · [📚 Tài liệu](https://gp247.net/vi/docs) · [🤖 Skill cho AI agent](https://github.com/gp247net/gp247-skills) · [💬 Nhóm Facebook](https://www.facebook.com/groups/scart.opensource)

<img src="https://static.gp247.net/page/sc-1.jpg" alt="Giao diện cửa hàng S-Cart" width="49%"> <img src="https://static.gp247.net/page/sc-2.jpg" alt="Trang quản trị S-Cart" width="49%">

</div>

## Giới thiệu

S-Cart là phần mềm website bán hàng **miễn phí, mã nguồn mở**, dành cho doanh nghiệp, cá nhân kinh doanh, lập trình viên và sinh viên. Bạn có sẵn một cửa hàng trực tuyến hoàn chỉnh (sản phẩm, giỏ hàng, đơn hàng, khách hàng, tin tức) cùng trang quản trị, và có thể mở rộng bằng plugin/template. Đọc xong trang này, bạn sẽ cài được S-Cart trên máy hoặc server của mình, biết cách cập nhật và tùy biến nó.

**Công nghệ S-Cart 3.x:** PHP ≥ 8.3 · [Laravel 13](https://github.com/laravel/laravel) · [GP247](https://github.com/gp247net) · Tailwind CSS 4 · MySQL / MariaDB

## ✨ Có gì trong S-Cart

| Nhóm | Chức năng |
|---|---|
| 🛍️ **Bán hàng** | Sản phẩm, giỏ hàng, đơn hàng, khách hàng |
| 🌏 **Đa quốc gia** | Đa ngôn ngữ, đa tiền tệ |
| 📰 **Nội dung (CMS)** | Danh mục, tin tức, trang nội dung |
| 💳 **Thanh toán & vận chuyển** | Plugin thanh toán, phương thức vận chuyển, mã giảm giá, tính thuế |
| 🔐 **Quản trị & bảo mật** | Phân quyền theo vai trò (quản trị viên, quản lý, marketing…), nhật ký thao tác, CAPTCHA |
| 📊 **Công cụ kinh doanh** | Xử lý đơn hàng, quản lý khách hàng, thống kê & báo cáo |
| 🧩 **Mở rộng** | Plugin theo mô hình HMVC, chợ plugin/template trực tuyến, API bảo mật cho app di động |
| ⭐ **Plugin Pro** | [Multi-vendor](https://gp247.net/vi/product/multi-vendor-pro.html) (sàn nhiều người bán) · [Multi-store](https://gp247.net/vi/product/multi-store-pro.html) (nhiều cửa hàng) · [Quản lý thu chi](https://gp247.net/vi/product/plugin-inout-purchase-return.html) (nhập hàng, trả hàng, thu chi & công nợ) |

## 🧰 Yêu cầu hệ thống

| Thành phần | Yêu cầu |
|---|---|
| PHP | **8.3 trở lên** |
| Composer | Bản 2.x |
| Cơ sở dữ liệu | MySQL hoặc MariaDB — tạo sẵn một database trống |
| Quyền ghi thư mục | `storage` · `bootstrap/cache` · `app/GP247` · `public/GP247` · `public/vendor` · `resources/views/vendor` · `vendor` |

> 💡 Dùng Docker thì **không cần** cài PHP, Composer, MySQL trên máy — xem [Cách 3](#cách-3--docker).

## 🚀 Cài đặt

Chọn **một** trong ba cách:

| Cách | Phù hợp khi |
|---|---|
| [**1. Composer**](#cách-1--composer-khuyến-nghị) ⭐ | Cài lên hosting, VPS, hoặc máy dùng Laragon/XAMPP — **khuyến nghị** |
| [**2. Git clone**](#cách-2--git-clone) | Muốn lấy mã nguồn mới nhất từ GitHub để phát triển/đóng góp |
| [**3. Docker**](#cách-3--docker) | Không muốn cài PHP/MySQL trên máy |

## Cách 1 — Composer (khuyến nghị)

1. Mở **Terminal** (Windows: "Command Prompt" hoặc terminal của Laragon), kiểm tra Composer đang chạy bằng PHP nào:

   ```bash
   composer diagnose
   ```

   Dòng `PHP version` phải là **8.3 trở lên**.

   > ⚠️ Nếu PHP cũ hơn, Composer **không báo lỗi** mà lặng lẽ cài bản S-Cart 1.x rất cũ. Luôn giữ `"^3.0"` trong lệnh ở bước 2 để Composer báo lỗi rõ ràng thay vì cài nhầm.

2. Tạo dự án (thay `my-shop` bằng tên thư mục bạn muốn):

   ```bash
   composer create-project gp247/s-cart my-shop "^3.0"
   cd my-shop
   ```

3. Mở file `.env` trong thư mục dự án, sửa phần database cho khớp database bạn đã tạo:

   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ten_database
   DB_USERNAME=ten_dang_nhap
   DB_PASSWORD=mat_khau
   ```

   > Giá trị mặc định `DB_HOST=mysql-local` chỉ dành cho Docker — cài trực tiếp thì đổi thành `127.0.0.1`.

4. Khởi tạo S-Cart:

   ```bash
   php artisan gp247:install
   ```

   Lệnh sẽ hỏi xác nhận, gõ `yes`. Khi xong, màn hình in ra đường dẫn trang quản trị và tài khoản đăng nhập.

5. *(Tùy chọn)* Thêm dữ liệu mẫu để xem thử:

   ```bash
   php artisan gp247:shop-sample
   ```

6. Mở trình duyệt:

   | Trang | Địa chỉ | Đăng nhập |
   |---|---|---|
   | Cửa hàng | `http://ten-mien-cua-ban` | — |
   | Quản trị | `http://ten-mien-cua-ban/gp247_admin` | `admin` / `admin` |

   > 🔑 **Đổi mật khẩu `admin` ngay sau lần đăng nhập đầu tiên.**

## Cách 2 — Git clone

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
composer install
```

Sau đó làm tiếp **bước 3 → 6 của [Cách 1](#cách-1--composer-khuyến-nghị)** (sửa `.env`, chạy `gp247:install`, mở trình duyệt).

## Cách 3 — Docker

Có hai file cấu hình **tách biệt** — luôn dùng đúng file cho đúng môi trường:

| File | Môi trường |
|---|---|
| `docker-compose.yml` | **dev** — máy cá nhân |
| `docker-compose.prod.yml` | **prod** — server thật |

**Máy cá nhân (dev):**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan gp247:install
docker compose exec app php artisan gp247:shop-sample   # tùy chọn
```

Mở website tại <http://localhost:8000>.

**Server thật (prod):**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# Sửa .env: APP_ENV=production, APP_DEBUG=false, DB_*, SC_DOCKER_WWWUSER/SC_DOCKER_WWWGROUP — xem DOCKER_vi.md
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan gp247:install
docker compose -f docker-compose.prod.yml run --rm node   # build CSS/JS
```

> ⚠️ Trên prod **luôn** thêm `-f docker-compose.prod.yml`. Quên nó là chạy nhầm cấu hình dev (bật debug, chạy quyền root, cài Xdebug…).

📘 Hướng dẫn từng bước và xử lý sự cố Docker: [DOCKER_vi.md](./DOCKER_vi.md).

## 🔄 Cập nhật phiên bản

1. **Sao lưu** database và thư mục `app/GP247`, `public/GP247` trước khi cập nhật.
2. Tải mã nguồn mới:

   ```bash
   composer update gp247/core gp247/front gp247/shop
   ```

3. Áp dụng thay đổi lên site (an toàn, không xóa dữ liệu, không ghi đè bản dịch hay template bạn đã sửa):

   ```bash
   php artisan gp247:update
   ```

4. Kiểm tra lại:

   ```bash
   php artisan gp247:info
   ```

> ⚠️ Chỉ chạy `composer update` là **chưa đủ** — luôn chạy thêm bước 3.

Tùy chọn nâng cao (ghi đè bản dịch bằng `--overwrite-lang`, làm mới asset/view bằng `--publish=…`) có thể **ghi đè tùy biến của bạn** — đọc kỹ [Hướng dẫn cập nhật GP247](https://gp247.net/vi/docs/system/how-to-update-gp247.html) trước khi dùng.

## 🎨 Tùy biến & mở rộng

| Bạn muốn… | Cách làm |
|---|---|
| Tạo plugin mới | `php artisan gp247:make-plugin --name=PluginName` |
| Tạo template mới | `php artisan gp247:make-template --name=TemplateName` |
| Đóng gói file zip để phân phối | Thêm `--download=1` vào hai lệnh trên |
| Sửa **một** màn của template mặc định | `php artisan gp247:template-publish GP247Front --file=screen/home.blade.php` rồi sửa file ở `app/GP247/Templates/GP247Front/` |
| Sửa giao diện trang quản trị | `php artisan vendor:publish --tag=gp247:core-view` (core) · `--tag=gp247:front-admin` (front) · `--tag=gp247:shop-view-admin` (shop) |
| Đổi cấu hình upload file (lfm) | `php artisan vendor:publish --tag=config-lfm` |
| Ghi đè hàm helper `gp247_*` | Khai báo tên hàm trong `config/gp247_functions_except.php`, rồi viết hàm mới trong `app/GP247/Helpers/*.php` |
| Ghi đè controller | Xem [bên dưới](#ghi-đè-controller) |
| Thêm route cho trang quản trị | Dùng hằng số `GP247_ADMIN_PREFIX` và `GP247_ADMIN_MIDDLEWARE` — xem [routes.php của core](https://github.com/gp247net/core/blob/master/src/routes.php) |

> 💡 Template mặc định `GP247Front` được nạp **trực tiếp từ package**, nên file bạn chưa publish sẽ tự nhận bản mới khi cập nhật. Chỉ publish đúng file bạn cần sửa.

## Ghi đè controller

Áp dụng cho mọi controller (kể cả API) của `GP247/Core`, `GP247/Front`, `GP247/Shop`:

1. Tạo file cùng đường dẫn con và cùng tên trong `app/GP247/{Core|Front|Shop}/...`.
2. Cho class mới `extends` controller gốc trong `vendor/gp247/...`.
3. Thêm `App\` vào đầu namespace gốc, giữ nguyên phần còn lại:

   | Namespace gốc | Namespace mới |
   |---|---|
   | `GP247\Core\Controllers` | `App\GP247\Core\Controllers` |
   | `GP247\Core\Api\Controllers` | `App\GP247\Core\Api\Controllers` |
   | `GP247\Front\...` / `GP247\Shop\...` | `App\GP247\Front\...` / `App\GP247\Shop\...` |

📘 Tài liệu chi tiết: [Tạo plugin](https://gp247.net/vi/docs/user-guide-extension/create-new-plugin.html) · [Tạo template](https://gp247.net/vi/docs/user-guide-extension/create-new-template.html) · [Toàn bộ lệnh CLI](https://gp247.net/vi/docs/system/gp247-system-command-line.html)

## 📂 Cấu trúc thư mục

`(+)` = thư mục do GP247 tạo và quản lý.

```text
my-shop/
├── app/GP247/
│   ├── Core(+)        ← ghi đè controller của Core
│   ├── Front(+)       ← ghi đè controller của Front
│   ├── Shop(+)        ← ghi đè controller của Shop
│   ├── Helpers(+)     ← file *.php ở đây được nạp tự động
│   ├── Plugins(+)     ← plugin (gp247:make-plugin)
│   └── Templates(+)   ← template (gp247:make-template) + file template đã publish để sửa
├── public/GP247/
│   ├── Core(+)        ← CSS/JS trang quản trị
│   ├── Plugins(+)
│   └── Templates(+)
├── resources/views/vendor/
│   ├── gp247-admin(+)        ← view quản trị của Core đã publish
│   ├── gp247-front-admin(+)  ← view quản trị của Front đã publish
│   └── gp247-shop-admin(+)   ← view quản trị của Shop đã publish
└── vendor/gp247/
    ├── core           ← lõi: quản trị, phân quyền, cấu hình
    ├── front          ← giao diện cửa hàng, CMS
    └── shop           ← sản phẩm, giỏ hàng, đơn hàng
```

## 🔧 Biến môi trường hay dùng

Khai báo trong file `.env`:

| Biến | Mặc định | Ý nghĩa |
|---|---|---|
| `GP247_ADMIN_PREFIX` | `gp247_admin` | Đường dẫn trang quản trị, ví dụ `ten-mien.com/gp247_admin` |
| `GP247_API_MODE` | `1` | Bật (`1`) / tắt (`0`) API |
| `GP247_DB_PREFIX` | `gp247_` | Tiền tố tên bảng — ⚠️ **không đổi được sau khi cài** |
| `GP247_ADMIN_LOG` | `1` | Ghi nhật ký truy cập trang quản trị |
| `GP247_SEO_LANG` | `0` | Thêm mã ngôn ngữ vào URL cửa hàng (`/vi/...`, `/en/...`) |
| `GP247_ENCRYPTION_KEY` | *(trống)* | Khóa mã hóa riêng cho mật khẩu SMTP, license… — xem ghi chú trong `.env.example` |

## ❓ Hỏi & Đáp (Q&A)

**Câu 1: Composer cài xong rồi báo `Access denied for user 'root'`, là sao?**

→ Composer đang chạy bằng PHP cũ hơn 8.3 nên đã cài nhầm S-Cart 1.x. Xóa thư mục vừa tạo, chuyển Composer sang PHP 8.3+ (kiểm tra bằng `composer diagnose`), rồi cài lại với `"^3.0"`.

**Câu 2: Trang quản trị ở đâu, đăng nhập bằng gì?**

→ `http://ten-mien-cua-ban/gp247_admin`, tài khoản `admin` / mật khẩu `admin`. Hãy đổi mật khẩu ngay.

**Câu 3: Làm sao biết mình đang dùng phiên bản nào?**

→ Chạy `php artisan gp247:info`.

**Câu 4: Site lỗi hoặc cài không được, kiểm tra ở đâu trước?**

→ Chạy `php artisan gp247:doctor` — lệnh kiểm tra môi trường (PHP, quyền ghi thư mục, cấu hình…) và chỉ ra chỗ cần sửa. Nhớ kiểm tra quyền ghi các thư mục ở mục [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống).

**Câu 5: Cập nhật phiên bản có làm mất dữ liệu hay phần tôi đã sửa không?**

→ `php artisan gp247:update` không xóa dữ liệu và giữ nguyên bản dịch, template bạn đã sửa. Chỉ các tùy chọn `--overwrite-lang` và `--publish=…` mới có thể ghi đè — sao lưu trước khi dùng.

**Câu 6: Tôi sửa template mặc định, cập nhật có bị mất không?**

→ Không, nếu bạn chỉ publish đúng file cần sửa bằng `gp247:template-publish GP247Front --file=...`. File bạn đã sửa được giữ nguyên; các file còn lại tự nhận bản mới từ package.

**Câu 7: Đổi đường dẫn trang quản trị thế nào?**

→ Sửa `GP247_ADMIN_PREFIX` trong `.env` (ví dụ `quan-tri`). Không đặt trùng tên một thư mục có sẵn trong `public/` (như `vendor`, `GP247`), nếu không trang sẽ báo lỗi 403.

**Câu 8: Tôi có đổi được tiền tố tên bảng (`GP247_DB_PREFIX`) sau khi cài không?**

→ Không. Tiền tố này phải chọn trước khi chạy `gp247:install`.

**Câu 9: Tôi không dùng app di động, có nên tắt API không?**

→ Có thể. Đặt `GP247_API_MODE=0` trong `.env`.

**Câu 10: Cần hỏi thêm thì hỏi ở đâu?**

→ Xem [tài liệu GP247](https://gp247.net/vi/docs), hỏi [DeepWiki](https://deepwiki.com/gp247net/s-cart), hoặc đăng câu hỏi ở [nhóm Facebook S-Cart](https://www.facebook.com/groups/scart.opensource).

---

<sub>📅 **Cập nhật lần cuối:** 2026-09-29 · ✍️ **Tác giả (Author):** GP247</sub>
