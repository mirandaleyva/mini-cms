<?php
declare(strict_types=1);

final class Renderer
{
    public function renderPage(Page $page): string
    {
        $title = htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8');

        $html  = "<!doctype html>\n<html lang=\"de\">\n<head>\n";
        $html .= "  <meta charset=\"utf-8\">\n";
        $html .= "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
        $html .= "  <title>{$title}</title>\n";
        $html .= "</head>\n<body>\n";
        $html .= "  <h1>{$title}</h1>\n";

        foreach ($page->getBlocks() as $block) {
            $html .= $this->renderBlock($block);
        }

        $html .= "</body>\n</html>\n";
        return $html;
    }

    public function renderBlock(ContentBlock $block): string
    {
        // Polymorphie/Dispatch ohne type-String
        if ($block instanceof TextBlock) {
            return $this->renderTextBlock($block);
        }

        if ($block instanceof ImageBlock) {
            return $this->renderImageBlock($block);
        }

        if ($block instanceof TeaserBlock) {
            return $this->renderTeaserBlock($block);
        }

        // falls später neue Block-Typen kommen und den Renderer erweiterung vergessen geht
        throw new RuntimeException('Unbekannter Block-Typ: ' . $block::class);
    }

    private function renderTextBlock(TextBlock $block): string
    {
        $safe = nl2br(htmlspecialchars($block->getText(), ENT_QUOTES, 'UTF-8'));
        return "<section class=\"block\"><p>{$safe}</p></section>\n";
    }

    private function renderImageBlock(ImageBlock $block): string
    {
        $src = htmlspecialchars($block->getSrc(), ENT_QUOTES, 'UTF-8');
        $alt = htmlspecialchars($block->getAlt(), ENT_QUOTES, 'UTF-8');
        return "<section class=\"block\"><img src=\"{$src}\" alt=\"{$alt}\"></section>\n";
    }

    private function renderTeaserBlock(TeaserBlock $block): string
    {
        $h = htmlspecialchars($block->getHeadline(), ENT_QUOTES, 'UTF-8');
        $b = htmlspecialchars($block->getBody(), ENT_QUOTES, 'UTF-8');
        $u = htmlspecialchars($block->getLinkUrl(), ENT_QUOTES, 'UTF-8');

        return "<section class=\"block\"><a class=\"teaser\" href=\"{$u}\"><h3>{$h}</h3><p>{$b}</p></a></section>\n";
    }
}
