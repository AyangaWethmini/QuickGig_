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
    protected $accountSubscriptionModel;
    protected $managerModel;
    protected $systemReportModel; 
    protected $managerDashboardModel;

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
        $this->systemReportModel = $this->model('SystemReport');
        $this->managerDashboardModel = $this->model('ManagerDashboard');
    }

    public function index()
    {
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] . ' 00:00:00' : date('Y-m-01 00:00:00');
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] . ' 23:59:59' : date('Y-m-d 23:59:59');

        $subscriptionData = $this->systemReportModel->getSubscriptionRevenue($startDate, $endDate);
        $extractedData = array_map(function($item) {
            return [
            'planName' => $item->planName,
            'subscriptionCount' => $item->subscription_count
            ];
        }, $subscriptionData);

        // print_r($extractedData); // Debugging line
        $response = [
            'adCount' => $this->managerDashboardModel->adsPosted($startDate, $endDate),
            'subCount' => $this->managerDashboardModel->getSubscribersCount($startDate, $endDate),
            'planCount' => $this->managerDashboardModel->getPlanCount(),
            'revenue' => [
                'totalEarnings' => isset($this->systemReportModel->getSubscriptionRevenue($startDate, $endDate)[0]->total_earning) ? $this->systemReportModel->getSubscriptionRevenue($startDate, $endDate)[0]->total_earning : 0, // You'll need to sum this from getSubscriptionRevenue results
                'totalRevenue' => $this->systemReportModel->getAdsRevenue($startDate, $endDate)['totalRevenue']    // Same as above
            ],
            'adViews' => $this->managerDashboardModel->getTotalAdViews($startDate, $endDate),
            'adClicks' => $this->managerDashboardModel->getTotalAdClicks($startDate, $endDate),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'subscriptionData' => $extractedData,
            'mgrName' => $this->managerModel->getManagerName($_SESSION['user_id']),
        ];

       
        // print_r($response); // Debugging line

        

        $this->view('dashboard', $response);
    }

    public function profile()
    {
        $accountID = $_SESSION['user_id'];
        $data = $this->managerModel->getManagerData($accountID);
        $this->view('profile', ['manager' => $data]);
    }

    public function announcements()
    {
        $announcements = $this->announcementModel->getAnnouncements();
        $annCount = $this->announcementModel->getCount();
        $this->view('announcements', ['announcements' => $announcements, 'annCount' => $annCount]);   
    }

    public function createAnnouncement()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = trim($_POST['content']);
            $adminId = $_SESSION['user_id'];
            $announcementDate = date('Y-m-d');
            $announcementTime = date('H:i:s');
            $data = [
                'content' => $content,
                'announcementDate' => $announcementDate,
                'announcementTime' => $announcementTime
            ];
            $this->announcementModel->createAnnouncement($data, $adminId);
            $_SESSION['success'] = "Announcement created successfully.";
            header('Location: ' . ROOT . '/manager/announcements');
            exit;
        }
    }

    public function helpCenter()
    {
        $data = $this->helpModel->getAllQuestions();
        $this->view('helpCenter', ['questions' => $data]);
    }

    public function plans()
    {
        $data = $this->planModel->getPlans();
        // $subs = $this->accountSubscriptionModel->getActiveSubscriptions();
        $this->view('plans', ['plans' => $data]);
    }

    public function settings()
    {
        $this->view('settings');
    }

    public function advertisements()
    {
        // $advertisers = $this->advertiserModel->getAdvertisers();
        $data = $this->advertisementModel->getAdvertisements();
        $this->view('advertisements', ['advertisements' => $data]);
    }

    public function advertisers()
    {
        $data = $this->advertiserModel->getAdvertisers();
        $this->view('advertisers', ['advertisers' => $data]);
    }

    public function subscriptions(){
        $subs = $this->accountSubscriptionModel->getActiveSubscriptions();
        $this->view('subscriptions', ['subs' => $subs]);
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
    $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) . ' 00:00:00' : date('Y-m-01 00:00:00');
    $endDate = isset($_POST['endDate']) ? trim($_POST['endDate']) . ' 23:59:59' : date('Y-m-d 23:59:59');


    $adRevenue = $this->systemReportModel->getAdsRevenue($startDate, $endDate);
    $subEarnings = $this->systemReportModel->getSubscriptionRevenue($startDate, $endDate);
    $userCount = $this->systemReportModel->getUsers($startDate, $endDate);

    if($subEarnings === false) {
        $_SESSION['error'] = "Error fetching subscription revenue data.";
    } elseif(empty($subEarnings)) {
        $_SESSION['warning'] = "No subscription revenue data found for the selected date range.";
    }
    
    if($adRevenue === false) {
        $_SESSION['error'] = "Error fetching advertisement revenue data.";
    }
    
    $this->view('report', [
        'adRevenue' => is_array($adRevenue) ? $adRevenue : [],
        'subEarnings' => is_array($subEarnings) ? $subEarnings : [],
        'userCount' => $userCount,
        'startDate' => $startDate,
        'endDate' => $endDate
    ]);
}
public function postAdvertisement()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['error' => "Invalid request method."]);
        exit;
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
        'endDate',
    ];

    if (empty($_POST)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => "Form data is missing."]);
        exit;
    }

    // Validate dates
    if (isset($_POST['startDate'], $_POST['endDate'])) {
        $startDate = strtotime($_POST['startDate']);
        $endDate = strtotime($_POST['endDate']);

        if ($startDate === false || $endDate === false || $startDate >= $endDate) {
            header('Content-Type: application/json');
            echo json_encode(['error' => "Start date must be earlier than end date."]);
            exit;
        }
    }

    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $_POST) || trim($_POST[$field]) === '') {
            header('Content-Type: application/json');
            echo json_encode(['error' => "All fields are required."]);
            exit;
        }
    }

    if (!isset($_FILES['adImage']) || $_FILES['adImage']['error'] === UPLOAD_ERR_NO_FILE) {
        header('Content-Type: application/json');
        echo json_encode(['error' => "Advertisement image is required."]);
        exit;
    }

    if (!preg_match('/^07\d{8}$/', $_POST['contact'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => "Invalid contact number. It must be in the format 07XXXXXXXX."]);
        exit;
    }

    // Process advertiser
    $advertiserName = trim($_POST['advertiserName']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);

    $advertiserId = $this->advertiserModel->isAdvertiserExist($email);

    if (!$advertiserId) {
        $newAdvertiserData = [
            'advertiserName' => $advertiserName,
            'contact' => $contact,
            'email' => $email
        ];

        $this->advertiserModel->createAdvertiser($newAdvertiserData);
        $advertiserId = $this->advertiserModel->isAdvertiserExist($email);

        if (!$advertiserId) {
            error_log("Failed to create new advertiser. Email: " . $email);
            header('Content-Type: application/json');
            echo json_encode(['error' => "Failed to create new advertiser."]);
            exit;
        }
    }

    // Process image
    $imagePath = null;
    if ($_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['adImage']['tmp_name']) ?: $_FILES['adImage']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => "Invalid image type. Allowed types: JPEG, PNG, GIF"]);
            exit;
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($_FILES['adImage']['size'] > $maxSize) {
            header('Content-Type: application/json');
            echo json_encode(['error' => "Image file is too large. Maximum size is 5MB."]);
            exit;
        }

        // Generate unique filename
        $extension = pathinfo($_FILES['adImage']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('ad_') . '.' . $extension;
        $uploadDir = UPLOAD_ROOT . '/advertisements/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imagePath = $uploadDir . $filename;
        
        if (!move_uploaded_file($_FILES['adImage']['tmp_name'], $imagePath)) {
            error_log("Failed to move uploaded file: " . $_FILES['adImage']['tmp_name']);
            header('Content-Type: application/json');
            echo json_encode(['error' => "Failed to process image file."]);
            exit;
        }

        // Store relative path
        $imagePath = '/uploads/advertisements/' . $filename;
    }

    // Generate unique ID for the advertisement
    $advertisementID = uniqid("AD", true);

    // Calculate payment amount (1000 LKR per week)
    $start = new DateTime($_POST['startDate']);
    $end = new DateTime($_POST['endDate']);
    $days = $end->diff($start)->days;
    $weeks = ceil($days / 7);
    $amount = 1000 * $weeks;

    // Prepare advertisement data
    $advertisementData = [
        'advertisementID' => $advertisementID,
        'advertiserID' => $advertiserId,
        'adTitle' => trim($_POST['adTitle']),
        'adDescription' => trim($_POST['adDescription']),
        'img' => $imagePath,
        'link' => trim($_POST['link']),
        'startDate' => trim($_POST['startDate']),
        'endDate' => trim($_POST['endDate']),
        'adStatus' => ($_POST['adStatus'] == 1) ? 'pending_payment' : 'inactive',
        'amount' => $amount,
        'paymentStatus' => ($_POST['adStatus'] == 1) ? 'pending' : 'none'
    ];

    // Create advertisement in database first
    try {
        $result = $this->advertisementModel->createAdvertisement($advertisementData);

        if (!$result) {
            error_log("Advertisement creation failed. Data: " . print_r($advertisementData, true));
            header('Content-Type: application/json');
            echo json_encode(['error' => "Failed to create advertisement in database."]);
            exit;
        }

        // If payment is required (adStatus = 1)
        if ($_POST['adStatus'] == 1) {
            // Create Stripe Checkout Session
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            
            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => 'Advertisement: ' . $advertisementData['adTitle'],
                            'description' => 'From ' . $advertisementData['startDate'] . ' to ' . $advertisementData['endDate']
                        ],
                        'unit_amount' => $amount * 100, // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => ROOT . '/manager/advertisementPaymentSuccess?session_id={CHECKOUT_SESSION_ID}&ad_id=' . $advertisementID,
                'cancel_url' => ROOT . '/manager/advertisements?canceled=true',
                'metadata' => [
                    'advertisement_id' => $advertisementID,
                    'advertiser_id' => $advertiserId
                ]
            ]);

            // Return JSON response with redirect URL
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'payment_required',
                'redirectUrl' => $checkoutSession->url
            ]);
            exit;
        } else {
            // If no payment required (inactive status)
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

    } catch (Exception $e) {
        error_log("Exception in advertisement creation: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode(['error' => "System error occurred while creating advertisement."]);
        exit;
    }
}

