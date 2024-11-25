<?php

    class Admin extends Controller {

        protected $viewpath = "../app/view/";

        public function index(){
            $this->view('admin/dashboard');
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

        if (!$announcement) {
            // Redirect if announcement not found
            flash('announcement_message', 'Announcement not found', 'alert alert-danger');
            header('Location: ' . ROOT . '/admin/adminannouncement');
            exit;
        }

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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                    // Redirect with success message
                    // flash('announcement_message', 'Announcement updated successfully');
                    header('Location: ' . ROOT . '/admin/adminannouncement');
                    exit;
                } else {
                    // Handle database error
                    // flash('announcement_message', 'Error updating the announcement', 'alert alert-danger');
                }
            }
    
            // Reload the view with errors
            $this->view('admineditannouncement', $data);
        } else {
            // Redirect to announcements if accessed without POST
            header('Location: ' . ROOT . '/admin/adminannouncement');
            exit;
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

        function admincreateannouncement() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize and validate the input
                $data = [
                    'announcementID' => trim($_POST['announcementID']),
                    'announcementDate' => trim($_POST['announcementDate']),
                    'announcementTime' => trim($_POST['announcementTime']),
                    'content' => trim($_POST['body']),
                    'announcementID_error' => '',
                    'announcementDate_error' => '',
                    'announcementTime_error' => '',
                    'content_error' => '',
                ];
        
                // Validate inputs
                if (empty($data['announcementID'])) {
                    $data['announcementID_error'] = 'Announcement ID cannot be empty.';
                }
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
                    empty($data['announcementID_error']) && 
                    empty($data['announcementDate_error']) && 
                    empty($data['announcementTime_error']) && 
                    empty($data['content_error'])
                ) {
                    // Insert into the database using the model
                    if ($this->adminModel->createAnnouncement($data)) {
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
                    'announcementID' => '',
                    'announcementDate' => '',
                    'announcementTime' => '',
                    'content' => '',
                    'announcementID_error' => '',
                    'announcementDate_error' => '',
                    'announcementTime_error' => '',
                    'content_error' => '',
                ];
        
                $this->view('admincreateannouncement', $data);
            }
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
        
        public function announcement(){
            $data = [];
            
            $this->view('admin/adminannouncement');
        }

        public function create announcement(){
            $data = [];
            
            $this->view('admin/admincreateannouncement');
        }

        public function complaints(){
            $data = [];
            
            $this->view('admin/complaints');
        }

        public function reviewcomplaints(){
            $data = [];
            
            $this->view('admin/reviewcomplaint');
        }

        public function manageusers(){
            $data = [];
            
            $this->view('users');
        }

        public function settings(){
            $data = [];
            
            $this->view('admin/settings');
        }

        public function logindetails(){
            $data = [];
            
            $this->view('admin/logindetails');
        }

        public function deleteaccount(){
            $data = [];
            
            $this->view('admin/delete_account');
        }
        
    }



}
