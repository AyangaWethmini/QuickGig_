<?php

class ProviderNotDone{
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

    public function getApplyJobCompleted()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT a.*, i.accountID,i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency, j.location
        FROM apply_job a 
        JOIN job j ON a.jobID = j.jobID
        JOIN individual i ON a.seekerID = i.accountID
        JOIN account acc ON a.seekerID = acc.accountID
        WHERE j.accountID = ? 
        AND a.applicationStatus = 6
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function getReqAvailableCompleted()
    {   
        $id = $_SESSION['user_id'];
        $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.description, m.availableID, acc.pp, m.availableDate, m.timeFrom, m.timeTo, m.salary, m.currency, m.location
        FROM req_available r
        JOIN makeavailable m ON r.availableID = m.availableID
        JOIN individual i ON m.accountID = i.accountID
        JOIN account acc ON i.accountID = acc.accountID
        WHERE r.providerID = ?
        AND r.reqStatus = 6
        ORDER BY datePosted DESC, timePosted DESC";
        $result = $this->query($query, [$id]);
        
        return $result ? $result : [];
    }

    public function getEmployeeDetails($taskID)
    {
        // Check if the taskID is in the reqID field of req_available
        $query = "SELECT COUNT(*) as count FROM req_available WHERE reqID = ?";
        $result = $this->query($query, [$taskID]);

        if ($result[0]->count > 0) {
            // If taskID is found in req_available, execute the relevant query
            $query = "SELECT r.*, i.accountID,i.fname, i.lname, m.description as title, m.availableID as ja, m.availableDate, m.timeFrom, m.timeTo, m.salary, m.currency, m.location, m.accountID
                    FROM req_available r
                    JOIN makeavailable m ON r.availableID = m.availableID
                    JOIN individual i ON m.accountID = i.accountID
                    WHERE r.reqID = ?";
            $result = $this->query($query, [$taskID]);
        } else {
            // If taskID is not found in req_available, check if it is in apply_job
            $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle as title, j.jobID ja, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency, j.location, i.accountID
                    FROM apply_job a 
                    JOIN job j ON a.jobID = j.jobID
                    JOIN individual i ON a.seekerID = i.accountID
                    WHERE a.applicationID = ?";
            $result = $this->query($query, [$taskID]);
        }

        return $result ? $result[0] : null;
    }

    public function searchCompleted($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency, j.location
                  FROM apply_job a 
                  JOIN job j ON a.jobID = j.jobID
                  JOIN individual i ON a.seekerID = i.accountID
                  JOIN account acc ON a.seekerID = acc.accountID
                  WHERE j.accountID = ? 
                  AND a.applicationStatus = 6
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(j.jobTitle) LIKE ? OR
                      LOWER(j.location) LIKE ?
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function searchReqAvailableCompleted($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.description, m.availableID, acc.pp, m.availableDate, m.timeFrom, m.timeTo, m.salary, m.currency, m.location
                  FROM req_available r
                  JOIN makeavailable m ON r.availableID = m.availableID
                  JOIN individual i ON m.accountID = i.accountID
                  JOIN account acc ON i.accountID = acc.accountID
                  WHERE r.providerID = ? 
                  AND r.reqStatus = 6
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(m.description) LIKE ? OR
                      LOWER(m.location) LIKE ?
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function filterCompletedByDate($userID, $filterDate) {
        $query = "SELECT a.*,i.accountID, i.fname, i.lname, j.jobTitle, j.jobID, acc.pp, j.availableDate, j.timeFrom, j.timeTo, j.salary, j.currency, j.location
                  FROM apply_job a 
                  JOIN job j ON a.jobID = j.jobID
                  JOIN individual i ON a.seekerID = i.accountID
                  JOIN account acc ON a.seekerID = acc.accountID
                  WHERE j.accountID = ? 
                  AND a.applicationStatus = 6
                  AND j.availableDate = ?
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $filterDate]);
    }

    public function filterReqAvailableCompletedByDate($userID, $filterDate) {
        $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.timeFrom, m.timeTo, m.availableDate, m.salary, m.currency, m.location, acc.pp, m.description, m.availableID
                  FROM req_available r
                  JOIN makeavailable m ON r.availableID = m.availableID
                  JOIN individual i ON m.accountID = i.accountID
                  JOIN account acc ON m.accountID = acc.accountID
                  WHERE r.providerID = ? 
                  AND r.reqStatus = 6
                  AND m.availableDate = ?
                  ORDER BY m.availableDate DESC, m.timeFrom DESC";
        return $this->query($query, [$userID, $filterDate]);
    }
}