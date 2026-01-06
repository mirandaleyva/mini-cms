<?php
declare(strict_types=1);

final class HtmlRenderer implements RenderInterface{
  public function render(Page $page): string{
  $title = htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8');

  // HTML-String stück für stück aufbau = Valides Dokument
  $html  = "<!doctype html>\n<html lang=\"de\">\n<head>\n";
  $html .= "<meta charset=\"utf-8\">\n";
  $html .= "<title>{$title}</title>\n";
  $html .= "</head>\n<body>\n";
  $html .= "<h1>{$title}</h1>\n";

  // geht über jeder Block. wird separat gerendert
  foreach($page->getBlocks() as $block){
    $html .= $this->renderBlock($block);
  }

  // Dokument schliessen.
  $html .= "</body>\n</html>\n";
  return $html;
}

  private function renderBlock(ContentBlock $block): string{

    // Ausgabe absichern:
    $safe = htmlspecialchars($block->getContent(), ENT_QUOTES, 'UTF-8');

    return match ($block->getType()){
      'headline' => "<h2>{$safe}</h2>\n",
      'text' => "<p>" . nl2br($safe) . "</p>\n",
      default => "<div>{$safe}</div>\n",
    };
  }
}
?>
