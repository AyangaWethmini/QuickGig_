<?php

class ReceivedSeeker{
    use Database;

    public $availableID;
    public $providerID;
    public $reqID;
    public $datePosted;
    public $timePosted;
    public $reqStatus;
    public $timeFrom;
    public $timeTo;
    public $availableDate;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }


    public function getReceivedRequests()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*, 
                         CASE 
                             WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                             THEN CONCAT(i.fname, ' ', i.lname) 
                             ELSE o.orgName 
                         END AS name, 
                         m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location, m.currency
                  FROM req_available r 
                  JOIN makeavailable m ON r.availableID = m.availableID
                  LEFT JOIN individual i ON r.providerID = i.accountID
                  LEFT JOIN organization o ON r.providerID = o.accountID
                  WHERE m.accountID = ? 
                  AND r.reqStatus = 1
                  ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }

    public function rejectRequest($reqID) {
        $query = "UPDATE req_available SET reqStatus = 0 WHERE reqID = ?";
        return $this->query($query, [$reqID]);
    }

    public function acceptRequest($reqID) {
        $query = "UPDATE req_available SET reqStatus = 2 WHERE reqID = ?";
        return $this->query($query, [$reqID]);
    }
    
    public function updateAvailableStatus($availableID, $status) {
        $query = "UPDATE makeavailable SET availabilityStatus = ? WHERE availableID = ?";
        return $this->query($query, [$status, $availableID]);
    }

    public function getReqByID($reqID) {
        $query = "SELECT * FROM req_available WHERE reqID = ?";
        $result = $this->query($query, [$reqID]);
        return $result ? $result[0] : null;
    }
}