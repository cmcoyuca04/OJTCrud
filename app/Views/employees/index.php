<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Employees</h1>

<div class="bar">
    <form method="get" action="<?= site_url('employees') ?>" class="filters">
        <input type="text" name="q" placeholder="Search name or role" value="<?= esc($search) ?>">
        <button type="submit" class="btn">Search</button>
        <a class="btn secondary" href="<?= site_url('employees') ?>">Reset</a>
    </form>
    <a class="btn add" href="<?= site_url('employees/create') ?>">+ Add Employee</a>
</div>

<p class="muted">Total: <?= (int) $pager->getTotal() ?> employees</p>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Date Created</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= esc($r['id']) ?></td>
            <td><?= esc($r['name']) ?></td>
            <td><?= esc($r['role']) ?></td>
            <td><?= esc($r['created_at'] ?? '') ?></td>
            <td>
                <a class="btn edit" href="<?= site_url('employees/edit/' . (int) $r['id']) ?>">Edit</a>
                <form action="<?= site_url('employees/delete/' . (int) $r['id']) ?>" method="post" style="display:inline"
                      onsubmit="return confirm('Delete this employee?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="del">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (! $rows): ?>
        <tr><td colspan="5">No employees found.</td></tr>
    <?php endif; ?>
</table>

<div class="pager"><?= $pager->links() ?></div>

<?= $this->endSection() ?>
