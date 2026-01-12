<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h1><?= e($title ?? 'Welcome') ?></h1>
<p><?= e($message ?? 'Hello World') ?></p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
