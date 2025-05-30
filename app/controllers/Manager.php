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
    protected $adminModel;

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
        $this->adminModel = $this->model('AdminModel');
    }

    public function index()
    {
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] . ' 00:00:00' : date('Y-m-01 00:00:00');
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] . ' 23:59:59' : date('Y-m-d 23:59:59');

        $subscriptionData = $this->systemReportModel->getSubscriptionRevenue($startDate, $endDate);

        $extractedData = [];

        if (is_array($subscriptionData)) {
            $extractedData = array_map(function ($item) {
                return [
                    'planName' => $item->planName,
                    'subscriptionCount' => $item->subscription_count
                ];
            }, $subscriptionData);
        } else {
            error_log("getSubscriptionRevenue() did not return an array. Check your DB query or model.");
        }


        
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
       
        $this->view('plans', ['plans' => $data]);
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

    public function advertisers()
    {
        $data = $this->advertiserModel->getAdvertisers();
        $this->view('advertisers', ['advertisers' => $data]);
    }

    public function subscriptions()
    {
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

        if ($subEarnings === false) {
            $_SESSION['error'] = "No subscription new subscribers during this period.";
        } elseif (empty($subEarnings)) {
            $_SESSION['warning'] = "No subscription revenue data found for the selected date range.";
        }

        if ($adRevenue === false) {
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
            $_SESSION['error'] = "Invalid request method.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }

       
        $advertisementID = uniqid("AD", true);

       
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

        if (!isset($_POST) || empty($_POST)) {
            $_SESSION['error'] = "Form data is missing.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }

       
        if (isset($_POST['startDate'], $_POST['endDate'])) {
            $startDate = strtotime($_POST['startDate']);
            $endDate = strtotime($_POST['endDate']);

            if ($startDate === false || $endDate === false || $startDate >= $endDate) {
                $_SESSION['error'] = "Start date must be earlier than end date.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $_POST) || trim($_POST[$field]) === '') {
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
        
        $contact = trim($_POST['contact']);
        if (!preg_match('/^07\d{8}$/', $contact)) {
            
            $_SESSION['error'] = "Invalid contact number. It must be in the format 07XXXXXXXX.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }
       
        $advertiserName = trim($_POST['advertiserName']);
        $contact = trim($_POST['contact']);
        $email = trim($_POST['email']);

        $advertiserId = $this->advertiserModel->isAdvertiserExist($email);


        
        if (!$advertiserId) {
            $newAdvertiserData = [
                'advertiserID' => $advertiserId,
                'advertiserName' => $advertiserName,
                'contact' => $contact,
                'email' => $email
            ];

            $this->advertiserModel->createAdvertiser($newAdvertiserData);

            $advertiserId = $this->advertiserModel->isAdvertiserExist($email);

           
            if (!$advertiserId) {
                error_log("Failed to create new advertiser. Email: " . $email);
                $_SESSION['error'] = "Failed to create new advertiser.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

      
        $imageData = null;
        if ($_FILES['adImage']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['adImage']['tmp_name']) ?: $_FILES['adImage']['type'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "Invalid image type. Allowed types: JPEG, PNG, GIF";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }

            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['adImage']['size'] > $maxSize) {
                $_SESSION['error'] = "Image file is too large. Maximum size is 5MB.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }

            $imageData = file_get_contents($_FILES['adImage']['tmp_name']);
            if ($imageData === false) {
                error_log("Failed to read image file: " . $_FILES['adImage']['tmp_name']);
                $_SESSION['error'] = "Failed to process image file.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }
        }

    
        $advertisementData = [
            'advertisementID' => $advertisementID,
            'advertiserID' => $advertiserId,
            'adTitle' => trim($_POST['adTitle']),
            'adDescription' => trim($_POST['adDescription']),
            'adImage' => $imageData,
            'link' => trim($_POST['link']),
            'startDate' => trim($_POST['startDate']),
            'endDate' => trim($_POST['endDate']),
            'adStatus' => ($_POST['adStatus'] == 1) ? 'active' : 'inactive'
        ];

        
        try {
            $result = $this->advertisementModel->createAdvertisement($advertisementData);

            if (!$result) {
                error_log("Advertisement creation failed. Data: " . print_r($advertisementData, true));
                $_SESSION['error'] = "Failed to create advertisement in database.";
                header('Location: ' . ROOT . '/manager/createAd');
                exit;
            }

            $_SESSION['success'] = "Advertisement created successfully.";
            header('Location: ' . ROOT . '/manager/advertisements');
            exit;
        } catch (Exception $e) {
            error_log("Exception in advertisement creation: " . $e->getMessage());
            $_SESSION['error'] = "System error occurred while creating advertisement.";
            header('Location: ' . ROOT . '/manager/createAd');
            exit;
        }
    }

    public function getAdvertiserByEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            if (empty($email)) {
                echo json_encode(['error' => 'Email is required.']);
                exit;
            }

            $advertiser = $this->advertiserModel->getAdvertiserByEmail($email);

            if ($advertiser) {
                echo json_encode(['advertiser' => $advertiser]);
            } else {
                echo json_encode(['error' => 'No advertiser found with this email.']);
            }
        } else {
            http_response_code(405); 
            echo json_encode(['error' => 'Invalid request method.']);
            exit;
        }
    }


    
    public function updateAdvertisement($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $requiredFields = ['adTitle', 'adDescription', 'link', 'startDate', 'endDate'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    $_SESSION['error'] = "The field '{$field}' is required.";
                    header('Location: ' . ROOT . '/manager/updateAd/' . $id);
                    exit;
                }
            }

           


            $adTitle = trim($_POST['adTitle']);
            $adDescription = trim($_POST['adDescription']);
            $link = trim($_POST['link']);
            $startDate = trim($_POST['startDate']);
            $endDate = trim($_POST['endDate']);
            $adStatus = isset($_POST['adStatus']) && $_POST['adStatus'] === 'active' ? 1 : 0;

            $updateData = [
                'adTitle' => $adTitle,
                'adDescription' => $adDescription,
                'link' => $link,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'adStatus' => $adStatus
            ];

            
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
                
                $existingAd = $this->advertisementModel->getAdById($id);
                if ($existingAd && isset($existingAd->img)) {
                    $updateData['img'] = $existingAd->img;
                }
            }

            
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



    public function incrementAdView($adId)
    {
        if (!is_numeric($adId)) {
            http_response_code(204);
            exit;
        }
        $this->advertisementModel->addView($adId);
        http_response_code(204);
        exit;
    }

    public function incrementAdClick($adId)
    {
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $this->advertisementModel->delete($id);
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['success'] = "Advertisement deleted successfully.";
        } else {
            
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['error'] = "Failed to delete advertisement.";
        }
    }


    public function deleteAdvertiser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->advertiserModel->delete($id);
            header('Location:'  . ROOT . '/manager/advertisements');
            $_SESSION['success'] = "Advertiser Deleted Successfully";
        } else {
            header('Location: ' . ROOT . '/manager/advertisements');
            $_SESSION['error'] = "Failed to delete advertiser.";
        }
    }

    //-------------------Plans----------------------

    public function createPlan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            
            unset($_SESSION['error']);
            unset($_SESSION['success']);

            $requiredFields = ['planName', 'description', 'duration', 'price', 'postLimit', 'currency', 'recInterval'];

           
            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $_POST) || trim($_POST[$field]) === '') {
                    $_SESSION['error'] = "The field '" . $field . "' is required.";
                    header('Location: ' . ROOT . '/manager/plans');
                    exit;
                }
            }

           
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

            
            if (strlen(trim($_POST['currency'])) !== 3) {
                $_SESSION['error'] = "Currency must be a 3-letter code.";
                header('Location: ' . ROOT . '/manager/plans');
                exit;
            }

            
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

    
    public function deletePlan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if (!$this->planModel->deletePlan($id)) {
                $_SESSION['error'] = "This plan cannot be deleleted as it has active subscribers.";
            } else {
                $_SESSION['success'] = "Plan deleted successfully.";
            }
            header('Location: ' . ROOT . '/manager/plans');
        } else {
            
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
            
            unset($_SESSION['error']);
            unset($_SESSION['success']);

            
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

            
            if (!is_numeric($_POST['duration']) || !is_numeric($_POST['price']) || !is_numeric($_POST['postLimit'])) {
                $_SESSION['error'] = "Duration, price, and post limit must be numeric.";
                header('Location: ' . ROOT . '/manager/updatePlanForm.' . $id);
                exit;
            }

            
            if (strlen(trim($_POST['planName'])) > 20) {
                $_SESSION['error'] = "Plan name must be 20 characters or fewer.";
                header('Location: ' . ROOT . '/manager/updatePlanForm' . $id);
                exit;
            }

            if (strlen(trim($_POST['description'])) > 1000) {
                $_SESSION['error'] = "Description must be 1000 characters or fewer.";
                header('Location: ' . ROOT . '/manager/updatePlanForm' . $id);
                exit;
            }

            
            $updateData = [
                'planName' => trim($_POST['planName']),
                'description' => trim($_POST['description']),
                'duration' => intval($_POST['duration']),
                'price' => floatval($_POST['price']),
                'postLimit' => intval($_POST['postLimit']),
                'badge' => isset($_POST['badge']) ? 1 : 0,
                'active' => isset($_POST['active']) ? 1 : 0
            ];

           
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

        header('Location: ' . ROOT . '/manager/plans');
        exit;
    }


    //--------------------Help-------------------------

    public function reply($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
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


    public function createAnnouncements($data)
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
            $this->adminModel->createannouncement($data, $adminId);
            $_SESSION['success'] = "Announcement created successfully.";
            header('Location: ' . ROOT . '/manager/announcements');
            exit;
        }
    }



    public function getDashboardData()
    {
       
        $data = json_decode(file_get_contents('php://input'), true);
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

       
        $adCount = $this->advertisementModel->getAdsCountDateRange($startDate, $endDate);
        $adRev = $this->advertisementModel->getAdRev($startDate, $endDate);
        $subRevData = $this->accountSubscriptionModel->getSubRev($startDate, $endDate);
        $planCount = $this->planModel->getPlansCount();
        $manager = $this->managerModel->getManagerName($_SESSION['accountID']);

       
        $response = [
            'success' => true,
            'adCount' => $adCount,
            'revenue' => $adRev,
            'subsCount' => $subRevData['active_subscriptions'],
            'subRevenue' => $subRevData['total_revenue'],
            'planCount' => $planCount,
            'managerName' => $manager ? $manager->fname : 'Manager'
        ];

        
        echo json_encode($response);
    }


    public function adsToBeReviewed()
    {
        $data = $this->advertisementModel->getAdsToBeReviewed();
        $this->view('adsToReview', ['ads' => $data]);
    }

    public function approveAd($adId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isApproved = $this->advertisementModel->approveAd($adId);
            $adDetails = $this->advertisementModel->getAdById($adId);
            if ($isApproved) {
                $advId = $_POST['advertiserID'];
                $advertiserEmail = $this->advertiserModel->getAdvertiserEmailById($advId);
                if ($advertiserEmail) {
                    $subject = "Your Advertisement Has Been Approved";
                    $message = "Dear Advertiser,\n\nYour advertisement titled '{$adDetails->adTitle}' has been successfully approved and is now live on our platform. \nThe advertisement will run from {$adDetails->startDate} to {$adDetails->endDate}. \nThe total amount paid for this advertisement is {$adDetails->amount}.\n\nThank you for choosing our service.\n\nBest regards,\nQuickGig Team";
                    $headers = "From: no-reply@quickgig.com";

                    if (!mail($advertiserEmail['email'], $subject, $message, $headers)) {
                        error_log("Failed to send email to advertiser: $advertiserEmail");
                    }
                }
                $_SESSION['success'] = "Advertisement approved successfully.";
            } else {
                $_SESSION['error'] = "Failed to approve advertisement.";
            }
            header('Location: ' . ROOT . '/manager/adsToBeReviewed');
            exit;
        } else {
            $_SESSION['error'] = "Failed to approve advertisement.";
            header('Location: ' . ROOT . '/manager/adsToBeReviewed');
            exit;
        }
    }


    public function rejectAd($adId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['advertiserID'])) {
                $isRejected = $this->advertisementModel->rejectAd($adId);

                if ($isRejected) {
                    $advId = $_POST['advertiserID'];
                    $advertiserEmail = $this->advertiserModel->getAdvertiserEmailById($advId);
                    if ($advertiserEmail) {
                        $subject = "Your Advertisement Has Been Rejected";
                        $message = "Dear Advertiser,\n\nWe regret to inform you that your advertisement has been rejected. Please note that the payment made for this advertisement is non-refundable.\n\nIf you have any questions or need further clarification, feel free to contact our support team.\n\nBest regards,\nQuickGig Team";
                        $headers = "From: no-reply@quickgig.com";

                        if (!mail($advertiserEmail['email'], $subject, $message, $headers)) {
                            error_log("Failed to send email to advertiser: " . $advertiserEmail['email']);
                        }
                    }
                    $_SESSION['success'] = "Advertisement rejected and email sent to the advertiser.";
                } else {
                    $_SESSION['error'] = "Failed to reject advertisement.";
                }
            } else {
                $_SESSION['error'] = "Advertiser ID is missing.";
            }
            header('Location: ' . ROOT . '/manager/adsToBeReviewed');
            exit;
        } else {
            $_SESSION['error'] = "Invalid request method.";
            header('Location: ' . ROOT . '/manager/adsToBeReviewed');
            exit;
        }
    }


    public function deleteAnnouncement($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->adminModel->delete($id);
            $_SESSION['success'] = "Announcement deleted successfully.";
            header('Location: ' . ROOT . '/manager/announcements');
            exit;
        } else {
            $_SESSION['error'] = "Failed to delete announcement.";
            header('Location: ' . ROOT . '/manager/announcements');
            exit;
        }
    }
}
