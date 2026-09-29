> 🌐 **Ngôn ngữ:** 🇻🇳 Tiếng Việt (hiện tại) · [🇬🇧 English](./DOCKER.md)

<div align="center">

# 🐳 S-Cart với Docker

**Chạy S-Cart (GP247 / Laravel 13) bằng Docker — cho máy cá nhân (dev) lẫn server thật (prod)**

[⬅️ Về README](./README_vi.md) · [🐳 Docker Docs](https://docs.docker.com/) · [💬 Nhóm Facebook](https://www.facebook.com/groups/scart.opensource)

</div>

## Giới thiệu

Tài liệu này hướng dẫn dựng S-Cart bằng Docker từ đầu, dành cho người muốn chạy thử trên máy cá nhân hoặc đưa lên server mà **không phải tự cài PHP, Composer, MySQL**. Đọc xong, bạn sẽ chạy được môi trường dev và prod, biết các lệnh dùng hằng ngày, và tự xử lý được các lỗi thường gặp.

## Mục lục

1. [Yêu cầu](#-yêu-cầu)
2. [Stack gồm những gì](#-stack-gồm-những-gì)
3. [Chạy môi trường DEV](#-chạy-môi-trường-dev)
4. [Chạy môi trường PROD](#-chạy-môi-trường-prod)
5. [Lệnh dùng hằng ngày](#-lệnh-dùng-hằng-ngày)
6. [Khi nào cần build lại / restart](#-khi-nào-cần-build-lại--restart)
7. [Dữ liệu được lưu ở đâu](#-dữ-liệu-được-lưu-ở-đâu)
8. [MySQL đóng gói sẵn](#-mysql-đóng-gói-sẵn)
9. [Chạy nhiều dự án trên một host](#-chạy-nhiều-dự-án-trên-một-host)
10. [Điều kiện & ràng buộc](#-điều-kiện--ràng-buộc-hiểu-trước-khi-thao-tác)
11. [Hỏi & Đáp](#-hỏi--đáp-qa)

---

## 🧰 Yêu cầu

| Thành phần | Yêu cầu |
|---|---|
| Docker | Docker Desktop (Windows/Mac) hoặc Docker Engine + Compose plugin (Linux) |
| Mã nguồn | Đã có repo này trên máy/server: `git clone https://github.com/gp247net/s-cart.git` |
| Windows | Nên dùng WSL2; để nhanh nhất, đặt project trong filesystem của WSL2 (vd `~/projects/s-cart`) thay vì `/mnt/c/...` |

---

## 🧱 Stack gồm những gì

| Service | Vai trò | Image |
|---|---|---|
| `app` | PHP-FPM chạy Laravel | build từ `docker/php` |
| `webserver` | Nginx, phục vụ `public/`, chuyển `.php` sang `app` | `nginx:1.27-alpine` |
| `queue` | `php artisan queue:work` (email, job nền) | dùng chung image `app` |
| `scheduler` | Gọi `php artisan schedule:run` mỗi 60 giây | dùng chung image `app` |
| `mysql-local` | MySQL 8.4 (tùy chọn, bật bằng `COMPOSE_PROFILES=db-local`) | `mysql:8.4` |
| `node` | Build/dev asset (Vite) — chỉ chạy khi cần | `node:22-alpine` |

Có hai file compose **tách biệt hoàn toàn** — luôn dùng đúng file cho đúng môi trường:

| | `docker-compose.yml` — **DEV** | `docker-compose.prod.yml` — **PROD** |
|---|---|---|
| Dùng cho | Máy cá nhân | Server thật |
| Lệnh | `docker compose ...` | `docker compose -f docker-compose.prod.yml ...` |
| Cổng web mặc định | `8000` | `80` |
| `APP_ENV` / `APP_DEBUG` | `local` / `true` (ghim trong file compose) | `production` / `false` (ghim trong file compose) |
| `app` chạy bằng | root (tránh lỗi quyền khi bind-mount) | `www-data` theo `SC_DOCKER_WWWUSER`/`SC_DOCKER_WWWGROUP` |
| Xdebug, Vite hot-reload | Có | Không |
| Tên container | `scart-app`, `scart-nginx`… | `scart-app-prod`, `scart-nginx-prod`… |

---

## 💻 Chạy môi trường DEV

1. Vào thư mục project, tạo file cấu hình:

   ```bash
   cp .env.example .env
   ```

   `.env.example` đã có sẵn cấu hình chạy được ngay (dùng MySQL đóng gói trong Docker) — không cần sửa gì.

2. Khởi động toàn bộ container (lần đầu mất vài phút để build image):

   ```bash
   docker compose up -d --build
   ```

   Kiểm tra bằng `docker compose ps` — các service phải ở trạng thái `running`.

3. Cài S-Cart:

   ```bash
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan gp247:install
   docker compose exec app php artisan gp247:shop-sample   # tùy chọn: dữ liệu mẫu
   ```

   `gp247:install` hỏi xác nhận — gõ `yes`.

4. Mở trình duyệt:

   | Trang | Địa chỉ |
   |---|---|
   | Cửa hàng | <http://localhost:8000> |
   | Quản trị | <http://localhost:8000/gp247_admin> — `admin` / `admin` |
   | Vite dev server (hot-reload asset) | <http://localhost:5173> |

   > 🔑 Đổi mật khẩu `admin` ngay sau lần đăng nhập đầu tiên.

> 💡 Muốn đổi cổng hoặc database, sửa `.env` **trước bước 2**: `SC_DOCKER_APP_PORT`, `SC_DOCKER_DB_PORT`, `DB_*`, `COMPOSE_PROFILES`. Mỗi biến có chú thích ngay trong mục `#========DOCKER=========` của `.env.example`. Nên đặt `APP_URL=http://localhost:8000` để link trong email (sinh từ queue/CLI) có đúng cổng.

---

## 🏭 Chạy môi trường PROD

1. Trên server, tạo `.env` từ file mẫu:

   ```bash
   cp .env.example .env
   ```

2. Chọn **một** trong hai cách dùng database:

   | | **A. Database từ xa / managed** (RDS, Cloud SQL…) | **B. MySQL đóng gói trong Docker** |
   |---|---|---|
   | `DB_HOST` | `your-remote-mysql-host` | `mysql-local` |
   | `COMPOSE_PROFILES` | *(để trống)* — không tạo container `mysql-local` | `db-local` |
   | `SC_DOCKER_DB_ROOT_PASSWORD` | không cần | **bắt buộc**, đổi khỏi `change_me_root` |

3. Sửa `.env` — tối thiểu các dòng sau (ví dụ cho cách A):

   ```env
   APP_ENV=production
   APP_DEBUG=false

   DB_CONNECTION=mysql
   DB_HOST=your-remote-mysql-host
   DB_PORT=3306
   DB_DATABASE=scart-db-prod
   DB_USERNAME=scart-user
   DB_PASSWORD=mat_khau_that        # BẮT BUỘC đổi khỏi giá trị mẫu "password"
   COMPOSE_PROFILES=

   SC_DOCKER_WWWUSER=1000           # chạy `id -u` trên server
   SC_DOCKER_WWWGROUP=1000          # chạy `id -g` trên server
   ```

   > Không đặt `SC_DOCKER_APP_PORT` trừ khi cần cổng khác `80` (vd đứng sau reverse proxy) — file compose prod tự mặc định `80`.

4. Khởi động container:

   ```bash
   docker compose -f docker-compose.prod.yml up -d --build
   ```

5. Cài S-Cart (chỉ lần đầu):

   ```bash
   docker compose -f docker-compose.prod.yml exec app php artisan key:generate
   docker compose -f docker-compose.prod.yml exec app php artisan gp247:install
   ```

6. Build asset CSS/JS (asset không nằm sẵn trong image — chạy lại mỗi khi CSS/JS đổi):

   ```bash
   docker compose -f docker-compose.prod.yml run --rm node
   ```

7. Mở `http://ten-mien-cua-ban` và `http://ten-mien-cua-ban/gp247_admin` để kiểm tra.

> ⚠️ Mọi lệnh prod đều có `-f docker-compose.prod.yml`. Hãy **copy nguyên lệnh**, đừng gõ theo trí nhớ — thiếu `-f` là Docker lặng lẽ dùng file DEV. Xem [Câu 7](#-hỏi--đáp-qa).

**Mẹo rút gọn lệnh** — chỉ có hiệu lực trong phiên terminal hiện tại:

```bash
export COMPOSE_FILE=docker-compose.prod.yml       # bash/zsh
# $env:COMPOSE_FILE = "docker-compose.prod.yml"   # PowerShell
```

Biến này **mất** khi mở SSH mới, tab mới, hoặc trong cron/script deploy. Trong script và CI, luôn ghi đầy đủ `-f docker-compose.prod.yml`.

---

## 🔁 Lệnh dùng hằng ngày

> Các lệnh dưới đây viết cho DEV. **Trên prod, thêm `-f docker-compose.prod.yml` sau `docker compose`.** Không chắc shell đang nhắm file nào? Chạy `docker compose config --services`.

**Cập nhật code sau `git pull`:**

```bash
git pull
docker compose exec app composer install --no-interaction --optimize-autoloader   # nếu composer.lock đổi
docker compose exec app php artisan gp247:update                                   # nếu gói gp247/* lên phiên bản mới
docker compose exec app php artisan migrate --force                                # nếu có migration mới
docker compose run --rm node                                                       # nếu asset đổi
docker compose exec app php artisan config:cache
```

Thay đổi code thông thường **không cần** build lại hay restart — xem [mục 6](#-khi-nào-cần-build-lại--restart).

**Các lệnh khác:**

| Việc | Lệnh |
|---|---|
| Chạy lệnh artisan bất kỳ | `docker compose exec app php artisan <lệnh>` |
| Xem log PHP / Nginx | `docker compose logs -f app` · `docker compose logs -f webserver` |
| Xem log Laravel | `tail -f storage/logs/laravel.log` (PowerShell: `Get-Content storage\logs\laravel.log -Wait -Tail 50`) |
| Vào shell container | `docker compose exec app sh` |
| Dừng toàn bộ (giữ dữ liệu) | `docker compose down` |
| Sao lưu MySQL đóng gói | `docker compose exec mysql-local mysqldump -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" scart > backup.sql` |
| Cập nhật dependency PHP | `docker compose exec app composer update --no-interaction --optimize-autoloader` rồi `docker compose restart queue scheduler` |

> 💡 Đặt `LOG_STACK=daily` trong `.env` để log Laravel xoay vòng theo ngày, tránh một file `laravel.log` phình mãi.

---

## 🔨 Khi nào cần build lại / restart

Quy tắc: file được **copy vào image** (trong `docker/php/Dockerfile`) → sửa xong phải **build lại**. File chỉ được **mount** → chỉ cần **restart/recreate**. Code ứng dụng → **không cần gì**.

| Thay đổi | Build lại? | Restart? | Lệnh |
|---|---|---|---|
| `docker/php/Dockerfile`, `php.ini`, `entrypoint.sh`, `prod-guard.sh` | **Có** | Có | `docker compose build app && docker compose up -d` |
| `.env`: `SC_DOCKER_PHP_VERSION`, `SC_DOCKER_WWWUSER`, `SC_DOCKER_WWWGROUP` | **Có** | Có | `docker compose up -d --build` |
| `.env`: biến runtime (`DB_HOST`, `SC_DOCKER_APP_PORT`, `SC_DOCKER_DB_PORT`, `SC_DOCKER_XDEBUG_MODE`…) | Không | Có | `docker compose up -d` |
| `docker-compose*.yml` | Không | Có | `docker compose up -d` |
| `docker/nginx/default.conf` | Không | Có | `docker compose restart webserver` |
| `docker/mysql/my.cnf` | Không | Có | `docker compose restart mysql-local` |
| Code PHP / Blade | Không | Không | — (chạy lại `config:cache` nếu bạn dùng nó) |
| `composer.json` / `composer.lock` | Không | Không | `docker compose exec app composer install ...` |
| `package.json` / asset JS-CSS | Không | Không | `docker compose run --rm node` |
| `APP_ENV` / `APP_DEBUG` trong `.env` | Không | Không | Không tác dụng bên trong container — hai giá trị này bị file compose **ghim** cho cả `app`, `queue`, `scheduler`. Muốn đổi phải sửa file compose |

> Đã chạy `php artisan config:cache`? Thay đổi trong `.env` chỉ có hiệu lực sau khi chạy lại `config:cache` (hoặc `config:clear`).

---

## 💾 Dữ liệu được lưu ở đâu

Image **không chứa code** — toàn bộ thư mục project được bind-mount từ máy bạn vào container (`./:/var/www/html`). Vì vậy build lại hay tạo lại container **không làm mất** các thư mục sau:

- `app/GP247` — controller, helper, plugin, template bạn tùy biến
- `public/GP247`, `public/vendor`, `resources/views/vendor`
- `storage/app/public` — ảnh sản phẩm, file upload

Ngoại lệ là các thư mục nằm trong **named volume** của Docker (nhanh hơn nhiều so với bind-mount trên Windows):

| Nội dung | Volume DEV | Volume PROD |
|---|---|---|
| `vendor/` | `scart_scart-vendor` | `scart-vendor` |
| `node_modules/` | `scart_scart-node-modules` | `scart-node-modules` |
| Dữ liệu MySQL | `scart_scart-mysql-local-data-dev` | `scart-mysql-local-data-prod` |

- Volume **còn nguyên** khi `docker compose down`, **chỉ mất** khi `docker compose down -v` hoặc `docker volume rm`.
- `vendor/` và `node_modules/` không duyệt được từ File Explorer — bình thường, vì không nên sửa tay chúng. Mất volume này cũng không sao: container tự cài lại khi khởi động.
- Xem tên volume thật: `docker volume ls`. Tên PROD được ghim cố định trong `docker-compose.prod.yml`; tên DEV có tiền tố project `scart_`.

> ⚠️ **Nâng cấp một server prod đã chạy từ bản cũ?** Chạy `docker volume ls` **trước khi** kéo `docker-compose.prod.yml` mới. Nếu volume MySQL đang có tên dạng `scart_scart-mysql-local-data-prod` (có tiền tố), hãy đổi tên/chép dữ liệu sang `scart-mysql-local-data-prod`, hoặc sửa `name:` trong file compose cho khớp — nếu không MySQL sẽ khởi động trên một volume mới, trống rỗng.

Khi chuyển sang server khác, nhớ mang theo các thư mục ở danh sách trên (qua git, rsync, hoặc backup riêng).

---

## 🐬 MySQL đóng gói sẵn

Khi `COMPOSE_PROFILES=db-local`, container `mysql-local` tự tạo database và user từ `.env`:

| Biến `.env` | Trở thành | Mặc định DEV (nếu bỏ trống) |
|---|---|---|
| `DB_DATABASE` | `MYSQL_DATABASE` | `scart` |
| `DB_USERNAME` | `MYSQL_USER` | `scart` |
| `DB_PASSWORD` | `MYSQL_PASSWORD` | `scart` |
| `SC_DOCKER_DB_ROOT_PASSWORD` | `MYSQL_ROOT_PASSWORD` | `root_secret` |

- PROD **không có mặc định** — phải khai báo đủ cả 4 biến.
- Laravel đọc cùng file `.env` nên thông tin luôn khớp; chỉ cần `DB_HOST=mysql-local` (tên service, không phải hostname thật).
- Dùng HeidiSQL/DBeaver trên máy (chỉ DEV): kết nối `127.0.0.1`, cổng `SC_DOCKER_DB_PORT` (mặc định `3306`).

Kiểm tra database đang có trong container:

```bash
docker compose exec mysql-local mysql -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" -e "SHOW DATABASES;"
```

Thêm database/user còn thiếu mà **không đụng** dữ liệu hiện có:

```bash
docker compose exec mysql-local mysql -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS your_db; CREATE USER IF NOT EXISTS 'your_user'@'%' IDENTIFIED BY 'your_pass'; GRANT ALL ON your_db.* TO 'your_user'@'%';"
```

Reset toàn bộ — ⚠️ **mất hết dữ liệu MySQL, không khôi phục được**, sao lưu trước:

```bash
docker compose down
docker volume ls | grep mysql-local-data            # xem tên thật trước khi xoá
docker volume rm scart_scart-mysql-local-data-dev   # DEV; PROD: scart-mysql-local-data-prod
docker compose up -d
```

---

## 🏢 Chạy nhiều dự án trên một host

Docker phân biệt stack theo **project name**, không theo thư mục. Mọi tên container, image tag, volume, network đều sinh ra từ **một biến `SC_DOCKER_INSTANCE`** (bỏ trống = `scart`). Vì vậy **mỗi dự án phải có `SC_DOCKER_INSTANCE` riêng** — hai thư mục cùng để trống sẽ bị Docker coi là **cùng một stack**: `up` ở thư mục thứ hai sẽ chiếm container và **cả database MySQL** của dự án thứ nhất, không có cảnh báo nào.

Thêm dự án thứ 2, thứ 3…:

1. Đặt mỗi dự án trong **thư mục riêng**.
2. Trong `.env` của dự án đó, đặt tên instance và cổng host **riêng**:

   ```env
   SC_DOCKER_INSTANCE=shopa     # duy nhất mỗi dự án: shopa, shopb…
   SC_DOCKER_APP_PORT=8001      # cổng web khác nhau mỗi dự án
   SC_DOCKER_VITE_PORT=5174     # chỉ DEV
   SC_DOCKER_DB_PORT=3307       # chỉ DEV, khi COMPOSE_PROFILES=db-local

   # GIỮ NGUYÊN ở mọi dự án:
   DB_HOST=mysql-local
   DB_PORT=3306
   ```

3. Khởi động như bình thường (`docker compose up -d --build`, thêm `-f docker-compose.prod.yml` cho prod).

Kết quả với `SC_DOCKER_INSTANCE=shopa`:

| Định danh | Mặc định (bỏ trống) | `SC_DOCKER_INSTANCE=shopa` |
|---|---|---|
| Project (dev / prod) | `scart` / `scart-prod` | `shopa` / `shopa-prod` |
| Container | `scart-app`, `scart-nginx`… | `shopa-app`, `shopa-nginx`… |
| Image tag (dev / prod) | `scart-app:8.3` / `scart-app:8.3-prod` | `scart-app:8.3-shopa` / `scart-app:8.3-shopa-prod` |
| Volume DEV | `scart_scart-vendor`, `scart_scart-mysql-local-data-dev`… | `shopa_scart-vendor`, `shopa_scart-mysql-local-data-dev`… |
| Volume PROD | `scart-vendor`, `scart-mysql-local-data-prod`… | `shopa-vendor`, `shopa-mysql-local-data-prod`… |
| Network (dev / prod) | `scart_scart` / `scart-prod_scart` | `shopa_scart` / `shopa-prod_scart` |

Vai trò của từng biến khi nhiều stack chạy chung host:

| Biến | Tác dụng | Khi nhiều stack |
|---|---|---|
| `SC_DOCKER_INSTANCE` | Tên project, container, image tag, volume, network | **Bắt buộc khác nhau** |
| `SC_DOCKER_APP_PORT` | Cổng web trên host (mặc định dev `8000`, prod `80`) | **Khác nhau**, hoặc đặt reverse proxy phía trước |
| `SC_DOCKER_VITE_PORT` | Cổng Vite dev server (chỉ DEV) | **Khác nhau** nếu chạy nhiều stack dev |
| `SC_DOCKER_DB_PORT` | Cổng `mysql-local` trên host cho công cụ DB (chỉ DEV) | **Khác nhau** nếu nhiều stack dev bật `db-local` |
| `DB_HOST` / `DB_PORT` | Nơi Laravel kết nối, **bên trong** network Docker | **Giữ nguyên** `mysql-local` / `3306` — mỗi stack có network riêng |
| `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | Database của dự án | Trùng được nếu mỗi stack có `mysql-local` riêng; **phải khác** nếu dùng chung một MySQL |
| `COMPOSE_PROFILES` | `db-local` = MySQL riêng; trống = DB ngoài | Để trống nếu muốn nhiều stack dùng chung một MySQL (tiết kiệm RAM) |
| `SC_DOCKER_PHP_VERSION` | Phiên bản PHP của image | Khác nhau được |
| `SC_DOCKER_WWWUSER` / `SC_DOCKER_WWWGROUP` | UID/GID của `www-data` (PROD) | Theo chủ sở hữu thư mục của **từng** dự án |

- **Nhiều site trên prod** → dùng reverse proxy (Traefik, Caddy, hoặc Nginx trên host) publish `80`/`443` và route theo domain tới từng stack; các stack không cần publish cổng ra ngoài, lại có TLS tập trung.
- **Tài nguyên**: mỗi instance là 4–6 container, RAM/CPU tăng theo số instance. Muốn chứa nhiều site hơn trên VPS nhỏ, cho các instance dùng chung một MySQL (mỗi site một `DB_DATABASE`, `COMPOSE_PROFILES=` để trống).

---

## 🚦 Điều kiện & ràng buộc (hiểu trước khi thao tác)

**Khi khởi động PROD**

- **Container prod từ chối khởi động nếu còn bí mật mẫu** — khi `APP_ENV=production`, `DB_PASSWORD` không được là `password`, và nếu `COMPOSE_PROFILES=db-local` thì `SC_DOCKER_DB_ROOT_PASSWORD` không được là `change_me_root`. Vì một site thật chạy với mật khẩu ai cũng biết là site bị chiếm. Kiểm tra này chỉ so đúng giá trị mẫu — không chấm "độ mạnh" mật khẩu thật, và không bao giờ chặn DEV.
- **Lệnh prod phải có `-f docker-compose.prod.yml`** — thiếu nó, Docker không báo lỗi mà dùng file DEV (bật debug, chạy root, cài Xdebug).
- **`APP_ENV` / `APP_DEBUG` bị ghim trong file compose** — sửa `.env` không đổi được giá trị bên trong container; điều này đảm bảo prod không thể vô tình chạy chế độ debug. `.env` vẫn cần hai dòng này cho lệnh chạy ngoài container.

**Khi cấu hình database**

- **MySQL đóng gói chỉ tạo database/user/mật khẩu root ở lần khởi động đầu tiên** (volume dữ liệu còn trống). Sửa `DB_*` hay `SC_DOCKER_DB_ROOT_PASSWORD` trong `.env` sau đó **không** làm MySQL thay đổi — phải sửa trong MySQL (`CREATE USER`, `ALTER USER`) hoặc reset volume.
- **Không đổi `DB_PORT`** để tránh trùng cổng giữa các dự án — `DB_PORT` là cổng bên trong network Docker, MySQL luôn nghe ở `3306`. Cổng phía host là `SC_DOCKER_DB_PORT`. (Hướng dẫn cũ từng ghi `DB_PORT=3307` cho dự án thứ 2 — nếu đã làm vậy: trả `DB_PORT=3306`, chuyển `3307` sang `SC_DOCKER_DB_PORT`, rồi `docker compose up -d`.)

**Khi đặt `SC_DOCKER_INSTANCE`**

- **Chỉ gồm chữ thường, số, `-`, `_`, bắt đầu bằng chữ hoặc số** — đây là quy tắc đặt tên project của Docker.
- **Chọn trước lần `up` đầu tiên.** Muốn đổi về sau: `docker compose down` **trước**, rồi mới sửa `.env` và `up -d`. Stack mới chạy trên **volume mới, trống** — dữ liệu cũ không mất, chỉ nằm lại trong volume mang tên cũ.

**Khi chạy lại `gp247:install`**

- Lệnh cài đặt ghi đè dữ liệu cửa hàng và một số file đã publish. **Sao lưu database và `app/GP247` trước** nếu site đã có dữ liệu hoặc tùy biến.

---

## ❓ Hỏi & Đáp (Q&A)

**Câu 1: `git pull` xong có phải build lại image không?**

→ Không. Code được bind-mount thẳng vào container nên có hiệu lực ngay. Chỉ build lại khi sửa file trong `docker/php/` — xem [mục 6](#-khi-nào-cần-build-lại--restart).

**Câu 2: Build lại hoặc xoá container có làm mất tùy biến và ảnh đã upload không?**

→ Không. `app/GP247`, `public/GP247`, `storage/app/public`… nằm trên đĩa của bạn. Chỉ `docker compose down -v` hoặc `docker volume rm` mới xoá dữ liệu MySQL — xem [mục 7](#-dữ-liệu-được-lưu-ở-đâu).

**Câu 3: `composer install` báo "process timeout" ở lần chạy đầu?**

→ Thường gặp trên Windows khi project nằm ở `/mnt/c/...` hoặc `/mnt/d/...`. Chạy lại `docker compose exec app composer install --no-interaction --optimize-autoloader` — chỉ cần xong một lần. Để nhanh hẳn, chuyển project vào filesystem của WSL2 (vd `~/projects/s-cart`).

**Câu 4: Trên Linux, file do container tạo ra thuộc root, sửa phải dùng `sudo`?**

→ DEV chạy `app` bằng root để tránh lỗi quyền. Muốn chạy bằng user của bạn, trong service `app` của `docker-compose.yml` đặt `build.args.WWWUSER`/`WWWGROUP` theo `id -u`/`id -g` và `environment.PHP_FPM_ALLOW_ROOT: "false"`, rồi `docker compose build app && docker compose up -d`. ⚠️ Trên Windows với project ở `/mnt/...`, cách này gây lỗi `touch(): Utime failed` — giữ mặc định root, hoặc chuyển project vào WSL2.

**Câu 5: Deploy prod bằng root, bị `Permission denied` khi ghi `composer.lock` / `vendor/`?**

→ `www-data` trong container chạy bằng UID `SC_DOCKER_WWWUSER` (mặc định `1000`) nên không ghi được file của root. Cấp quyền một lần bằng ACL (thay `1000` nếu bạn dùng UID khác):

```bash
apt-get install -y acl
cd /path/to/project
setfacl -R  -m u:1000:rwx .
setfacl -R -d -m u:1000:rwx .
```

Hoặc dành riêng một user UID 1000 để deploy và `chown -R 1000:1000 /path/to/project`.

**Câu 6: Container prod báo `[prod-guard] Refusing to start`?**

→ `.env` còn mật khẩu mẫu. Xem biến nào bằng `docker compose -f docker-compose.prod.yml logs app`, đặt mật khẩu thật (hoặc `COMPOSE_PROFILES=` nếu dùng DB từ xa), rồi `docker compose -f docker-compose.prod.yml up -d`. Nếu volume MySQL đã được tạo với mật khẩu mẫu, đổi thêm trong MySQL bằng `ALTER USER`.

**Câu 7: Lỡ chạy `docker compose up -d --build` trên prod mà quên `-f docker-compose.prod.yml`?**

→ Stack prod **không bị ảnh hưởng** — Docker chỉ dựng thêm một stack DEV riêng (tên không có `-prod`, volume riêng). Có thể bạn thấy lỗi trùng cổng thay vì bị ghi đè. Dừng stack DEV lỡ chạy bằng `docker compose -f docker-compose.yml down`, rồi kiểm tra prod bằng `docker compose -f docker-compose.prod.yml ps`.

**Câu 8: Sửa `DB_DATABASE`/mật khẩu trong `.env` mà MySQL không đổi?**

→ MySQL chỉ đọc các giá trị này ở lần khởi động đầu tiên. Thêm database/user bằng lệnh ở [mục 8](#-mysql-đóng-gói-sẵn), hoặc reset volume (mất dữ liệu).

**Câu 9: Log Nginx và PHP-FPM ở đâu?**

→ Nằm trong container, xem bằng `docker compose logs -f webserver` và `docker compose logs -f app`. Muốn có log Nginx trên máy, thêm volume `./storage/logs/nginx:/var/log/nginx` vào service `webserver` trong file compose.

**Câu 10: Làm sao dùng database từ xa thay cho MySQL đóng gói?**

→ Trong `.env`: `DB_HOST=your-remote-mysql-host` và `COMPOSE_PROFILES=` (để trống), rồi `docker compose up -d`. Container `mysql-local` sẽ không được tạo. Xem bảng ở bước 2 của [PROD](#-chạy-môi-trường-prod).

---

<sub>📅 **Cập nhật lần cuối:** 2026-09-29 · ✍️ **Tác giả (Author):** GP247</sub>
