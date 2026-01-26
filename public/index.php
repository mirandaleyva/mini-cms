<?php
declare(strict_types=1);

// Base directory (public/)
$base = __DIR__;

// Aufgabe 11: Template Helpers
require_once $base . '/TemplateHelpers.php';

// Aufgabe 10: ViewRenderer
require_once $base . '/ViewRenderer.php';

// Aufgabe 9: Config
require_once $base . '/Config.php';
require_once $base . '/ConfigKeys.php';

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

// Rendering - wird nicht mehr benötigt ab aufgabe 10, das wir ViewRenderer nutzen
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


// Aufgabe 9: ENV + Config
$env = getenv('APP_ENV') ?: 'dev';

$dev = [
    ConfigKeys::APP_ENV => 'dev',
    ConfigKeys::RENDERER_FORMAT => 'html',
    ConfigKeys::FEATURE_CACHE => true,
    ConfigKeys::FEATURE_DEBUG => true,
];

$prod = [
    ConfigKeys::APP_ENV => 'prod',
    ConfigKeys::RENDERER_FORMAT => 'json',
    ConfigKeys::FEATURE_CACHE => false,
    ConfigKeys::FEATURE_DEBUG => false,
];

$config = new Config($env === 'prod' ? $prod : $dev);

// Auswahl Renderer/Cache nur im Bootstrap
$rendererChoice = $config->getString(ConfigKeys::RENDERER_FORMAT);
$renderer = match ($rendererChoice) {
    'html' => new HtmlRenderer(),
    'json' => new JsonRenderer(),
    default => new HtmlRenderer(),
};

$cacheEnabled = $config->getBool(ConfigKeys::FEATURE_CACHE);
$cache = $cacheEnabled ? new ArrayCache() : new NullCache();

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

$controller = new PageController($repo, $view, $cache);

// Ausgabe (Config-gesteuert)
echo "<hr><h2>ENV</h2>";
echo "<p>APP_ENV: " . htmlspecialchars($config->getString(ConfigKeys::APP_ENV), ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p>Renderer: " . htmlspecialchars($rendererChoice, ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p>Cache enabled: " . ($cacheEnabled ? 'true' : 'false') . "</p>";

echo "<hr><h2>MVC-Ausgabe</h2>";
echo $controller->show(1);

// Fehlerseite TEST
echo "<hr><h2>Fehlerseite</h2>";
echo $controller->show(999);

// Legacy
echo "<hr><h2>Legacy</h2>";
if (function_exists('showPage')) {
    showPage(1);
} else {
    echo "Legacy showPage() nicht gefunden.";
}

// PageTitle Validierung
echo "<hr><h2>PageTitle Validierung</h2>";
try {
    $ok = new PageTitle('Kontakt');
    $slug = new Slug('kontakt');
    $p = new Page($ok, $slug);

    echo "OK: " . $p->getTitle()->toString() . "<br>";

    new PageTitle('');
} catch (InvalidArgumentException $e) {
    echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}

// Helpers Laden
echo "<hr><h2>Template Helpers Test</h2>";
$page->addBlock(new TextBlock(99, '<script>alert(1)</script>'));
