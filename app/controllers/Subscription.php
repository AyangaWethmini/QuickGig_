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
        $data = $this->planModel->getPlansWithStripe();
		$this->view('premium', ['plans' => $data]);
    }

    public function subscribe() {
        if (!isset($_SESSION['user_id'], $_SESSION['user_email'], $_POST['priceID'])) {
            header('Location: ' . ROOT . "/home/login");
            exit;
        }

        $accountID = $_SESSION['user_id'];
        $email = $_SESSION['user_email'];
        $priceID = $_POST['priceID'];

        $customerID = $this->accountSubscriptionModel->getStripeCustomerID($accountID);

        if (!$customerID) {
            $account = $this->accountModel->findByEmail($email);
            if (!$account) {
                $_SESSION['error'] = 'Account not found';
                header('Location: ' . ROOT . '/home/premium');
                exit;
            }

            $customerID = $this->accountSubscriptionModel->createStripeCustomer($accountID, $email);
            if (!$customerID) {
                $_SESSION['error'] = 'Failed to create Stripe customer';
                header('Location: ' . ROOT . '/home/premium');
                exit;
            }
        }

        $checkoutResult = $this->accountSubscriptionModel->createCheckoutSession($accountID, $priceID );

        if (!empty($checkoutResult['success']) && !empty($checkoutResult['checkout_url'])) {
            header('Location: ' . $checkoutResult['checkout_url']);
            exit;
        } else {
            $_SESSION['error'] = $checkoutResult['error'] ?? 'Failed to create checkout session';
            header('Location: ' . ROOT . '/home/premium');
            exit;
        }
    }

    public function checkoutSuccess() {
        if (!isset($_SESSION['user_id']) || !isset($_GET['session_id'])) {
            $this->view('subscription/error', ['message' => 'Missing session info.']);
            exit;
        }
    
        $accountID = $_SESSION['user_id'];
        $sessionID = $_GET['session_id'];
    
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionID);
    
            if ($session->payment_status === 'paid') {
                $priceID = $session->metadata->price_id ?? null;
    
                if (!$priceID) {
                    // fallback if priceID not in metadata, use session
                    $priceID = $_SESSION['price_id'] ?? null;
                }
    
                if ($priceID) {
                    $result = $this->accountSubscriptionModel->createSubscription($accountID, $priceID);
    
                    if (isset($result['error'])) {
                        $this->view('subscription/error', ['message' => $result['error']]);
                        return;
                    }
    
                    $this->view('subscription/success', ['message' => 'Payment successful! Welcome to Premium.']);
                    return;
                } else {
                    $this->view('subscription/error', ['message' => 'Price ID missing.']);
                    return;
                }
            } else {
                $this->view('subscription/error', ['message' => 'Payment not completed.']);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $this->view('subscription/error', ['message' => 'Stripe error: ' . $e->getMessage()]);
        }
    }
    

    public function cancelSubscription() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $accountID = $_SESSION['user_id'];
        $subscriptions = $this->accountSubscriptionModel->getActiveSubscriptions($accountID);

        if (!empty($subscriptions)) {
            $subscriptionID = $subscriptions[0]->stripe_subscription_id;
            $result = $this->accountSubscriptionModel->cancelSubscription($subscriptionID);

            if ($result['success']) {
                $_SESSION['success'] = 'Subscription canceled successfully!';
            } else {
                $_SESSION['error'] = $result['error'] ?? 'Failed to cancel subscription';
            }
        } else {
            $_SESSION['error'] = 'No active subscription found.';
        }

        header('Location: /subscribe');
        exit;
    }

    public function webhook() {
        $config = require 'config/stripe_config.php';
        $endpoint_secret = $config['webhook_secret'];

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException | \Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $subscription = $event->data->object;
                $db = require 'config/database.php';
                $query = "SELECT user_id FROM stripe_customers WHERE stripe_customer_id = :customer_id LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':customer_id', $subscription->customer);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $this->accountSubscriptionModel->updateSubscriptionStatus($subscription->id, $subscription->status);

                    if ($subscription->status === 'active') {
                        $planMap = $this->getStripePlanMap();
                        $priceId = $subscription->items->data[0]->price->id;
                        $planID = $planMap[$priceId] ?? null;

                        if ($planID) {
                            $updateQuery = "UPDATE account SET planID = :planID WHERE user_id = :user_id";
                            $updateStmt = $db->prepare($updateQuery);
                            $updateStmt->bindParam(':planID', $planID);
                            $updateStmt->bindParam(':user_id', $result['user_id']);
                            $updateStmt->execute();
                        }
                    }
                }
                break;

            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->accountSubscriptionModel->updateSubscriptionStatus($subscription->id, 'canceled');
                break;
        }

        http_response_code(200);
    }

    private function getStripePlanMap() {
        return [
            'price_1RBC4LFq0GU0Vr5TFeEmkI37' => 1, // individual
            'price_1RBC5KFq0GU0Vr5TMvpc9eDH' => 2, // organization
        ];
    }

    public function checkoutFailed() {
        $this->view('subscription/error', ['message' => 'Payment was canceled or failed.']);
    }
    

    
}

