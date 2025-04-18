<?php

date_default_timezone_set('Asia/Colombo');

class Manager extends Controller
{
    protected $viewPath = "../app/views/manager/";
    protected $advertisementModel;
    protected $planModel;
    protected $helpModel;
    protected $announcementModel;
    protected $advertiserModel;
    protected $accountModel;
    protected $accountSubscriptionModel; // Assuming you have this model for subscriptions
    protected $managerModel;

    public function __construct()
    {
        $this->advertisementModel = $this->model('Advertisement');
        $this->planModel = $this->model('Plans');
        $this->helpModel = $this->model('Help');
        $this->announcementModel = $this->model('AdminModel');
        $this->advertiserModel = $this->model('Advertiser');
        $this->accountModel = $this->model('Account');
        $this->accountSubscriptionModel = $this->model('AccountSubscription'); 
        $this->managerModel = $this->model('ManagerModel');
    }

    public function index()
    {
        // $adCount = $this->advertisementModel->getAdsCount();
        // $planCount = $this->planModel->getPlansCount();
        // $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : null;
        // $endDate = isset($_POST['endDate']) ? trim($_POST['endDate']) : null;
        //$subsCount = $this->accountSubscriptionModel->getSubscriptionCount($startDate, $endDate);
        
        
        $this->view('dashboard');
    }

    public function profile()
    {
        $accountID = $_SESSION['user_id'];
        $data = $this->managerModel->getManagerData($accountID);
        $this->view('profile', ['manager' => $data]);
    }

    public function announcements()
    {
        $data = $this->announcementModel->getAnnouncements();
        $this->view('announcements', ['announcements' => $data]);
    }

    public function helpCenter()
    {
        $data = $this->helpModel->getAllQuestions();
        $this->view('helpCenter', ['questions' => $data]);
    }

    public function plans()
    {
        $data = $this->planModel->getPlans();
        $subs = $this->accountSubscriptionModel->getActiveSubscriptions();
        $this->view('plans', ['plans' => $data, 'subs' => $subs]);
    }

    public function settings()
    {
        $this->view('settings');
    }

    public function advertisements()
    {
        $data = $this->advertisementModel->getAdvertisements();
        $this->view('advertisements', ['advertisements' => $data]);
    }


    public function createAd()
    {
        $data = $this->advertiserModel->getAdvertisers();
        $this->view('createAd');
    }

    public function updateAd($id)
    {
        $data = $this->advertisementModel->getAdById($id);
        $this->view('updateAd', ['ad' => $data]);
    }


    public function report()
    {
        $this->view('report');
    }

