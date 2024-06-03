<?php

namespace App;

class Router
{
    private array $routes = [];

    public function addRoute($method, $path, $controller, $action)
    {
        $this->routes[strtoupper($method)][$path] = [$controller, $action];

    }

    public function dispatch($requestUri, $requestMethod)
    {
        $methodRoutes = $this->routes[strtoupper($requestMethod)] ?? [];

        if(isset($methodRoutes[$requestUri])) {
            [$controller, $action] = $methodRoutes[$requestUri];
            if(class_exists($controller) && method_exists($controller, $action)) {
                $controllerInstance = new $controller();
                return call_user_func([$controllerInstance, $action]);
            }
        } else {
            http_response_code(404);
            return '404 - Page Not Found';
        }
    }

}
