<?php

class FindJobs {
    use Database;

    public $jobID;
    public $jobTitle;
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
    public $jobStatus;
    public $datePosted;
    public $timePosted;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getJobs() {
        $id = $_SESSION['user_id'];
        $query = 'SELECT j.*, i.fname, i.lname 
                  FROM job j 
                  JOIN individual i ON j.accountID = i.accountID 
                  WHERE j.accountID != ? 
                  ORDER BY j.datePosted DESC, j.timePosted DESC';
        return $this->query($query, [$id]);
    }
}