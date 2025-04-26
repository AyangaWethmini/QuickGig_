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
        $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 1
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }

    public function rejectRequest($applicationID) {
        $dateActioned = date('Y-m-d');
        $timeActioned = date('H:i:s');
        $query = "UPDATE apply_job SET applicationStatus = 0, dateActioned = ?, timeActioned = ? WHERE applicationID = ?";
        return $this->query($query, [$dateActioned, $timeActioned, $applicationID]);
    }
    
    public function acceptRequest($applicationID) {
        $dateActioned = date('Y-m-d');
        $timeActioned = date('H:i:s');
        $query = "UPDATE apply_job SET applicationStatus = 2, dateActioned = ?, timeActioned = ? WHERE applicationID = ?";
        return $this->query($query, [$dateActioned, $timeActioned, $applicationID]);
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

    public function searchReceivedRequests($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp
                  FROM apply_job a 
                  JOIN job j ON a.jobID = j.jobID
                  JOIN individual i ON a.seekerID = i.accountID
                  JOIN account acc ON a.seekerID = acc.accountID
                  WHERE j.accountID = ? 
                  AND a.applicationStatus = 1
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(j.jobTitle) LIKE ? OR
                      LOWER(j.location) LIKE ?
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function filterReceivedRequestsByDate($userID, $filterDate) {
        $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp
                  FROM apply_job a 
                  JOIN job j ON a.jobID = j.jobID
                  JOIN individual i ON a.seekerID = i.accountID
                  JOIN account acc ON a.seekerID = acc.accountID
                  WHERE j.accountID = ? 
                  AND a.applicationStatus = 1
                  AND a.dateApplied = ?
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $filterDate]);
    }
}