<?php


class App
{
    private $controller = 'Home';
    private $method     = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitURL();
		show($URL);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $URL[0] === 'signup' && $URL[1] === 'register') {
			require_once "../app/controllers/Signup.php";
			$signupController = new Signup();
			$signupController->register($_POST['email'], $_POST['password']);
			
		}

        /** select controller **/
        $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // If controller doesn't exist, load a 404 controller
            $filename = "../app/controllers/_404.php";
            require $filename;
            $this->controller = "_404";
        }

        $controller = new $this->controller;

        /** select method **/
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        // Call the method with the URL parameters
        call_user_func_array([$controller, $this->method], $URL);
    }

    private function handleSignupRegister()
    {
        require_once '../app/controllers/Signup.php';
        $controller = new Signup();
        $controller->register($_POST['email'], $_POST['password']);
        
        header("Location: " . ROOT . "/home"); // Redirect to home after registration
        exit; // Prevent further processing
    }
}
