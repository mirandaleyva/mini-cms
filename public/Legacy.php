<?php
declare(strict_types=1);

require_once __DIR__ . '/ContentBlock.php';
require_once __DIR__ . '/TextBlock.php';
require_once __DIR__ . '/ImageBlock.php';
require_once __DIR__ . '/TeaserBlock.php';
require_once __DIR__ . '/ContentBlockCollection.php';
require_once __DIR__ . '/Page.php';
require_once __DIR__ . '/Renderer.php';

function showPage(int $id): void
{
    // Statt Array-Daten: Objekte bauen
    $page1 = new Page(new PageTitle('Home'), new Slug('home'));
    $page1->addBlock(new TextBlock(1, 'Hallo'));
    $page1->addBlock(new ImageBlock(2, 'bild.jpg', ''));

    $page2 = new Page(new PageTitle('Kontakt'));
    $page2->addBlock(new TextBlock(1, 'Mail: test@example.com'));

    $pages = [
        1 => $page1,
        2 => $page2,
    ];

    if (!isset($pages[$id])) {
        echo '404';
        return;
    }

    $renderer = new Renderer();
    echo $renderer->renderPage($pages[$id]);
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    showPage(1);
}
