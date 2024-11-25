<?php
    class User extends Controller {
        protected $viewPath = "../app/views/user/";


        function complaints(){
            $this->view('complaints');
        }

        function messages(){
            $this->view('messages');
        }

        function helpCenter(){
            $this->view('helpCenter');
        }
        
    }