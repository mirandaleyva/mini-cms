<?php
declare(strict_types=1);

final class ContentBlockCollection
{
    /** @var ContentBlock[] */
    private array $blocks = [];

    public function __construct(array $blocks = [])
    {
        foreach ($blocks as $block) {
            $this->add($block);
        }
    }

    public function add(ContentBlock $block): void
    {
        $this->blocks[] = $block;
    }

    /** @return ContentBlock[] */
    public function all(): array
    {
        return $this->blocks;
    }

    public function count(): int
    {
        return count($this->blocks);
    }

    public function findById(int $id): ?ContentBlock
    {
        foreach ($this->blocks as $block) { // gehen alle blocks durch
            if ($block->getId() === $id) { // wenn die id passt
                return $block; // gib den block zurück
            }
        }
      return null; // wenn keiner passt, gib null zurück
    }

    public function filter(callable $predicate): ContentBlockCollection // ein predicate ist eine Funktion die true/false zurückgibt
    {
        $filtered = new self(); // neue Collection erstellen / nicht bestehende ändern!

        foreach ($this->blocks as $block) { // alle blocks durchgehen
            if ($predicate($block)) { // funktion aufrufen / block behalten wenn true
                $filtered->add($block); // Wenn true, dann in die neue Collection hinzufügen
            }
        }
        return $filtered; // gefilterte Collection zurückgeben
    }

    public function onlyTextBlocks(): ContentBlockCollection // function die nur TextBlocks zurückgibt
    {
        return $this->filter( // benutze eigene filter function
          fn(ContentBlock $block) => $block instanceof TextBlock // gibt true aus wenn textblock
        );
    }
}