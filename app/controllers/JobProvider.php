<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/jobProvider/";
        
        function index(){
            $this->view('individualProfile');
        }

        function findEmployees(){
            $this->view('findEmployees');
        }

        function postJob(){
            $this->view('postJob');
        }
        
        function jobListing(){
            $this->view('jobListing');
        }

        function viewEmployeeProfile(){
            $this->view('viewEmployeeProfile');
        }

        function subscription(){
            $this->view('subscription');
        }

        function messages(){
            $this->view('messages');
        }

        function announcements(){
            $this->view('announcements');
        }

        function editProfile(){
            $this->view('individualEditProfile');
        }

        function reviews(){
            $this->view('reviews');
        }

    }