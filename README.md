# Thryft Advisors — Drupal 7 → WordPress

Near-clone of the live site [www.thryftadvisors.com](https://www.thryftadvisors.com/) onto **the same MochaHost account**, without taking Drupal down until cutover.

| Live today | Target |
|---|---|
| Drupal 7 (EOL), theme `thryft`, Bootstrap 3 | WordPress (latest) |
| LiteSpeed / MochaHost | Same host, staging then document-root switch |

## Status

- [x] Public URL inventory (31 pages, all HTTP 200)
- [x] MochaHost cPanel access / file + DB backup
- [x] WordPress staging install (`wp.thryftadvisors.com`)
- [x] Theme + content clone
- [x] Forms, redirects, QA (Contact Us delivers to `admin@thryftadvisors.com`)
- [x] Cutover (`www` is WordPress; Drupal is `public_html_drupal`)

## Do not put in this repo

cPanel passwords, Drupal admin logins, database dumps with PII, or `.env` files.

## Next

Live site is WordPress at [www.thryftadvisors.com](https://www.thryftadvisors.com/). Keep the Drupal folder `public_html_drupal` and the account backup for at least 30 days. Leave PHP at 7.4 until Drupal is retired.
