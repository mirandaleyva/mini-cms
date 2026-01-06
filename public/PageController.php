<?php
declare(strict_types=1);

final class PageController {
  public function __construct(
    private PageRepositoryInterface $repo, // Holt Seiten aus der DB
    private RenderInterface $renderer, // Rendert Seiten als HTML
    private CacheInterface $store) {} // Speichert gecachte Seiten

  public function show(int $pageId): string { // Methode: tut die seite anzeigen, durch den id identifiziert und als string zurückgeben
    $cacheKey = "page_{$pageId}"; // Schlüssel für jede Seite im Cache
    if ($this->store->has($cacheKey)) { // Beim Laden einer Page wird zuerst der Cache geprüft
      return $this->store->get($cacheKey); //Ist die Page im Cache, wird sie von dort verwendet
    }
    $page = $this->repo->findById($pageId); // Ist sie nicht im Cache, wird sie aus dem Repository geladen 
    $this->store->set($cacheKey, $page); // und danach im Cache gespeichert.

    return $this->renderer->render($page); // Die Seite wird gerendert und als HTML zurückgegeben
  }
}