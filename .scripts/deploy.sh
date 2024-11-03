#!/bin/bash

set -e

echo "Deployment started ..."

git pull origin production

composer install --ignore-platform-reqs

docker exec app php artisan migrate

echo "Deployment finished!"
