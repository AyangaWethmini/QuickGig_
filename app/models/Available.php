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


    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getJobsByUser($userID)
    {
        $query = "SELECT * FROM makeavailable WHERE accountID = :accountID ORDER BY availableDate DESC LIMIT 50";

        $params = ['accountID' => $userID];
        return $this->query($query, $params);
    }

    public function create($data)
    {
        $query = "INSERT INTO makeavailable (availableID, accountID, description, location, timeFrom, timeTo, availableDate, shift,salary,currency) 
                  VALUES (:availableID, :accountID, :description, :location, :timeFrom,:timeTo, :availableDate, :shift,:salary,:currency)";

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
            'currency' => $data['currency']
        ];

        return $this->query($query, $params);
    }


    public function delete($id)
    {
        $query = "DELETE FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getComplaintById($id)
    {
        $query = "SELECT * FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }


    public function update($id, $data)
    {
        $query = "UPDATE complaint SET content = :content, complaintDate = :complaintDate, complaintTime = :complaintTime WHERE complaintID = :id";
        $params = [
            'id' => $id,
            'content' => $data['content'],
            'complaintDate' => $data['complaintDate'],
            'complaintTime' => $data['complaintTime']
        ];
        return $this->query($query, $params);
    }
}
