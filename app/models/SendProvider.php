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
    }


    public function getSendRequests(){   

    $id = $_SESSION['user_id'];
    $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location,m.currency, acc.pp
    FROM req_available r 
    JOIN makeavailable m ON r.availableID = m.availableID
    JOIN individual i ON m.accountID = i.accountID
    JOIN account acc ON m.accountID = acc.accountID
    WHERE r.providerID = ? 
    AND r.reqStatus = 1
    ORDER BY datePosted DESC, timePosted DESC";
    $result = $this->query($query, [$id]);
    
    
    return $result ? $result : [];
    }

    public function deleteSendRequest($reqID) {
        $query = "DELETE FROM req_available WHERE reqID = ?";
        return $this->query($query, [$reqID]);
    }

    public function searchSendRequests($userID, $searchTerm) {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location, m.currency, acc.pp
                  FROM req_available r 
                  JOIN makeavailable m ON r.availableID = m.availableID
                  JOIN individual i ON m.accountID = i.accountID
                  JOIN account acc ON m.accountID = acc.accountID
                  WHERE r.providerID = ? 
                  AND r.reqStatus = 1
                  AND (
                      LOWER(i.fname) LIKE ? OR
                      LOWER(i.lname) LIKE ? OR
                      LOWER(m.description) LIKE ? OR
                      LOWER(m.location) LIKE ? 
                  )
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function filterSendRequestsByDate($userID, $filterDate) {
        $query = "SELECT r.*,i.accountID, i.fname, i.lname, m.timeFrom, m.timeTo, m.availableDate, m.description, m.salary, m.location, m.currency, acc.pp
                  FROM req_available r 
                  JOIN makeavailable m ON r.availableID = m.availableID
                  JOIN individual i ON m.accountID = i.accountID
                  JOIN account acc ON m.accountID = acc.accountID
                  WHERE r.providerID = ? 
                  AND r.reqStatus = 1
                  AND m.availableDate = ?
                  ORDER BY datePosted DESC, timePosted DESC";
        return $this->query($query, [$userID, $filterDate]);
    }

}