<?php

class Help {
    use Database;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getAllQuestions() {
        $query = 'SELECT * FROM help;';
        return $this->query($query);
    }

    public function createQuestion($data) {
        $query = "INSERT INTO help () 
                  VALUES (:advertiserName, :contact)";
        
        $params = [
            'advertiserName' => $data['advertiserName'],
            'contact' => $data['contact'],
        ];
        
        return $this->query($query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM advertiser WHERE advertiserID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getAdvertiserById($id) {
        $query = "SELECT * FROM advertiser WHERE advertiserID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
    
        return isset($result[0]) ? $result[0] : null;
    }


    public function findAdvertiser($data) {     //find by name and contact
        $query = "SELECT * FROM advertiser WHERE advertiserName = :advertiserName AND contact = :contact";
        $params = ['advertiserName' => $data['advertiserName'], 'contact' => $data['contact']];
        $result = $this->query($query, $params);
    
        return isset($result[0]) ? $result[0] : null;
    }
    
    
    public function update($id, $data) {
        $query = "UPDATE advertiser 
                  SET contact = :contact, 
                  WHERE advertiserID = :id";
    
        $params = [
            'id' => $id,
            'contact' => $data['contact'],
            
        ];
    
        return $this->query($query, $params);
    }

    //from manager side to reply to the question
    public function replyToQuestion($id, $data){
        $query = "UPDATE help
                  SET reply = :reply,
                  WHERE helpId = :id";

        $params = [
            'id' => $id,
            'reply' => $data['reply']
        ];

        return $this->query($query, $params);
    }
    
}