<?php

class ToBeCompletedSeeker{
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


    public function getReqAvailableTBC()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*, 
                         CASE 
                             WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                             THEN CONCAT(i.fname, ' ', i.lname) 
                             ELSE o.orgName 
                         END AS name, 
                         m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location, m.currency, acc.pp
                  FROM req_available r 
                  JOIN makeavailable m ON r.availableID = m.availableID
                  LEFT JOIN individual i ON r.providerID = i.accountID
                  LEFT JOIN organization o ON r.providerID = o.accountID
                  JOIN account acc ON r.providerID = acc.accountID
                  WHERE m.accountID = ? 
                  AND r.reqStatus = 2
                  ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        //error_log(print_r($result, true));
        
        return $result ? $result : [];
    }

    public function getApplyJobTBC()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, 
                        CASE 
                             WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                             THEN CONCAT(i.fname, ' ', i.lname) 
                             ELSE o.orgName 
                         END AS name,
                         j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.location, j.salary, j.currency
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        LEFT JOIN individual i ON j.accountID = i.accountID
        LEFT JOIN organization o ON j.accountID = o.accountID
        JOIN account acc ON j.accountID = acc.accountID
        WHERE a.seekerID = ? 
        AND a.applicationStatus = 2
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function searchReqAvailableTBC($userID, $searchTerm)
    {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT r.*, 
                        CASE 
                            WHEN i.fname IS NOT NULL AND i.lname IS NOT NULL 
                            THEN CONCAT(i.fname, ' ', i.lname) 
                            ELSE o.orgName 
                        END AS name, 
                        m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location, m.currency, acc.pp
                FROM req_available r 
                JOIN makeavailable m ON r.availableID = m.availableID
                LEFT JOIN individual i ON r.providerID = i.accountID
                LEFT JOIN organization o ON r.providerID = o.accountID
                JOIN account acc ON r.providerID = acc.accountID
                WHERE m.accountID = ? 
                AND r.reqStatus = 2
                AND (
                    LOWER(i.fname) LIKE ? OR
                    LOWER(i.lname) LIKE ? OR
                    LOWER(m.description) LIKE ? OR
                    LOWER(m.location) LIKE ?
                )
                ORDER BY datePosted DESC, timePosted DESC";

        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
}