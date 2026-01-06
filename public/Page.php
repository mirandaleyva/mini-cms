<?php
declare(strict_types=1);

final class Page{
  private string $title;

  // @var ContentBlock[]
  private array $blocks = [];

  public function __construct(string $title){
    $this->title = $title;
  }

  public function addBlock(ContentBlock $block): void
  {
    $this->blocks[] = $block;
  }

  // @return ContentBlock[]
  public function getBlocks(): array{
    return $this->blocks;
  }

  public function getTitle(): string{
    return $this->title;
  }
}

// Da werden die Blocks gesammelt, kein render (HTML ladet sonnst auf der Page)
?>
