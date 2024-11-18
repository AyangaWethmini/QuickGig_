<?php

class HomeController
{
    public function index()
    {
        $this->loadView('home/home.view');
    }

    public function login()
    {      

        $this->loadView('home/login.view');
    }
    public function signup()
    {      

        $this->loadView('home/signup.view');
    }

    private function loadView($viewPath, $data = [])
{
    $file = APPROOT . "/views/$viewPath.php";

    if (file_exists($file)) {
        extract($data); // Pass variables to the view
        require_once $file;
    } else {
        echo "View file not found: $file<br>";
    }
}
}

