<?= $this->extend('analytics/layout') ?>

<?= $this->section('content') ?>

<?php
$errors  = session('errors') ?? [];
$selType = old('type', $row['type'] ?? '');

$createdDefault = '';
if (! empty($row['created_at'])) {
    $ts = strtotime($row['created_at']);
    $createdDefault = $ts ? date('Y-m-d\TH:i:s', $ts) : '';
}
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

        <label>Client ID
            <input type="number" name="client_id" min="1" required value="<?= old('client_id', $row['client_id'] ?? '') ?>">
        </label>

        <label>Type
            <select name="type" required>
                <option value="">-- choose --</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= esc($t) ?>" <?= $selType === $t ? 'selected' : '' ?>><?= esc($t) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>IP Address
            <input type="text" name="ip_address" maxlength="45" value="<?= old('ip_address', $row['ip_address'] ?? '') ?>">
        </label>

        <label>Session ID
            <input type="text" name="session_id" maxlength="128" value="<?= old('session_id', $row['session_id'] ?? '') ?>">
        </label>

        <label>Created At
            <input type="datetime-local" step="1" name="created_at" value="<?= old('created_at', $createdDefault) ?>">
        </label>
        <p class="muted">Leave blank when adding to use the current date and time.</p>

        <button type="submit" class="btn add">Save</button>
        <a class="btn secondary" href="<?= site_url('analytics') ?>">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>
