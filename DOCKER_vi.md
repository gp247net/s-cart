# Hướng dẫn dùng Docker cho S-Cart (GP247 / Laravel 13)

*(English version: [DOCKER.md](DOCKER.md))*

Hướng dẫn này giúp bạn dựng S-Cart bằng Docker từ đầu, cả cho môi trường dev
trên máy cá nhân lẫn môi trường prod trên server. Làm theo đúng thứ tự các
bước bên dưới.

## Yêu cầu

- Docker Desktop (Windows/Mac) hoặc Docker Engine + Compose plugin (Linux)
- Đã có sẵn source code repo này trên máy (hoặc server)

---

## Phần 1 — Chạy môi trường DEV

**1. Copy file cấu hình môi trường**

```bash
cp .env.example .env
```

`.env.example` đã có sẵn cấu hình mặc định chạy được ngay (dùng MySQL đóng
gói sẵn trong Docker), không cần sửa gì thêm.

**2. Khởi động container**

```bash
docker compose up -d --build
```

Lệnh này build image PHP và khởi động toàn bộ: app, Nginx, MySQL, queue
worker, và scheduler.

**3. Cài đặt S-Cart**

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan sc:install
docker compose exec app php artisan sc:sample   # tùy chọn: thêm dữ liệu mẫu
```

**4. Truy cập website**

- Website: http://localhost:8000
- Vite dev server (hot-reload assets): http://localhost:5173

Có thể đổi cổng và thông tin database trong `.env` trước bước 2 — xem
`SC_DOCKER_APP_PORT`, `DB_*`, `COMPOSE_PROFILES`. Nếu muốn dùng database từ xa thay vì
database có sẵn, xem [Q: Làm sao để dùng database từ xa thay vì database có
sẵn?](#q-làm-sao-để-dùng-database-từ-xa-thay-vì-database-có-sẵn)

Vậy là xong — dev đã chạy. Các lệnh dùng hằng ngày xem ở [Phần 3](#phần-3--các-lệnh-dùng-hằng-ngày).

---

## Phần 2 — Chạy môi trường PROD

**1. Chuẩn bị `.env` trên server**

Copy `.env.example` thành `.env` và đặt tối thiểu các biến sau:

```env
APP_ENV=production
APP_DEBUG=false

# Database — chọn MỘT trong hai cách bên dưới
DB_CONNECTION=mysql
DB_HOST=your-remote-mysql-host   # hoặc "mysql-local" nếu dùng DB đóng gói sẵn — xem mục 4.2
DB_PORT=3306
DB_DATABASE=scart-db-prod
DB_USERNAME=scar-user
DB_PASSWORD=********

