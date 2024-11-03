#!/bin/bash

set -e

echo "Deployment started ..."

docker exec app php artisan down

git pull origin production

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

docker exec app php artisan migrate --force

docker exec app php artisan optimize:clear

docker exec app php artisan up

echo "Deployment finished!"
