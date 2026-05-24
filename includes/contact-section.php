<section id="contact" class="site-section site-section--alt site-section--contact" aria-labelledby="contact-title">
    <div class="page-wrap">
        <header class="section-intro reveal">
            <span class="section-kicker">Contact</span>
            <h2 id="contact-title" class="section-title">Let's talk</h2>
            <p class="section-lead">
                Product, integration, or role — I read everything and usually reply within a few business days.
            </p>
        </header>

        <div class="contact-layout reveal">
            <div id="contact-form-alerts" class="form-alerts" role="region" aria-live="polite"></div>

            <form id="contact-form" class="contact-form" method="post" action="<?= e(base_url('contact-submit.php')) ?>" novalidate autocomplete="on">
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

                <div class="form-group" data-field="name">
                    <label for="contact-name">Name</label>
                    <input id="contact-name" name="name" type="text" autocomplete="name" maxlength="120" aria-describedby="err-name" aria-invalid="false">
                    <span class="field-error" id="err-name" role="alert"></span>
                </div>
                <div class="form-group" data-field="email">
                    <label for="contact-email">Email</label>
                    <input id="contact-email" name="email" type="email" autocomplete="email" maxlength="190" aria-describedby="err-email" aria-invalid="false">
                    <span class="field-error" id="err-email" role="alert"></span>
                </div>
                <div class="form-group" data-field="phone">
                    <label for="contact-phone">Phone</label>
                    <input id="contact-phone" type="tel" autocomplete="tel" required aria-required="true" aria-describedby="err-phone" aria-invalid="false">
                    <input type="hidden" name="phone_country_code" id="phone_country_code" value="">
                    <input type="hidden" name="phone_number" id="phone_number" value="">
                    <input type="hidden" name="full_phone_number" id="full_phone_number" value="">
                    <span class="field-error" id="err-phone" role="alert"></span>
                </div>
                <div class="form-group" data-field="subject">
                    <label for="contact-subject">Subject</label>
                    <input id="contact-subject" name="subject" type="text" maxlength="200" aria-describedby="err-subject" aria-invalid="false">
                    <span class="field-error" id="err-subject" role="alert"></span>
                </div>
                <div class="form-group" data-field="message">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" maxlength="5000" aria-describedby="err-message" aria-invalid="false"></textarea>
                    <span class="field-error" id="err-message" role="alert"></span>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="contact-submit-btn">
                        <span class="btn-label"><i class="fas fa-paper-plane" aria-hidden="true"></i> Send message</span>
                        <span class="btn-loading" hidden>Sending…</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
