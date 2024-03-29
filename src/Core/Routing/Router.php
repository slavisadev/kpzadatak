<?php

namespace KPZadatak\Core\Routing;

class Router
{
    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * @param $route
     * @param $method
     * @param $action
     *
     * @return void
     */
    public function add($route, $method, $action): void
    {
        $this->routes[] = ['route' => $route, 'method' => $method, 'action' => $action];
    }

    /**
     * @param $uri
     * @param $requestMethod
     *
     * @return void
     */
    public function dispatch($uri, $requestMethod)
    {
        foreach ($this->routes as $route) {
            if ($route['route'] === $uri && $route['method'] === $requestMethod) {
                [$controller, $method] = explode('@', $route['action']);
                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = new $controller();
                    return $controllerInstance->$method();
                }
            }
        }

        // Handle not found
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit;
    }
}
