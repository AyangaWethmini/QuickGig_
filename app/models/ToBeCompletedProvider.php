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


    public function getTBC()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 2
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }
}