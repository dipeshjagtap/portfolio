<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

start_public_session();

function json_out(array $payload, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(['ok' => false, 'message' => 'Method not allowed.'], 405);
}

$token = $_POST['_csrf'] ?? null;
if (!csrf_verify(is_string($token) ? $token : null)) {
    json_out(['ok' => false, 'message' => 'Invalid security token. Refresh the page and try again.'], 403);
}

$validation = validate_contact_input($_POST);
if (!$validation['ok']) {
    json_out([
        'ok'           => false,
        'message'      => 'Please correct the highlighted fields.',
        'field_errors' => $validation['field_errors'],
    ], 422);
}

$d = $validation['data'];
$ip = client_ip();
$mysqli = db();

if (contact_rate_limited($mysqli, $ip, CONTACT_RATE_LIMIT_PER_HOUR)) {
    json_out(['ok' => false, 'message' => 'Too many messages sent. Please try again later.'], 429);
}

$name = $d['name'];
$email = $d['email'];
$phoneCountry = $d['phone_country_code'];
$phoneNational = $d['phone_number'];
$phoneFull = $d['full_phone_number'];
$subject = $d['subject'];
$message = $d['message'];
$status = 'unread';

$stmt = $mysqli->prepare(
    'INSERT INTO contact_submissions (name, email, phone_country_code, phone_number, full_phone_number, subject, message, status, ip_address, created_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())'
);

try {
    $stmt->bind_param('sssssssss', $name, $email, $phoneCountry, $phoneNational, $phoneFull, $subject, $message, $status, $ip);
    $stmt->execute();
} catch (Throwable $e) {
    error_log('Contact insert failed: ' . $e->getMessage());
    $stmt->close();
    json_out(['ok' => false, 'message' => 'Could not save your message. Please try again or email directly.'], 500);
}

$stmt->close();

if (MAIL_NOTIFICATIONS_ENABLED) {
    $body = "New contact form submission\n\n" .
        "Name: {$d['name']}\n" .
        "Email: {$d['email']}\n" .
        "Phone country code: {$d['phone_country_code']}\n" .
        "Phone (national): {$d['phone_number']}\n" .
        "Phone (E.164): {$d['full_phone_number']}\n" .
        "Subject: {$d['subject']}\n\n" .
        $d['message'];
    send_contact_mail(MAIL_TO, MAIL_FROM, 'Portfolio inquiry: ' . $d['subject'], $body);
}

json_out(['ok' => true, 'message' => 'Thank you — your message was sent. I will get back to you soon.']);
