<p align="center">
    <a href="https://gp247.net"><img src="https://gp247.net/GP247/Core/logo/logo.png" width="150"></a>
</p>
<p align="center">Mã nguồn mở miễn phí cho website thương mại điện tử<br>
    <code><b>composer create-project gp247/s-cart</b></code></p>
<p align="center">
 <a href="https://gp247.net">Trang chủ</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://gp247.net/en/docs/s-cart/s-cart-overview.html">Tài liệu</a>  | <a href="https://www.facebook.com/groups/scart.opensource">Nhóm FB</a>
</p>

<p align="center">
<a href="https://packagist.org/packages/gp247/s-cart"><img src="https://poser.pugx.org/gp247/s-cart/d/total" alt="Packagist Downloads"></a>
<a href="https://github.com/gp247net/s-cart/releases"><img src="https://poser.pugx.org/gp247/s-cart/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://github.com/gp247net/s-cart/blob/master/LICENSE"><img src="https://poser.pugx.org/gp247/s-cart/license" alt="License"></a>
<a href="https://deepwiki.com/gp247net/s-cart"><img src="https://deepwiki.com/badge.svg" alt="Ask DeepWiki"></a>
</p>

*(English version: [README.md](README.md))*

# 1. Giới thiệu tổng quan

S-Cart là dự án website thương mại điện tử miễn phí tốt nhất dành cho cá nhân và doanh nghiệp, được xây dựng trên hệ sinh thái GP247 (nền tảng Laravel Framework) và các công nghệ mới nhất.

Mục tiêu của chúng tôi là "Hiệu quả và thân thiện cho tất cả mọi người":
- Hiệu quả: Đáp ứng ngay cả những yêu cầu nhỏ nhất của khách hàng.
- Thân thiện: Dễ sử dụng, dễ bảo trì, dễ phát triển.
- Tất cả mọi người: Doanh nghiệp, cá nhân, lập trình viên, sinh viên.

**S-Cart 2.x:**
> Được hỗ trợ bởi hệ thống GP247 <a href="https://github.com/gp247net">https://github.com/gp247net</a>
>
> Core Laravel framework 13.x <a href="https://github.com/laravel/laravel">https://github.com/laravel/laravel</a>
>
> Giao diện xây dựng trên Tailwind CSS 4

## Hình ảnh minh họa
<img src="https://static.gp247.net/page/s-cart/sc-1.jpg">
<img src="https://static.gp247.net/page/s-cart/sc-2.jpg">

## Các chức năng của S-Cart

#### Tính năng cốt lõi
- Xây dựng gói plugin theo mô hình HMVC
- Hỗ trợ nâng cấp và vá lỗi S-Cart qua dòng lệnh
- Tài liệu đầy đủ cho nhà phát triển và khách hàng

#### Chức năng của website bán hàng chuyên nghiệp
- **Đa ngôn ngữ**
- **Đa tiền tệ**
- **Đầy đủ tính năng thương mại điện tử:**
  - Quản lý giỏ hàng
  - Quản lý đơn hàng
  - Quản lý sản phẩm
  - Quản lý khách hàng
- **Quản lý nội dung CMS**:
  - Danh mục
  - Tin tức
  - Trang nội dung
- **Tiện ích mở rộng**:
  - Plugin thanh toán
  - Phương thức vận chuyển
  - Hệ thống giảm giá
  - Tính thuế
- **Plugin chuyên nghiệp cho S-Cart**:
  - Multi-vendor: https://gp247.net/vi/docs/s-cart/multi-vendor.html
  - Multi-stores: https://gp247.net/vi/docs/s-cart/multi-store.html
- **Tài nguyên cho nhà phát triển**:
  - Thư viện trực tuyến: plugin và template
  - Hỗ trợ API với bảo mật cho ứng dụng và tích hợp di động

