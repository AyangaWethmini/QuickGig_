<?php

class SystemReport {
    use Database;

    public function __construct()
    {
        // $this->db = new Database; // PDO instanc
    }

    //for sub revenue
    public function getSubscriptionRevenue($startDate=null, $endDate=null) {
        try {
            $query = "SELECT p.planID, p.planName, p.price, p.duration, p.currency, 
                      COUNT(s.id) AS subscription_count, 
                      COUNT(s.id) * p.price AS total_revenue,
                      SUM(COUNT(s.id) * p.price) OVER () AS total_earning
                      FROM subscriptions s
                      JOIN plan p ON s.stripe_price_id = p.stripe_price_id
                      WHERE 
                         s.created_at >= :startDate
                          AND s.created_at <= :endDate
                          AND s.status = 'active'
                          AND p.active = 1
                      GROUP BY 
                          p.planID, p.planName, p.price, p.duration, p.currency
                      ORDER BY 
                          total_revenue DESC";
    
            $params = [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ];
            
            $result = $this->query($query, $params) ?? [];
    
            return $result;
        } catch (Exception $e) {
            error_log("Error fetching subscription revenue: " . $e->getMessage());
            return false;
        }
    }


    //for ads revenue
    //my logic fro this - depending on the start date  and end date i get the ceil vaue of the active weeks of ads, then calculate revenue,
    //possible improvements - align with business weeks
    public function getAdsRevenue($startDate = null, $endDate = null){
        try {
    
            if($startDate == null || $endDate == null) {
                $query = "SELECT advertisementID, adTitle, startDate, endDate FROM advertisement WHERE deleted = 0";
                $params = [];
            }
            
            // Get all ads that were active during the period
            $query = "SELECT advertisementID, adTitle, startDate, endDate, views, clicks FROM advertisement WHERE (startDate <= :endDate AND endDate >= :startDate)
            AND deleted = 0";
        
    
            $params = [
                'startDate' => $startDate,
                'endDate' => $endDate
            ];
    
            $ads = $this->query($query, $params);
    
            $totalRevenue = 0;
            $results = [];
    
            foreach ($ads as $ad) {
                // Calculate the number of days the ad was active
                $start = strtotime($ad->startDate);
                $end = strtotime($ad->endDate);
                $daysActive = ($end - $start) / (60 * 60 * 24) + 1; // +1 to include both days
                
                // Calculate number of weeks (rounded up)
                $weeksActive = ceil($daysActive / 7);
                
                // Simple pricing: 1000LKR per week
                $get_rates = $this->getAdRates();
    
                if(!$get_rates) {
                    throw new Exception("Failed to fetch ad rates.");
                }
    
                $rates = $get_rates;
                $weeklyRate = $rates->flat_fee_weekly ?? 0;
                $perClickRate = $rates->per_click ?? 0;
                $perViewRate = $rates->per_view ?? 0;
    
                $adRevenue = $weeksActive * $weeklyRate + $ad->clicks * $perClickRate + $ad->views * $perViewRate;
                $paidAmount =  $weeksActive * $weeklyRate;
                $toBeCharged = $adRevenue - $paidAmount;
    
                $results[] = [
                    'adId' => $ad->advertisementID,
                    'title' => $ad->adTitle,
                    'daysActive' => $daysActive,
                    'weeksActive' => $weeksActive,
                    'revenue' => $adRevenue,
                    'paidAmount' => $paidAmount,
                    'toBeCharged' => $toBeCharged,
                ];
    
                $totalRevenue += $adRevenue;
            }
    
            return [
                'totalRevenue' => $totalRevenue,
                'ads' => $results,
                'weeklyRate' => $weeklyRate
            ];
        } catch (Exception $e) {
            error_log("Error calculating ad revenue: " . $e->getMessage());
            return false;
        }
    }


    public function getAdRates() {
        $query = "SELECT * FROM ad_rates;"; 
        $result = $this->query($query);
        return $result[0] ?? null;
    }

    public function getUsers($startDate = null, $endDate = null) {
        try {
            $query = "SELECT ar.roleID, COUNT(*) AS role_count 
                      FROM account a 
                      JOIN account_role ar ON a.accountID = ar.accountID 
                      WHERE a.accStatus = 0 
                      AND (a.createdAt >= :startDate OR :startDate IS NULL)
                      AND (a.createdAt <= :endDate OR :endDate IS NULL)
                      GROUP BY ar.roleID;";
            $params = [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ];
            return $this->query($query, $params) ?: [];
        } catch (Exception $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }
    public function getUserCount($startDate = null , $endDate = null ) {
        try {
            $query = "SELECT ar.roleID, COUNT(*) AS role_count FROM account a JOIN account_role ar ON a.accountID = ar.accountID WHERE a.accStatus = 0 GROUP BY ar.roleID;";
            $params = [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ];
            return $this->query($query, $params);
        } catch (Exception $e) {
            error_log("Error fetching user count: " . $e->getMessage());
            return false;
        }
    }


    
    
}