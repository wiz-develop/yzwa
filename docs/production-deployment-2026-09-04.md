# Production deployment: 2026-09-04

## Scope

- Site: `https://www.yzwa.net/`
- WordPress: `6.1.12` to `7.1`
- PHP: `7.4.33` (unchanged)
- Active theme: `base` 1.7

## Backup

- Server backup: `www.yzwa.net-cms-20260904-051945-v8knsp.wpress`
- Local backup: `backups/20260904-production-predeploy/www.yzwa.net-cms-20260904-051945-v8knsp.wpress`
- Size: 71,108,343 bytes
- SHA-256: `3f6e8008e83828d814f1407c0de2866ab88b2abb707938b95589880474d9b231`

## Plugin versions

| Plugin | Before | After |
| --- | --- | --- |
| Advanced Custom Fields | 5.12.3 | 6.8.9 |
| Akismet Anti-spam | 4.1.7 | 5.7.2 |
| All-in-One WP Migration | 7.69 | 7.110 |
| Autoptimize | 3.1.1.1 | 3.1.15.1 |
| Classic Editor | 1.6.2 | 1.7.0 |
| Custom Field Suite | 2.6.8 | 2.6.8-wiz.2 |
| Google XML Sitemap Generator | 4.1.7 | 4.1.24 |
| Limit Login Attempts Reloaded | 2.16.0 | 3.3.7 |
| MW WP Form | 5.0.3 | 5.0.3 |
| SiteGuard WP Plugin | 1.5.2 | 1.8.9 |
| TS Webfonts for XSERVER | 1.2.1 | 2.0.9 |
| WP Doctor Malware Scanner | 2.3 | 2.9 |
| Zipaddr-JP | 1.33 | 1.45 |

Inactive Hello Dolly and MW WP Form reCAPTCHA were removed. Six obsolete inactive default themes were removed; current Twenty Twenty-Four and Twenty Twenty-Five are retained as fallback themes.

## Compatibility changes

- Applied the production `base` theme PHP/JavaScript compatibility fixes verified on the test site.
- Preserved production analytics, the static `/recruit/` site, uploads, mail settings, `.htaccess`, and `wp-config.php`.
- Kept Custom Field Suite and applied the maintained PHP compatibility patch instead of replacing it with another plugin.
- ACF and other plugins were manually reactivated after updates because this host did not automatically restore their active state.

## QA

- HTTP 200: home, company, greeting, company profile, history, offices, news, contact, privacy policy, and recruitment site.
- Recruitment links resolve to `/recruit/` in a new tab; the recruitment site returned HTTP 200.
- Contact form markup contains the expected form, inputs, select, textarea, and submit control. No production email was sent.
- WordPress dashboard, Site Health, update screen, plugin screen, and permalink screen returned HTTP 200.
- REST API returned HTTP 200.
- Site Health: WordPress.org communication, background updates, loopback requests, HTTPS, and Authorization header tests all passed.
- WP-Cron is enabled and core version, plugin update, cleanup, and Site Health events are scheduled.
- All non-`wp-content` WordPress core files matched the official 7.1 checksums.
- Public and admin responses contained no PHP Fatal, Warning, Deprecated, Notice, gateway timeout, or 502 output.
- No `debug.log` or PHP `error_log` file existed in the checked WordPress/public paths.
- All local CSS, JavaScript, and image assets referenced by the home and contact pages returned HTTP 200. The XML-RPC discovery endpoint returned the expected HTTP 405 for a GET request.
- The temporary diagnostic plugin was removed after verification.

## Remaining constraints

- PHP 7.4 is end-of-life and Site Health reports it as critical. A supported PHP release should be scheduled after application compatibility testing.
- MW WP Form 5.1.6 requires a newer PHP release. Version 5.0.3 is the newest compatible version retained for PHP 7.4, so WordPress continues to display one plugin update notice.
- Production form submission was intentionally not performed to avoid sending mail to the customer. Perform one controlled mail-delivery test when an approved recipient and time window are available.
- Chrome browser automation was unavailable on the deployment workstation; visual QA was based on the approved test site plus production HTTP, DOM, asset, and error checks.

## Rollback

1. In WordPress admin, open All-in-One WP Migration backups.
2. Restore `www.yzwa.net-cms-20260904-051945-v8knsp.wpress`.
3. Confirm the home page, admin login, contact page, and recruitment site.
4. If only source rollback is required, use Git commit `e140e8c` as the pre-upgrade production baseline and restore the matching database backup before validating.
