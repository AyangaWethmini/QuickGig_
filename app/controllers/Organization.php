<?php
    class Organization extends Controller {
        protected $viewPath = "../app/views/organization/";
        
        function index(){
            $this->view('organizationProfile');
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

        function organizationEditProfile(){
            $this->view('organizationEditProfile');
        }

        function helpCenter(){
            $this->view('helpCenter');
        }

        function reviews(){
            $this->view('reviews');
        }

    }