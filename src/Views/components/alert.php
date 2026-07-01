<?php if (!empty($message)): ?>
<div class="alert alert-<?= $type ?? 'info' ?>">
    <?= \App\Core\View::escape($message) ?>
</div>
<?php endif; ?>
