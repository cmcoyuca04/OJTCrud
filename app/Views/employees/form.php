<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php $errors = session('errors') ?? []; ?>

<h1><?= esc($title) ?></h1>

<div class="card">
    <?php if ($errors): ?>
        <div class="flash err">
            <ul>
                <?php foreach ($errors as $msg): ?>
                    <li><?= esc($msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= $action ?>" method="post">
        <?= csrf_field() ?>

        <label>Name
            <input type="text" name="name" maxlength="255" required autofocus
                   value="<?= esc(old('name', $row['name'] ?? '', false)) ?>">
        </label>

        <label>Role
            <input type="text" name="role" maxlength="100" required placeholder="e.g. Developer, HR, Accountant"
                   value="<?= esc(old('role', $row['role'] ?? '', false)) ?>">
        </label>

        <?php if ($row): ?>
            <p class="muted">Date created: <?= esc($row['created_at'] ?? '-') ?></p>
        <?php endif; ?>

        <div class="actions">
            <button type="submit" class="btn add">Save</button>
            <a class="btn secondary" href="<?= site_url('employees') ?>">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
