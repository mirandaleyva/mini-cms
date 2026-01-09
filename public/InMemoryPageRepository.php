<?php 
declare(strict_types=1);

final class InMemoryPageRepository implements PageRepositoryInterface{
  /** @var array<int, Page> */
  private array $pages;

  public function __construct(array $pages)
  {
    $this->pages = $pages;
  }
  /** @throws PageNotFoundException */
  public function findById(int $id): Page
  {
    if (!isset($this->pages[$id])) {
      throw new PageNotFoundException("Page {$id} nicht gefunden");
    }

    return $this->pages[$id];
  }
}