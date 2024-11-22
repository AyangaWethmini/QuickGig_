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
        
        function jobListing_received(){
            $this->view('jobListing_received');
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

        function individualEditProfile(){
            $this->view('individualEditProfile');
        }

        function helpCenter(){
            $this->view('helpCenter');
        }

        function reviews(){
            $this->view('reviews');
        }

    }