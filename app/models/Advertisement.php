<?php
class Advertisement
{
    use Database;

    public function getAdvertisements()
    {
        $query = 'SELECT * FROM advertisement ORDER BY createdAt ASC';
        return $this->query($query);
    }

    public function createAdvertisement($data)
    {
        $query = "INSERT INTO advertisement (advertiserID, adTitle, adDescription, img, link, startDate, endDate, adStatus) 
                  VALUES (:advertiserID, :adTitle, :adDescription, :img, :link, :startDate, :endDate, :adStatus)";

        $params = [
            'advertiserID' => $data['advertiserID'],
            'adTitle' => $data['adTitle'],
            'adDescription' => $data['adDescription'],
            'img' => $data['adImage'], // Corrected key
            'link' => $data['link'],
            'startDate' => $data['startDate'],
            'endDate' => $data['endDate'],
            'adStatus' => $data['adStatus']
        ];

        return $this->query($query, $params);
    }


    public function delete($id)
    {
        $query = "DELETE FROM advertisement WHERE advertisementID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getAdById($id)
    {
        $query = "SELECT * FROM advertisement WHERE advertisementID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return $result[0] ?? null;
    }

    public function update($id, $data)
    {
        $query = "UPDATE advertisement 
                  SET adTitle = :adTitle, 
                      adDescription = :adDescription, 
                      img = :img, 
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
            'adTime' => $data['adTime'],
            'link' => $data['link'],
            'duration' => $data['duration'],
            'adStatus' => $data['adStatus']
        ];

        return $this->query($query, $params);
    }

    public function getAdsCount()
    {
        $query = "SELECT COUNT(*) AS totalAds FROM advertisement WHERE adStatus = 'active'";
        $result = $this->query($query);
        return $result[0]->totalAds ?? 0;
    }

    public function getRandomActiveAd()
    {
        $query = "SELECT * FROM advertisement 
              WHERE adStatus = 'active' AND endDate > NOW() 
              ORDER BY RAND() LIMIT 1";
        $result = $this->query($query);
        return $result[0] ?? null;
    }

    public function recordClick($adId) {
        $query = "UPDATE advertisement 
                 SET clicks = clicks + 1 
                 WHERE advertisementID = :id";
        $params = ['id' => $adId];
        return $this->query($query, $params);
    }
}
