# Thryft Advisors — Drupal 7 → WordPress

Near-clone of the live site [www.thryftadvisors.com](https://www.thryftadvisors.com/) onto **the same MochaHost account**, without taking Drupal down until cutover.

| Live today | Target |
|---|---|
| Drupal 7 (EOL), theme `thryft`, Bootstrap 3 | WordPress (latest) |
| LiteSpeed / MochaHost | Same host, staging then document-root switch |

## Status

- [x] Public URL inventory (31 pages, all HTTP 200)
- [ ] MochaHost cPanel access / file + DB backup
- [ ] WordPress staging install (`wp.thryftadvisors.com` or similar)
- [ ] Theme + content clone
- [ ] Forms, redirects, QA
- [ ] Cutover

## Do not put in this repo

cPanel passwords, Drupal admin logins, database dumps with PII, or `.env` files.

## Next

When you have MochaHost login, we install WordPress on a staging subdomain, copy theme assets from `sites/all/themes/thryft`, and import pages using `inventory/url-map.md`.
