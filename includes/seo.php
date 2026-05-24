<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/functions.php';

/**
 * Expects $pageMeta: title, description, og_image optional, json_ld_person bool, noindex optional,
 * single_page optional (canonical + og:url = home URL only)
 */
$meta = $pageMeta ?? [];
$title = $meta['title'] ?? SITE_NAME;
$description = $meta['description'] ?? SITE_TAGLINE;
$useHomeCanonical = !empty($meta['single_page']);
$canonical = $useHomeCanonical ? base_url('') : canonical_url();
$ogImage = $meta['og_image'] ?? asset_url('assets/images/profile.png');
$includeJsonLd = !empty($meta['json_ld_person']);
$noindex = !empty($meta['noindex']);

$personJson = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Person',
    'name'        => 'Dipesh Jagtap',
    'jobTitle'    => 'Senior Software Developer',
    'url'         => base_url(''),
    'image'       => asset_url('assets/images/profile.png'),
    'sameAs'      => [
        'https://www.linkedin.com/in/dipeshjagtap',
        'https://x.com/dipeshjagtap',
    ],
    'email'       => PUBLIC_EMAIL,
    'address'     => [
        '@type'           => 'PostalAddress',
        'addressLocality' => 'Pune',
        'addressRegion'   => 'Maharashtra',
        'addressCountry'  => 'IN',
    ],
    'worksFor'    => [
        '@type' => 'Organization',
        'name'  => 'SRV Media Pvt. Ltd.',
    ],
    'knowsAbout'  => [
        'Laravel', 'PHP', 'REST APIs', 'MySQL', 'MongoDB', 'JavaScript', 'AWS', 'CodeIgniter', 'Backend development',
    ],
    'description' => 'Senior Software Developer at SRV Media, Pune, building Laravel applications, backend systems, API integrations, and scalable web platforms.',
];

$personJson['contactPoint'] = [
    '@type'            => 'ContactPoint',
    'contactType'      => 'professional inquiries',
    'email'            => PUBLIC_EMAIL,
    'areaServed'       => 'IN',
    'availableLanguage'=> ['English', 'Hindi', 'Marathi'],
];

if (PUBLIC_PHONE_E164 !== '') {
    $personJson['telephone'] = PUBLIC_PHONE_E164;
    $personJson['contactPoint']['telephone'] = PUBLIC_PHONE_E164;
}

?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($description) ?>">
<meta name="author" content="Dipesh Jagtap">
<meta name="keywords" content="Dipesh Jagtap, Laravel Developer, PHP Developer, Full Stack Laravel Developer, REST API Developer, Laravel MySQL Developer, Web Application Developer, Software Developer Portfolio, Pune Laravel Developer">
<meta name="robots" content="<?= $noindex ? 'noindex, nofollow' : 'index, follow' ?>">
<meta name="theme-color" content="#0a0e17">
<link rel="canonical" href="<?= e($canonical) ?>">

<meta property="og:type" content="website">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:locale" content="en_IN">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($title) ?>">
<meta name="twitter:description" content="<?= e($description) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<link rel="apple-touch-icon" sizes="180x180" href="<?= e(asset_url('assets/images/favicon/apple-touch-icon.png')) ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?= e(asset_url('assets/images/favicon/favicon-32x32.png')) ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= e(asset_url('assets/images/favicon/favicon-16x16.png')) ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?= e(asset_url('assets/images/favicon/android-chrome-192x192.png')) ?>">
<link rel="icon" type="image/png" sizes="512x512" href="<?= e(asset_url('assets/images/favicon/android-chrome-512x512.png')) ?>">
<link rel="shortcut icon" href="<?= e(asset_url('assets/images/favicon/favicon.ico')) ?>">
<link rel="manifest" href="<?= e(asset_url('assets/images/favicon/site.webmanifest')) ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/main.css')) ?>">

<?php if ($includeJsonLd): ?>
<script type="application/ld+json"><?= json_encode($personJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endif; ?>
