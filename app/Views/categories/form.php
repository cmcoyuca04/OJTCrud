<?= $this->extend('categories/layout') ?>

<?= $this->section('content') ?>

<?php
$errors  = session('errors') ?? [];
$selType = old('type', $row['type'] ?? '');
?>

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
            <input type="text" name="name" maxlength="100" required value="<?= old('name', $row['name'] ?? '') ?>">
        </label>

        <label>Type
            <select name="type" required>
                <option value="">-- choose --</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= esc($t) ?>" <?= $selType === $t ? 'selected' : '' ?>><?= esc($t) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <div class="actions">
            <button type="submit" class="btn add">Save</button>
            <a class="btn secondary" href="<?= site_url('categories') ?>">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
