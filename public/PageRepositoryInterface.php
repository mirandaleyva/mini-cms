<?php
declare(strict_types=1);

interface PageRepositoryInterface {
  public function findById(int $id): Page;
}