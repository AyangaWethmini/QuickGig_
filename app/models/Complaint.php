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
        $query = 'SELECT * FROM complaint where complainantID=1 ORDER BY complaintDate DESC, complaintTime DESC';
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

    public function getComplaintById($id) {
        $query = "SELECT * FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
    
        return isset($result[0]) ? $result[0] : null;
    }
    
    
    public function update($id, $data) {
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