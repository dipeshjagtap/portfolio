<?php
declare(strict_types=1);

require __DIR__ . '/includes/auth.php';
require_admin_login();

$mysqli = db();
$unread = (int) $mysqli->query("SELECT COUNT(*) FROM contact_submissions WHERE status = 'unread'")->fetch_row()[0];
$total = (int) $mysqli->query('SELECT COUNT(*) FROM contact_submissions')->fetch_row()[0];

$recentRes = $mysqli->query(
    'SELECT id, name, email, subject, status, created_at FROM contact_submissions ORDER BY created_at DESC LIMIT 5'
);
$recent = $recentRes ? $recentRes->fetch_all(MYSQLI_ASSOC) : [];

$pageTitle = 'Dashboard';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="admin-stack">
    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-value"><?= (int) $unread ?></span>
            <span class="stat-label">Unread</span>
        </div>
        <div class="stat-card">
            <span class="stat-value"><?= (int) $total ?></span>
            <span class="stat-label">Total</span>
        </div>
    </div>

    <section class="admin-panel">
        <h2>Recent inquiries</h2>
        <?php if ($recent === []): ?>
        <p class="muted">No submissions yet.</p>
        <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent as $r): ?>
                    <tr>
                        <td><?= (int) $r['id'] ?></td>
                        <td><?= e($r['name']) ?></td>
                        <td><?= e($r['email']) ?></td>
                        <td><?= e($r['subject']) ?></td>
                        <td><span class="badge <?= $r['status'] === 'unread' ? 'badge-warn' : '' ?>"><?= e($r['status']) ?></span></td>
                        <td><?= e($r['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <p style="margin-top:1rem;"><a class="btn btn-primary" href="<?= e(base_url('admin/inquiries.php')) ?>">View all</a></p>
    </section>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php';
