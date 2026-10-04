<?php
declare(strict_types=1);
$year = (int) date('Y');
$effectiveDate = 'October 4, 2026';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy — Tetris</title>
    <meta name="description" content="Privacy Policy for the Tetris mobile application by Dipesh Jagtap. Explains local storage, offline play, and that gameplay data is not transmitted off-device.">
    <meta name="theme-color" content="#101114">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://dipeshjagtap.in/tetris/privacy-policy.php">
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
                <a class="brand-mark" href="./">
                    <img class="brand-mark__logo" src="assets/images/03_website_brand_logo_256.png" alt="" width="32" height="32">
                    <span>Tetris</span>
                </a>
                <a class="nav-link" href="./">Back to game site</a>
            </div>
        </header>

        <main class="policy wrap">
            <header class="policy__header fade-up">
                <h1>Privacy Policy</h1>
                <p class="policy__meta">Tetris mobile application · Effective date: <?= htmlspecialchars($effectiveDate, ENT_QUOTES, 'UTF-8') ?></p>
            </header>

            <article class="panel policy-card">
                <h2>Introduction</h2>
                <p>
                    This Privacy Policy describes how the Tetris mobile application (“the App”), developed by Dipesh Jagtap (“I”, “me”, or “the developer”), handles information.
                    It applies to the current version of the App as implemented in the Flutter project (game modes, settings, local persistence, audio, and haptics).
                </p>
                <p>
                    The App is designed to run offline for gameplay. Preferences and game statistics are stored on your device. The App does not provide account sign-in and does not include advertising, analytics, or crash-reporting services in the current build.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Information We Collect</h2>
                <p>
                    The App does <strong>not</strong> collect personal information such as your name, email address, phone number, contacts, precise location, photos, microphone audio, or account credentials.
                </p>
                <p>
                    The App does not create a user profile on a remote server and does not ask you to register.
                </p>
                <p>
                    If you contact the developer by email, any information you choose to include in that message is received only because you sent it — not because the App transmitted it.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Information Stored Locally</h2>
                <p>
                    The App uses on-device storage (via the Flutter <code>shared_preferences</code> package) to remember gameplay-related data and settings. This information stays on your device unless you clear the App’s data or uninstall the App.
                </p>
                <p>Locally stored game statistics (per mode — Classic and Cascade) may include:</p>
                <ul>
                    <li>High score</li>
                    <li>Highest level reached</li>
                    <li>Total games played</li>
                    <li>Total lines cleared</li>
                </ul>
                <p>Locally stored settings may include:</p>
                <ul>
                    <li>Sound effects enabled / disabled</li>
                    <li>Vibration (haptic feedback) enabled / disabled</li>
                    <li>Show Help (piece landing / ghost preview) enabled / disabled</li>
                    <li>Show button labels enabled / disabled</li>
                </ul>
                <p>
                    These values are used only to present your progress on the home screen and to apply your preferences during play. They are not uploaded by the App.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>How Information Is Used</h2>
                <p>On-device data is used solely to:</p>
                <ul>
                    <li>Display your Classic and Cascade statistics</li>
                    <li>Restore your sound, vibration, help, and label preferences</li>
                    <li>Support normal offline gameplay</li>
                </ul>
                <p>
                    Sound effects are played from audio files bundled with the App. Haptic feedback, when enabled, uses the device’s vibration capability for events such as hard drop, line clears, and game over. Neither audio playback nor haptics send gameplay data off the device.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Data Sharing</h2>
                <p>
                    The App does not sell, rent, or share your game statistics or settings with third parties.
                    Because gameplay preferences and statistics remain on your device, there is no App-driven transfer of that data to the developer or to external services.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Third-Party Services</h2>
                <p>
                    The current App dependencies used for gameplay-related functionality are limited to Flutter SDK packages such as:
                </p>
                <ul>
                    <li><code>shared_preferences</code> — local key/value storage on the device</li>
                    <li><code>audioplayers</code> — local playback of bundled sound effects</li>
                    <li><code>flutter_svg</code> — rendering bundled vector graphics</li>
                    <li><code>cupertino_icons</code> — UI icons</li>
                </ul>
                <p>
                    The current build does not integrate third-party advertising SDKs, analytics SDKs, social login, cloud save, or crash-reporting platforms.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Advertising and Analytics</h2>
                <p>
                    The current version of the App does not display advertisements and does not include in-app analytics or tracking SDKs.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Network Access</h2>
                <p>
                    Gameplay, settings, statistics, sound, and haptics do not require internet access.
                    The release Android manifest for the App does not declare an Internet permission for distribution builds.
                    Debug/profile development builds may include an Internet permission for Flutter tooling only; that is not used by the App to send gameplay or personal data.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Permissions and Device Features</h2>
                <p>
                    The App does not request access to your camera, microphone, contacts, or location.
                    Vibration / haptic feedback is used only when that setting is enabled and only for in-game feedback.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Children’s Privacy</h2>
                <p>
                    The App is a general-audience puzzle game and does not knowingly collect personal information from children.
                    Because the App does not collect personal information through its gameplay features, no parental consent flow is required for the functionality described in this policy.
                    If you believe a child has sent personal information to the developer by email, contact me and I will delete that correspondence upon request where feasible.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Data Security</h2>
                <p>
                    Local statistics and settings are stored using the platform mechanisms provided by <code>shared_preferences</code> on your device.
                    Protecting device access (for example with a lock screen) is the primary control for that data.
                    Uninstalling the App or clearing the App’s stored data removes the locally saved preferences and statistics.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Changes to This Privacy Policy</h2>
                <p>
                    This policy may be updated if the App’s data practices change — for example if advertising, analytics, accounts, or online services are added in a future version.
                    When that happens, the Effective Date above will be revised and the updated policy will be posted at this URL.
                    Material changes will be described in the updated policy text.
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Contact</h2>
                <p>
                    If you have questions about this Privacy Policy or the Tetris App, contact:
                </p>
                <p>
                    Dipesh Jagtap<br>
                    Companion website: <a href="./">https://dipeshjagtap.in/tetris/</a>
                </p>
            </article>

            <article class="panel policy-card">
                <h2>Effective Date</h2>
                <p>This Privacy Policy is effective as of <?= htmlspecialchars($effectiveDate, ENT_QUOTES, 'UTF-8') ?>.</p>
            </article>

            <p class="back-row">
                <a class="btn btn--ghost" href="./">← Back to Tetris</a>
            </p>
        </main>

        <footer class="site-footer">
            <div class="wrap">
                <p class="site-footer__brand">Tetris</p>
                <p>Developed by Dipesh Jagtap</p>
                <div class="site-footer__links">
                    <a href="./">Game site</a>
                    <a href="privacy-policy.php">Privacy Policy</a>
                </div>
                <p>© <?= $year ?></p>
            </div>
        </footer>
    </div>

    <script src="js/tetris.js" defer></script>
</body>
</html>
