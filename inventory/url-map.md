# Public URL map (scraped 2026-09-06)

Canonical host: `https://www.thryftadvisors.com`  
`https://thryftadvisors.com` → 301 to www.

Source stack: Drupal 7 (`x-generator`), custom theme `thryft` (`/sites/all/themes/thryft/`), Drupal Bootstrap 7.x-3.x, Bootstrap 3.4.1, Font Awesome 4.7, fonts Open Sans / Poppins / Raleway. Logo: `/sites/default/files/logo.png`.

WordPress should keep these paths so cutover needs almost no 301s (except `/node/N` shortlinks).

## Core pages

| WP type | Path | Drupal node | Notes |
|---|---|---|---|
| Front page | `/` | node/5 | Alias `/welcome-thryft-advisors` |
| Page | `/about` | node/1 | |
| Page | `/contact-us` | node/2 | Quote form lives here (`/contact` 404s) |
| Page | `/services` | node/3 | Thin landing; services listed in footer |
| Page | `/faq` | node/4 | Accordion Q&A |
| Page | `/expense-reduction` | node/57 | Category landing |
| Page | `/specialized-savings` | node/56 | Category landing |
| Page | `/tax-incentives` | node/54 | Category landing |
| Page | `/terms-conditions` | node/44 | |
| Page | `/privacy-policy` | node/45 | |

## News / blog (3 posts)

| WP type | Path | Drupal node |
|---|---|---|
| Post | `/cares-act-and-cost-segregation` | node/49 |
| Post | `/savings-oh-so-annoying-accounts-payable` | node/48 |
| Post | `/think-you-cant-save-shipping-think-again` | node/47 |

`/blog` and `/news` 404 — keep post permalinks as `/%postname%/`.

## Service pages (keep nested paths)

### Expense reduction

| Path | Node |
|---|---|
| `/services/expense-reduction/copier-printer-charges` | 69 |
| `/services/expense-reduction/credit-card-fees` | 68 |
| `/services/expense-reduction/parcel-shipping-bills` | 67 |
| `/services/expense-reduction/shipping-freight-platform` | 66 |
| `/services/expense-reduction/waste-recycle-bills` | 65 |
| `/services/expense-reduction/wireless-bills` | 64 |
| `/services/expense-reduction/worker’s-comp-premium` | 63 |
| `/services/expense-reduction/zero-cost-card-processing` | 62 |

The workers-comp slug uses a Unicode apostrophe (`’`, `%E2%80%99`). Preserve it or add a redirect from the encoded URL.

### Specialized savings

| Path | Node |
|---|---|
| `/services/specialized-savings/accounts-payable-automation` | 61 |
| `/services/specialized-savings/class-action-claims` | 60 |
| `/services/specialized-savings/employee-health-benefits-billing-transparency` | 59 |
| `/services/specialized-savings/gas-electric-bills` | 58 |
| `/services/specialized-savings/same-day-pay-employee-digital-wallet` | 55 |

### Tax incentives

| Path | Node |
|---|---|
| `/services/tax-incentives/cost-segregation` | 53 |
| `/services/tax-incentives/property-tax-mitigation` | 52 |
| `/services/tax-incentives/r-d-tax-credit` | 51 |
| `/services/tax-incentives/workforce-hiring-incentive` | 50 |

## Menus / chrome (every page)

- Header: Home, About, Contact Us, Services, FAQ
- Phone: `888-316-6968`
- CTA: Request a quote / Request a Consultation → `/contact-us`
- Email: `info@thryftadvisors.com`
- Address: 3455 Peachtree Road North East, 5th Floor, Atlanta, Georgia 30326
- Social: Facebook, LinkedIn, Instagram (`thryftadvisors`)
- Footer credit historically: webdesignchoice.co.uk
- Copyright text still says “2020 © Thryft Advisor commercial”

## Forms

Contact Us includes a “How Can We Help You?” form (Drupal Webform). Recreate in WordPress (WPForms or Contact Form 7) to email `info@thryftadvisors.com`. Add spam protection (Akismet or Cloudflare). Field list TBD from backup or a logged-in screenshot.

## 301s to add on WordPress

| From | To |
|---|---|
| `/node/N` | matching alias |
| `/welcome-thryft-advisors` | `/` (optional; currently canonical of home) |
| `/contact` | `/contact-us` |
| `/blog`, `/news` | latest posts or home |

## Not public / not scraped

Drupal `/admin`, `/user/login`, modules, private files. Wait for cPanel backup.
