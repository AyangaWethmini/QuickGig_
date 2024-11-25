<?php
    class Manager extends Controller {
        protected $viewPath = "../app/views/manager/";
        protected $advertisementModel;

        public function __construct(){
            $this->advertisementModel = $this->model('Advertisement');
        }

        function index(){
            $this->view('dashboard');
        }

        function advertisements() {
            $data = $this->advertisementModel->getAdvertisements();
            $this->view('advertisements', ['advertisements' => $data]);

        }


        function postAdvertisement(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            }
        }   
    }