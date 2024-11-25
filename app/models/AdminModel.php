<?php
// models/Admin.php

class AdminModel{
    use Model;

    protected $table = 'announcement';

    public $adminId;
    public $name;
    public $email;
    public $password;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getAnnouncements() {
        $query = 'SELECT * FROM announcement ORDER BY announcementDate DESC, announcementTime DESC';
        return $this->query($query);
    }

    // Properties representing the columns in the account table
    public function createAnnouncement($data) {
        // Include adminID as a fixed value (1)
        $query = "INSERT INTO announcement (announcementID, announcementDate, announcementTime, content, adminID) 
                  VALUES (:announcementID, :announcementDate, :announcementTime, :content, :adminID)";
        
        // Adding adminID to the params array with a fixed value of 1
        $params = [
            'announcementID' => $data['announcementID'],
            'announcementDate' => $data['announcementDate'],
            'announcementTime' => $data['announcementTime'],
            'content' => $data['content'],
            'adminID' => 1,  // Fixed adminID of 1
        ];
        
        // Execute the query
        return $this->query($query, $params);
    }

    
    public function getAnnouncementById($announcementID){
        $query = "SELECT * FROM announcement where announcementID = :announcementID";
        $params = [
            ':announcementID' => $announcementID
        ];

        return $this->get_row($query, $params);
    }

    public function delete($announcementID) {
        $query = "DELETE FROM announcement WHERE announcementID = :announcementID";
        $params = [
            ':announcementID' => $announcementID,
        ];
        return $this->query($query, $params);
    }

    public function updateAnnouncements($announcementID, $data) {
        $query = "UPDATE announcement SET 
                  announcementDate = :announcementDate, 
                  announcementTime = :announcementTime, 
                  content = :content 
                  WHERE announcementID = :announcementID";
    
        $params = [
            ':announcementID' => $announcementID,
            ':announcementDate' => $data['announcementDate'],
            ':announcementTime' => $data['announcementTime'],
            ':content' => $data['content'],
        ];
    
        return $this->query($query, $params);
    }
    

}