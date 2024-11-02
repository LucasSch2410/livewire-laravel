#!/bin/bash

set -e

echo "Deployment started ..."

git fetch origin production
git reset --hard origin/production

# Install dependencies based on lock file
docker exec app /usr/local/bin/composer install

# Migrate database
docker exec app php artisan migrate --force

echo "Deployment finished!"

