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
        $query = "INSERT INTO help (accountID, managerID, title, description, reply)
                VALUES (:accountID, :managerID, :title, :description, :reply)";
    
        $params = [
            'accountID' => $data['accountID'],
            'managerID' => $data['managerID'],
            'title' => $data['title'],
            'description' => $data['description'],
            'reply' => $data['reply']
        ];
        return $this->query($query, $params);
    }   

    public function delete($id) {
        $query = "DELETE FROM help WHERE helpId = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }    
    
    public function update($id, $data) {
        $query = "UPDATE help 
                  SET title = :title, 
                      description = :description, 
                  WHERE helpId = :id";
    
        $params = [
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
        ];
    
        return $this->query($query, $params);
    }

    //from manager side to reply to the question
    public function replyToQuestion($id, $data) {
        // Ensure the helpId exists before updating
        $existing = $this->query("SELECT helpId FROM help WHERE helpId = :id", ['id' => $id]);
    
        if (!$existing) {
            return false;
        }
    
        $query = "UPDATE help
                  SET reply = :reply,
                      managerID = :managerID
                  WHERE helpId = :id";
    
        $params = [
            'id' => $id,
            'reply' => $data['reply'],
            'managerID' => $data['managerID']
        ];
    
        return $this->query($query, $params);
    }

    
    
    
}