<?php
 class Admin extends Controller {

        protected $viewpath = "../app/view/";

        public function index(){
            $this->view('admin/dashboard');
        }
        
        public function announcement(){
            $data = [];
            
            $this->view('admin/announcement');
        }

        public function create_announcement(){
            $data = [];
            
            $this->view('admin/create_announcement');
        }

        public function complaints(){
            $data = [];
            
            $this->view('admin/complaints');
        }

        public function reviewcomplaints(){
            $data = [];
            
            $this->view('admin/reviewcomplaint');
        }

        public function manageusers(){
            $data = [];
            
            $this->view('users');
        }

        public function settings(){
            $data = [];
            
            $this->view('admin/settings');
        }

        public function logindetails(){
            $data = [];
            
            $this->view('admin/logindetails');
        }

        public function deleteaccount(){
            $data = [];
            
            $this->view('admin/delete_account');
        }
        
    }



