<?php

class Help {
    use Database;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }

    public function getAllQuestions() {
        $query = 'SELECT * FROM help WHERE deleted = 0;';
        return $this->query($query);
    }

    public function getUserQuestions($accountID){
        $query = 'SELECT * FROM help WHERE accountID = :accountID AND deleted = 0;';
        $params = ['accountID' => $accountID];
        $result =  $this->query($query, $params);

        return $result ?? null;
    }

    public function createQuestion($data) {
        try {
            $query = "INSERT INTO help (accountID, helpID,  title, description) 
                      VALUES (:accountID, :helpID, :title, :description)";
        
            $params = [
                'helpID' => $data['helpID'],
                'accountID' => $data['accountID'],
                'title' => $data['title'],
                'description' => $data['description'],
            ];
            $_SESSION['success'] = "Your question has been submitted successfully!";
            $_SESSION['error'] = null; 

            return $this->query($query, $params);
        } catch (Exception $e) {
            error_log("Error creating question: " . $e->getMessage());
            $_SESSION['error'] = "An error occurred while submitting your question. Please try again later.";
            return false;
        }
    }   

    public function delete($id) {
        $query = "UPDATE help SET deleted = 1 WHERE helpId = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }    
    
    public function update($id, $data) {
        $query = "UPDATE help 
                  SET title = :title, 
                      description = :description 
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