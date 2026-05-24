<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/functions.php';
require_once __DIR__ . '/auth.php';

/** @var string $pageTitle */
start_admin_session();
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle) ?> | Admin</title>
    <link rel="stylesheet" href="<?= e(asset_url('assets/css/admin.css')) ?>">
</head>
<body class="admin-body admin-app">
    <header class="admin-header">
        <a class="admin-brand" href="<?= e(base_url('admin/dashboard.php')) ?>"><?= e(SITE_NAME) ?> Admin</a>
        <nav class="admin-nav">
            <a href="<?= e(base_url('admin/dashboard.php')) ?>">Dashboard</a>
            <a href="<?= e(base_url('admin/inquiries.php')) ?>">Inquiries</a>
            <a href="<?= e(base_url('')) ?>" target="_blank" rel="noopener">View site</a>
            <a href="<?= e(base_url('admin/logout.php')) ?>">Logout</a>
        </nav>
    </header>
    <main class="admin-main">
        <h1 class="admin-title"><?= e($pageTitle) ?></h1>
