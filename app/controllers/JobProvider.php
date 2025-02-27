<?php
    class JobProvider extends Controller {
        private $accountModel;
        use Database;  // Use the Database trait, don't instantiate it.

        public function __construct(){
            $this->complaintModel = $this->model('Complaint');
            $db = $this->connect();
            $this->accountModel = new Account($db);
            
        }
        

        protected $viewPath = "../app/views/jobProvider/";
        
        function index(){
            // Ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                redirect('login'); // Redirect to login if not authenticated
            }
    
            // Get user data
            $userId = $_SESSION['user_id'];
            $data = $this->accountModel->getUserData($userId);
            $this->view('individualProfile',$data);
        }

        function findEmployees(){
            $this->view('findEmployees');
        }

        function postJob(){
            $this->view('postJob');
        }
        
        function jobListing_received(){
            $this->view('jobListing_received');
        }

        function viewEmployeeProfile(){
            $this->view('viewEmployeeProfile');
        }

        function subscription(){
            $this->view('subscription');
        }

        function messages(){
            $this->view('messages');
        }

        function announcements(){
            $this->view('announcements');
        }

        public function individualEditProfile() {
            // Ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                redirect('login'); // Redirect to login if not authenticated
            }
    
            // Get user data
            $userId = $_SESSION['user_id'];
            $data = $this->accountModel->getUserData($userId);
    
            // Load the view and pass user data
            $this->view('individualEditProfile', $data);
        }
        public function updateProfile() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userId = $_SESSION['user_id'];
        
                $data = [
                    'fname' => trim($_POST['fname']),
                    'lname' => trim($_POST['lname']),
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
                if ($this->accountModel->updateUserData($userId, $data)) {
                    redirect('JobProvider/individualProfile'); // Reload page with updated data
                } else {
                    die("Something went wrong. Please try again.");
                }
            }
        }
        

        function helpCenter(){
            $this->view('helpCenter');
        }

        function reviews(){
            $this->view('reviews');
        }

        function jobListing_myJobs(){
            $this->view('jobListing_myJobs');
        }

        function jobListing_send(){
            $this->view('jobListing_send');
        }

        function jobListing_toBeCompleted(){
            $this->view('jobListing_toBeCompleted');
        }

        function jobListing_ongoing(){
            $this->view('jobListing_ongoing');
        }

        function jobListing_completed(){
            $this->view('jobListing_completed');
        }

        function makeComplaint(){
            $this->view('makeComplaint');
        }

        function submitComplaint(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $complainantID = $_SESSION['user_id'];
                $content = trim($_POST['complainInfo']);
                $complaintDate = date('Y-m-d');
                $complaintTime = date('h:i A');
                $complaintStatus = 1;
    
                $complaintModel = $this->model('Complaint');
                $complaintModel->create([
                    'complainantID' => $complainantID,
                    'content' => $content,
                    'complaintDate' => $complaintDate,
                    'complaintTime' => $complaintTime,
                    'complaintStatus' => $complaintStatus
                ]);
    
                header('Location: ' . ROOT . '/jobProvider/jobListing_completed');
            }
        }



        function complaints(){
            $complaints = $this->complaintModel->getComplaints();

            $data = [
                'complaints' => $complaints
            ];

            $this->view('complaints', $data); 
            
        }

        public function deleteComplaint($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->complaintModel->delete($id);
                header('Location: ' . ROOT . '/jobProvider/complaints');
            }
        }

        public function updateComplaint($id = null) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $content = trim($_POST['complainInfo']);
                $complaintDate = date('Y-m-d');
                $complaintTime = date('h:i A');
        
                $this->complaintModel->update($id, [
                    'content' => $content,
                    'complaintDate' => $complaintDate,
                    'complaintTime' => $complaintTime
                ]);
        
                header('Location: ' . ROOT . '/jobProvider/complaints');
            } else {
                $complaint = $this->complaintModel->getComplaintById($id);
        
                $data = [
                    'complaint' => $complaint
                ];
        
                $this->view('updateComplaint', $data);
            }
        }

        function settings(){
            $this->view('settings');
        }
    }