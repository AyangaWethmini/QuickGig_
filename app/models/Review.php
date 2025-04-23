<?php

class Review
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
    public function submitReview($reviewerID, $revieweeID, $reviewDate, $reviewTime, $content, $rating, $roleID,$jobID)
    {
        $query = "INSERT INTO review(reviewDate,reviewTime,content,rating,reviewerID,revieweeID,roleID,jobID) VALUES (:reviewDate,:reviewTime,:content,:rating,:reviewerID,:revieweeID,:roleID,:jobID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reviewerID', $reviewerID);
        $stmt->bindParam(':reviewDate', $reviewDate);
        $stmt->bindParam(':reviewTime', $reviewTime);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':revieweeID', $revieweeID);
        $stmt->bindParam(':roleID', $roleID);
        $stmt->bindParam(':jobID', $jobID);

        return $stmt->execute();
    }
    public function readReview($revieweeID, $roleID)
    {
        $query = "SELECT 
                r.*, 
                j.jobTitle,
                a.pp,
                CASE
                    WHEN i.accountID IS NOT NULL THEN CONCAT(i.fname, ' ', i.lname)
                    WHEN o.accountID IS NOT NULL THEN o.orgName
                    ELSE 'Unknown'
                END AS reviewerName
                FROM review r
                LEFT JOIN job j ON r.jobID = j.jobID
                LEFT JOIN account a ON r.reviewerID = a.accountID
                LEFT JOIN individual i ON a.accountID = i.accountID
                LEFT JOIN organization o ON a.accountID = o.accountID
                WHERE r.reviewerID = :accountID 
                AND r.roleID = :roleID
                ORDER BY r.reviewDate DESC, r.reviewTime DESC;
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountID', $revieweeID);
        $stmt->bindParam(':roleID', $roleID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getRatingDistribution($accountID,$roleID) {
        $query = "SELECT rating, COUNT(*) as total 
                  FROM review 
                  WHERE revieweeID = :accountID AND roleID = :roleID
                  GROUP BY rating";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->bindParam(':roleID', $roleID);
        $stmt->execute();
    
        $ratings = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
        while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $ratings[$row->rating] = $row->total;
        }
        return $ratings;
    }
    public function deleteReview($reviewerID,$revieweeID, $roleID){
        $query = ("DELETE FROM review WHERE revieweeID = :revieweeID AND roleID = :roleID AND reviewerID = :reviewerID");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':revieweeID', $revieweeID);
        $stmt->bindParam(':roleID', $roleID);
        $stmt->bindParam(':reviewerID', $reviewerID);

        return $stmt->execute();

    }
}
