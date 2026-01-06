<?php
declare(strict_types=1);
//Speichert nichts
final class NullCache implements CacheInterface
{
  public function get(string $key): mixed
  {
    return null;
  }

  public function set(string $key, mixed $value): void
  {
    // Macht bewusst nichts
  }

  public function has(string $key): bool
  {
    return false; // liefert immer `false` bei `has()`.
  }
}