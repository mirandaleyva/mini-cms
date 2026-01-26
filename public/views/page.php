<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

<h1><?= htmlspecialchars($title) ?></h1>

<?php foreach ($blocks as $blockHtml): ?>
    <?= $blockHtml ?>
<?php endforeach; ?>

</body>
</html>