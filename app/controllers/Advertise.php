<?php
class Advertise extends Controller {
    private $advertisementModel;
    private $advertiserModel;

    protected $viewPath = "../app/views/advertise/";
    private const DEBUG_MODE = true; // Toggle to false in production

    public function __construct() {
        $this->advertisementModel = $this->model('Advertisement');
        $this->advertiserModel = $this->model('Advertiser');
    }

    public function index() {
        $this->view('create');
    }

    public function postAdvertisement() {
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->respondWithError("Invalid request method.");
        }
    
        $requiredFields = [
            'advertiserName', 'contact', 'email', 'adTitle', 'adDescription',
            'link', 'startDate', 'endDate'
        ];
    
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return $this->respondWithError("Field '{$field}' is required.");
            }
        }
    
        if (!preg_match('/^07\d{8}$/', $_POST['contact'])) {
            return $this->respondWithError("Invalid contact number. Format: 07XXXXXXXX");
        }
    
        $start = strtotime($_POST['startDate']);
        $end = strtotime($_POST['endDate']);
    
        if (!$start || !$end || $start >= $end) {
            return $this->respondWithError("Start date must be earlier than end date.");
        }
    
        if (!isset($_FILES['adImage']) || $_FILES['adImage']['error'] === UPLOAD_ERR_NO_FILE) {
            return $this->respondWithError("Advertisement image is required.");
        }
    
        $fileType = mime_content_type($_FILES['adImage']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            return $this->respondWithError("Invalid image type. Only JPEG, PNG, and GIF allowed.");
        }
    
        if ($_FILES['adImage']['size'] > 5 * 1024 * 1024) {
            return $this->respondWithError("Image file is too large. Max 5MB allowed.");
        }
    
        $imageData = file_get_contents($_FILES['adImage']['tmp_name']);
        if (!$imageData) {
            return $this->respondWithError("Failed to process image file.");
        }
    
        try {
            $advertiserId = $this->advertiserModel->isAdvertiserExist($_POST['email']);
            if (!$advertiserId) {
                $created = $this->advertiserModel->createAdvertiser([
                    'advertiserName' => trim($_POST['advertiserName']),
                    'contact' => trim($_POST['contact']),
                    'email' => trim($_POST['email'])
                ]);
                if (!$created) {
                    return $this->respondWithError("Failed to create new advertiser.");
                }
                $advertiserId = $this->advertiserModel->isAdvertiserExist($_POST['email']);
            }
    
            $adId = uniqid("AD", true);
            $startDate = new DateTime($_POST['startDate']);
            $endDate = new DateTime($_POST['endDate']);
            $weeks = ceil($startDate->diff($endDate)->days / 7);
            $amount = $weeks * 1000;
    
            $adData = [
                'advertisementID' => $adId,
                'advertiserID' => $advertiserId,
                'adTitle' => trim($_POST['adTitle']),
                'adDescription' => trim($_POST['adDescription']),
                'img' => $imageData,
                'link' => trim($_POST['link']),
                'startDate' => $_POST['startDate'],
                'endDate' => $_POST['endDate'],
                'amount' => $amount,
                'paymentStatus' => 'pending',
                'adStatus' => 'inactive' // Optional: set default
            ];
    
            if (!$this->advertisementModel->createAdvertisement($adData)) {
                error_log("Ad DB creation failed: " . print_r($adData, true));
                return $this->respondWithError("Failed to store advertisement.");
            }
    
            echo json_encode(['success' => true, 'message' => "Ad created. Awaiting payment."]);
        } catch (Exception $e) {
            http_response_code(500);
            error_log("Ad creation exception: " . $e->getMessage());
            $this->respondWithError("System error occurred during ad creation.", $e);
        }
    }
    

    public function paymentCanceled() {
        $ad_id = $_GET['ad_id'] ?? null;
        if ($ad_id) {
            $this->advertisementModel->updateAdStatus($ad_id, 'inactive');
        }
        return $this->renderPaymentView(false, "Payment was canceled.");
    }

    private function respondWithError($message, $exception = null) {
        header('Content-Type: application/json');
        http_response_code(400);
        if (self::DEBUG_MODE && $exception) {
            $message .= ' | Debug: ' . $exception->getMessage();
        }
        echo json_encode(['error' => $message]);
        exit;
    }

    private function renderPaymentView($success, $message) {
        $this->view('advertisement/paymentResult', [
            'success' => $success,
            'message' => $message
        ]);
    }
}
