<?php

class ManagerDashboard {
    use Database;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }
    public function getPlanCount($startDate = null, $endDate = null) {
    $query = "SELECT COUNT(*) as plan_count FROM plan WHERE active = 1";
    $result = $this->query($query);
    return $result[0]->plan_count ?? 0; 
}

public function getSubscribersCount($startDate = null, $endDate = null) {
    $query = "SELECT COUNT(*) as subscriber_count FROM subscriptions WHERE status IN ('active', 'canceled')";
    $params = [];
    
    if ($startDate && $endDate) {
        $query .= " AND created_at BETWEEN :start_date AND :end_date";
        $params = [
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ];
    }

    $result = $this->query($query, $params);
    return $result[0]->subscriber_count ?? 0; 
}

public function adsPosted($startDate = null, $endDate = null) {
    $query = "SELECT COUNT(*) as ads_count FROM advertisement";
    $params = [];
    
    if ($startDate && $endDate) {
        $query .= " WHERE createdAt >= :start_date AND createdAt <= :end_date";
        $params = [
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ];
    }


    $result = $this->query($query, $params);
    return $result[0]->ads_count ?? 0; 
}

    public function getTotalAdClicks($startDate = null, $endDate = null) {
        $query = "SELECT SUM(clicks) as total_clicks FROM advertisement WHERE deleted = 0";
        $params = [];

        if ($startDate && $endDate) {
            $query .= " AND createdAt BETWEEN :start_date AND :end_date";
            $params = [
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ];
        }

        $result = $this->query($query, $params);
        return $result[0]->total_clicks ?? 0; 

    }

    public function getTotalAdViews($startDate = null, $endDate = null) {
        $query = "SELECT SUM(views) as total_views FROM advertisement WHERE deleted = 0";
        $params = [];

        if ($startDate && $endDate) {
            $query .= " AND createdAt BETWEEN :start_date AND :end_date";
            $params = [
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ];
        }

        $result = $this->query($query, $params);
        return $result[0]->total_views ?? 0; 

    }

    public function getManagerName($accountID){
        $query = "SELECT fname FROM manager WHERE accountID = :accountID";
        $params = [
            ':accountID' => $accountID
        ];
        $result = $this->query($query, $params);
    }

    
}