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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Basic form validation
            if (!isset($_POST['adTitle']) || !isset($_POST['adDescription']) || !isset($_POST['link']) || !isset($_POST['adStatus']) || !isset($_FILES['adImage'])) {
                // Handle error - redirect with error message
                header('Location: ' . ROOT . '/manager/advertisements');
                return;
            }

            // Get form data
            $adTitle = trim($_POST['adTitle']);
            $advertiserID = 2; // Default for now
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $adStatus = intval($_POST['adStatus']);
            $adDate = date('Y-m-d');
            $adTime = date('H:i:s');

            // Handle image upload
            $imageData = null;
            if (isset($_FILES['adImage']) && $_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
                // Check file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($_FILES['adImage']['tmp_name']);
                
                if (in_array($fileType, $allowedTypes)) {
                    // Read the image file content
                    $imageData = file_get_contents($_FILES['adImage']['tmp_name']);
                } else {
                    // Handle invalid file type
                    header('Location: ' . ROOT . '/manager/advertisements');
                    return;
                }
            }

            // Create advertisement with image data
            $this->advertisementModel->createAdvertisement([
                'adTitle' => $adTitle,
                'advertiserID' => $advertiserID,
                'adDescription' => $adDescription,
                'link' => $link,
                'adStatus' => $adStatus,
                'img' => $imageData, // Binary image data
                'adDate' => $adDate,
                'adTime' => $adTime,
                'clicks' => 0 // Default clicks count
            ]);

            header('Location: ' . ROOT . '/manager/advertisements');
        }
    }

    public function deleteAdvertisement($id) {
        $this->advertisementModel->delete($id);
        header('Location: ' . ROOT . '/manager/advertisements');
    }
}
