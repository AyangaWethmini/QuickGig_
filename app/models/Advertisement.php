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
                 (advertisementID, advertiserID, adTitle, adDescription, img, link, startDate, endDate, adStatus) 
                 VALUES (:advertisementID, :advertiserID, :adTitle, :adDescription, :adImage, :link, :startDate, :endDate, :adStatus)";

            $params = [
                'advertisementID' => $data['advertisementID'] ?? throw new Exception("advertisementID is required"),
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
            if (empty($params['advertisementID']) || empty($params['advertiserID']) || empty($params['adTitle'])) {
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

    public function updateAdvertisementStatus($advertisementId, $data)
    {
        try {
            $query = "UPDATE advertisement SET 
                 adStatus = :adStatus,
                 paymentStatus = :paymentStatus,
                 paymentDate = :paymentDate,
                 transactionId = :transactionId
                 WHERE advertisementID = :advertisementID";

            $params = [
                'advertisementID' => $advertisementId,
                'adStatus' => $data['adStatus'],
                'paymentStatus' => $data['paymentStatus'],
                'paymentDate' => $data['paymentDate'],
                'transactionId' => $data['transactionId']
            ];

            return $this->query($query, $params) !== false;
        } catch (PDOException $e) {
            error_log("Advertisement update failed: " . $e->getMessage());
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
              WHERE adStatus = 'active' AND endDate > NOW() AND startDate <= NOW() AND deleted = 0 
              ORDER BY RAND() LIMIT 1";
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

    public function addView($adId)
    {
        $query = "UPDATE advertisement SET views = views + 1 WHERE advertisementID = :adId";
        $params = ['adId' => $adId];
        $this->query($query, $params); // No return needed
    }



    public function updateAdRates($data)
    {
        $query = "UPDATE ad_rates SET flat_fee_weekly = :flat_fee_weekly, per_click = :per_click, per_view = :per_view;";
        $params = [
            'flat_fee_weekly' => $data['flat_fee_weekly'],
            'per_click' => $data['per_click'],
            'per_view' => $data['per_view']
        ];
        return $this->query($query, $params);
    }

    public function getTotalAdvertisements()
    {
        $query = "SELECT COUNT(*) as count FROM advertisement";
        $result = $this->query($query);
        return $result[0]->count;
    }

    public function getAdvertisementsPaginated($start, $limit)
    {
        // Cast parameters to integers to ensure proper SQL syntax
        $start = (int)$start;
        $limit = (int)$limit;

        $query = "SELECT * FROM advertisement 
                  ORDER BY createdAt DESC 
                  LIMIT $start, $limit";

        $result = $this->query($query);
        return $result ?: [];
    }


    public function createAdvertisementRecievedOnline($data)
    {
        try {
            $query = "INSERT INTO advertisement 
                     (advertisementID, advertiserID, adTitle, adDescription, img, link, 
                      startDate, endDate, adStatus, amount, paymentStatus, onlineAd)
                     VALUES (:advertisementID, :advertiserID, :adTitle, :adDescription, :img, :link, 
                             :startDate, :endDate, :adStatus, :amount, :paymentStatus, :onlineAd)";
            $params = [
                'advertisementID' => $data['advertisementID'],
                'advertiserID' => $data['advertiserID'],
                'adTitle' => $data['adTitle'],
                'adDescription' => $data['adDescription'],
                'img' => $data['img'],
                'link' => $data['link'],
                'startDate' => $data['startDate'],
                'endDate' => $data['endDate'],
                'adStatus' => 'inactive',  // Default ad status
                'amount' => $data['amount'],
                'paymentStatus' => 'pending',
                'onlineAd' => 1
            ];

            $result = $this->query($query, $params);

            return $result !== false;
        } catch (PDOException $e) {
            error_log("Advertisement creation failed: " . $e->getMessage());
            return false;
        }
    }

    public function updateAdStatus($adId, $status)
    {
        $query = "UPDATE advertisement SET adStatus = :status WHERE advertisementID = :adId";
        $params = [
            'status' => $status,
            'adId' => $adId
        ];
        return $this->query($query, $params);
    }

    public function updatePaymentStatus($adId, $status)
    {
        $query = "UPDATE advertisement SET paymentStatus = :status WHERE advertisementID = :adId";
        $params = [
            'status' => $status,
            'adId' => $adId
        ];
        return $this->query($query, $params);
    }

    public function getAdDetailsWithoutImage($adId)
    {
        $query = "SELECT advertisementID, advertiserID, adTitle, adDescription, link, startDate, endDate, amount, paymentStatus
        FROM advertisement
        WHERE advertisementID = :adId
        LIMIT 1;";
        $params = ['adId' => $adId];
        $result = $this->query($query, $params);
        return $result[0] ?? null; // Return the first row or null if no result
    }

    // public function isAdExists($adId) {
    //     $query = "SELECT COUNT(*) as count FROM advertisement WHERE advertisementID = :adId AND deleted = 0";
    //     $params = ['adId' => $adId];
    //     $result = $this->query($query, $params);
    //     return $result[0]->count > 0; // Return true if count is greater than 0
    // }

    public function getAdsToBeReviewed() {
        $query = "SELECT * FROM advertisement WHERE adStatus = 'inactive' AND onlineAd = 1 AND rejected = 0 ORDER BY createdAt DESC";
        $result = $this->query($query);
        return $result ?: [];
    }

    public function approveAd($adId)
    {
        $query = "UPDATE advertisement SET adStatus = 'active' WHERE advertisementID = :adId";
        $params = ['adId' => $adId];
        return $this->query($query, $params);
    }

    public function rejectAd($adId) {
        $query = "UPDATE advertisement SET rejected = 1 WHERE advertisementID = :adId";
        $params = ['adId' => $adId];
        return $this->query($query, $params);
    }
    
}


