<?php

class Advertiser {
    use Database;

    public $advertiserName;
    public $contact;
    public $email;
    

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getAdvertisers() {
        $query = 'SELECT * FROM advertiser;';
        return $this->query($query);
    }

    public function createAdvertiser($data) {
        $query = "INSERT INTO advertiser (advertiserName, contact, email) 
                  VALUES (:advertiserName, :contact, :email)";
        
        $params = [
            'advertiserName' => $data['advertiserName'],
            'contact' => $data['contact'],
            'email' => $data['email']
        ];
    
        try {
            $this->query($query, $params);
            return $this->lastInsertId(); 
            print_r($this->lastInsertID());// Return the new advertiser ID
        } catch (PDOException $e) {
            error_log("Failed to create advertiser: " . $e->getMessage());
            return false;
        }
    }


    // Checks if the advertiser exists and if yes returns the ID; if not, returns false
    public function isAdvertiserExist($email) {
        try {
            if (empty($email)) {
                return false;
            }
    
            $query = "SELECT advertiserID FROM advertiser WHERE LOWER(email) = LOWER(:email) LIMIT 1";
            $params = ['email' => trim($email)];
            
            $result = $this->query($query, $params);
            
            return !empty($result) ? $result[0]->advertiserID : false;
        } catch (Exception $e) {
            error_log("Error in isAdvertiserExist: " . $e->getMessage());
            return false;
        }
    }

    public function getAdvertiserByEmail($email){
        $query = "SELECT * FROM advertiser WHERE LOWER(email) = LOWER(:email) LIMIT 1";
        $params = ['email' => trim($email)];
        
        $result = $this->query($query, $params);
        
        return !empty($result) ? json_decode(json_encode($result[0]), true) : false;
    }


    // public function checkForActiveAds(){
    //     $query = 
    // }
    
    
    
}