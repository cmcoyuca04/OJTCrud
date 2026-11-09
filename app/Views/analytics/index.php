<?= $this->extend('analytics/layout') ?>

<?= $this->section('content') ?>

<h1>Analytics Records</h1>

<div class="bar">
    <form method="get" action="<?= site_url('analytics') ?>" class="filters">
        <select name="type">
            <option value="">All types</option>
            <?php foreach ($types as $t): ?>
                <option value="<?= esc($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= esc($t) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="client_id" min="1" placeholder="Client ID" value="<?= esc($clientId) ?>">
        <button type="submit" class="btn">Filter</button>
        <a class="btn secondary" href="<?= site_url('analytics') ?>">Reset</a>
    </form>
    <a class="btn add" href="<?= site_url('analytics/create') ?>">+ Add Record</a>
</div>

<p class="muted">Total: <?= (int) $pager->getTotal() ?> records</p>

<table>
    <tr>
        <th>ID</th>
        <th>Client ID</th>
        <th>Type</th>
        <th>IP Address</th>
        <th>Session ID</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= esc($r['id']) ?></td>
            <td><?= esc($r['client_id']) ?></td>
            <td><?= esc($r['type']) ?></td>
            <td><?= esc($r['ip_address']) ?></td>
            <td title="<?= esc($r['session_id']) ?>"><?= esc(mb_strimwidth((string) $r['session_id'], 0, 16, '...')) ?></td>
            <td><?= esc($r['created_at']) ?></td>
            <td>
                <a class="btn edit" href="<?= site_url('analytics/edit/' . (int) $r['id']) ?>">Edit</a>
                <form action="<?= site_url('analytics/delete/' . (int) $r['id']) ?>" method="post" style="display:inline"
                      onsubmit="return confirm('Permanently delete record #<?= (int) $r['id'] ?>?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="del">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (! $rows): ?>
        <tr><td colspan="7">No records found.</td></tr>
    <?php endif; ?>
</table>

<div class="pager"><?= $pager->links() ?></div>

<?= $this->endSection() ?>