# Bắt buộc với prod: khớp với user thật mà Docker chạy trên server này
SC_DOCKER_WWWUSER=1000    # chạy `id -u` trên server
SC_DOCKER_WWWGROUP=1000   # chạy `id -g` trên server
```

**2. Khởi động container**

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

**3. Cài đặt S-Cart (chỉ lần đầu)**

```bash
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan sc:install
docker compose -f docker-compose.prod.yml exec app php artisan sc:sample   # tùy chọn
```

**4. Build assets frontend**

```bash
docker compose -f docker-compose.prod.yml run --rm node
```

Assets không được build sẵn trong image, nên chạy lệnh này một lần sau khi
cài đặt, và chạy lại mỗi khi CSS/JS thay đổi.

Vậy là website đã chạy. Hai lựa chọn database và giá trị `.env` chính xác
được nói kỹ ở Q&A: [Q: Prod có 2 lựa chọn database, `.env` mỗi lựa chọn cần
những gì?](#q-prod-có-2-lựa-chọn-database-env-mỗi-lựa-chọn-cần-những-gì)

Mọi lệnh ở trên đều ghi đầy đủ `-f docker-compose.prod.yml` có chủ đích.
Lệnh thiếu `-f` sẽ âm thầm rơi về `docker-compose.yml` (file DEV) thay vì
báo lỗi — xem [Q: Tôi lỡ tay chạy `docker compose up -d --build` trên prod
(quên `-f docker-compose.prod.yml`) — giờ chuyện gì xảy
ra?](#q-tôi-lỡ-tay-chạy-docker-compose-up-d---build-trên-prod-quên--f-docker-composeprodyml--giờ-chuyện-gì-xảy-ra)
để biết cụ thể hậu quả. Hãy copy nguyên các lệnh trên, không gõ lại theo
trí nhớ.

**(Tùy chọn) Rút gọn lệnh**

Nếu không muốn gõ `-f docker-compose.prod.yml` mỗi lần, có thể export biến
này một lần cho phiên shell:

```bash
export COMPOSE_FILE=docker-compose.prod.yml   # bash/zsh
# $env:COMPOSE_FILE = "docker-compose.prod.yml"   # PowerShell
```

Đây chỉ là tiện lợi cho phiên làm việc tương tác hiện tại — không tồn tại
khi đăng nhập SSH mới, mở tab terminal mới, chạy cron job, hoặc chạy script
deploy không tương tác. **Không được giả định biến này đã được export**
chỉ vì bạn (hoặc ai khác) đã export nó trước đây. Khi không chắc, khi viết
script, hoặc trong CI, luôn dùng dạng đầy đủ `-f docker-compose.prod.yml`
thay vì dựa vào `COMPOSE_FILE`.

---

## Phần 3 — Các lệnh dùng hằng ngày

Các lệnh dưới đây không ghi `-f` để ngắn gọn — chúng áp dụng cho môi trường
mà shell hiện tại của bạn đang nhắm tới. **Trên server production, thêm
`-f docker-compose.prod.yml` vào mọi lệnh `docker compose` dưới đây.**
Không giả định `COMPOSE_FILE` đã được export cho phiên shell này (xem lưu ý
ở Phần 2) — kiểm tra bằng `docker compose config --services` nếu không
chắc, hoặc cứ luôn gõ rõ `-f docker-compose.prod.yml`.

**Cập nhật code sau khi `git pull`:**

```bash
git pull
docker compose exec app composer install --no-interaction --optimize-autoloader   # nếu composer.lock đổi
docker compose run --rm node                                                       # nếu assets đổi
docker compose exec app php artisan migrate --force                                # nếu có migration mới
docker compose exec app php artisan config:cache
```

Không cần `docker compose build` hay `restart` với thay đổi code thông
thường — xem [Q: Khi nào thực sự cần build lại hoặc restart?](#q-khi-nào-thực-sự-cần-build-lại-hoặc-restart)

**Các lệnh thường dùng khác:**

```bash
# Chạy artisan bất kỳ
docker compose exec app php artisan <command>

# Xem log
docker compose logs -f app
docker compose logs -f webserver

# Vào shell container
docker compose exec app sh

# Dừng toàn bộ (dữ liệu vẫn giữ nguyên — xem Q&A)
docker compose down

# Sao lưu MySQL (khi dùng database có sẵn)
docker compose exec mysql-local mysqldump -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" scart > backup.sql

# Update dependency PHP
docker compose exec app composer update --no-interaction --optimize-autoloader
docker compose restart queue scheduler   # để các tiến trình nền nhận code mới
```

**Xem log Laravel:**

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

### Q: Vì sao `git pull` xong không cần build lại image Docker?

Vì image không hề đóng gói sẵn code ứng dụng. Toàn bộ thư mục project được
bind-mount thẳng từ máy bạn vào container:

```yaml
volumes:
  - ./:/var/www/html
```

Nên code mới trên đĩa có ngay trong container, không cần build lại. Image
chỉ chứa PHP-FPM và các extension; chỉ cần build lại khi bạn sửa
`docker/php/Dockerfile` (ví dụ đổi phiên bản PHP hoặc thêm extension).

### Q: Build lại hoặc tạo lại container có làm mất các tùy chỉnh của tôi (`app/GP247`, ảnh đã upload...) không?

Không. Vì toàn bộ project nằm trên đĩa của bạn (không nằm trong image), các
thư mục sau tự động được giữ nguyên, không cần cấu hình gì thêm:

- `app/GP247` — nơi bạn override controller, helper, plugin, template
- `public/GP247`, `public/vendor`
- `resources/views/vendor`
- `storage/app/public` — ảnh sản phẩm, file upload

Khi deploy sang server khác, chỉ cần đảm bảo các thư mục này đi cùng code
(git, rsync, hoặc backup riêng nếu không commit vào git).

### Q: Vì sao tôi không duyệt được `vendor/` hay `node_modules/` từ File Explorer?

`vendor/` và `node_modules/` là ngoại lệ duy nhất của bind-mount ở trên —
chúng nằm trong named volume riêng của Docker (`scart-vendor`,
`scart-node-modules`) thay vì bind-mount từ host:

```yaml
volumes:
  - ./:/var/www/html
  - scart-vendor:/var/www/html/vendor
