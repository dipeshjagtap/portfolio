<?php
declare(strict_types=1);

$chipTooltips = [
    'Laravel'             => 'Modern PHP framework for scalable backends, APIs, queues, and admin modules.',
    'MySQL'               => 'Relational database design, indexing, optimization, and transactional workloads.',
    'AJAX'                => 'Asynchronous requests for fast filtering, forms, and in-page updates without full reloads.',
    'AWS'                 => 'Cloud hosting, EC2 deployment, and infrastructure for production PHP applications.',
    'Easebuzz'            => 'Payment gateway integration for secure online transactions and checkout flows.',
    'Bootstrap'           => 'Responsive UI components and rapid layout for admin and marketing surfaces.',
    'REST APIs'           => 'HTTP APIs with clear endpoints, validation, and structured JSON for client and partner use.',
    'Microsoft Graph API' => 'Microsoft 365 integration for calendar, mail, and identity across enterprise accounts.',
    'OAuth 2.0'           => 'Standard authorization flows for secure third-party login and delegated API access.',
    'CMS'                 => 'Content management modules for editors to publish and update site content.',
    'Admin Panels'        => 'Role-based dashboards for managing records, content, and day-to-day operations.',
    'CRM Integrations'    => 'Connecting web forms and landing pages to CRM pipelines for lead capture and sync.',
    'Webhook Handling'    => 'Receiving and processing external event callbacks with validation and idempotency.',
    'jQuery'              => 'DOM manipulation, AJAX, and progressive enhancement in existing codebases.',
    'CodeIgniter'         => 'Lightweight PHP MVC framework for applications and REST-style services.',
    'Instamojo'           => 'Payment gateway for collections, checkout, and transaction tracking in India.',
    'Analytics'           => 'Usage metrics, reporting views, and data exports for product and ops decisions.',
    'Telr'                => 'Payment gateway for UAE and regional card processing and checkout flows.',
    'CCAvenue'            => 'Indian payment gateway integration for checkout, collections, and transaction reconciliation.',
];

function render_project_chip(string $label, array $tooltips, bool $withTooltip = false): void
{
    if (!$withTooltip) {
        echo '<span class="chip">', e($label), '</span>';
        return;
    }
    $tip = $tooltips[$label] ?? null;
    if ($tip === null) {
        echo '<span class="chip">', e($label), '</span>';
        return;
    }
    echo '<span class="chip tag--tooltip" tabindex="0" data-tooltip="', e($tip), '">', e($label), '</span>';
}

