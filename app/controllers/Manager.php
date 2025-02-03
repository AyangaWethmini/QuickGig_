<?php
class Manager extends Controller {
    protected $viewPath = "../app/views/manager/";
    protected $advertisementModel;
    protected $planModel;
    protected $helpModel;

    public function __construct(){
        $this->advertisementModel = $this->model('Advertisement');
        $this->planModel = $this->model('Plans');
        $this->helpModel = $this->model('Help');
    }

    public function index(){
        $this->view('dashboard');
    }

    public function profile(){
        $this->view('profile');
    }

    public function announcements(){
        $this->view('announcements');
    }

    public function helpCenter(){
        $data = $this->helpModel->getAllQuestions();
        $this->view('helpCenter', ['questions' => $data]);
    }

    public function plans(){
        $data = $this->planModel->getPlans();
        $this->view('plans', ['plans' => $data]);
    }

    public function settings(){
        $this->view('settings');
    }

    public function advertisements() {
        $data = $this->advertisementModel->getAdvertisements();
        $this->view('advertisements', ['advertisements' => $data]);
    }


    public function createAd(){
        $this->view('createAd');
    }

    public function updateAd($id){
        $data = $this->advertisementModel->getAdById($id);
        $this->view('updateAd', ['ad' => $data]);
    }

    public function postAdvertisement() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //form validation
            if (!isset($_POST['adTitle']) || !isset($_POST['adDescription']) || !isset($_POST['link']) || !isset($_POST['adStatus']) || !isset($_FILES['adImage']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
                header('Location: ' . ROOT . '/manager/advertisements');
                return;
            }

            // Get form data
            $adTitle = trim($_POST['adTitle']);
            $advertiserID = 1; // Default for now
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $adStatus = intval($_POST['adStatus']);
            $adDate = date('Y-m-d');
            $adTime = date('H:i:s');
            $duration = intval($_POST['duration']);
            $startDate = trim($_POST['startDate']);
            $endDate = trim($_POST['endDate']);

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
                'duration' => $duration,
                'img' => $imageData,
                'adDate' => $adDate,
                'adTime' => $adTime,
                'clicks' => 0,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

            header('Location: ' . ROOT . '/manager/advertisements');
        }
    }
    // delete advertisement
    public function deleteAdvertisement($id) {
        $this->advertisementModel->delete($id);
        header('Location: ' . ROOT . '/manager/advertisements');
    }


    // update advertisement
    public function updateAdvertisement($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validation
            if (!isset($_POST['adTitle']) || !isset($_POST['adDescription']) || !isset($_POST['link']) || !isset($_POST['adStatus'])) {
                header('Location: ' . ROOT . '/manager/advertisements');
                return;
            }

            $adTitle = trim($_POST['adTitle']);
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $adStatus = intval($_POST['adStatus']);
            $duration = intval($_POST['duration']);
            //  updateData without the image field
            $updateData = [
                'adTitle' => $adTitle,
                'duration' => $duration,
                'adDescription' => $adDescription,
                'link' => $link,
                'adStatus' => $adStatus
            ];

            // Only update image if a new one was uploaded
            if (isset($_FILES['adImage']) && $_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($_FILES['adImage']['tmp_name']);
                
                if (in_array($fileType, $allowedTypes)) {
                    $updateData['img'] = file_get_contents($_FILES['adImage']['tmp_name']);
                }
            } else {
                // Get existing advertisement data
                $existingAd = $this->advertisementModel->getAdById($id);
                if ($existingAd && isset($existingAd->img)) {
                    $updateData['img'] = $existingAd->img;
                }
            }

            $this->advertisementModel->update($id, $updateData);
            header('Location: ' . ROOT . '/manager/advertisements');
        }
    }


    //-------------------Plans----------------------

    public function createPlan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate required fields
            $requiredFields = ['planName', 'description', 'duration', 'price', 'postLimit'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    $_SESSION['error'] = "All fields are required";
                    header('Location: ' . ROOT . '/manager/plans');
                    return;
                }
            }
    
            // Validate numeric fields
            if (!is_numeric($_POST['duration']) || !is_numeric($_POST['price']) || !is_numeric($_POST['postLimit'])) {
                $_SESSION['error'] = "Duration, price, and post limit must be numeric values";
                header('Location: ' . ROOT . '/manager/plans');
                return;
            }
    
            try {
                // Get and sanitize form data
                $planName = trim($_POST['planName']);
                $description = trim($_POST['description']);
                $duration = intval($_POST['duration']);
                $price = floatval($_POST['price']);
                $postLimit = intval($_POST['postLimit']);
                $badge = isset($_POST['badge']) ? 1 : 0;
    
                // Create the plan
                $result = $this->planModel->createPlan([
                    'planName' => $planName,
                    'description' => $description,
                    'duration' => $duration,
                    'price' => $price,
                    'badge' => $badge,
                    'postLimit' => $postLimit
                ]);
    
                if ($result) {
                    $_SESSION['success'] = "Plan created successfully";
                } else {
                    $_SESSION['error'] = "Failed to create plan";
                }
    
            } catch (Exception $e) {
                $_SESSION['error'] = "An error occurred while creating the plan";
                error_log($e->getMessage());
            }
    
            header('Location: ' . ROOT . '/manager/plans');
            return;
        }
    
        // If not POST request, redirect to plans page
        header('Location: ' . ROOT . '/manager/plans');
    }

    // delete plan
    public function deletePlan($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check for POST request
            $this->planModel->deletePlan($id);
            header('Location: '.ROOT. '/manager/plans');
        } else {
            // Handle the case where the request method is not POST
            header('Location: '.ROOT. '/manager/plans');
        }
    }

    //--------------------Help-------------------------

    public function reply($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validation
            if (!isset($_POST['reply'])) {
                header('Location: ' . ROOT . '/manager/helpCenter');
                return;
            }

            $reply = trim($_POST['reply']);

            $updateData = [
                'reply' => $reply
            ];
            $this->helpModel->replyToQuestion($id, $updateData); 
            header('Location: ' . ROOT . '/manager/helpCenter'); 
        }
    }
}




