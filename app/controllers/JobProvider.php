<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/jobProvider/";


        function index(){
            $this->view('individualProfile');
        }
        
        function jobListing(){
            $this->view('jobListing');
        }

        function viewEmployeeProfile(){
            $this->view('viewEmployeeProfile');
        }

    }