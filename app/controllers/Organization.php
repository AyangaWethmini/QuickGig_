<?php
    class Organization extends Controller {
        protected $viewPath = "../app/views/organization/";
        
        function index(){
            $this->view('organizationProfile');
        }

        function org_findEmployees(){
            $this->view('org_findEmployees');
        }

        function org_postJob(){
            $this->view('org_postJob');
        }
        
        function org_jobListing_received(){
            $this->view('org_jobListing_received');
        }

        function org_viewEmployeeProfile(){
            $this->view('org_viewEmployeeProfile');
        }

        function org_subscription(){
            $this->view('org_subscription');
        }

        function org_messages(){
            $this->view('org_messages');
        }

        function org_announcements(){
            $this->view('org_announcements');
        }

        function organizationEditProfile(){
            $this->view('organizationEditProfile');
        }

        function org_helpCenter(){
            $this->view('org_helpCenter');
        }

        function org_reviews(){
            $this->view('org_reviews');
        }

        function org_jobListing_myJobs(){
            $this->view('org_jobListing_myJobs');
        }

        function org_jobListing_send(){
            $this->view('org_jobListing_send');
        }

        function org_jobListing_toBeCompleted(){
            $this->view('org_jobListing_toBeCompleted');
        }

        function org_jobListing_ongoing(){
            $this->view('org_jobListing_ongoing');
        }

        function org_jobListing_completed(){
            $this->view('org_jobListing_completed');
        }

    }