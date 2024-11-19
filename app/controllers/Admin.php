<?php
 class Admin extends Controller {

        protected $viewPath = "../app/views/admin/";

        function index(){
            $this->view('adminannouncement');
        }

        function admincreateannouncement(){
            $data = [];
            
            $this->view('admincreateannouncement');
        }

        function admincomplaints(){
            $data = [];
            
            $this->view('admincomplaints');
        }

        function adminreviewcomplaints(){
            $data = [];
            
            $this->view('adminreviewcomplaint');
        }

        function adminmanageusers(){
            $data = [];
            
            $this->view('adminmanageusers');
        }

        function adminsettings(){
            $data = [];
            
            $this->view('adminsettings');
        }

        function adminlogindetails(){
            $data = [];
            
            $this->view('adminlogindetails');
        }

        function admindeleteaccount(){
            $data = [];
            
            $this->view('admindeleteaccount');
        }
        
        function adminadvertisements(){
            $data = [];

            $this->view('adminadvertisements');
        }

    }



