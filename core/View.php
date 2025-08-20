<?php

namespace Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewPath = dirname(__DIR__) . '/src/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View '$view' not found at $viewPath");
        }

        extract($data);
        require $viewPath;
    }
}
