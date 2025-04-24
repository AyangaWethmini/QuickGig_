<?php
date_default_timezone_set('Asia/Colombo');
class Organization extends Controller
{

    protected $viewPath = "../app/views/organization/";

    use Database;
    public function __construct()
    {
        $this->findEmpModel = $this->model('FindEmployees');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->accountModel = $this->model('Account');
        $this->reviewModel = $this->model('Review');

    }


    function index()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }

        // Get user data
        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getOrgData($userId);
        $rating = $this->reviewModel->readMyReview($userId, 1);
        $finalrate = 0;
        $length = 0;
        $data['ratings'] = $this->reviewModel->getRatingDistribution($userId, 1);
        $finalrate = 0;
        foreach ($rating as $rate) {
            $finalrate = $finalrate + $rate->rating;
            $length += 1;
        }
        $avgRate = 0;
        if ($finalrate != 0) {
            $avgRate = round((float)$finalrate / (float)$length, 1);
        } else {
            $avgRate = 0;
        }

        $this->view('organizationProfile', ['data' => $data, 'reviews' => $rating, 'avgRate' => $avgRate]);
    }

    function org_findEmployees()
    {
        $findEmployees = $this->findEmpModel->getEmployees();
        foreach ($findEmployees as &$employee) {
            $sumRate = 0;
            $avgRate = 0;

            $rating = $this->reviewModel->readMyReview($employee->accountID, 2);
            $length = count($rating);
            $userData = $this->accountModel->getUserData($employee->accountID);

            if (empty($userData)) {
                $userData = $this->accountModel->getOrgData($employee->accountID);
            }
            foreach ($rating as $rate) {
                $sumRate += $rate->rating;
            }

            if ($length > 0) {
                $avgRate = $sumRate / $length;
            }

            $employee->rating = $avgRate;
            $employee->badge = $userData['badge'];
        }
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

            if ($success) {
                echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
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
        foreach ($receivedRequests as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 2);
            $finalrate = 0;
            $length = 0;
            $finalrate = 0;
            foreach ($rating as $rate) {
                $finalrate = $finalrate + $rate->rating;
                $length += 1;
            }
            $avgRate = 0;
            if ($finalrate != 0) {
                $avgRate = round((float)$finalrate / (float)$length, 1);
            } else {
                $avgRate = 0;
            }
            $job->avgRate = $avgRate;
        }
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

    function org_viewEmployeeProfile($employeeID)
    {
        $account = $this->model('account');
        $role = $account->findrole($employeeID);
        $employeeData = null;
        if ($role['roleID'] == 2) {
            $employeeData = $account->getUserData($employeeID);
            $employeeData['name'] = $employeeData['fname'] . ' ' . $employeeData['lname'];
        } else if ($role['roleID'] == 3) {
            $employeeData = $account->getOrgData($employeeID);
            $employeeData['name'] = $employeeData['orgName'];
        }
        $rating = $this->reviewModel->readMyReview($employeeData['accountID'], 2);
        $finalrate = 0;
        $length = 0;
        $employeeData['ratings'] = $this->reviewModel->getRatingDistribution($employeeData['accountID'], 2);
        $finalrate = 0;
        foreach ($rating as $rate) {
            $finalrate = $finalrate + $rate->rating;
            $length += 1;
        }
        $avgRate = 0;
        if ($finalrate != 0) {
            $avgRate = round((float)$finalrate / (float)$length, 1);
        } else {
            $avgRate = 0;
        }
        $this->view('org_viewEmployeeProfile',['data' => $employeeData, 'reviews' => $rating, 'avgRate' => $avgRate]);
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
        $this->view('org_announcements');
    }

    function organizationEditProfile()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }

        // Get user data
        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getOrgData($userId);

        // Load the view and pass user data
        $this->view('organizationEditProfile', $data);
    }
    public function updateProfile()
    {
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

    function org_helpCenter()
    {
        $this->view('org_helpCenter');
    }
    function review($jobId)
    {
        $job = $this->model('job');
        $account = $this->model('Account');
        $reviewModel = $this->model('review');

        $accountID = $_SESSION['user_id'];
        $SeekerById = $job->getJobSeekerById($jobId);
        $revieweeData = $account->getUserData($SeekerById->seekerID);
        $review = $reviewModel->readReviewSpecific($accountID, $SeekerById->seekerID, $jobId, 2);
        $revieweeData['jobID'] = $jobId;

        if (!empty($review)) {
            $revieweeData['rating'] = $review->rating ?? NULL;
            $revieweeData['content'] = $review->content ?? '';
        }
        $this->view('review', $revieweeData);
    }

    function org_reviews()
    {
        $accountID = $_SESSION['user_id'];
        $review = $this->model('review');
        $data = $review->readReview($accountID, 2);
        $this->view('org_reviews',$data);
    }
    public function addReview($accountID)
    {

        $reviewerID = $_SESSION['user_id'];
        $revieweeID = $accountID;
        $reviewDate = $_POST['reviewDate'];
        $reviewTime = $_POST['reviewTime'];
        $content    = $_POST['review'];
        $rating     = $_POST['rating'];
        $jobID      = $_POST['jobID'];
        $roleID     = 2;

        $review = $this->model('review');
        $delete = $review->deleteReview($reviewerID, $revieweeID, $jobID, $roleID);
        $result = $review->submitReview($reviewerID, $revieweeID, $reviewDate, $reviewTime, $content, $rating, $roleID, $jobID);
        header('Location: ' . ROOT . '/organization/org_reviews');
    }
    public function deleteReview($reviewID)
    {
        $reviewModel = $this->model('Review');
        $review = $reviewModel->reviewById($reviewID);
        $delete = $reviewModel->deleteReview($review->reviewerID, $review->revieweeID, $review->jobID, 2);
        header('Location: ' . ROOT . '/organization/org_reviews');
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
        foreach ($sendRequests as $request) {
            $userId = $request->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 2);
            $finalrate = 0;
            $length = 0;
            $finalrate = 0;
            foreach ($rating as $rate) {
                $finalrate = $finalrate + $rate->rating;
                $length += 1;
            }
            $avgRate = 0;
            if ($finalrate != 0) {
                $avgRate = round((float)$finalrate / (float)$length, 1);
            } else {
                $avgRate = 0;
            }
            $request->avgRate = $avgRate;
        }
        $data = [
            'sendRequests' => $sendRequests
        ];

        $this->view('org_jobListing_send', $data);
    }

    public function deleteSendRequest()
    {
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

    function org_jobListing_toBeCompleted()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $tbcProvider = $this->model('ToBeCompletedProvider');
        $applyJobTBC = $tbcProvider->getApplyJobTBC();
        $reqAvailableTBC = $tbcProvider->getReqAvailableTBC();
        foreach ($applyJobTBC as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 2);
            $finalrate = 0;
            $length = 0;
            $finalrate = 0;
            foreach ($rating as $rate) {
                $finalrate = $finalrate + $rate->rating;
                $length += 1;
            }
            $avgRate = 0;
            if ($finalrate != 0) {
                $avgRate = round((float)$finalrate / (float)$length, 1);
            } else {
                $avgRate = 0;
            }
            $job->avgRate = $avgRate;
        }
        foreach ($reqAvailableTBC as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 2);
            $finalrate = 0;
            $length = 0;
            $finalrate = 0;
            foreach ($rating as $rate) {
                $finalrate = $finalrate + $rate->rating;
                $length += 1;
            }
            $avgRate = 0;
            if ($finalrate != 0) {
                $avgRate = round((float)$finalrate / (float)$length, 1);
            } else {
                $avgRate = 0;
            }
            $job->avgRate = $avgRate;
        }
        $data = [
            'applyJobTBC' => $applyJobTBC,
            'reqAvailableTBC' => $reqAvailableTBC
        ];
        $this->view('org_jobListing_toBeCompleted', $data);
    }

    function org_jobListing_ongoing()
    {
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

    function org_jobListing_completed()
    {
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