```

Hai thư mục này chứa hàng chục nghìn file nhỏ (riêng `aws-sdk-php` đã có
khoảng 150 định nghĩa package). Đọc/ghi lượng file nhỏ như vậy qua
**bind-mount từ ổ Windows** chậm tới mức `composer install`/`npm ci` có thể
bị timeout. Named volume nằm trong storage Linux gốc của Docker nên nhanh
hơn nhiều — và vẫn được giữ nguyên qua các lần tạo lại container/build lại
image (chỉ mất khi chạy `docker compose down -v`). Đánh đổi là bạn không
duyệt trực tiếp được hai thư mục này từ host, nhưng không sao vì vốn dĩ
không nên tự sửa tay chúng.

Dữ liệu MySQL cũng được lưu ở named volume riêng
(`scart-mysql-local-data-dev` / `scart-mysql-local-data-prod`), nên cũng
không mất khi `docker compose down` (chỉ mất khi `docker compose down -v`).

Cả 3 volume của prod (`scart-vendor`, `scart-node-modules`,
`scart-mysql-local-data-prod`) đã được ghim `name:` cố định trong
`docker-compose.prod.yml` (từ modification `20260709T090000`), đúng y
nguyên các literal string trên — độc lập với tên project, nên không đổi
khi tên project đổi.

> **Đang nâng cấp một deployment prod đã chạy từ trước khi có việc ghim
> tên này?** Chạy `docker volume ls` **trước khi** pull
> `docker-compose.prod.yml` mới, xác nhận tên volume thực tế đã khớp các
> tên trên. Nếu deployment hiện tại có tên volume dạng có prefix project
> (vd `scart_scart-mysql-local-data-prod`), hãy đổi tên volume đó để khớp
> (hoặc sao chép dữ liệu sang volume mới) hoặc sửa lại `name:` trong
> `docker-compose.prod.yml` cho khớp với volume hiện có trước khi chạy
> `up` — để MySQL không bị mount vào một volume mới trống rỗng.
> `vendor`/`node_modules` thì an toàn trong mọi trường hợp — tự rebuild lại
> khi container khởi động (xem `docker/php/entrypoint.sh`).

### Q: `composer install` báo lỗi "process timeout" ở lần chạy đầu — xử lý sao?

Triệu chứng:

```
Install of aws/aws-sdk-php failed
The following exception is caused by a process timeout
...exceeded the timeout of 300 seconds.
```

Lỗi này xảy ra trên Windows khi project nằm trên ổ Windows mount vào WSL2
(ví dụ `/mnt/d/...`) — I/O qua cầu nối đó chậm với các package nhiều file
nhỏ. `docker/php/Dockerfile` đã tăng sẵn timeout
(`COMPOSER_PROCESS_TIMEOUT=900`) và đưa `vendor/`/`node_modules/` ra khỏi
bind-mount chậm (xem Q&A phía trên), nhưng nếu vẫn gặp lỗi:

- Chạy lại là được, chỉ cần hoàn tất một lần:
  `docker compose exec app composer install --no-interaction --optimize-autoloader`
- Để có hiệu năng I/O tốt nhất, nên đặt project trong filesystem gốc của
  WSL2 (ví dụ `~/projects/s-cart-project`) thay vì dưới `/mnt/c/...` hay
  `/mnt/d/...`, rồi mở từ Windows qua `\\wsl$\<distro>\...` hoặc extension
  WSL Remote của VS Code.

### Q: Làm sao để dùng database từ xa thay vì database có sẵn?

Việc container `mysql-local` có khởi động hay không được điều khiển bằng
`COMPOSE_PROFILES` trong `.env`. Để bỏ nó và trỏ sang database từ
xa/managed:

```env
DB_HOST=your-remote-mysql-host
COMPOSE_PROFILES=
```

Muốn dùng database có sẵn, đặt `COMPOSE_PROFILES=db-local` và
`DB_HOST=mysql-local` (đây là mặc định của `.env.example` cho dev).

### Q: Prod có 2 lựa chọn database, `.env` mỗi lựa chọn cần những gì?

**Lựa chọn A — Database từ xa/managed (mặc định, ví dụ RDS/Cloud SQL):**

```env
DB_CONNECTION=mysql
DB_HOST=your-remote-mysql-host
DB_PORT=3306
DB_DATABASE=scart-db-prod
DB_USERNAME=scar-user
DB_PASSWORD=********
COMPOSE_PROFILES=
```

Container `mysql-local` sẽ không được tạo.

**Lựa chọn B — MySQL đóng gói trong Docker:**

```env
DB_CONNECTION=mysql
DB_HOST=mysql-local
DB_PORT=3306
DB_DATABASE=scart-db
DB_USERNAME=scar-user
DB_PASSWORD=********
SC_DOCKER_DB_ROOT_PASSWORD=********
COMPOSE_PROFILES=db-local
```

Dù chọn cách nào, khởi động bằng cùng một lệnh:

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

### Q: Khi nào thực sự cần build lại hoặc restart?

Quy tắc chung: file bị **copy vào image** (trong `docker/php/Dockerfile`)
thì sửa xong phải build lại. File chỉ được **mount** (nginx/mysql conf,
`docker-compose*.yml`) chỉ cần recreate/restart container, không cần build.
Code ứng dụng (PHP, blade, JS, CSS) không cần cái nào cả, nhờ bind-mount và
`opcache.validate_timestamps=1`.

| Thay đổi | Cần build lại? | Cần restart/recreate? | Lệnh cần chạy |
|---|---|---|---|
| `docker/php/Dockerfile` (đổi PHP version, thêm extension) | **Có** | Có | `docker compose build app && docker compose up -d` |
| `docker/php/php.ini` | **Có** | Có | `docker compose build app && docker compose up -d` |
| `docker/php/entrypoint.sh` | **Có** | Có | `docker compose build app && docker compose up -d` |
| Biến `.env` dùng làm build arg (`SC_DOCKER_PHP_VERSION`, `SC_DOCKER_WWWUSER`, `SC_DOCKER_WWWGROUP`, `SC_DOCKER_INSTALL_XDEBUG`) | **Có** | Có | `docker compose up -d --build` |
| Biến `.env` chỉ dùng runtime (`APP_ENV`, `APP_DEBUG`, `DB_HOST`, `SC_DOCKER_APP_PORT`...) | Không | Có | `docker compose up -d` |
| `docker-compose.yml` / `docker-compose.prod.yml` (thêm service, đổi volume/command) | Không | Có | `docker compose up -d` |
| `docker/nginx/default.conf` | Không | Có | `docker compose restart webserver` |
| `docker/mysql/my.cnf` | Không | Có | `docker compose restart mysql` |
| Code PHP/blade ứng dụng | Không | **Không** | Không cần gì (chạy lại `config:cache` nếu bạn dùng) |
| `composer.json` / `composer.lock` | Không | Không | `docker compose exec app composer install ...` |
| `package.json` / assets JS-CSS | Không | Không | `docker compose run --rm node` |
| Migration mới | Không | Không | `docker compose exec app php artisan migrate --force` |

**Lưu ý:** nếu bạn đã chạy `php artisan config:cache` trước đó, thay đổi
trong `.env` sẽ không có tác dụng cho tới khi chạy lại `config:cache` (hoặc
`config:clear`) — việc này không liên quan gì tới Docker.

### Q: Tôi gặp lỗi quyền ghi file — nguyên nhân là gì?

Mặc định ở dev, container `app` chạy dưới quyền root, chủ đích để bạn không
gặp lỗi permission khi bind-mount bất kể hệ điều hành nào. Đánh đổi: file do
container tạo ra (log, view đã compile, file publish) sẽ thuộc sở hữu root
trên đĩa. Điều này vô hình trên WSL2/Windows, nhưng trên **Linux gốc** có
thể cần `sudo` để sửa/xóa các file đó từ ngoài container.

Nếu điều này gây khó chịu trên Linux gốc, sửa service `app` trong
`docker-compose.yml`:

```yaml
build:
  args:
    WWWUSER: "1000"   # `id -u` của bạn
    WWWGROUP: "1000"  # `id -g` của bạn
