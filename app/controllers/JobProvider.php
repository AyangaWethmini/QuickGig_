<?php
class JobProvider extends Controller
{
    public function __construct()
    {
        $this->complaintModel = $this->model('Complaint');
        $this->findEmpModel = $this->model('FindEmployees');
        $this->accountModel = $this->model('Account');
        $this->adminModel = $this->model('AdminModel');
    }
    protected $viewPath = "../app/views/jobProvider/";

    function index()
    {

        $this->view('individualProfile');
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oldPassword = trim($_POST['oldpw']);
            $newPassword = trim($_POST['newpw']);
            $reNewPassword = trim($_POST['renewpw']);
            $accountID = $_SESSION['user_id']; // Assuming user ID is stored in session

            // Validate if new passwords match
            if ($newPassword !== $reNewPassword) {
                // flash('password_message', 'New passwords do not match!', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }

            // Fetch the current password from the database
            $currentUser = $this->accountModel->getUserByID($accountID);

            if (!password_verify($oldPassword, $currentUser->password)) {
                // flash('password_message', 'Old password is incorrect!', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in the database
            if ($this->accountModel->changePassword($accountID, $hashedPassword)) {
                // flash('password_message', 'Password updated successfully!', 'alert-success');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            } else {
                // flash('password_message', 'Something went wrong, please try again.', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }
        } else {
            header('Location: ' . ROOT . '/jobProvider/settings');
            exit;
        }
    }

    function findEmployees()
    {
        $findEmployees = $this->findEmpModel->getEmployees();
        $data = [
            'findEmployees' => $findEmployees
        ];
        $this->view('findEmployees', $data);
    }
    public function requestJob()
    {
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
    function postJob()
    {
        $this->view('postJob');
    }

    public function jobListing_received()
    {
        $received = $this->model('ReceivedProvider');
        $receivedRequests = $received->getReceivedRequests();
        $data = [
            'receivedRequests' => $receivedRequests
        ];
        $this->view('jobListing_received', $data);
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

                header('Location: ' . ROOT . '/jobprovider/jobListing_received');
            } else {
                echo "Failed to accept the request.";
            }
        }
    }
    public function rejectJobRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $applicationID = $_POST['applicationID'];
            $receivedProviderModel = $this->model('ReceivedProvider');
            $success = $receivedProviderModel->rejectRequest($applicationID);

            if ($success) {
                header('Location: ' . ROOT . '/jobprovider/jobListing_received');
            } else {
                echo "Failed to reject the request.";
            }
        }
    }
    function viewEmployeeProfile()
    {
        $this->view('viewEmployeeProfile');
    }
    function subscription()
    {
        $this->view('subscription');
    }
    function messages()
    {
        $this->view('messages');
    }
    function announcements()
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

        $this->view('announcements', $data);
    }
    function individualEditProfile()
    {
        $this->view('individualEditProfile');
    }
    function helpCenter()
    {
        $this->view('helpCenter');
    }
    function reviews()
    {
        $this->view('reviews');
    }
    public function jobListing_myJobs()
    {
        $userID = $_SESSION['user_id'];
        $jobModel = $this->model('Job');
        $jobs = $jobModel->getJobsByUser($userID);

        $data = [
            'jobs' => $jobs
        ];

        $this->view('jobListing_myJobs', $data);
    }
    function jobListing_send()
    {
        $send = $this->model('sendProvider');
        $sendRequests = $send->getsendRequests();
        $data = [
            'sendRequests' => $sendRequests
        ];
        $this->view('jobListing_send', $data);
    }
    function jobListing_toBeCompleted()
    {
        $this->view('jobListing_toBeCompleted');
    }
    function jobListing_ongoing()
    {
        $this->view('jobListing_ongoing');
    }
    function jobListing_completed()
    {
        $this->view('jobListing_completed');
    }
    function makeComplaint()
    {
        $this->view('makeComplaint');
    }
    function submitComplaint()
    {
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
    function complaints()
    {
        $complaints = $this->complaintModel->getComplaints();
        $data = [
            'complaints' => $complaints
        ];
        $this->view('complaints', $data);
    }
    public function deleteComplaint($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->complaintModel->delete($id);
            header('Location: ' . ROOT . '/jobProvider/complaints');
        }
    }
    public function updateComplaint($id = null)
    {
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
                header('Location: ' . ROOT . '/jobProvider/jobListing_myJobs'); // Replace with the appropriate success page
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
            header('Location: ' . ROOT . '/jobProvider/jobListing_myJobs');
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
            header('Location: ' . ROOT . '/jobProvider/jobListing_myJobs');
        }
    }
}
