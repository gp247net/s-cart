<p align="center">
    <a href="https://gp247.net"><img src="https://s-cart.org/logo.png" width="150"></a>
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


## Giới thiệu về S-Cart
S-Cart là dự án website thương mại điện tử miễn phí tốt nhất dành cho cá nhân và doanh nghiệp, được xây dựng trên nền tảng Laravel Framework và các công nghệ mới nhất.
Mục tiêu của chúng tôi là "Hiệu quả và thân thiện cho tất cả mọi người":
- Hiệu quả: Đáp ứng ngay cả những yêu cầu nhỏ nhất của khách hàng.
- Thân thiện: Dễ sử dụng, dễ bảo trì, dễ phát triển.
- Tất cả mọi người: Doanh nghiệp, cá nhân, lập trình viên, sinh viên.

[Các phiên bản mới của s-cart từ năm  2025 được phát triển bởi GP247 team]

Về thành phần:

> **S-Cart** = `Laravel` + `GP247/Core` + `GP247/Front` + `GP247/Shop`

## HÌNH ẢNH MINH HỌA:
<img src="https://static.s-cart.org/guide/use/common/shop.jpg">
<img src="https://static.s-cart.org/guide/use/common/dashboard.jpg">

## Các chức năng của S-Cart:

###  S-Cart - Giải pháp website thương mại điện tử  MIỄN PHÍ cho doanh nghiệp 

#### Tính năng cốt lõi
- Xây dựng gói plugin theo mô hình HMVC
- Hỗ trợ nâng cấp và vá lỗi S-Cart qua dòng lệnh
- Tài liệu đầy đủ cho nhà phát triển và khách hàng

####  Chức năng của website bán hàng chuyên nghiệp
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

####  Tính năng quản trị mạnh mẽ
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


## S-Cart 1.x:


> Được hỗ trợ bởi hệ thống GP247 <a href="https://github.com/gp247net">https://github.com/gp247net</a>

> Core Laravel framework 12.x <a href="https://github.com/laravel/laravel">https://github.com/laravel/laravel</a>


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


## Hướng dẫn cài đặt nhanh

### Phương pháp 1: Cài đặt bằng Composer (Khuyến nghị)

- **Bước 1**: 

  Tham khảo lệnh: 
  >`composer create-project gp247/s-cart`

- **Bước 2**: Kiểm tra cấu hình trong tệp .env

  Đảm bảo rằng cấu hình cơ sở dữ liệu và thông tin APP_KEY trong tệp .env đã hoàn chỉnh.

  Nếu APP_KEY chưa được thiết lập, sử dụng lệnh sau để tạo: 
  >`php artisan key:generate`

- **Bước 3**: Khởi tạo S-Cart

  Chạy lệnh: 
  >`php artisan sc:install`

- **Bước 4**: Cài đặt dữ liệu mẫu (tùy chọn)

  Nếu bạn muốn cài đặt dữ liệu mẫu, chạy lệnh:
  >`php artisan sc:sample`

### Phương pháp 2: Cài đặt bằng Git Clone

- **Bước 1**: Clone repository từ GitHub

  >`git clone https://github.com/gp247net/s-cart.git`

- **Bước 2**: Di chuyển vào thư mục dự án

  >`cd s-cart`

- **Bước 3**: Tạo file .env từ file mẫu

  >`cp .env.example .env`

- **Bước 4**: Tạo APP_KEY

  >`php artisan key:generate`

- **Bước 5**: Cài đặt dependencies bằng Composer

  >`composer install`

- **Bước 6**: Cấu hình cơ sở dữ liệu trong file .env

  Chỉnh sửa các thông tin kết nối database trong file .env:
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```

- **Bước 7**: Khởi tạo S-Cart

  >`php artisan sc:install`

- **Bước 8**: Cài đặt dữ liệu mẫu (tùy chọn)

  >`php artisan sc:sample`

### Phương pháp 3: Cài đặt từng thành phần (Laravel + GP247/Core + GP247/Front + GP247/Shop)

- **Bước 1**: Tạo dự án Laravel 12.x (hoặc sử dụng dự án có sẵn)

  >`composer create-project laravel/laravel s-cart`

- **Bước 2**: Di chuyển vào thư mục s-cart, và cài các thành phần GP247 theo thứ tự

  >`composer require gp247/core`

  >`composer require gp247/front`

  >`composer require gp247/shop`

- **Bước 3**: Đăng ký Service Providers

  Mở file `bootstrap/providers.php`, thêm 2 provider vào cuối mảng trả về:

  ```php
  GP247\Front\FrontServiceProvider::class,
  GP247\Shop\ShopServiceProvider::class,
  ```

- **Bước 4**: Cấu hình routing và exceptions cho GP247

  Mở file `bootstrap/app.php`:

  - Comment dòng cấu hình web routes:

    ```php
    //GP247 comment
    //web: __DIR__.'/../routes/web.php',
    ```

  - Thêm xử lý exceptions (đặt trong phần cấu hình exceptions):

    ```php
    // GP247 add new
    $exceptions->report(function (\Throwable $e) {
        if (function_exists('gp247_handle_exception')) {
            gp247_handle_exception($e);
        }
    });
    ```

- **Bước 5**: Tạo APP_KEY nếu chưa có

  >`php artisan key:generate`

- **Bước 6**: Cấu hình cơ sở dữ liệu trong file .env

  Chỉnh sửa các thông tin kết nối database trong file .env:
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```

