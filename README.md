# Doings VerifyTools — Production-Ready Activation System

## Quick Start (Development)

```bash
cp .env.example .env
docker compose up --build
docker exec -i <db_container> mysql -u root -proot_password_placeholder verifytools < sql/schema.sql
docker exec -i <db_container> mysql -u root -proot_password_placeholder verifytools < sql/sample-data.sql
docker compose exec web composer install
