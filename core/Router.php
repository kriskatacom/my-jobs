<?php

namespace Core;

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $pattern, array $action, array $middleware = []): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $this->convertPattern($pattern),
            'params' => $this->extractParams($pattern),
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function get(string $pattern, array $action, array $middleware = [])
    {
        $this->addRoute('GET', $pattern, $action, $middleware);
    }

    public function post(string $pattern, array $action, array $middleware = [])
    {
        $this->addRoute('POST', $pattern, $action, $middleware);
    }

    public function put(string $pattern, array $action, array $middleware = [])
    {
        $this->addRoute('PUT', $pattern, $action, $middleware);
    }

    public function delete(string $pattern, array $action, array $middleware = [])
    {
        $this->addRoute('DELETE', $pattern, $action, $middleware);
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if (strtoupper($method) !== strtoupper($route['method'])) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Numeric array за call_user_func_array (работи на всички PHP версии)
                $params = [];
                foreach ($route['params'] as $param) {
                    $params[] = $matches[$param] ?? null;
                }

                // Middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    if (!class_exists($middlewareClass)) {
                        error_log("Middleware class not found: $middlewareClass");
                        continue;
                    }
                    $middleware = new $middlewareClass();
                    if (method_exists($middleware, 'handle')) {
                        $middleware->handle($matches); // подаваме $matches ако middleware иска имената
                    }
                }

                // Контролер
                [$controllerClass, $methodName] = $route['action'];
                

                if (!class_exists($controllerClass)) {
                    error_log("Controller class not found: $controllerClass");
                    http_response_code(500);
                    echo "Internal Server Error: Controller not found";
                    return;
                }
                

                $controller = new $controllerClass();
                

                if (!method_exists($controller, $methodName)) {
                    error_log("Method $methodName not found in controller $controllerClass");
                    http_response_code(500);
                    echo "Internal Server Error: Method not found";
                    return;
                }

                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    protected function convertPattern(string $pattern): string
    {
        return "#^" . preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $pattern) . "$#";
    }

    protected function extractParams(string $pattern): array
    {
        preg_match_all('/\{(\w+)\}/', $pattern, $matches);
        return $matches[1] ?? [];
    }

    public static function getDomain(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
}
