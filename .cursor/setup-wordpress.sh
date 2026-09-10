#!/usr/bin/env bash
#
# Idempotent local WordPress setup for the Thryft Advisors theme.
#
# The repository only ships the custom theme (wp-content/themes/thryft) and a
# must-use plugin (wp-content/mu-plugins/thryft-brand.php). To exercise them we
# need a full WordPress install. This script downloads WordPress core into a
# gitignored webroot, wires up a zero-dependency SQLite database (no MySQL
# server required), links the repo's theme + mu-plugin into that webroot, and
# activates the theme so its content importer runs.
#
# Safe to run repeatedly: existing installs are reused and only refreshed.

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WEBROOT="${THRYFT_WEBROOT:-$REPO_ROOT/public_html}"
WP_URL="${THRYFT_WP_URL:-http://localhost:8080}"
ADMIN_USER="${THRYFT_ADMIN_USER:-admin}"
ADMIN_PASS="${THRYFT_ADMIN_PASS:-admin}"
ADMIN_EMAIL="${THRYFT_ADMIN_EMAIL:-admin@example.com}"

wp() { command wp --path="$WEBROOT" --allow-root "$@"; }

echo "==> Thryft WordPress setup"
echo "    repo:    $REPO_ROOT"
echo "    webroot: $WEBROOT"
echo "    url:     $WP_URL"

mkdir -p "$WEBROOT"

# 1. WordPress core --------------------------------------------------------
if [ ! -f "$WEBROOT/wp-load.php" ]; then
  echo "==> Downloading WordPress core"
  command wp --path="$WEBROOT" --allow-root core download
else
  echo "==> WordPress core already present"
fi

# 2. SQLite drop-in (no external database server needed) -------------------
SQLITE_PLUGIN_DIR="$WEBROOT/wp-content/plugins/sqlite-database-integration"
if [ ! -d "$SQLITE_PLUGIN_DIR" ]; then
  echo "==> Installing SQLite database integration drop-in"
  TMP_ZIP="$(mktemp --suffix=.zip)"
  curl -sSL -o "$TMP_ZIP" \
    https://downloads.wordpress.org/plugin/sqlite-database-integration.latest-stable.zip
  mkdir -p "$WEBROOT/wp-content/plugins"
  unzip -q -o "$TMP_ZIP" -d "$WEBROOT/wp-content/plugins"
  rm -f "$TMP_ZIP"
fi

# wp-config.php (DB credentials are placeholders; SQLite drop-in ignores them)
if [ ! -f "$WEBROOT/wp-config.php" ]; then
  echo "==> Creating wp-config.php"
  command wp --path="$WEBROOT" --allow-root config create \
    --dbname=thryft --dbuser=thryft --dbpass=thryft --dbhost=localhost \
    --skip-check --force
fi

# Activate the SQLite drop-in by copying db.copy -> wp-content/db.php with the
# plugin path placeholders filled in.
DB_DROPIN="$WEBROOT/wp-content/db.php"
if [ ! -f "$DB_DROPIN" ]; then
  echo "==> Enabling SQLite db.php drop-in"
  php -r '
    $src = $argv[1] . "/db.copy";
    $dst = $argv[2];
    $php = file_get_contents($src);
    $php = str_replace(
      ["{SQLITE_IMPLEMENTATION_FOLDER_PATH}", "{SQLITE_PLUGIN}"],
      [$argv[1], "sqlite-database-integration/load.php"],
      $php
    );
    file_put_contents($dst, $php);
  ' "$SQLITE_PLUGIN_DIR" "$DB_DROPIN"
fi

# 3. Link the repo theme + mu-plugin into the webroot ----------------------
echo "==> Linking repo theme + mu-plugin into webroot"
mkdir -p "$WEBROOT/wp-content/themes" "$WEBROOT/wp-content/mu-plugins"
ln -sfn "$REPO_ROOT/wp-content/themes/thryft" "$WEBROOT/wp-content/themes/thryft"
ln -sfn "$REPO_ROOT/wp-content/mu-plugins/thryft-brand.php" \
  "$WEBROOT/wp-content/mu-plugins/thryft-brand.php"

# 4. Install WordPress -----------------------------------------------------
if ! wp core is-installed 2>/dev/null; then
  echo "==> Installing WordPress"
  wp core install \
    --url="$WP_URL" \
    --title="Thryft Advisors" \
    --admin_user="$ADMIN_USER" \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email
else
  echo "==> WordPress already installed; updating site URL to $WP_URL"
  wp option update home "$WP_URL"
  wp option update siteurl "$WP_URL"
fi

# 5. Activate the Thryft theme (runs the content importer) -----------------
echo "==> Activating Thryft Advisors theme"
wp theme activate thryft

echo "==> Done. Pages present:"
wp post list --post_type=page --fields=ID,post_title,post_name --format=table || true

echo
echo "Start the dev server with:"
echo "  php -S 0.0.0.0:8080 -t \"$WEBROOT\""
