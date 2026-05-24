<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';

start_public_session();

$bodyClass = 'is-single-page';

$pageMeta = [
    'title'          => 'Dipesh Jagtap | Senior Software Developer Pune | Laravel & PHP | SRV Media',
    'description'    => 'Dipesh Jagtap — Senior Software Developer at SRV Media, Pune. Laravel, PHP, REST APIs, CRM integrations, MySQL, MongoDB, AWS. Backend-focused portfolio.',
    'json_ld_person' => true,
    'single_page'    => true,
];

$loadIntlTelInput = true;

require __DIR__ . '/includes/header.php';

require __DIR__ . '/includes/hero.php';
require __DIR__ . '/includes/about-section.php';
require __DIR__ . '/includes/skills-section.php';
require __DIR__ . '/includes/experience-section.php';
require __DIR__ . '/includes/projects-section.php';
require __DIR__ . '/includes/resume-section.php';
require __DIR__ . '/includes/contact-section.php';

require __DIR__ . '/includes/footer.php';
