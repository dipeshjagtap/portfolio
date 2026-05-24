<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * URL path of the app root (e.g. /demo/personal) or empty string at domain root.
 * Derived from the current script. Admin scripts live in /admin so their dirname is one level too deep — strip that.
 */
function app_base_path(): string
{
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $dir = str_replace('\\', '/', dirname($script));
    if (basename($dir) === 'admin') {
        $dir = dirname($dir);
    }
    if ($dir === '/' || $dir === '.' || $dir === '') {
        return '';
    }
    return rtrim($dir, '/');
}

/**
 * Scheme + host (and non-default port), no path — e.g. http://localhost or https://dipeshjagtap.in
 */
function url_origin(): string
{
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $scheme . '://' . $host;
}

/**
 * Absolute URL to a path under this app. Pass '' or '/' for home.
 * For in-page anchors use base_url('#about') -> https://host/app/#about
 */
function base_url(string $path = ''): string
{
    $prefix = app_base_path();
    $base = url_origin() . $prefix;
    $path = trim($path);
    if ($path === '' || $path === '/') {
        return rtrim($base, '/') . '/';
    }
    if (str_starts_with($path, '#')) {
        return rtrim($base, '/') . '/' . $path;
    }
    $path = '/' . ltrim($path, '/');
    return rtrim($base, '/') . $path;
}

/**
 * Absolute URL to a file under /assets or any path relative to app root.
 * Example: asset_url('assets/css/main.css')
 */
function asset_url(string $relative): string
{
    return base_url(ltrim($relative, '/'));
}

/**
 * Full URL for the current request path (no query string). Safe for rel=canonical and og:url.
 * Do not pass REQUEST_URI into base_url() — it would duplicate the subfolder segment.
 */
function canonical_url(): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        $path = '/';
    }
    return url_origin() . $path;
}

/**
 * HTML escape for output
 */
function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function session_cookie_path(): string
{
    $base = app_base_path();
    return ($base === '' || $base === '/') ? '/' : $base . '/';
}

function start_public_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name(SESSION_NAME_PUBLIC);
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => session_cookie_path(),
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    ini_set('session.use_strict_mode', '1');
    session_start();
}

