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
            $confirmPassword = trim($_POST['confirm-password']);

            $_SESSION['signup_errors'] = [];

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['signup_errors'][] = "Invalid Email Format.";
                header("Location: " . ROOT . "/home/signup");
                return false;
            }
            $domain = substr(strrchr($email, "@"), 1);

            // Check if the domain has valid DNS records
            if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
                $_SESSION['signup_errors'][] = "Invalid Email Format.";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }

            $domain = substr(strrchr($email, "@"), 1);

            // Check if the domain has valid DNS records
            if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
                $_SESSION['signup_errors'][] = "Invalid Email Format.";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }

            // Check if email is already registered
            if ($this->model->findByEmail($email)) {
                $_SESSION['signup_errors'][] = "User Exists";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }

            // Validate password length
            if (strlen($password) < 6) {
                $_SESSION['signup_errors'][] = "Password length must be exceeding 6";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }
            if ($password != $confirmPassword) {
                $_SESSION['signup_errors'][] = "Confirm Password doesnt match";
                header("Location: " . ROOT . "/home/signup");
                exit;
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
                $_SESSION['accountID'] = $accountID;
                header("Location: " . ROOT . "/home/nextSign");
                exit; // Prevent further script execution after redirect
            } else {
                $_SESSION['signup_errors'][] = "Something went Wrong!";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }
        }
    }
    public function registerMore()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $accountID = isset($_SESSION['accountID']) ? $_SESSION['accountID'] : null;

            if (!$accountID) {
                $_SESSION['signup_errors'][] = "Session expired. Please complete the signup process again.";
                header("Location: " . ROOT . "/home/signup");
                exit;
            }

            $userType = trim($_POST['userType']);

            if ($userType === 'individual') {
                // Process individual user data
                $firstName = trim($_POST['fname']);
                $lastName = trim($_POST['lname']);
                $nic = trim($_POST['nic']);
                $gender = trim($_POST['gender']);
                $phoneDig = trim($_POST['Phone']);
                $code = trim($_POST['countryCode']);

                if (empty($firstName) || empty($lastName) || empty($nic) || empty($gender) || empty($phoneDig) || empty($code)) {
                    $_SESSION['signup_errors'][] = "Please fill all the fields";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }
                if ($this->model->findByNIC($nic)) {
                    $_SESSION['signup_errors'][] = "NIC Already in Used";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }
                $firstName = ucwords(strtolower($firstName));
                $lastName = ucwords(strtolower($lastName));
                $phone = $code . ' ' . $phoneDig;
                $pattern = '/^\+?\d{1,4}[\s\-]?\(?\d{1,4}\)?[\s\-]?\d{3,4}[\s\-]?\d{3,4}$/';

                if (!preg_match($pattern, $phone)) {
                    $_SESSION['signup_errors'][] = "Invalid phone number format.";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }


                $individualData = [
                    'accountID' => $accountID,
                    'fname' => $firstName,
                    'lname' => $lastName,
                    'nic' => $nic,
                    'gender' => $gender,
                    'Phone' => $phone
                ];

                if ($this->model->createIndividual($individualData)) {
                    header("Location: " . ROOT . "/home/login");
                    exit;
                } else {
                    $_SESSION['signup_errors'][] = "Something went Wrong!";
                    header("Location: " . ROOT . "/home/signup");
                }
            } elseif ($userType === 'organization') {
                // Process organization user data
                $orgName = trim($_POST['orgName']);
                $BRN = trim($_POST['brn']);
                $phoneDig = trim($_POST['Phone2']);
                $code = trim($_POST['countryCode2']);

                if (empty($orgName) || empty($BRN)) {
                    $_SESSION['signup_errors'][] = "Please fill all the fields";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }
                if ($this->model->findByBRN($BRN)) {
                    $_SESSION['signup_errors'][] = "BRN already in used";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }
                $orgName = ucwords($orgName);
                $phone = $code . ' ' . $phoneDig;
                $pattern = '/^\+?\d{1,4}[\s\-]?\(?\d{1,4}\)?[\s\-]?\d{3,4}[\s\-]?\d{3,4}$/';

                if (!preg_match($pattern, $phone)) {
                    $_SESSION['signup_errors'][] = "Invalid phone number format.";
                    header("Location: " . ROOT . "/home/nextSign");
                    exit;
                }

                $organizationData = [
                    'accountID' => $accountID,
                    'orgName' => $orgName,
                    'brn' => $BRN,
                    'Phone' => $phone
                ];

                if ($this->model->createOrganization($organizationData)) {
                    header("Location: " . ROOT . "/home/login");
                    exit;
                } else {
                    $_SESSION['signup_errors'][] = "Something went Wrong!";
                    header("Location: " . ROOT . "/home/signup");
                }
            } else {
                $_SESSION['signup_errors'][] = "Something went Wrong!";
                header("Location: " . ROOT . "/home/signup");
            }
        }
    }
}
