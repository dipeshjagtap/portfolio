<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/functions.php';

$footerPhoneTel = preg_replace('/\s+/', '', PUBLIC_PHONE_E164);
$footerWaDigits = preg_replace('/\D+/', '', PUBLIC_PHONE_E164);
$footerWaUrl = $footerWaDigits !== '' ? 'https://wa.me/' . $footerWaDigits : '';
?>
</main>
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <strong><?= e(SITE_NAME) ?></strong>
            <span class="footer-tagline"><?= e(SITE_TAGLINE) ?> · Pune, India</span>
            <p class="footer-closing">
                Backend engineering, API integration, and scalable web applications — available for selective engagements and serious product work.
            </p>
        </div>
        <div class="footer-social-wrap">
            <div class="footer-social" aria-label="Social and contact links">
                <a href="mailto:<?= e(PUBLIC_EMAIL) ?>" aria-label="Email"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                <a href="https://www.linkedin.com/in/dipeshjagtap" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                <a href="https://x.com/dipeshjagtap" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
                <?php if (PUBLIC_PHONE_E164 !== ''): ?>
                <a href="tel:<?= e($footerPhoneTel) ?>" aria-label="Phone"><i class="fas fa-phone" aria-hidden="true"></i></a>
                <?php endif; ?>
                <?php if ($footerWaUrl !== ''): ?>
                <a href="<?= e($footerWaUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <p class="footer-meta">
            <a href="<?= e(base_url('classic-resume/')) ?>" class="footer-legacy">Classic resume</a>
            · &copy; <?= (int) date('Y') ?> <?= e(SITE_NAME) ?>
        </p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php if (!empty($loadIntlTelInput)): ?>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@28.0.5/dist/js/intlTelInput.min.js" crossorigin="anonymous"></script>
<?php endif; ?>
<script src="<?= e(asset_url('assets/js/main.js')) ?>" defer></script>
</body>
</html>
