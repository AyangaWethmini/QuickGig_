<?php
class Advertisement {
    use Database;

    public function getAdvertisements() {
        $query = 'SELECT * FROM advertisement ORDER BY adDate ASC, adTime ASC';
        return $this->query($query);
    }

    public function createAdvertisement($data) {
        $query = "INSERT INTO advertisement (advertiserID, adTitle, adDate, adTime, clicks, img, adDescription, link, adStatus, duration) 
                  VALUES (:advertiserID, :adTitle, :adDate, :adTime, :clicks, :img, :adDescription, :link, :adStatus, :duration)";
        
        $params = [
            'advertiserID' => $data['advertiserID'],
            'adTitle' => $data['adTitle'],
            'adDate' => $data['adDate'],
            'adTime' => $data['adTime'],
            'clicks' => $data['clicks'],
            'img' => $data['img'],
            'adDescription' => $data['adDescription'],
            'link' => $data['link'],
            'adStatus' => $data['adStatus'],
            'duration' => $data['duration']
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
        return $result[0] ?? null;
    }

    public function update($id, $data) {
        $query = "UPDATE advertisement 
                  SET adTitle = :adTitle, 
                      adDescription = :adDescription, 
                      img = :img, 
                      adDate = :adDate, 
                      adTime = :adTime, 
                      link = :link,
                      duration = :duration,
                      adStatus = :adStatus 
                  WHERE advertisementID = :id";
    
        $params = [
            'id' => $id,
            'adTitle' => $data['adTitle'],
            'adDescription' => $data['adDescription'],
            'img' => $data['img'],
            'adDate' => $data['adDate'],
            'adTime' => $data['adTime'],
            'link' => $data['link'],
            'duration' => $data['duration'],
            'adStatus' => $data['adStatus']
        ];
    
        return $this->query($query, $params);
    }
}