<?php

namespace DMirzorasul\Api\Routing;

class Route
{
    private static array $routes = [];

    public static function get(string $pattern, string $class, string $method): void
    {
        if (!isset(self::$routes['GET'])) {
            self::$routes['GET'] = [];
        }

        self::$routes['GET'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public static function post(string $pattern, string $class, string $method): void
    {
        if (!isset(self::$routes['POST'])) {
            self::$routes['POST'] = [];
        }

        self::$routes['POST'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public static function patch(string $pattern, string $class, string $method): void
    {
        if (!isset(self::$routes['PATCH'])) {
            self::$routes['PATCH'] = [];
        }

        self::$routes['PATCH'][$pattern] = [ 'class' => $class, 'method' => $method ];
    }

    public static function getMatchedController(string $method, string $path): ?array
    {
        // TODO: Add Exception if the endpoint exists but METHOD was not right.
        if (!isset(self::$routes[$method][$path])) {
            return null;
        }

        return self::$routes[$method][$path];
    }
}