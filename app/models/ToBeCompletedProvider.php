<?php

class ToBeCompletedProvider{
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

    public function getApplyJobTBC()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.location, j.salary, j.currency
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 2
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function getReqAvailableTBC()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*, i.fname, i.lname, m.description, m.availableID, acc.pp, m.timeFrom, m.timeTo, m.availableDate, m.location, m.salary, m.currency
        FROM req_available r
        JOIN makeavailable m ON r.availableID = m.availableID
        JOIN individual i ON m.accountID = i.accountID
        JOIN account acc ON i.accountID = acc.accountID
        WHERE r.providerID = ?
        AND r.reqStatus = 2
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }
}