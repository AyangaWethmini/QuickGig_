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

    public function cancelConfirm() {
        $this->view('cancel', ['message' => 'Payment cancelled!']);
    }

    public function subscribe() {
        if (!isset($_SESSION['user_id'], $_SESSION['user_email'], $_POST['priceID'], $_SESSION['user_role'])) {
            header('Location: ' . ROOT . "/home/login");
            exit;
        }

        $accountID = $_SESSION['user_id'];
        $email = $_SESSION['user_email'];
        $priceID = $_POST['priceID'];
        $userRole = $_SESSION['user_role'];

        // Role-based plan restriction
        $rolePlanMap = [
            2 => 'price_1RBC4LFq0GU0Vr5TFeEmkI37', // Role 2 -> Individual Plan
            3 => 'price_1RBC5KFq0GU0Vr5TMvpc9eDH', // Role 3 -> Organization Plan
        ];

        if (!isset($rolePlanMap[$userRole]) || $rolePlanMap[$userRole] !== $priceID) {
            $_SESSION['error'] = 'Your account in not eligible to subscribe to this plan';
            header('Location: ' . ROOT . '/subscription/premium');
            exit;
        }

        $customerID = $this->accountSubscriptionModel->ensureStripeCustomer($accountID, $email);
        
        if (!$customerID) {
            $_SESSION['error'] = 'Failed to setup payment account';
            header('Location: ' . ROOT . '/subscription/premium');
            exit;
        }

        $checkoutResult = $this->accountSubscriptionModel->createCheckoutSession(
            $accountID,
            $priceID
        );

        if (isset($checkoutResult['error'])) {
            $_SESSION['error'] = $checkoutResult['error'];
            header('Location: ' . ROOT . '/subscription/premium');
            exit;
        }

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
            $session = \Stripe\Checkout\Session::retrieve([
                'id' => $sessionID,
                'expand' => ['payment_intent', 'subscription']
            ]);
            
            if (!$session || $session->payment_status !== 'paid') {
                error_log("Payment failed for session: $sessionID");
                $this->view('error', ['message' => 'Payment not completed']);
                return;
            }

            if (!$session->subscription) {
                error_log("No subscription found for session: $sessionID");
                $this->view('error', ['message' => 'Subscription not found']);
                return;
            }

            $subscription = $session->subscription;
            $accountID = $session->metadata->accountID ?? null;
            $priceID = $session->metadata->priceID ?? $subscription->items->data[0]->price->id;

            if (!$accountID) {
                error_log("No account ID found in session metadata: $sessionID");
                $this->view('error', ['message' => 'Account not found']);
                return;
            }

            // Only create subscription if status is active or trialing
            if (!in_array($subscription->status, ['active', 'trialing'])) {
                error_log("Subscription not active: " . $subscription->status);
                $this->view('error', ['message' => 'Subscription is not active']);
                return;
            }

            $result = $this->accountSubscriptionModel->createSubscription(
                $accountID, 
                $priceID, 
                $subscription->id,
                $subscription->status,
                $subscription->current_period_start,
                $subscription->current_period_end
            );

            if (isset($result['error'])) {
                error_log("Subscription creation failed: " . $result['error']);
                $this->view('error', ['message' => $result['error']]);
                return;
            }

            $planMap = $this->getStripePlanMap();
            if (isset($planMap[$priceID])) {
                $this->accountModel->updatePlan($accountID, $planMap[$priceID]);
                $_SESSION['plan_id'] = $planMap[$priceID]; // Update session with plan ID
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
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                if ($session->payment_status === 'paid') {
                    $this->handleCheckoutSessionCompleted($session);
                }
                break;
                
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                if ($invoice->subscription) {
                    $this->handleSubscriptionPaymentSucceeded($invoice);
                }
                break;
                
            case 'customer.subscription.updated':
                $subscription = $event->data->object;
                $this->handleSubscriptionUpdate($subscription);
                break;
                
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->handleSubscriptionCancelled($subscription);
                break;

            
                
            default:
                error_log('Received unhandled event type: ' . $event->type);
        }

        http_response_code(200);
    }

    private function handleCheckoutSessionCompleted($session) {
        if ($session->payment_status === 'paid' && $session->subscription) {
            try {
                $subscription = \Stripe\Subscription::retrieve($session->subscription);
                if (in_array($subscription->status, ['active', 'trialing'])) {
                    $this->handleSubscriptionUpdate($subscription);
                }
            } catch (\Stripe\Exception\ApiErrorException $e) {
                error_log("Error retrieving subscription: " . $e->getMessage());
            }
        }
    }

    private function handleSubscriptionPaymentSucceeded($invoice) {
        try {
            $subscription = \Stripe\Subscription::retrieve($invoice->subscription);
            $this->handleSubscriptionUpdate($subscription);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log("Error handling payment succeeded: " . $e->getMessage());
        }
    }

    private function handleSubscriptionUpdate($subscription) {
        $customerID = $subscription->customer;
        $subscriptionID = $subscription->id;
        $status = $subscription->status;
        $priceID = $subscription->items->data[0]->price->id;
        
        $accountID = $this->accountSubscriptionModel->getAccountIDByCustomerID($customerID);
        if (!$accountID) {
            error_log("No account found for customer: $customerID");
            return;
        }

        $this->accountSubscriptionModel->updateSubscription(
            $subscriptionID,
            $status,
            $subscription->current_period_start,
            $subscription->current_period_end
        );

        if ($status === 'active') {
            $planMap = $this->getStripePlanMap();
            if (isset($planMap[$priceID])) {
                $this->accountModel->updatePlan($accountID, $planMap[$priceID]);
            }
        }
    }

    private function handleSubscriptionCancelled($subscription) {
        $subscriptionID = $subscription->id;
        $customerID = $subscription->customer;
        
        // Get account ID
        $accountID = $this->accountSubscriptionModel->getAccountIDByCustomerID($customerID);
        if (!$accountID) {
            error_log("No account found for customer: $customerID");
            return;
        }
        
        // Update only toBeCancelled flag (status remains active until period ends)
        $this->accountSubscriptionModel->updateSubscriptionCancellationFlag($subscriptionID, 1);
        
        error_log("Marked subscription $subscriptionID for cancellation via webhook");
    }

    private function getStripePlanMap() {
        return [
            'price_1RBC4LFq0GU0Vr5TFeEmkI37' => 1, // individual
            'price_1RBC5KFq0GU0Vr5TMvpc9eDH' => 2, // organization
        ];
    }



    //cancelaation
    public function cancel() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . "/home/login");
            exit;
        }
    
        $accountID = $_SESSION['user_id'];
        
        $subscription = $this->accountSubscriptionModel->getActiveSubscriptions($accountID);
    
        if (empty($subscription)) {
            $_SESSION['error'] = 'No active subscription found';
            header('Location: ' . ROOT . '/subscription');
            exit;
        }
    
        $subscriptionID = $subscription[0]->stripe_subscription_id;
        $result = $this->accountSubscriptionModel->markForCancellation($subscriptionID, $accountID);
    
        if ($result) {
            $_SESSION['success'] = 'Subscription will be cancelled at the end of your billing period';
        } else {
            $_SESSION['error'] = 'Failed to process cancellation';
        }
    
        header('Location: ' . ROOT . '/subscription/cancelConfirm');
        exit;
    }
    


}