<?php 
declare(strict_types=1);

final class inMemoryPageRepository implements PageRepositoryInterface{
  /** @var array<int, Page> */
  private array $pages;

  public function __construct(array $pages)
  {
    $this->pages = $pages;
  }

  public function findById(int $id): Page
  {
    if (!isset($this->pages[$id])) {
      throw new RuntimeException("Page {$id} nicht gefunden");
    }

    return $this->pages[$id];
  }
}