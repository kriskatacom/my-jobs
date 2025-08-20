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
            if ($method !== $route['method']) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = [];
                foreach ($route['params'] as $param) {
                    $params[$param] = $matches[$param] ?? null;
                }

                // Middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass;
                    if (method_exists($middleware, 'handle')) {
                        $middleware->handle($params);
                    }
                }

                [$controllerClass, $methodName] = $route['action'];
                $controller = new $controllerClass();
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
