# Thryft Advisors — Drupal 7 → WordPress

Near-clone of the live site [www.thryftadvisors.com](https://www.thryftadvisors.com/) onto **the same MochaHost account**, without taking Drupal down until cutover.

| Live today | Target |
|---|---|
| Drupal 7 (EOL), theme `thryft`, Bootstrap 3 | WordPress (latest) + custom `thryft` theme |
| LiteSpeed / MochaHost | Same host: staging at `new.thryftadvisors.com`, then document-root switch |

## Status

- [x] Public URL inventory (31 pages, all HTTP 200)
- [x] MochaHost cPanel access / file + DB backup
- [x] WordPress staging install (`new.thryftadvisors.com`)
- [x] Custom theme that reuses Drupal CSS, images, header/footer, and service templates (`wp-content/themes/thryft`)
- [x] Drupal URL redirects (`wp-content/mu-plugins/thryft-brand.php`)
- [x] Activate the `thryft` theme on staging (pages/posts imported 2026-09-12; see [new.thryftadvisors.com](https://new.thryftadvisors.com/))
- [x] Contact Us form on staging accepted a test quote (GoSMTP/`wp_mail` returned success to `admin@thryftadvisors.com`; confirm it arrived in that inbox)
- [ ] Cutover (`www` still Drupal as of 2026-09-12; keep Drupal as `public_html_drupal` when switching)

## What this repo ships

| Path | Role |
|---|---|
| `wp-content/themes/thryft/` | Drupal near-clone theme. Activating it creates the pages, nested service URLs, news posts, and permalinks. |
| `wp-content/plugins/thryft-redirects/` | 301s for `/node/N`, `/contact`, `/blog`, and the Unicode workers-comp slug. Upload this from WP Admin if you cannot write `mu-plugins`. |
| `wp-content/mu-plugins/thryft-brand.php` | Same redirects, auto-loaded if you copy it via File Manager. Safe to use with or instead of the plugin. |

Do **not** use the old PopularFX/PageLayer overlay. Staging is a stock WordPress 7.1 + Twenty Twenty-Five install; this theme replaces that look.

### Staging activate (WP Admin, no FTP)

From the repo root: `bash tools/package-for-staging.sh` (writes `dist/thryft-theme.zip` and `dist/thryft-redirects.zip`).

1. Log into [new.thryftadvisors.com/wp-admin](https://new.thryftadvisors.com/wp-admin/).
2. Appearance → Themes → Add New → Upload Theme → `thryft-theme.zip` → **Activate**.
3. Plugins → Add New → Upload Plugin → `thryft-redirects.zip` → **Activate**.
4. Settings → Permalinks → Save (flush rewrites if nested `/services/...` URLs 404).
5. Send a test quote from `/contact-us/` (GoSMTP is already on staging).

To refresh bundled copy after a later theme update: Appearance → **Re-import content**.

### Local preview

```bash
bash .cursor/setup-wordpress.sh
php -S 0.0.0.0:8080 -t public_html
```

Then open http://localhost:8080/ . Admin is `admin` / `admin` unless you override `THRYFT_ADMIN_*`.

## Do not put in this repo

cPanel passwords, Drupal admin logins, database dumps with PII, or `.env` files.

## Next

Keep Drupal at [www.thryftadvisors.com](https://www.thryftadvisors.com/) until staging looks right. After cutover, keep `public_html_drupal` and the account backup for at least 30 days. Leave PHP at 7.4 until Drupal is retired, then raise it for WordPress.
