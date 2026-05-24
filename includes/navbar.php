<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/functions.php';

$navItems = [
    ['id' => 'hero', 'label' => 'Home'],
    ['id' => 'about', 'label' => 'About'],
    ['id' => 'skills', 'label' => 'Skills'],
    ['id' => 'experience', 'label' => 'Experience'],
    ['id' => 'projects', 'label' => 'Projects'],
    ['id' => 'resume', 'label' => 'Resume'],
    ['id' => 'contact', 'label' => 'Contact'],
];
?>
<a href="#hero" class="skip-link">Skip to content</a>
<header class="site-header" id="site-header">
    <div class="header-inner">
        <a class="brand nav-scroll" href="<?= e(base_url('#hero')) ?>">
            <span class="brand-mark">DJ</span>
            <span class="brand-text"><?= e(SITE_NAME) ?></span>
        </a>
        <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>
        <nav class="primary-nav" id="primary-nav" aria-label="Primary">
            <ul class="nav-list">
                <?php foreach ($navItems as $item):
                    $href = base_url('#' . $item['id']);
                    ?>
                <li>
                    <a class="nav-link nav-scroll" href="<?= e($href) ?>" data-section="#<?= e($item['id']) ?>"><?= e($item['label']) ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
