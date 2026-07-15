#!/bin/bash
set -e

echo "==> Pulling latest changes..."
git pull origin main

echo "==> Building container..."
docker compose build app

echo "==> Restarting container..."
docker compose up -d

echo "==> Done! Website running at http://localhost:$(grep APP_PORT .env | cut -d= -f2)"
docker ps --filter "name=RavaaWeb-prod" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
