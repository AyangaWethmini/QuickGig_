<?php

class Advertisement {
    use Database;

    public $advertiserID;
    public $adTitle;
    public $adDate;
    public $adTime;
    public $clicks;
    public $img;
    public $adDescription;
    public $link;
    public $status;
    

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getAdvertisements() {
        $query = 'SELECT * FROM advertisement ORDER BY adDate DESC, adTime DESC';
        return $this->query($query);
    }

    public function create($data) {
        $query = "INSERT INTO advertisement (advertiserId, adTitle, adDate, adTime, clicks, img, adDescription, link, adStatus) 
                  VALUES (:advertiserId, :adTitle, :adDate, :adTime, :clicks, :img, :adDescription, :link, :adStatus)";
        
        $params = [
            'advertiserID' => $data['advertiserID'],
            'adTitle' => $data['adTitle'],
            'adDate' => $data['adDate'],
            'adTime' => $data['adTime'],
            'clicks' => $data['clicks'],
            'img' => $data['img'],
            'adDescription' => $data['adDescription'],
            'link' => $data['link'],
            'adStatus' => $data['adStatus']
        ];
        
        return $this->query($query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM advertisement WHERE advertisementID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getAdById($id) {
        $query = "SELECT * FROM advertisement WHERE advertisementID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
    
        return isset($result[0]) ? $result[0] : null;
    }
    
    
    public function update($id, $data) {
        $query = "UPDATE advertisement 
                  SET adDescription = :adDescription, 
                      img = :img, 
                      adTitle = :adTitle, 
                      complaintDate = :complaintDate, 
                      complaintTime = :complaintTime 
                  WHERE complaintID = :id";
    
        $params = [
            'id' => $id,
            'adDescription' => $data['adDescription'],
            'img' => $data['img'],
            'adTitle' => $data['adTitle'],
            'complaintDate' => $data['complaintDate'],
            'complaintTime' => $data['complaintTime']
        ];
    
        return $this->query($query, $params);
    }
    
}