environment:
  PHP_FPM_ALLOW_ROOT: "false"
```

rồi:

```bash
docker compose build app
docker compose up -d
```

(Đây cũng chính là cách prod luôn dùng — xem Phần 2.)

⚠️ Trên Windows, nếu bạn đổi sang user không phải root theo cách trên **và**
project nằm trên ổ Windows mount vào WSL2 (`/mnt/c/...`, `/mnt/d/...`), bạn
sẽ gặp lỗi `touch(): Utime failed: Operation not permitted` từ Blade
compiler của Laravel — cầu nối WSL2 cho đường dẫn ổ Windows không hỗ trợ
`utime()` với UID không phải root. Cách sửa: quay lại mặc định hardcode
root, hoặc chuyển project vào filesystem gốc của WSL2.

### Q: Tôi deploy prod bằng root và bị `Permission denied` khi ghi `composer.lock`/`vendor/` — sửa sao?

Triệu chứng:

```
file_put_contents(./composer.lock): Failed to open stream: Permission denied
```

Nguyên nhân: ở prod, `www-data` trong container chạy dưới UID/GID lấy từ
`SC_DOCKER_WWWUSER`/`SC_DOCKER_WWWGROUP` (mặc định `1000`). Nếu bạn deploy/`git pull` bằng
**root**, file project trên host thuộc sở hữu root, `www-data` không có
quyền ghi vào đó.

**Cách sửa khuyến nghị** — thiết lập ACL mặc định một lần, để mọi file mới
root tạo ra sau này tự động ghi được bởi UID 1000:

```bash
apt-get install -y acl
cd /path/to/project
setfacl -R  -m u:1000:rwx .
setfacl -R -d -m u:1000:rwx .
```

Sau đó cứ tiếp tục deploy bằng root như bình thường — không cần `chown`
lại. Thay `1000` bằng đúng `SC_DOCKER_WWWUSER` bạn đang dùng nếu khác mặc định.

**Cách khác** — đổi hẳn owner (chỉ hợp lý nếu bạn có thể dành riêng một user
UID 1000 cho việc deploy, vì mọi lần ghi sau đó đều phải dùng đúng user
này):

```bash
chown -R 1000:1000 /path/to/project
```

### Q: Chạy lại `sc:install` có ghi đè các file tôi đã tùy chỉnh không?

- Nếu file đích chưa tồn tại: được tạo mới bình thường.
- Nếu đã tồn tại: có bị ghi đè hay không tùy lệnh publish bên dưới có dùng
  `--force` hay không (chỉ `gp247:core-install` dùng — xem
  [Install.php](app/Console/Commands/Install.php:33)). Đây là hành vi vốn
  có của S-Cart, giống hệt khi không dùng Docker.
  **Hãy backup `app/GP247` trước khi chạy lại `sc:install`** nếu bạn đã
  tùy chỉnh nó.
- Trên Linux host, file mới publish mang UID/GID của container (map theo
  `SC_DOCKER_WWWUSER`/`SC_DOCKER_WWWGROUP`) — có thể cần `chown` để sửa nếu khác user của bạn
  (đọc thì vẫn được vì file publish thường world-readable).

### Q: Các log khác nằm ở đâu, xem thế nào?

`storage/logs/laravel.log` đã nằm sẵn trên host (xem Phần 3). Hai log khác
thì **không**, vì chưa được mount ra ngoài theo mặc định:

| Log | Ở đâu | Cách xem |
|---|---|---|
| Nginx access/error | Bên trong container `webserver` | `docker compose logs -f webserver` |
| PHP-FPM stdout/stderr | Bên trong container `app` | `docker compose logs -f app` |

Muốn xem cả log Nginx trên host, thêm volume này vào service `webserver`
trong `docker-compose.yml`:

```yaml
volumes:
  - ./storage/logs/nginx:/var/log/nginx
