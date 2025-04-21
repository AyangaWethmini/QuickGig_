<?php
date_default_timezone_set('Asia/Colombo');
    class Organization extends Controller {
        
        private $helpModel;
        protected $viewPath = "../app/views/organization/";

        use Database;
        public function __construct(){
            $this->findEmpModel = $this->model('FindEmployees');
            $this->jobStatusUpdater = $this->model('JobStatusUpdater');

            $this->adminModel = $this->model('AdminModel');
            $this->accountModel = $this->model('Account');

            $this->helpModel = $this->model('Help');
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



    function org_findEmployees()
    {
        $findEmployees = $this->findEmpModel->getEmployees();

        $data = [
            'findEmployees' => $findEmployees
        ];

        $this->view('org_findEmployees', $data);
    }

    public function requestJob()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jobModel = new FindEmployees();
            $providerID = $_SESSION['user_id'];
            $availableID = $_POST['jobID'];
            $reqID = uniqid('REQ_');

            $success = $jobModel->applyForJob($reqID, $providerID, $availableID);

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

        public function org_subscription() {
            $this->view('org_subscription');
        }

        function org_messages(){
            $this->view('org_messages');
        }

        function org_report(){
            $this->view('report');
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

        //help center functionalities 
    function org_helpCenter()
    {
        $data = $this->helpModel->getUserQuestions($_SESSION['user_id']);
        $this->view('org_helpCenter', ['questions' => $data]);
    }

    function submitQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $accountID = $_SESSION['user_id'];
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            // Ensure none of the fields are empty
            if (empty($title) || empty($description)) {
            $_SESSION['error'] = 'Title and description cannot be empty.';
            header('Location: ' . ROOT . '/jobProvider/helpCenter?error=empty_fields');
            exit;
            }

            $this->helpModel->createQuestion([
            'accountID' => $accountID,
            'title' => $title,
            'description' => $description
            ]);

            header('Location: ' . ROOT . '/jobProvider/helpCenter');
        }
    }

    function editQuestion($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            // Ensure none of the fields are empty
            if (empty($title) || empty($description)) {
            $_SESSION['error'] = 'Title and description cannot be empty.';
            header('Location: ' . ROOT . '/jobProvider/editQuestion/' . $id);
            exit;
            }

            $this->helpModel->update($id, [
            'title' => $title,
            'description' => $description
            ]);

            header('Location: ' . ROOT . '/jobProvider/helpCenter');
        } else {
            $question = $this->helpModel->getQuestionById($id);
            $data = [
            'question' => $question
            ];
            $this->view('editQuestion', $data);
        }
    }

    function deleteQuestion($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->helpModel->delete($id);
            header('Location: ' . ROOT . '/jobProvider/helpCenter');
        }
    }


    //help center done

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
                echo json_encode(["status" => "error", "message" => "You have already requested for this."]);
            }
        }
    }

    function org_postJob()
    {
        $this->view('org_postJob');
    }

    public function org_jobListing_received()
    {
        $received = $this->model('ReceivedProvider');
        $receivedRequests = $received->getReceivedRequests();

        $data = [
            'receivedRequests' => $receivedRequests
        ];

        $this->view('org_jobListing_received', $data);
    }

    public function rejectJobRequest()
    {
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

    public function acceptJobRequest()
    {
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

    function org_viewEmployeeProfile()
    {
        $this->view('org_viewEmployeeProfile');
    }

    function org_subscription()
    {
        $this->view('org_subscription');
    }

    function org_messages()
    {
        $this->view('org_messages');
    }

    function org_announcements()
    {
        // Set items per page
        $limit = 3;

        // Get current page from URL, default to 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate offset (start from 0 for first page)
        $start = ($page - 1) * $limit;

        // Get total announcements and paginated announcements
        $totalAnnouncements = $this->adminModel->getTotalAnnouncements();
        $announcements = $this->adminModel->getAnnouncementsPaginated($start, $limit);

        // Calculate total pages
        $totalPages = ceil($totalAnnouncements / $limit);

        // Ensure current page is within valid range
        if ($page > $totalPages && $totalPages > 0) {
            header('Location: ' . ROOT . '/admin/adminannouncement?page=1');
            exit;
        }

        // Debug information (temporarily uncomment to check values)
        // echo "Page: $page, Start: $start, Limit: $limit, Total: $totalAnnouncements<br>";
        // print_r($announcements);

        $data = [
            'announcements' => $announcements,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalAnnouncements' => $totalAnnouncements
        ];

        $this->view('org_announcements', $data);
    }

    function organizationEditProfile()
    {
        $this->view('organizationEditProfile');
    }

    function org_helpCenter()
    {
        $this->view('org_helpCenter');
    }

    function org_reviews()
    {
        $this->view('org_reviews');
    }

    public function org_jobListing_myJobs()
    {
        $userID = $_SESSION['user_id'];
        $jobModel = $this->model('Job');
        $jobs = $jobModel->getJobsByUser($userID);

        $data = [
            'jobs' => $jobs
        ];

        $this->view('org_jobListing_myJobs', $data);
    }

    function org_jobListing_send()
    {
        $send = $this->model('sendProvider');
        $sendRequests = $send->getsendRequests();

        $data = [
            'sendRequests' => $sendRequests
        ];

        $this->view('org_jobListing_send', $data);
    }

    function org_jobListing_toBeCompleted()
    {
        $this->view('org_jobListing_toBeCompleted');
    }

    function org_jobListing_ongoing()
    {
        $this->view('org_jobListing_ongoing');
    }

    function org_jobListing_completed()
    {
        $this->view('org_jobListing_completed');
    }

    function org_complaints()
    {
        $this->view('org_complaints');
    }

    function settings()
    {
        $this->view('settings');
    }

    public function job()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    public function updateJob($id = null)
    {
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

    public function deleteJob($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->jobModel = $this->model('Job');
            $this->jobModel->delete($id);
            header('Location: ' . ROOT . '/organization/org_jobListing_myJobs');
        }
    }
}
