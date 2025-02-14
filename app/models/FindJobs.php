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
        $query = 'SELECT j.*, 
                         COALESCE(i.fname, o.orgName) AS name, 
                         i.lname 
                  FROM job j 
                  LEFT JOIN individual i ON j.accountID = i.accountID 
                  LEFT JOIN organization o ON j.accountID = o.accountID 
                  WHERE j.accountID != ? 
                  AND j.jobStatus = 1 
                  ORDER BY j.datePosted DESC, j.timePosted DESC';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }
}