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

        $customer = $this->stripeService->createCustomer($email, $name, ['accountID' => $accountID]);

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

    public function createSubscription($accountID, $priceID) {
        $customerID = $this->getStripeCustomerID($accountID);
        if (!$customerID) {
            return ['error' => 'Customer not found in Stripe'];
        }

        $subscription = $this->stripeService->createSubscription($customerID, $priceID, ['accountID' => $accountID]);
        if ($subscription && $subscription->id) {
            try {
                $planMap = $this->getStripePlanMap();
                $planID = $planMap[$priceID] ?? null;

                if ($planID) {
                    $query = "UPDATE account SET planID = :planID WHERE accountID = :accountID";
                    $this->query($query, ['planID' => $planID, 'accountID' => $accountID]);
                }

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

                return ['success' => true, 'subscription' => $subscription];
            } catch (PDOException $e) {
                return ['error' => 'Database error: ' . $e->getMessage()];
            }
        }

        return ['error' => 'Subscription creation failed'];
    }

    public function getActiveSubscriptionsCount($startDate = null, $endDate = null) {
        $query = "SELECT COUNT(stripe_subscription_id) FROM subscriptions WHERE status = 'active' AND current_period_start BETWEEN :startDate AND :endDate";
        if($startDate >= $endDate) {
            $_SESSION['error'] = 'Invalid date range';
            return ['error' => 'Invalid date range'];
        }
        $params = [
            'startDate' => $startDate ? date('Y-m-d H:i:s', strtotime($startDate)) : date('Y-m-d H:i:s', strtotime('-1 month')),
            'endDate' => $endDate ? date('Y-m-d H:i:s', strtotime($endDate)) : date('Y-m-d H:i:s')
        ];
        $result =  $this->query($query, $params);
        if (!$result) {
            return ['error' => 'Database error'];
        }
        return $result ? $result[0]['COUNT(stripe_subscription_id)'] : 0;
        
    }

    public function updateSubscriptionStatus($stripeSubscriptionID, $status) {
        $query = "UPDATE subscriptions SET status = :status WHERE stripe_subscription_id = :subscriptionID";
        return $this->query($query, ['status' => $status, 'subscriptionID' => $stripeSubscriptionID]);
    }

    public function cancelSubscription($subscriptionID) {
        $subscription = $this->stripeService->cancelSubscription($subscriptionID);
        if ($subscription && $subscription->id) {
            try {
                $query = "UPDATE subscriptions SET status = :status WHERE stripe_subscription_id = :subscription_id";
                $params = ['status' => 'canceled', 'subscription_id' => $subscription->id];
                $this->query($query, $params);
                return ['success' => true];
            } catch (PDOException $e) {
                return ['error' => 'Database error: ' . $e->getMessage()];
            }
        }
        return ['error' => 'Subscription cancellation failed'];
    }

    public function createCheckoutSession($accountID, $priceID) {
        $customerID = $this->getStripeCustomerID($accountID);
        if (!$customerID) {
            return ['error' => 'Customer not found in Stripe'];
        }
    
        $success_url = ROOT . "/subscription/checkoutSuccess";
        $cancel_url = ROOT . "/subscription/checkoutFailed"; 
    
        $session = $this->stripeService->createCheckoutSession($customerID, $priceID, $success_url, $cancel_url);
    
        if ($session && $session->id) {
            return ['success' => true, 'session_id' => $session->id, 'checkout_url' => $session->url];
        }
    
        return ['error' => 'Checkout session creation failed', 'checkout_url' => $cancel_url];
    }
    
    private function getStripePlanMap() {
        return [
            'price_1RBC4LFq0GU0Vr5TFeEmkI37' => 1, // individual
            'price_1RBC5KFq0GU0Vr5TMvpc9eDH' => 2, // organization
        ];
    }

    public function getSubRev($startDate, $endDate){
        $query = "SELECT SUM(p.amount) AS total_revenue, COUNT(s.accommID) AS active_subscriptions FROM subscriptions s JOIN prices p ON s.stripe_price_id = p.stripe_price_id
                    WHERE s.status = 'active' AND s.current_period_start >= :startDate AND s.current_period_end <= :endDate;";

        $params = [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        $result = $this->query($query, $params);
        if ($result) {
            return [
                'total_revenue' => $result[0]['total_revenue'],
                'active_subscriptions' => $result[0]['active_subscriptions']
            ];
        } else {
            return [
                'total_revenue' => 0,
                'active_subscriptions' => 0
            ];
        }
    }
}
