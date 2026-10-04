<?php
declare(strict_types=1);
$year = (int) date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris — Classic &amp; Cascade Mobile Game</title>
    <meta name="description" content="Tetris for mobile with Classic and Cascade modes, next/hold previews, sound, haptics, and offline local stats. Developed by Dipesh Jagtap.">
    <meta name="theme-color" content="#101114">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://dipeshjagtap.in/tetris/">
    <meta property="og:title" content="Tetris — Classic &amp; Cascade">
    <meta property="og:description" content="A modern mobile Tetris experience with Classic and Cascade modes.">
    <meta property="og:url" content="https://dipeshjagtap.in/tetris/">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" sizes="64x64" href="assets/images/05_favicon_large_64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/06_favicon_standard_32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/07_favicon_small_16.png">
    <link rel="apple-touch-icon" sizes="256x256" href="assets/images/03_website_brand_logo_256.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Orbitron:wght@700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tetris.css">
</head>
<body>
    <div class="sky" aria-hidden="true">
        <div class="sky__stars" id="sky-stars"></div>
        <div class="sky__shooting" id="sky-shooting"></div>
    </div>

    <div class="page">
        <header class="site-header">
            <div class="wrap site-header__inner">
                <span class="brand-mark">
                    <img class="brand-mark__logo" src="assets/images/03_website_brand_logo_256.png" alt="" width="32" height="32">
                    <span>Tetris</span>
                </span>
                <a class="nav-link" href="privacy-policy.php">Privacy Policy</a>
            </div>
        </header>

        <main>
            <section class="hero wrap fade-up">
                <h1 class="hero__title">Tetris</h1>
                <p class="hero__modes">Classic • Cascade</p>
                <p class="hero__tagline">A modern mobile Tetris experience.</p>
                <div class="hero__rule" aria-hidden="true"></div>
                <div class="hero__actions">
                    <!-- Play Store listing URL not finalized yet — tooltip note until a real URL is available. -->
                    <button
                        type="button"
                        class="btn btn--primary tip-trigger"
                        id="play-store-cta"
                        data-tooltip="Google Play Store listing is currently being prepared. The download link will be available after publication."
                        aria-describedby="tetris-tooltip"
                    >
                        <svg class="play-badge" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path fill="currentColor" d="M3.6 2.8c-.4.2-.6.6-.6 1.1v16.2c0 .5.2.9.6 1.1l.1.1L13 12.5v-.9L3.7 2.7l-.1.1zm11.2 6.4 2.5 1.4-2.5 1.4V9.2zm3.4 1.9 2.3 1.3c.7.4.7 1.1 0 1.5l-2.3 1.3-2.7-1.5 2.7-1.5zM3.8 21.1l9.2-9.2v.9L4 21.3l-.2-.2z"/>
                        </svg>
                        Get it on Google Play
                    </button>
                    <a class="btn btn--ghost" href="#modes">View game modes</a>
                </div>
            </section>

            <section class="wrap" id="about-game">
                <p class="section-label">The game</p>
                <h2 class="section-title">Built for focused play</h2>
                <p class="section-lead">
                    Clear lines in Classic mode with official-style gravity, or switch to Cascade where connected groups keep falling after clears.
                    Next and Hold previews, hard drop, optional landing help, sound effects, and haptic feedback are all available offline — with scores and settings saved on your device.
                </p>
            </section>

            <section class="wrap" id="modes">
                <p class="section-label">Game modes</p>
                <h2 class="section-title">Choose your gravity</h2>
                <p class="section-lead">Two modes are implemented in the current app.</p>
                <div class="mode-grid">
                    <article class="mode-card">
                        <h3>Classic</h3>
                        <p>Official Tetris rules — completed rows are removed and the stack settles in the familiar way.</p>
                    </article>
                    <article class="mode-card">
                        <h3>Cascade</h3>
                        <p>Connected groups continue falling after line clears, chaining movement across the board.</p>
                    </article>
                </div>
            </section>

            <section class="wrap" id="features">
                <p class="section-label">Features</p>
                <h2 class="section-title">What’s in the app</h2>
                <p class="section-lead">Confirmed from the current Flutter Tetris build.</p>
                <div class="feature-grid">
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">01</div>
                        <div>
                            <h3>Classic &amp; Cascade</h3>
                            <p>Two gravity modes with separate local statistics on the home screen.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">02</div>
                        <div>
                            <h3>Next-piece preview</h3>
                            <p>See the upcoming tetromino before it enters the board.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">03</div>
                        <div>
                            <h3>Hold piece</h3>
                            <p>Store a piece and swap it back when you need a better fit.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">04</div>
                        <div>
                            <h3>Hard drop</h3>
                            <p>Lock pieces instantly with hard drop, plus soft drop and rotate controls.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">05</div>
                        <div>
                            <h3>Sound effects</h3>
                            <p>Bundled SFX for moves, drops, clears, level-up, pause, and more — toggle in Settings.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">06</div>
                        <div>
                            <h3>Haptic feedback</h3>
                            <p>Optional vibration on hard drop, line clears, and game over.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">07</div>
                        <div>
                            <h3>Landing preview help</h3>
                            <p>Show Help draws a ghost piece at the landing position when you want guidance.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">08</div>
                        <div>
                            <h3>Local stats &amp; settings</h3>
                            <p>High score, best level, games played, lines cleared, and preferences stay on-device.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">09</div>
                        <div>
                            <h3>Offline gameplay</h3>
                            <p>Play without an account or network — no ads or analytics in the current build.</p>
                        </div>
                    </article>
                    <article class="feature-item">
                        <div class="feature-icon" aria-hidden="true">10</div>
                        <div>
                            <h3>Button labels</h3>
                            <p>Keep control labels visible or hide them for a cleaner board.</p>
                        </div>
                    </article>
                </div>
            </section>

            <section class="wrap" id="screenshots">
                <p class="section-label">Screenshots</p>
                <h2 class="section-title">A look at the UI</h2>
                <p class="section-lead">Real screens from the Tetris mobile app.</p>
                <div class="shot-carousel" data-shot-carousel aria-roledescription="carousel" aria-label="Tetris app screenshots">
                    <div class="shot-track" data-shot-track>
                        <figure class="shot-slot shot-slot--phone">
                            <img src="assets/images/screenshot-home.png" alt="Tetris home screen with Classic and Cascade modes" width="413" height="858" loading="eager">
                            <figcaption class="shot-slot__caption">Home</figcaption>
                        </figure>
                        <figure class="shot-slot shot-slot--phone">
                            <img src="assets/images/screenshot-gameplay.png" alt="Tetris gameplay with next and hold previews" width="413" height="858" loading="eager">
                            <figcaption class="shot-slot__caption">Gameplay</figcaption>
                        </figure>
                        <figure class="shot-slot shot-slot--phone">
                            <img src="assets/images/screenshot-game-over.png" alt="Tetris game over screen in Classic mode" width="413" height="858" loading="lazy">
                            <figcaption class="shot-slot__caption">Game Over</figcaption>
                        </figure>
                        <figure class="shot-slot shot-slot--phone">
                            <img src="assets/images/screenshot-settings.png" alt="Tetris settings screen with sound, vibration, and help toggles" width="413" height="858" loading="lazy">
                            <figcaption class="shot-slot__caption">Settings</figcaption>
                        </figure>
                    </div>
                </div>
            </section>

            <section class="wrap" id="developer">
                <p class="section-label">Developer</p>
                <h2 class="section-title">Made independently</h2>
                <div class="panel dev-panel">
                    <p>Developed by <strong>Dipesh Jagtap</strong></p>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="wrap">
                <p class="site-footer__brand">Tetris</p>
                <p>Developed by Dipesh Jagtap</p>
                <div class="site-footer__links">
                    <a href="privacy-policy.php">Privacy Policy</a>
                    <a href="#google-play-url-placeholder">Google Play (soon)</a>
                </div>
                <p>© <?= $year ?></p>
            </div>
        </footer>
    </div>

    <script src="js/tetris.js" defer></script>
</body>
</html>
