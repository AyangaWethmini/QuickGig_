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
                  ORDER BY ma.datePosted DESC, ma.timePosted DESC LIMIT 10';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }
    public function getJobs() {
        $id = $_SESSION['user_id'];
        $query = 'SELECT j.*, acc.pp,
                         CASE 
                             WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                             THEN CONCAT(i.fname, " ", i.lname) 
                             ELSE o.orgName 
                         END AS name
                  FROM job j 
                  LEFT JOIN individual i ON j.accountID = i.accountID 
                  LEFT JOIN organization o ON j.accountID = o.accountID
                  LEFT JOIN account acc ON j.accountID = acc.accountID
                  WHERE j.accountID != ? 
                  AND j.jobStatus = 1 
                  ORDER BY j.datePosted DESC, j.timePosted DESC LIMIT 10';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }
    

    
    
}