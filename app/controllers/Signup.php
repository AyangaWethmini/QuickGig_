<?php

require_once APPROOT . '/core/Database.php'; // Include the Database trait

class Signup extends Controller
{
    use Database;  // Use the Database trait, don't instantiate it.

    private $model;

    public function __construct()
    {
        // Now you can use the methods from the Database trait, including connect()
        $db = $this->connect();  // Use the connect method from the trait
        $this->model = new Account($db);  // Pass the connection to the Account model
    }

    // Update register method to get data from the form submission (POST)
    public function register()
    {
        // Check if the form data exists
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                return false;
            }

            // Check if email is already registered
            if ($this->model->findByEmail($email)) {
                echo "Email is already registered.";
                return false;
            }

            // Validate password length
            if (strlen($password) < 6) {
                echo "Password must be at least 6 characters long.";
                return false;
            }

            // Hash the password 
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Generate a unique ID for the account
            $accountID = uniqid("ACC", true);

            // Set properties for the account
            $this->model->accountID = $accountID;
            $this->model->email = $email;
            $this->model->password = $hashedPassword;
            $this->model->planID = null; // Default to null or a default plan
            $this->model->district = null;
            $this->model->addressLine1 = null;
            $this->model->addressLine2 = null;
            $this->model->city = null;
            $this->model->accStatus = 'active';

            // Attempt to create the account
            if ($this->model->create()) {
                // Redirect to the homepage
                header("Location: " . ROOT . "/home");
                 exit; // Prevent further script execution after redirect
            } else {
                echo "Failed to create account.";
                return false;
            }
        }
    }
}
