<?php
class Manager extends Controller {
    protected $viewPath = "../app/views/manager/";
    protected $advertisementModel;
    protected $planModel;
    protected $helpModel;
    protected $announcementModel;
    protected $advertiserModel;

    public function __construct(){
        $this->advertisementModel = $this->model('Advertisement');
        $this->planModel = $this->model('Plans');
        $this->helpModel = $this->model('Help');
        $this->announcementModel = $this->model('AdminModel');
        $this->advertiserModel = $this->model('Advertiser');
    }

    public function index(){
        $adCount = $this->advertisementModel->getAdsCount();
        $planCount = $this->planModel->getPlansCount();
        $data = [
            'adCount' => $adCount,
            'planCount' => $planCount
        ];
        $this->view('dashboard', $data);
    }

    public function profile(){
        $this->view('profile');
    }

    public function announcements(){
        $data = $this->announcementModel->getAnnouncements();
        $this->view('announcements', ['announcements' => $data]);
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
        $data = $this->advertiserModel->getAdvertisers();
        $this->view('createAd');
    }

    public function updateAd($id){
        $data = $this->advertisementModel->getAdById($id);
        $this->view('updateAd', ['ad' => $data]);
    }

    public function postAdvertisement() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //form validation
            if (!isset($_POST['advertiserName']) || !isset($_POST['contact']) || !isset($_POST['email']) || !isset($_POST['adTitle']) || !isset($_POST['adDescription']) || !isset($_POST['link']) || !isset($_POST['adStatus']) || !isset($_FILES['adImage']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
                $_SESSION['error'] = "All fields are required.";
                header('Location: ' . ROOT . '/manager/advertisements');
                return;
            }

            $advertiserName = trim($_POST['advertiserName']);
            $contact = trim($_POST['contact']);
            $email = trim($_POST['email']);

            //retriving the advertiser ID. if not exist create an advertiser profile
            $getAdvId = $this->advertiserModel->isAdvertiserExist($email);
            if ($getAdvId == null) {
                $this->advertiserModel->createAdvertiser([
                        'advertiserName' => $advertiserName,
                        'contact' => $contact,
                        'email' => $email
                    ]
                );
                $_SESSION['success'] = "Advertiser profile created successfully.";

                $getAdvId = $this->advertiserModel->isAdvertiserExist($email);
            }

            // Get form data
            $advertiserID = $getAdvId; 
            $adTitle = trim($_POST['adTitle']);
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $startDate = trim($_POST['startDate']);
            $endDate = trim($_POST['endDate']);
            $adStatus = intval($_POST['adStatus']);

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
                'advertiserID' => $advertiserID,
                'adTitle' => $adTitle,
                'adDescription' => $adDescription,
                'adImage' => $imageData,
                'link' => $link,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'adStatus' => $adStatus,                
            ]);

            header('Location: ' . ROOT . '/manager/createAd');
            $_SESSION['success'] = "Advertisement created successfully.";
            exit;

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
            // Validation: Ensure reply is not empty
            if (empty(trim($_POST['reply']))) {
                $_SESSION['error'] = "Reply cannot be empty.";
                header('Location: ' . ROOT . '/manager/helpCenter');
                exit;
            }
    
            $reply = trim($_POST['reply']);
    
            $updateData = [
                'reply' => $reply
            ];
    
            if ($this->helpModel->replyToQuestion($id, $updateData)) {
                $_SESSION['success'] = "Reply submitted successfully.";
            } else {
                $_SESSION['error'] = "Failed to submit reply.";
            }
    
            header('Location: ' . ROOT . '/manager/helpCenter');
            exit;
        }
    }
    
}




