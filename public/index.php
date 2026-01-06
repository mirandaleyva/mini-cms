<?php
declare(strict_types=1);

require 'ContentBlock.php';
require 'TextBlock.php';
require 'ImageBlock.php';
require 'TeaserBlock.php';
require 'Page.php';

require 'RenderInterface.php';
require 'HtmlRenderer.php';
require 'JsonRenderer.php';

require 'PageRepositoryInterface.php';
require 'InMemoryPageRepository.php';
require 'PageController.php';

require 'CacheInterface.php';
require 'ArrayCache.php';
require 'NullCache.php';

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
