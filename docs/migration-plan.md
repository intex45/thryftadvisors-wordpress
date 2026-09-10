# Migration plan — same MochaHost account, near-clone

## Principle

Build WordPress on a **staging hostname**. Drupal stays at `www` until you approve. Then switch which folder the domain points at.

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

**Done in-repo:** custom theme `wp-content/themes/thryft` reuses the Drupal CSS/images and rebuilds header, footer, home sections, and the service template. Activate it on `new.thryftadvisors.com` (stock WP is still Twenty Twenty-Five until then).

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
- Quote form email delivery (`admin@thryftadvisors.com`) — previously verified on the PopularFX staging; re-test after this theme is activated
- Phone `tel:` links (header shows `888-316-6968`, matching Drupal)
- Homepage counters/video embeds
- SEO titles/canonicals on www after launch

## Phase 6 — Cutover

**Not done yet.** `www.thryftadvisors.com` is still Drupal 7 as of 2026-09-10. WordPress is on `new.thryftadvisors.com`.

1. Put Drupal in maintenance or leave it as a renamed folder (`public_html_drupal`).
2. Point the primary domain document root at the WordPress folder **or** move WP files to `public_html` after renaming Drupal aside.
3. Update WP `siteurl` / `home` to `https://www.thryftadvisors.com`.
4. `/node/*` redirects ship in `thryft-brand.php`.
5. Keep the Drupal backup zip for 30+ days.

## Risk notes

- PHP version clash if Drupal and WP share one cPanel PHP. Staging subdomain with its own MultiPHP setting avoids this.
- Workers-comp URL encoding.
- Homepage animated counters (browser showed 56/39/4595 vs copy that says 60/42/5000) — clone the live behavior, then you can correct copy later.
