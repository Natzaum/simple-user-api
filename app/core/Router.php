<?php

class Router
{
    private array $routes = [];

    public function get(string $uri, callable $callback): void
    {
        $this->routes['GET'][$uri] = $callback;
    }

    public function post(string $uri, callable $callback): void
    {
        $this->routes['POST'][$uri] = $callback;
    }

    public function put(string $uri, callable $callback): void
    {
        $this->routes['PUT'][$uri] = $callback;
    }

    public function delete(string $uri, callable $callback): void
    {
        $this->routes['DELETE'][$uri] = $callback;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if(isset($this->routes[$method][$uri])) {
            echo call_user_func(callback: $this->routes[$method][$uri]);
            return;
        }
        
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                echo call_user_func_array($callback, $matches);
                return;
            }
        }

        http_response_code(404);
        echo 'Route not found';
    }
}