<?php
    class Admin extends Controller {
        protected $viewPath = "../app/views/admin/";


        function index(){
            $this->view('adminannouncement');
        }

        function admincomplaints(){
            $this->view('adminancomplaints');
        }

        function admincreateannouncement(){
            $this->view('admincreateannouncement');
        }
        
    }