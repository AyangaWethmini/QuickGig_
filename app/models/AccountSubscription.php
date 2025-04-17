<?php

require_once "../app/models/Account.php";
require_once '../app/services/StripeService.php';

class AccountSubscription extends Account {
    use Database;

    private $accountModel;
    protected $stripeService;
    private $db;

    public function __construct() {
        $this->db = $this->connect();
        parent::__construct($this->db);
        $this->stripeService = new StripeService();
        $this->accountModel = new Account($this->db);
    }

    public function createStripeCustomer($accountID, $email) {
        $query = "SELECT * FROM account WHERE accountID = :accountID LIMIT 1";
        $params = ['accountID' => $accountID];
        $account = $this->query($query, $params);

        if (!$account) {
            return false;
        }

        $role = $this->accountModel->findRole($accountID);
        // $name = $this->accountModel->getUserName($accountID);
        $name = "User";

        if ($role == 2) {
            $query = "SELECT * FROM individual WHERE accountID = :accountID LIMIT 1";
            $individual = $this->query($query, $params);
            if ($individual) {
                $name = $individual[0]->firstName . " " . $individual[0]->lastName;
            }
        } elseif ($role == 3) {
            $query = "SELECT * FROM organization WHERE accountID = :accountID LIMIT 1";
            $business = $this->query($query, $params);
            if ($business) {
                $name = $business[0]->orgName;
            }
        }

        $customer = $this->stripeService->createCustomer($email, $name, ['accountID' => $accountID,'localCreatedAt' => date('Y-m-d H:i:s')]);

        if ($customer && $customer->id) {
            $query = "INSERT INTO stripe_customers (accountID, stripe_customer_id, created_at) 
                      VALUES (:accountID, :stripe_customer_id, NOW())";
            $params = [
                'accountID' => $accountID,
                'stripe_customer_id' => $customer->id
            ];
            $this->query($query, $params);
            return $customer->id;
        }

        return false;
    }

    public function getStripeCustomerID($accountID) {
        $query = "SELECT stripe_customer_id FROM stripe_customers WHERE accountID = :accountID LIMIT 1";
        $params = ['accountID' => $accountID];
        $customer = $this->query($query, $params);
        return $customer && count($customer) ? $customer[0]->stripe_customer_id : false;
    }

    public function ensureStripeCustomer($accountID, $email) {
        $customerID = $this->getStripeCustomerID($accountID);
        
        if ($customerID) {
            return $customerID;
        }
        return $this->createStripeCustomer($accountID, $email);
    }

    public function getAccountIDByCustomerID($customerID) {
        $query = "SELECT accountID FROM stripe_customers WHERE stripe_customer_id = :customerID LIMIT 1";
        $params = ['customerID' => $customerID];
        $result = $this->query($query, $params);
        return $result && count($result) ? $result[0]->accountID : false;
    }

    public function createSubscription($accountID, $priceID, $subscriptionID, $status, $periodStart, $periodEnd) {
        try {
            // Check if subscription already exists
            $existing = $this->getSubscription($subscriptionID);
            if ($existing) {
                return ['error' => 'Subscription already exists'];
            }

            $query = "INSERT INTO subscriptions 
                      (accountID, stripe_subscription_id, stripe_price_id, status, current_period_start, current_period_end) 
                      VALUES (:accountID, :subscription_id, :price_id, :status, FROM_UNIXTIME(:period_start), FROM_UNIXTIME(:period_end))";
            
            $params = [
                'accountID' => $accountID,
                'subscription_id' => $subscriptionID,
                'price_id' => $priceID,
                'status' => $status,
                'period_start' => $periodStart,
                'period_end' => $periodEnd
            ];

            $result = $this->query($query, $params);

            if (!$result) {
                return ['error' => 'Failed to create subscription record'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return ['error' => 'Database error'];
        }
    }


    public function createCheckoutSession($accountID, $priceID) {
        $account = $this->accountModel->findById($accountID);
        if (!$account) {
            return ['error' => 'Account not found'];
        }

        // Ensure customer exists in Stripe
        $customerID = $this->ensureStripeCustomer($accountID, $account->email);
        if (!$customerID) {
            return ['error' => 'Failed to create or retrieve Stripe customer'];
        }

        // Create checkout session
        $success_url = ROOT . "/subscription/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}";
        $cancel_url = ROOT . "/subscription/error";

        $session = $this->stripeService->createCheckoutSession(
            $customerID, 
            $priceID, 
            $success_url, 
            $cancel_url,
            [
                'accountID' => $accountID,
                'priceID' => $priceID
            ]
        );

        if (!$session || !isset($session->id)) {
            return ['error' => 'Failed to create checkout session'];
        }

        return [
            'success' => true,
            'session_id' => $session->id,
            'checkout_url' => $session->url
        ];
    }


    public function getSubscription($subscriptionID) {
        $query = "SELECT * FROM subscriptions WHERE stripe_subscription_id = :subscription_id LIMIT 1";
        $params = ['subscription_id' => $subscriptionID];
        $result = $this->query($query, $params);
        return $result && count($result) ? $result[0] : false;
    }

    public function updateSubscription($subscriptionID, $status, $periodStart = null, $periodEnd = null) {
        try {
            $query = "UPDATE subscriptions SET status = :status";
            $params = ['status' => $status, 'subscription_id' => $subscriptionID];

            if ($periodStart && $periodEnd) {
                $query .= ", current_period_start = FROM_UNIXTIME(:period_start), current_period_end = FROM_UNIXTIME(:period_end)";
                $params['period_start'] = $periodStart;
                $params['period_end'] = $periodEnd;
            }

            $query .= " WHERE stripe_subscription_id = :subscription_id";

            return $this->query($query, $params);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateSubscriptionStatus($subscriptionID, $status) {
        return $this->updateSubscription($subscriptionID, $status);
    }

    public function cancelSubscription($subscriptionID) {
        $result = $this->stripeService->cancelSubscription($subscriptionID);
        if ($result) {
            return $this->updateSubscriptionStatus($subscriptionID, 'canceled');
        }
        return false;
    }

    public function getActiveSubscriptions($accountID = null) {
        $query = "SELECT * FROM subscriptions WHERE status = 'active'";
        $params = [];

        if ($accountID) {
            $query .= " AND accountID = :accountID";
            $params['accountID'] = $accountID;
        }

        return $this->query($query, $params);
    }
}