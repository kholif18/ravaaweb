# RavaaWeb — Ravaa Creative Website

Website company profile + e-commerce untuk **Ravaa Creative**, dibangun dengan Laravel 11.

---

## 📋 Daftar Isi

- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi dengan Docker (Production)](#instalasi-dengan-docker-production)
- [Instalasi di Host (Manual)](#instalasi-di-host-manual)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Seed Data Awal](#seed-data-awal)
- [Penggunaan Sehari-hari](#penggunaan-sehari-hari)
- [Struktur Direktori](#struktur-direktori)

---

## Persyaratan Sistem

### Opsi A — Docker
- **Docker** 24+ & **Docker Compose** v2
- Port `80` tersedia (atau sesuaikan di `.env`)

### Opsi B — Host (Manual)
- **PHP** 8.3–8.4
- **Composer** 2.x
- **MariaDB** 10.6+ / MySQL 8+
- **Redis** 7+ (opsional, untuk cache & session)
- **Node.js** 20+ & **NPM** (jika dibutuhkan build frontend)

---

## Instalasi dengan Docker (Production)

Ini adalah cara yang **direkomendasikan** — semua dependensi sudah terbungkus dalam container.

### 1. Clone project

```bash
git clone https://github.com/kholif18/RavaaWeb.git
cd RavaaWeb
```

### 2. Setup environment

```bash
cp .env.example .env
nano .env   # isi konfigurasi database dan lainnya
```

**Isi minimal yang wajib diisi:**

| Variabel | Contoh | Keterangan |
|---|---|---|
| `APP_KEY` | *(lihat cara generate di bawah)* | Wajib — jangan dikosongkan |
| `DB_PASSWORD` | `rahasia123` | Password database MariaDB |
| `APP_URL` | `http://domain-anda.com` | URL tempat aplikasi diakses |

**Port (opsional):** secara default aplikasi berjalan di port **80**. Kalau ingin port lain (misal `8020` biar tidak bentrok), tambahkan di `.env`:
```env
APP_PORT=8020
APP_URL=http://localhost:8020
```

### 3. Generate APP KEY

```bash
# Opsi A — pake container development (recommended)
docker run --rm -v $(pwd):/app -w /app composer:latest php artisan key:generate

# Opsi B — langsung dengan PHP (kalau terinstall di host)
php artisan key:generate

# Opsi C — manual
echo "APP_KEY=base64:$(openssl rand -base32)" >> .env
```

Hasilnya akan otomatis tertulis di file `.env`.

### 4. Jalankan stack

```bash
docker compose up -d
```

Perintah ini akan menjalankan 3 container:
| Container | Fungsi |
|---|---|
| `RavaaWeb-prod` | Aplikasi Laravel (Apache + PHP 8.4) |
| `RavaaWeb-redis` | Cache & session (Redis 7) |
| `RavaaWeb-db` | Database (MariaDB 11) |

### 5. Seed data awal

```bash
docker compose exec app php artisan db:seed --force
```

### 6. Akses

Buka `http://localhost` (atau `http://localhost:8020` jika menggunakan port 8020, sesuaikan dengan `APP_URL`).

Login admin: `http://localhost/admin/login` (sesuaikan port bila perlu)

---

## Instalasi di Host (Manual)

Cara ini digunakan jika tidak menggunakan Docker.

### 1. Clone & masuk direktori

```bash
git clone https://github.com/kholif18/RavaaWeb.git
cd RavaaWeb
```

### 2. Install dependensi PHP

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
nano .env   # sesuaikan database, redis, dll
```

### 4. Konfigurasi database

Buat database MariaDB/MySQL, lalu atur di `.env`:

```
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ravaaweb
DB_USERNAME=root
DB_PASSWORD=rahasia123
```

### 5. Setup Redis (opsional tapi disarankan)

Install Redis, lalu atur di `.env`:

```
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
CACHE_STORE=redis
SESSION_DRIVER=redis
```

> Kalau Redis tidak tersedia, bisa pakai fallback:
> ```
> CACHE_STORE=file
> SESSION_DRIVER=database
> ```

### 6. Migrasi & seed

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 7. Storage link

```bash
php artisan storage:link
```

### 8. Optimasi Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 9. Web server (Apache/Nginx)

**Apache:**
```apache
<VirtualHost *:80>
    ServerName ravaaweb.local
    DocumentRoot /path/to/RavaaWeb/public

    <Directory /path/to/RavaaWeb/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name ravaaweb.local;
    root /path/to/RavaaWeb/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 10. Queue worker (background jobs)

```bash
php artisan queue:work --queue=high,default --sleep=3 --tries=3
```

> Untuk production, jalankan sebagai **service systemd** atau gunakan **Supervisor**.

### 11. Schedule cron

Tambahkan ke crontab (`crontab -e`):

```
* * * * * cd /path/to/RavaaWeb && php artisan schedule:run >> /dev/null 2>&1
```

---

## Konfigurasi Environment

File `.env.example` berisi semua variabel yang tersedia:

| Variabel | Default | Keterangan |
|---|---|---|
| `APP_ENV` | `production` | Jangan ubah ke `local` di production |
| `APP_DEBUG` | `false` | Matikan debug di production |
| `APP_KEY` | — | **Wajib** — generate dengan `php artisan key:generate` |
| `APP_URL` | `http://localhost` | URL publik aplikasi |
| `DB_HOST` | `mariadb` | Host database (`127.0.0.1` di host, `mariadb` di Docker) |
| `DB_PORT` | `3306` | Port database |
| `DB_DATABASE` | `web` | Nama database |
| `DB_USERNAME` | `root` | User database |
| `DB_PASSWORD` | — | Password database |
| `REDIS_HOST` | `redis` | Host Redis (`127.0.0.1` di host, `redis` di Docker) |
| `REDIS_PORT` | `6379` | Port Redis |
| `CACHE_STORE` | `redis` | Driver cache (`redis`, `file`, `database`) |
| `SESSION_DRIVER` | `redis` | Driver session (`redis`, `database`, `file`) |
| `MAIL_MAILER` | `log` | Driver mail (`log`, `smtp`, dll) |
| `QUEUE_CONNECTION` | `database` | Driver queue (`database`, `redis`) |
| `FILESYSTEM_DISK` | `local` | Driver storage (`local`, `s3`) |

---

## Seed Data Awal

Setelah migrasi, jalankan seeder untuk mengisi data awal:

```bash
php artisan db:seed --force
```

Data yang akan dibuat:

| Seeder | Data | Jumlah |
|---|---|---|
| `SettingSeeder` | Pengaturan umum (nama toko, kontak, sosial media, hero, SEO) | ~20 item |
| `ServiceSeeder` | Layanan (Desain Grafis, Percetakan, Custom Invitations, ATK, Sablon, Software House) | 6 item |
| `PortfolioSeeder` | Portofolio proyek | 6 item |
| `BannerSeeder` | Banner hero slider | 3 item |
| **User & Role** | Admin user + role admin | 1 user, 1 role |

### Login admin default

| Field | Value |
|---|---|
| URL | `http://localhost/admin/login` (sesuaikan port bila perlu) |
| Email | `admin@example.com` |
| Password | `secret` |

> **⚠️ Ganti password segera setelah pertama login!**

---

## Penggunaan Sehari-hari

### Melihat log aplikasi

```bash
# Docker
docker compose logs -f app
docker compose logs -f redis
docker compose logs -f mariadb

# Host
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log
```

### Backup database

```bash
# Docker
docker compose exec mariadb mysqldump -u root -p web > backup-$(date +%Y%m%d).sql

# Host
mysqldump -u root -p web > backup-$(date +%Y%m%d).sql
```

### Restart stack

```bash
docker compose restart
```

### Update aplikasi

```bash
git pull origin main
docker compose build --no-cache app
docker compose up -d
```

### Menjalankan test

```bash
# Docker (clear config cache dulu karena environment testing)
docker compose exec app php artisan config:clear
docker compose exec app php artisan test

# Host
php artisan config:clear
php artisan test
```

> **Catatan:** Config cache production menimpa env testing (sqlite). Selalu `config:clear` sebelum `php artisan test`.

---

## Struktur Direktori

```
RavaaWeb/
├─ .docker/               # Konfigurasi Docker (php.ini, vhost, entrypoint)
├─ app/                   # Kode aplikasi (Controllers, Models, Services)
├─ bootstrap/             # Bootstrapping & cache
├─ config/                # Konfigurasi Laravel
├─ database/              # Migrations, seeders, factories
├─ public/                # Document root (index.php, assets)
├─ resources/             # Views (Blade), bahasa
├─ routes/                # Route definitions (web.php)
├─ storage/               # Log, cache, uploads, session
├─ tests/                 # Unit & Feature tests
├─ Dockerfile             # Production Docker image
├─ docker-compose.yml     # Production stack (app + redis + mariadb)
└─ .env.example           # Template environment variables
```

---

## Teknologi

| Stack | Teknologi |
|---|---|
| **Backend** | Laravel 11 (PHP 8.4) |
| **Database** | MariaDB 11 |
| **Cache & Session** | Redis 7 |
| **Web Server** | Apache 2.4 |
| **Frontend** | Blade + CSS/JS (Vite) |
| **Container** | Docker + Docker Compose |
| **Auth** | Spatie Laravel Permission |
