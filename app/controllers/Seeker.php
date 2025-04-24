<?php
date_default_timezone_set('Asia/Colombo');

class Seeker extends Controller
{
    public function __construct()
    {
        $this->jobModel = $this->model('Job');
        $this->findJobModel = $this->model('FindJobs');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->accountModel = $this->model('Account');
        $this->reviewModel = $this->model('Review');
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
    function findEmployees()
    {
        $findJobs = $this->findJobModel->getJobs();

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
            'findJobs' => $findJobs,
            'avgRate' => $avgRate
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

    function postJob()
    {
        $this->view('postJob');
    }

    function jobListing_received()
    {
        $receivedModel = $this->model('ReceivedSeeker');
        $receivedRequests = $receivedModel->getReceivedRequests();
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

    function announcements()
    {
        $this->view('announcements');
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
        $revieweeData = $account->getUserData($providerById->accountID);
        $review = $reviewModel->readReviewSpecific($accountID, $providerById->accountID, $jobId, 1);
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
        $availableModel = $this->model('Available');
        $jobs = $availableModel->getJobsByUser($userID);

        $data = [
            'jobs' => $jobs
        ];

        $this->view('jobListing_myJobs', $data);
    }

    function jobListing_send()
    {
        $send = $this->model('SendSeeker');
        $sendRequests = $send->getSendRequests();
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
        $reqAvailableTBC = $tbcSeeker->getReqAvailableTBC();
        $applyJobTBC = $tbcSeeker->getApplyJobTBC();
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
        $reqAvailableOngoing = $ongoingSeeker->getReqAvailableOngoing();
        $applyJobOngoing = $ongoingSeeker->getApplyJobOngoing();
        $data = [
            'reqAvailableOngoing' => $reqAvailableOngoing,
            'applyJobOngoing' => $applyJobOngoing
        ];
        $this->view('jobListing_ongoing', $data);
    }

    function jobListing_completed()
    {
        $this->jobStatusUpdater->updateJobStatuses();
        $completedSeeker = $this->model('CompletedSeeker');
        $reqAvailableCompleted = $completedSeeker->getReqAvailableCompleted();
        $applyJobCompleted = $completedSeeker->getApplyJobCompleted();
        $data = [
            'reqAvailableCompleted' => $reqAvailableCompleted,
            'applyJobCompleted' => $applyJobCompleted
        ];
        $this->view('jobListing_completed', $data);
    }

    function makeComplaint()
    {
        $this->view('makeComplaint');
    }

    function complaints()
    {
        $this->view('complaints');
    }

    function settings()
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
