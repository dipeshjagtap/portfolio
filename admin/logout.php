<?php
declare(strict_types=1);

require __DIR__ . '/includes/auth.php';

start_admin_session();
admin_logout();

header('Location: ' . base_url('admin/login.php'));
exit;
