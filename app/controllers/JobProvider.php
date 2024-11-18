<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/jobProvider/";
        
        function index(){
            $this->view('findEmployees');
        }

        function profile(){
            $this->view('individualProfile');
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

    }