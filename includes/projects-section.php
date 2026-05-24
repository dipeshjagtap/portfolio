<?php
declare(strict_types=1);

$projects = [
    [
        'id'                 => 'study-uae-collegevorti',
        'title'              => 'Study From UAE &amp; CollegeVorti',
        'type'               => 'Education Platforms',
        'summary'            => 'International education platforms for UAE and Bangladesh focused on university discovery, course exploration, and scalable student workflows.',
        'chips'              => ['Laravel', 'MySQL', 'AJAX', 'AWS', 'Easebuzz', 'Bootstrap', 'REST APIs'],
        'links'              => [
            ['label' => 'Study From UAE', 'url' => 'https://www.studyfromuae.com/'],
            ['label' => 'CollegeVorti', 'url' => 'https://www.collegevorti.com/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Multi-role dashboards (Admin, University, Student)',
            'AJAX-powered university and course filtering',
            'Dynamic course management workflows',
            'Payment gateway integration',
            'Backend API integrations',
            'AWS deployment and optimization',
            'High-availability infrastructure',
            'Modular Laravel architecture',
            'Search optimization',
            'Admin management systems',
        ],
    ],
    [
        'id'                 => 'actylis-pulse',
        'title'              => 'Actylis Pulse',
        'type'               => 'Enterprise Scheduling &amp; Meeting Workflow System',
        'summary'            => 'Internal enterprise workflow platform focused on scheduling, Outlook synchronization, and operational meeting management.',
        'chips'              => ['Laravel', 'Microsoft Graph API', 'OAuth 2.0', 'REST APIs', 'AJAX', 'MySQL'],
        'links'              => [],
        'confidential_badge' => 'Internal enterprise project',
        'details'            => [
            'Scheduling and meeting management workflows',
            'Outlook Login (SSO) integration',
            'Microsoft OAuth 2.0 authentication',
            'Two-way Outlook Calendar synchronization',
            'Microsoft Graph API integration',
            'Admin approval workflows',
            'Enterprise operational tooling',
            'Backend synchronization handling',
            'UAT collaboration workflows',
            'Production readiness support',
        ],
    ],
    [
        'id'                 => 'dynamic-admin-systems',
        'title'              => 'Dynamic Admin Systems',
        'type'               => 'Dynamic CMS &amp; Admin Platforms',
        'summary'            => 'Dynamic admin systems and CMS-driven platforms powering enterprise and educational websites with API-connected content workflows.',
        'chips'              => ['Laravel', 'CMS', 'AJAX', 'MySQL', 'REST APIs', 'Bootstrap', 'Admin Panels'],
        'links'              => [
            ['label' => 'Actylis', 'url' => 'https://actylis.com/'],
            ['label' => 'SIT Nagpur', 'url' => 'https://sitnagpur.edu.in/'],
            ['label' => 'SIU Dubai', 'url' => 'https://siu-dubai.ac.ae/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'API-linked CMS modules',
            'Dynamic content management systems',
            'Course management workflows',
            'Role-based access control',
            'AJAX CRUD operations',
            'Multi-panel administration',
            'Dynamic backend modules',
            'Content publishing systems',
            'Operational management workflows',
            'Secure admin authentication systems',
        ],
    ],
    [
        'id'                 => 'landing-crm-systems',
        'title'              => 'Landing Page &amp; CRM Integration Systems',
        'type'               => 'Marketing &amp; Lead Generation Systems',
        'summary'            => 'Backend integrations and CRM-connected lead generation systems powering campaign landing pages and enquiry workflows.',
        'chips'              => ['Laravel', 'REST APIs', 'CRM Integrations', 'AJAX', 'MySQL', 'Webhook Handling', 'jQuery'],
        'links'              => [],
        'confidential_badge' => null,
        'details'            => [
            'CRM integrations',
            'Lead capture workflows',
            'Real-time enquiry synchronization',
            'Dynamic form processing',
            'API-based campaign integrations',
            'Form validation systems',
            'Marketing automation workflows',
            'Landing page backend integrations',
            'Lead tracking consistency',
            'Campaign testing and launch support',
        ],
    ],
    [
        'id'                 => 'vvm',
        'title'              => 'Vidyarthi Vigyan Manthan (VVM)',
        'type'               => 'National-Level Science Learning Platform',
        'summary'            => 'Large-scale science learning and examination platform supporting nationwide student registration, quizzes, analytics, and examination workflows.',
        'chips'              => ['CodeIgniter', 'MySQL', 'AWS', 'Instamojo', 'Analytics', 'Admin Panels'],
        'links'              => [
            ['label' => 'Visit Website', 'url' => 'https://vvm.org.in/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Student management workflows',
            'Quiz and examination systems',
            'Large-scale registration handling',
            'Analytics and reporting modules',
            'Payment gateway integration',
            'AWS-hosted infrastructure',
            'Admin management systems',
            'Examination workflows',
            'Backend optimization',
            'Scalable CodeIgniter architecture',
        ],
    ],
    [
        'id'                 => 'iisf',
        'title'              => 'IISF',
        'type'               => 'National Science Festival Management Platform',
        'summary'            => 'Administrative and operational platform supporting national-level science festival management, participant coordination, and dynamic backend workflows.',
        'chips'              => ['CodeIgniter', 'MySQL', 'REST APIs', 'CMS', 'Admin Panels', 'AJAX'],
        'links'              => [
            ['label' => 'Visit Website', 'url' => 'https://www.scienceindiafest.org/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Admin panel development',
            'API integrations',
            'Participant coordination workflows',
            'Dynamic content management',
            'Event administration systems',
            'Backend operational tooling',
            'Content publishing workflows',
            'Event management support systems',
            'Database-driven administration modules',
            'Backend maintenance and operational support',
        ],
    ],
    [
        'id'                 => 'sif-uae-qatar',
        'title'              => 'SIF UAE &amp; SIF Qatar',
        'type'               => 'International Quiz &amp; Event Management Platforms',
        'summary'            => 'Student-focused event and quiz management platforms for UAE and Qatar supporting registrations, analytics, payment processing, and multi-role administration.',
        'chips'              => ['CodeIgniter', 'MySQL', 'Telr', 'AJAX', 'Analytics', 'Admin Panels'],
        'links'              => [
            ['label' => 'SIF UAE', 'url' => 'https://sifuae.com/'],
            ['label' => 'SIF Qatar', 'url' => 'https://sifqatar.com/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Quiz management systems',
            'Student event workflows',
            'Registration systems',
            'Multi-role admin panels',
            'Reporting and analytics workflows',
            'Event coordination systems',
            'Payment gateway integration',
            'Backend workflow automation',
            'Educational competition management',
            'Dynamic administration systems',
        ],
    ],
];
?>
<section id="projects" class="site-section site-section--alt" aria-labelledby="projects-title">
    <div class="page-wrap">
        <header class="section-intro reveal">
            <span class="section-kicker">Projects</span>
            <h2 id="projects-title" class="section-title">Selected production work</h2>
            <p class="section-lead">
                Real platforms and integrations—backend ownership, multi-role systems, and long-running production support. Open a card for engineering detail.
            </p>
        </header>

        <div class="card-grid cols-2 project-grid">
            <?php foreach ($projects as $p): ?>
            <article
                class="glass-card project-card reveal project-card--interactive"
                data-project-modal="<?= e($p['id']) ?>"
                tabindex="0"
            >
                <p class="project-card__type"><?= $p['type'] ?></p>
                <h3 class="project-card__title"><?= $p['title'] ?></h3>
                <p class="project-card__summary"><?= $p['summary'] ?></p>
                <div class="meta project-card__chips">
                    <?php foreach ($p['chips'] as $c): ?>
                    <span class="chip"><?= e($c) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="project-card__actions">
                    <?php if (!empty($p['links'])): ?>
                    <div class="project-card__links">
                        <?php foreach ($p['links'] as $link): ?>
                        <a class="btn btn-secondary btn-sm project-card__visit" href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($link['label']) ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php elseif (!empty($p['confidential_badge'])): ?>
                    <span class="project-card__badge"><?= e($p['confidential_badge']) ?></span>
                    <?php endif; ?>
                    <button type="button" class="btn btn-primary btn-sm project-card__details">
                        View Details
                    </button>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="project-modal-root" class="project-modal-root" aria-hidden="true" hidden>
        <div class="project-modal-backdrop" data-project-modal-close tabindex="-1"></div>
        <div class="project-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="">
            <button type="button" class="project-modal-close btn btn-ghost" data-project-modal-close aria-label="Close project details">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="project-modal-scroll">
                <?php foreach ($projects as $p): ?>
                <div class="project-modal-panel" id="project-modal-panel-<?= e($p['id']) ?>" hidden>
                    <p class="project-modal-type"><?= $p['type'] ?></p>
                    <h2 class="project-modal-title" id="project-modal-title-<?= e($p['id']) ?>"><?= $p['title'] ?></h2>
                    <p class="project-modal-lead"><?= $p['summary'] ?></p>

                    <h3 class="project-modal-heading">Engineering highlights</h3>
                    <ul class="project-modal-list">
                        <?php foreach ($p['details'] as $line): ?>
                        <li><?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3 class="project-modal-heading">Tech stack</h3>
                    <div class="project-modal-chips">
                        <?php foreach ($p['chips'] as $c): ?>
                        <span class="chip"><?= e($c) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="project-modal-footer-actions">
                        <?php if (!empty($p['links'])): ?>
                        <?php foreach ($p['links'] as $link): ?>
                        <a class="btn btn-secondary" href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($link['label']) ?></a>
                        <?php endforeach; ?>
                        <?php elseif (!empty($p['confidential_badge'])): ?>
                        <p class="project-modal-confidential muted"><?= e($p['confidential_badge']) ?> — no public URL.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
