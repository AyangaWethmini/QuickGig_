<?php 
class PaymentController extends Controller {
    public function __construct() {
        // Initialize models if needed
    }

    public function createCheckoutSession() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            exit;
        }

        try {
            // Validate required data
            $required = ['advertisementID', 'amount', 'adTitle'];
            foreach ($required as $field) {
                if (!isset($_POST[$field])) {
                    throw new Exception("Missing required field: $field");
                }
            }

            // Initialize Stripe
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => 'Advertisement: ' . trim($_POST['adTitle']),
                        ],
                        'unit_amount' => $_POST['amount'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => ROOT . '/payment/success?session_id={CHECKOUT_SESSION_ID}&ad_id=' . $_POST['advertisementID'],
                'cancel_url' => ROOT . '/payment/canceled?ad_id=' . $_POST['advertisementID'],
                'metadata' => [
                    'advertisement_id' => $_POST['advertisementID']
                ]
            ]);

            echo json_encode([
                'status' => 'payment_required',
                'redirectUrl' => $session->url
            ]);
        } catch (Exception $e) {
            error_log("Payment error: " . $e->getMessage());
            echo json_encode(['error' => 'Payment processing failed']);
        }
    }

    public function success() {
        $session_id = $_GET['session_id'] ?? null;
        $ad_id = $_GET['ad_id'] ?? null;
        
        if (!$session_id || !$ad_id) {
            $_SESSION['error'] = "Invalid payment confirmation.";
            header('Location: ' . ROOT . '/advertisements');
            exit;
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            
            if ($session->payment_status == 'paid') {
                // Update payment status - you'll need to access your model here
                // $this->advertisementModel->updatePaymentStatus($ad_id, 'paid');
                
                $_SESSION['success'] = "Payment successful! Your advertisement is now active.";
            } else {
                $_SESSION['error'] = "Payment not completed. Please try again.";
            }
        } catch (Exception $e) {
            error_log("Stripe error: " . $e->getMessage());
            $_SESSION['error'] = "Error verifying payment. Please contact support.";
        }
        
        header('Location: ' . ROOT . '/advertisements');
        exit;
    }

    public function canceled() {
        $ad_id = $_GET['ad_id'] ?? null;
        
        if ($ad_id) {
            // Update payment status to failed
            // $this->advertisementModel->updatePaymentStatus($ad_id, 'failed');
        }
        
        $_SESSION['error'] = "Payment was canceled. Your advertisement is pending payment.";
        header('Location: ' . ROOT . '/advertisements');
        exit;
    }
}