<?php
declare(strict_types=1);

final class PageController {
  public function __construct(
    private PageRepositoryInterface $repo, // Holt Seiten aus der DB
    private ViewRenderer $view, // Rendert Seiten als HTML
    private CacheInterface $cache) {} // Speichert gecachte Seiten

  public function show(int $pageId): string { // Methode: tut die seite anzeigen, durch den id identifiziert und als string zurückgeben
    $cacheKey = "page_" . $pageId; // Schlüssel für jede Seite im Cache

    try{
      if ($this->cache->has($cacheKey)) { // Beim Laden einer Page wird zuerst der Cache geprüft
        $cached = $this->cache->get($cacheKey); // Wenn die Seite im Cache ist, wird sie abgerufen
        if (is_string($cached)) { // Sicherstellen, dass der gecachte Wert HTML ist
          return $cached; //Ist die HTML im Cache, wird sie von dort verwendet
        }
      }
      // Kann jz exception werfen
      $page = $this->repo->findById($pageId); // Ist sie nicht im Cache, wird sie aus dem Repository geladen

      $blocksHtml = [];
      foreach ($page->getBlocks()->all() as $block) {

        if ($block instanceof TextBlock) {
          $blocksHtml[] = $this->view->render('blocks/text.php', [
            'text' => $block->getText()
          ]);
        } else if ($block instanceof ImageBlock) {
          $blocksHtml[] = $this->view->render('blocks/image.php', [
            'src' => $block->getSrc(),
            'alt' => $block->getAlt()
          ]);
        } else if ($block instanceof TeaserBlock) {
          $blocksHtml[] = $this->view->render('blocks/text.php', [
            'text' => $block->getHeadline() . "\n" . $block->getBody()
          ]);
        }
      }

      $html = $this->view->render('page.php', [
        'title' => $page->getTitle()->toString(),
        'blocks' => $blocksHtml
      ]);

      $this->cache->set($cacheKey, $html); // HTML wird gecached

      return $html; // Die Seite wird als HTML zurückgegeben

    } catch(PageNotFoundException $e){
        // Keine echo hier! Wir erzeugen eine Fehler-Page und rendern sie normal.
        $blocksHtml = [
          $this->view->render('blocks/text.php', [
            'text' => "Die Seite {$pageId} existiert nicht."
          ])
        ];

        $html = $this->view->render('page.php', [
          'title' => '404 – Seite nicht gefunden',
          'blocks' => $blocksHtml
        ]);

        return $html;
      }
  }
}