public function advertisementPaymentSuccess()
{
    $sessionId = $_GET['session_id'] ?? null;
    $advertisementId = $_GET['ad_id'] ?? null;

    if (!$sessionId || !$advertisementId) {
        $_SESSION['error'] = 'Invalid payment confirmation';
        header('Location: ' . ROOT . '/manager/advertisements');
        exit;
    }

    try {
        // Verify the payment with Stripe
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            // Update advertisement status
            $this->advertisementModel->updateAdvertisementStatus($advertisementId, [
                'adStatus' => 'active',
                'paymentStatus' => 'paid',
                'paymentDate' => date('Y-m-d H:i:s'),
                'transactionId' => $session->payment_intent
            ]);

            $_SESSION['success'] = 'Advertisement and payment processed successfully!';
        } else {
            $_SESSION['error'] = 'Payment verification failed. Your advertisement is pending payment.';
        }
    } catch (Exception $e) {
        error_log("Payment verification error: " . $e->getMessage());
        $_SESSION['error'] = 'Error verifying payment. Please contact support.';
    }

    header('Location: ' . ROOT . '/manager/advertisements');
    exit;
}

    public function getAdvertiserByEmail(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = trim($_POST['email']);

            if(empty($email)){
                echo json_encode(['error' => 'Email is required.']);
                exit;
            }

            $advertiser = $this->advertiserModel->getAdvertiserByEmail($email);

            if($advertiser){
                echo json_encode(['advertiser' => $advertiser]);
            }else{
                echo json_encode(['error' => 'No advertiser found with this email.']);
            }
        }else{
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Invalid request method.']);
            exit;
        }
    }


    // update advertisement
    public function updateAdvertisement($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        $requiredFields = ['adTitle', 'adDescription', 'link', 'startDate', 'endDate'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $_SESSION['error'] = "The field '{$field}' is required.";
                header('Location: ' . ROOT . '/manager/updateAd/' . $id);
                exit;
            }
        }

        // Validate dates
       

        $adTitle = trim($_POST['adTitle']);
        $adDescription = trim($_POST['adDescription']);
        $link = trim($_POST['link']);
        $startDate = trim($_POST['startDate']);
        $endDate = trim($_POST['endDate']);
        $adStatus = isset($_POST['adStatus']) && $_POST['adStatus'] === 'active' ? 1 : 0;

        // Prepare update data
        $updateData = [
            'adTitle' => $adTitle,
            'adDescription' => $adDescription,
            'link' => $link,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'adStatus' => $adStatus
        ];

        // Handle image upload if provided
        if (isset($_FILES['adImage']) && $_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['adImage']['tmp_name']) ?: $_FILES['adImage']['type'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "Invalid image type. Allowed types: JPEG, PNG, GIF.";
                header('Location: ' . ROOT . '/manager/updateAd/' . $id);
                exit;
            }

            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['adImage']['size'] > $maxSize) {
                $_SESSION['error'] = "Image file is too large. Maximum size is 5MB.";
                header('Location: ' . ROOT . '/manager/updateAd/' . $id);
                exit;
            }

            $imageData = file_get_contents($_FILES['adImage']['tmp_name']);
            if ($imageData === false) {
                $_SESSION['error'] = "Failed to process the uploaded image.";
                header('Location: ' . ROOT . '/manager/updateAd/' . $id);
                exit;
            }

            $updateData['img'] = $imageData;
        } else {
            // Retain existing image if no new image is uploaded
            $existingAd = $this->advertisementModel->getAdById($id);
            if ($existingAd && isset($existingAd->img)) {
                $updateData['img'] = $existingAd->img;
            }
        }

        // Update advertisement in the database
        try {
            $this->advertisementModel->update($id, $updateData);
            $_SESSION['success'] = "Advertisement updated successfully.";
        } catch (Exception $e) {
            error_log("Error updating advertisement: " . $e->getMessage());
            $_SESSION['error'] = "Failed to update advertisement. Please try again.";
        }

        header('Location: ' . ROOT . '/manager/advertisements');
        exit;
    }

    $_SESSION['error'] = "Invalid request method.";
    header('Location: ' . ROOT . '/manager/advertisements');
    exit;
}

    

    public function incrementAdView($adId) {
        if (!is_numeric($adId)) {
            http_response_code(204);
            exit;
        }
        $this->advertisementModel->addView($adId);
        http_response_code(204);
        exit;
    }
    
    public function incrementAdClick($adId) {
        if (!is_numeric($adId)) {
            http_response_code(204);
            exit;
        }
        $this->advertisementModel->recordClick($adId);
        http_response_code(204);
        exit;
    }

    public function deleteAD($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check for POST request
            $this->advertisementModel->delete($id);
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['success'] = "Advertisement deleted successfully.";
        } else {
            // Handle the case where the request method is not POST
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['error'] = "Failed to delete advertisement.";
        }
    }


    public function deleteAdvertiser($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->advertiserModel->delete($id);
            header('Location:'  . ROOT . '/manager/advertisements');
            $_SESSION['success'] = "Advertiser Deleted Successfully";
        }else{
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['error'] = "Failed to delete advertiser.";
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
