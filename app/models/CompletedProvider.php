<?php

class CompletedProvider{
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

    public function getApplyJobCompleted()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency, j.location
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 4
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function getReqAvailableCompleted()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*, i.fname, i.lname, m.description, m.availableID, acc.pp, m.availableDate, m.timeFrom, m.timeTo, m.salary, m.currency, m.location
        FROM req_available r
        JOIN makeavailable m ON r.availableID = m.availableID
        JOIN individual i ON m.accountID = i.accountID
        JOIN account acc ON i.accountID = acc.accountID
        WHERE r.providerID = ?
        AND r.reqStatus = 4
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }
}