<?php
class userReport {
    use Database;

    protected $accountID;

    public function __construct() {
        // Assuming session is already started elsewhere in your application
        $this->accountID = $_SESSION['user_id'] ?? null;
        if (!$this->accountID) {
            throw new Exception("User not logged in.");
            exit;
        }
    }
  

    //User account details
    public function getUserDetails($accountID) {
        $query = 'SELECT a.accountID, a.email, p.planName, i.fname, i.lname 
              FROM account a
              JOIN plan p ON p.planID = a.planID JOIN individual i ON a.accountID = i.accountID
              WHERE a.accountID = :accountID';
        
        $params = ['accountID' => $accountID];
        return $this->query($query, $params);
    }

    //job details
    public function getAppliedJobs($accountID) {
        $queryJobs = "SELECT aj.applicationID, j.jobTitle, aj.dateApplied
                      FROM apply_job aj
                      JOIN job j ON aj.jobID = j.jobID
                      WHERE aj.seekerID = :accountID";
        
        $queryCount = "SELECT COUNT(applicationID) AS applicationCount 
                       FROM apply_job 
                       WHERE seekerID = :accountID";
        
        $params = ['accountID' => $accountID];
        
        $jobs = $this->query($queryJobs, $params);
        $count = $this->query($queryCount, $params);
    
        return ['jobs' => $jobs, 'count' => $count[0]->applicationCount ?? 0];
    }


    public function getPostedJobs($accountID) {
        $queryJobs = "SELECT jobID, jobTitle, datePosted, description, location, noOfApplicants
                      FROM job
                      WHERE accountID = :accountID
                      ORDER BY datePosted DESC";
        
        $queryCount = "SELECT COUNT(jobID) AS jobCount 
                       FROM job 
                       WHERE accountID = :accountID";
        
        $params = ['accountID' => $accountID];
        
        $jobs = $this->query($queryJobs, $params);
        $count = $this->query($queryCount, $params);
        
        return [
            'jobs' => $jobs,
            'count' => $count[0]->jobCount ?? 0
        ];
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


    public function getReviewsGivenCount($accountID) {
        $query = "SELECT COUNT(reviewID) AS givenCount FROM review WHERE reviewerID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->givenCount ?? 0;
    }

    
    public function getReviewsReceivedCount($accountID) {
        $query = "SELECT COUNT(reviewID) AS receivedCount FROM review WHERE revieweeID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->receivedCount ?? 0;
    }


    public function getAverageRating($accountID) {
        $query = "SELECT AVG(rating) AS averageRating FROM review WHERE revieweeID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return round($result[0]->averageRating ?? 0, 2); // Rounded to 2 decimal places
    }
    
    public function getComplaintsCount($accountID){
        $query = "SELECT COUNT(complaintID) AS complaintCount FROM complaints WHERE accountID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->complaintCount ?? 0;
    }


    public function getComplaintsMadeCount($accountID) {
        $query = "SELECT COUNT(complaintID) AS madeCount FROM complaint WHERE complainantID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->madeCount ?? 0;
    }


    public function getComplaintsReceivedCount($accountID) {
        $query = "SELECT COUNT(complaintID) AS receivedCount FROM complaint WHERE complaineeID = :accountID";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->receivedCount ?? 0;
    }


    public function getCompletedJobsCountProvided($accountID) {
        $query = "SELECT COUNT(*) AS completedCount
                  FROM applyjob a
                  JOIN job j ON a.jobID = j.jobID
                  WHERE j.accountID = :accountID
                  AND a.applicationStatus = 5";

        $params = ['accountID' => $accountID];
        
        $result = $this->query($query, $params);
        return $result[0]->completedCount ?? 0;
    }


    public function getOngoingTasks($accountID){
        $query = "SELECT COUNT(applicationID) AS ongoingTasks FROM apply_job WHERE seekerID = :accountID AND applicationStatus = 3";
        $params = ['accountID' => $accountID];
        $result = $this->query($query, $params);
        return $result[0]->completedTasks ?? 0;
    }
    
    
    
    
    



    
}