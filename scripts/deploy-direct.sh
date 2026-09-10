#!/usr/bin/env bash
# Direct SSH deploy to Alwaysdata, bypassing GitHub Actions entirely.
#
# Use this when GitHub Actions is unavailable/broken. It mirrors the
# "Deploy to Alwaysdata" job in .github/workflows/ci-cd.yml step for step,
# so keep the two in sync if either changes.
#
# Required environment variables (same names as the GitHub Actions secrets):
#   ALWAYSDATA_SSH_HOST, ALWAYSDATA_SSH_USER, ALWAYSDATA_SSH_PASSWORD
#   LARAVEL_APP_KEY
#   DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Optional:
#   APP_URL (defaults to https://hospital.alwaysdata.net)
#
# Usage:
#   ALWAYSDATA_SSH_HOST=... ALWAYSDATA_SSH_USER=... ALWAYSDATA_SSH_PASSWORD=... \
#   LARAVEL_APP_KEY=... DB_HOST=... DB_DATABASE=... DB_USERNAME=... DB_PASSWORD=... \
#   ./scripts/deploy-direct.sh

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
APP_URL="${APP_URL:-https://hospital.alwaysdata.net}"

for var in ALWAYSDATA_SSH_HOST ALWAYSDATA_SSH_USER ALWAYSDATA_SSH_PASSWORD \
           LARAVEL_APP_KEY DB_HOST DB_DATABASE DB_USERNAME DB_PASSWORD; do
  if [ -z "${!var:-}" ]; then
    echo "Missing required environment variable: $var" >&2
    exit 1
  fi
done

if ! command -v sshpass >/dev/null 2>&1; then
  echo "sshpass is required (apt-get install sshpass / brew install hudochenkov/sshpass/sshpass)" >&2
  exit 1
fi

WORKDIR="$(mktemp -d)"
trap 'rm -rf "$WORKDIR"' EXIT

echo "==> Packaging release from $REPO_ROOT"
RELEASE_DIR="$WORKDIR/release"
mkdir -p "$RELEASE_DIR"
tar \
  --exclude='.git' \
  --exclude='.env*' \
  --exclude='vendor' \
  --exclude='storage' \
  --exclude='bootstrap/cache' \
  --exclude='database/*.sqlite' \
  --exclude='.phpunit.cache' \
  --exclude='node_modules' \
  -cf - -C "$REPO_ROOT" . | tar -xf - -C "$RELEASE_DIR"

echo "==> Writing production .env"
escape_dotenv() { printf '%s' "$1" | sed 's/[\\"]/\\&/g'; }
{
  printf '%s\n' \
    'APP_NAME="MediTrack HMS"' \
    'APP_ENV=production' \
    'APP_DEBUG=false' \
    "APP_KEY=$LARAVEL_APP_KEY" \
    "APP_URL=${APP_URL}" \
    "ASSET_URL=${APP_URL}" \
    "FRONTEND_URL=${APP_URL}" \
    'APP_TIMEZONE=Africa/Kampala' \
    'DB_CONNECTION=mysql' \
    'DB_PORT=3306' \
    'CACHE_STORE=file' \
    'SESSION_DRIVER=file' \
    'QUEUE_CONNECTION=sync' \
    'MAIL_MAILER=log' \
    'ENABLE_SMS_NOTIFICATIONS=false' \
    'ENABLE_MOBILE_MONEY=false' \
    'ENABLE_INSURANCE_INTEGRATION=false' \
    'ENABLE_ID_VERIFICATION=false' \
    'ENABLE_LIS_INTEGRATION=false' \
    'ENABLE_PHARMACY_SUPPLY_CHAIN=false' \
    'ENABLE_AMBULANCE_GPS=false' \
    'ENABLE_TWILIO_EMERGENCY=false'
  printf 'DB_HOST="%s"\n' "$(escape_dotenv "$DB_HOST")"
  printf 'DB_DATABASE="%s"\n' "$(escape_dotenv "$DB_DATABASE")"
  printf 'DB_USERNAME="%s"\n' "$(escape_dotenv "$DB_USERNAME")"
  printf 'DB_PASSWORD="%s"\n' "$(escape_dotenv "$DB_PASSWORD")"
} > "$RELEASE_DIR/.env"

echo "==> Archiving release"
ARCHIVE="$WORKDIR/meditrack-release.tgz"
tar -czf "$ARCHIVE" -C "$RELEASE_DIR" .

SSH_OPTS=(-4 -o StrictHostKeyChecking=no -o ConnectTimeout=15)
SSH_TARGET="$ALWAYSDATA_SSH_USER@$ALWAYSDATA_SSH_HOST"

