<?php

class App
{
    private $controller = 'Home';
    private $method = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function loadController()
{
    $URL = $this->splitURL();

    // Handle POST request routes first
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->handlePostRequest($URL);
    }

    /** Select controller **/
    $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
    if (file_exists($filename)) {
        require $filename;
        $this->controller = ucfirst($URL[0]);
        unset($URL[0]);
    } else {
        // Load a 404 controller if the controller doesn't exist
        $filename = "../app/controllers/_404.php";
        require $filename;
        $this->controller = "_404";
    }

    $controller = new $this->controller;

    /** Select method **/
    if (!empty($URL[1]) && method_exists($controller, $URL[1])) {
        $this->method = $URL[1];
        unset($URL[1]);
    } else {
        // Default to 'index' if no method is provided
        $this->method = 'index';
    }

    // Call the method with the URL parameters
    call_user_func_array([$controller, $this->method], $URL);
}


    private function handlePostRequest($URL)
    {
        if ($URL[0] === 'signup' && $URL[1] === 'register') {
            require_once "../app/controllers/Signup.php";
            $signupController = new Signup();
            $signupController->register($_POST['email'], $_POST['password']);
            // Redirect after successful registration
            // header("Location: " . ROOT . "/home/login"); 
            exit;
        }

        if ($URL[0] === 'login' && $URL[1] === 'verify') {
            require_once "../app/controllers/Login.php";
            $loginController = new Login();
            $loginController->verify($_POST['email'], $_POST['password']);
            // Redirect after successful login
            header("Location: " . ROOT . "/home");
            exit;
        }

        // Add more POST route handlers if needed
    }
}