- **Bước 7**: Lần lượt chạy các lệnh sau để cài đặt:

  >`php artisan gp247:core-install`

  >`php artisan gp247:front-install`

  >`php artisan gp247:shop-install`

- **Bước 8**: Cài đặt dữ liệu mẫu (tùy chọn)

  >`php artisan gp247:shop-sample`

### Lưu ý quan trọng về quyền thư mục

Đảm bảo các thư mục sau có quyền ghi:
- `app/GP247`
- `public/GP247`
- `public/vendor`
- `resources/views/vendor`
- `storage`
- `vendor`

Nếu không có quyền ghi đúng, việc cài đặt và các tính năng khác nhau sẽ không hoạt động chính xác.

## Thông tin hữu ích:

**Xem phiên bản S-Cart**

(Chỉ có sẵn khi cài đặt s-cart trực tiếp)

>`php artisan sc:info`

**Cập nhật S-Cart**

Cập nhật gói bằng lệnh: 

>`composer update gp247/core`

>`composer update gp247/front`

>`composer update gp247/shop`

Sau đó, chạy lệnh: 

(Chỉ có sẵn khi cài đặt s-cart trực tiếp)

>`php artisan sc:update`

**Tạo plugin:**

>`php artisan gp247:make-plugin  --name=PluginName`

Tạo tệp zip plugin

>`php artisan gp247:make-plugin  --name=PluginName --download=1`

**Tạo template:**

>`php artisan gp247:make-template  --name=TemplateName`

Tạo tệp zip template:

>`php artisan gp247:make-template  --name=TemplateName --download=1`

## Tùy chỉnh


**Tùy chỉnh cấu hình lfm cho tải lên**

>`php artisan vendor:publish --tag=config-lfm`

**Tùy chỉnh giao diện quản trị core**

>`php artisan vendor:publish --tag=gp247:view-core`

**Ghi đè các hàm helper gp247_***

>Bước 1: Thêm danh sách các hàm bạn muốn ghi đè vào `config/gp247_functions_except.php`

>Bước 2: Tạo các tệp php mới chứa các hàm mới trong thư mục `app/GP247/Helpers`, ví dụ `app/GP247/Helpers/myfunction.php`

**Ghi đè các tệp controller gp247**

>Bước 1: Sao chép các tệp controller bạn muốn ghi đè từ vendor/gp247/core/src/Core/Controllers -> app/GP247/Core/Controllers

>Bước 2: Thay đổi `namespace GP247\Core\Controllers` thành `namespace App\GP247\Core\Controllers`

**Ghi đè các tệp controller API gp247**

>Bước 1: Sao chép các tệp controller bạn muốn ghi đè từ vendor/gp247/core/src/Api/Controllers -> app/GP247/Core/Api/Controllers

>Bước 2: Thay đổi `namespace GP247\Core\Api\Controllers` thành `namespace App\GP247\Core\Api\Controllers`

## Thêm route

Sử dụng các hằng số prefix và middleware `GP247_ADMIN_PREFIX`, `GP247_ADMIN_MIDDLEWARE` trong khai báo route.

Tham khảo: https://github.com/gp247net/core/blob/master/src/routes.php


## Biến môi trường trong tệp .env

**Tắt API**
> `GP247_API_MODE=1` // Để tắt, đặt giá trị 0

**Tiền tố bảng dữ liệu**
> `GP247_DB_PREFIX=gp247_` //Không thể thay đổi sau khi cài đặt gp247

**Tiền tố đường dẫn đến trang quản trị**
> `GP247_ADMIN_PREFIX=gp247_admin` 