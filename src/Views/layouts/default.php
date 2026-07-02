<!DOCTYPE html>
<html lang="fr">

<head>
    <?php \App\Core\View::partial('components/head', [
        'title' => $title ?? 'EasyUpload',
    ]); ?>
</head>

<body>

<?php \App\Core\View::partial('components/header'); ?>

<main>
    <?= $content ?>
</main>

<?php \App\Core\View::partial('components/footer'); ?>

</body>
</html>