function csrf_token(): string
{
    start_public_session();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_verify(?string $token): bool
{
    start_public_session();
    if ($token === null || $token === '') {
        return false;
    }
    return isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}

function redirect(string $url, int $code = 302): void
{
    header('Location: ' . $url, true, $code);
    exit;
}

function client_ip(): string
{
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return trim((string) $_SERVER['HTTP_CF_CONNECTING_IP']);
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $parts = explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($parts[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function normalize_space(string $s): string
{
    return trim(preg_replace('/\s+/', ' ', $s) ?? '');
}

function strip_inline_tags(string $s): string
{
    return strip_tags($s);
}

function contact_strip_zw(string $s): string
{
    return preg_replace('/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{FEFF}]/u', '', $s) ?? '';
}

function contact_normalize_line(string $s): string
{
    $s = contact_strip_zw($s);
    $s = preg_replace('/[\x{00A0}\x{202F}\x{2007}\x{3000}]/u', ' ', $s) ?? '';
    $s = preg_replace('/[\r\n\v\f]+/u', ' ', $s) ?? '';

    return trim(preg_replace('/^[\s.,;:!?\-_]+/u', '', normalize_space($s)) ?? '');
}

function contact_normalize_message(string $s): string
{
    $s = contact_strip_zw($s);
    $s = preg_replace('/[\x{00A0}\x{202F}\x{2007}\x{3000}]/u', ' ', $s) ?? '';
    $s = str_replace(["\r\n", "\r"], "\n", $s);
    $s = preg_replace('/\n{3,}/u', "\n\n", $s) ?? '';
    $parts = explode("\n", $s);
    if (count($parts) > 41) {
        $parts = array_slice($parts, 0, 41);
        $s = implode("\n", $parts);
    }
    $lines = explode("\n", $s);
    $out = [];
    foreach ($lines as $line) {
        $out[] = trim(preg_replace('/[ \t]+/u', ' ', $line) ?? '');
    }

    return trim(implode("\n", $out));
}

/**
 * @param list<string> $parts
 */
function contact_name_spam_checks(array $parts): ?string
{
    static $banned = [
        'admin' => true, 'test' => true, 'user' => true, 'guest' => true, 'unknown' => true,
        'person' => true, 'name' => true, 'fake' => true, 'spam' => true, 'null' => true,
        'undefined' => true, 'qwerty' => true, 'asdf' => true, 'asdfg' => true, 'zxcvb' => true,
        'placeholder' => true, 'nobody' => true, 'someone' => true, 'anyone' => true,
    ];
    $seen = [];
    foreach ($parts as $part) {
        $low = mb_strtolower($part, 'UTF-8');
        if (isset($banned[$low])) {
            return 'Please enter a meaningful name.';
        }
        if (isset($seen[$low])) {
            return 'Please enter a meaningful name.';
        }
        $seen[$low] = true;
    }
    foreach ($parts as $part) {
        if (preg_match('/qwerty|asdf|zxcv|hjkl|asdasd|dsaewq|12345|23456|34567/i', $part)) {
            return 'Please enter a meaningful name.';
        }
    }
    foreach ($parts as $part) {
        if (preg_match('/^[a-z]+$/i', $part) && mb_strlen($part) >= 5 && !preg_match('/[aeiouy]/i', $part)) {
            return 'Please enter a meaningful name.';
        }
    }

    return null;
}

function contact_validate_name(string $name): ?string
{
    if ($name === '') {
        return 'Please enter your full name.';
    }
    if (mb_strlen($name) > 120) {
        return 'Name should contain only letters and valid spaces.';
    }
    if (mb_strlen($name) < 3) {
        return 'Please enter a meaningful name.';
    }
    if (preg_match('/\d/u', $name)) {
        return 'Name should contain only letters and valid spaces.';
    }
    if (preg_match('/[^\p{L}\s.\'\-]/u', $name)) {
        return 'Name should contain only letters and valid spaces.';
    }
    if (preg_match('/(.)\1{4,}/u', $name)) {
        return 'Please enter a meaningful name.';
    }
    $parts = preg_split('/[\s.\'\-]+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
    if (count($parts) < 2) {
        return 'Please enter your full name.';
    }
    foreach ($parts as $part) {
        if (!preg_match('/^\p{L}+$/u', $part)) {
            return 'Name should contain only letters and valid spaces.';
        }
        if (preg_match('/^(.)\1{2,}$/u', $part)) {
            return 'Please enter a meaningful name.';
        }
    }
    preg_match_all('/\p{L}/u', $name, $m);
    if (count($m[0] ?? []) < 4) {
        return 'Please enter a meaningful name.';
    }
    $spam = contact_name_spam_checks($parts);
    if ($spam !== null) {
        return $spam;
    }

    return null;
}

function contact_validate_email_professional(string $email): ?string
{
    $msg = 'Please enter a valid professional email address.';
    if ($email === '') {
        return $msg;
    }
    if (mb_strlen($email) > 190) {
        return $msg;
    }
    if (preg_match('/\s/u', $email)) {
        return $msg;
    }
    $at = strpos($email, '@');
    if ($at < 1) {
        return $msg;
    }
    if (strrpos($email, '@') !== $at) {
        return $msg;
    }
    $local = substr($email, 0, $at);
    $domain = substr($email, $at + 1);
    if ($local === '' || $domain === '') {
        return $msg;
    }
    if (str_contains($local, '..') || str_contains($domain, '..')) {
        return $msg;
    }
    $localLen = strlen($local);
    if ($local[0] === '.' || $local[$localLen - 1] === '.') {
        return $msg;
    }
    if (!str_contains($domain, '.')) {
        return $msg;
    }
    $domLen = strlen($domain);
    if ($domain[$domLen - 1] === '.') {
        return $msg;
    }
    if (!preg_match('/^[a-z0-9]([a-z0-9._+-]*[a-z0-9])$/', $local) && !preg_match('/^[a-z0-9]$/', $local)) {
        return $msg;
    }
    $labels = explode('.', $domain);
    if (count($labels) < 2) {
        return $msg;
    }
    $tld = $labels[count($labels) - 1];
    if (strlen($tld) < 2) {
        return $msg;
    }
    if (preg_match('/^\d+$/', $tld)) {
        return $msg;
    }
    foreach ($labels as $lab) {
        $len = strlen($lab);
        if ($len < 1 || $len > 63) {
            return $msg;
        }
        if ($lab[0] === '-' || $lab[$len - 1] === '-') {
            return $msg;
        }
        if (!preg_match('/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/i', $lab)) {
            return $msg;
        }
    }
    static $blockedTlds = [
        'test' => true, 'invalid' => true, 'example' => true, 'localhost' => true,
        'local' => true, 'onion' => true,
    ];
    if (isset($blockedTlds[strtolower($tld)])) {
        return $msg;
    }
    $allSame = true;
    foreach ($labels as $lab) {
        if ($lab !== $labels[0]) {
            $allSame = false;
            break;
        }
    }
    if ($allSame && strlen($labels[0]) <= 3) {
        return $msg;
    }
    if (in_array($local, ['admin', 'test', 'root', 'postmaster'], true)) {
        return $msg;
    }
    if (strtolower($labels[0]) === 'test' && strtolower($tld) === 'test') {
        return $msg;
    }

    return null;
}

function contact_validate_subject(string $subject): ?string
{
    if ($subject === '') {
        return 'Please enter a meaningful subject.';
    }
    if (mb_strlen($subject) > 200) {
        return 'Subject is too long (max 200 characters).';
    }
    if (mb_strlen($subject) < 8) {
        return 'Please enter a meaningful subject.';
    }
    preg_match_all('/\p{L}/u', $subject, $m);
    $alpha = count($m[0] ?? []);
    if ($alpha < 5) {
        return 'Please enter a meaningful subject.';
    }
    if (preg_match('/^\d+$/', $subject)) {
        return 'Please enter a meaningful subject.';
    }
    if (preg_match('/^[^\p{L}\d\s]+$/u', $subject)) {
        return 'Please enter a meaningful subject.';
    }
    if (preg_match('/(.)\1{5,}/u', $subject)) {
        return 'Please enter a meaningful subject.';
    }
    if (mb_strlen($subject) > 12 && $alpha / mb_strlen($subject) < 0.4) {
        return 'Please enter a meaningful subject.';
    }

    return null;
}

function contact_validate_message(string $message): ?string
{
    if ($message === '') {
        return 'Please enter a message with a bit more detail.';
    }
    if (mb_strlen($message) > 5000) {
        return 'Message is too long (max 5000 characters).';
    }
    if (mb_strlen($message) < 24) {
        return 'Please enter a message with a bit more detail.';
    }
    $tokens = preg_split('/\s+/u', trim($message), -1, PREG_SPLIT_NO_EMPTY);
    $wordCount = 0;
    foreach ($tokens as $t) {
        if (preg_match('/\p{L}/u', $t)) {
            ++$wordCount;
        }
    }
    if ($wordCount < 4) {
        return 'Please enter a message with a bit more detail.';
    }
    if (preg_match('/(.)\1{7,}/u', $message)) {
        return 'Please enter a meaningful message.';
    }
    preg_match_all('/\p{L}/u', $message, $lm);
    $letters = count($lm[0] ?? []);
    $len = mb_strlen($message);
    if ($len > 20 && $letters / $len < 0.35) {
        return 'Please enter a meaningful message.';
    }
    $nonSpace = preg_replace('/\s+/u', '', $message) ?? '';
    $nsLen = mb_strlen($nonSpace);
    if ($nsLen > 0 && $letters / $nsLen < 0.3) {
        return 'Please enter a meaningful message.';
    }

    return null;
}

function contact_phone_national_looks_fake(string $digits): bool
{
    if ($digits === '' || mb_strlen($digits) < 6) {
        return false;
    }
    if (preg_match('/(\d)\1{5,}/', $digits)) {
        return true;
    }
    $uniq = array_unique(str_split($digits));

    return count($uniq) <= 1;
}

/**
 * @return array{ok: bool, errors: string[], field_errors: array<string, string>, data: array<string, string>}
 */
function validate_contact_input(array $post): array
{
    $fieldErrors = [];
    $name = contact_normalize_line(strip_inline_tags((string) ($post['name'] ?? '')));
    $email = strtolower(contact_normalize_line((string) ($post['email'] ?? '')));
    $phoneCountry = normalize_space(strip_inline_tags((string) ($post['phone_country_code'] ?? '')));
    $phoneNational = strip_inline_tags((string) ($post['phone_number'] ?? ''));
    $phoneFull = normalize_space(strip_inline_tags((string) ($post['full_phone_number'] ?? '')));
    $subject = contact_normalize_line(strip_inline_tags((string) ($post['subject'] ?? '')));
    $message = contact_normalize_message(strip_inline_tags((string) ($post['message'] ?? '')));

    $phoneNationalDigits = preg_replace('/\D+/', '', $phoneNational) ?? '';

    $nameErr = contact_validate_name($name);
    if ($nameErr !== null) {
        $fieldErrors['name'] = $nameErr;
    }
    $emailErr = contact_validate_email_professional($email);
    if ($emailErr !== null) {
        $fieldErrors['email'] = $emailErr;
    }
    if ($phoneCountry === '' || !preg_match('/^\+[1-9][0-9]{0,3}$/', $phoneCountry)) {
        $fieldErrors['phone'] = 'Please enter a valid phone number.';
    }
    if ($phoneNationalDigits === '' || mb_strlen($phoneNationalDigits) < 4 || mb_strlen($phoneNationalDigits) > 24) {
        $fieldErrors['phone'] = 'Please enter a valid phone number.';
    }
    if ($phoneFull === '' || !preg_match('/^\+[1-9][0-9]{5,14}$/', $phoneFull)) {
        $fieldErrors['phone'] = 'Please enter a valid phone number.';
    }
    if ($phoneFull !== '' && $phoneCountry !== '' && strpos($phoneFull, $phoneCountry) !== 0) {
        $fieldErrors['phone'] = 'Please enter a valid phone number.';
    }
    if (!isset($fieldErrors['phone']) && contact_phone_national_looks_fake($phoneNationalDigits)) {
        $fieldErrors['phone'] = 'Please enter a valid phone number.';
    }
    $subjectErr = contact_validate_subject($subject);
    if ($subjectErr !== null) {
        $fieldErrors['subject'] = $subjectErr;
    }
    $messageErr = contact_validate_message($message);
    if ($messageErr !== null) {
        $fieldErrors['message'] = $messageErr;
    }

    return [
        'ok'           => $fieldErrors === [],
        'field_errors' => $fieldErrors,
        'errors'       => array_values($fieldErrors),
        'data'         => [
            'name'               => $name,
            'email'              => $email,
            'phone_country_code' => $phoneCountry,
            'phone_number'       => $phoneNationalDigits,
            'full_phone_number'  => $phoneFull,
            'subject'            => $subject,
            'message'            => $message,
        ],
    ];
}

function contact_rate_limited(mysqli $mysqli, string $ip, int $maxPerHour): bool
{
    $stmt = $mysqli->prepare(
        'SELECT COUNT(*) FROM contact_submissions WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)'
    );
    $stmt->bind_param('s', $ip);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = (int) ($row[0] ?? 0);
    $stmt->close();
    return $count >= $maxPerHour;
}

function send_contact_mail(string $to, string $from, string $subject, string $body): bool
{
    $subject = str_replace(["\r", "\n"], '', $subject);
    $from = str_replace(["\r", "\n"], '', $from);
    $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion() . "\r\n" .
        'Content-Type: text/plain; charset=UTF-8';
    return @mail($to, $subject, $body, $headers);
}
