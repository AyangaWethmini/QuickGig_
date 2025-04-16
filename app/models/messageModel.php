<?php
class MessageModel  {
    use Database;
    private $db;

    public function __construct($db = null)
    {
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = $this->connect();  // Use the connect method from the trait
        }
    }

    public function getMessages($user1, $user2) {
        $query=("SELECT * FROM messages 
                          WHERE (sender_id = :user1 AND receiver_id = :user2)
                             OR (sender_id = :user2 AND receiver_id = :user1)
                          ORDER BY created_at ASC");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user1', $user1,PDO::PARAM_STR);
        $stmt->bindParam(':user2', $user2,PDO::PARAM_STR);
        if ($stmt->execute()) {
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $messages ? $messages : [];
        } else {
            return [];
        }
    }

    public function sendMessage($sender, $receiver, $message) {
        $query=("INSERT INTO messages (sender_id, receiver_id, message) 
                          VALUES (:sender, :receiver, :message)");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sender', $sender);
        $stmt->bindParam(':receiver', $receiver);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }
}
