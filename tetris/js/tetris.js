/**
 * Tetris companion site — night-sky ambience.
 * Lightweight, dependency-free, mobile-friendly.
 */
(function () {
  "use strict";

  var reducedMotion =
    window.matchMedia &&
    window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function clamp(n, min, max) {
    return Math.min(max, Math.max(min, n));
  }

  function initStars() {
    var host = document.getElementById("sky-stars");
    if (!host) return;

    var count = window.innerWidth < 480 ? 36 : window.innerWidth < 900 ? 48 : 56;
    var colors = ["", "sky__star--cyan", "sky__star--lavender", "sky__star--gold"];
    var frag = document.createDocumentFragment();

    for (var i = 0; i < count; i++) {
      var star = document.createElement("span");
      var size = 1.2 + Math.random() * (Math.random() > 0.88 ? 3.4 : 1.8);
      var op = 0.28 + Math.random() * 0.4;
      var colorClass = colors[Math.floor(Math.random() * colors.length)];

      star.className = "sky__star" + (colorClass ? " " + colorClass : "");
      if (size >= 3.2) star.classList.add("sky__star--glow");

      star.style.left = (2 + Math.random() * 96).toFixed(2) + "%";
      star.style.top = (2 + Math.random() * 96).toFixed(2) + "%";
      star.style.width = size.toFixed(1) + "px";
      star.style.height = size.toFixed(1) + "px";
      star.style.setProperty("--op", op.toFixed(2));
      star.style.setProperty("--dur", (3.2 + Math.random() * 3.4).toFixed(2) + "s");
      star.style.setProperty("--delay", (-Math.random() * 4.2).toFixed(2) + "s");

      frag.appendChild(star);
    }

    host.innerHTML = "";
    host.appendChild(frag);
  }

  function initShootingStars() {
    var host = document.getElementById("sky-shooting");
    if (!host || reducedMotion) return;

    var timer = null;
    var active = null;

    function schedule() {
      var delay = 5000 + Math.floor(Math.random() * 15001);
      timer = window.setTimeout(fire, delay);
    }

    function fire() {
      if (document.hidden) {
        schedule();
        return;
      }

      if (active && active.parentNode) {
        active.parentNode.removeChild(active);
      }

      var el = document.createElement("span");
      el.className = "sky__shooting-star";

      var goRight = Math.random() > 0.5;
      var startX = goRight ? Math.random() * 45 : 55 + Math.random() * 40;
      var startY = Math.random() * 38;
      var angle = 25 + Math.random() * 40;
      var distance = 140 + Math.random() * 160;
      var rad = (angle * Math.PI) / 180;
      var dx = Math.cos(rad) * distance * (goRight ? 1 : -1);
      var dy = Math.sin(rad) * distance;
      var dur = 800 + Math.floor(Math.random() * 401);

      el.style.left = clamp(startX, 2, 96) + "%";
      el.style.top = clamp(startY, 2, 70) + "%";
      el.style.setProperty("--angle", (goRight ? angle : 180 - angle).toFixed(1) + "deg");
      el.style.setProperty("--dx", dx.toFixed(1) + "px");
      el.style.setProperty("--dy", dy.toFixed(1) + "px");
      el.style.setProperty("--shot-dur", dur + "ms");

      host.appendChild(el);
      active = el;

      // Restart animation on next frame
      requestAnimationFrame(function () {
        el.classList.add("is-active");
      });

      window.setTimeout(function () {
        if (el.parentNode) el.parentNode.removeChild(el);
        if (active === el) active = null;
        schedule();
      }, dur + 40);
    }

    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        if (timer) window.clearTimeout(timer);
        timer = null;
      } else if (!timer) {
        schedule();
      }
    });

    schedule();
  }

  function initTooltips() {
    var triggers = document.querySelectorAll("[data-tooltip]");
    if (!triggers.length) return;

    var tipEl = document.getElementById("tetris-tooltip");
    if (!tipEl) {
      tipEl = document.createElement("div");
      tipEl.id = "tetris-tooltip";
      tipEl.className = "tetris-tooltip";
      tipEl.setAttribute("role", "tooltip");
      document.body.appendChild(tipEl);
    }

    var hideTimer = null;
    var activeEl = null;
    var pinned = false;
    var finePointer =
      window.matchMedia && window.matchMedia("(hover: hover) and (pointer: fine)").matches;

    function clearHide() {
      if (hideTimer) {
        window.clearTimeout(hideTimer);
        hideTimer = null;
      }
    }

    function hideTip() {
      clearHide();
      tipEl.classList.remove("is-visible");
      tipEl.textContent = "";
      activeEl = null;
      pinned = false;
    }

    function placeTip(el) {
      var r = el.getBoundingClientRect();
      var tw = tipEl.offsetWidth;
      var th = tipEl.offsetHeight;
      var x = Math.round(r.left + r.width / 2 - tw / 2);
      var y = Math.round(r.top - th - 10);
      x = Math.max(10, Math.min(x, window.innerWidth - tw - 10));
      if (y < 10) {
        y = Math.round(r.bottom + 10);
      }
      if (y + th > window.innerHeight - 10) {
        y = Math.max(10, Math.round(r.top - th - 10));
      }
      tipEl.style.left = x + "px";
      tipEl.style.top = y + "px";
    }

    function showTip(el, lock) {
      var text = el.getAttribute("data-tooltip");
      if (!text) return;
      clearHide();
      activeEl = el;
      pinned = !!lock;
      tipEl.textContent = text;
      tipEl.classList.add("is-visible");
      requestAnimationFrame(function () {
        placeTip(el);
        if (tipEl.offsetWidth < 8) {
          requestAnimationFrame(function () {
            placeTip(el);
          });
        }
      });
    }

    function scheduleHide(delay) {
      clearHide();
      hideTimer = window.setTimeout(hideTip, delay || 90);
    }

    Array.prototype.forEach.call(triggers, function (el) {
      el.addEventListener("mouseenter", function () {
        if (!finePointer) return;
        showTip(el, false);
      });
      el.addEventListener("mouseleave", function () {
        if (!finePointer || pinned) return;
        scheduleHide(90);
      });
      el.addEventListener("focus", function () {
        showTip(el, false);
      });
      el.addEventListener("blur", function () {
        if (pinned) return;
        scheduleHide(110);
      });
      el.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (pinned && activeEl === el) {
          hideTip();
          return;
        }
        showTip(el, true);
      });
    });

    document.addEventListener("click", function (e) {
      if (!activeEl) return;
      if (activeEl.contains(e.target) || tipEl.contains(e.target)) return;
      hideTip();
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") hideTip();
    });

    window.addEventListener("scroll", hideTip, { passive: true });
    window.addEventListener("resize", hideTip);
  }

  function initScreenshotCarousel() {
    var root = document.querySelector("[data-shot-carousel]");
    if (!root) return;

    var track = root.querySelector("[data-shot-track]");
    if (!track || track.children.length < 2) return;

    var intervalMs = 4200;
    var transitionMs = 560;
    var timer = null;
    var animating = false;
    var resizeTimer = null;

    function gapPx() {
      var styles = window.getComputedStyle(track);
      var gap = parseFloat(styles.columnGap || styles.gap);
      return isNaN(gap) ? 0 : gap;
    }

    function stepDistance() {
      var first = track.children[0];
      if (!first) return 0;
      return first.getBoundingClientRect().width + gapPx();
    }

    function resetPosition() {
      track.style.transition = "none";
      track.style.transform = "translate3d(0, 0, 0)";
      // Force layout so the next animated step starts cleanly.
      void track.offsetWidth;
      track.style.transition = "";
    }

    function advance() {
      if (animating || document.hidden || track.children.length < 2) return;

      var distance = stepDistance();
      if (distance <= 0) return;

      animating = true;
      track.style.transition =
        "transform " + transitionMs + "ms cubic-bezier(0.33, 0.1, 0.25, 1)";
      track.style.transform = "translate3d(" + -distance + "px, 0, 0)";

      window.setTimeout(function () {
        track.appendChild(track.children[0]);
        resetPosition();
        animating = false;
      }, transitionMs + 20);
    }

    function stop() {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    }

    function start() {
      stop();
      if (reducedMotion) return;
      timer = window.setInterval(advance, intervalMs);
    }

    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        stop();
      } else {
        resetPosition();
        start();
      }
    });

    window.addEventListener("resize", function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(function () {
        resetPosition();
      }, 150);
    });

    resetPosition();
    start();
  }

  function ready(fn) {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", fn);
    } else {
      fn();
    }
  }

  ready(function () {
    initStars();
    initShootingStars();
    initScreenshotCarousel();
    initTooltips();

    var resizeTimer;
    window.addEventListener("resize", function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(initStars, 200);
    });
  });
})();