    public function postAdvertisement()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Form validation
        $requiredFields = [
            'advertiserName',
            'contact',
            'email',
            'adTitle',
            'adDescription',
            'link',
            'adStatus',
            'startDate',
            'endDate'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $_SESSION['error'] = "All fields are required.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

        if (!isset($_FILES['adImage']) || $_FILES['adImage']['error'] === UPLOAD_ERR_NO_FILE) {
            $_SESSION['error'] = "Advertisement image is required.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }

        // Clean input data
        $advertiserName = trim($_POST['advertiserName']);
        $contact = trim($_POST['contact']);
        $email = trim($_POST['email']);

        // Get existing advertiser ID
        $advertiserId = $this->advertiserModel->isAdvertiserExist($email);
        if ($advertiserId === null) {
            $advertiserData = [
                'advertiserName' => $advertiserName,
                'contact' => $contact,
                'email' => $email
            ];

            $this->advertiserModel->createAdvertiser($advertiserData);

            // Fetch the newly created advertiser ID
            $advertiserId = $this->advertiserModel->isAdvertiserExist($email);
            if ($advertiserId === null) {
                $_SESSION['error'] = "Failed to retrieve advertiser ID after creation.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

        // Handle image upload
        $imageData = null;
        if ($_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['adImage']['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "Invalid image type. Allowed types: JPEG, PNG, GIF";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }

            $imageData = file_get_contents($_FILES['adImage']['tmp_name']);
            if ($imageData === false) {
                $_SESSION['error'] = "Failed to read image file.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

        // Prepare advertisement data
        $advertisementData = [
            'advertiserID' => $advertiserId,
            'adTitle' => trim($_POST['adTitle']),
            'adDescription' => trim($_POST['adDescription']),
            'adImage' => $imageData,
            'link' => trim($_POST['link']),
            'startDate' => trim($_POST['startDate']),
            'endDate' => trim($_POST['endDate']),
            'adStatus' => ($_POST['adStatus'] == 1) ? 'active' : 'inactive'
        ];

        // Create advertisement
        if (!$this->advertisementModel->createAdvertisement($advertisementData)) {
            $_SESSION['error'] = "Failed to create advertisement.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }

        $_SESSION['success'] = "Advertisement created successfully.";
        header('Location: ' . ROOT . '/manager/advertisement');
        exit;
    }



    // update advertisement
    public function updateAdvertisement($id)
    {
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

    //add clicks to the ads
    public function click($adId)
    {
        if (isset($adId) && is_numeric($adId)) {
            $result = $this->advertisementModel->recordClick($adId);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Click recorded successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to record click']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ad ID']);
        }
    }

    public function adView($adId){
        if (isset($adId) && is_numeric($adId)) {
            $result = $this->advertisementModel->addView($adId);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Click recorded successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to record click']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ad ID']);
        }
    }

    //-------------------Plans----------------------

    public function createPlan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Clear any existing session errors
            unset($_SESSION['error']);
            unset($_SESSION['success']);

            $requiredFields = ['planName', 'description', 'duration', 'price', 'postLimit', 'currency', 'recInterval'];
    
            // Validate required fields
            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $_POST) || trim($_POST[$field]) === '') {
                    $_SESSION['error'] = "The field '" . $field . "' is required.";
                    header('Location: ' . ROOT . '/manager/plans');
                    exit;
                }
            }

            // Validate numeric fields
            if (!is_numeric($_POST['duration']) || !is_numeric($_POST['price']) || !is_numeric($_POST['postLimit'])) {
                $_SESSION['error'] = "Duration, price, and post limit must be numeric.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }

            if (isset($_POST['stripe_price_id']) && !preg_match('/^price_[a-zA-Z0-9]{14,}$/', $_POST['stripe_price_id'])) {
                $_SESSION['error'] = "Invalid Stripe price ID format.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }
    
            // Validate currency
            if (strlen(trim($_POST['currency'])) !== 3) {
                $_SESSION['error'] = "Currency must be a 3-letter code.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }
    
            // Additional string length checks
            if (strlen(trim($_POST['planName'])) > 20) {
                $_SESSION['error'] = "Plan name must be 20 characters or fewer.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }
    
            if (strlen(trim($_POST['description'])) > 1000) {
                $_SESSION['error'] = "Description must be 1000 characters or fewer.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }
    
            // Prepare sanitized data
            $data = [
                'planName' => trim($_POST['planName']),
                'description' => trim($_POST['description']),
                'duration' => intval($_POST['duration']),
                'price' => floatval($_POST['price']),
                'postLimit' => intval($_POST['postLimit']),
                'badge' => isset($_POST['badge']) ? 1 : 0,
                'stripe_price_id' => isset($_POST['stripe_price_id']) ? trim($_POST['stripe_price_id']) : null,
                'currency' => strtoupper(trim($_POST['currency'])),
                'recInterval' => trim($_POST['recInterval']),
                'active' => isset($_POST['active']) ? 1 : 0
            ];
    
            try {
                $result = $this->planModel->createPlan($data);
    
                if ($result) {
                    $_SESSION['success'] = "Plan created successfully.";
                } else {
                    $_SESSION['error'] = "Failed to create the plan.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error creating plan: " . $e->getMessage();
                error_log($e->getMessage());
            }
    
            header('Location: ' . ROOT . '/manager/plans');
            exit;
        }
    
        header('Location: ' . ROOT . '/manager/plans');
        exit;
    }

    // delete plan
    public function deletePlan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check for POST request
            $this->planModel->deletePlan($id);
            header('Location: ' . ROOT . '/manager/plans');
        } else {
            // Handle the case where the request method is not POST
            header('Location: ' . ROOT . '/manager/plans');
        }
    }

    //update plan
    public function updatePlanForm($id)
    {
        $data = $this->planModel->getPlanById($id);
        $this->view('updatePlanForm', ['plan' => $data]);
    }

    public function updatePlan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Clear any existing session errors
            unset($_SESSION['error']);
            unset($_SESSION['success']);

            // Validation: Ensure required fields are present and not empty
            $requiredFields = ['planName', 'description', 'duration', 'price', 'postLimit'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    $_SESSION['error'] = "The field '" . $field . "' is required.";
                    header('Location: ' . ROOT . '/manager/plans');
                    exit;
                }
            }

            if (isset($_POST['stripe_price_id']) && trim($_POST['stripe_price_id']) !== '') {
                if (!preg_match('/^price_[a-zA-Z0-9]{14,}$/', $_POST['stripe_price_id'])) {
                    $_SESSION['error'] = "Invalid Stripe price ID format.";
                    header('Location: ' . ROOT . '/manager/updatePlanForm/' . $id);
                    exit;
                }
                $updateData['stripe_price_id'] = trim($_POST['stripe_price_id']);
            } else {
                $updateData['stripe_price_id'] = null;
            }

            // Validate numeric fields
            if (!is_numeric($_POST['duration']) || !is_numeric($_POST['price']) || !is_numeric($_POST['postLimit'])) {
                $_SESSION['error'] = "Duration, price, and post limit must be numeric.";
                header('Location: ' . ROOT . '/manager/updatePlanForm.' . $id);
                exit;
            }

            // Validate string length for plan name and description
            if (strlen(trim($_POST['planName'])) > 20) {
                $_SESSION['error'] = "Plan name must be 20 characters or fewer.";
                header('Location: ' . ROOT . '/manager/updatePlanForm'. $id);
                exit;
            }

            if (strlen(trim($_POST['description'])) > 1000) {
                $_SESSION['error'] = "Description must be 1000 characters or fewer.";
                header('Location: ' . ROOT . '/manager/updatePlanForm'. $id);
                exit;
            }

            // Prepare update data
            $updateData = [
                'planName' => trim($_POST['planName']),
                'description' => trim($_POST['description']),
                'duration' => intval($_POST['duration']),
                'price' => floatval($_POST['price']),
                'postLimit' => intval($_POST['postLimit']),
                'badge' => isset($_POST['badge']) ? 1 : 0,
                'active' => isset($_POST['active']) ? 1 : 0
            ];

            // Attempt to update the plan
            try {
                $result = $this->planModel->update($id, $updateData);
                if ($result) {
                    $_SESSION['success'] = "Plan updated successfully.";
                } else {
                    $_SESSION['error'] = "Failed to update the plan.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error updating plan: " . $e->getMessage();
                error_log($e->getMessage());
            }

            header('Location: ' . ROOT . '/manager/plans');
            exit;
        }

        // Redirect if not a POST request
        header('Location: ' . ROOT . '/manager/plans');
        exit;
    }


    //--------------------Help-------------------------

    public function reply($id)
    {
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



    public function getDashboardData() {
        // Get the start and end date from the POST request
        $data = json_decode(file_get_contents('php://input'), true);
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
    
        // Fetch data from your database using the functions
        $adCount = $this->advertisementModel->getAdsCountDateRange($startDate, $endDate);
        $adRev = $this->advertisementModel->getAdRev($startDate, $endDate);
        $subRevData = $this->accountSubscriptionModel->getSubRev($startDate, $endDate);
        $planCount = $this->planModel->getPlansCount();
        $manager = $this->managerModel->getManagerName($_SESSION['accountID']);
    
        // Prepare the response data
        $response = [
            'success' => true,
            'adCount' => $adCount,
            'revenue' => $adRev,
            'subsCount' => $subRevData['active_subscriptions'],
            'subRevenue' => $subRevData['total_revenue'],
            'planCount' => $planCount,
            'managerName' => $manager ? $manager->fname : 'Manager'
        ];
    
        // Return data as a JSON response
        echo json_encode($response);
    }
    
    
}
