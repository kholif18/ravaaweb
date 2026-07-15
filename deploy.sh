#!/bin/bash
set -e

echo "==> Pulling latest changes..."
git pull origin main

echo "==> Building container..."
docker compose build app

echo "==> Restarting container..."
docker compose up -d

echo "==> Fixing file permissions..."
sudo chown -R ravaa:ravaa /var/www/RavaaWeb

echo "==> Done!"
docker ps --filter "name=RavaaWeb-prod" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
