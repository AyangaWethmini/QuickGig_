<?php

require_once '../app/services/StripeService.php';

class Subscription extends Controller {
    use Database;
    
    protected $viewPath = "../app/views/subscription/";
    protected $accountSubscriptionModel;
    protected $stripeService;
    protected $accountModel;
    private $db;
    protected $planModel;
    
    public function __construct() {
        $this->db = $this->connect();
        $this->accountSubscriptionModel = new AccountSubscription();
        $this->stripeService = new StripeService();
        $this->accountModel = $this->model('Account', $this->db);
        $this->planModel = $this->model('Plans');
    }

    public function index() {
        $data = $this->planModel->getPlans();
        $this->view('premium', ['plans' => $data]);
    }

    public function success() {
        $this->view('success', ['message' => 'Payment successful!']);
    }

    public function error() {
        $this->view('error', ['message' => 'Payment failed!']);
    }

    public function subscribe() {
        // Validate required session and post data
        if (!isset($_SESSION['user_id'], $_SESSION['user_email'], $_POST['priceID'])) {
            header('Location: ' . ROOT . "/home/login");
            exit;
        }
    
        $accountID = $_SESSION['user_id'];
        $email = $_SESSION['user_email'];
        $priceID = $_POST['priceID'];
    
        // Use the ensureStripeCustomer method to handle customer creation/retrieval
        $customerID = $this->accountSubscriptionModel->ensureStripeCustomer($accountID, $email);
        
        if (!$customerID) {
            $_SESSION['error'] = 'Failed to setup payment account';
            header('Location: ' . ROOT . '/subscription');
            exit;
        }
    
        // Create checkout session - now using the model's method
        $checkoutResult = $this->accountSubscriptionModel->createCheckoutSession(
            $accountID,
            $priceID
        );
    
        if (isset($checkoutResult['error'])) {
            $_SESSION['error'] = $checkoutResult['error'];
            header('Location: ' . ROOT . '/subscription');
            exit;
        }
    
        // Redirect to Stripe checkout
        header('Location: ' . $checkoutResult['checkout_url']);
        exit;
    }
    
    public function checkoutSuccess() {
        if (!isset($_GET['session_id'])) {
            $this->view('error', ['message' => 'Missing session ID']);
            return;
        }

        $sessionID = $_GET['session_id'];
        
        try {
            // Retrieve the session from Stripe
            $session = \Stripe\Checkout\Session::retrieve($sessionID);
            
            if (!$session || $session->payment_status !== 'paid') {
                $this->view('error', ['message' => 'Payment not completed']);
                return;
            }

            // Get subscription ID from the session
            $subscriptionID = $session->subscription;
            if (!$subscriptionID) {
                $this->view('error', ['message' => 'Subscription not found']);
                return;
            }

            // Retrieve the full subscription object
            $subscription = \Stripe\Subscription::retrieve($subscriptionID);
            
            $accountID = $session->metadata->accountID ?? null;
            $priceID = $session->metadata->priceID ?? $subscription->items->data[0]->price->id;

            if (!$accountID) {
                $this->view('error', ['message' => 'Account not found']);
                return;
            }

            // Create subscription record in database
            $result = $this->accountSubscriptionModel->createSubscription(
                $accountID, 
                $priceID, 
                $subscriptionID,
                $subscription->status,
                $subscription->current_period_start,
                $subscription->current_period_end
            );

            if (isset($result['error'])) {
                $this->view('error', ['message' => $result['error']]);
                return;
            }

            // Update user's plan
            $planMap = $this->getStripePlanMap();
            if (isset($planMap[$priceID])) {
                $this->accountModel->updatePlan($accountID, $planMap[$priceID]);
            }

            $this->view('success', ['message' => 'Subscription activated successfully!']);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log("Stripe Error: " . $e->getMessage());
            $this->view('error', ['message' => 'Error processing subscription']);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            $this->view('error', ['message' => 'An error occurred']);
        }
    }

    public function webhook() {
        $config = require '../app/core/stripe-config.php';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $config['webhook_secret']
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
                
            case 'customer.subscription.updated':
            case 'customer.subscription.created':
                $subscription = $event->data->object;
                $this->handleSubscriptionUpdate($subscription);
                break;
                
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->handleSubscriptionCancelled($subscription);
                break;
                
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    private function handleCheckoutSessionCompleted($session) {
        // This is already handled in checkoutSuccess, but can be used as backup
        if ($session->payment_status === 'paid' && $session->subscription) {
            $subscription = \Stripe\Subscription::retrieve($session->subscription);
            $this->handleSubscriptionUpdate($subscription);
        }
    }

    private function handleSubscriptionUpdate($subscription) {
        $customerID = $subscription->customer;
        $subscriptionID = $subscription->id;
        $status = $subscription->status;
        $priceID = $subscription->items->data[0]->price->id;
        
        // Get account ID from database
        $accountID = $this->accountSubscriptionModel->getAccountIDByCustomerID($customerID);
        if (!$accountID) return;

        // Update subscription in database
        $this->accountSubscriptionModel->updateSubscription(
            $subscriptionID,
            $status,
            $subscription->current_period_start,
            $subscription->current_period_end
        );

        // Update user plan if active
        if ($status === 'active') {
            $planMap = $this->getStripePlanMap();
            if (isset($planMap[$priceID])) {
                $this->accountModel->updatePlan($accountID, $planMap[$priceID]);
            }
        }
    }

    private function handleSubscriptionCancelled($subscription) {
        $subscriptionID = $subscription->id;
        $this->accountSubscriptionModel->updateSubscriptionStatus($subscriptionID, 'canceled');
        
        // Optionally downgrade user plan here
    }

    private function getStripePlanMap() {
        return [
            'price_1RBC4LFq0GU0Vr5TFeEmkI37' => 1, // individual
            'price_1RBC5KFq0GU0Vr5TMvpc9eDH' => 2, // organization
        ];
    }
}