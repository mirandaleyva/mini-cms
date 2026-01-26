<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Rendert ein Partial innerhalb eines Templates.
 * $template ist relativ zu views/ (z.B. 'partials/header.php')
 */
function includePartial(string $template, array $data = []): void
{
    $base = __DIR__ . '/views/';
    $file = $base . ltrim($template, '/\\');

    if (!is_file($file)) {
        throw new RuntimeException("Partial nicht gefunden: {$file}");
    }

    extract($data, EXTR_SKIP);
    require $file;
}
