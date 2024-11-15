<?php
    class JobProvider extends Controller {
        protected $viewPath = "../app/views/";


        function index(){
            $this->view('helpCenter');
        }

       
    }