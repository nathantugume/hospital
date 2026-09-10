#!/usr/bin/env bash
# Run from the published release after switching the document-root symlink.
# CLI opcache_reset() cannot clear the web worker's opcode cache.
set -euo pipefail

APP_ORIGIN="${1:-https://hospital.alwaysdata.net}"
PUBLIC_DIR="$(pwd)/public"
PROBE="release-cache-$(openssl rand -hex 24).php"
trap 'rm -f "$PUBLIC_DIR/$PROBE"' EXIT

cat > "$PUBLIC_DIR/$PROBE" <<'PHP'
<?php
header('Content-Type: text/plain');
header('Cache-Control: no-store');
echo function_exists('opcache_reset') && opcache_reset() ? 'refreshed' : 'unavailable';
PHP

RESULT="$(curl --fail --silent --show-error --max-time 30 "$APP_ORIGIN/$PROBE")"
if [ "$RESULT" != refreshed ]; then
  echo 'Web PHP opcode cache refresh failed.' >&2
  exit 1
fi
echo 'Web PHP opcode cache refreshed.'
