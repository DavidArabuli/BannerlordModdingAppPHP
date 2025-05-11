<?php
require '../controllers/UnitController.php';

class Router
{
    protected $routes = [];

    public function addRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller,
        ];
    }
    public function get($uri, $controller)
    {
        return $this->addRoute("GET", $uri, $controller);
    }
    public function post($uri, $controller)
    {
        return $this->addRoute("POST", $uri, $controller);
    }
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['method'] === $method) {
                require '../controllers/' . $route['controller'];
                return;
            }
        }
        $this->abort();
    }
    public function abort()
    {
        http_response_code(404);
        require '../views/404.php';
        die();
    }
}