```

Mẹo: đổi sang xoay vòng log theo ngày bằng `LOG_STACK=daily` trong `.env`
để tránh một file `laravel.log` phình to mãi.

### Q: MySQL đóng gói trong Docker lấy đâu ra tên database/user để tạo?

Từ `.env` của bạn, Compose chuyển các giá trị này vào container
`mysql-local`:

| Biến `.env` | Trở thành | Mặc định ở dev nếu không set |
|---|---|---|
| `DB_DATABASE` | `MYSQL_DATABASE` | `scart` |
| `DB_USERNAME` | `MYSQL_USER` | `scart` |
| `DB_PASSWORD` | `MYSQL_PASSWORD` | `secret` |
| `SC_DOCKER_DB_ROOT_PASSWORD` | `MYSQL_ROOT_PASSWORD` | `root_secret` |

(Prod không có mặc định — bắt buộc set đủ cả 4 biến.) Vì Laravel cũng đọc
các biến `DB_*` của mình từ đúng file `.env` này, chúng luôn tự khớp nhau.
Chỉ cần nhớ đặt `DB_HOST=mysql-local` (tên service trong Compose, không
phải hostname thật) khi dùng database có sẵn.

**Quan trọng:** MySQL chỉ chạy bước tạo này **đúng một lần**, vào lần khởi
động đầu tiên khi volume dữ liệu còn trống. Nếu bạn sửa
`DB_DATABASE`/user/password trong `.env` *sau khi* đã từng khởi động, sẽ
không có gì thay đổi trong container — volume cũ vẫn giữ giá trị cũ.

Để kiểm tra thực tế bên trong container đang chạy:

```bash
docker compose exec mysql-local mysql -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" -e "SHOW DATABASES;"
```

Nếu không khớp với `.env`, hoặc thêm phần còn thiếu mà không đụng dữ liệu
hiện có:

```bash
docker compose exec mysql-local mysql -u root -p"$SC_DOCKER_DB_ROOT_PASSWORD" -e \
  "CREATE DATABASE IF NOT EXISTS your_db; \
   CREATE USER IF NOT EXISTS 'your_user'@'%' IDENTIFIED BY 'your_pass'; \
   GRANT ALL ON your_db.* TO 'your_user'@'%';"
