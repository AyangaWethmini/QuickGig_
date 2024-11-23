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
        
        function adminadvertisements(){
            $data = [];

            $this->view('adminadvertisements');
        }


    }



