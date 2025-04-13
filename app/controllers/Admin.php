<?php
class Admin extends Controller
{

    public function __construct()
    {
        $this->adminModel = $this->model('AdminModel');
        $this->complaintModel = $this->model('Complaint');
        $this->userModel = $this->model('User');
        $this->advertisementModel = $this->model('Advertisement');
        $this->accountModel = $this->model('Account');
    }

    protected $viewPath = "../app/views/admin/";

    function index()
    {
        $this->view('adminannouncement');
    }

    // In app/controllers/Admin.php
    function adminadvertisements()
    {
        // Set items per page
        $limit = 1;

        // Get current page from URL, default to 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate offset
        $start = ($page - 1) * $limit;

        // Get total advertisements and paginated advertisements
        $totalAds = $this->advertisementModel->getTotalAdvertisements();
        $ads = $this->advertisementModel->getAdvertisementsPaginated($start, $limit);

        // Calculate total pages
        $totalPages = ceil($totalAds / $limit);

        // Ensure current page is within valid range
        if ($page > $totalPages && $totalPages > 0) {
            header('Location: ' . ROOT . '/admin/adminadvertisements?page=1');
            exit;
        }

        $data = [
            'ads' => $ads,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalAds' => $totalAds
        ];

        $this->view('adminadvertisements', $data);
    }

    function adminmanageusers()
    {
        // Set items per page
        $limit = 4;

        // Get current page from URL, default to 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate offset (start from 0 for first page)
        $start = ($page - 1) * $limit;

        // Get total users and paginated users
        $totalUsers = $this->userModel->getTotalUsers();
        $users = $this->userModel->getUsersPaginated($start, $limit);

        // Calculate total pages
        $totalPages = ceil($totalUsers / $limit);

        // Ensure current page is within valid range
        if ($page > $totalPages && $totalPages > 0) {
            header('Location: ' . ROOT . '/admin/adminmanageusers?page=1');
            exit;
        }

        // Debug information
        // echo "Page: $page, Start: $start, Limit: $limit, Total Users: $totalUsers";
        // print_r($users);

        $data = [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalUsers' => $totalUsers
        ];

        $this->view('adminmanageusers', $data);
    }


    public function deactivateUser($accountID)
    {
        // Debugging: Check if the accountID is received
        // echo "Account ID: " . $accountID;
        // exit;

        // Call the model method to deactivate the user
        if ($this->userModel->deactivateUserById($accountID)) {
            header('Location: ' . ROOT . '/admin/adminmanageusers');
        } else {
            header('Location: ' . ROOT . '/admin/adminmanageusers');
        }
    }

