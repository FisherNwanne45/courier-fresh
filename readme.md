# Courier Tracking App

A self-hosted PHP/MySQL courier & logistics site: a public-facing marketing
site (with swappable front-end themes), a shipment tracking page, a client
"vault" portal, and an admin dashboard for managing shipments, site content,
and email notifications.

## Features

- **Multi-theme front end** -- three complete, independent front-end themes
  under `themes/` (`theme1`, `theme2`, `theme3`), switchable from the admin
  dashboard's Appearance page with zero code changes. `theme3` additionally
  ships 5 selectable homepage designs (Main, Courier Service, Freight,
  International Logistics, Maritime Transport).
- **Shipment tracking** -- a public tracking-number lookup
  (`resources/track-result.php`) with a live status timeline, a printable
  PDF-style receipt, and 4 selectable accent-color schemes (admin-configurable
  from Appearance).
- **Client vault** -- a lightweight authenticated portal (`resources/vault.php`)
  for individual client accounts to see their own record.
- **Admin dashboard** -- create/edit tracking records and vault users, manage
  site settings (branding, branch offices, logos), appearance (theme, color
  scheme, tracking-page translator languages), SMTP settings, and email
  templates, all from `resources/` (start at `resources/login.php`).
- **Email notifications** -- SMTP-based emails (via PHPMailer) sent on parcel
  creation and status updates, using admin-editable templates
  (`resources/email_templates.php`) with a delivery log
  (`resources/email_log.php`).
- **Google Translate widget** -- a language picker (`resources/translator.php`)
  in every theme's header and on the tracking page; which languages it offers
  is admin-configurable from Appearance.

## Installation

The easiest way to set this up on a fresh clone (no database yet) is the
installer wizard:

1. Point your web server at this folder and visit `/install/` in a browser.
2. **Environment check** -- confirms PHP version, required extensions, and
   that the app can write `.env` and `resources/img/` (needed for uploads).
3. **Database** -- enter your MySQL host/user/password/database name. The
   wizard creates the database (if it doesn't exist), all tables, and seeds
   default data: a demo tracking number (`1234`), a demo vault login
   (`user@user.com` / `1234`), and the default email templates.
4. **Site & Appearance** -- site name, contact details, logo/favicon, front-end
   theme, and tracking-page accent color.
5. **SMTP** -- outbound email settings, with a "send test email" button. Can
   be skipped and configured later from the dashboard.
6. **Admin account** -- the username/password you'll use to log in.

The wizard writes `resources/.env` (database credentials + a generated
encryption key used to encrypt the stored SMTP password) and locks itself
with `install/installed.lock` when done -- delete that file to run the
wizard again (e.g. to point the app at a different database).

**Manual setup** (equivalent to the wizard, if you'd rather do it by hand):

1. Create a MySQL database and run `install/schema.sql` against it.
2. Copy `resources/.env.example` to `resources/.env` (if present) or create
   `resources/.env` with `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, and an
   `APP_KEY` (generate one with `php -r "echo bin2hex(random_bytes(32));"`).
3. Log into MySQL and insert an admin row into `userlog`
   (`amt = 'admin'`, `password` = a `password_hash()` bcrypt hash) and a row
   into `site` with `id = 20`.
4. Configure SMTP from the dashboard's Email / SMTP Settings page once
   you can log in.

## Requirements

- PHP 8.1+, with the `mysqli`, `openssl`, and `mbstring` extensions
- MySQL / MariaDB
- Apache with `mod_rewrite`/`.htaccess` support (used to block direct access
  to `.env`, `.sql` files, and other internal files)

## Project layout

```
themes/theme1|theme2|theme3/   Front-end themes (selected in Appearance)
resources/                     Admin dashboard, tracking logic, email, config
resources/.env                 DB credentials + APP_KEY (not committed)
install/                       First-run setup wizard (see Installation)
*.php (root)                   Thin dispatcher stubs -- each one resolves to
                                the active theme's matching file; see
                                resources/theme_dispatch.php
```
