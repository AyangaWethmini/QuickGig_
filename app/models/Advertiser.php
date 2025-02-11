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
        
        return $this->query($query, $params);
    }


    // Checks if the advertiser exists and if yes returns the ID; if not, returns null
    public function isAdvertiserExist($email) {
        $query = "SELECT advertiserID FROM advertiser WHERE email = :email";
        $params = ['email' => $email];
        $result = $this->query($query, $params);
    
        // Check if the result is an object and not empty
        if (is_object($result) && !empty($result)) {
            return $result->advertiserID; // Access the object property
        }
    
        return null; 
    }

    
}