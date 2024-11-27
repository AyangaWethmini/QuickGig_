<?php 

session_start();

// Include the app's core initialization
require "../app/core/init.php";

// Set error display based on DEBUG constant
DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

// Initialize and load the controller through the App class
$app = new App();
$app->loadController(); // This will handle the URL routing and actions
?>
