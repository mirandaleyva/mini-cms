<?php
declare(strict_types=1);

final class EmailAddress
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '' || filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Ungültige E-Mail-Adresse.');
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
