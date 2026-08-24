```
  _____  _____     ___  _  _   _____ 
 / ____|  __ \   |__ \| || | |___  |
| |  __| |__) |     ) | || |_   / / 
| | |_ |  ___/     / /|__   _| / /  
| |__| | |        / /_   | |  / /   
 \_____|_|       |____|  |_| /_/    
```

> 🌐 **Ngôn ngữ:** 🇻🇳 Tiếng Việt (hiện tại) · [🇬🇧 English](README.md)

# S-Cart

**Nền tảng thương mại điện tử mã nguồn mở, miễn phí cho tất cả mọi người** —
doanh nghiệp, cá nhân, lập trình viên và sinh viên. Xây dựng trên hệ sinh thái
GP247 (Laravel) với cấu trúc rõ ràng, thân thiện với AI agent.

```bash
composer create-project gp247/s-cart
```

[🏠 Trang chủ](https://gp247.net) · [🚀 Demo](https://demo.s-cart.org) · [📚 Tài liệu GP247](https://github.com/gp247net/gp247-docs) · [🤖 Skill agent GP247](https://github.com/gp247net/gp247-skills) · [💬 Nhóm Facebook](https://www.facebook.com/groups/scart.opensource)

[![Packagist Downloads](https://poser.pugx.org/gp247/s-cart/d/total)](https://packagist.org/packages/gp247/s-cart)
[![Latest Stable Version](https://poser.pugx.org/gp247/s-cart/v/stable.svg)](https://github.com/gp247net/s-cart/releases)
[![License](https://poser.pugx.org/gp247/s-cart/license)](https://github.com/gp247net/s-cart/blob/master/LICENSE)
[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/gp247net/s-cart)

---

## 📖 Mục lục

- [Giới thiệu tổng quan](#-giới-thiệu-tổng-quan)
- [Hình ảnh minh họa](#-hình-ảnh-minh-họa)
- [Các chức năng](#-các-chức-năng)
- [Cài đặt nhanh](#-cài-đặt-nhanh)
  - [Phương pháp 1 — Composer (khuyến nghị)](#phương-pháp-1--composer-khuyến-nghị)
  - [Phương pháp 2 — Git clone](#phương-pháp-2--git-clone)
  - [Phương pháp 3 — Docker](#phương-pháp-3--docker)
  - [Quyền thư mục](#-quyền-thư-mục)
- [Cấu trúc dự án](#-cấu-trúc-dự-án)
- [Câu hỏi thường gặp](#-câu-hỏi-thường-gặp)

---

## 🎯 Giới thiệu tổng quan

S-Cart là dự án website thương mại điện tử miễn phí tốt nhất dành cho cá nhân
và doanh nghiệp, được xây dựng trên hệ sinh thái GP247 (nền tảng Laravel
Framework) và các công nghệ mới nhất.

Mục tiêu của chúng tôi là **"Hiệu quả và thân thiện cho tất cả mọi người"**:

| Tiêu chí | Ý nghĩa |
|---|---|
| **Hiệu quả** | Đáp ứng ngay cả những yêu cầu nhỏ nhất của khách hàng. |
| **Thân thiện** | Dễ sử dụng, dễ bảo trì, dễ phát triển. |
| **Tất cả mọi người** | Doanh nghiệp, cá nhân, lập trình viên, sinh viên. |
| **Thân thiện với AI agent** | Cấu trúc rõ ràng, tài liệu và skill chuẩn hoá để AI agent dễ hiểu dự án và hỗ trợ phát triển. |

**Công nghệ S-Cart 2.x**

| Tầng | Công nghệ |
|---|---|
| Hệ sinh thái | [GP247](https://github.com/gp247net) |
| Framework | [Laravel 13.x](https://github.com/laravel/laravel) |
| Giao diện | Tailwind CSS 4 |

---

## 🖼️ Hình ảnh minh họa

![Ảnh minh họa S-Cart 1](https://static.gp247.net/page/sc-1.jpg)

![Ảnh minh họa S-Cart 2](https://static.gp247.net/page/sc-2.jpg)

---

## ✨ Các chức năng

### 🧩 Nền tảng & trải nghiệm nhà phát triển

- Xây dựng gói plugin theo mô hình **HMVC**
- Hỗ trợ **nâng cấp và vá lỗi** S-Cart qua dòng lệnh
- Tài liệu đầy đủ cho nhà phát triển và khách hàng
- **Thư viện trực tuyến** cho plugin và template
- **API bảo mật** cho ứng dụng và tích hợp di động

### 🛒 Website bán hàng

| Nhóm | Khả năng |
|---|---|
| **Thương mại** | Giỏ hàng, đơn hàng, sản phẩm, khách hàng |
| **Bản địa hoá** | Đa ngôn ngữ, đa tiền tệ |
| **Nội dung (CMS)** | Danh mục, tin tức, trang nội dung |
| **Tiện ích mở rộng** | Plugin thanh toán, phương thức vận chuyển, hệ thống giảm giá, tính thuế |
| **Plugin chuyên nghiệp** | [Multi-vendor](https://gp247.net/vi/docs/s-cart/multi-vendor.html), [Multi-store](https://gp247.net/vi/docs/s-cart/multi-store.html) |

### 🛠️ Quản trị

| Nhóm | Khả năng |
|---|---|
| **Truy cập & bảo mật** | Phân quyền theo vai trò (quản trị viên, quản lý, marketing…), ghi nhật ký đầy đủ, kiểm soát truy cập, xác thực, CAPTCHA |
| **Công cụ kinh doanh** | Quản lý sản phẩm, xử lý đơn hàng, quản lý khách hàng, phân tích & thống kê, theo dõi hoạt động |

---

## 🚀 Cài đặt nhanh

> **Muốn nhanh nhất?** Chọn **Phương pháp 1 (Composer)** — chỉ một lệnh, không
> cần cấu hình server phức tạp ngoài PHP + MySQL.

### Phương pháp 1 — Composer (khuyến nghị)

```bash
# 1. Tạo dự án
composer create-project gp247/s-cart

# 2. Kiểm tra .env (thông tin database). Nếu chưa có APP_KEY, tạo bằng:
php artisan key:generate

# 3. Khởi tạo S-Cart
php artisan gp247:install

# 4. (Tùy chọn) Cài dữ liệu mẫu
php artisan gp247:shop-sample
```

### Phương pháp 2 — Git clone

```bash
# 1. Clone
git clone https://github.com/gp247net/s-cart.git
cd s-cart

# 2. Tạo file .env & cài dependencies
cp .env.example .env
php artisan key:generate
composer install
```

Cấu hình database trong `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Sau đó khởi tạo:

```bash
php artisan gp247:install
php artisan gp247:shop-sample   # tùy chọn, dữ liệu mẫu
```

### Phương pháp 3 — Docker

*Hỗ trợ từ S-Cart 2.* Không cần cài PHP/Composer/MySQL trên máy — chỉ cần
Docker. Có hai file cấu hình **tách biệt rõ ràng**, dùng đúng file cho đúng
môi trường:

| File | Môi trường |
|---|---|
| `docker-compose.yml` | **dev** (máy cá nhân) |
| `docker-compose.prod.yml` | **prod** (server) |

**Cài đặt DEV**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan gp247:install --force=1
docker compose exec app php artisan gp247:shop-sample   # tùy chọn
```

Truy cập website: <http://localhost:8000>

**Cài đặt PROD**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# Cấu hình .env cho prod: APP_ENV, DB_*, SC_DOCKER_WWWUSER/SC_DOCKER_WWWGROUP — xem DOCKER_vi.md
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan gp247:install --force=1
docker compose -f docker-compose.prod.yml exec app php artisan gp247:shop-sample   # tùy chọn
docker compose -f docker-compose.prod.yml run --rm node                    # build assets CSS/JS
```

> ⚠️ Trên prod luôn nhớ thêm `-f docker-compose.prod.yml`, nếu không sẽ vô
> tình chạy nhầm cấu hình dev (bật debug, chạy root, cài Xdebug…) — xem chi
> tiết sự cố này ở Q&A trong [DOCKER_vi.md](DOCKER_vi.md).

Hướng dẫn đầy đủ, từng bước, cùng phần Q&A xử lý sự cố chi tiết cho cả dev lẫn
prod, xem tại [DOCKER_vi.md](DOCKER_vi.md).

### 🔐 Quyền thư mục

Nếu cài đặt bằng **Phương pháp 1 hoặc 2** (không dùng Docker), đảm bảo các thư
mục sau có quyền ghi, nếu không việc cài đặt và các tính năng khác sẽ không hoạt
động chính xác:

`app/GP247` · `public/GP247` · `public/vendor` · `resources/views/vendor` · `storage` · `vendor`

---

## 📂 Cấu trúc dự án

Cấu trúc thư mục cho website sử dụng GP247 (`(+)` = do GP247 tạo/quản lý):

```text
Website-folder/
│
├── app
│     └── GP247
│           ├── Core(+)       // Tùy chỉnh controller của Core
│           ├── Helpers(+)    // Tự động tải Helpers/*.php để nạp vào hệ thống
│           ├── Front(+)      // Tùy chỉnh controller của GP247/Front
│           ├── Shop(+)       // Tùy chỉnh controller của GP247/Shop
│           ├── Plugins(+)    // php artisan gp247:make-plugin --name=NameOfPlugin
│           └── Templates(+)  // php artisan gp247:make-template --name=NameOfTemplate
├── public
│     └── GP247
│           ├── Core(+)
│           ├── Plugins(+)
│           └── Templates(+)
├── resources
│     └── views/vendor
│           ├── gp247-admin(+)        // Tùy chỉnh core admin
│           ├── gp247-shop-admin(+)   // Tùy chỉnh Shop admin
│           └── gp247-front-admin(+)  // Tùy chỉnh Front admin
├── vendor
│     ├── gp247/core
│     ├── gp247/front
│     └── gp247/shop
└── ...
```

---

## ❓ Câu hỏi thường gặp

> 📖 **Tham chiếu dòng lệnh đầy đủ.** Các lệnh bên dưới chỉ bao các trường hợp
> thông dụng. Xem tất cả lệnh artisan của GP247 cùng tùy chọn và ví dụ trong tài
> liệu chính thức: [Tiếng Việt](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference_vi.md)
> · [English](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference.md).

### Làm sao xem phiên bản S-Cart đang cài?

```bash
php artisan gp247:info
```

### Làm sao cập nhật S-Cart?

Cập nhật từng gói bằng Composer:

```bash
composer update gp247/core
composer update gp247/front
composer update gp247/shop
```

Sau đó chạy lệnh refresh an toàn, không phá dữ liệu (cập nhật core, cập nhật
schema shop nếu có module shop, và rebuild cache):

```bash
php artisan gp247:update
```

**Tùy chọn — cập nhật lại file ngôn ngữ.** Mặc định `gp247:update` giữ nguyên
bản dịch của bạn. Thêm `--overwrite-lang` để chạy thêm `gp247:language-update`,
lệnh này kéo bản dịch mới nhất và **ghi đè mọi chuỗi ngôn ngữ bạn đã sửa**:

```bash
php artisan gp247:update --overwrite-lang
```

**Tùy chọn — cập nhật lại asset/view đã publish lên bản mới nhất.**
`composer update` và `gp247:update` chỉ cập nhật code trong `vendor/`; các file đã
được copy ra `public/GP247` và `app/GP247` **không** tự động được ghi đè. Nếu
bản phát hành mới có thay đổi CSS/JS đã build sẵn hoặc template/view mặc định và
bạn muốn áp dụng lên site, hãy publish lại kèm `--force`:

```bash
php artisan vendor:publish --tag=gp247:core-public --force    # -> public/GP247 (build admin: CSS/JS, ...)
php artisan vendor:publish --tag=gp247:front-public --force   # -> public/GP247/Templates/GP247Front (CSS/JS storefront)
php artisan vendor:publish --tag=gp247:front-view --force     # -> app/GP247/Templates/GP247Front (view template mặc định)
```

> ⚠️ `--force` sẽ **ghi đè** các file ở thư mục đích — bao gồm cả những tùy
> chỉnh cục bộ bạn đã sửa ở đó (logo/ảnh tùy biến, file Blade template đã chỉnh,
> v.v.). **Hãy backup `public/GP247` và `app/GP247` trước**, và chỉ publish đúng
> tag bạn thực sự cần.

Bạn cũng có thể gộp bước re-publish vào ngay lệnh refresh bằng option **tùy chọn**
`--publish=<tokens>` (mặc định không publish gì). Chỉ `core-public` là an toàn
(asset admin đã build); các token view/template sẽ ghi đè tùy biến của bạn, nên
hãy backup trước:

```bash
php artisan gp247:update --publish=core-public          # an toàn: làm mới CSS/JS admin
php artisan gp247:update --publish=core-public,front-view # đồng thời ghi đè template storefront (PHÁ DỮ LIỆU)
```

`gp247:update` **không** có cờ `--force` — tự gõ token phá-dữ-liệu chính là đồng
thuận, và chạy tương tác vẫn cảnh báo và hỏi xác nhận. Xem
[tài liệu CLI](gp247-docs/system/command-line-reference_vi.md) để biết bảng đầy đủ
token → đích → mức độ ảnh hưởng.

### Làm sao tạo plugin mới?

```bash
php artisan gp247:make-plugin --name=PluginName
```

Tạo kèm tệp zip để phân phối:

```bash
php artisan gp247:make-plugin --name=PluginName --download=1
```

### Làm sao tạo template mới?

```bash
php artisan gp247:make-template --name=TemplateName
```

Tạo kèm tệp zip để phân phối:

```bash
php artisan gp247:make-template --name=TemplateName --download=1
```

### Làm sao tùy chỉnh cấu hình upload (lfm)?

```bash
php artisan vendor:publish --tag=config-lfm
```

### Làm sao tùy chỉnh giao diện quản trị?

Mỗi package publish view quản trị vào riêng một thư mục
`views/vendor/<namespace>` — chỉ publish đúng tag bạn cần override:

```bash
php artisan vendor:publish --tag=gp247:core-view        # -> views/vendor/gp247-admin
php artisan vendor:publish --tag=gp247:front-admin      # -> views/vendor/gp247-front-admin
php artisan vendor:publish --tag=gp247:shop-view-admin  # -> views/vendor/gp247-shop-admin
```

Dùng thêm `--force` nếu cần ghi đè các file đã publish từ trước.

### Làm sao tùy chỉnh template mặc định?

```bash
php artisan vendor:publish --tag=gp247:front-view       # -> app/GP247/Templates/GP247Front
php artisan vendor:publish --tag=gp247:front-public     # -> public/GP247/Templates/GP247Front
php artisan vendor:publish --tag=gp247:shop-view-front  # -> app/GP247/Templates/GP247Front
```

Dùng thêm `--force` nếu cần ghi đè các file đã publish từ trước.

### Làm sao ghi đè các hàm helper `gp247_*`?

1. Thêm danh sách các hàm bạn muốn ghi đè vào `config/gp247_functions_except.php`
2. Tạo các tệp php mới chứa các hàm mới trong thư mục `app/GP247/Helpers`, ví dụ `app/GP247/Helpers/myfunction.php`

### Làm sao ghi đè (override) controller của GP247/Core, GP247/Front, GP247/Shop?

S-Cart cho phép ghi đè **toàn bộ** controller (kể cả controller API) trong
`GP247/Core`, `GP247/Front`, `GP247/Shop` theo cùng một cơ chế: tạo controller
tương ứng trong `app/GP247/{Core|Front|Shop}`, **extend lại controller gốc**,
và thêm `App` vào phía trước namespace gốc.

Ví dụ ghi đè một controller của Core:

1. Tạo file tương ứng trong `app/GP247/Core/Controllers/...` (giữ nguyên đường
   dẫn con và tên file như trong package gốc).
2. Cho controller mới extend lại controller gốc trong `vendor/gp247/core/...`
3. Đổi namespace từ `GP247\Core\Controllers` thành `App\GP247\Core\Controllers`
   (chỉ thêm `App` vào phía trước, giữ nguyên phần còn lại).

Áp dụng tương tự cho `GP247\Front\*`, `GP247\Shop\*` (đổi thành
`App\GP247\Front\*`, `App\GP247\Shop\*`) và cho controller API (đổi
`GP247\Core\Api\Controllers` thành `App\GP247\Core\Api\Controllers`).

### Làm sao thêm route mới cho khu vực quản trị?

Sử dụng các hằng số prefix và middleware `GP247_ADMIN_PREFIX`,
`GP247_ADMIN_MIDDLEWARE` trong khai báo route.

Tham khảo: <https://github.com/gp247net/core/blob/master/src/routes.php>

### Có những biến môi trường nào trong `.env` cần biết?

**Tắt API:**
```env
GP247_API_MODE=1   // Để tắt, đặt giá trị 0
```

**Tiền tố bảng dữ liệu** (không thể thay đổi sau khi cài đặt gp247):
```env
GP247_DB_PREFIX=gp247_
```

**Tiền tố đường dẫn đến trang quản trị:**
```env
GP247_ADMIN_PREFIX=gp247_admin
```

---

Được xây dựng bởi hệ sinh thái ❤️ GP247 — [gp247.net](https://gp247.net)
