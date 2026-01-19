<?php
declare(strict_types=1);

final class HtmlRenderer implements RenderInterface
{
    public function render(Page $page): string
    {
        $title = htmlspecialchars($page->getTitle()->toString(), ENT_QUOTES, 'UTF-8');

        $html  = "<!doctype html>\n<html lang=\"de\">\n<head>\n";
        $html .= "<meta charset=\"utf-8\">\n";
        $html .= "<title>{$title}</title>\n";
        $html .= "</head>\n<body>\n";
        $html .= "<h1>{$title}</h1>\n";

        foreach ($page->getBlocks()->all() as $block) {
            $html .= $this->renderBlock($block);
        }

        $html .= "</body>\n</html>\n";
        return $html;
    }

    private function renderBlock(ContentBlock $block): string
    {
        if ($block instanceof TextBlock) {
            $safe = nl2br(htmlspecialchars($block->getText(), ENT_QUOTES, 'UTF-8'));
            return "<p>{$safe}</p>\n";
        }

        if ($block instanceof ImageBlock) {
            $src = htmlspecialchars($block->getSrc(), ENT_QUOTES, 'UTF-8');
            $alt = htmlspecialchars($block->getAlt(), ENT_QUOTES, 'UTF-8');
            return "<img src=\"{$src}\" alt=\"{$alt}\">\n";
        }

        if ($block instanceof TeaserBlock) {
            $h = htmlspecialchars($block->getHeadline(), ENT_QUOTES, 'UTF-8');
            $b = htmlspecialchars($block->getBody(), ENT_QUOTES, 'UTF-8');
            $u = htmlspecialchars($block->getLinkUrl(), ENT_QUOTES, 'UTF-8');
            return "<a class=\"teaser\" href=\"{$u}\"><h3>{$h}</h3><p>{$b}</p></a>\n";
        }

        return "<!-- Unbekannter Block-Typ -->\n";
    }
}
