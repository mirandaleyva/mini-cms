<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title><?= e($pageTitle ?? 'Seite') ?></title>
</head>
<body>

<?php includePartial('partials/header.php', ['pageTitle' => $pageTitle ?? 'Seite']); ?>

<main>
    <?= $content ?>
</main>

<?php includePartial('partials/footer.php'); ?>

</body>
</html>
