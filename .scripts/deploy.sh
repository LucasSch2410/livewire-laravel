#!/bin/bash
set -e

echo "Deployment started ..."

(php artisan down) || true

git pull origin production

docker compose up -d --build

echo "Deployment finished!"
