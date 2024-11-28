<?php
    class Seeker extends Controller {

        protected $viewPath = "../app/views/seeker/";
        
        function index(){
            $this->view('seekerProfile');
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

        function individualEditProfile(){
            $this->view('individualEditProfile');
        }

        function helpCenter(){
            $this->view('helpCenter');
        }

        function reviews(){
            $this->view('reviews');
        }

        function jobListing_myJobs(){
            $jobModel = $this->model('Available'); // Assuming 'Available' is the model
            $userID = $_SESSION['user_id']; // Assuming the user is logged in and their ID is stored in the session

            // Fetch jobs posted by the user
            $jobs = $jobModel->getJobsByUser($userID);
            $_SESSION['availabilities'] =  $jobs;
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

        function complaints(){
            $this->view('complaints');
        }

        function settings(){
            $this->view('settings');
        }
        public function availability() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $availableID = uniqid();
    
                $accountID = $_SESSION['user_id'];
    
                $description = trim($_POST['description']);
                $location = trim($_POST['location']);
                $timeFrom = trim($_POST['timeFrom']);
                $timeTo = trim($_POST['timeTo']);
                $availableDate = trim($_POST['availableDate']);
                $shift = trim($_POST['shift']);
                $salary = trim($_POST['salary']);
                $currency = trim($_POST['currency']);
        
                $makeAvailableModel = $this->model('Available'); 
                $isPosted = $makeAvailableModel->create([
                    'availableID' => $availableID,
                    'accountID' => $accountID,
                    'description' => $description,
                    'timeFrom' => $timeFrom,
                    'timeTo' => $timeTo,
                    'location' => $location,
                    'availableDate' => $availableDate,
                    'shift' => $shift,
                    'salary' => $salary,
                    'currency' => $currency
                ]);
        
                // Redirect or handle based on success or failure
                if ($isPosted) {
                    header('Location: ' . ROOT . '/seeker/jobListing_myJobs'); // Replace with the appropriate success page
                    exit();
                } else {
                    // Handle errors (e.g., log them or show an error message)
                    echo "Failed to post availability. Please try again.";
                }
            }
        }
 
    }
    
    