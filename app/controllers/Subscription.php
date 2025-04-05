<?php

require_once 'services/StripeService.php';

class Subscription extends Controller {
    protected $viewPath = "../app/views/subscriptions/";
    protected $accountSubscriptionModel;
    protected $stripeService;
    protected $accountModel;
    

    public function __construct(){
        $this->accountSubscriptionModel = $this->model('AccountSubscription');
        $this->stripeService = new StripeService();   
        $this->accountModel = $this->model('Account');
    }


    public function index(){
        $data = $this->accountSubscriptionModel->getAllSubscriptions();
        $this->view('plans', $data);
    }

    public function subscribe(){
        if(!isset($_SESSION['accountID']) || !isset($_POST['priceID'])){
            header('Location: /plans');
            exit;
        }

        $accountID = $_SESSION['accountID'];
        $priceID = $_POST['priceID'];

        $customenrID = $this->accountSubscriptionModel->getStripeCustomerID($accountID);
        if(!$customenrID){ //user has no Stripe account
            $account = $this->accountModel->findByEmail($accountID);

            if(!$account){
                $_SESSION['error'] = 'Account not found'; /*!ERRORS!*/
                header('Location: /plans');
                exit;
            }

            $customenrID = $this->accountSubscriptionModel->createStripeCustomer($accountID, $account->email);
            if(!$customenrID){
                $_SESSION['error'] = 'Failed to create Stripe customer'; /*!ERRORS!*/
                header('Location: /plans');
                exit;
            }
        }

        //create the checkout session
        $checkoutResult = $this->accountSubscriptionModel->createCheckoutSession($customenrID, $priceID);
        
        //if successful, redirect to checkout URL
        if(isset($checkoutResult['success']) && $checkoutResult['checkout_url']){
            header('Location: ' . $checkoutResult['checkout_url']);
            exit;
        }else{
            $_SESSION['error'] = isset($checkoutResult['error']) ? $checkoutResult['error'] : 'Failed to create checkout session';
            header('Location: ' . $checkoutResult['checkout_url']);
            exit;
        }
    }

    public function chekoutSuccess(){
        if(!isset($_SESSION['accountID']) || !isset($_GET['session_id'])){
            header('Location: /plans');
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
        header('Location: /plans');
        exit;
    }

    public function cancelSubscription(){
        if(!isset($_SESSION['accountID'])){
            header('Location: /login'); //!ERRORS!  
            exit;
        }

        $accountID = $_SESSION['accountID'];
        $result = $this->accountSubscriptionModel->cancelSubscription($accountID);

        if($result['success']){
            $_SESSION['success'] = 'Subscription canceled successfully!';
        }else{
            $_SESSION['error'] = isset($result['error']) ? $result['error'] : 'Failed to cancel subscription'; /*!ERRORS!*/
        }
        header('Location: /plans');
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
                $query = "SELECT accountID FROM stripe_customers WHERE stripe_customer_id = :customer_id LIMIT 1";
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
                            $query = "UPDATE account SET planID = :planID WHERE accountID = :accountID";
                            $stmt = $db->prepare($query);
                            $stmt->bindParam(':planID', $planID);
                            $stmt->bindParam(':accountID', $result['accountID']);
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
            'price_1RASEUFq0GU0Vr5T2NbrfNQz' => 1,   
            'price_1RASEUFq0GU0Vr5T2NbrfNQz'   => 2,   
            'price_1RASFHFq0GU0Vr5TM8MF8OjW' => 3   
        ];
    }
    

    
















}