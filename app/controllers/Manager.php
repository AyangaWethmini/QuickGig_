<?php
    class Manager extends Controller {
        protected $viewPath = "../app/views/manager/";


        function index(){
            $this->view('dashboard');
        }

        function advertisements(){
            
            $this->view('advertisements');
        }
        
    }