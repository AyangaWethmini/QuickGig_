<?php
// models/Complaint.php

class Complaint {
    use Database;

    public $complainantID;
    public $content;
    public $complaintDate;
    public $complaintTime;
    public $complaintStatus;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getComplaints() {
        $query = 'SELECT * FROM complaint ORDER BY complaintDate ASC, complaintTime ASC';
        return $this->query($query);
    }

    public function create($data) {
        $query = "INSERT INTO complaint (complainantID, content, complaintDate, complaintTime, complaintStatus) 
                  VALUES (:complainantID, :content, :complaintDate, :complaintTime, :complaintStatus)";
        
        $params = [
            'complainantID' => $data['complainantID'],
            'content' => $data['content'],
            'complaintDate' => $data['complaintDate'],
            'complaintTime' => $data['complaintTime'],
            'complaintStatus' => $data['complaintStatus']
        ];
        
        return $this->query($query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }
}