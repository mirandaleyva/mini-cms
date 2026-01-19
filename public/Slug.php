<?php
declare(strict_types=1);

final class Slug
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException('Slug darf nicht leer sein.');
        }

        // Optional: Normalisierung (einfach)
        $value = strtolower($value);

        if (!preg_match('/^[a-z0-9-]+$/', $value)) {
            throw new InvalidArgumentException('Slug darf nur a-z, 0-9 und "-" enthalten.');
        }

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
