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

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if(isset($this->routes[$method][$uri])) {
            call_user_func(callback: $this->routes[$method][$uri]);
        } else {
            http_response_code(response_code: 404);
            echo 'Route not found';
        }
    }
}