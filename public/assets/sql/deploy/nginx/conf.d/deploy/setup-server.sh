#!/usr/bin/env bash
set -euo pipefail

DOMAIN="doings.verifytools"
CERT_EMAIL="admin@doings.verifytools"

apt-get update
apt-get install -y ca-certificates curl gnupg lsb-release software-properties-common apt-transport-https

if ! command -v docker >/dev/null 2>&1; then
  curl -fsSL https://get.docker.com -o get-docker.sh
  sh get-docker.sh
  rm get-docker.sh
fi

apt-get install -y docker-compose-plugin nginx certbot python3-certbot-nginx

systemctl enable --now docker
systemctl enable --now nginx

echo "Setup complete. Next steps:"
echo "1) Clone repo to /opt/verifytools"
echo "2) Copy .env.production.example to .env and edit"
echo "3) Run /opt/verifytools/deploy/deploy.sh"
echo "4) Ensure DNS A record for doings.verifytools points to this server"
echo "5) Run: sudo certbot --nginx -d doings.verifytools --email ${CERT_EMAIL} --agree-tos --non-interactive"
