<?php
// models/Complaint.php

class Available
{
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


    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getJobsByUser($userID)
    {
        $query = "SELECT * FROM makeavailable WHERE accountID = :accountID ORDER BY availableDate DESC, timeFrom DESC";
        $params = ['accountID' => $userID];
        return $this->query($query, $params);
    }

    public function create($data)
{
    $query = "INSERT INTO makeavailable (availableID, accountID, description, location, timeFrom, timeTo, availableDate, shift, salary, currency, categories, availabilityStatus) 
              VALUES (:availableID, :accountID, :description, :location, :timeFrom, :timeTo, :availableDate, :shift, :salary, :currency, :categories, :availabilityStatus)";

    $params = [
        'availableID' => $data['availableID'],
        'accountID' => $data['accountID'],
        'description' => $data['description'],
        'location' => $data['location'],
        'timeFrom' => $data['timeFrom'],
        'timeTo' => $data['timeTo'],
        'availableDate' => $data['availableDate'],
        'shift' => $data['shift'],
        'salary' => $data['salary'],
        'currency' => $data['currency'],
        'categories' => $data['categories'],
        'availabilityStatus' => $data['availabilityStatus']
    ];

    return $this->query($query, $params);
}
    public function update($id, $data) {
        $query = "UPDATE makeavailable 
                  SET description = :description, 
                      location = :location, 
                      timeFrom = :timeFrom, 
                      timeTo = :timeTo,
                      availableDate = :availableDate,
                      shift = :shift,
                      salary = :salary,
                      currency = :currency,
                      categories = :categories
                  WHERE availableID = :id";
    
        $params = [
            'id' => $id, 
            'description' => $data['description'],
            'location' => $data['location'],
            'timeFrom' => $data['timeFrom'],
            'timeTo' => $data['timeTo'],
            'availableDate' => $data['availableDate'],
            'shift' => $data['shift'],
            'salary' => $data['salary'],
            'currency' => $data['currency'],
            'categories' => $data['categories']
        ];
    
        return $this->query($query, $params);
    }
    
    public function getAvailabilityById($id) {
        $query = "SELECT * FROM makeavailable WHERE availableID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
    
        if (isset($result[0])) {
            $result[0]->categories = json_decode($result[0]->categories, true);
        }
    
        return isset($result[0]) ? $result[0] : null;
    }

    public function delete($id) {
        $query = "DELETE FROM makeavailable WHERE availableID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function searchJobsByUser($userID, $searchTerm)
    {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT * FROM makeavailable 
                WHERE accountID = :accountID 
                AND (
                    LOWER(description) LIKE :searchTerm OR
                    LOWER(location) LIKE :searchTerm OR
                    LOWER(categories) LIKE :searchTerm
                )
                ORDER BY availableDate DESC, timeFrom DESC";

        $params = [
            'accountID' => $userID,
            'searchTerm' => $searchTerm
        ];

        return $this->query($query, $params);
    }
}
