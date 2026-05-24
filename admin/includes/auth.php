<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

function start_admin_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE && session_name() === SESSION_NAME_ADMIN) {
        return;
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    session_name(SESSION_NAME_ADMIN);
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

function admin_csrf_token(): string
{
    start_admin_session();
    if (empty($_SESSION['_csrf_admin'])) {
        $_SESSION['_csrf_admin'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_admin'];
}

function admin_csrf_verify(?string $token): bool
{
    start_admin_session();
    if ($token === null || $token === '') {
        return false;
    }
    return isset($_SESSION['_csrf_admin']) && hash_equals($_SESSION['_csrf_admin'], $token);
}

function admin_logged_in(): bool
{
    start_admin_session();
    return !empty($_SESSION['admin_id']);
}

function require_admin_login(): void
{
    if (!admin_logged_in()) {
        header('Location: ' . base_url('admin/login.php'));
        exit;
    }
}

function admin_logout(): void
{
    start_admin_session();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
