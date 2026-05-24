<section id="about" class="site-section" aria-labelledby="about-title">
    <div class="page-wrap">
        <header class="section-intro reveal">
            <span class="section-kicker">About</span>
            <h2 id="about-title" class="section-title">Backend systems built for production</h2>
            <p class="section-lead">
                I'm <strong>Dipesh Jagtap</strong>, a <strong>Senior Software Developer</strong> in <strong>Pune</strong> focused on Laravel, PHP, and platforms that stay fast, safe, and easy to evolve.
            </p>
        </header>

        <div class="glass-card glass-card--prose reveal">
            <p>
                I work on <strong>API design</strong>, backend architecture, and connections between business tools and the web—from authenticated endpoints to background processing and cloud-backed deployments.
            </p>
            <p>
                I enjoy solving backend problems that simplify day-to-day work and make platforms easier to maintain over time.
            </p>
            <p class="mb-0">
                I value maintainable systems, predictable releases, and backend logic that stays reliable as products evolve. I've shipped across server and UI boundaries—AJAX-driven screens, multilingual sites, and CMS-backed properties—with steady ownership of data integrity and releases.
            </p>
        </div>

        <div class="subsection reveal">
            <h3 class="subsection-title" id="languages-heading">Languages</h3>
            <ul class="tag-list tag-list--row" role="list">
                <li class="tag">English — professional</li>
                <li class="tag">Hindi — fluent</li>
                <li class="tag">Marathi — native</li>
            </ul>
        </div>

        <div class="subsection reveal">
            <h3 class="subsection-title" id="connect-heading">Connect</h3>
            <?php
            $publicPhoneTel = preg_replace('/\s+/', '', PUBLIC_PHONE_E164);
            $publicWhatsAppDigits = preg_replace('/\D+/', '', PUBLIC_PHONE_E164);
            $publicWhatsAppUrl = $publicWhatsAppDigits !== '' ? 'https://wa.me/' . $publicWhatsAppDigits : '';
            ?>
            <ul class="connect-links" role="list">
                <li>
                    <a class="connect-icon-link" href="mailto:<?= e(PUBLIC_EMAIL) ?>" aria-label="Email <?= e(PUBLIC_EMAIL) ?>">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </a>
                </li>
                <li>
                    <a class="connect-icon-link" href="https://www.linkedin.com/in/dipeshjagtap" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn (opens in new tab)">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                </li>
                <li>
                    <a class="connect-icon-link" href="https://x.com/dipeshjagtap" target="_blank" rel="noopener noreferrer" aria-label="X (opens in new tab)">
                        <i class="fab fa-x-twitter" aria-hidden="true"></i>
                    </a>
                </li>
                <?php if (PUBLIC_PHONE_E164 !== ''): ?>
                <li>
                    <a class="connect-icon-link" href="tel:<?= e($publicPhoneTel) ?>" aria-label="Phone <?= e(PUBLIC_PHONE_E164) ?>">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($publicWhatsAppUrl !== ''): ?>
                <li>
                    <a class="connect-icon-link" href="<?= e($publicWhatsAppUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp (opens in new tab)">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <a class="btn btn-primary nav-scroll connect-cta" href="<?= e(base_url('#contact')) ?>">Let's connect</a>
        </div>
    </div>
</section>
