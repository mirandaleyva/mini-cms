<?php
declare(strict_types=1);

require __DIR__ . '/ContentBlock.php';
require __DIR__ . '/TextBlock.php';
require __DIR__ . '/ImageBlock.php';
require __DIR__ . '/TeaserBlock.php';
require __DIR__ . '/Page.php';
require __DIR__ . '/RenderInterface.php';
require __DIR__ . '/HtmlRenderer.php';
require __DIR__ . '/JsonRenderer.php';

require __DIR__ . '/PageRepositoryInterface.php';
require __DIR__ . '/InMemoryPageRepository.php';
require __DIR__ . '/PageController.php';

require __DIR__ . '/CacheInterface.php';
require __DIR__ . '/ArrayCache.php';
require __DIR__ . '/NullCache.php';

require __DIR__ . '/PageNotFoundException.php';

// Daten
$page = new Page('DI CMS');
$page->addBlock(new TextBlock(1, 'Hallo Welt'));
$page->addBlock(new ImageBlock(2, 'bild.jpg', 'Bild'));
$page->addBlock(new TeaserBlock(3, 'Mehr', 'Text', 'https://example.com'));

$repo = new InMemoryPageRepository([
    1 => $page
]);

echo "<hr><h2>HTML-Ausgabe</h2>";

// HTML
$controller = new PageController($repo, new HtmlRenderer(), new NullCache());
echo $controller->show(1);

echo "<hr><h2>JSON-Ausgabe</h2>";


// JSON
$controller = new PageController($repo, new JsonRenderer(), new NullCache());
echo $controller->show(1);

echo "<hr><h2>Find by ID</h2>";

$renderer = new JsonRenderer();
echo $renderer->render($repo->findById(1));

// Cache
echo "<hr><h2>Cache</h2>";
$cache = new ArrayCache();
$controller = new PageController($repo, $renderer, $cache);
echo $controller->show(1);

$cache = new NullCache();
$controller = new PageController($repo, $renderer, $cache);
echo $controller->show(1);

// Fehlerseite
echo "<hr><h2>Fehlerseite</h2>";
echo $controller->show(999);