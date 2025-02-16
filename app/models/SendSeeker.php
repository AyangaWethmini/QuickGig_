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
        $query = "SELECT a.*, 
                        CASE 
                            WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                            THEN CONCAT(i.fname, ' ', i.lname) 
                            ELSE o.orgName 
                        END AS name, 
                        j.jobTitle, j.jobID, j.salary, j.currency, j.location, j.availableDate, j.timeFrom, j.timeTo
                FROM apply_job a 
                JOIN job j ON a.jobID = j.jobID
                LEFT JOIN individual i ON j.accountID = i.accountID
                LEFT JOIN organization o ON j.accountID = o.accountID
                WHERE a.seekerID = ? 
                AND a.applicationStatus = 1
                ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }
}