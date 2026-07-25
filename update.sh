#!/bin/bash
set -e

BRANCH="main"

# Deteksi versi Docker Compose — support V1 (docker-compose) dan V2 (docker compose)
if docker compose version &>/dev/null 2>&1; then
    DC="docker compose"
elif command -v docker-compose &>/dev/null; then
    DC="docker-compose"
else
    echo "[ERROR] Docker Compose tidak ditemukan. Install dulu: https://docs.docker.com/compose/install/"
    exit 1
fi
echo "    Menggunakan: $DC"

echo "========================================="
echo "  RavaaWeb — Update & Redeploy"
echo "========================================="

# ── 1. Backup database ────────────────────────
echo ""
echo "==> [1/5] Backing up database..."
BACKUP_FILE="/tmp/ravaaweb_backup_$(date +%Y%m%d_%H%M%S).sql"
$DC exec -T mariadb mysqldump \
    -u"${DB_USERNAME:-root}" -p"${DB_PASSWORD}" "${DB_DATABASE:-web}" \
    > "$BACKUP_FILE" 2>/dev/null && \
    echo "    Database backed up: $BACKUP_FILE ($(du -sh "$BACKUP_FILE" | cut -f1))" || \
    echo "    [WARN] Database backup skipped (container mungkin belum jalan)"

# ── 2. Sync ke git — abaikan local changes ───
echo ""
echo "==> [2/5] Pulling latest changes from git..."
# Buang local changes agar server selalu sinkron dengan git
# (jangan edit file langsung di server — semua perubahan harus lewat git)
git fetch origin "$BRANCH"
git stash push --include-untracked -m "auto-stash before update $(date +%Y%m%d_%H%M%S)" 2>/dev/null || true
git reset --hard "origin/$BRANCH"
echo "    HEAD: $(git log -1 --oneline)"

# ── 3. Build image baru ───────────────────────
echo ""
echo "==> [3/5] Building container..."
$DC build app

# ── 4. Restart container ──────────────────────
echo ""
echo "==> [4/5] Restarting container (skip DB migrate/seed)..."
APP_SKIP_DB=true $DC up -d

# Tunggu sebentar agar container fully up
sleep 3

# ── 5. Fix permissions ────────────────────────
echo ""
echo "==> [5/5] Fixing file permissions..."
# Ownership proyek ke user host agar bisa diedit via VS Code / SSH
sudo chown -R ravaa:ravaa /var/www/RavaaWeb
# storage/framework harus dimiliki www-data agar Laravel bisa write cache view
# Tanpa ini: touch(): Utime failed: Operation not permitted (500 error)
$DC exec -T app chown -R www-data:www-data /var/www/html/storage/framework

# ── Done ──────────────────────────────────────
echo ""
echo "========================================="
echo "  Done!"
echo "========================================="
docker ps --filter "name=RavaaWeb" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

