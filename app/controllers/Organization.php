<?php
    class Organization extends Controller {
        protected $viewPath = "../app/views/organization/";

        private $accountModel;
        use Database;

        public function __construct(){
            $db = $this->connect();
            $this->accountModel = new Account($db);
            
        }
        
        function index(){
            // Ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                redirect('login'); // Redirect to login if not authenticated
            }
    
            // Get user data
            $userId = $_SESSION['user_id'];
            $data = $this->accountModel->getOrgData($userId);
            $this->view('organizationProfile',$data);
        }

        function org_findEmployees(){
            $this->view('org_findEmployees');
        }

        function org_postJob(){
            $this->view('org_postJob');
        }
        
        function org_jobListing_received(){
            $this->view('org_jobListing_received');
        }

        function org_viewEmployeeProfile(){
            $this->view('org_viewEmployeeProfile');
        }

        function org_subscription(){
            $this->view('org_subscription');
        }

        function org_messages(){
            $this->view('org_messages');
        }

        function org_announcements(){
            $this->view('org_announcements');
        }

        function organizationEditProfile(){
            // Ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                redirect('login'); // Redirect to login if not authenticated
            }
    
            // Get user data
            $userId = $_SESSION['user_id'];
            $data = $this->accountModel->getOrgData($userId);
    
            // Load the view and pass user data
            $this->view('organizationEditProfile',$data);
        }
        public function updateProfile() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userId = $_SESSION['user_id'];
        
                $data = [
                    'orgName' => trim($_POST['orgName']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'district' => trim($_POST['district']),
                    'addressLine1' => trim($_POST['addressLine1']),
                    'addressLine2' => trim($_POST['addressLine2']),
                    'city' => trim($_POST['city']),
                    'linkedIn' => trim($_POST['linkedIn']),
                    'facebook' => trim($_POST['facebook']),
                    'bio' => trim($_POST['bio']),
                    'pp' => null
                ];
                
        
                // Handle profile picture upload
                if (!empty($_FILES['pp']['tmp_name'])) {
                    $imageData = file_get_contents($_FILES['pp']['tmp_name']);
                    $data['pp'] = $imageData;
                    $_SESSION['pp'] = $imageData;
                }
                if ($this->accountModel->updateOrgData($userId, $data)) {
                    redirect('organization/organizationProfile'); // Reload page with updated data
                } else {
                    die("Something went wrong. Please try again.");
                }
            }
        }

        function org_helpCenter(){
            $this->view('org_helpCenter');
        }

        function org_reviews(){
            $this->view('org_reviews');
        }

        function org_jobListing_myJobs(){
            $this->view('org_jobListing_myJobs');
        }

        function org_jobListing_send(){
            $this->view('org_jobListing_send');
        }

        function org_jobListing_toBeCompleted(){
            $this->view('org_jobListing_toBeCompleted');
        }

        function org_jobListing_ongoing(){
            $this->view('org_jobListing_ongoing');
        }

        function org_jobListing_completed(){
            $this->view('org_jobListing_completed');
        }

        function org_complaints(){
            $this->view('org_complaints');
        }

        function settings(){
            $this->view('settings');
        }

    }