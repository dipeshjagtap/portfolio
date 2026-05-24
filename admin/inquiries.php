<?php
declare(strict_types=1);

require __DIR__ . '/includes/auth.php';
require_admin_login();

$mysqli = db();
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['_csrf'] ?? null;
    if (!admin_csrf_verify(is_string($token) ? $token : null)) {
        $flash = 'error:Invalid security token.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        $id = (int) ($_POST['id'] ?? 0);
        if ($id < 1) {
            $flash = 'error:Invalid record.';
        } elseif ($action === 'mark_read') {
            $stmt = $mysqli->prepare("UPDATE contact_submissions SET status = 'read' WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $flash = 'success:Marked as read.';
        } elseif ($action === 'delete') {
            $stmt = $mysqli->prepare('DELETE FROM contact_submissions WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $flash = 'success:Deleted.';
        } else {
            $flash = 'error:Unknown action.';
        }
    }
}

$q = normalize_space((string) ($_GET['q'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$where = '';
if ($q !== '') {
    $where = ' WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ? OR phone_country_code LIKE ? OR phone_number LIKE ? OR full_phone_number LIKE ?';
}

$countSql = 'SELECT COUNT(*) FROM contact_submissions' . $where;
if ($q !== '') {
    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = '%' . $q . '%';
    $stmt = $mysqli->prepare($countSql);
    $stmt->bind_param('sssssss', $l1, $l2, $l3, $l4, $l5, $l6, $l7);
    $stmt->execute();
    $totalRows = (int) ($stmt->get_result()->fetch_row()[0] ?? 0);
    $stmt->close();
} else {
    $totalRows = (int) $mysqli->query($countSql)->fetch_row()[0];
}
$totalPages = max(1, (int) ceil($totalRows / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $perPage;
}

$sql = 'SELECT id, name, email, phone_country_code, phone_number, full_phone_number, subject, message, status, created_at FROM contact_submissions' . $where .
    ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
if ($q !== '') {
    $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $l7 = '%' . $q . '%';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssssssii', $l1, $l2, $l3, $l4, $l5, $l6, $l7, $perPage, $offset);
} else {
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $perPage, $offset);
}
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$pageTitle = 'Inquiries';
require __DIR__ . '/includes/layout_top.php';

$flashType = '';
$flashMsg = '';
if ($flash !== '') {
    $parts = explode(':', $flash, 2);
    $flashType = $parts[0] ?? '';
    $flashMsg = $parts[1] ?? $flash;
}
?>
<div class="admin-stack">
    <?php if ($flashType === 'success'): ?>
    <div class="alert-success"><?= e($flashMsg) ?></div>
    <?php elseif ($flashType === 'error'): ?>
    <div class="alert-error"><?= e($flashMsg) ?></div>
    <?php endif; ?>

    <form class="toolbar" method="get" action="">
        <div>
            <label for="q" class="muted" style="display:block;font-size:0.8rem;margin-bottom:0.25rem;">Search</label>
            <input id="q" name="q" type="search" value="<?= e($q) ?>" placeholder="Name, email, subject, message">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <?php if ($q !== ''): ?>
        <a class="btn btn-ghost" href="<?= e(base_url('admin/inquiries.php')) ?>">Clear</a>
        <?php endif; ?>
    </form>

    <?php if ($rows === []): ?>
    <p class="muted">No inquiries found.</p>
    <?php else: ?>

    <div class="admin-panel data-table-wrap-desktop">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= (int) $r['id'] ?></td>
                        <td><?= e($r['name']) ?></td>
                        <td><?= e($r['email']) ?></td>
                        <td class="inquiry-phone">
                            <?php
                            $__cc = (string) ($r['phone_country_code'] ?? '');
                            $__nat = (string) ($r['phone_number'] ?? '');
                            $__full = (string) ($r['full_phone_number'] ?? '');
                            $__label = trim($__cc . ' ' . $__nat);
                            $__tel = preg_replace('/\s+/', '', $__full);
                            if ($__full !== '' && preg_match('/^\+[1-9][0-9]{5,14}$/', $__tel)): ?>
                            <a href="tel:<?= e($__tel) ?>"><?= e($__label !== '' ? $__label : $__full) ?></a>
                            <span class="muted" style="display:block;font-size:0.78rem;margin-top:0.15rem;"><?= e($__full) ?></span>
                            <?php else: ?>
                            <?= e($__label) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= e($r['subject']) ?></td>
                        <td class="message-preview" title="<?= e($r['message']) ?>"><?= e($r['message']) ?></td>
                        <td><?= e($r['created_at']) ?></td>
                        <td><span class="badge <?= $r['status'] === 'unread' ? 'badge-warn' : '' ?>"><?= e($r['status']) ?></span></td>
                        <td>
                            <?php if ($r['status'] === 'unread'): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="_csrf" value="<?= e(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="mark_read">
                                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-ghost btn-sm">Read</button>
                            </form>
                            <?php endif; ?>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Delete this inquiry?');">
                                <input type="hidden" name="_csrf" value="<?= e(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-list">
        <?php foreach ($rows as $r): ?>
        <article class="inquiry-card">
            <dl>
                <dt>ID</dt><dd><?= (int) $r['id'] ?></dd>
                <dt>Name</dt><dd><?= e($r['name']) ?></dd>
                <dt>Email</dt><dd><?= e($r['email']) ?></dd>
                <dt>Phone</dt><dd>
                    <?php
                    $__cc = (string) ($r['phone_country_code'] ?? '');
                    $__nat = (string) ($r['phone_number'] ?? '');
                    $__full = (string) ($r['full_phone_number'] ?? '');
                    $__label = trim($__cc . ' ' . $__nat);
                    $__tel = preg_replace('/\s+/', '', $__full);
                    if ($__full !== '' && preg_match('/^\+[1-9][0-9]{5,14}$/', $__tel)): ?>
                    <a href="tel:<?= e($__tel) ?>"><?= e($__label !== '' ? $__label : $__full) ?></a>
                    <div class="muted" style="font-size:0.85rem;margin-top:0.2rem;"><?= e($__full) ?></div>
                    <?php else: ?>
                    <?= e($__label) ?>
                    <?php endif; ?>
                </dd>
                <dt>Subject</dt><dd><?= e($r['subject']) ?></dd>
                <dt>Message</dt><dd><?= nl2br(e($r['message'])) ?></dd>
                <dt>Date</dt><dd><?= e($r['created_at']) ?></dd>
                <dt>Status</dt><dd><span class="badge <?= $r['status'] === 'unread' ? 'badge-warn' : '' ?>"><?= e($r['status']) ?></span></dd>
            </dl>
            <div class="inquiry-actions">
                <?php if ($r['status'] === 'unread'): ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="_csrf" value="<?= e(admin_csrf_token()) ?>">
                    <input type="hidden" name="action" value="mark_read">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button type="submit" class="btn btn-ghost btn-sm">Mark read</button>
                </form>
                <?php endif; ?>
                <form method="post" style="display:inline;" onsubmit="return confirm('Delete?');">
                    <input type="hidden" name="_csrf" value="<?= e(admin_csrf_token()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <nav class="pagination" aria-label="Pagination">
        <span>Page <?= (int) $page ?> of <?= (int) $totalPages ?> (<?= (int) $totalRows ?> total)</span>
        <?php
        $queryBase = $q !== '' ? '?q=' . rawurlencode($q) . '&' : '?';
        if ($page > 1): ?>
        <a class="btn btn-ghost btn-sm" href="<?= e(base_url('admin/inquiries.php') . $queryBase . 'page=' . ($page - 1)) ?>">Previous</a>
        <?php endif;
        if ($page < $totalPages): ?>
        <a class="btn btn-ghost btn-sm" href="<?= e(base_url('admin/inquiries.php') . $queryBase . 'page=' . ($page + 1)) ?>">Next</a>
        <?php endif; ?>
    </nav>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php';
