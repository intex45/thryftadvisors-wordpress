#!/usr/bin/env bash
# Build the two zips you can upload from WordPress admin on new.thryftadvisors.com.
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST="$ROOT/dist"
rm -rf "$DIST"
mkdir -p "$DIST"
(
  cd "$ROOT/wp-content/themes"
  zip -qr "$DIST/thryft-theme.zip" thryft
)
(
  cd "$ROOT/wp-content/plugins"
  zip -qr "$DIST/thryft-redirects.zip" thryft-redirects
)
echo "Wrote:"
ls -la "$DIST"
echo
echo "On new.thryftadvisors.com:"
echo "  1. Appearance → Themes → Add New → Upload Theme → thryft-theme.zip → Activate"
echo "  2. Plugins → Add New → Upload Plugin → thryft-redirects.zip → Activate"
echo "  3. Settings → Permalinks → Save"
