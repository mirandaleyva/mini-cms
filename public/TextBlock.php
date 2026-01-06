<?php
declare(strict_types=1);

final class TextBlock extends ContentBlock{
  public function __construct(int $id, private string $text)
  {
    parent::__construct($id);
  }

  public function getText(): string
  {
    return $this->text;
  }

  public function getContent(): string
  {
    return $this->getText();
  }

  public function getTemplateKey(): string
  {
    return 'text';
  }
}