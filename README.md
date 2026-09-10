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
- [ ] Activate the `thryft` theme on staging (copies pages/posts on activation)
- [ ] Confirm Contact Us mail via GoSMTP to `admin@thryftadvisors.com`
- [ ] Cutover (`www` still Drupal as of 2026-09-10; keep Drupal as `public_html_drupal` when switching)

## What this repo ships

Upload these paths into the WordPress install (document root `wp-content/`):

| Path | Role |
|---|---|
| `wp-content/themes/thryft/` | Drupal near-clone theme. Activating it creates the pages, nested service URLs, news posts, and permalinks. |
| `wp-content/mu-plugins/thryft-brand.php` | 301s for `/node/N`, `/contact`, `/blog`, and the Unicode workers-comp slug. Hides CookieAdmin chrome. |

Do **not** use the old PopularFX/PageLayer overlay. Staging is a stock WordPress 7.1 + Twenty Twenty-Five install; this theme replaces that look.

### Staging activate

1. Copy `wp-content/themes/thryft` and `wp-content/mu-plugins/thryft-brand.php` onto `new.thryftadvisors.com`.
2. WP Admin → Appearance → Themes → **Activate Thryft Advisors**.
3. Settings → Permalinks → save once (flush rewrites) if nested `/services/...` URLs 404.
4. Send a test quote from `/contact-us/` (GoSMTP is already on staging).

To refresh bundled copy after a later theme update: WP Admin → Appearance → **Re-import content**.

## Do not put in this repo

cPanel passwords, Drupal admin logins, database dumps with PII, or `.env` files.

## Next

Keep Drupal at [www.thryftadvisors.com](https://www.thryftadvisors.com/) until staging looks right. After cutover, keep `public_html_drupal` and the account backup for at least 30 days. Leave PHP at 7.4 until Drupal is retired, then raise it for WordPress.
