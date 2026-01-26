<?php
declare(strict_types=1);

final class NullLogger implements LoggerInterface
{
    public function debug(string $message): void
    {
        // Macht bewusst nichts
    }
}