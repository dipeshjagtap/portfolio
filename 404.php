<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';

start_public_session();

http_response_code(404);

$bodyClass = '';

$pageMeta = [
    'title'            => 'Page not found | ' . SITE_NAME,
    'description'      => 'The page you requested could not be found.',
    'json_ld_person'   => false,
    'noindex'          => true,
];

require __DIR__ . '/includes/header.php';
?>
<div class="page-wrap error-page">
    <h1>404</h1>
    <p class="page-lead" style="margin: 1rem auto 0; max-width: 40ch;">This page does not exist or has moved.</p>
    <p style="margin-top: 1.5rem;">
        <a class="btn btn-primary" href="<?= e(base_url('')) ?>">Back to home</a>
    </p>
</div>
<?php require __DIR__ . '/includes/footer.php';
