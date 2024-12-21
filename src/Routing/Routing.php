<?php

namespace DMirzorasul\Api\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Routing
{
    private array $routes = [];

    public function get(string $pattern, string $class, string $method): void
    {
        if (!isset($this->routes['GET'])) {
            $this->routes['GET'] = [];
        }

        $this->routes['GET'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public function post(string $pattern, string $class, string $method): void
    {
        if (!isset($this->routes['POST'])) {
            $this->routes['POST'] = [];
        }

        $this->routes['POST'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public function patch(string $pattern, string $class, string $method): void
    {
        if (!isset($this->routes['PATCH'])) {
            $this->routes['PATCH'] = [];
        }

        $this->routes['PATCH'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public function getMatchedController(string $method, string $path): ?array
    {
        if (!isset($this->routes[$method][$path])) {
            return null;
        }

        return $this->routes[$method][$path];
    }
}