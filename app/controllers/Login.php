<?php

require_once APPROOT . '/core/Database.php'; // Include the Database trait

class Login extends Controller
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
    public function verify()
    {
        // Check if the form data exists
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $_SESSION['login_errors'] = [];

            // Validate inputs
            if (empty($email) || empty($password)) {
                $_SESSION['login_errors'][] = "Email and password are required.";
                header("Location: " . ROOT . "/home/login");
                exit;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['login_errors'][] = "Invalid Email Format.";
                header("Location: " . ROOT . "/home/login");
                return false;
            }

            $domain = substr(strrchr($email, "@"), 1);

            // Check if the domain has valid DNS records
            if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
                $_SESSION['login_errors'][] = "Invalid Email Format.";
                header("Location: " . ROOT . "/home/login");
                exit;
            }

            $user = $this->model->findByEmail($email);
            $userRole = $this->model->findRole($user['accountID']);


            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['accountID']; // Store user ID in the session
                $_SESSION['user_email'] = $user['email']; // Store user email in the session
                $_SESSION['user_role'] = $userRole['roleID']; 
                $_SESSION['user_logged_in'] = true; // Store user email in the session
                header("Location: " . ROOT . "/home");
                exit;
            }else {
                // Login failed
                $_SESSION['login_errors'][] = "Invalid email or password.";
                header("Location: " . ROOT . "/home/login");
                exit;
            }

        }
    }
    public function logout()
    {
        // Destroy session and redirect to login page
        session_start();
        session_unset();
        session_destroy();
        header("Location: " . ROOT . "/home/login");
        exit;
    }
}
