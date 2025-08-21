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

    public static function redirect($url, $permanent = false): never
    {
        if (!headers_sent()) {
            header('Location: ' . $url, true, $permanent ? 301 : 302);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '";';
            echo '</script>';
            exit();
        }
    }
}
