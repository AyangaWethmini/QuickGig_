<?php
date_default_timezone_set('Asia/Colombo');

class Seeker extends Controller
{
    private $helpModel;
    private $userReportModel;
    public function __construct()
    {
        $this->jobModel = $this->model('Job');
        $this->findJobModel = $this->model('FindJobs');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->accountModel = $this->model('Account');
        $this->helpModel = $this->model('Help');
        $this->userModel = $this->model('User');
        $this->userReportModel = $this->model('userReport');
        $this->reviewModel = $this->model('Review');
        $this->adminModel = $this->model('AdminModel');
    }

    protected $viewPath = "../app/views/seeker/";


    function index()
    {
        $_SESSION['current_role'] = 2;
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }
        // Get user data

        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getUserData($userId);
        $rating = $this->reviewModel->readMyReview($userId, 2);
        $finalrate = 0;
        $length = 0;
        $data['ratings'] = $this->reviewModel->getRatingDistribution($userId, 2);
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

        $this->view('seekerProfile', ['data' => $data, 'reviews' => $rating, 'avgRate' => $avgRate]);
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
                    header('Location: ' . ROOT . '/seeker/settings');
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
                    header('Location: ' . ROOT . '/seeker/settings');
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
                    header('Location: ' . ROOT . '/seeker/settings');
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
                    header('Location: ' . ROOT . '/seeker/settings');
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
                            header('Location: ' . ROOT . '/seeker/settings');
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
                        header('Location: ' . ROOT . '/seeker/settings');
                    }
                    exit;
                }
            }
        }

        // If not a POST request or confirmation not provided, redirect
        header('Location: ' . ROOT . '/seeker/settings');
        exit;
    }

    function findEmployees()
    {
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $shift = isset($_GET['shift']) ? trim($_GET['shift']) : 'any';
        $date = isset($_GET['date']) ? trim($_GET['date']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';
    
        if (!empty($searchTerm) || $shift !== 'any' || !empty($date) || !empty($location)) {
            $findJobs = $this->findJobModel->filterJobs($searchTerm, $shift, $date, $location);
        } else {
            $findJobs = $this->findJobModel->getJobs();
        }
    
        foreach ($findJobs as &$job) {
            $sumRate = 0;
            $avgRate = 0;
            $provider = $this->jobModel->getJobProviderById($job->jobID);
            $rating = $this->reviewModel->readMyReview($provider->accountID, 1);
            $userData = $this->accountModel->getUserData($provider->accountID);
    
            if (empty($userData)) {
                $userData = $this->accountModel->getOrgData($provider->accountID);
            }
    
            $length = count($rating);
            foreach ($rating as $rate) {
                $sumRate += $rate->rating;
            }
    
            if ($length > 0) {
                $avgRate = $sumRate / $length;
            }
    
            $job->rating = $avgRate;
            $job->badge = $userData['badge'];
        }
    
        $data = [
            'findJobs' => $findJobs
        ];
    
        $this->view('findEmployees', $data);
    }

    public function requestJob()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $jobModel = new FindJobs();
            $seekerID = $_SESSION['user_id'];
            $jobID = $_POST['jobID'];
            $applicationID = uniqid('APP_'); // Generate a unique application ID

            $success = $jobModel->applyForJob($applicationID, $seekerID, $jobID);

            if ($success) {
                echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "You have already applied for this job."]);
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
            header('Location: ' . ROOT . '/seeker/jobListing_myJobs');
            exit();
        }

        // Load the post job view if the limit is not exceeded
        $this->view('postJob');
    }

    function jobListing_received()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $receivedModel = $this->model('ReceivedSeeker');
        $receivedRequests = !empty($searchTerm) ? $receivedModel->searchReceivedRequests($userID, $searchTerm) : $receivedModel->getReceivedRequests();

        foreach ($receivedRequests as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 1);
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

        $data = ['receivedRequests' => $receivedRequests];
        $this->view('jobListing_received', $data);
    }

    public function rejectJobRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reqID = $_POST['reqID'];
            $receivedSeekerModel = $this->model('ReceivedSeeker');
            $success = $receivedSeekerModel->rejectRequest($reqID);

            if ($success) {
                header('Location: ' . ROOT . '/seeker/jobListing_received');
            } else {
                echo "Failed to reject the request.";
            }
        }
    }

    public function acceptJobRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reqID = $_POST['reqID'];
            $receivedSeekerModel = $this->model('ReceivedSeeker');
            $success = $receivedSeekerModel->acceptRequest($reqID);

            if ($success) {
                // Get the jobID from the application
                $req = $receivedSeekerModel->getReqByID($reqID);
                if ($req) {
                    $availableID = $req->availableID;

                    // Update the request status
                    $receivedSeekerModel->updateAvailableStatus($availableID, 2);

                    header('Location: ' . ROOT . '/seeker/jobListing_received');
                } else {
                    echo "Request not found.";
                }
            } else {
                echo "Failed to accept the request.";
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
        $this->view('viewEmployeeProfile', ['data' => $employeeData, 'reviews' => $rating, 'avgRate' => $avgRate]);
    }

    function subscription()
    {
        $this->view('subscription');
    }

    function messages()
    {
        $this->view('messages');
    }

    function individualEditProfile()
    {
        $this->view('individualEditProfile');
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
            $appliedJobs = $this->userReportModel->getAppliedJobs($userID);
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

            $data = [];
            $data = array_merge($data, [
                // 'totalEarnings' => $totalEarnings,
                // 'totalSpent' => $totalSpent,

                // 'completedTasks' => $completedTasks,
                // 'ongoingTasks' => $ongoingTasks
            ]);

            $data = [
                'profile' => $profile,
                'appliedJobs' => $appliedJobs,
                'postedJobs' => $postedJobs,
                'reviewsGivenCount' => $reviewsGivenCount,
                'reviewsReceivedCount' => $reviewsReceivedCount,
                'averageRating' => $averageRating,
                'complaintsMadeCount' => $complaintsMadeCount,
                'complaintsReceivedCount' => $complaintsReceivedCount,
            ];;
            $this->view('report', $data);
        } catch (Exception $e) {
            // Log the error and show a user-friendly message
            error_log("Error in userReport: " . $e->getMessage());
            $this->view('error', ['message' => 'Failed to generate report']);
        }
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
        $data = $review->readReview($accountID, 1);
        $this->view('reviews', $data);
    }
    function review($jobId)
    {
        $job = $this->model('job');
        $account = $this->model('Account');
        $reviewModel = $this->model('review');

        $accountID = $_SESSION['user_id'];
        $providerById = $job->getJobProviderById($jobId);
        if ($providerById == null) {
            $providerById = $job->getJobProviderByAvailableId($jobId);
        }
        $revieweeData = $account->getUserData($providerById->providerID);
        if ($revieweeData == null) {
            $revieweeData = $account->getOrgData($providerById->providerID);
            $revieweeData['fname']= $revieweeData['orgName'];
            $revieweeData['lname'] = '';
        } 
        $review = $reviewModel->readReviewSpecific($accountID, $providerById->providerID, $jobId, 1);
        $revieweeData['jobID'] = $jobId;

        if (!empty($review)) {
            $revieweeData['rating'] = $review->rating ?? NULL;
            $revieweeData['content'] = $review->content ?? '';
        }
        $this->view('review', $revieweeData);
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
        $roleID     = 1;

        $review = $this->model('review');
        $delete = $review->deleteReview($reviewerID, $revieweeID, $jobID, $roleID);
        $result = $review->submitReview($reviewerID, $revieweeID, $reviewDate, $reviewTime, $content, $rating, $roleID, $jobID);

        header('Location: ' . ROOT . '/seeker/reviews');
    }
    public function deleteReview($reviewID)
    {
        $reviewModel = $this->model('Review');
        $review = $reviewModel->reviewById($reviewID);
        $delete = $reviewModel->deleteReview($review->reviewerID, $review->revieweeID, $review->jobID, 1);
        header('Location: ' . ROOT . '/seeker/reviews');
    }

    public function jobListing_myJobs()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $availableModel = $this->model('Available');
        $jobs = !empty($searchTerm) ? $availableModel->searchJobsByUser($userID, $searchTerm) : $availableModel->getJobsByUser($userID);

        $data = ['jobs' => $jobs];
        $this->view('jobListing_myJobs', $data);
    }

    function jobListing_send()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $sendModel = $this->model('SendSeeker');
        $sendRequests = !empty($searchTerm) ? $sendModel->searchSendRequests($userID, $searchTerm) : $sendModel->getSendRequests();

        foreach ($sendRequests as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 1);
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
            'sendRequests' => $sendRequests
        ];

        $data = ['sendRequests' => $sendRequests];
        $this->view('jobListing_send', $data);
    }

    public function deleteSendRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $applicationID = $data['applicationID'];
            $sendSeekerModel = $this->model('SendSeeker');
            $success = $sendSeekerModel->deleteSendRequest($applicationID);

            if ($success) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error"]);
            }
        }
    }

    function jobListing_toBeCompleted()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $tbcSeeker = $this->model('ToBeCompletedSeeker');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

        $reqAvailableTBC = !empty($searchTerm) ? $tbcSeeker->searchReqAvailableTBC($userID, $searchTerm) : $tbcSeeker->getReqAvailableTBC();
        $applyJobTBC = !empty($searchTerm) ? $tbcSeeker->searchToBeCompleted($userID, $searchTerm) : $tbcSeeker->getApplyJobTBC();


        foreach ($reqAvailableTBC as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 1);
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
        foreach ($applyJobTBC as $job) {
            $userId = $job->accountID;
            $rating = $this->reviewModel->readMyReview($userId, 1);
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
            'reqAvailableTBC' => $reqAvailableTBC,
            'applyJobTBC' => $applyJobTBC
        ];
        $this->view('jobListing_toBeCompleted', $data);
    }

    function jobListing_ongoing()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $ongoingSeeker = $this->model('OngoingSeeker');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

        $applyJobOngoing = !empty($searchTerm) ? $ongoingSeeker->searchOngoing($userID, $searchTerm) : $ongoingSeeker->getApplyJobOngoing();
        $reqAvailableOngoing = !empty($searchTerm) ? $ongoingSeeker->searchReqAvailableOngoing($userID, $searchTerm) : $ongoingSeeker->getReqAvailableOngoing();

        $data = [
            'applyJobOngoing' => $applyJobOngoing,
            'reqAvailableOngoing' => $reqAvailableOngoing
        ];
        $this->view('jobListing_ongoing', $data);
    }

    function jobListing_completed()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $completedSeeker = $this->model('CompletedSeeker');
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

        $applyJobCompleted = !empty($searchTerm) ? $completedSeeker->searchCompleted($userID, $searchTerm) : $completedSeeker->getApplyJobCompleted();
        $reqAvailableCompleted = !empty($searchTerm) ? $completedSeeker->searchReqAvailableCompleted($userID, $searchTerm) : $completedSeeker->getReqAvailableCompleted();

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
        $completedProvider = $this->model('SeekerDone');
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
        $completedProvider = $this->model('SeekerNotDone');
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
        $completedSeeker = $this->model('CompletedSeeker');
        $employer = $completedSeeker->getEmployerDetails($taskID);

        $data = [
            'employer' => $employer
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

            $complaintModel = $this->model('SeekerComplaint');
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

            header('Location: ' . ROOT . '/seeker/complaints');
        }
    }

    public function complaints()
    {
        $complaintModel = $this->model('SeekerComplaint');
        $complaints = $complaintModel->getComplaints();

        $data = [
            'complaints' => $complaints
        ];

        $this->view('complaints', $data);
    }

    public function updateComplaint($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = trim($_POST['complainInfo']);
            $complaintDate = date('Y-m-d');
            $complaintTime = date('H:i:s');

            $complaintModel = $this->model('SeekerComplaint');
            $complaintModel->update($id, [
                'content' => $content,
                'complaintDate' => $complaintDate,
                'complaintTime' => $complaintTime
            ]);

            header('Location: ' . ROOT . '/seeker/complaints');
        } else {
            $complaintModel = $this->model('SeekerComplaint');
            $complaint = $complaintModel->getComplaintById($id);

            $data = [
                'complaint' => $complaint
            ];

            $this->view('updateComplaint', $data);
        }
    }

    public function deleteComplaint($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $complaintModel = $this->model('SeekerComplaint');
            $complaintModel->delete($id);
            header('Location: ' . ROOT . '/seeker/complaints');
        }
    }

    public function settings()
    {
        $this->view('settings');
    }
    function updateJob()
    {
        $this->view('updateJob');
    }

    public function availability()
    {
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
            $availabilityStatus = 1;
            $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

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
                'currency' => $currency,
                'availabilityStatus' => $availabilityStatus,
                'categories' => json_encode($categories)
            ]);

            // Redirect or handle based on success or failure
            if ($isPosted) {
                $this->accountModel->incrementCounter($accountID);
                header('Location: ' . ROOT . '/seeker/jobListing_myJobs'); // Replace with the appropriate success page
                exit();
            } else {
                // Handle errors (e.g., log them or show an error message)
                echo "Failed to post availability. Please try again.";
            }
        }
    }

    public function updateAvailability($id = null)
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
            $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

            // Update availability in the database
            $this->availabilityModel = $this->model('Available');
            $this->availabilityModel->update($id, [
                'description' => $description,
                'shift' => $shift,
                'salary' => $salary,
                'currency' => $currency,
                'timeFrom' => $timeFrom,
                'timeTo' => $timeTo,
                'availableDate' => $availableDate,
                'location' => $location,
                'categories' => json_encode($categories)
            ]);

            // Redirect to the availability page or another appropriate page
            header('Location: ' . ROOT . '/seeker/jobListing_myJobs');
        } else {
            // Get the current availability details for the given ID
            $this->availabilityModel = $this->model('Available');
            $availability = $this->availabilityModel->getAvailabilityById($id);

            // Pass the current availability data to the view
            $data = [
                'availability' => $availability
            ];

            // Load the update form view
            $this->view('updateJob', $data);
        }
    }
    public function deleteAvailability($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->availabilityModel = $this->model('Available');
            $this->availabilityModel->delete($id);
            header('Location: ' . ROOT . '/seeker/jobListing_myJobs');
        }
    }
}
