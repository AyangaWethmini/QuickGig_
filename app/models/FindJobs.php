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
                  ORDER BY j.datePosted DESC, j.timePosted DESC';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }

    public function hasAlreadyApplied($seekerID, $jobID) {
        $query = "SELECT COUNT(*) as count FROM apply_job WHERE seekerID = ? AND jobID = ?";
        $result = $this->query($query, [$seekerID, $jobID]);
    
        return $result[0]->count > 0; // Returns true if an application exists
    }
    
    public function applyForJob($applicationID, $seekerID, $jobID) {
        if ($this->hasAlreadyApplied($seekerID, $jobID)) {
            return false; // Prevent duplicate applications
        }
    
        //$dateApplied = date('Y-m-d');
        //$timeApplied = date('H:i:s');
        $applicationStatus = 1; // Set to 1 as per requirements
    
        $query = "INSERT INTO apply_job (applicationID, seekerID, jobID, applicationStatus) 
                  VALUES (?, ?, ?, ?)";
    
        return $this->query($query, [$applicationID, $seekerID, $jobID, $applicationStatus]);
    }

    public function searchJobs($searchTerm) {
        $id = $_SESSION['user_id'];
        $searchTerm = '%' . strtolower($searchTerm) . '%';
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
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(o.orgName) LIKE ? OR
                      LOWER(j.jobTitle) LIKE ? OR
                      LOWER(j.description) LIKE ? OR
                      LOWER(j.location) LIKE ? OR
                      LOWER(j.categories) LIKE ?
                  )
                  ORDER BY j.datePosted DESC, j.timePosted DESC';
        $result = $this->query($query, [$id, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $result ? $result : [];
    }
    
}