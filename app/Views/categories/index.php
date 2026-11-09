<?= $this->extend('categories/layout') ?>

<?= $this->section('content') ?>

<h1>Categories</h1>

<div class="bar">
    <form method="get" action="<?= site_url('categories') ?>" class="filters">
        <input type="text" name="q" placeholder="Search name" value="<?= esc($search) ?>">
        <select name="type">
            <option value="">All types</option>
            <?php foreach ($types as $t): ?>
                <option value="<?= esc($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= esc($t) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Filter</button>
        <a class="btn secondary" href="<?= site_url('categories') ?>">Reset</a>
    </form>
    <a class="btn add" href="<?= site_url('categories/create') ?>">+ Add Category</a>
</div>

<p class="muted">Total: <?= (int) $pager->getTotal() ?> categories</p>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($rows as $r): ?>
        <?php
        $cls = strtolower((string) $r['type']) === 'income' ? 'income'
             : (strtolower((string) $r['type']) === 'expense' ? 'expense' : 'other');
        ?>
        <tr>
            <td><?= esc($r['id']) ?></td>
            <td><?= esc($r['name']) ?></td>
            <td><span class="badge <?= $cls ?>"><?= esc($r['type']) ?></span></td>
            <td>
                <a class="btn edit" href="<?= site_url('categories/edit/' . (int) $r['id']) ?>">Edit</a>
                <form action="<?= site_url('categories/delete/' . (int) $r['id']) ?>" method="post" style="display:inline"
                      onsubmit="return confirm('Delete this category?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="del">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (! $rows): ?>
        <tr><td colspan="4">No categories found.</td></tr>
    <?php endif; ?>
</table>

<div class="pager"><?= $pager->links() ?></div>

<?= $this->endSection() ?>
