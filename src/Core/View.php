<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'default',
    ): void {
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if (file_exists($layoutFile)) {
            require $layoutFile;
            return;
        }

        echo $content;
    }

    public static function partial(string $view, array $data = []): void
    {
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Partial not found: {$view}");
        }

        extract($data, EXTR_SKIP);

        require $viewFile;
    }

    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
