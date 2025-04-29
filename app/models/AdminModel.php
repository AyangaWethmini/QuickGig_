<?php


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
        
    }

    public function getTotalAnnouncements()
    {
        $query = "SELECT COUNT(*) as count FROM announcement";
        $result = $this->query($query);
        return $result[0]->count;
    }

    public function getAnnouncementsPaginated($start, $limit)
    {
        
        $start = (int)$start;
        $limit = (int)$limit;

        $query = "SELECT * FROM announcement 
                  ORDER BY announcementDate DESC, announcementTime DESC 
                  LIMIT $start, $limit";  

        $result = $this->query($query);
        return $result ?: [];
    }

    public function getJobCount()
    {
        $query = 'SELECT COUNT(*) AS jobcount FROM job';
        $result = $this->query($query);

        
        if (is_array($result) && isset($result[0]->jobcount)) {
            return $result[0]->jobcount;
        }

        return 0; 
    }

    
    public function getCountByRoleID($roleID)
    {
        $query = "SELECT COUNT(*) AS count FROM account_role WHERE roleID = :roleID";

        
        $params = [
            'roleID' => $roleID
        ];

    
        $result = $this->query($query, $params); 

    
        if (is_array($result) && isset($result[0]->count)) {
            return $result[0]->count; 
        }

        return 0; 
    }

    public function getAnnouncements()
    {
        $query = 'SELECT * FROM announcement ORDER BY announcementDate DESC, announcementTime DESC';
        return $this->query($query);
    }

    public function getAnnouncementsFiltered($anDate = null){
        try{
            if($anDate){
                $query = "SELECT * FROM announcement WHERE announcementDate = :anDate";
                $params = [
                    ':announcementDate' => $anDate,
                ];

                $result = $this->query($query, $params);
                return $result;
            }else{
                $query = "SELECT * FROM announcement ORDER BY announcementDate DESC, announcementTime DESC";
                $result = $this->query($query);
                return $result;
            }
            
        }catch (Exception $e) {
            error_log("Error calculating ad revenue: " . $e->getMessage());
            return false;
        }
        
    }

    
    public function createAnnouncement($data, $adminId)
    {
        
        $query = "INSERT INTO announcement (announcementID, announcementDate, announcementTime, title, content, adminID) 
                  VALUES (:announcementID, :announcementDate, :announcementTime, :content, :title, :adminID)";

        
        $params = [
            'announcementID' => NULL,
            'announcementDate' => $data['announcementDate'],
            'announcementTime' => $data['announcementTime'],
            'title' => $data['title'],
            'content' => $data['content'],
            'adminID' => $adminId,
        ];

        
        return $this->query($query, $params);
    }


    public function getAnnouncementById($announcementID)
    {
        $query = "SELECT * FROM announcement WHERE announcementID = :announcementID LIMIT 1";
        $params = [
            ':announcementID' => $announcementID
        ];

        $result = $this->query($query, $params);

        
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

    public function getCount($adDate)
    {
        $query = "SELECT COUNT(*) AS count FROM announcement WHERE advertisementDate = :adDate";
        $result = $this->query($query);

        
        if (is_array($result) && isset($result[0]->count)) {
            return $result[0]->count; 
        }

        return 0;
    }
    public function searchUsersByEmail($searchTerm)
    {
        $query = "SELECT a.*, ar.roleID, a.activationCode 
                  FROM account a
                  JOIN account_role ar ON a.accountID = ar.accountID
                  WHERE a.email LIKE :email
                  ORDER BY a.email ASC";

        $params = [
            ':email' => '%' . $searchTerm . '%'
        ];

        $result = $this->query($query, $params);
        return $result ?: [];
    }
}
