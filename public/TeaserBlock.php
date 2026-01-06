<?php
declare(strict_types=1);

final class TeaserBlock extends ContentBlock{
  public function __construct(int $id, private string $headline, private string $body, private string $linkUrl)
  {
    parent::__construct($id);
  }

  public function getHeadline(): string
  {
    return $this->headline;
  }

  public function getBody(): string
  {
    return $this->body;
  }

  public function getContent(): string
  {
    return $this->getBody();
  }

  public function getLinkUrl(): string
  {
    return $this->linkUrl;
  }

  public function getTemplateKey(): string
  {
    return 'teaser';
  }
} 