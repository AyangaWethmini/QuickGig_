<?php

class SendProvider{
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
    $query = "SELECT r.*, i.fname, i.lname, m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location,m.currency
    FROM req_available r 
    JOIN makeavailable m ON r.availableID = m.availableID
    JOIN individual i ON m.accountID = i.accountID
    WHERE r.providerID = ? 
    AND r.reqStatus = 1
    ORDER BY datePosted DESC, timePosted DESC";
    $result = $this->query($query, [$id]);
    
    //error_log(print_r($result, true));
    
    return $result ? $result : [];
}
}