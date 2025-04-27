<?php

class FindEmployees {
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
                  ORDER BY ma.datePosted DESC, ma.timePosted DESC';
        $result = $this->query($query, [$id]);
        return $result ? $result : [];
    }

    public function hasAlreadyApplied($providerID, $availableID) {
        $query = "SELECT COUNT(*) as count FROM req_available WHERE providerID = ? AND availableID = ?";
        $result = $this->query($query, [$providerID, $availableID]);
    
        return $result[0]->count > 0; 
    }
    
    public function applyForJob($reqID, $providerID, $availableID) {
        if ($this->hasAlreadyApplied($providerID, $availableID)) {
            return false; 
        }
    
        
        $reqStatus = 1; 
    
        $query = "INSERT INTO req_available (reqID, providerID, availableID, reqStatus) 
                  VALUES (?, ?, ?, ?)";
    
        return $this->query($query, [$reqID, $providerID, $availableID, $reqStatus]);
    }

    public function searchEmployees($searchTerm) {
        $id = $_SESSION['user_id'];
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = 'SELECT ma.*, i.fname, i.lname, acc.pp
                FROM makeAvailable ma
                JOIN individual i ON ma.accountID = i.accountID
                JOIN account acc ON ma.accountID = acc.accountID
                WHERE ma.accountID != ?
                AND ma.availabilityStatus = 1
                AND (
                    LOWER(i.fname) LIKE ? OR
                    LOWER(i.lname) LIKE ? OR
                    LOWER(ma.description) LIKE ? OR
                    LOWER(ma.location) LIKE ? OR
                    LOWER(ma.categories) LIKE ?
                )
                ORDER BY ma.datePosted DESC, ma.timePosted DESC';
        $result = $this->query($query, [$id, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $result ? $result : [];
    }

    public function filterEmployees($searchTerm, $shift, $date, $location)
{
    $id = $_SESSION['user_id'];
    $query = 'SELECT ma.*, i.fname, i.lname, acc.pp
              FROM makeAvailable ma
              JOIN individual i ON ma.accountID = i.accountID
              JOIN account acc ON ma.accountID = acc.accountID
              WHERE ma.accountID != ?
              AND ma.availabilityStatus = 1';

    $params = [$id];

    if (!empty($searchTerm)) {
        $query .= ' AND (
            LOWER(i.fname) LIKE ? OR
            LOWER(i.lname) LIKE ? OR
            LOWER(ma.description) LIKE ? OR
            LOWER(ma.location) LIKE ? OR
            LOWER(ma.categories) LIKE ?
        )';
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $params = array_merge($params, array_fill(0, 5, $searchTerm));
    }

    if ($shift !== 'any') {
        $query .= ' AND ma.shift = ?';
        $params[] = $shift;
    }

    if (!empty($date)) {
        $query .= ' AND ma.availableDate = ?';
        $params[] = $date;
    }

    if (!empty($location)) {
        $query .= ' AND LOWER(ma.location) LIKE ?';
        $params[] = '%' . strtolower($location) . '%';
    }

    $query .= ' ORDER BY ma.datePosted DESC, ma.timePosted DESC';

    $result = $this->query($query, $params);
    return $result ? $result : [];
}
}