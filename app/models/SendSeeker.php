<?php

class SendSeeker{
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


    public function getSendRequests()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.fname, i.lname, j.jobTitle, j.jobID, j.jobTitle, j.salary, j.currency, j.location, j.availableDate, j.timeFrom, j.timeTo
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        WHERE a.seekerID = ? 
        AND a.applicationStatus = 1
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }
}