#### Tính năng quản trị mạnh mẽ
- **Quản lý người dùng**:
  - Phân quyền dựa trên vai trò (quản trị viên, quản lý, marketing, v.v.)
  - Bảo mật toàn diện với ghi nhật ký đầy đủ
  - Kiểm soát truy cập, xác thực, và CAPTCHA
- **Công cụ kinh doanh**:
  - Quản lý sản phẩm
  - Xử lý đơn hàng
  - Quản lý khách hàng
  - Phân tích và thống kê
  - Theo dõi hoạt động

## Cấu trúc thư mục website sử dụng GP247

    Website-folder/
    |
    ├── app
    │     └── GP247
    │           ├── Core(+) //Tùy chỉnh controller của Core
    │           ├── Helpers(+) //Tự động tải Helpers/*.php để nạp vào hệ thống
    │           ├── Front(+) //Tùy chỉnh controller của GP247/Front 
    │           ├── Shop(+) //Tùy chỉnh controller của GP247/Shop 
    │           ├── Plugins(+) //Sử dụng `php artisan gp247:make-plugin --name=NameOfPlugin`
    │           └── Templates(+) //Sử dụng `php artisan gp247:make-template --name=NameOfTempate`
    ├── public
    │     └── GP247
    │           ├── Core(+)
    │           ├── Plugins(+)
    │           └── Templates(+)
    ├── resources
    │            └── views/vendor
    │                           |── gp247-core(+) //Tùy chỉnh view core
    │                           └── gp247-front(+) //Tùy chỉnh view front
    ├── vendor
    │     ├── gp247/core
    │     ├── gp247/front
    │     └── gp247/shop
    └──...

---

# 2. Hướng dẫn cài đặt nhanh nhất

## Phương pháp 1: Cài đặt bằng Composer (Khuyến nghị)

**1. Tạo dự án**

```bash
composer create-project gp247/s-cart
```

**2. Kiểm tra cấu hình trong tệp `.env`**

Đảm bảo thông tin database đã đúng. Nếu `APP_KEY` chưa có, tạo bằng:

```bash
php artisan key:generate
```

**3. Khởi tạo S-Cart**

```bash
php artisan sc:install
```

**4. Cài đặt dữ liệu mẫu (tùy chọn)**

```bash
php artisan sc:sample
```

## Phương pháp 2: Cài đặt bằng Git Clone

**1. Clone repository**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
```

**2. Tạo file `.env` và cài dependencies**

```bash
cp .env.example .env
php artisan key:generate
composer install
```

**3. Cấu hình database trong `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**4. Khởi tạo S-Cart**

```bash
php artisan sc:install
php artisan sc:sample   # tùy chọn, dữ liệu mẫu
```

## Phương pháp 3: Cài đặt bằng Docker (hỗ trợ từ S-Cart 2)

Không cần cài PHP/Composer/MySQL trên máy — chỉ cần Docker. Có hai file
cấu hình **tách biệt rõ ràng** cho dev và prod, dùng đúng file cho đúng môi
trường:

- `docker-compose.yml` — môi trường **dev** (máy cá nhân)
- `docker-compose.prod.yml` — môi trường **prod** (server)

