<?php
class Admin extends Controller {

        public function __construct(){
            $this->adminModel = $this->model('AdminModel');
        }

        protected $viewPath = "../app/views/admin/";

        function index(){
            $this->view('adminannouncement');        
        }

        function adminannouncement(){
            // Fetch announcements from the database
            $announcements = $this->adminModel->getAnnouncements();

            // Ensure the announcements key is always defined
            $data = [
                'announcements' => $announcements
            ];

            $this->view('adminannouncement', $data); 
            
        }

        // Load the edit announcement page
    function admineditannouncement($announcementID) {
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


    function updateAnnouncement($announcementID) {
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
    
    public function deleteAnnouncement($announcementID) {
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

    function createannouncement(){
        $data = [];
        $this->view('admincreateannouncement', $data);

    }

        function admincreateannouncement() {
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
        
        function admindashboard(){
            $data = [];
            
            $this->view('admindashboard', $data);
        }

        function admincomplaints(){
            $data = [];
            
            $this->view('admincomplaints');
        }

        function adminreviewcomplaints(){
            $data = [];
            
            $this->view('adminreviewcomplaint');
        }

        function adminmanageusers(){
            $data = [];
            
            $this->view('adminmanageusers');
        }

        function adminsettings(){
            $data = [];
            
            $this->view('adminsettings');
        }

        function adminlogindetails(){
            $data = [];
            
            $this->view('adminlogindetails');
        }

        function admindeleteaccount(){
            $data = [];
            
            $this->view('admindeleteaccount');
        }
        
        function adminadvertisements(){
            $data = [];

            $this->view('adminadvertisements');
        }

}