    public function activateUser($accountID)
    {
        // Debugging: Check if the accountID is received
        // echo "Account ID: " . $accountID;
        // exit;

        // Call the model method to deactivate the user
        if ($this->userModel->activateUserById($accountID)) {
            header('Location: ' . ROOT . '/admin/adminmanageusers');
        } else {
            header('Location: ' . ROOT . '/admin/adminmanageusers');
        }
    }

    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST);
            $accountID = $_POST['accountID'] ?? null;

            if (!$accountID) {
                die('Account ID is missing');
            }

            // Debugging
            echo "Account ID to delete: $accountID";

            if ($this->userModel->deleteUserById($accountID)) {
                // echo "User deleted successfully";
                header('Location: ' . ROOT . '/admin/adminmanageusers');
                exit;
            } else {
                echo "Failed to delete user";
                exit;
            }
        } else {
            header('Location: ' . ROOT . '/admin/adminmanageusers');
            exit;
        }
    }


    function adminannouncement()
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

        $this->view('adminannouncement', $data);
    }

    // Load the edit announcement page
    function admineditannouncement($announcementID)
    {
        $announcement = $this->adminModel->getAnnouncementById($announcementID);

        $data = [
            'announcementID' => $announcementID,
            'announcementDate' => $announcement->announcementDate,
            'announcementTime' => $announcement->announcementTime,
            'content' => $announcement->content,
            'announcementDate_error' => '',
            'announcementTime_error' => '',
            'content_error' => '',
        ];

        $this->view('admineditannouncement', $data);
    }


    function updateAnnouncement($announcementID)
    {
        echo "Checkpoint 1: Function start"; // Add at the start of the function

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "Checkpoint 2: Inside POST check"; // Add after the POST check

            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'announcementID' => $announcementID,  // Use the ID from the URL
                'announcementDate' => trim($_POST['announcementDate']),
                'announcementTime' => trim($_POST['announcementTime']),
                'content' => trim($_POST['body']),
                'announcementDate_error' => '',
                'announcementTime_error' => '',
                'content_error' => '',
            ];

            // Validate input
            if (empty($data['announcementDate'])) {
                $data['announcementDate_error'] = 'Announcement date cannot be empty.';
            }
            if (empty($data['announcementTime'])) {
                $data['announcementTime_error'] = 'Announcement time cannot be empty.';
            }
            if (empty($data['content'])) {
                $data['content_error'] = 'Content cannot be empty.';
            }

            // Check if there are no validation errors
            if (empty($data['announcementDate_error']) && empty($data['announcementTime_error']) && empty($data['content_error'])) {
                // Update the announcement
                if ($this->adminModel->updateAnnouncements($announcementID, [
                    'announcementDate' => $data['announcementDate'],
                    'announcementTime' => $data['announcementTime'],
                    'content' => $data['content'],
                ])) {

                    header('Location: ' . ROOT . '/admin/adminannouncement');
                } else {
                    // die("Checkpoint 4: Database failed");
                    header('Location: ' . ROOT . '/admin/adminannouncement');
                }
            }

            // Reload the view with errors
            $this->view('admineditannouncement', $data);
        }
    }

    public function deleteAnnouncement($announcementID)
    {
        if ($this->adminModel->delete($announcementID)) {
            // Redirect to the announcements page with success message
            header('Location: ' . ROOT . '/admin/adminannouncement');
            exit;
        } else {
            // Redirect to the announcements page with error message
            header('Location: ' . ROOT . '/admin/adminannouncement');
            exit;
        }
    }

    function createannouncement()
    {
        $data = [];
        $this->view('admincreateannouncement', $data);
    }

    function admincreateannouncement()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and validate the input
            $data = [
                'announcementDate' => trim($_POST['announcementDate']),
                'announcementTime' => trim($_POST['announcementTime']),
                'content' => trim($_POST['body']),
                'announcementDate_error' => '',
                'announcementTime_error' => '',
                'content_error' => '',
            ];

            if (empty($data['announcementDate'])) {
                $data['announcementDate_error'] = 'Announcement date cannot be empty.';
            }
            if (empty($data['announcementTime'])) {
                $data['announcementTime_error'] = 'Announcement time cannot be empty.';
            }
            if (empty($data['content'])) {
                $data['content_error'] = 'Content cannot be empty.';
            }

            // Check for no errors
            if (
                empty($data['announcementDate_error']) &&
                empty($data['announcementTime_error']) &&
                empty($data['content_error'])
            ) {
                // Get the adminID from the session
                $adminID = $_SESSION['user_id'];
                // Insert into the database using the model
                if ($this->adminModel->createAnnouncement($data, $adminID)) {
                    // Redirect to announcements page
                    header('Location: ' . ROOT . '/admin/adminannouncement');
                    exit;
                } else {
                    // die('Something went wrong.');
                    header('Location: ' . ROOT . '/admin/adminannouncement');
                }
            } else {
                // Load the view with errors
                $this->view('admincreateannouncement', $data);
            }
        } else {
            $data = [
                'announcementDate' => '',
                'announcementTime' => '',
                'content' => '',
                'announcementDate_error' => '',
                'announcementTime_error' => '',
                'content_error' => '',
            ];

            $this->view('admincreateannouncement', $data);
        }
    }

    function admindashboard()
    {
        // Assuming you have a model for interacting with the database
        $totalIndividuals = $this->adminModel->getCountByRoleID(2); // Count for roleID=2
        $totalOrganizations = $this->adminModel->getCountByRoleID(3); // Count for roleID=3
        $totalJobs = $this->adminModel->getJobCount(); // Count for jobs

        $totalAnnouncements = $this->adminModel->getTotalAnnouncements();

        $totalAds = $this->advertisementModel->getTotalAdvertisements();

        $totalComplaints = $this->complaintModel->getComplaintsCount();

        // Pass the counts to the view
        $data = [
            'totalIndividuals' => $totalIndividuals,
            'totalOrganizations' => $totalOrganizations,
            'totalJobs' => $totalJobs,
            'totalAnnouncements' => $totalAnnouncements,
            'totalAds' => $totalAds,
            'totalComplaints' => $totalComplaints
        ];

        $this->view('admindashboard', $data);
    }


    /*COMPLAINTS*/
    function admincomplaints()
    {

        $complaints = $this->complaintModel->getAllComplaints();

        $data = [
            'complaints' => $complaints
        ];

        $this->view('admincomplaints', $data);
    }

    public function updateComplaintStatus()
    {
        try {
            // Check if it's a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Get the JSON data from the request
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData);

            if (!$data || !isset($data->id) || !isset($data->status)) {
                throw new Exception('Invalid data received');
            }

            // Update the complaint status
            $success = $this->complaintModel->updateStatus($data->id, $data->status);

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Failed to update status');
            }
        } catch (Exception $e) {
            error_log("Error in updateComplaintStatus: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    function adminreviewcomplaints()
    {
        $data = [];

        $this->view('adminreviewcomplaint');
    }



    function adminsettings()
    {
        $data = [];

        $this->view('adminsettings');
    }

    function adminlogindetails()
    {
        $data = [];

        $this->view('adminlogindetails');
    }

    function admindeleteaccount()
    {
        $data = [];

        $this->view('admindeleteaccount');
    }

    public function getComplaintDetails($complaintId)
    {
        try {
            // Debug logging
            error_log("Received complaint ID: " . $complaintId);

            // Get complaint details
            $complaint = $this->complaintModel->getComplaintById($complaintId);

            // Debug logging
            error_log("Complaint data: " . print_r($complaint, true));

            if (!$complaint) {
                throw new Exception('Complaint not found');
            }

            // Get user details
            $complainant = $this->accountModel->getUserByID($complaint->complainantID);
            $complainee = $this->accountModel->getUserByID($complaint->complaineeID);

            // Debug logging
            error_log("Complainant data: " . print_r($complainant, true));
            error_log("Complainee data: " . print_r($complainee, true));

            if (!$complainant || !$complainee) {
                throw new Exception('User details not found');
            }

            // Prepare response data
            $response = [
                'complaint' => [
                    'complaintID' => $complaint->complaintID,
                    'content' => $complaint->content,
                    'complaintDate' => $complaint->complaintDate,
                    'complaintTime' => $complaint->complaintTime,
                    'complaintStatus' => $complaint->complaintStatus
                ],
                'complainant' => [
                    'email' => $complainant->email
                ],
                'complainee' => [
                    'email' => $complainee->email
                ]
            ];

            // Set proper headers
            header('Content-Type: application/json');

            // Debug logging
            error_log("Sending response: " . json_encode($response));

            // Send response
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            // Log the error
            error_log("Error in getComplaintDetails: " . $e->getMessage());

            // Send error response
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
