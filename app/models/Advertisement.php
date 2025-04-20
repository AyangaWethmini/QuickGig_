<?php
class Advertisement
{
    use Database;

    public function getAdvertisements()
    {
        $query = 'SELECT * FROM advertisement WHERE deleted = 0 ORDER BY createdAt ASC;';
        return $this->query($query);
    }

    public function createAdvertisement($data)
{
    try {
        $query = "INSERT INTO advertisement 

                 (advertiserID, adTitle, adDescription, img, link, startDate, endDate, adStatus) 
                 VALUES (:advertiserID, :adTitle, :adDescription, :adImage, :link, :startDate, :endDate, :adStatus)";

        $params = [
            'advertiserID' => $data['advertiserID'] ?? null,
            'adTitle' => $data['adTitle'] ?? '',
            'adDescription' => $data['adDescription'] ?? '',
            'adImage' => $data['adImage'] ?? null, // Consider storing image path instead of binary data
            'link' => $data['link'] ?? '',
            'startDate' => $data['startDate'] ?? date('Y-m-d'),
            'endDate' => $data['endDate'] ?? date('Y-m-d', strtotime('+1 month')),
            'adStatus' => $data['adStatus'] ?? 'inactive'
        ];

        // Validate required fields
        if (empty($params['advertiserID']) || empty($params['adTitle'])) {
            throw new Exception("Required fields are missing");
        }

        $result = $this->query($query, $params);
        
        if (!$result) {
            // Get the specific database error if available
            throw new Exception("Database error: " . ($errorInfo ?? 'Unknown error'));
        }

        return $result;
    } catch (Exception $e) {
        error_log("Advertisement creation failed: " . $e->getMessage());
        return false;
    }
}


    public function delete($id)
    {
        $query = "UPDATE advertisement SET deleted = 1 WHERE advertisementID = :id";
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
                  link = :link,
                  startDate = :startDate,
                  endDate = :endDate,
                  adStatus = :adStatus 
              WHERE advertisementID = :id";

    $params = [
        'id' => $id,
        'adTitle' => $data['adTitle'],
        'adDescription' => $data['adDescription'],
        'img' => $data['img'] ?? null,
        'link' => $data['link'],
        'startDate' => $data['startDate'],
        'endDate' => $data['endDate'],
        'adStatus' => $data['adStatus']
    ];

    return $this->query($query, $params);
}



    public function getAdsCountDateRange($startDate, $endDate)
    {
        $query = "SELECT COUNT(*) AS totalAds FROM advertisement 
                  WHERE startDate >= :startDate AND endDate <= :endDate";
        $params = [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        $result = $this->query($query, $params);
        return $result[0]->totalAds ?? 0;
    }

    public function getActiveAdsCount()
    {
        $query = "SELECT COUNT(*) AS totalAds FROM advertisement WHERE adStatus = 'active'";
        $result = $this->query($query);
        return $result[0]->totalAds ?? 0;
    }

    public function getActiveAds()
    {
        $query = "SELECT * FROM advertisement 
              WHERE adStatus = 'active' AND endDate > NOW() AND startDate <= NOW() AND deleted = 0";
        $result = $this->query($query);
        return $result ?? null;
    }

    public function recordClick($adId)
    {
        $query = "UPDATE advertisement 
                 SET clicks = clicks + 1 
                 WHERE advertisementID = :adId";
        $params = ['adId' => $adId];
        return $this->query($query, $params);
    }

    public function addView($adId) {
        $query = "UPDATE advertisement SET views = views + 1 WHERE advertisementID = :adId";
        $params = ['adId' => $adId];
        $this->query($query, $params); // No return needed
    }

    public function getAdRev($startDate, $endDate) {
        $query = "SELECT SUM(price) AS totalRevenue FROM advertisement 
                  WHERE startDate >= :startDate AND endDate <= :endDate";
        $params = [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        $result = $this->query($query, $params);    
        return $result[0]->totalRevenue ?? 0;
    }
}
