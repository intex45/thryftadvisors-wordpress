# Migration plan — same MochaHost account, near-clone

## Principle

Build WordPress on a **staging hostname**. Drupal stayed at `www` until cutover (2026-09-13). Live now points `public_html` at the WordPress folder; Drupal is parked as `public_html_drupal`.

## Phase 1 — Access (blocked on you)

In MochaHost cPanel:

1. Full backup: `public_html` zip + MySQL dump of the Drupal database.
2. Note PHP version (Drupal 7 is often PHP 7.x; WordPress wants 8.1+). Plan a PHP switch **after** WP is ready, or only on the staging subdomain.
3. Create subdomain `wp.thryftadvisors.com` (or `staging.thryftadvisors.com`) → new folder e.g. `public_html/wp`.
4. Create a **new** MySQL database/user for WordPress (do not reuse the Drupal DB).

## Phase 2 — WordPress install

1. Softaculous (or download WP) into the staging folder.
2. SSL for the subdomain (MochaHost AutoSSL / Let’s Encrypt).
3. Permalinks: `/%postname%/` plus parent pages so service URLs match Drupal.

## Phase 3 — Theme clone

Copy from the Drupal backup:

- `sites/all/themes/thryft/` (CSS, JS, images, templates)
- `sites/default/files/` (logo, uploads, generated CSS)

**Done in-repo:** custom theme `wp-content/themes/thryft` reuses the Drupal CSS/images and rebuilds header, footer, home sections, and the service template. Live on `www.thryftadvisors.com` as of 2026-09-13.

## Phase 4 — Content

| Drupal | WordPress |
|---|---|
| Basic pages | Pages (same slugs) |
| Service nodes | Child pages under Services |
| News nodes | Posts |
| Webform | Contact Form 7 / WPForms |
| Menus | Appearance → Menus |
| Files | Media library |

This site is small (~31 URLs). Manual copy from the inventory plus backup HTML is safer than a generic Drupal-to-WP plugin.

## Phase 5 — QA on staging

- Every URL in `inventory/url-map.md`
- Mobile header/footer
- Quote form email delivery (`admin@thryftadvisors.com`) — confirmed on staging 2026-09-12 after this theme was activated
- Phone `tel:` links (header shows `888-316-6968`, matching Drupal)
- Homepage counters/video embeds
- SEO titles/canonicals on www after launch

## Phase 6 — Cutover

**Done 2026-09-13.** `www.thryftadvisors.com` serves WordPress. Drupal is parked at `public_html_drupal`. `new.thryftadvisors.com` 301s to www.

1. WP DB dump: `/home/thryftad/tmp/wp-pre-cutover-2026-09-13.sql`. Account backups already on disk.
2. `mv public_html public_html_drupal`, then `ln -s new.thryftadvisors.com public_html`.
3. `home` / `siteurl` → `https://www.thryftadvisors.com`; search-replace `new.` → `www.`.
4. `/node/*` redirects ship in `thryft-brand.php`. Host-level 301 for `new.` → www in `.htaccess`.
5. Keep `public_html_drupal` and the account backup for 30+ days. Live PHP is account default 8.2.

## Risk notes

- PHP version clash if Drupal and WP share one cPanel PHP. Staging subdomain with its own MultiPHP setting avoids this.
- Workers-comp URL encoding.
- Homepage animated counters (browser showed 56/39/4595 vs copy that says 60/42/5000) — clone the live behavior, then you can correct copy later.
