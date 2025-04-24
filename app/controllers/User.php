<?php
class User extends Controller
{
    protected $viewPath = "../app/views/user/";


    function complaints()
    {
        $this->view('complaints');
    }

    function messages()
    {
        $this->view('messages');
    }

    function helpCenter()
    {
        $this->view('helpCenter');
    }

    function settings()
    {
        $this->view('settings');
    }
    public function switchRole($roleId)
    {
        // Validate the role ID (1 = Job Provider, 2 = Job Seeker)
            $_SESSION['current_role'] = (int)$roleId;
        // Redirect back or to dashboard
        if($roleId ==  2){
            header("Location: " . ROOT . "/seeker/seekerProfile"); 
        }else if($roleId ==  1){
            header("Location: " . ROOT . "/jobprovider/providerProfile"); 
        }
        
        function settings(){
            $this->view('settings');
        }

        function userReport(){
            $this->view('user_report');
        }
        
        
    }
