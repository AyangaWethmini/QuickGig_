<?php
class Advertise extends Controller {
    private $advertisementModel;
    private $advertiserModel;

    protected $viewPath = "../app/views/advertise/";
    private const DEBUG_MODE = true;

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
                error_log("Ad DB creation failed: " . print_r($adData, true));
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
                'success_url' => ROOT . "/advertise/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}&ad_id={$adId}",
                'cancel_url' => ROOT . "/advertise/paymentCanceled?ad_id={$adId}",
                'metadata' => [
                    'advertisement_id' => $adId,
                    'advertiser_email' => $_POST['email']
                ]
            ]);

            // Update the advertisement status to 'active' after successful payment
            // $this->advertisementModel->updateAdStatus($adId, 'active'); //manager does this

            echo json_encode(['status' => 'payment_required', 'redirectUrl' => $session->url]);
            return;

        } catch (Exception $e) {
            http_response_code(500);
            error_log("Ad creation exception: " . $e->getMessage());
            return $this->respondWithError("System error occurred during ad creation.", $e);
        }
    }

    public function checkoutSuccess() {
        $session_id = $_GET['session_id'] ?? null;
        $ad_id = $_GET['ad_id'] ?? null;

        if (!$session_id || !$ad_id) {
            return $this->renderInvoiceView(false, "Invalid request.");
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            if ($session->payment_status === 'paid') {
                $this->advertisementModel->updatePaymentStatus($ad_id, 'paid');

                echo "<script>console.log('Advertisement details retrieved: " . json_encode($ad_id) . "');</script>";
                echo "<script>console.log('Session details retrieved: " . json_encode($this->advertisementModel->isAdExists($ad_id)) . "');</script>";
                // echo "<script>console.log('Session details retrieved: " . json_encode($session) . "');</script>";
                $advertisement = $this->advertisementModel->getAdDetailsWithoutImage($ad_id);
                echo "<script>console.log('Advertisement details retrieved: " . json_encode($advertisement) . "');</script>";

                if (!$advertisement) {
                    return $this->renderInvoiceView(false, "Advertisement not found.");
                }

                $invoiceData = [
                    'advertisement' => $advertisement,
                    'payment_status' => $session->payment_status,
                    'amount' => $session->amount_total / 100,
                    'session_id' => $session_id,
                    'ad_id' => $ad_id
                ];

                return $this->renderInvoiceView(true, "Payment successful. Your ad has been submitted.", $invoiceData);
            }

            return $this->renderInvoiceView(false, "Payment not completed.");
        } catch (Exception $e) {
            error_log("Stripe invoice error: " . $e->getMessage());
            return $this->renderInvoiceView(false, "Could not retrieve invoice details.");
        }
    }

    public function paymentCanceled() {
        $ad_id = $_GET['ad_id'] ?? null;
        if ($ad_id) {
            $this->advertisementModel->updateAdStatus($ad_id, 'inactive');
        }
        return $this->renderInvoiceView(false, "Payment was canceled.");
    }

    public function invoice() {
        $session_id = $_GET['session_id'] ?? null;
        $ad_id = $_GET['ad_id'] ?? null;

        if (!$session_id || !$ad_id) {
            return $this->renderInvoiceView(false, "Invalid invoice request.");
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            if ($session->payment_status === 'paid') {
                $advertisement = $this->advertisementModel->getAdDetailsWithoutImage($ad_id);

                if (!$advertisement) {
                    return $this->renderInvoiceView(false, "Advertisement not found.");
                }

                $invoiceData = [
                    'advertisement' => $advertisement,
                    'payment_status' => $session->payment_status,
                    'amount' => $session->amount_total / 100,
                    'session_id' => $session_id,
                    'ad_id' => $ad_id
                ];

                return $this->renderInvoiceView(true, "Invoice generated successfully.", $invoiceData);
            }

            return $this->renderInvoiceView(false, "Payment not completed.");
        } catch (Exception $e) {
            error_log("Stripe invoice error: " . $e->getMessage());
            return $this->renderInvoiceView(false, "Invoice generation failed.");
        }
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

    private function renderInvoiceView($success, $message, $invoiceData = null) {
        $this->view('invoice', [
            'success' => $success,
            'message' => $message,
            'invoiceData' => $invoiceData
        ]);
    }
}
