<?php

require_once '../app/services/StripeService.php';

class Subscription extends Controller {
    use Database; // Use the Database trait for database connection
    protected $viewPath = "../app/views/subscription/";
    protected $accountSubscriptionModel;
    protected $stripeService;
    protected $accountModel;
    private $db;
    

    public function __construct() {
        // parent::__construct(); // Call the parent constructor first
        
        // Create a database connection using the trait method
        $db = $this->connect();
        
        // Instantiate the models
        $this->accountSubscriptionModel = new AccountSubscription();
        $this->stripeService = new StripeService();
        
        // Pass the db object to the Account model constructor
        $this->accountModel = $this->model('Account', $db);
    }


    public function index(){
        $this->view('subscribe');
    }

    public function subscribe(){
    if (!isset($_SESSION['user_id'], $_SESSION['user_email'], $_POST['priceID'])) {
        header('Location: ' . ROOT . "/home/login");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $priceID = $_POST['priceID'];
    $email = $_SESSION['user_email'];

    $customerID = $this->accountSubscriptionModel->getStripeCustomerID($user_id);

    if (!$customerID) {
        $account = $this->accountModel->findByEmail($email);

        var_dump($user_id);
        var_dump($account);

        if (!$account) {
            $_SESSION['error'] = 'Account not found';
            header('Location: ' . ROOT . '/home/premium');
            exit;
        }

        $customerID = $this->accountSubscriptionModel->createStripeCustomer($user_id, $email);
        var_dump($customerID);

        if (!$customerID) {
            $_SESSION['error'] = 'Failed to create Stripe customer';
            header('Location: ' . ROOT . '/home/premium');
            exit;
        }
    }

    // Create the checkout session
    $checkoutResult = $this->accountSubscriptionModel->createCheckoutSession($customerID, $priceID);
    var_dump($checkoutResult);

    if (!empty($checkoutResult['success']) && !empty($checkoutResult['checkout_url'])) {
        header('Location: ' . $checkoutResult['checkout_url']);
        exit;
    } else {
        $_SESSION['error'] = $checkoutResult['error'] ?? 'Failed to create checkout session';
        header('Location: ' . ROOT . '/home/premium');
        exit;
    }
}


    public function checkoutSuccess(){
        if(!isset($_SESSION['user_id']) || !isset($_GET['session_id'])){
            header('Location: /subscribe');
            exit;
        }

        $sessionID = $_GET['session_id'];
        
        try{
            $session = \Stripe\Checkout\Session::retrieve($sessionID);

            if($session->payment_status == 'paid'){
                $_SESSION['success'] = 'Payment successful!';
            }else{
                $_SESSION['warning'] = 'Payment failed!';
            }
        }catch(\Stripe\Exception\ApiErrorException $e){
            $_SESSION['error'] = 'Failed to retrieve session: ' . $e->getMessage(); /*!ERRORS!*/
        }
        header('Location: /subscribe');
        exit;
    }

    public function cancelSubscription(){
        if(!isset($_SESSION['user_id'])){
            header('Location: /login'); //!ERRORS!  
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $result = $this->accountSubscriptionModel->cancelSubscription($user_id);

        if($result['success']){
            $_SESSION['success'] = 'Subscription canceled successfully!';
        }else{
            $_SESSION['error'] = isset($result['error']) ? $result['error'] : 'Failed to cancel subscription'; /*!ERRORS!*/
        }
        header('Location: /subscribe');
        exit;
    }

    // Handle Stripe webhooks
    public function webhook()
    {
        $config = require 'config/stripe_config.php';
        $endpoint_secret = $config['webhook_secret'];
        
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
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
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $subscription = $event->data->object;
                // Find account by customer ID
                $db = require 'config/database.php';
                $query = "SELECT user_id FROM stripe_customers WHERE stripe_customer_id = :customer_id LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':customer_id', $subscription->customer);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    $this->accountSubscriptionModel->updateSubscriptionStatus($subscription->id, $subscription->status);
                    
                    // If subscription is active, update the plan
                    if ($subscription->status === 'active') {
                        $planMap = $this->getStripePlanMap();
                        $priceId = $subscription->items->data[0]->price->id;
                        $planID = isset($planMap[$priceId]) ? $planMap[$priceId] : null;
                        
                        if ($planID) {
                            $query = "UPDATE account SET planID = :planID WHERE user_id = :user_id";
                            $stmt = $db->prepare($query);
                            $stmt->bindParam(':planID', $planID);
                            $stmt->bindParam(':user_id', $result['user_id']);
                            $stmt->execute();
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
            'price_1RBC4LFq0GU0Vr5TFeEmkI37' => 1,//individual
            'price_1RBC5KFq0GU0Vr5TMvpc9eDH' => 2, //organization
        ];
    }
    

    
















}