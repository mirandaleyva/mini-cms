<?php

// Da wird kein HTML erzeugt

declare(strict_types=1);

// interface = Vetrag
interface RenderInterface
{
    public function render(Page $page): string;
}