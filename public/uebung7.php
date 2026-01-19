<?php
declare(strict_types=1);

$base = __DIR__;

require_once $base . '/ContentBlock.php';
require_once $base . '/TextBlock.php';
require_once $base . '/ImageBlock.php';
require_once $base . '/TeaserBlock.php';

require_once $base . '/ContentBlockCollection.php';
require_once $base . '/Page.php';

require_once $base . '/RenderInterface.php';
require_once $base . '/HtmlRenderer.php';

require_once $base . '/PageRepositoryInterface.php';
require_once $base . '/InMemoryPageRepository.php';

require_once $base . '/CacheInterface.php';
require_once $base . '/NullCache.php';

require_once $base . '/PageNotFoundException.php';
require_once $base . '/PageController.php';

function showPage(int $id): string
{
    $page1 = new Page(new PageTitle('Home'), new Slug('home'));
    $page1->addBlock(new TextBlock(1, 'Hallo'));
    $page1->addBlock(new ImageBlock(2, 'bild.jpg', ''));

    $page2 = new Page(new PageTitle('Kontakt'));
    $page2->addBlock(new TextBlock(1, 'Mail: test@example.com'));

    $repo = new InMemoryPageRepository([
        1 => $page1,
        2 => $page2,
    ]);

    $renderer = new HtmlRenderer();
    $cache = new NullCache();
    $controller = new PageController($repo, $renderer, $cache);

    return $controller->show($id);
}

echo showPage(999);
