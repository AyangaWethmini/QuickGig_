<?php
// models/Admin.php

class AdminModel
{
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

    public function getTotalAnnouncements()
    {
        $query = "SELECT COUNT(*) as count FROM announcement";
        $result = $this->query($query);
        return $result[0]->count;
    }

    public function getAnnouncementsPaginated($start, $limit)
    {
        // Cast parameters to integers to ensure proper SQL syntax
        $start = (int)$start;
        $limit = (int)$limit;

        $query = "SELECT * FROM announcement 
                  ORDER BY announcementDate DESC, announcementTime DESC 
                  LIMIT $start, $limit";  // Use direct integers instead of parameters

        $result = $this->query($query);
        return $result ?: [];
    }

    public function getJobCount()
    {
        $query = 'SELECT COUNT(*) AS jobcount FROM job';
        $result = $this->query($query);

        // Ensure the result is an array and has at least one element
        if (is_array($result) && isset($result[0]->jobcount)) {
            return $result[0]->jobcount; // Access the 'jobcount' property from the first object
        }

        return 0; // Return 0 if no rows match or query fails
    }

    /* ADMIN DASHBOARD */
    public function getCountByRoleID($roleID)
    {
        $query = "SELECT COUNT(*) AS count FROM account_role WHERE roleID = :roleID";

        // Parameters for the query
        $params = [
            'roleID' => $roleID
        ];

        // Execute the query
        $result = $this->query($query, $params); // Returns an array of objects or false

        // Handle the result
        if (is_array($result) && isset($result[0]->count)) {
            return $result[0]->count; // Access the 'count' property from the first object
        }

        return 0; // Return 0 if no rows match or query fails
    }

    public function getAnnouncements()
    {
        $query = 'SELECT * FROM announcement ORDER BY announcementDate DESC, announcementTime DESC';
        return $this->query($query);
    }

    // Properties representing the columns in the account table
    public function createAnnouncement($data, $adminId)
    {
        // Include adminID as a fixed value (1)
        $query = "INSERT INTO announcement (announcementID, announcementDate, announcementTime, content, adminID) 
                  VALUES (:announcementID, :announcementDate, :announcementTime, :content, :adminID)";

        // Adding adminID to the params array with a fixed value of 1
        $params = [
            'announcementID' => NULL,
            'announcementDate' => $data['announcementDate'],
            'announcementTime' => $data['announcementTime'],
            'content' => $data['content'],
            'adminID' => $adminId,
        ];

        // Execute the query
        return $this->query($query, $params);
    }


    public function getAnnouncementById($announcementID)
    {
        $query = "SELECT * FROM announcement WHERE announcementID = :announcementID LIMIT 1";
        $params = [
            ':announcementID' => $announcementID
        ];

        $result = $this->query($query, $params);

        // Debug the query result
        // var_dump($result);
        // exit;

        return $result ? $result[0] : false;
    }

    public function delete($announcementID)
    {
        $query = "DELETE FROM announcement WHERE announcementID = :announcementID";
        $params = [
            ':announcementID' => $announcementID,
        ];
        return $this->query($query, $params);
    }

    public function updateAnnouncements($announcementID, $data)
    {
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
