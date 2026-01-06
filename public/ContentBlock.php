<?php
declare(strict_types=1);

abstract class ContentBlock
{
  public function __construct(private int $id)
  {}

  public function getId(): int
  {
    return $this->id;
  }

  // Laut aufgabe: abstrakter key
  abstract public function getTemplateKey(): string;

  // Einheitliche Schnittstelle für Renderer
  abstract public function getContent(): string;

  public function getType(): string
  {
    return $this->getTemplateKey();
  }
}
?>