$projects = [
    [
        'id'                 => 'study-uae-collegevorti',
        'title'              => 'Study From UAE &amp; CollegeVorti',
        'type'               => 'Education Platforms',
        'summary'            => 'International education platforms for UAE and Bangladesh with university discovery, course exploration, and student journeys built to scale.',
        'chips'              => ['Laravel', 'MySQL', 'AJAX', 'AWS', 'Easebuzz', 'Bootstrap'],
        'links'              => [
            ['label' => 'Study From UAE', 'url' => 'https://www.studyfromuae.com/'],
            ['label' => 'CollegeVorti', 'url' => 'https://www.collegevorti.com/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Multi-role dashboards for admin, university, and student users',
            'Live university and course filtering without page reloads',
            'Easebuzz payment gateway for enrolment and fees',
            'Modular Laravel architecture with clear domain boundaries',
            'University search and filtering optimization',
            'Role-based administration panels for content and users',
            'AWS hosting tuned for traffic spikes and high availability',
            'Partner and internal endpoints for connected services',
        ],
    ],
    [
        'id'                 => 'actylis-pulse',
        'title'              => 'Actylis Pulse',
        'type'               => 'Enterprise Scheduling &amp; Meeting Workflow System',
        'summary'            => 'Internal enterprise platform for scheduling, Outlook calendar sync, and meeting coordination across teams.',
        'chips'              => ['Laravel', 'Microsoft Graph API', 'OAuth 2.0', 'AJAX', 'MySQL'],
        'links'              => [],
        'confidential_badge' => 'Internal enterprise project',
        'details'            => [
            'Meeting scheduling with approval and visibility rules',
            'Outlook single sign-on and Microsoft OAuth 2.0 for corporate accounts',
            'Two-way Outlook Calendar synchronization via Microsoft Graph',
            'Admin review steps before bookings go live',
            'Role-specific internal administration and reporting tools',
            'Reliable sync jobs when external calendars change',
            'UAT cycles with stakeholders before wider rollout',
            'Production hardening and launch support',
        ],
    ],
    [
        'id'                 => 'dynamic-admin-systems',
        'title'              => 'Dynamic Admin Systems',
        'type'               => 'Dynamic CMS &amp; Admin Platforms',
        'summary'            => 'CMS-driven admin platforms for enterprise and education sites with content, courses, and publishing tied together through APIs.',
        'chips'              => ['Laravel', 'CMS', 'AJAX', 'MySQL', 'Bootstrap', 'Admin Panels'],
        'links'              => [
            ['label' => 'Actylis', 'url' => 'https://actylis.com/'],
            ['label' => 'SIT Nagpur', 'url' => 'https://sitnagpur.edu.in/'],
            ['label' => 'SIU Dubai', 'url' => 'https://siu-dubai.ac.ae/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'CMS modules linked to public site content via APIs',
            'Course catalogues with structured programme data',
            'Role-based administration panels across admin, editor, and viewer roles',
            'AJAX CRUD for fast record updates in the panel',
            'Reusable Laravel modules shared across properties',
            'Publishing flows from draft to live with checks',
            'Hardened authentication for privileged accounts',
        ],
    ],
    [
        'id'                 => 'landing-crm-systems',
        'title'              => 'Landing Page &amp; CRM Integration Systems',
        'type'               => 'Marketing &amp; Lead Generation Systems',
        'summary'            => 'Campaign landing pages with CRM-connected lead capture, validation, and real-time enquiry handoff to sales pipelines.',
        'chips'              => ['Laravel', 'CRM Integrations', 'AJAX', 'MySQL', 'Webhook Handling', 'jQuery'],
        'links'              => [],
        'confidential_badge' => null,
        'details'            => [
            'CRM connectors for lead routing and field mapping',
            'Form capture with server-side validation rules',
            'Near real-time enquiry sync to CRM records',
            'Dynamic forms driven by campaign configuration',
            'Webhook handling for marketing and attribution tools',
            'Server logic behind high-traffic landing pages',
            'Pre-launch testing and campaign go-live support',
        ],
    ],
    [
        'id'                 => 'vvm',
        'title'              => 'Vidyarthi Vigyan Manthan (VVM)',
        'type'               => 'National-Level Science Learning Platform',
        'summary'            => 'Nationwide science learning and examination platform with registration at scale, Instamojo payments, quizzes, analytics, and exam delivery.',
        'chips'              => ['CodeIgniter', 'MySQL', 'AWS', 'Instamojo', 'Analytics', 'Admin Panels'],
        'links'              => [
            ['label' => 'VVM', 'url' => 'https://vvm.org.in/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Student enrolment and profile management at national scale',
            'Quiz and examination modules with scoring rules',
            'Analytics dashboards and exportable reports',
            'Instamojo integration for registration fees and checkout flows',
            'AWS-hosted infrastructure sized for peak registration traffic',
            'Role-based administration for coordinators and reviewers',
            'Query and cache tuning under load',
        ],
    ],
    [
        'id'                 => 'iisf',
        'title'              => 'IISF',
        'type'               => 'National Science Festival Management Platform',
        'summary'            => 'National science festival platform with participant coordination, content publishing, and festival administration in one place.',
        'chips'              => ['CodeIgniter', 'MySQL', 'CMS', 'Admin Panels', 'AJAX'],
        'links'              => [
            ['label' => 'Visit Website', 'url' => 'https://www.scienceindiafest.org/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Role-based administration for festival organisers and partners',
            'Participant registration and assignment tracking',
            'CMS for schedules, pages, and announcements',
            'Event administration across venues and tracks',
            'Coordinator tooling for on-the-ground festival operations',
            'Editorial publishing with review before go-live',
            'Ongoing fixes and releases through festival cycles',
        ],
    ],
    [
        'id'                 => 'sif-uae-qatar',
        'title'              => 'SIF UAE &amp; SIF Qatar',
        'type'               => 'International Quiz &amp; Event Management Platforms',
        'summary'            => 'Quiz and event platforms for UAE and Qatar with registrations, Telr payments, analytics, and role-based administration.',
        'chips'              => ['CodeIgniter', 'MySQL', 'Telr', 'AJAX', 'Analytics', 'Admin Panels'],
        'links'              => [
            ['label' => 'SIF UAE', 'url' => 'https://sifuae.com/'],
            ['label' => 'SIF Qatar', 'url' => 'https://sifqatar.com/'],
        ],
        'confidential_badge' => null,
        'details'            => [
            'Quiz creation, delivery, and scoring for competitions',
            'Student event registration and check-in flows',
            'Enrolment handling across school and regional levels',
            'Reporting for participation and performance trends',
            'Telr integration for regional registration fees and checkout',
            'Role-based administration for organisers, schools, and reviewers',
            'Flexible admin configuration per country instance',
        ],
    ],
];
?>
<section id="projects" class="site-section site-section--alt" aria-labelledby="projects-title">
    <div class="page-wrap">
        <header class="section-intro reveal">
            <span class="section-kicker">Projects</span>
            <h2 id="projects-title" class="section-title">Featured projects</h2>
            <p class="section-lead">
                Production platforms I've built and maintained across education, enterprise, and event ecosystems.
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
                    <?php render_project_chip($c, $chipTooltips, false); ?>
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
                        See details
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

                    <h3 class="project-modal-heading">Key work</h3>
                    <ul class="project-modal-list">
                        <?php foreach ($p['details'] as $line): ?>
                        <li><?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3 class="project-modal-heading">Tech stack</h3>
                    <div class="project-modal-chips">
                        <?php foreach ($p['chips'] as $c): ?>
                        <?php render_project_chip($c, $chipTooltips, true); ?>
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
