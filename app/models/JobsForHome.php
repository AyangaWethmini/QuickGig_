<?php

class JobsForHome {
    use Database;

    public $availableID;
    public $accountID;
    public $description;
    public $location;
    public $timeFrom;
    public $timeTo;
    public $availableDate;
    public $shift;
    public $salary;
    public $currency;
    public $categories;
    public $availabilityStatus;
    public $datePosted;
    public $timePosted;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getEmployees() {
        $id = $_SESSION['user_id'];
        $query = 'SELECT ma.*, i.fname, i.lname , acc.pp
                  FROM makeAvailable ma 
                  JOIN individual i ON ma.accountID = i.accountID 
                  Join account acc ON ma.accountID = acc.accountID
                  WHERE ma.accountID != ?
                  AND ma.availabilityStatus = 1
                  ORDER BY ma.datePosted DESC, ma.timePosted DESC LIMIT 8';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }

    
    
}