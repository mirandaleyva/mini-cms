<?php
declare(strict_types=1);

final class PageController {
  public function __construct(
    private PageRepositoryInterface $repo, // Holt Seiten aus der DB
    private RenderInterface $renderer, // Rendert Seiten als HTML
    private CacheInterface $cache) {} // Speichert gecachte Seiten

  public function show(int $pageId): string { // Methode: tut die seite anzeigen, durch den id identifiziert und als string zurückgeben
    $cacheKey = "page_" . $pageId; // Schlüssel für jede Seite im Cache

    try{
      if ($this->cache->has($cacheKey)) { // Beim Laden einer Page wird zuerst der Cache geprüft
        $cached = $this->cache->get($cacheKey); // Wenn die Seite im Cache ist, wird sie abgerufen
        if ($cached instanceof Page) { // Sicherstellen, dass der gecachte Wert eine Page ist
          return $this->renderer->render($cached); //Ist die Page im Cache, wird sie von dort verwendet
        }
      }
      // Kann jz exception werfen
      $page = $this->repo->findById($pageId); // Ist sie nicht im Cache, wird sie aus dem Repository geladen

      $this->cache->set($cacheKey, $page); // und danach im Cache gespeichert.

      return $this->renderer->render($page); // Die Seite wird gerendert und als HTML zurückgegeben

    } catch(PageNotFoundException $e){
        // Keine echo hier! Wir erzeugen eine Fehler-Page und rendern sie normal.
        $errorPage = new Page(new PageTitle('404 – Seite nicht gefunden'));
        $errorPage->addBlock(new TextBlock(1, "Die Seite {$pageId} existiert nicht."));
        return $this->renderer->render($errorPage);    
      }
  }
}