```

hoặc reset toàn bộ (⚠️ mất hết dữ liệu trong volume đó):

```bash
docker compose down
docker volume rm scart-mysql-local-data-dev   # hoặc scart-mysql-local-data-prod
docker compose up -d
```

### Q: Tôi lỡ tay chạy `docker compose up -d --build` trên prod (quên `-f docker-compose.prod.yml`) — giờ chuyện gì xảy ra?

**Từ modification `20260709T090000` (RISK-OPS-006 / NFR-SEC-005 / ADR
`installer-deploy_docker-dev-prod-safeguards`), lỗi này không còn ghi đè
âm thầm container/image prod đang chạy nữa.** Dev (`docker-compose.yml`) và
prod (`docker-compose.prod.yml`) nay dùng project name khác nhau (`scart`
vs `scart-prod`), image tag khác nhau (`scart-app:${SC_DOCKER_PHP_VERSION}` vs
`scart-app:${SC_DOCKER_PHP_VERSION}-prod`), và tên container khác nhau (mọi container
prod đều có hậu tố `-prod`). Ràng buộc tên container duy nhất của Docker
không còn thể bị "đụng" giữa hai môi trường.

Thực tế sẽ xảy ra nếu bạn chạy lệnh dev trên host đang chạy sẵn stack prod:

- Một **stack dev độc lập, tên hoàn toàn khác** (`scart-app`, `scart-nginx`,
  ... — không có hậu tố `-prod`) khởi động song song với stack prod vẫn
  đang chạy nguyên vẹn (`scart-app-prod`, `scart-nginx-prod`, ...). Không có
  gì ở container hay image tag prod bị đổi.
- Bạn có thể gặp **xung đột cổng** thay vì bị ghi đè (nếu `SC_DOCKER_APP_PORT`/
  `DB_PORT`/`SC_DOCKER_VITE_PORT` của cả hai stack trùng cổng host) — Docker sẽ báo
  lỗi rõ ràng và từ chối chạy service dev bị trùng, không âm thầm thay thế
  bất cứ thứ gì.
- Volume MySQL đóng gói cũng tách biệt hoàn toàn
  (`scart-mysql-local-data-dev` vs `scart-mysql-local-data-prod`, cả hai
  đều được ghim `name:` cố định trong file compose tương ứng), nên cũng
  không còn rủi ro app prod bị trỏ nhầm vào volume dev rỗng.

**Cách sửa — chỉ cần dừng stack dev lỡ chạy** (phía prod không hề bị động
tới, không cần build lại gì):

```bash
docker compose -f docker-compose.yml down
```

Muốn kiểm tra chắc chắn phía prod không bị ảnh hưởng:

```bash
docker compose -f docker-compose.prod.yml ps   # container prod, vẫn -prod, vẫn đang chạy
docker images | grep scart-app                  # scart-app:<ver> (dev) và scart-app:<ver>-prod (prod) là 2 image khác nhau
```

### Q: Tôi có thể chạy nhiều dự án S-Cart độc lập trên cùng một host không? (multi-instance)

Có. Docker vốn cô lập các stack theo *project name*, và các file compose nay
sinh mọi định danh phạm vi-host từ **một biến `SC_DOCKER_INSTANCE`**, nên mỗi dự án có
container/image tag/volume dữ liệu riêng, không đụng nhau.

**Mặc định (không set `SC_DOCKER_INSTANCE`) mọi thứ y như cũ** — project vẫn là
`scart`/`scart-prod`, container vẫn `scart-app`…, volume vẫn `scart-vendor`…
Deployment single-instance đang chạy **không đổi tên, không phải migrate dữ liệu**.

Để thêm dự án thứ 2 (thứ 3, …) trên cùng host:

1. Đặt mỗi dự án trong **thư mục riêng** (mỗi thư mục bind-mount `./` là app root
   của chính nó).
2. Trong `.env` của dự án đó, đặt slug **duy nhất** và **cổng riêng**:

   ```env
   SC_DOCKER_INSTANCE=shopa          # duy nhất mỗi dự án: shopa, shopb, …
   SC_DOCKER_APP_PORT=8001           # cổng host khác nhau mỗi dự án
   SC_DOCKER_VITE_PORT=5174
   DB_PORT=3307
   ```

3. Khởi động như thường (`docker compose up -d --build`, hoặc thêm
   `-f docker-compose.prod.yml` cho prod).

`SC_DOCKER_INSTANCE` scope tất cả cùng lúc nên 2 instance không bao giờ đụng nhau:

| Định danh | `SC_DOCKER_INSTANCE` bỏ trống (mặc định) | `SC_DOCKER_INSTANCE=shopa` |
|---|---|---|
| Project name (dev / prod) | `scart` / `scart-prod` | `shopa` / `shopa-prod` |
| Tên container | `scart-app`, `scart-nginx`, … | `shopa-app`, `shopa-nginx`, … |
| Image tag (dev / prod) | `scart-app:8.3` / `…-prod` | `scart-app:8.3-shopa` / `…-shopa-prod` |
| Volume ghim tên (prod) | `scart-vendor`, `scart-mysql-local-data-prod`, … | `shopa-vendor`, `shopa-mysql-local-data-prod`, … |

Nhờ vậy mỗi instance có **volume MySQL riêng** — không có cách nào để dự án này
mount trúng database của dự án kia (xem RISK-OPS-009). Cơ chế này kết hợp với việc
tách dev/prod ở câu hỏi trước: định danh luôn là `<instance>-<env>`, và
`SC_DOCKER_INSTANCE=scart` (mặc định) tái tạo đúng tên cũ.

**Quản cổng khi nhiều site — dùng reverse proxy.** Cấp cổng thủ công sẽ mệt khi
có nhiều site. Ở prod, đặt trước các stack một reverse proxy (Traefik, Caddy, hoặc
Nginx chạy trên host) chỉ publish `80`/`443` và route theo domain tới container
`webserver` nội bộ của từng instance. Khi đó các stack không cần publish
`SC_DOCKER_APP_PORT` ra host (bind loopback hoặc bỏ publish), lại có TLS tập trung. Đây là
bố cục khuyến nghị để host nhiều site khách trên một máy.

**Trần tài nguyên.** Mỗi instance ~4–6 container (app, nginx, queue, scheduler,
và tùy chọn mysql + node), nên RAM/CPU tăng theo số instance — VPS nhỏ chỉ chứa
được vài cái. Muốn nhồi nhiều hơn, cho các instance trỏ về **DB dùng chung/managed**
(mỗi cái một `DB_DATABASE`, `COMPOSE_PROFILES=` để không bật `mysql-local` riêng)
thay vì mỗi stack một MySQL. Xem NFR-SCAL-003 / NFR-SCAL-001.

### Q: Kiến trúc gồm những service nào?

| Service | Vai trò | Image |
|---------|---------|-------|
| `app` | PHP-FPM chạy Laravel | build từ `docker/php` |
| `webserver` | Nginx, phục vụ `public/`, forward `.php` sang `app` | `nginx:1.27-alpine` |
| `queue` | `php artisan queue:work` (email, job nền) | dùng chung image `app` |
| `scheduler` | Vòng lặp gọi `php artisan schedule:run` mỗi 60s | dùng chung image `app` |
| `mysql-local` | MySQL 8.4 (tùy chọn) | `mysql:8.4` |
| `node` | Build/dev assets (Vite) — chạy khi cần | `node:22-alpine` |

Chỉ duy nhất `app` được build riêng; nginx/mysql/node dùng image chính
thức, chỉ mount file cấu hình vào.
