<?php
declare(strict_types=1);

// Base directory (public/)
$base = __DIR__;

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

// Rendering
require_once $base . '/RenderInterface.php';
require_once $base . '/HtmlRenderer.php';
require_once $base . '/JsonRenderer.php';

// Repository + Controller
require_once $base . '/PageRepositoryInterface.php';
require_once $base . '/InMemoryPageRepository.php';
require_once $base . '/PageNotFoundException.php';
require_once $base . '/PageController.php';

// Cache
require_once $base . '/CacheInterface.php';
require_once $base . '/ArrayCache.php';
require_once $base . '/NullCache.php';

// Legacy (nur Funktionen laden, nicht auto-ausführen)
require_once $base . '/Legacy.php';

// --------------------
// Daten (Page aufbauen)
// --------------------
$page = new Page(new PageTitle('DI CMS'), new Slug('di-cms'));
$page->addBlock(new TextBlock(1, 'Hallo Welt'));
$page->addBlock(new ImageBlock(2, 'bild.jpg', 'Bild'));
$page->addBlock(new TeaserBlock(3, 'Mehr', 'Text', 'https://example.com'));

$repo = new InMemoryPageRepository([
    1 => $page,
]);

// --------------------
// HTML-Ausgabe
// --------------------
echo "<hr><h2>HTML-Ausgabe</h2>";
$controller = new PageController($repo, new HtmlRenderer(), new NullCache());
echo $controller->show(1);

// --------------------
// JSON-Ausgabe
// --------------------
echo "<hr><h2>JSON-Ausgabe</h2>";
$controller = new PageController($repo, new JsonRenderer(), new NullCache());
echo $controller->show(1);

// --------------------
// Repository findById (Page)
// --------------------
echo "<hr><h2>Repository: findById(Page)</h2>";
$renderer = new JsonRenderer();
echo $renderer->render($repo->findById(1));

// --------------------
// Collection findById (ContentBlock)
// --------------------
echo "<hr><h2>Collection: findById(ContentBlock)</h2>";
$block = $repo->findById(1)->getBlocks()->findById(2);
echo "<pre>";
var_dump($block);
echo "</pre>";

// --------------------
// Cache-Test
// --------------------
echo "<hr><h2>Cache</h2>";
$cache = new ArrayCache();
$controller = new PageController($repo, $renderer, $cache);
echo $controller->show(1);

$cache = new NullCache();
$controller = new PageController($repo, $renderer, $cache);
echo $controller->show(1);

// --------------------
// Fehlerseite TEST
// --------------------
echo "<hr><h2>Fehlerseite</h2>";
echo $controller->show(999);

// --------------------
// Legacy (nur wenn showPage() existiert)
// Achtung: Legacy.php darf NICHT selbst showPage(1) ausführen.
// --------------------
echo "<hr><h2>Legacy</h2>";
if (function_exists('showPage')) {
    showPage(1);
} else {
    echo "Legacy showPage() nicht gefunden.";
}

// --------------------
// PageTitle Validierung
// --------------------
echo "<hr><h2>PageTitle Validierung</h2>";
try {
    $ok = new PageTitle('Kontakt');
    $slug = new Slug('kontakt');
    $p = new Page($ok, $slug);

    echo "OK: " . $p->getTitle()->toString() . "<br>";

    // Ungültig (muss Exception werfen)
    new PageTitle('');
} catch (InvalidArgumentException $e) {
    echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
