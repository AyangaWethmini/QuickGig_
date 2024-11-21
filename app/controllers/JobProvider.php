<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/jobProvider/";
        
        function index(){
            $this->view('findEmployees');
        }

        function individualProfile(){
            $this->view('individualProfile');
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

        function jobProvider_sidebar(){
            $this->view('jobProvider_sidebar');
        }

    }