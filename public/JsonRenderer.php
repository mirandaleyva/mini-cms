<?php
declare(strict_types=1);

final class JsonRenderer implements RenderInterface
{
    public function render(Page $page): string
    {
        $blocks = [];

        foreach ($page->getBlocks()->all() as $block) {

            if ($block instanceof TextBlock) {
                $blocks[] = [
                    'type' => 'text',
                    'text' => $block->getText()
                ];
            }

            elseif ($block instanceof ImageBlock) {
                $blocks[] = [
                    'type' => 'image',
                    'src'  => $block->getSrc(),
                    'alt'  => $block->getAlt()
                ];
            }

            elseif ($block instanceof TeaserBlock) {
                $blocks[] = [
                    'type' => 'teaser',
                    'headline' => $block->getHeadline(),
                    'body'     => $block->getBody(),
                    'url'      => $block->getLinkUrl()
                ];
            }
        }

        return json_encode([
            'title'  => $page->getTitle(),
            'blocks' => $blocks
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