**Cài đặt DEV:**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan sc:install
docker compose exec app php artisan sc:sample   # tùy chọn
```

Truy cập website: http://localhost:8000

**Cài đặt PROD:**

```bash
git clone https://github.com/gp247net/s-cart.git
cd s-cart
cp .env.example .env
# Cấu hình .env cho prod: APP_ENV, DB_*, WWWUSER/WWWGROUP — xem DOCKER_vi.md
docker compose -f docker-compose.prod.yml up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan sc:install
docker compose exec app php artisan sc:sample   # tùy chọn
docker compose run --rm node                    # build assets CSS/JS
```

⚠️ Trên prod luôn nhớ thêm `-f docker-compose.prod.yml`, nếu không sẽ vô
tình chạy nhầm cấu hình dev (bật debug, chạy root, cài Xdebug...) — xem chi
tiết sự cố này ở Q&A trong [DOCKER_vi.md](DOCKER_vi.md).

Hướng dẫn đầy đủ, từng bước, cùng phần Q&A xử lý sự cố chi tiết cho cả dev
lẫn prod, xem tại [DOCKER_vi.md](DOCKER_vi.md).

## Lưu ý quan trọng về quyền thư mục

Nếu cài đặt bằng Phương pháp 1 hoặc 2 (không dùng Docker), đảm bảo các thư
mục sau có quyền ghi, nếu không việc cài đặt và các tính năng khác sẽ không
hoạt động chính xác:
- `app/GP247`
- `public/GP247`
- `public/vendor`
- `resources/views/vendor`
- `storage`
- `vendor`

---

# 3. Q&A

### Q: Làm sao xem phiên bản S-Cart đang cài?

*(Chỉ có sẵn khi cài đặt s-cart trực tiếp, không áp dụng cho phương pháp cài từng thành phần)*

```bash
php artisan sc:info
```

### Q: Làm sao cập nhật S-Cart?

Cập nhật từng gói bằng Composer:

```bash
composer update gp247/core
composer update gp247/front
composer update gp247/shop
```

Sau đó chạy (chỉ có sẵn khi cài đặt s-cart trực tiếp):

```bash
php artisan sc:update
```

### Q: Làm sao tạo plugin mới?

```bash
php artisan gp247:make-plugin --name=PluginName
```

Tạo kèm tệp zip để phân phối:

```bash
php artisan gp247:make-plugin --name=PluginName --download=1
```

### Q: Làm sao tạo template mới?

```bash
php artisan gp247:make-template --name=TemplateName
```

Tạo kèm tệp zip để phân phối:

```bash
php artisan gp247:make-template --name=TemplateName --download=1
```

### Q: Làm sao tùy chỉnh cấu hình upload (lfm)?

```bash
php artisan vendor:publish --tag=config-lfm
```

### Q: Làm sao tùy chỉnh giao diện quản trị core?

```bash
php artisan vendor:publish --tag=gp247:view-core
```

### Q: Làm sao ghi đè các hàm helper `gp247_*`?

1. Thêm danh sách các hàm bạn muốn ghi đè vào `config/gp247_functions_except.php`
2. Tạo các tệp php mới chứa các hàm mới trong thư mục `app/GP247/Helpers`, ví dụ `app/GP247/Helpers/myfunction.php`

### Q: Làm sao ghi đè (override) controller của GP247/Core, GP247/Front, GP247/Shop?

S-Cart cho phép ghi đè **toàn bộ** controller (kể cả controller API) trong
`GP247/Core`, `GP247/Front`, `GP247/Shop` theo cùng một cơ chế: tạo controller
tương ứng trong `app/GP247/{Core|Front|Shop}`, **extend lại controller gốc**,
và thêm `App` vào phía trước namespace gốc.

Ví dụ ghi đè một controller của Core:

1. Tạo file tương ứng trong `app/GP247/Core/Controllers/...` (giữ nguyên
   đường dẫn con và tên file như trong package gốc).
2. Cho controller mới extend lại controller gốc trong `vendor/gp247/core/...`
3. Đổi namespace từ `GP247\Core\Controllers` thành `App\GP247\Core\Controllers`
   (chỉ thêm `App` vào phía trước, giữ nguyên phần còn lại).

Áp dụng tương tự cho `GP247\Front\*`, `GP247\Shop\*` (đổi thành
`App\GP247\Front\*`, `App\GP247\Shop\*`) và cho controller API (đổi
`GP247\Core\Api\Controllers` thành `App\GP247\Core\Api\Controllers`).

### Q: Làm sao thêm route mới cho khu vực quản trị?

Sử dụng các hằng số prefix và middleware `GP247_ADMIN_PREFIX`,
`GP247_ADMIN_MIDDLEWARE` trong khai báo route.

Tham khảo: https://github.com/gp247net/core/blob/master/src/routes.php

### Q: Có những biến môi trường nào trong `.env` cần biết?

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
