<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Analytics') ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6f8; margin: 0; color: #222; }
        .wrap { max-width: 1000px; margin: 32px auto; padding: 0 16px; }
        h1 { margin: 0 0 16px; }
        .bar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 8px; }
        .filters { display: flex; gap: 8px; flex-wrap: wrap; }
        input, select { padding: 8px; border: 1px solid #bbb; border-radius: 4px; font-size: 14px; }
        .btn, button { display: inline-block; padding: 8px 14px; border: 0; border-radius: 4px; color: #fff; background: #455a64; text-decoration: none; cursor: pointer; font-size: 14px; }
        .add { background: #2e7d32; } .edit { background: #1565c0; } .del { background: #c62828; } .secondary { background: #757575; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 14px; }
        th { background: #eceff1; }
        .muted { color: #666; font-size: 13px; }
        .flash { padding: 10px 14px; border-radius: 4px; margin-bottom: 12px; }
        .flash.ok { background: #e8f5e9; color: #1b5e20; }
        .flash.err { background: #ffebee; color: #b71c1c; }
        .flash.err ul { margin: 0; padding-left: 18px; }
        .card { background: #fff; padding: 20px; border-radius: 6px; max-width: 520px; }
        label { display: block; margin-top: 14px; font-weight: bold; font-size: 14px; }
        .card input, .card select { width: 100%; box-sizing: border-box; margin-top: 4px; }
        .pager { margin-top: 14px; }
        .pager ul { list-style: none; padding: 0; display: flex; gap: 6px; flex-wrap: wrap; }
        .pager a { padding: 6px 10px; background: #fff; border: 1px solid #ccc; border-radius: 4px; text-decoration: none; color: #1565c0; }
        .pager li.active a { background: #1565c0; color: #fff; }
    </style>
</head>
<body>
<div class="wrap">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash ok"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>
</body>
</html>
