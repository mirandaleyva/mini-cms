<?php
declare(strict_types=1);

final class PageTitle
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException('PageTitle darf nicht leer sein.');
        }
        $len = mb_strlen($value);
        if ($len < 3) {
            throw new InvalidArgumentException('PageTitle muss mindestens 3 Zeichen haben.');
        }
        if ($len > 80) {
            throw new InvalidArgumentException('PageTitle darf maximal 80 Zeichen haben.');
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
