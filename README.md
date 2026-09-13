# Thryft Advisors — Drupal 7 → WordPress

Near-clone of the live site onto **the same MochaHost account**. Cutover completed **2026-09-13**.

| Live now | Parked |
|---|---|
| WordPress 7.1 + custom `thryft` theme at [www.thryftadvisors.com](https://www.thryftadvisors.com/) | Drupal 7 at `public_html_drupal` (keep ≥ 30 days) |
| PHP 8.2 (account default) | Drupal’s old PHP 7.4 `AddHandler` stayed with the parked tree |

Apex `thryftadvisors.com` and staging `new.thryftadvisors.com` 301 to `https://www.thryftadvisors.com/`.

## Status

- [x] Public URL inventory (31 pages, all HTTP 200)
- [x] MochaHost cPanel access / file + DB backup
- [x] WordPress staging install (`new.thryftadvisors.com`)
- [x] Custom theme that reuses Drupal CSS, images, header/footer, and service templates (`wp-content/themes/thryft`)
- [x] Drupal URL redirects (`wp-content/mu-plugins/thryft-brand.php`)
- [x] Activate the `thryft` theme (pages/posts imported 2026-09-12)
- [x] Contact Us mail via GoSMTP to `admin@thryftadvisors.com` (staging test quote received 2026-09-12)
- [x] Cutover 2026-09-13: `public_html` → WordPress symlink; Drupal parked as `public_html_drupal`

## What this repo ships

| Path | Role |
|---|---|
| `wp-content/themes/thryft/` | Drupal near-clone theme. Activating it creates the pages, nested service URLs, news posts, and permalinks. |
| `wp-content/plugins/thryft-redirects/` | 301s for `/node/N`, `/contact`, `/blog`, and the Unicode workers-comp slug. Upload this from WP Admin if you cannot write `mu-plugins`. |
| `wp-content/mu-plugins/thryft-brand.php` | Same redirects, auto-loaded if you copy it via File Manager. Safe to use with or instead of the plugin. |

Do **not** use the old PopularFX/PageLayer overlay. Live is WordPress 7.1 + this theme.

### Staging / local activate (WP Admin)

From the repo root: `bash tools/package-for-staging.sh` (writes `dist/thryft-theme.zip` and `dist/thryft-redirects.zip`).

1. Log into [www.thryftadvisors.com/wp-admin](https://www.thryftadvisors.com/wp-admin/) (or a local install).
2. Appearance → Themes → Add New → Upload Theme → `thryft-theme.zip` → **Activate**.
3. Plugins → Add New → Upload Plugin → `thryft-redirects.zip` → **Activate**.
4. Settings → Permalinks → Save (flush rewrites if nested `/services/...` URLs 404).
5. Send a test quote from `/contact-us/` (GoSMTP is already configured).

To refresh bundled copy after a later theme update: Appearance → **Re-import content**.

### Local preview

```bash
bash .cursor/setup-wordpress.sh
php -S 0.0.0.0:8080 -t public_html
```

Then open http://localhost:8080/ . Admin is `admin` / `admin` unless you override `THRYFT_ADMIN_*`.

## Cutover notes (hosting)

Executed on the MochaHost account (`thryftad`):

1. WP DB dump at `/home/thryftad/tmp/wp-pre-cutover-2026-09-13.sql`.
2. `mv public_html public_html_drupal` (Drupal 7 intact).
3. `ln -s new.thryftadvisors.com public_html` (`www` → `public_html` still valid).
4. `home` / `siteurl` set to `https://www.thryftadvisors.com`; search-replace `new.` → `www.`.
5. `.htaccess` 301s `new.thryftadvisors.com` to www.

### Rollback (SSH as `thryftad`)

```bash
rm /home/thryftad/public_html   # only if it is the WordPress symlink
mv /home/thryftad/public_html_drupal /home/thryftad/public_html
# restore WP URLs if needed:
# wp --skip-packages db import /home/thryftad/tmp/wp-pre-cutover-2026-09-13.sql
```

Do **not** delete `public_html_drupal` for at least 30 days. Do **not** force live WordPress back onto PHP 7.4.

## Do not put in this repo

cPanel passwords, Drupal admin logins, database dumps with PII, or `.env` files.
