<?php
declare(strict_types=1);

final class ViewRenderer
{
    public function __construct(
        private string $basePath // Pfad zum Verzeichnis mit den View-Dateien
    ) {}

    public function render(string $template, array $data = []): string
    {
        $file = rtrim($this->basePath, '/\\') . DIRECTORY_SEPARATOR . $template;

        if (!is_file($file)) {
            throw new RuntimeException("View nicht gefunden: {$file}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        return (string) ob_get_clean();
    }

    public function renderWithLayout(string $template, array $data, string $layout): string
    {
        // 1) Content rendern
        $content = $this->render($template, $data);

        // 2) Layout rendern (bekommt $content + Layout-Daten)
        $layoutData = $data;
        $layoutData['content'] = $content;

        return $this->render($layout, $layoutData);
    }
}