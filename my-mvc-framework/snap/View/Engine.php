<?php

declare(strict_types=1);

namespace snap\View;

use RuntimeException;

class Engine
{
    public function __construct(
        private string $viewsPath,
    ) {}

    public function render(string $view, array $data = []): string
    {
        $inner  = $this->renderTemplate($view, $data);
        $title  = $data['title'] ?? 'Task Manager';
        return $this->renderTemplate('layout', ['content' => $inner, 'title' => $title]);
    }

    private function renderTemplate(string $view, array $data): string
    {
        $file = $this->viewsPath . '/' . $view . '.php';

        if (! file_exists($file)) {
            throw new RuntimeException("View not found: [{$file}]");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        return (string) ob_get_clean();
    }
}
