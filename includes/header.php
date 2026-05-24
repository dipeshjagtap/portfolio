<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
<?php require __DIR__ . '/seo.php'; ?>
<?php if (!empty($loadIntlTelInput)): ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@28.0.5/dist/css/intlTelInput.css" crossorigin="anonymous">
<?php endif; ?>
</head>
<body<?= ($bodyClass ?? '') !== '' ? ' class="' . e($bodyClass) . '"' : '' ?>>
<?php require __DIR__ . '/navbar.php'; ?>
<main id="main-content" class="site-main">
