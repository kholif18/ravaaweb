# RavaaWeb — Deploy ARM64 (Odroid N2 / Armbian 26)

## Spesifikasi Target

| Komponen | Nilai |
|---|---|
| Device | Odroid N2 (Amlogic S922X) |
| OS | Armbian 26.5.1 (Noble/Ubuntu 24.04) |
| Kernel | 6.6.58-ophub |
| Arch | ARM64 (AArch64) — `linux/arm64/v8` |
| RAM | 1.75 GB (1.1 GB free) |
| Storage | 6.5 GB (~2.3 GB free) |
| IP LAN | `192.168.40.10` |

## Prasyarat

```bash
# Cek Docker sudah terinstall
docker --version
docker compose version

# Cek platform
uname -m
# → aarch64
```

## 1. Clone Repository

```bash
cd /opt
git clone <repo-url> RavaaWeb
cd RavaaWeb
```

## 2. Siapkan Environment

```bash
cp .env.example .env
# Edit .env — isi APP_KEY, DB_PASSWORD, dll
nano .env
```

Setidaknya isi:

```ini
APP_KEY=base64:xxxxxxxxxxxxxx     # generate via: php artisan key:generate
DB_PASSWORD=rahasia123
APP_URL=http://192.168.40.10:8020
```

## 3. Build & Jalankan

```bash
# Build image ARM64 (proses ~10-15 menit di Odroid N2)
docker compose -f docker-compose.arm.yml build

# Jalankan
docker compose -f docker-compose.arm.yml up -d

# Cek status
docker compose -f docker-compose.arm.yml ps
docker compose -f docker-compose.arm.yml logs -f
```

## 4. Akses

| URL | Keterangan |
|---|---|
| `http://192.168.40.10:8020` | Website publik |
| `http://192.168.40.10:8020/admin` | Panel admin |

## 5. Resource Limits

Konfigurasi di `docker-compose.arm.yml` sudah diset:

| Service | Max RAM | Max CPU |
|---|---|---|
| App (PHP+Apache) | 512 MB | 2 core |
| MariaDB | 256 MB | 1 core |

**Total:** 768 MB RAM + 3 CPU core — cocok untuk Odroid N2 dengan 1.75GB RAM.

## 6. Perawatan

```bash
# Upgrade image (re-build)
docker compose -f docker-compose.arm.yml build --no-cache
docker compose -f docker-compose.arm.yml up -d

# Backup database
docker exec RavaaWeb-db mariadb-dump -u ravaa -p ravaaweb > backup.sql

# Hapus
docker compose -f docker-compose.arm.yml down -v
```

## Catatan

- **JIT diaktifkan** di `opcache.arm.ini` (64M buffer) — PHP 8.4+ mendukung JIT di ARM64
- **Memory limit PHP** 128M — cukup untuk Laravel dengan 1.75GB RAM
- **Port 8020** — menghindari konflik dengan service lain di perangkat
- Platform eksplisit `linux/arm64` di compose — memastikan pull image yang benar
