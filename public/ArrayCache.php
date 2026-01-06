<?php
declare(strict_types=1);
// Speichert Werte in einem internen Array.
final class ArrayCache implements CacheInterface // Klasse kann nicht verärbt werden
{
  private array $store = []; // Alle Cache-einträge speichern

  public function get(string $key): mixed // Gibt den wert für den angegebenen Schlüssel zurück
  {
    return $this->store[$key] ?? null; // Wenn der Schlüssel nicht existiert, wird null zurückgegeben
  }

  public function set(string $key, mixed $value): void // Speichert einen Wert unter dem angegebenen Schlüssel
  {
    $this->store[$key] = $value; // Wert im internen Array speichern
  }

  public function has(string $key): bool // Prüft ob ein Wert für den angegebenen Schlüssel existiert
  {
    return array_key_exists($key, $this->store); // Gibt true zurück, wenn der Schlüssel existiert, sonst false
  }
}