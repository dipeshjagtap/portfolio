<?php
declare(strict_types=1);

require __DIR__ . '/includes/auth.php';

start_admin_session();

if (admin_logged_in()) {
    header('Location: ' . base_url('admin/dashboard.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['_csrf'] ?? null;
    if (!admin_csrf_verify(is_string($token) ? $token : null)) {
        $error = 'Invalid security token. Refresh the page.';
    } else {
        $user = normalize_space((string) ($_POST['username'] ?? ''));
        $pass = (string) ($_POST['password'] ?? '');
        if ($user === '' || $pass === '') {
            $error = 'Enter username and password.';
        } else {
            $mysqli = db();
            $stmt = $mysqli->prepare('SELECT id, password_hash FROM admins WHERE username = ? LIMIT 1');
            $stmt->bind_param('s', $user);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($row && password_verify($pass, $row['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = (int) $row['id'];
                $_SESSION['admin_user'] = $user;
                header('Location: ' . base_url('admin/dashboard.php'));
                exit;
            }
            $error = 'Invalid credentials.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin login | <?= htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars(asset_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="admin-body">
    <div class="admin-login-card">
        <h1>Admin</h1>
        <p class="muted">Portfolio inquiries</p>
        <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>
    </div>
</body>
</html>
