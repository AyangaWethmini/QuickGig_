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
}