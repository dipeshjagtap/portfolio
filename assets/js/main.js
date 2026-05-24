(function ($) {
    "use strict";

    var $win = $(window);
    var $doc = $(document);
    var $header = $("#site-header");
    var ITI_VERSION = "28.0.5";
    var ITI_UTILS_URL =
        "https://cdn.jsdelivr.net/npm/intl-tel-input@" + ITI_VERSION + "/dist/js/utils.js";

    function headerH() {
        return $header.outerHeight() || 64;
    }

    function pathsMatchForHash(href) {
        try {
            var a = document.createElement("a");
            a.href = href;
            var p1 = (a.pathname.replace(/\/$/, "") || "/") + (a.search || "");
            var p2 = (window.location.pathname.replace(/\/$/, "") || "/") + (window.location.search || "");
            return p1.split("?")[0] === p2.split("?")[0];
        } catch (e) {
            return false;
        }
    }

    $doc.on("click", "a.nav-scroll", function (e) {
        var href = $(this).attr("href");
        if (!href || href.indexOf("#") === -1) {
            return;
        }
        var tmp = document.createElement("a");
        tmp.href = href;
        if (!pathsMatchForHash(href)) {
            return;
        }
        var hash = tmp.hash;
        if (!hash) {
            return;
        }
        var $t = $(hash);
        if (!$t.length) {
            return;
        }
        e.preventDefault();
        var top = $t.offset().top - headerH() + 2;
        $("html, body").stop().animate({ scrollTop: top }, 450);
        $("#primary-nav").removeClass("is-open");
        $(".nav-toggle").attr("aria-expanded", "false").attr("aria-label", "Open menu");
        if (history.pushState) {
            history.pushState(null, "", href);
        }
    });

    $win.on("load", function () {
        var h = window.location.hash;
        if (h && $(h).length) {
            var top = $(h).offset().top - headerH() + 2;
            $("html, body").scrollTop(top);
        }
    });

    $win.on("scroll", function () {
        $header.toggleClass("is-scrolled", window.scrollY > 12);
    }).trigger("scroll");

    var sectionIds = ["#hero", "#about", "#skills", "#experience", "#projects", "#resume", "#contact"];
    function scrollSpy() {
        if (!$(".is-single-page").length) {
            return;
        }
        var pos = $win.scrollTop() + headerH() + 48;
        var active = "#hero";
        sectionIds.forEach(function (id) {
            var $el = $(id);
            if ($el.length && $el.offset().top <= pos) {
                active = id;
            }
        });
        $(".nav-link[data-section]").removeClass("is-active");
        $('.nav-link[data-section="' + active + '"]').addClass("is-active");
    }
    $win.on("scroll resize", scrollSpy);
    scrollSpy();

    $(".nav-toggle").on("click", function () {
        var open = $("#primary-nav").toggleClass("is-open").hasClass("is-open");
        $(this).attr("aria-expanded", open).attr("aria-label", open ? "Close menu" : "Open menu");
    });

    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (!reduceMotion && "IntersectionObserver" in window) {
        var obs = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        obs.unobserve(entry.target);
                    }
                });
            },
            { rootMargin: "0px 0px -6% 0px", threshold: 0.06 }
        );
        document.querySelectorAll(".reveal").forEach(function (el) {
            obs.observe(el);
        });
    } else {
        document.querySelectorAll(".reveal").forEach(function (el) {
            el.classList.add("is-visible");
        });
    }

    function initTenure() {
        var longEl = document.getElementById("hero-exp-phrase");
        var shortEl = document.getElementById("hero-exp-short");
        if (!longEl && !shortEl) {
            return;
        }
        var startIso = (longEl && longEl.getAttribute("data-start")) || "2018-10-01";
        var start = new Date(startIso + "T12:00:00");
        var now = new Date();
        if (isNaN(start.getTime()) || now < start) {
            return;
        }
        var y0 = start.getFullYear();
        var m0 = start.getMonth();
        var y1 = now.getFullYear();
        var m1 = now.getMonth();
        var totalMonths = (y1 - y0) * 12 + (m1 - m0);
        var rem = totalMonths % 12;
        var years = (totalMonths - rem) / 12;
        function plural(n, one, many) {
            return n === 1 ? one : many;
        }
        var longText;
        if (rem === 0) {
            longText = years + plural(years, " year", " years");
        } else {
            longText =
                years +
                plural(years, " year", " years") +
                " " +
                rem +
                plural(rem, " month", " months");
        }
        var shortText = rem > 0 ? years + "+ yrs" : years + " yrs";
        if (longEl) {
            longEl.textContent = longText;
        }
        if (shortEl) {
            shortEl.textContent = shortText;
        }
    }

    function initTooltipTags() {
        var tipEl = document.getElementById("skill-tooltip");
        if (!tipEl) {
            tipEl = document.createElement("div");
            tipEl.id = "skill-tooltip";
            tipEl.className = "skill-tooltip";
            tipEl.setAttribute("role", "tooltip");
            document.body.appendChild(tipEl);
        }
        var hideTimer;
        function hideTip() {
            tipEl.classList.remove("is-visible");
            tipEl.textContent = "";
        }
        function showTip(el) {
            var text = el.getAttribute("data-tooltip");
            if (!text) {
                return;
            }
            clearTimeout(hideTimer);
            tipEl.textContent = text;
            tipEl.classList.add("is-visible");
            function placeTip() {
                var r = el.getBoundingClientRect();
                var tw = tipEl.offsetWidth;
                var th = tipEl.offsetHeight;
                var x = Math.round(r.left + r.width / 2 - tw / 2);
                var y = Math.round(r.top - th - 10);
                x = Math.max(10, Math.min(x, window.innerWidth - tw - 10));
                if (y < 10) {
                    y = Math.round(r.bottom + 10);
                }
                tipEl.style.left = x + "px";
                tipEl.style.top = y + "px";
            }
            requestAnimationFrame(function () {
                placeTip();
                if (tipEl.offsetWidth < 8) {
                    requestAnimationFrame(placeTip);
                }
            });
        }
        $doc.on("mouseenter.tooltips", "#skills .tag--tooltip, .project-modal-root .tag--tooltip", function (e) {
            e.stopPropagation();
            showTip(this);
        });
        $doc.on("mouseleave.tooltips", "#skills .tag--tooltip, .project-modal-root .tag--tooltip", function () {
            hideTimer = setTimeout(hideTip, 80);
        });
        $doc.on("focusin.tooltips", "#skills .tag--tooltip, .project-modal-root .tag--tooltip", function () {
            showTip(this);
        });
        $doc.on("focusout.tooltips", "#skills .tag--tooltip, .project-modal-root .tag--tooltip", function () {
            hideTimer = setTimeout(hideTip, 100);
        });
        $win.on("scroll.tooltips resize.tooltips", hideTip);
        $doc.on("scroll.tooltips", ".project-modal-scroll", hideTip);
    }

    initTenure();
    initTooltipTags();

    function initProjectModals() {
        var $root = $("#project-modal-root");
        if (!$root.length) {
            return;
        }
        var $dialog = $root.find(".project-modal-dialog");
        var lastFocus = null;

        function openModal(id) {
            var $panel = $("#project-modal-panel-" + id);
            if (!$panel.length) {
                return;
            }
            lastFocus = document.activeElement;
            $root.find(".project-modal-panel").attr("hidden", true);
            $panel.removeAttr("hidden");
            $dialog.attr("aria-labelledby", "project-modal-title-" + id);
            $root.removeAttr("hidden").attr("aria-hidden", "false");
            $("body").addClass("project-modal-open");
            requestAnimationFrame(function () {
                $root.addClass("is-open");
            });
            setTimeout(function () {
                $root.find(".project-modal-close").first().trigger("focus");
            }, 40);
        }

        function closeModal() {
            $root.removeClass("is-open");
            $("body").removeClass("project-modal-open");
            setTimeout(function () {
                $root.attr("hidden", true).attr("aria-hidden", "true");
                $root.find(".project-modal-panel").attr("hidden", true);
                $dialog.attr("aria-labelledby", "");
                if (lastFocus && typeof lastFocus.focus === "function") {
                    lastFocus.focus();
                }
                lastFocus = null;
            }, 280);
        }

        $("#projects").on("click", ".project-card--interactive", function (e) {
            if ($(e.target).closest("a.project-card__visit").length) {
                return;
            }
            e.preventDefault();
            var id = $(this).data("projectModal");
            if (id) {
                openModal(id);
            }
        });

        $("#projects").on("keydown", ".project-card--interactive", function (e) {
            if (e.key !== "Enter" && e.key !== " ") {
                return;
            }
            if ($(e.target).closest("a.project-card__visit").length) {
                return;
            }
            e.preventDefault();
            var id = $(this).data("projectModal");
            if (id) {
                openModal(id);
            }
        });

        $root.on("click", "[data-project-modal-close]", function (e) {
            e.preventDefault();
            closeModal();
        });

        $root.on("click", function (e) {
            if ($(e.target).is($root)) {
                closeModal();
            }
        });

        $doc.on("keydown.projectModal", function (e) {
            if (e.key === "Escape" && $root.hasClass("is-open")) {
                closeModal();
            }
        });
    }

    initProjectModals();

    var $form = $("#contact-form");
    if (!$form.length) {
        return;
    }

    var $alerts = $("#contact-form-alerts");
    var $btn = $("#contact-submit-btn");
    var contactIti = null;
    var phoneFieldTouched = false;
    var phoneInputHasFocus = false;
    var textFieldTouched = { name: false, email: false, subject: false, message: false };

    var phoneInputEl = document.querySelector("#contact-phone");
    if (phoneInputEl && typeof window.intlTelInput === "function") {
        contactIti = window.intlTelInput(phoneInputEl, {
            initialCountry: "in",
            countryOrder: ["in", "us", "gb"],
            separateDialCode: true,
            strictMode: true,
            formatOnDisplay: true,
            countrySearch: true,
            loadUtils: function () {
                return import(ITI_UTILS_URL);
            },
        });
        phoneInputEl.addEventListener("countrychange", function () {
            $(phoneInputEl).trigger("input");
        });
    }

    $form.on("focusin", "#contact-phone", function () {
        phoneFieldTouched = true;
        phoneInputHasFocus = true;
    });

    $form.on("focusout", "#contact-phone", function () {
        phoneInputHasFocus = false;
    });

    $form.on(
        "focusin",
        'input[name="name"], input[name="email"], input[name="subject"], textarea[name="message"]',
        function () {
            textFieldTouched[$(this).attr("name")] = true;
        }
    );

    var CONTACT_LIMITS = {
        nameMax: 120,
        nameMinChars: 3,
        emailMax: 190,
        subjectMax: 200,
        subjectMinChars: 8,
        subjectMinAlpha: 5,
        messageMax: 5000,
        messageMinChars: 24,
        messageMinWords: 4,
        debounceMs: 420,
        phoneLiveDebounceMs: 720,
        ajaxTimeoutMs: 45000,
    };

    var NAME_SPAM_TOKENS = {
        admin: true,
        test: true,
        user: true,
        guest: true,
        unknown: true,
        person: true,
        name: true,
        fake: true,
        spam: true,
        null: true,
        undefined: true,
        qwerty: true,
        asdf: true,
        asdfg: true,
        zxcvb: true,
        placeholder: true,
        nobody: true,
        someone: true,
        anyone: true,
    };

    var EMAIL_BLOCKED_TLDS = {
        test: true,
        invalid: true,
        example: true,
        localhost: true,
        local: true,
        onion: true,
    };

    function formGroupFor(field) {
        return $form.find('.form-group[data-field="' + field + '"]');
    }

    function contactControl(field) {
        if (field === "phone") {
            return $form.find("#contact-phone");
        }
        return $form.find('[name="' + field + '"]').first();
    }

    var CONTACT_TEXT_FIELDS = ["name", "email", "subject", "message"];

    var MSG_NAME_FULL = "Please enter your full name.";
    var MSG_NAME_LETTERS = "Name should contain only letters and valid spaces.";
    var MSG_NAME_MEANINGFUL = "Please enter a meaningful name.";
    var MSG_EMAIL_PRO = "Please enter a valid professional email address.";
    var MSG_SUBJECT_MEANINGFUL = "Please enter a meaningful subject.";
    var MSG_SUBJECT_LONG = "Subject is too long (max 200 characters).";
    var MSG_MESSAGE_DETAIL = "Please enter a message with a bit more detail.";
    var MSG_MESSAGE_LONG = "Message is too long (max 5000 characters).";
    var MSG_MESSAGE_MEANINGFUL = "Please enter a meaningful message.";

    function normalizeContactText(s, opts) {
        opts = opts || {};
        if (typeof s !== "string") {
            s = "";
        }
        s = s.replace(/[\u200B-\u200F\u202A-\u202E\uFEFF]/g, "");
        s = s.replace(/\u00A0|\u202F|\u2007|\u3000/g, " ");
        if (opts.isMessage) {
            s = s.replace(/\r\n/g, "\n").replace(/\r/g, "\n");
            s = s.replace(/\n{3,}/g, "\n\n");
            var nlMatches = s.match(/\n/g);
            var nlCount = nlMatches ? nlMatches.length : 0;
            if (nlCount > 40) {
                s = s.split("\n").slice(0, 41).join("\n");
            }
        } else {
            s = s.replace(/[\r\n\v\f]+/g, " ");
        }
        s = s.replace(/[^\S\r\n]+/g, " ");
        s = s.replace(/[ \t]+/g, " ");
        if (!opts.isMessage) {
            s = s.replace(/^[\s.,;:!?\-_]+/g, "");
        }
        return s.trim();
    }

    function normalizeEmailInput(s) {
        return normalizeContactText(s || "", {}).toLowerCase();
    }

    function nameSpamCheck(parts) {
        var seen = {};
        var j;
        for (j = 0; j < parts.length; j++) {
            var low = parts[j].toLowerCase();
            if (NAME_SPAM_TOKENS[low]) {
                return MSG_NAME_MEANINGFUL;
            }
            if (seen[low]) {
                return MSG_NAME_MEANINGFUL;
            }
            seen[low] = true;
        }
        var kb = /qwerty|asdf|zxcv|hjkl|asdasd|dsaewq|12345|23456|34567/i;
        for (j = 0; j < parts.length; j++) {
            if (kb.test(parts[j])) {
                return MSG_NAME_MEANINGFUL;
            }
        }
        for (j = 0; j < parts.length; j++) {
            var tok = parts[j];
            if (/^[a-z]+$/i.test(tok) && tok.length >= 5 && !/[aeiouy]/i.test(tok)) {
                return MSG_NAME_MEANINGFUL;
            }
        }
        return null;
    }

    var contactValidators = {
        name: function (n) {
            if (!n) {
                return { message: MSG_NAME_FULL };
            }
            if (n.length > CONTACT_LIMITS.nameMax) {
                return { message: MSG_NAME_LETTERS };
            }
            if (n.length < CONTACT_LIMITS.nameMinChars) {
                return { message: MSG_NAME_MEANINGFUL };
            }
            if (/\d/.test(n)) {
                return { message: MSG_NAME_LETTERS };
            }
            if (/[^\p{L}\s.'-]/u.test(n)) {
                return { message: MSG_NAME_LETTERS };
            }
            if (/(.)\1{4,}/u.test(n)) {
                return { message: MSG_NAME_MEANINGFUL };
            }
            var parts = n.split(/[\s.'-]+/).filter(function (p) {
                return p.length > 0;
            });
            if (parts.length < 2) {
                return { message: MSG_NAME_FULL };
            }
            var i;
            for (i = 0; i < parts.length; i++) {
                if (!/^[\p{L}]+$/u.test(parts[i])) {
                    return { message: MSG_NAME_LETTERS };
                }
                if (/^(.)\1{2,}$/u.test(parts[i])) {
                    return { message: MSG_NAME_MEANINGFUL };
                }
            }
            var letterCount = (n.match(/[\p{L}]/gu) || []).length;
            if (letterCount < 4) {
                return { message: MSG_NAME_MEANINGFUL };
            }
            var spamMsg = nameSpamCheck(parts);
            if (spamMsg) {
                return { message: spamMsg };
            }
            return { message: "" };
        },
        email: function (n) {
            if (!n) {
                return { message: MSG_EMAIL_PRO };
            }
            if (n.length > CONTACT_LIMITS.emailMax) {
                return { message: MSG_EMAIL_PRO };
            }
            if (/\s/.test(n)) {
                return { message: MSG_EMAIL_PRO };
            }
            var at = n.indexOf("@");
            if (at < 1) {
                return { message: MSG_EMAIL_PRO };
            }
            if (n.indexOf("@", at + 1) !== -1) {
                return { message: MSG_EMAIL_PRO };
            }
            var local = n.slice(0, at);
            var domain = n.slice(at + 1);
            if (!local || !domain) {
                return { message: MSG_EMAIL_PRO };
            }
            if (local.indexOf("..") !== -1 || domain.indexOf("..") !== -1) {
                return { message: MSG_EMAIL_PRO };
            }
            if (local[0] === "." || local[local.length - 1] === ".") {
                return { message: MSG_EMAIL_PRO };
            }
            if (domain.indexOf(".") === -1) {
                return { message: MSG_EMAIL_PRO };
            }
            if (domain[domain.length - 1] === ".") {
                return { message: MSG_EMAIL_PRO };
            }
            if (!/^[a-z0-9]([a-z0-9._+-]*[a-z0-9])$/.test(local) && !/^[a-z0-9]$/.test(local)) {
                return { message: MSG_EMAIL_PRO };
            }
            var labels = domain.split(".");
            if (labels.length < 2) {
                return { message: MSG_EMAIL_PRO };
            }
            var tld = labels[labels.length - 1];
            if (tld.length < 2) {
                return { message: MSG_EMAIL_PRO };
            }
            if (/^\d+$/.test(tld)) {
                return { message: MSG_EMAIL_PRO };
            }
            var li;
            for (li = 0; li < labels.length; li++) {
                var lab = labels[li];
                if (lab.length < 1 || lab.length > 63) {
                    return { message: MSG_EMAIL_PRO };
                }
                if (lab[0] === "-" || lab[lab.length - 1] === "-") {
                    return { message: MSG_EMAIL_PRO };
                }
                if (!/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/i.test(lab)) {
                    return { message: MSG_EMAIL_PRO };
                }
            }
            if (EMAIL_BLOCKED_TLDS[tld]) {
                return { message: MSG_EMAIL_PRO };
            }
            if (labels.length && labels.every(function (l) { return l === labels[0]; }) && labels[0].length <= 3) {
                return { message: MSG_EMAIL_PRO };
            }
            if (local === "admin" || local === "test" || local === "root" || local === "postmaster") {
                return { message: MSG_EMAIL_PRO };
            }
            if (/^test$/i.test(labels[0]) && /^test$/i.test(tld)) {
                return { message: MSG_EMAIL_PRO };
            }
            return { message: "" };
        },
        subject: function (n) {
            if (!n) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            if (n.length > CONTACT_LIMITS.subjectMax) {
                return { message: MSG_SUBJECT_LONG };
            }
            if (n.length < CONTACT_LIMITS.subjectMinChars) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            var alpha = (n.match(/[\p{L}]/gu) || []).length;
            if (alpha < CONTACT_LIMITS.subjectMinAlpha) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            if (/^\d+$/.test(n)) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            if (/^[^\p{L}\d\s]+$/u.test(n)) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            if (/(.)\1{5,}/u.test(n)) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            if (n.length > 12 && alpha / n.length < 0.4) {
                return { message: MSG_SUBJECT_MEANINGFUL };
            }
            return { message: "" };
        },
        message: function (n) {
            if (!n) {
                return { message: MSG_MESSAGE_DETAIL };
            }
            if (n.length > CONTACT_LIMITS.messageMax) {
                return { message: MSG_MESSAGE_LONG };
            }
            if (n.length < CONTACT_LIMITS.messageMinChars) {
                return { message: MSG_MESSAGE_DETAIL };
            }
            var words = n.split(/\s+/).filter(function (w) {
                return /[\p{L}]/u.test(w);
            });
            if (words.length < CONTACT_LIMITS.messageMinWords) {
                return { message: MSG_MESSAGE_DETAIL };
            }
            if (/(.)\1{7,}/u.test(n)) {
                return { message: MSG_MESSAGE_MEANINGFUL };
            }
            var letters = (n.match(/[\p{L}]/gu) || []).length;
            if (n.length > 20 && letters / n.length < 0.35) {
                return { message: MSG_MESSAGE_MEANINGFUL };
            }
            var nonSpace = n.replace(/\s/g, "").length;
            if (nonSpace > 0 && letters / nonSpace < 0.3) {
                return { message: MSG_MESSAGE_MEANINGFUL };
            }
            return { message: "" };
        },
    };

    function setFieldError(field, msg) {
        var $g = formGroupFor(field);
        $g.find(".field-error").text(msg || "");
        $g.toggleClass("has-error", !!msg);
        if (msg) {
            $g.removeClass("has-success");
        }
        var $c = contactControl(field);
        if ($c.length) {
            $c.attr("aria-invalid", msg ? "true" : "false");
        }
    }

    function applyFieldUI(field, message, normalizedValue, allowSuccess) {
        setFieldError(field, message);
        var $g = formGroupFor(field);
        if (!message && normalizedValue && normalizedValue.length > 0 && allowSuccess) {
            $g.addClass("has-success");
        } else {
            $g.removeClass("has-success");
        }
    }

    function validateFieldNormalized(field, options) {
        options = options || {};
        if (!contactValidators[field]) {
            return "";
        }
        if (options.skipUntouchedLive && !textFieldTouched[field]) {
            return "";
        }
        var $inp = $form.find('[name="' + field + '"]');
        var raw = $inp.val();
        var n =
            field === "email"
                ? normalizeEmailInput(raw || "")
                : normalizeContactText(raw || "", { isMessage: field === "message" });
        if (options.applyToInput) {
            $inp.val(n);
        }
        var r = contactValidators[field](n);
        var allowSuccess = !!options.forceSuccess || !!textFieldTouched[field];
        applyFieldUI(field, r.message, n, allowSuccess);
        return r.message;
    }

    function clearAllErrors() {
        ["name", "email", "phone", "subject", "message"].forEach(function (f) {
            setFieldError(f, "");
        });
        $form.find(".form-group").removeClass("has-success");
        CONTACT_TEXT_FIELDS.concat(["phone"]).forEach(function (f) {
            var $c = contactControl(f);
            if ($c.length) {
                $c.attr("aria-invalid", "false");
            }
        });
    }

    function showAlert(html, isError) {
        $alerts.html(
            '<div class="alert ' + (isError ? "alert-error" : "alert-success") + '" role="alert">' + html + "</div>"
        );
    }

    function clearAlert() {
        $alerts.empty();
    }

    function syncPhoneHidden(iti) {
        if (!iti) {
            return;
        }
        var data = iti.getSelectedCountryData();
        var dial = data && data.dialCode ? "+" + String(data.dialCode).replace(/^\++/, "") : "";
        var full = "";
        var natDigits = "";
        var U = window.intlTelInput && window.intlTelInput.utils;
        if (U && U.numberFormat) {
            full = iti.getNumber(U.numberFormat.E164) || "";
            natDigits = (iti.getNumber(U.numberFormat.NATIONAL) || "").replace(/\D/g, "");
        } else {
            full = iti.getNumber() || "";
        }
        if (!natDigits) {
            natDigits = ($("#contact-phone").val() || "").replace(/\D/g, "");
        }
        $("#phone_country_code").val(dial);
        $("#phone_number").val(natDigits);
        $("#full_phone_number").val(full);
    }

    function validatePhoneSync(phoneOpts) {
        phoneOpts = phoneOpts || {};
        if (!contactIti) {
            setFieldError("phone", "Phone input is not available. Refresh the page and try again.");
            return "Phone input is not available.";
        }
        var raw = $.trim($("#contact-phone").val() || "");
        var $g = formGroupFor("phone");
        if (!raw) {
            $("#phone_country_code, #phone_number, #full_phone_number").val("");
            if (phoneOpts.silentEmpty) {
                setFieldError("phone", "");
                $g.removeClass("has-success");
                return "";
            }
            setFieldError("phone", "Please enter your phone number.");
            $g.removeClass("has-success");
            return "Please enter your phone number.";
        }
        if (!contactIti.isValidNumber()) {
            setFieldError("phone", "Please enter a valid phone number for the selected country.");
            $g.removeClass("has-success");
            return "invalid";
        }
        syncPhoneHidden(contactIti);
        var dial = String($("#phone_country_code").val() || "");
        var nat = String($("#phone_number").val() || "");
        var full = String($("#full_phone_number").val() || "");
        var dialOk = /^\+[1-9][0-9]{0,3}$/.test(dial);
        var natLen = nat.length;
        var fullOk = /^\+[1-9][0-9]{5,14}$/.test(full);
        if (!dialOk || natLen < 4 || natLen > 24 || !fullOk || (dial && full.indexOf(dial) !== 0)) {
            setFieldError("phone", "Please enter a valid phone number for the selected country.");
            $g.removeClass("has-success");
            return "invalid";
        }
        if (phoneNationalLooksFake(nat)) {
            setFieldError("phone", "Please enter a valid phone number for the selected country.");
            $g.removeClass("has-success");
            return "invalid";
        }
        setFieldError("phone", "");
        var allowPhoneOk = !!phoneOpts.forceSuccess || !!phoneFieldTouched;
        if (allowPhoneOk) {
            $g.addClass("has-success");
        } else {
            $g.removeClass("has-success");
        }
        return "";
    }

    function phoneNationalLooksFake(natDigits) {
        if (!natDigits || natDigits.length < 6) {
            return false;
        }
        var seen = {};
        var i;
        for (i = 0; i < natDigits.length; i++) {
            seen[natDigits[i]] = true;
        }
        var k;
        var nUnique = 0;
        for (k in seen) {
            if (Object.prototype.hasOwnProperty.call(seen, k)) {
                nUnique++;
            }
        }
        if (nUnique <= 1) {
            return true;
        }
        if (/(\d)\1{5,}/.test(natDigits)) {
            return true;
        }
        return false;
    }

    var textFieldDebounce = { name: null, email: null, subject: null, message: null };

    $form.on(
        "input",
        'input[name="name"], input[name="email"], input[name="subject"], textarea[name="message"]',
        function () {
            var field = $(this).attr("name");
            if (textFieldDebounce[field]) {
                clearTimeout(textFieldDebounce[field]);
            }
            textFieldDebounce[field] = setTimeout(function () {
                textFieldDebounce[field] = null;
                validateFieldNormalized(field, { applyToInput: false, skipUntouchedLive: true });
            }, CONTACT_LIMITS.debounceMs);
        }
    );

    $form.on(
        "blur",
        'input[name="name"], input[name="email"], input[name="subject"], textarea[name="message"]',
        function () {
            var field = $(this).attr("name");
            textFieldTouched[field] = true;
            if (textFieldDebounce[field]) {
                clearTimeout(textFieldDebounce[field]);
                textFieldDebounce[field] = null;
            }
            validateFieldNormalized(field, { applyToInput: true });
        }
    );

    $form.on("blur", "#contact-phone", function () {
        if (!contactIti) {
            return;
        }
        contactIti.promise.then(function () {
            validatePhoneSync({ forceSuccess: true });
        });
    });

    var phoneDebounce = null;
    $form.on("input countrychange", "#contact-phone", function () {
        if (!contactIti) {
            return;
        }
        clearTimeout(phoneDebounce);
        var raw = $.trim($("#contact-phone").val() || "");
        if (!raw) {
            $("#phone_country_code, #phone_number, #full_phone_number").val("");
            setFieldError("phone", "");
            formGroupFor("phone").removeClass("has-success");
            return;
        }
        phoneDebounce = setTimeout(function () {
            contactIti.promise.then(function () {
                if (phoneInputHasFocus) {
                    return;
                }
                if (!phoneFieldTouched) {
                    return;
                }
                validatePhoneSync();
            });
        }, CONTACT_LIMITS.phoneLiveDebounceMs);
    });

    function scrollToField(field) {
        var $el = formGroupFor(field);
        if ($el.length) {
            $("html, body").animate({ scrollTop: $el.offset().top - headerH() - 8 }, 350);
            if (field === "phone") {
                $("#contact-phone").focus();
            } else {
                $el.find("input, textarea").first().focus();
            }
        }
    }

    function firstErrorFieldInOrder(order) {
        var i;
        for (i = 0; i < order.length; i++) {
            if (formGroupFor(order[i]).hasClass("has-error")) {
                return order[i];
            }
        }
        return null;
    }

    var contactFormSubmitting = false;

    $form.on("submit", function (e) {
        e.preventDefault();
        if (contactFormSubmitting) {
            return;
        }
        clearAlert();
        clearAllErrors();

        CONTACT_TEXT_FIELDS.forEach(function (n) {
            validateFieldNormalized(n, { applyToInput: true, forceSuccess: true, skipUntouchedLive: false });
        });

        var feSync = firstErrorFieldInOrder(["name", "email", "subject", "message"]);
        if (feSync) {
            scrollToField(feSync);
            return;
        }

        if (!contactIti || !contactIti.promise) {
            setFieldError("phone", "Phone input is not available. Refresh the page and try again.");
            var feNoIti = firstErrorFieldInOrder(["name", "email", "phone", "subject", "message"]);
            if (feNoIti) {
                scrollToField(feNoIti);
            }
            return;
        }

        contactFormSubmitting = true;
        $btn.prop("disabled", true).attr("aria-busy", "true");

        contactIti.promise
            .then(function () {
                syncPhoneHidden(contactIti);
                validatePhoneSync({ forceSuccess: true });
                var firstBad = firstErrorFieldInOrder(["name", "email", "phone", "subject", "message"]);
                if (firstBad) {
                    scrollToField(firstBad);
                    return Promise.reject({ code: "validation" });
                }
                syncPhoneHidden(contactIti);
                return $.ajax({
                    url: $form.attr("action"),
                    method: "POST",
                    data: $form.serialize(),
                    dataType: "json",
                    timeout: CONTACT_LIMITS.ajaxTimeoutMs,
                });
            })
            .then(
                function (res) {
                    if (res && res.ok) {
                        showAlert($("<div>").text(res.message || "Sent.").html(), false);
                        $form[0].reset();
                        clearAllErrors();
                        phoneFieldTouched = false;
                        textFieldTouched.name = false;
                        textFieldTouched.email = false;
                        textFieldTouched.subject = false;
                        textFieldTouched.message = false;
                        if (contactIti) {
                            contactIti.setNumber("");
                            $("#phone_country_code, #phone_number, #full_phone_number").val("");
                        }
                    } else {
                        var msg = (res && res.message) || "Something went wrong.";
                        if (res && res.field_errors) {
                            Object.keys(res.field_errors).forEach(function (k) {
                                setFieldError(k, res.field_errors[k]);
                            });
                        }
                        showAlert($("<div>").text(msg).html(), true);
                    }
                },
                function (xhr, status) {
                    if (xhr && xhr.code === "validation") {
                        return;
                    }
                    var msg = "Could not send. Please try again or email directly.";
                    if (status === "timeout") {
                        msg = "Request timed out. Please check your connection and try again.";
                    } else if (status === "error" && xhr && !xhr.status) {
                        msg = "Network error. Please check your connection and try again.";
                    }
                    try {
                        var j = xhr && xhr.responseJSON;
                        if (j && j.message) {
                            msg = j.message;
                        }
                        if (j && j.field_errors) {
                            Object.keys(j.field_errors).forEach(function (k) {
                                setFieldError(k, j.field_errors[k]);
                            });
                        }
                    } catch (err) {
                        /* ignore */
                    }
                    showAlert($("<div>").text(msg).html(), true);
                }
            )
            .finally(function () {
                contactFormSubmitting = false;
                $btn.prop("disabled", false).attr("aria-busy", "false");
            });
    });
})(jQuery);
