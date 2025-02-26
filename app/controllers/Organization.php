<?php
date_default_timezone_set('Asia/Colombo');
    class Organization extends Controller {

        public function __construct(){
            $this->findEmpModel = $this->model('FindEmployees');
            $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        }

        protected $viewPath = "../app/views/organization/";
        
        function index(){
            $this->view('organizationProfile');
        }

        function org_findEmployees(){
            $findEmployees = $this->findEmpModel->getEmployees();

            $data = [
                'findEmployees' => $findEmployees
            ];

            $this->view('org_findEmployees', $data);
        }

        public function requestJob() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $jobModel = new FindEmployees();
                $providerID = $_SESSION['user_id']; 
                $availableID = $_POST['jobID'];
                $reqID = uniqid('REQ_');
        
                $success = $jobModel->applyForJob($reqID, $providerID, $availableID);
        
                if ($success) {
                    echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "You have already requested for this."]);
                }
            }
        }    

        function org_postJob(){
            $this->view('org_postJob');
        }
        
        public function org_jobListing_received(){
            $received = $this->model('ReceivedProvider');
            $receivedRequests = $received->getReceivedRequests();

            $data = [
                'receivedRequests' => $receivedRequests
            ];

            $this->view('org_jobListing_received', $data);
        }

        public function rejectJobRequest() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $applicationID = $_POST['applicationID'];
                $receivedProviderModel = $this->model('ReceivedProvider');
                $success = $receivedProviderModel->rejectRequest($applicationID);
        
                if ($success) {
                    header('Location: ' . ROOT . '/organization/org_jobListing_received');
                } else {
                    echo "Failed to reject the request.";
                }
            }
        }

        public function acceptJobRequest() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $applicationID = $_POST['applicationID'];
                $receivedProviderModel = $this->model('ReceivedProvider');
                $success = $receivedProviderModel->acceptRequest($applicationID);
        
                if ($success) {
                    // Get the jobID from the application
                    $application = $receivedProviderModel->getApplicationByID($applicationID);
                    $jobID = $application->jobID;
        
                    // Count the number of accepted applications for the job
                    $acceptedCount = $receivedProviderModel->countAcceptedApplications($jobID);
        
                    // Get the number of applicants allowed for the job
                    $jobModel = $this->model('Job');
                    $job = $jobModel->getJobById($jobID);
                    $noOfApplicants = $job->noOfApplicants;
        
                    // If the number of accepted applications equals the number of applicants, update the job status
                    if ($acceptedCount >= $noOfApplicants) {
                        $receivedProviderModel->updateJobStatus($jobID, 2);
                    }
        
                    header('Location: ' . ROOT . '/organization/org_jobListing_received');
                } else {
                    echo "Failed to accept the request.";
                }
            }
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
            $this->view('organizationEditProfile');
        }

        function org_helpCenter(){
            $this->view('org_helpCenter');
        }

        function org_reviews(){
            $this->view('org_reviews');
        }

        public function org_jobListing_myJobs(){
            $userID = $_SESSION['user_id'];
            $jobModel = $this->model('Job'); 
            $jobs = $jobModel->getJobsByUser($userID);
        
            $data = [
                'jobs' => $jobs
            ];
        
            $this->view('org_jobListing_myJobs', $data);
        }

        function org_jobListing_send(){
            $send = $this->model('sendProvider');
            $sendRequests = $send->getsendRequests();

            $data = [
                'sendRequests' => $sendRequests
            ];

            $this->view('org_jobListing_send', $data);
        }

        public function deleteSendRequest() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $reqID = $data['reqID'];
                $sendProviderModel = $this->model('SendProvider');
                $success = $sendProviderModel->deleteSendRequest($reqID);
        
                if ($success) {
                    echo json_encode(["status" => "success"]);
                } else {
                    echo json_encode(["status" => "error"]);
                }
            }
        }

        function org_jobListing_toBeCompleted(){
            $this->jobStatusUpdater->updateJobStatuses();
            $tbcProvider = $this->model('ToBeCompletedProvider');
            $applyJobTBC = $tbcProvider->getApplyJobTBC();
            $reqAvailableTBC = $tbcProvider->getReqAvailableTBC();
            $data = [
                'applyJobTBC' => $applyJobTBC,
                'reqAvailableTBC' => $reqAvailableTBC
            ];
            $this->view('org_jobListing_toBeCompleted', $data);
        }

        function org_jobListing_ongoing(){
            $this->jobStatusUpdater->updateJobStatuses();
            $ongoingProvider = $this->model('OngoingProvider');
            $applyJobOngoing = $ongoingProvider->getApplyJobOngoing();
            $reqAvailableOngoing = $ongoingProvider->getReqAvailableOngoing();
            $data = [
                'applyJobOngoing' => $applyJobOngoing,
                'reqAvailableOngoing' => $reqAvailableOngoing
            ];
            $this->view('org_jobListing_ongoing', $data);
        }

        function org_jobListing_completed(){
            $this->jobStatusUpdater->updateJobStatuses();
            $completedProvider = $this->model('CompletedProvider');
            $applyJobCompleted = $completedProvider->getApplyJobCompleted();
            $reqAvailableCompleted = $completedProvider->getReqAvailableCompleted();
            $data = [
                'applyJobCompleted' => $applyJobCompleted,
                'reqAvailableCompleted' => $reqAvailableCompleted
            ];
            $this->view('org_jobListing_completed', $data);
        }

        function org_complaints(){
            $this->view('org_complaints');
        }

        function settings(){
            $this->view('settings');
        }

        public function job(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $jobID = uniqid();

                $accountID = $_SESSION['user_id'];

                $description = trim($_POST['description']);
                $location = trim($_POST['location']);
                $timeFrom = trim($_POST['timeFrom']);
                $timeTo = trim($_POST['timeTo']);
                $availableDate = trim($_POST['availableDate']);
                $shift = trim($_POST['shift']);
                $salary = trim($_POST['salary']);
                $currency = trim($_POST['currency']);
                $jobTitle = trim($_POST['jobTitle']);
                $jobStatus = 1;
                $noOfApplicants = trim($_POST['noOfApplicants']);
                $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

                $jobModel = $this->model('Job');
                $isPosted = $jobModel->create([
                    'jobID' => $jobID,
                    'accountID' => $accountID,
                    'description' => $description,
                    'timeFrom' => $timeFrom,
                    'timeTo' => $timeTo,
                    'location' => $location,
                    'availableDate' => $availableDate,
                    'shift' => $shift,
                    'salary' => $salary,
                    'currency' => $currency,
                    'jobTitle' => $jobTitle,
                    'jobStatus' => $jobStatus,
                    'noOfApplicants' => $noOfApplicants,
                    'categories' => json_encode($categories)
                ]);

                // Redirect or handle based on success or failure
                if ($isPosted) {
                    header('Location: ' . ROOT . '/organization/org_jobListing_myJobs'); // Replace with the appropriate success page
                    exit();
                } else {
                    // Handle errors (e.g., log them or show an error message)
                    echo "Failed to post job. Please try again.";
                }
            }
        }

        public function updateJob($id = null) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
                // Prepare data for updating
                $description = trim($_POST['description']);
                $shift = $_POST['shift'];
                $salary = trim($_POST['salary']);
                $currency = $_POST['currency'];
                $timeFrom = $_POST['timeFrom'];
                $timeTo = $_POST['timeTo'];
                $availableDate = $_POST['availableDate'];
                $location = trim($_POST['location']);
                $jobTitle = trim($_POST['jobTitle']);
                $jobStatus = 1;
                $noOfApplicants = trim($_POST['noOfApplicants']);
                $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
        
                // Update availability in the database
                $this->jobModel = $this->model('Job');
                $this->jobModel->update($id, [
                    'description' => $description,
                    'shift' => $shift,
                    'salary' => $salary,
                    'currency' => $currency,
                    'timeFrom' => $timeFrom,
                    'timeTo' => $timeTo,
                    'availableDate' => $availableDate,
                    'location' => $location,
                    'jobTitle' => $jobTitle,
                    'jobStatus' => $jobStatus,
                    'noOfApplicants' => $noOfApplicants,
                    'categories' => json_encode($categories)
                ]);
        
                // Redirect to the availability page or another appropriate page
                header('Location: ' . ROOT . '/organization/org_jobListing_myJobs');
            } else {
                // Get the current availability details for the given ID
                $this->jobModel = $this->model('Job');
                $job = $this->jobModel->getJobById($id);
        
                // Pass the current availability data to the view
                $data = [
                    'job' => $job
                ];
        
                // Load the update form view
                $this->view('updateJob', $data);
            }
        }

        public function deleteJob($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->jobModel = $this->model('Job');
                $this->jobModel->delete($id);
                header('Location: ' . ROOT . '/organization/org_jobListing_myJobs');
            }
        }
    }