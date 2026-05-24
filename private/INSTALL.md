# Installation — Dipesh Jagtap portfolio (core PHP + MySQL)

This file lives in **`private/`** with **`schema.sql`** so it is **not served over the web** (see `private/.htaccess` and root `.htaccess`). Read it from your deployment package or via **cPanel File Manager** when installing.

This site is designed for **GoDaddy shared hosting (cPanel)**: upload files, create a MySQL database, import the schema, and edit configuration. No Composer, Node.js, or SSH required.

**Requirements:** PHP **8.0+** (strict typing, `basename()`, and `mysqli` with **mysqlnd** for `get_result()` / `fetch_all()`), MySQL **5.7+** / **MariaDB 10+**, Apache with `mod_rewrite` enabled.

## 1. Upload files

Upload the project to your hosting document root (or a subdirectory). Preserve the folder structure:

- Root PHP: `index.php` (single-page portfolio), `resume.php` (optional full resume), `contact-submit.php` (AJAX JSON endpoint), `404.php`
- Section partials under `includes/`: `hero.php`, `about-section.php`, `skills-section.php`, `experience-section.php`, `projects-section.php`, `resume-section.php`, `contact-section.php`
- `.htaccess`, `robots.txt`, `sitemap.xml`
- `private/` — **not web-accessible**: `schema.sql`, this `INSTALL.md`
- `config/`, `includes/`, `assets/`, `admin/`, `classic-resume/` (legacy static resume)

**URLs:** Public links, assets, and canonical tags are built from the current request (`HTTP_HOST`, `HTTPS`, and `SCRIPT_NAME`). The same codebase works at `http://localhost/demo/personal/` and at `https://dipeshjagtap.in/` with no `BASE_URL` edits.

## 2. MySQL database

1. In cPanel, open **MySQL® Databases** and create a database and user. Grant the user **ALL PRIVILEGES** on that database.
2. Open **phpMyAdmin**, select the database, and import **`private/schema.sql`** from the project on disk (cPanel **File Manager** → download or open the file; it is not available via URL). Or paste its contents into the SQL tab and run. This single file defines the full schema (including structured phone columns on `contact_submissions`); there is no separate migration SQL.
3. Edit **`config/database.php`** and set the `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` constants to match your hosting (often `DB_HOST` is `localhost`).

## 3. Admin user (password hash)

Do **not** store plain-text passwords. Generate a **bcrypt** hash with PHP (Run PHP section in cPanel, or a one-off file you delete afterward):

```php
<?php
echo password_hash('YourStrongPasswordHere', PASSWORD_DEFAULT);
```

Insert the admin row in phpMyAdmin (replace `your_user` and the hash):

```sql
INSERT INTO admins (username, password_hash) VALUES (
  'your_user',
  '$2y$10$...............................................................'
);
```

Sign in at `/admin/login.php` (with your site’s base path, e.g. `https://yourdomain.com/admin/login.php` or `http://localhost/demo/personal/admin/login.php`).

**HTTPS:** After SSL is active, session cookies are marked `Secure` automatically when requests use HTTPS.

## 4. Resume PDF (optional)

Place your CV at:

`assets/uploads/dipesh-jagtap-resume.pdf`

The Resume page enables the download button when this file exists.

## 5. Email notifications (optional)

In `config/config.php`:

- Set `MAIL_NOTIFICATIONS_ENABLED` to `true` if your host allows PHP `mail()`.
- Adjust `MAIL_FROM` to a sender address your host permits (often an address on your domain).

Many shared hosts require SPF/DKIM and a valid From domain.

## 6. Sitemap and robots

- **`sitemap.xml`** lists production URLs for `dipeshjagtap.in`. Adjust if your canonical domain differs.
- **`robots.txt`** references the sitemap; update the domain if needed.

## 7. Legacy classic resume

The older static site lives in **`/classic-resume/`** (not `/resume/`) so the clean URL **`/resume`** can map to **`resume.php`** without Apache preferring a physical `resume/` directory.

## 8. Security checklist

- `private/` blocks HTTP access to `schema.sql` and this guide; keep that folder when deploying.
- Use a strong admin password and keep `config/database.php` out of public repos if you mirror the project.
- Delete any temporary PHP files used only for hashing passwords.
- Ensure `.htaccess` is active (Apache `AllowOverride`).

## 9. Troubleshooting

- **404 on clean URLs:** Confirm `mod_rewrite` is enabled, `.htaccess` is read, and you are not using a server that ignores per-directory rewrites.
- **Database connection error:** Verify credentials, database name prefix (cPanel often adds `cpuser_`), and host (`localhost` vs socket).
- **Contact form does not save:** Confirm tables exist and `contact_submissions` matches `private/schema.sql`.
