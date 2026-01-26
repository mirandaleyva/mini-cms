<?php
declare(strict_types=1);

final class Config
{
    public function __construct(private array $values)
    {
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->values);
    }

    public function getString(string $key): string
    {
        if (!$this->has($key)){
            throw new RuntimeException("Config Key fehlt: {$key}.");
        }
        $value = $this->values[$key];

        if (!is_string($value)){
            throw new RuntimeException("Config Key {$key} ist kein String.");
        }

        return $value;
    }

    public function getBool(string $key): bool
    {
        if (!$this->has($key)){
            throw new RuntimeException("Config Key fehlt: {$key}.");
        }
        $value = $this->values[$key];

        if (!is_bool($value)){
            return $value;
        }
        // WICHTIG: Strings wie false dürfen nicht als true/false interpretiert werden
        if (is_string($value)){ 
            $v = strtolower(trim($value));
            if (in_array($v, ['1', 'true', 'yes', 'on'], true))
                return true;
            if (in_array($v, ['0', 'false', 'no', 'off'], true))
                return false;
        }
        if (is_int($value)) {
          return $value === 1;
        }
        throw new RuntimeException("Config Key {$key} ist kein Bool.");
    }
}