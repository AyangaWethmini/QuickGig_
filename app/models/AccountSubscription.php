<?php

require_once "account.php";
require_once 'services/StripeService.php';

class AccountSubscription extends Account{
    use Database;

    private $db; // Declare the $db property
    private $stirpeService;

    public function __construct($db)
    {
        $this->db = $db; // Initialize $db with the passed database connection
        parent::__construct($db);
        $this->stirpeService = new StripeService();
    }

    //creating stripe customer related to the account
    public function createStripeCustomer($accountID, $email){
        //retrieving the account
        $query = "SELECT * FROM account WHERE accountID = :accountID LIMIT 1";
        $params = ['accountID' => $accountID];
        $account =  $this->query($query, $params);

        if(!$account){ // Account not found
            return false;
        }

        //checking account roles
        $role = $this->findRole($accountID);

        if($role && $role == 2){ //for individuals accounts
            $query = "SELECT * FROM individual WHERE accountID = :accountID LIMIT 1";
            $params = ['accountID' => $accountID];
            $individual =  $this->query($query, $params);

            if($individual){
                $name = $individual[0]->firstName . " " . $individual[0]->lastName;
            }
            
        }else if($role && $role == 3){ //for business accounts
            $query = "SELECT * FROM organization WHERE accountID = :accountID LIMIT 1";
            $params = ['accountID' => $accountID];
            $business =  $this->query($query, $params);

            if($business){
                $name = $business[0]->orgName;
            }
        
        }
        // Create Stripe customer
        $customer = $this->stirpeService->createCustomer($email, $name, ['accountID' => $accountID]); //account id as metadata?
        if($customer && $customer->id){
            $query = "INSERT INTO stripe_customers (accountID, stripe_customer_id, created_at) 
                      VALUES (:accountID, :stripe_customer_id, NOW())";
            $params = [
                'accountID' => $accountID,
                'stripe_customer_id' => $customer->id
            ];
            $this->query($query, $params);
        }

        return false;
    }

    public function getStripeCustomerID($accountID){
        $query = "SELECT stripe_customer_id FROM stripe_customers WHERE accountID = :accountID LIMIT 1";
        $params = ['accountID' => $accountID];
        $customer =  $this->query($query, $params);

        if($customer && count($customer) > 0){
            return $customer[0]->stripe_customer_id;
        }
        return false;
    }

    //mapping stripe plan IDs to internal plan IDs
    // This function maps Stripe price IDs to internal plan IDs
    private function getStripePlanMap() {
        return [
            'price_1RASEUFq0GU0Vr5T2NbrfNQz' => 1,   
            'price_1RASEUFq0GU0Vr5T2NbrfNQz'   => 2,   
            'price_1RASFHFq0GU0Vr5TM8MF8OjW' => 3   
        ];
    }

    //creating subscription to the account
    public function createSubscription($accountID, $priceID){
        $customerID = $this->getStripeCustomerID($accountID);
        if(!$customerID){
            return ['error' => 'Customer not found in Stripe'];
        }

        $subscription = $this->stirpeService->createSubscription($customerID, $priceID, ['accountID' => $accountID]);
        if($subscription && $subscription->id){
            try{
                $this->db->beginTransaction();
                $planmap = $this->getStripePlanMap();
                $planID = isset($planmap[$priceID]) ? $planmap[$priceID] : null;

                if($planID){
                    $query = "UPDATE account SET planID = :planID WHERE accountID = :accountID";
                    $params = [
                        'planID' => $planID,
                        'accountID' => $accountID
                    ];
                    $this->query($query, $params);
                }

                //save subscription to the database
                $query = "INSERT INTO subscriptions (accountID, stripe_subscription_id, stripe_price_id, status, current_period_start, current_period_end) 
                          VALUES (:accountID, :subscription_id, :price_id, :status, FROM_UNIXTIME(:period_start), FROM_UNIXTIME(:period_end))";
                $params = [ 
                    'accountID' => $accountID,
                    'subscription_id' => $subscription->id,
                    'price_id' => $priceID,
                    'status' => $subscription->status,
                    'period_start' => $subscription->current_period_start,
                    'period_end' => $subscription->current_period_end
                ];
                $this->query($query, $params);
                $this->db->commit();
                return ['success' => true, 'subscription' => $subscription];
            }catch(PDOException $e){
                $this->db->rollBack();
                return ['error' => 'Database error: ' . $e->getMessage()];
            }
        
    }
        return ['error' => 'Subscription creation failed'];
    }   

   
    public function getActiveSubscriptions($accountID){
        $query = "SELECT * FROM subscriptions WHERE accountID = :accountID AND status = 'active'";
        $params = ['accountID' => $accountID];
        return $this->query($query, $params);
    }

   public function updateSubscriptionStatus($subscriptionID, $status){
        $query = "UPDATE subscriptions SET status = :status WHERE subscriptionID = :subscriptionID";
        $params = [
            'status' => $status,
            'subscriptionID' => $subscriptionID
        ];
        return $this->query($query, $params);
    }

    public function cancelSubscription($subscriptionID){
        $subscription = $this->stirpeService->cancelSubscription($subscriptionID);
        if($subscription && $subscription->id){
            try{
                $this->db->beginTransaction();
                $query = "UPDATE subscriptions SET status = :status WHERE stripe_subscription_id = :subscription_id";
                $params = [
                    'status' => 'canceled',
                    'subscription_id' => $subscription->id
                ];
                $this->query($query, $params);
                $this->db->commit();
                return ['success' => true];
            }catch(PDOException $e){
                $this->db->rollBack();
                return ['error' => 'Database error: ' . $e->getMessage()];
            }
        }
        return ['error' => 'Subscription cancellation failed'];
    }

    public function createCheckoutsession($accountID, $priceID){
        $customerID = $this->getStripeCustomerID($accountID);
        if(!$customerID){
            return ['error' => 'Customer not found in Stripe'];
        }

        $success_url = "https://yourdomain.com/success"; 
        $cancel_url = "https://yourdomain.com/cancel";  //add relevent urls

        $session = $this->stirpeService->createCheckoutSession($customerID, $priceID, $success_url, $cancel_url);
        if($session && $session->id){
            return ['success' => true, 'session_id' => $session->id, 'checkout_url' => $session->success_url];
        }
        return ['error' => 'Checkout session creation failed', 'checkout_url' => $session->cancel_url];
    }
}