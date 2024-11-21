<?php
 class Admin extends Controller {

        protected $viewPath = "../app/views/admin/";

        function index(){
            $this->view('adminannouncement');
        }

        function admincreateannouncement(){
            $data = [];
            
            $this->view('admincreateannouncement');
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

        function adminlogin(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Form is submitting
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),

                    'email_err' => '',
                    'password_err' => ''
                ];

                //validate the email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                } else {
                    if($this->userModel->findUserByEmail($data['email'])){
                        //User found
                    } else {
                        $data['email_err'] = 'No user found';
                    }
                }

                //validate the password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }

                //If no error found, login the user
                
            }
            else {
                //Initial Form

                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];

                //Load view
                $this->view('adminlogin', $data);
            }
        }

    }



