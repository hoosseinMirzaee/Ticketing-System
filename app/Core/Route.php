<?php

namespace App\Core;

class Route
{
    private static array $routes = [];

    public static function add($method, $uri, $action = null, $middleware = [])
    {
        self::$routes[] = ['method' => $method, 'uri' => $uri, 'action' => $action, 'middleware' => $middleware];
    }

    public static function get($uri, $action = null, $middleware = [])
    {
        self::add('get', $uri, $action, $middleware);
    }

    public static function post($uri, $action = null, $middleware = [])
    {
        self::add('post', $uri, $action, $middleware);
    }

    public static function put($uri, $action = null, $middleware = [])
    {
        self::add('put', $uri, $action, $middleware);
    }

    public static function patch($uri, $action = null, $middleware = [])
    {
        self::add('patch', $uri, $action, $middleware);
    }

    public static function delete($uri, $action = null, $middleware = [])
    {
        self::add('delete', $uri, $action, $middleware);
    }

    public static function options($uri, $action = null, $middleware = [])
    {
        self::add('options', $uri, $action, $middleware);
    }

    public static function routes()
    {
        return self::$routes;
    }
}
