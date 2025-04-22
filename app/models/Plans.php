<?php

use Stripe\BillingPortal\Session;

class Plans {
    use Database;

    public function getPlans() {
        $query = 'SELECT * FROM plan';
        return $this->query($query);
    }

    public function getPlansWithStripe() {
        $query = 'SELECT plan.*
                  FROM plan WHERE stripe_price_id IS NOT NULL AND stripe_price_id != ""';
        return $this->query($query);
    }

    public function getPlanById($id) {
        $query = "SELECT * FROM plan WHERE planID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return $result[0] ?? null;
    }


    public function createPlan($data) {
        // Validation
        if (
            empty($data['planName']) || strlen(trim($data['planName'])) > 20 ||
            empty($data['description']) || strlen(trim($data['description'])) > 1000 ||
            !is_numeric($data['price']) ||
            !is_numeric($data['duration']) ||
            !is_numeric($data['postLimit']) ||
            empty($data['currency']) || strlen(trim($data['currency'])) !== 3 ||
            empty($data['recInterval'])
        ) {
            return false;
        }
    
        // Prepare query and parameters
        $query = "INSERT INTO plan (
                      planName, description, price, duration, badge, postLimit, stripe_price_id, currency, recInterval, active
                  ) VALUES (
                      :planName, :description, :price, :duration, :badge, :postLimit, :stripe_price_id, :currency, :recInterval, :active
                  )";
    
        $params = [
            'planName' => $data['planName'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration' => $data['duration'],
            'badge' => isset($data['badge']) ? 1 : 0,
            'postLimit' => $data['postLimit'],
            'stripe_price_id' => $data['stripe_price_id'] ?? null,
            'currency' => $data['currency'],
            'recInterval' => $data['recInterval'],
            'active' => isset($data['active']) ? 1 : 0
        ];
    
        try {
            return $this->query($query, $params);
        } catch (Exception $e) {
            // Log the error for debugging
            error_log("Error creating plan: " . $e->getMessage());
            return false;
        }
    }


    public function deletePlan($id) {
        $query = "DELETE FROM plan WHERE planID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    
    public function update($id, $data) {
        $query = "UPDATE plan 
                  SET planName = :planName, 
                      description = :description, 
                      price = :price, 
                      duration = :duration, 
                      badge = :badge, 
                      postLimit = :postLimit, 
                      active = :active 
                  WHERE planID = :id";

        $params = [
            'id' => $id,
            'planName' => $data['planName'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration' => $data['duration'],
            'badge' => $data['badge'],
            'postLimit' => $data['postLimit'],
            'active' => $data['active']
        ];

        return $this->query($query, $params);
    }

    public function getPlansCount(){
        $query = "SELECT COUNT(*) AS total FROM plan";
        $result = $this->query($query);
        return $result[0]->total ?? 0;
    }
}