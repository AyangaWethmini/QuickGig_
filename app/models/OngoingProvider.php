<?php

class OngoingProvider{
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

    public function getApplyJobOngoing()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 3
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function getReqAvailableOngoing()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*, i.fname, i.lname, m.description, m.availableID, acc.pp, m.availableDate, m.timeFrom, m.timeTo, m.salary, m.currency
        FROM req_available r
        JOIN makeavailable m ON r.availableID = m.availableID
        JOIN individual i ON m.accountID = i.accountID
        JOIN account acc ON i.accountID = acc.accountID
        WHERE r.providerID = ?
        AND r.reqStatus = 3
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function searchOngoing($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency
                  FROM apply_job a 
                  JOIN job j ON a.jobID = j.jobID
                  JOIN individual i ON a.seekerID = i.accountID
                  JOIN account acc ON a.seekerID = acc.accountID
                  WHERE j.accountID = ? 
                  AND a.applicationStatus = 3
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(j.jobTitle) LIKE ? OR
                      LOWER(j.location) LIKE ?
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function searchReqAvailableOngoing($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT * FROM req_available 
                  WHERE providerID = ? 
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(description) LIKE ? OR
                      LOWER(location) LIKE ?
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
}