<?php
class Plans {
    use Database;

    protected $accountID;

    public function __construct() {
        // Assuming session is already started elsewhere in your application
        $this->accountID = $_SESSION['accountID'] ?? null;
        if (!$this->accountID) {
            throw new Exception("User not logged in.");
            exit;
        }
    }
  

    //User account details
    public function getUserDetails($accountID) {
        $query = 'SELECT a.accountID, a.email, p.planName, p.price 
              FROM account a
              JOIN plan p ON p.planID = a.planID
              WHERE a.accountID = :accountID';
        
        $params = ['accountID' => $accountID];
        return $this->query($query, $params);
    }

    //job details
    public function getAppliedJobs($accountID) {
        $query = "SELECT j.jobTitle AS jobname, a.dateApplied FROM  applications a JOIN jobs j ON a.jobID = j.jobID
        WHERE a.seekerID = :accountID";
        $params = ['accountID' => $accountID];
        return $this->query($query, $params);
    }

    public function getPostedJobs($accountID) {
        $query = "SELECT jobID,jobTitle, datePosted, description, location, noOfApplicants
                    FROM jobs
                    WHERE accountID = 'given_accountID'
                    ORDER BY datePosted DESC, timePosted DESC";
        $params = ['accountID' => $accountID];
        return $this->query($query, $params);
    }


    public function getTotalEarnings($accountID) {
        $query = "SELECT SUM(salary) AS totalEarnings FROM job WHERE accountID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->totalEarnings ?? 0;
    }

    public function getTotalSpent($accountID) {
        $query = "SELECT SUM(price) AS totalSpent FROM plan WHERE accountID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->totalSpent ?? 0;
    }

    
    



    public function createPlan($data) {
        $query = "INSERT INTO plan (planName, description, price, duration, badge, postLimit) 
                  VALUES (:planName, :description, :price, :duration, :badge, :postLimit)";
        
        $params = [
            'planName' => $data['planName'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration' => $data['duration'],
            'badge' => $data['badge'],
            'postLimit' => $data['postLimit'],
        ];
        
        return $this->query($query, $params);
    }

    public function deletePlan($id) {
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

    public function getPlansCount(){
        $query = "SELECT COUNT(*) AS total FROM plan";
        $result = $this->query($query);
        return $result[0]->total ?? 0;
    }
}