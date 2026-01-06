<?php

declare(strict_types=1);

final class JsonRenderer implements RenderInterface
{
    public function render(Page $page): string
    {
        return json_encode([ // wird in Json umgewandelt
            'title' => $page->getTitle(), // Seitentitel
            'blocks' => array_map( // ContentBlock als array
                fn(ContentBlock $b) => [
                    'type' => $b->getType(),
                    'content' => $b->getContent()
                ],
                $page->getBlocks()
            )
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}