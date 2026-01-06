<?php
declare(strict_types=1);

final class ImageBlock extends ContentBlock{
  public function __construct(int $id, private string $src, private string $alt='')
  {
    parent::__construct($id);
  }

  public function getSrc(): string
  {
    return $this->src;
  }

  public function getContent(): string
  {
    return $this->getSrc();
  }

  public function getAlt(): string
  {
    return $this->alt;
  }

  public function getTemplateKey(): string
  {
    return 'image';
  }
}