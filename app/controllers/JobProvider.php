<?php
date_default_timezone_set('Asia/Colombo');

class JobProvider extends Controller
{

    private $helpModel;
    private $managerModel;
    private $accountSubscriptionModel;
    private $userReportModel;

    public function __construct()
    {
        $this->complaintModel = $this->model('Complaint');
        $this->findEmpModel = $this->model('FindEmployees');
        $this->accountModel = $this->model('Account');
        $this->jobStatusUpdater = $this->model('JobStatusUpdater');
        $this->helpModel = $this->model('Help');
        $this->managerModel = $this->model('ManagerModel');
        $this->accountSubscriptionModel = $this->model('AccountSubscription');
        $this->userReportModel = $this->model('userReport');
    }
    protected $viewPath = "../app/views/jobProvider/";

    function index()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login'); // Redirect to login if not authenticated
        }

        // Get user data
        $userId = $_SESSION['user_id'];
        $data = $this->accountModel->getUserData($userId);
        $this->view('individualProfile', $data);
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
        if (!empty($searchTerm)) {
            $findEmployees = $this->findEmpModel->searchEmployees($searchTerm);
        } else {
            $findEmployees = $this->findEmpModel->getEmployees();
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

    function postJob()
    {
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

        $data = ['receivedRequests' => $receivedRequests];
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
        $subsDetails = $this->accountSubscriptionModel->getUserSubscriptionDetails($_SESSION['user_id']);
        $this->view('subscription', ['subscription' => $subsDetails]);
    }

    function messages()
    {
        $this->view('messages');
    }

    function announcements()
    {
        $this->view('announcements');
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

    function reviews()
    {
        $this->view('reviews');
    }

    function userReport()
    {
        // Check if user is logged in
        // if (!isset($_SESSION['user_id'])) {
        //     // Redirect to login or handle unauthorized access
        //     header('Location: /login');
        //     exit();
        // }

        // $userID = $_SESSION['user_id'];

        // try {
        //     $profile = $this->userReportModel->getUserDetails($userID);


        //     $appliedJobs = [];
        //     $postedJobs = [];

        //     $findEmpModel = $this->model('FindEmployees');
        //     $appliedJobs = $findEmpModel->getAppliedJobs($userID);
        //     $postedJobs = $findEmpModel->getPostedJobs($userID);


        //     $data = [
        //         'profile' => $profile,

        //         // 'appliedJobs' => $appliedJobs,
        //         // 'postedJobs' => $postedJobs
        //     ];

        $this->view('report'/*,$data*/);
        // } catch (Exception $e) {
        //     // Log the error and show a user-friendly message
        //     error_log("Error in userReport: " . $e->getMessage());
        //     $this->view('error', ['message' => 'Failed to generate report']);
        // }
    }

    function jobListing_myJobs()
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

        $data = ['sendRequests' => $sendRequests];
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
        }

        $data = [
            'applyJobTBC' => $applyJobTBC,
            'reqAvailableTBC' => $reqAvailableTBC
        ];
        $this->view('jobListing_toBeCompleted', $data);
    }

    function jobListing_ongoing()
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
