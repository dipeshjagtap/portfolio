<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';

start_public_session();

$bodyClass = '';

$pageMeta = [
    'title'            => 'Resume | Dipesh Jagtap — CV & Education',
    'description'      => 'Resume summary, education (MCA, BSc CS — SPPU), certifications and honors, and PDF download. Dipesh Jagtap — Senior Software Developer, Pune.',
    'json_ld_person'   => false,
];

$pdfPath = __DIR__ . '/assets/uploads/dipesh-jagtap-resume.pdf';
$pdfExists = is_file($pdfPath);

require __DIR__ . '/includes/header.php';
?>
<div class="page-wrap">
    <p class="resume-back reveal"><a class="text-link nav-scroll" href="<?= e(base_url('#resume')) ?>">← Back to portfolio</a></p>
    <header class="page-hero reveal">
        <h1 class="page-title">Resume</h1>
        <p class="page-lead">
            Download a concise CV or browse the classic interactive resume — same professional story, your choice of format.
        </p>
    </header>

    <div class="glass-card reveal stack" style="margin-bottom:1.5rem;">
        <p style="margin:0; color:var(--muted); max-width:65ch;">
            <strong>Dipesh Jagtap</strong> — <strong>Senior Software Developer</strong> at <strong>SRV Media</strong>, Pune. I build Laravel and PHP systems with strong API surfaces, thoughtful data modeling, and dependable cloud deployment practices.
        </p>
        <div class="hero-actions" style="margin-top:0.5rem;">
            <?php if ($pdfExists): ?>
            <a class="btn btn-primary" href="<?= e(asset_url('assets/uploads/dipesh-jagtap-resume.pdf')) ?>" download>
                <i class="fas fa-file-pdf" aria-hidden="true"></i> Download PDF
            </a>
            <?php else: ?>
            <span class="btn btn-secondary" style="opacity:0.85; cursor:default;" title="Upload dipesh-jagtap-resume.pdf to assets/uploads/">
                PDF not uploaded yet
            </span>
            <?php endif; ?>
            <a class="btn btn-secondary" href="<?= e(base_url('classic-resume/')) ?>">Classic resume site</a>
        </div>
    </div>

    <section class="section reveal" aria-labelledby="edu-heading">
        <div class="section-head">
            <h2 id="edu-heading">Education</h2>
        </div>
        <div class="card-grid cols-2">
            <div class="glass-card">
                <h3>Savitribai Phule Pune University</h3>
                <p class="muted" style="margin:0;">Master of Computer Applications (MCA), Computer Science — 2014–2017</p>
            </div>
            <div class="glass-card">
                <h3>Savitribai Phule Pune University</h3>
                <p class="muted" style="margin:0;">Bachelor of Science (BSc), Computer Science — 2010–2013</p>
            </div>
        </div>
    </section>

    <section class="section reveal" aria-labelledby="cert-heading">
        <div class="section-head">
            <h2 id="cert-heading">Certifications &amp; honors</h2>
        </div>
        <div class="glass-card">
            <h3 style="margin-top:0;">Honors &amp; awards</h3>
            <ul class="muted" style="margin:0; padding-left:1.2rem;">
                <li>
                    <a href="https://www.linkedin.com/posts/dipeshjagtap_appreciation-recognition-hardwork-activity-7276445592678023168-Jlpl" target="_blank" rel="noopener noreferrer">
                        Certificate of Appreciation (FY 2024–25), SRV Media
                    </a>
                </li>
            </ul>
        </div>
    </section>
</div>
<?php require __DIR__ . '/includes/footer.php';
