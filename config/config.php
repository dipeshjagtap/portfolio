<?php
/**
 * Site configuration — public URLs are auto-detected (see config/functions.php).
 */
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

define('SITE_NAME', 'Dipesh Jagtap');
define('SITE_TAGLINE', 'Senior Software Developer');

/** Contact email shown on the site */
define('PUBLIC_EMAIL', 'jagtap.dipesh18@gmail.com');

/** Public E.164 phone for tel: links, Connect section, and JSON-LD (optional; leave empty to hide) */
define('PUBLIC_PHONE_E164', '+919158427811');

/** Optional: send copy of contact form via PHP mail() */
define('MAIL_NOTIFICATIONS_ENABLED', false);
define('MAIL_TO', PUBLIC_EMAIL);
define('MAIL_FROM', 'noreply@dipeshjagtap.in');

/** Rate limit: max contact submissions per IP per hour */
define('CONTACT_RATE_LIMIT_PER_HOUR', 5);

/** Session name for public CSRF */
define('SESSION_NAME_PUBLIC', 'dj_portfolio_pub');
define('SESSION_NAME_ADMIN', 'dj_portfolio_admin');