echo "==> Uploading release archive to $ALWAYSDATA_SSH_HOST"
SSHPASS="$ALWAYSDATA_SSH_PASSWORD" sshpass -e ssh "${SSH_OPTS[@]}" "$SSH_TARGET" \
  'mkdir -p /home/hospital/releases /home/hospital/shared/meditrack/storage/app/public /home/hospital/shared/meditrack/storage/framework/cache/data /home/hospital/shared/meditrack/storage/framework/sessions /home/hospital/shared/meditrack/storage/framework/views /home/hospital/shared/meditrack/storage/logs'
SSHPASS="$ALWAYSDATA_SSH_PASSWORD" sshpass -e ssh "${SSH_OPTS[@]}" "$SSH_TARGET" \
  'cat > /home/hospital/meditrack-release.tgz' < "$ARCHIVE"

echo "==> Installing and publishing release on the server"
SSHPASS="$ALWAYSDATA_SSH_PASSWORD" sshpass -e ssh "${SSH_OPTS[@]}" "$SSH_TARGET" 'bash -s' <<'REMOTE_SCRIPT'
set -euo pipefail

HOME_DIR=/home/hospital
ARCHIVE="$HOME_DIR/meditrack-release.tgz"
STAMP="$(date +%Y%m%d%H%M%S)"
RELEASE="$HOME_DIR/releases/$STAMP"
SHARED="$HOME_DIR/shared/meditrack"

mkdir -p "$RELEASE" "$SHARED" "$SHARED/storage/app/public" \
  "$SHARED/storage/framework/cache/data" "$SHARED/storage/framework/sessions" \
  "$SHARED/storage/framework/views" "$SHARED/storage/logs"
tar -xzf "$ARCHIVE" -C "$RELEASE"
mkdir -p "$RELEASE/bootstrap/cache" "$RELEASE/bootstrap/cache/views"
rm -rf "$RELEASE/storage"
ln -s "$SHARED/storage" "$RELEASE/storage"
printf 'VIEW_COMPILED_PATH=%s\n' "$RELEASE/bootstrap/cache/views" >> "$RELEASE/.env"

cd "$RELEASE"
/usr/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-security-blocking --ignore-platform-req=ext-pcntl
/usr/bin/php artisan optimize:clear
/usr/bin/php artisan migrate --force
/usr/bin/php artisan config:cache
/usr/bin/php artisan route:cache
/usr/bin/php artisan view:cache
/usr/bin/php artisan storage:link || true

if [ -e "$HOME_DIR/www" ] || [ -L "$HOME_DIR/www" ]; then
  mv "$HOME_DIR/www" "$HOME_DIR/www.previous.$STAMP"
fi
ln -s "$RELEASE/public" "$HOME_DIR/www"

# Alwaysdata serves PHP through a long-lived mod_fcgid worker. Recycle workers
# owned by this account so the new release is loaded immediately after the
# document-root symlink changes.
for pid in $(pgrep -u "$(id -u)" -x php-cgi 2>/dev/null || true); do
  kill "$pid" 2>/dev/null || true
done

bash scripts/refresh-php-cache.sh

rm -f "$ARCHIVE"

find "$HOME_DIR/releases" -mindepth 1 -maxdepth 1 -type d -printf '%T@ %p\n' \
  | sort -nr | tail -n +6 | cut -d' ' -f2- | xargs -r rm -rf

find "$HOME_DIR" -mindepth 1 -maxdepth 1 -name 'www.previous.*' -printf '%T@ %p\n' \
  | sort -nr | tail -n +4 | cut -d' ' -f2- | xargs -r rm -rf
REMOTE_SCRIPT

echo "==> Deploy uploaded and published."
echo ""
echo "IMPORTANT — two independent staleness sources on this host:"
echo ""
echo "1. mod_fcgid (FcgidMaxProcesses=1, FcgidIdleTimeout=60): a single"
echo "   long-lived PHP worker keeps serving OLD code until it has sat idle"
echo "   for 60+ seconds, at which point Apache kills it and the next"
echo "   request spawns a fresh worker. Do NOT hit the site at all for"
echo "   ~90 seconds after this script finishes (including health checks)"
echo "   or you will keep resetting that idle timer indefinitely."
echo ""
echo "2. Alwaysdata's own edge reverse proxy (shows as 'via: 2.0 alproxy'"
echo "   in response headers) can independently cache a response — including"
echo "   a 404 for a route that didn't exist yet before this deploy — for"
echo "   longer than the idle-timeout wait above, regardless of Cache-Control"
echo "   headers from the origin. If a brand-new route still 404s on the"
echo "   public URL after waiting for (1), but you can confirm via SSH that"
echo "   'php artisan route:list' shows it AND a direct php-cgi invocation"
echo "   (bypassing Apache) returns the correct response, the code is fine —"
echo "   it's this edge cache. There is no known purge mechanism from SSH;"
echo "   it clears on its own, sometimes after several more minutes."
