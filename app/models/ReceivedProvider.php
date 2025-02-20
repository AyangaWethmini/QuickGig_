<?php

class ReceivedProvider{
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
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 1
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }

    public function rejectRequest($applicationID) {
        $query = "UPDATE apply_job SET applicationStatus = 0 WHERE applicationID = ?";
        return $this->query($query, [$applicationID]);
    }

    public function acceptRequest($applicationID) {
        $query = "UPDATE apply_job SET applicationStatus = 2 WHERE applicationID = ?";
        return $this->query($query, [$applicationID]);
    }
    
    public function countAcceptedApplications($jobID) {
        $query = "SELECT COUNT(*) as acceptedCount FROM apply_job WHERE jobID = ? AND applicationStatus = 2";
        $result = $this->query($query, [$jobID]);
        return $result ? $result[0]->acceptedCount : 0;
    }
    
    public function updateJobStatus($jobID, $status) {
        $query = "UPDATE job SET jobStatus = ? WHERE jobID = ?";
        return $this->query($query, [$status, $jobID]);
    }

    public function getApplicationByID($applicationID) {
        $query = "SELECT * FROM apply_job WHERE applicationID = ?";
        $result = $this->query($query, [$applicationID]);
        return $result ? $result[0] : null;
    }
}