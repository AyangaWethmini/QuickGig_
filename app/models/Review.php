<?php

class Review{
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
    public function submitReview($reviewerID,$revieweeID,$reviewDate,$reviewTime,$content,$rating,$roleID){
        $query = "INSERT INTO review(reviewDate,reviewTime,content,rating,reviewerID,revieweeID,roleID) VALUES (:reviewDate,:reviewTime,:content,:rating,:reviewerID,:revieweeID,:roleID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reviewerID',$reviewerID);
        $stmt->bindParam(':reviewDate',$reviewDate);
        $stmt->bindParam(':reviewTime',$reviewTime);
        $stmt->bindParam(':content',$content);
        $stmt->bindParam(':rating',$rating);
        $stmt->bindParam(':revieweeID',$revieweeID);
        $stmt->bindParam(':roleID',$roleID);

        return $stmt->execute();
    }
    public function readReview($revieweeID,$roleID){
        $query = "SELECT * FROM review WHERE revieweeID = :revieweeID AND roleID = :roleID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':revieweeID',$revieweeID);
        $stmt->bindParam(':roleID',$roleID);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}
?>