<?php

namespace App\Core;

use App\Core\Route;

class Router
{
    private mixed $request;
    private array $routes;
    private mixed $current_route;
    const string BASE_CONTROLLER = '\App\Controllers\\';

    public function __construct()
    {
        $this->request = strtolower($_SERVER['REQUEST_METHOD']);

        $this->routes = Route::routes();
        $this->current_route = $this->findRoute($this->request) ?? null;
    }

    public function findRoute($request)
    {
        $methods = array_column($this->routes, 'method');
        if (!in_array($request, $methods)) {
            return false;
        }

        foreach ($this->routes as $route) {
            if ($request == $route['method']) {
                return $route;
            }
        }
        return null;
    }

    public function dispatch404()
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }

    public function run()
    {
        if (is_null($this->current_route))
            $this->dispatch404();
        $this->dispatch($this->current_route);
    }

    private function dispatch($route)
    {
        $action = $route['action'];
        # action : null
        if (empty($action)) {
            return;
        }

        # action : clousure
        if (is_callable($action)) {
            $action();
            // call_user_func($action);
        }

        # action : Controller@method
        if (is_string($action))
            $action = explode('@', $action);

        # action : ['Controller','method']
        if (is_array($action)) {
            $class_name = self::BASE_CONTROLLER . $action[0];
            $method = $action[1];
            if (!class_exists($class_name))
                throw new \Exception("Class $class_name Not Exists!");

            $controller = new $class_name();

            if (!method_exists($controller, $method))
                throw new \Exception("method $method Not Exists in class $class_name");

            if ($method == 'update' || $method == 'delete') {
                $request_uri = $_SERVER['REQUEST_URI'];
                $uri_parts = explode('/', $request_uri);

                $ticket_id = isset($uri_parts[3]) ? (int)$uri_parts[3] : null;
                $controller->{$method}($ticket_id);
            } else {
                $controller->{$method}();
            }
        }
    }
}
