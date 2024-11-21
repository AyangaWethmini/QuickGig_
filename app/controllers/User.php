<?php
    class User extends Controller {
        protected $viewPath = "../app/views/user/";


        function complaints(){
            $this->view('complaints');
        }

        function helpCenter(){
            $this->view('helpCenter');
        }
        
    }