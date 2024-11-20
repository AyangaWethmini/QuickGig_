<?php 

spl_autoload_register(function($classname) {
    // Check if the class is a model (ends with "Model")
    if (strpos($classname, 'Controller') !== false) {
        // Load the controller from the controllers directory
        $filename = "../app/controllers/" . ucfirst($classname) . ".php";
    } else {
        // Otherwise, assume it's a model and load from the models directory
        $filename = "../app/models/" . ucfirst($classname) . ".php";
    }

    // Require the file if it exists
    if (file_exists($filename)) {
        require_once $filename;
    } else {
        echo "Class file not found: " . $filename;
    }
});

define('BASEURL', '/QuickGig/public'); // Adjust this according to your project folder structure


// Required system files
require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
