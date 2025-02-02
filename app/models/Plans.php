<?php
class Plans {
    use Database;

    public function getPlans() {
        $query = 'SELECT * FROM advertisement ORDER BY adDate ASC, adTime ASC';
        return $this->query($query);
    }

    public function createPlan($data) {
        $query = "INSERT INTO plan (palnName, descrption, price, duration, badge, postLimit) 
                  VALUES (:palnName, :descrption, :price, :duration, :badge, :postLimit)";
        
        $params = [
            'plaName' => $data['plaName'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration' => $data['duration'],
            'badge' => $data['badge'],
            'postLimit' => $data['postLimit'],
        ];
        
        return $this->query($query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM plan WHERE planID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getPlanById($id) {
        $query = "SELECT * FROM plan WHERE planID = :id";
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