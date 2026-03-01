#!/bin/bash
set -e

APP_DIR=/var/www/html

# ── Generate .env from environment variables ───────────────────────────────────
cat > "$APP_DIR/.env" <<EOF
APP_NAME="${APP_NAME:-LiaStore}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=${APP_DIR}/database/database.sqlite

MAIL_MAILER="${MAIL_MAILER:-log}"
MAIL_HOST="${MAIL_HOST:-}"
MAIL_PORT="${MAIL_PORT:-587}"
MAIL_USERNAME="${MAIL_USERNAME:-}"
MAIL_PASSWORD="${MAIL_PASSWORD:-}"
MAIL_ENCRYPTION="${MAIL_ENCRYPTION:-tls}"
MAIL_FROM_ADDRESS="${MAIL_FROM_ADDRESS:-noreply@liastore.com}"
MAIL_FROM_NAME="${MAIL_FROM_NAME:-LiaStore}"

SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# ── Ensure SQLite database file exists ────────────────────────────────────────
touch "$APP_DIR/database/database.sqlite"
chown www-data:www-data "$APP_DIR/database/database.sqlite"
chmod 664 "$APP_DIR/database/database.sqlite"

# ── Laravel bootstrap ─────────────────────────────────────────────────────────
cd "$APP_DIR"

php artisan config:cache
php artisan view:cache

php artisan migrate --force
php artisan db:seed --force

php artisan storage:link --force 2>/dev/null || true

# ── Start Apache ──────────────────────────────────────────────────────────────
exec apache2-foreground
