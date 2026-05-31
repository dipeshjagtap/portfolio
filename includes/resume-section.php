<?php
declare(strict_types=1);

$pdfPathSection = dirname(__DIR__) . '/assets/uploads/dipesh-jagtap-resume.pdf';
$pdfOk = is_file($pdfPathSection);
?>
<section id="resume" class="site-section" aria-labelledby="resume-title">
    <div class="page-wrap">
        <header class="section-intro reveal">
            <span class="section-kicker">Resume</span>
            <h2 id="resume-title" class="section-title">CV &amp; credentials</h2>
            <p class="section-lead">
                <strong>Dipesh Jagtap</strong> — <strong>Senior Software Developer</strong> at <strong>SRV Media</strong>. MCA &amp; BSc CS (SPPU). Certificate of Appreciation (FY 2024–25).
            </p>
        </header>

        <div class="resume-actions glass-card reveal">
            <div class="resume-actions__inner">
                <?php if ($pdfOk): ?>
                <a class="btn btn-primary btn--lg" href="<?= e(asset_url('assets/uploads/dipesh-jagtap-resume.pdf')) ?>" download>
                    <i class="fas fa-file-pdf" aria-hidden="true"></i> Download PDF
                </a>
                <?php else: ?>
                <span class="btn btn-secondary is-disabled btn--lg" aria-disabled="true">
                    <i class="fas fa-file-pdf" aria-hidden="true"></i> PDF resume coming soon
                </span>
                <?php endif; ?>
                <div class="resume-actions__secondary">
                    <a class="btn btn-secondary" href="<?= e(base_url('resume')) ?>">Full resume page</a>
                    <a class="btn btn-ghost" href="<?= e(base_url('classic-resume/')) ?>">Classic site</a>
                </div>
            </div>
            <p class="resume-hint muted">Download the PDF resume or browse education, certifications, and honors on the <a href="<?= e(base_url('resume')) ?>">dedicated resume page</a>.</p>
        </div>
    </div>
</section>
