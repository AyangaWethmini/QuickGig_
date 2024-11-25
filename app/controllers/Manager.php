<?php
class Manager extends Controller {
    protected $viewPath = "../app/views/manager/";
    protected $advertisementModel;

    public function __construct(){
        $this->advertisementModel = $this->model('Advertisement');
    }

    public function index(){
        $this->view('dashboard');
    }

    public function advertisements() {
        $data = $this->advertisementModel->getAdvertisements();
        $this->view('advertisements', ['advertisements' => $data]);
    }

    public function postAdvertisement() {
        
        echo "dwjhdkjwff";
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
            $adTitle = trim($_POST['adTitle']);
            $advertiserID = 2; // Default for now
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $adStatus = intval($_POST['status']);
            $img = "https://via.placeholder.com/150"; // Placeholder image
            $adDate = date('Y-m-d');
            $adTime = date('H:i:s');
            echo "dwjhdkjwff";

            $advertisementModel = $this->model('Advertisement');

            $advertisementModel->createAdvertisement([
                'adTitle' => $adTitle,
                'advertiserID' => $advertiserID,
                'adDescription' => $adDescription,
                'link' => $link,
                'adStatus' => $adStatus,
                'img' => $img,
                'adDate' => $adDate,
                'adTime' => $adTime,
                'clicks' => 0 // Default clicks count
            ]);

            header('Location: ' . ROOT . '/manager/advertisements');
            
        }
    }
}
