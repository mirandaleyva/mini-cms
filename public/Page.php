<?php
declare(strict_types=1);

final class Page{
  private PageTitle $title;
  private ?Slug $slug;
  private ContentBlockCollection $blocks;

  public function __construct(PageTitle $title, ?Slug $slug = null){
    $this->title = $title;
    $this->slug = $slug;
    $this->blocks = new ContentBlockCollection();
  }

  public function getTitle(): PageTitle{
    return $this->title;
  }

  public function getSlug(): ?Slug{
    return $this->slug;
  }

  public function addBlock(ContentBlock $block): void
  {
    $this->blocks->add($block);
  }

  public function getBlocks(): ContentBlockCollection{
    return $this->blocks;
  }
}

// Da werden die Blocks gesammelt, kein render (HTML ladet sonnst auf der Page)
?>
