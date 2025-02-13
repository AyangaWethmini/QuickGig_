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
        $query = 'SELECT ma.*, i.fname, i.lname 
                  FROM makeAvailable ma 
                  JOIN individual i ON ma.accountID = i.accountID 
                  WHERE ma.accountID != ? 
                  ORDER BY ma.datePosted DESC, ma.timePosted DESC';
        return $this->query($query, [$id]);
    }
}