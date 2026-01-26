<?php
declare(strict_types=1);

// Base directory (public/)
$base = __DIR__;

// Aufgabe 10: ViewRenderer
require_once $base . '/ViewRenderer.php';

// Value Objects (Übung 8)
require_once $base . '/PageTitle.php';
require_once $base . '/Slug.php';

// Blocks + Collection + Page
require_once $base . '/ContentBlock.php';
require_once $base . '/TextBlock.php';
require_once $base . '/ImageBlock.php';
require_once $base . '/TeaserBlock.php';
require_once $base . '/ContentBlockCollection.php';
require_once $base . '/Page.php';

// Repository + Controller
require_once $base . '/PageRepositoryInterface.php';
require_once $base . '/InMemoryPageRepository.php';
require_once $base . '/PageNotFoundException.php';
require_once $base . '/PageController.php';

// Cache
require_once $base . '/CacheInterface.php';
require_once $base . '/NullCache.php';

// Daten (Page aufbauen)
$page = new Page(new PageTitle('DI CMS'), new Slug('di-cms'));
$page->addBlock(new TextBlock(1, 'Hallo Welt'));
$page->addBlock(new ImageBlock(2, 'bild.jpg', 'Bild'));
$page->addBlock(new TeaserBlock(3, 'Mehr', 'Text', 'https://example.com'));

$repo = new InMemoryPageRepository([
    1 => $page,
]);

// view renderer für Controller
$view = new ViewRenderer(__DIR__ . '/views');

$controller = new PageController($repo, $view, new NullCache());
echo $controller->show(1);
