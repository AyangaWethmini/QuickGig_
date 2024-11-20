<?php


class App
{
    private $controller = 'HomeController';
    private $method = 'index';

    public function __construct()
    {
        // Get the requested URI
        $this->processRoute();
    }

    private function processRoute()
    {
        global $routes; // Use routes defined in routes.php



        // Get the requested URI
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace('/QuickGig/public', '', $requestUri);
        if (array_key_exists($requestUri, $routes)) {

            $route = $routes[$requestUri];
            $this->controller = $route[0];
            $this->method = $route[1];
        } else {
            $this->controller = '_404';
            $this->method = 'index';
        }
    }
    
    public function loadController()
    {         
        $controllerFile = APPROOT . "/controllers/{$this->controller}.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerInstance = new $this->controller;

            if (method_exists($controllerInstance, $this->method)) {
                call_user_func([$controllerInstance, $this->method]);
            } else {

                echo "404 - Method {$this->method} not found!";
            }

        } else {

            echo "404 - Controller {$this->controller} not found!";
        }

    }

}
