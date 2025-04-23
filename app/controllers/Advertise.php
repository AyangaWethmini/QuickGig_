<?php
class Advertise extends Controller {
    protected $viewPath = "../app/views/advertise/";
    private $advertisementModel;
    private $advertiserModel;

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
                'paymentStatus' => 'pending'
            ];

            if (!$this->advertisementModel->createAdvertisementRecievedOnline($adData)) {
                return $this->respondWithError("Failed to store advertisement.");
            }

            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => ['name' => 'Ad: ' . $_POST['adTitle']],
                        'unit_amount' => $amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => ROOT . "/advertise/success?ad_id={$adId}",
                'cancel_url' => ROOT . "/advertise/cancel?ad_id={$adId}",
                'metadata' => [
                    'advertisement_id' => $adId,
                    'advertiser_email' => $_POST['email']
                ]
            ]);

            echo json_encode(['status' => 'payment_required', 'redirectUrl' => $session->url]);
            return;

        } catch (Exception $e) {
            http_response_code(500);
            return $this->respondWithError("System error occurred during ad creation.");
        }
    }

    public function success() {
        $ad_id = $_GET['ad_id'] ?? null;
        echo "<script>console.log('Ad ID: " . htmlspecialchars($ad_id, ENT_QUOTES, 'UTF-8') . "');</script>";
        if ($ad_id) {
            $updateSuccess = $this->advertisementModel->updatePaymentStatus($ad_id, 'paid');
            if (!$updateSuccess) {
                return $this->respondWithError("Failed to update payment status for advertisement ID: {$ad_id}.");
            }
        }
        $this->view('success');
    }

    public function cancel() {
        $ad_id = $_GET['ad_id'] ?? null;
        if ($ad_id) {
            $this->advertisementModel->updateAdStatus($ad_id, 'inactive');
        }
        $this->view('cancel');
    }

    private function respondWithError($message) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $message]);
        exit;
    }
}