<?php
declare(strict_types=1);

/**
 * MySQL via mysqli — update credentials after cPanel database creation.
 */
const DB_HOST = 'localhost';
const DB_NAME = 'dipesh_portfolio';
const DB_USER = 'your_db_user';
const DB_PASS = 'your_db_password';
const DB_CHARSET = 'utf8mb4';

/**
 * @return mysqli
 */
function db(): mysqli
{
    static $mysqli = null;
    if ($mysqli instanceof mysqli) {
        return $mysqli;
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $mysqli->set_charset(DB_CHARSET);
    } catch (Throwable $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        http_response_code(503);
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Unavailable</title></head><body><p>Service temporarily unavailable. Please try again later.</p></body></html>';
        exit;
    }

    return $mysqli;
}
