<?php
date_default_timezone_set('Asia/Colombo');

class JobProvider extends Controller
{

    private $helpModel;
    private $managerModel;
    private $accountSubscriptionModel;
    private $userReportModel;
    private $seekerDoneModel;
    private $providerDoneModel;

    public function __construct()
    {
        $this->complaintModel = $this->model('Complaint');
        $this->findEmpModel = $this->model('FindEmployees');
        $this->accountModel = $this->model('Account');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->adminModel = $this->model('AdminModel');
        $this->helpModel = $this->model('Help');
        $this->managerModel = $this->model('ManagerModel');
        $this->accountSubscriptionModel = $this->model('AccountSubscription');
        $this->userReportModel = $this->model('userReport');
        $this->userModel = $this->model('User');
        $this->reviewModel = $this->model('Review');
        $this->seekerDoneModel = $this->model('SeekerDone');
        $this->providerDoneModel = $this->model('ProviderDone');
    }
    protected $viewPath = "../app/views/jobProvider/";

    function index()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }
        $_SESSION['current_role'] = 1;
        // Get user data
        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getUserData($userId);
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

        $this->view('individualProfile', ['data' => $data, 'reviews' => $rating, 'avgRate' => $avgRate]);
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = ['success' => false, 'errors' => []];
            $oldPassword = trim($_POST['oldpw']);
            $newPassword = trim($_POST['newpw']);
            $reNewPassword = trim($_POST['renewpw']);
            $accountID = $_SESSION['user_id'];

            if ($newPassword !== $reNewPassword) {
                $response['errors']['newPassword'] = 'New passwords do not match!';
                echo json_encode($response);
                exit;
            }

            $currentUser = $this->accountModel->getUserByID($accountID);

            if (!password_verify($oldPassword, $currentUser->password)) {
                $response['errors']['oldPassword'] = 'Old password is incorrect!';
                echo json_encode($response);
                exit;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            if ($this->accountModel->changePassword($accountID, $hashedPassword)) {
                $response['success'] = true;
            } else {
                $response['errors']['general'] = 'Something went wrong, please try again.';
            }

            echo json_encode($response);
            exit;
        }
    }
    public function individualEditProfile()
    {
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
    public function updateProfile()
    {
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

    function findEmployees()
{
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $shift = isset($_GET['shift']) ? trim($_GET['shift']) : 'any';
    $date = isset($_GET['date']) ? trim($_GET['date']) : '';
    $location = isset($_GET['location']) ? trim($_GET['location']) : '';

    if (!empty($searchTerm) || $shift !== 'any' || !empty($date) || !empty($location)) {
        $findEmployees = $this->findEmpModel->filterEmployees($searchTerm, $shift, $date, $location);
    } else {
        $findEmployees = $this->findEmpModel->getEmployees();
    }

    foreach ($findEmployees as &$employee) {
        $sumRate = 0;
        $avgRate = 0;

        $rating = $this->reviewModel->readMyReview($employee->accountID, 2); // roleID = 2
        $userData = $this->accountModel->getUserData($employee->accountID);

        if (empty($userData)) {
            $userData = $this->accountModel->getOrgData($employee->accountID);
        }

        $length = count($rating);
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

    public function postJob()
    {
        $accountID = $_SESSION['user_id'];

        // Fetch the counter and postLimit from the database
        $accountData = $this->accountModel->getAccountData($accountID); // Add this method in the Account model
        $counter = $accountData->counter;
        $postLimit = $accountData->postLimit;

        // Check if the counter exceeds the postLimit
        if ($counter >= $postLimit) {
            // Set a session variable to show the popup message
            $_SESSION['postLimitExceeded'] = true;

            // Redirect back to the job listing page
            header('Location: ' . ROOT . '/jobProvider/jobListing_myJobs');
            exit();
        }

        // Load the post job view if the limit is not exceeded
        $this->view('postJob');
    }

    function jobListing_received()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';
        $receivedModel = $this->model('ReceivedProvider');

        if (!empty($filterDate)) {
            $receivedRequests = $receivedModel->filterReceivedRequestsByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $receivedRequests = $receivedModel->searchReceivedRequests($userID, $searchTerm);
        } else {
            $receivedRequests = $receivedModel->getReceivedRequests();
        }

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

    function viewEmployeeProfile($employeeID)
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

        // Pass data as associative array to the view
        $this->view('viewEmployeeProfile', ['data' => $employeeData, 'reviews' => $rating, 'avgRate' => $avgRate]);
    }

    function subscription()
    {
        $subsDetails = $this->accountSubscriptionModel->getUserSubscriptionDetails($_SESSION['user_id']);
        $this->view('subscription', ['subscription' => $subsDetails]);
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

    //help center functionalities 
    function helpCenter()
    {
        $data = $this->helpModel->getUserQuestions($_SESSION['user_id']);
        $this->view('helpCenter', ['questions' => $data]);
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

            $helpID = uniqid("HLP", true);

            $this->helpModel->createQuestion([
                'helpID' => $helpID,
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

    function reviews()
    {
        $accountID = $_SESSION['user_id'];
        $review = $this->model('review');
        $data = $review->readReview($accountID, 2);
        $this->view('reviews', $data);
    }
    function review($jobId)
    {
        $job = $this->model('job');
        $account = $this->model('Account');
        $reviewModel = $this->model('review');

        $accountID = $_SESSION['user_id'];
        $SeekerById = $job->getJobSeekerById($jobId);

        if ($SeekerById == null) {
            $SeekerById = $job->getJobSeekerByAvailableId($jobId);
        }


        $revieweeData = $account->getUserData($SeekerById->seekerID);
        if ($revieweeData == null) {
            $revieweeData = $account->getOrgData($SeekerById->seekerID);
        }

        $review = $reviewModel->readReviewSpecific($accountID, $SeekerById->seekerID, $jobId, 2);
        $revieweeData['jobID'] = $jobId;

        if (!empty($review)) {
            $revieweeData['rating'] = $review->rating ?? NULL;
            $revieweeData['content'] = $review->content ?? '';
        }
        $this->view('review', $revieweeData);
    }

    function userReport()
    {
        // Check if user is logged in
        // if (!isset($_SESSION['user_id'])) {
        //     // Redirect to login or handle unauthorized access
        //     header('Location: /login');
        //     exit();
        // }

        $userID = $_SESSION['user_id'];

        try {
            $profile = $this->userReportModel->getUserDetails($userID);
            $appliedJobs = $this->providerDoneModel->getApplyJobCompleted();
            $appliedJobs1 = $this->seekerDoneModel->getApplyJobCompleted();
            $requestedJobs = $this->providerDoneModel->getReqAvailableCompleted();
            $requestedJobs1 = $this->seekerDoneModel->getReqAvailableCompleted();
            $postedJobs = $this->userReportModel->getPostedJobs($userID);
            // $totalEarnings = $this->userReportModel->getTotalEarnings($userID);
            // $totalSpent = $this->userReportModel->getTotalSpent($userID);
            $reviewsGivenCount = $this->userReportModel->getReviewsGivenCount($userID);
            $reviewsReceivedCount = $this->userReportModel->getReviewsReceivedCount($userID);
            $averageRating = $this->userReportModel->getAverageRating($userID);
            $complaintsMadeCount = $this->userReportModel->getComplaintsMadeCount($userID);
            $complaintsReceivedCount = $this->userReportModel->getComplaintsReceivedCount($userID);
            // $completedTasks = $this->userReportModel->getCompletedTasks($userID);
            // $ongoingTasks = $this->userReportModel->getOngoingTasks($userID);


            $data = [
                'profile' => $profile,
                'appliedJobs' => $appliedJobs,
                'appliedJobs1' => $appliedJobs1,
                'postedJobs' => $postedJobs,
                'reviewsGivenCount' => $reviewsGivenCount,
                'reviewsReceivedCount' => $reviewsReceivedCount,
                'averageRating' => $averageRating,
                'complaintsMadeCount' => $complaintsMadeCount,
                'complaintsReceivedCount' => $complaintsReceivedCount,
                'requestedJobs' => $requestedJobs,
                'requestedJobs1' => $requestedJobs1
            ];;
            $this->view('report', $data);
        } catch (Exception $e) {
            // Log the error and show a user-friendly message
            error_log("Error in userReport: " . $e->getMessage());
            $this->view('error', ['message' => 'Failed to generate report']);
        }
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
        header('Location: ' . ROOT . '/jobProvider/reviews');
    }
    public function deleteReview($reviewID)
    {
        $reviewModel = $this->model('Review');
        $review = $reviewModel->reviewById($reviewID);
        $delete = $reviewModel->deleteReview($review->reviewerID, $review->revieweeID, $review->jobID, 2);
        header('Location: ' . ROOT . '/jobProvider/reviews');
    }
    public function jobListing_myJobs()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';

        $jobModel = $this->model('Job');
        if (!empty($filterDate)) {
            $jobs = $jobModel->filterJobsByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $jobs = $jobModel->searchJobsByUser($userID, $searchTerm);
        } else {
            $jobs = $jobModel->getJobsByUser($userID);
        }
        $jobs = $jobModel->getJobsByUser($userID);

        $data = ['jobs' => $jobs];
        $this->view('jobListing_myJobs', $data);
    }

    function jobListing_send()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';
        $sendModel = $this->model('SendProvider');

        if (!empty($filterDate)) {
            $sendRequests = $sendModel->filterSendRequestsByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $sendRequests = $sendModel->searchSendRequests($userID, $searchTerm);
        } else {
            $sendRequests = $sendModel->getSendRequests();
        }

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
        $this->view('jobListing_send', $data);
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

    function jobListing_toBeCompleted()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';
        $tbcProvider = $this->model('ToBeCompletedProvider');

        if (!empty($filterDate)) {
            $applyJobTBC = $tbcProvider->filterToBeCompletedByDate($userID, $filterDate);
            $reqAvailableTBC = $tbcProvider->filterReqAvailableTBCByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $applyJobTBC = $tbcProvider->searchToBeCompleted($userID, $searchTerm);
            $reqAvailableTBC = $tbcProvider->searchReqAvailableTBC($userID, $searchTerm);
        } else {
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
            $this->view('jobListing_toBeCompleted', $data);
        }
    }
    public function jobListing_ongoing()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $ongoingProvider = $this->model('OngoingProvider');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';

        if (!empty($filterDate)) {
            $applyJobOngoing = $ongoingProvider->filterOngoingByDate($userID, $filterDate);
            $reqAvailableOngoing = $ongoingProvider->filterReqAvailableOngoingByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $applyJobOngoing = $ongoingProvider->searchOngoing($userID, $searchTerm);
            $reqAvailableOngoing = $ongoingProvider->searchReqAvailableOngoing($userID, $searchTerm);
        } else {
            $applyJobOngoing = $ongoingProvider->getApplyJobOngoing();
            $reqAvailableOngoing = $ongoingProvider->getReqAvailableOngoing();
        }

        $data = [
            'applyJobOngoing' => $applyJobOngoing,
            'reqAvailableOngoing' => $reqAvailableOngoing
        ];
        $this->view('jobListing_ongoing', $data);
    }

    function jobListing_completed()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $completedProvider = $this->model('CompletedProvider');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';

        if (!empty($filterDate)) {
            $applyJobCompleted = $completedProvider->filterCompletedByDate($userID, $filterDate);
            $reqAvailableCompleted = $completedProvider->filterReqAvailableCompletedByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $applyJobCompleted = $completedProvider->searchCompleted($userID, $searchTerm);
            $reqAvailableCompleted = $completedProvider->searchReqAvailableCompleted($userID, $searchTerm);
        } else {
            $applyJobCompleted = $completedProvider->getApplyJobCompleted();
            $reqAvailableCompleted = $completedProvider->getReqAvailableCompleted();
        }

        $data = [
            'applyJobCompleted' => $applyJobCompleted,
            'reqAvailableCompleted' => $reqAvailableCompleted
        ];
        $this->view('jobListing_completed', $data);
    }

    public function updateCompletionStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $type = $_POST['type'];
            $status = $_POST['status'];

            $completedProvider = $this->model('CompletedProvider');

            if ($type === 'application') {
                $completedProvider->updateApplicationStatus($id, $status);
            } elseif ($type === 'request') {
                $completedProvider->updateRequestStatus($id, $status);
            }

            header('Location: ' . ROOT . '/jobProvider/jobListing_completed');
        }
    }

    function jobListing_done()
    { 
        $this->jobStatusUpdater->updateJobStatuses();
        $completedProvider = $this->model('ProviderDone');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';

        if (!empty($filterDate)) {
            $applyJobCompleted = $completedProvider->filterCompletedByDate($userID, $filterDate);
            $reqAvailableCompleted = $completedProvider->filterReqAvailableCompletedByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $applyJobCompleted = $completedProvider->searchCompleted($userID, $searchTerm);
            $reqAvailableCompleted = $completedProvider->searchReqAvailableCompleted($userID, $searchTerm);
        } else {
            $applyJobCompleted = $completedProvider->getApplyJobCompleted();
            $reqAvailableCompleted = $completedProvider->getReqAvailableCompleted();
        }

        $data = [
            'applyJobCompleted' => $applyJobCompleted,
            'reqAvailableCompleted' => $reqAvailableCompleted
        ];
        $this->view('jobListing_done', $data);
    }

    function jobListing_notDone()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $completedProvider = $this->model('ProviderNotDone');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterDate = isset($_GET['filterDate']) ? trim($_GET['filterDate']) : '';

        if (!empty($filterDate)) {
            $applyJobCompleted = $completedProvider->filterCompletedByDate($userID, $filterDate);
            $reqAvailableCompleted = $completedProvider->filterReqAvailableCompletedByDate($userID, $filterDate);
        } elseif (!empty($searchTerm)) {
            $applyJobCompleted = $completedProvider->searchCompleted($userID, $searchTerm);
            $reqAvailableCompleted = $completedProvider->searchReqAvailableCompleted($userID, $searchTerm);
        } else {
            $applyJobCompleted = $completedProvider->getApplyJobCompleted();
            $reqAvailableCompleted = $completedProvider->getReqAvailableCompleted();
        }

        $data = [
            'applyJobCompleted' => $applyJobCompleted,
            'reqAvailableCompleted' => $reqAvailableCompleted
        ];
        $this->view('jobListing_notDone', $data);
    }

    public function makeComplaint($taskID)
    {
        $completedProvider = $this->model('CompletedProvider');
        $employee = $completedProvider->getEmployeeDetails($taskID);

        $data = [
            'employee' => $employee
        ];

        $this->view('makeComplaint', $data);
    }

    public function submitComplaint()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $complainantID = $_SESSION['user_id'];
            $complaineeID = trim($_POST['complaineeID']);
            $content = trim($_POST['complainInfo']);
            $complaintDate = date('Y-m-d');
            $complaintTime = date('H:i:s');
            $complaintStatus = 1;
            $complaintID = uniqid('COMP_');
            $jobOrAvailable = trim($_POST['jobOrAvailable']);
            $applicationOrReq = trim($_POST['applicationOrReq']);

            $complaintModel = $this->model('Complaint');
            $complaintModel->create([
                'complaintID' => $complaintID,
                'complainantID' => $complainantID,
                'complaineeID' => $complaineeID,
                'content' => $content,
                'complaintDate' => $complaintDate,
                'complaintTime' => $complaintTime,
                'complaintStatus' => $complaintStatus,
                'jobOrAvailable' => $jobOrAvailable,
                'applicationOrReq' => $applicationOrReq
            ]);

            header('Location: ' . ROOT . '/jobProvider/complaints');
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
            $complaintTime = date('h:i:s');

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
                $this->accountModel->incrementCounter($accountID);
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

    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $accountID = $_SESSION['user_id'];
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmText = trim($_POST['confirmText']);

            error_log("Delete account attempt for ID: " . $accountID);

            // Verify email matches the account
            $userData = $this->accountModel->getUserByID($accountID);
            if ($userData->email !== $email) {
                // Email doesn't match
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    http_response_code(401);
                    echo json_encode(['success' => false, 'message' => 'Email address does not match your account.']);
                    exit;
                } else {
                    $_SESSION['delete_error'] = 'Email address does not match your account.';
                    header('Location: ' . ROOT . '/jobProvider/settings');
                    exit;
                }
            }

            // Verify password
            if (!password_verify($password, $userData->password)) {
                // Password incorrect
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    http_response_code(401);
                    echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
                    exit;
                } else {
                    $_SESSION['delete_error'] = 'Incorrect password.';
                    header('Location: ' . ROOT . '/jobProvider/settings');
                    exit;
                }
            }

            // Verify confirmation text
            if ($confirmText !== 'Delete my account') {
                // Confirmation text incorrect
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Please type "Delete my account" exactly as shown.']);
                    exit;
                } else {
                    $_SESSION['delete_error'] = 'Please type "Delete my account" exactly as shown.';
                    header('Location: ' . ROOT . '/jobProvider/settings');
                    exit;
                }
            }

            // All validations passed, proceed with account deletion
            $result = $this->userModel->deleteUserById($accountID);
            error_log("Delete result: " . ($result ? "success" : "failure"));

            if ($result) {
                // Success
                session_destroy(); // Log out the user

                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    header('Location: ' . ROOT . '/home/login');
                    exit;
                }
            } else {
                // Handle error
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Failed to delete account. Please try again.']);
                    exit;
                } else {
                    $_SESSION['delete_error'] = 'Failed to delete account. Please try again.';
                    header('Location: ' . ROOT . '/jobProvider/settings');
                    exit;
                }
            }
        }
    }

    public function deactivateAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $accountID = $_SESSION['user_id'];

            // Check if the confirmation was sent
            if (isset($_POST['confirm']) && $_POST['confirm'] === 'true') {
                // Log attempt for debugging
                error_log("Attempting to deactivate account ID: " . $accountID);

                try {
                    // Try the model method first
                    $success = false;
                    if (method_exists($this->userModel, 'deactivateUserById')) {
                        $success = $this->userModel->deactivateUserById($accountID);
                    }

                    // If model method fails or doesn't exist, try direct database query
                    if (!$success) {
                        $db = new Database();
                        $query = "UPDATE account SET activationCode = 0 WHERE accountID = :accountID";
                        $params = [':accountID' => $accountID];
                        $success = $db->query($query, $params);
                        error_log("Direct DB deactivation result: " . ($success ? "success" : "failed"));
                    }

                    // For AJAX requests
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        if ($success) {
                            echo json_encode(['success' => true]);
                        } else {
                            http_response_code(500);
                            echo json_encode(['success' => false, 'message' => 'Failed to deactivate account']);
                        }
                        exit;
                    } else {
                        // For non-AJAX requests
                        if ($success) {
                            session_destroy();
                            header('Location: ' . ROOT . '/');
                        } else {
                            $_SESSION['error'] = 'Failed to deactivate account';
                            header('Location: ' . ROOT . '/jobProvider/settings');
                        }
                        exit;
                    }
                } catch (Exception $e) {
                    error_log("Error deactivating account: " . $e->getMessage());

                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        http_response_code(500);
                        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                    } else {
                        $_SESSION['error'] = 'Error deactivating account';
                        header('Location: ' . ROOT . '/jobProvider/settings');
                    }
                    exit;
                }
            }
        }

        // If not a POST request or confirmation not provided, redirect
        header('Location: ' . ROOT . '/jobProvider/settings');
        exit;
    }
}
