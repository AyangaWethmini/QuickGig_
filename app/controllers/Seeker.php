<?php
date_default_timezone_set('Asia/Colombo');

class Seeker extends Controller
{
    private $helpModel;
    public function __construct()
    {
        $this->findJobModel = $this->model('FindJobs');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->accountModel = $this->model('Account');
        $this->helpModel = $this->model('Help');
        
    }

    protected $viewPath = "../app/views/seeker/";


    function index()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }

        // Get user data
        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getUserData($userId);
        $this->view('seekerProfile', $data);
    }

    function findEmployees() {
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        if (!empty($searchTerm)) {
            $findJobs = $this->findJobModel->searchJobs($searchTerm);
        } else {
            $findJobs = $this->findJobModel->getJobs();
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

    function postJob()
    {
        $this->view('postJob');
    }

    function jobListing_received()
    {
        $userID = $_SESSION['user_id'];
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $receivedModel = $this->model('ReceivedSeeker');
        $receivedRequests = !empty($searchTerm) ? $receivedModel->searchReceivedRequests($userID, $searchTerm) : $receivedModel->getReceivedRequests();

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
        $this->view('announcements');
    }

    function individualEditProfile()
    {
        $this->view('individualEditProfile');
    }

    function report(){
        $this->view('report');
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
        $this->view('reviews');
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

    public function updateCompletionStatus() {
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

    function jobListing_done() {
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

    function jobListing_notDone() {
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

            header('Location: ' . ROOT . '/seeker/jobListing_completed');
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
