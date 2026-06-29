#!/usr/bin/env bash
set -euo pipefail

ROOT="/opt/verifytools"
if [ ! -d "${ROOT}" ]; then
  echo "Clone the repository to ${ROOT} first and run this script from there."
  exit 1
fi

cd "${ROOT}"

if [ ! -f .env ]; then
  cp .env.production.example .env
  echo "Copied .env.production.example to .env. Please edit .env to set passwords and APP_URL."
  exit 0
fi

docker compose -f docker-compose.prod.yml up -d --build

echo "Waiting for DB to initialize..."
sleep 8

DB_CONTAINER=$(docker compose -f docker-compose.prod.yml ps -q db || true)
if [ -n "${DB_CONTAINER}" ]; then
  docker exec -i "${DB_CONTAINER}" sh -c 'exec mysql -u root -p"$MYSQL_ROOT_PASSWORD" "verifytools"' < sql/schema.sql
  docker exec -i "${DB_CONTAINER}" sh -c 'exec mysql -u root -p"$MYSQL_ROOT_PASSWORD" "verifytools"' < sql/sample-data.sql || true
else
  echo "DB container not found. Check docker compose ps output."
fi

echo "Installing composer dependencies..."
docker compose -f docker-compose.prod.yml exec -T app bash -lc "if [ -f composer.json ]; then composer install --no-dev --prefer-dist -o ; fi"

echo "Deployment complete. Create an admin user:"
echo "docker compose -f docker-compose.prod.yml exec -T app php tools/create_admin.php admin admin@example.com 'ChangeMeAdmin!2026'"
