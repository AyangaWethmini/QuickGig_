<?php

session_start();

// Load initialization file
require "../app/core/init.php";

// Enable or disable debugging based on the DEBUG constant
DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

// Load the routes file
require_once '../app/Routes/routes.php';

// Create an instance of the App class and load the controller
$app = new App();
$app->loadController();
// Get the requested URL (from the .htaccess rewrite rule)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip "/QuickGig/public" from the URL
$requestUri = str_replace("/QuickGig/public", "", $requestUri);

// Check if the route exists in the $routes array
if (array_key_exists($requestUri, $routes)) {
    // Get the controller and method for the route
    $route = $routes[$requestUri];
    // Ensure the route array has both controller and method
    if (count($route) == 2) {
        // Call the corresponding controller and method
        $controllerName = $route[0];
        $methodName = $route[1];
        
        // Instantiate the controller
        $controller = new $controllerName();
        
        // Call the method
        $controller->$methodName();
    } else {
        http_response_code(404);
        echo "Invalid route format.";
    }
} else {
    // If no route is found, return a 404 error
    http_response_code(404);
    echo "404 Not Found: The requested URL $requestUri was not found on this server.";
}
