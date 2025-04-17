<?php
class MessageModel
{
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

    public function getMessages($user1, $user2)
    {
        $query = ("SELECT * FROM messages 
                          WHERE (sender_id = :user1 AND receiver_id = :user2)
                             OR (sender_id = :user2 AND receiver_id = :user1)
                          ORDER BY created_at ASC");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user1', $user1, PDO::PARAM_STR);
        $stmt->bindParam(':user2', $user2, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $messages ? $messages : [];
        } else {
            return [];
        }
    }

    public function sendMessage($sender, $receiver, $message)
    {
        $query = ("INSERT INTO messages (sender_id, receiver_id, message) 
                          VALUES (:sender, :receiver, :message)");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sender', $sender);
        $stmt->bindParam(':receiver', $receiver);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }
    public function getConversationBetween($user1, $user2)
    {
        $query = ("SELECT * FROM conversations 
                              WHERE (user1_id = :user1 AND user2_id = :user2)
                                 OR (user1_id = :user2 AND user2_id = :user1)");
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user1', $user1);
        $stmt->bindValue(':user2', $user2);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function getConversationById($conversationId) {
        $query = ("SELECT * FROM conversations WHERE id = :conversationId");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':conversationId', $conversationId);
    
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createConversation($user1, $user2)
    {
        $query = ("INSERT INTO conversations (user1_id, user2_id) 
                              VALUES (:user1, :user2)");
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user1', $user1);
        $stmt->bindValue(':user2', $user2);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function getUserConversations($userId)
    {
        $query = ("SELECT c.*, a.accountID AS other_user_id,a.pp AS other_user_profile,COALESCE(CONCAT(i.fname, ' ', i.lname), o.orgName) AS other_user_name
                    FROM conversations c
                    JOIN account a 
                    ON a.accountID = CASE 
                        WHEN c.user1_id = :userId THEN c.user2_id 
                        ELSE c.user1_id 
                    END
                    LEFT JOIN individual i ON i.accountID = a.accountID
                    LEFT JOIN organization o ON o.accountID = a.accountID
                    WHERE c.user1_id = :userId OR c.user2_id = :userId
                    ORDER BY c.created_at DESC

                ");
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
