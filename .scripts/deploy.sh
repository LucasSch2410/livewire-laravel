#!/bin/bash

set -e

echo "Deployment started ..."

git pull origin production

docker compose up -d --build

echo "Deployment finished!"
