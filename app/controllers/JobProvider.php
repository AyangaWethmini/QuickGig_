<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/jobProvider/";


        function index(){
            $this->view('individualProfile');
        }

        function postJob(){
            $this->view('postJob');
        }
        
    }