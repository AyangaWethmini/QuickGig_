<?php

class Job
{
    use Database;

    public $jobID;
    public $accountID;
    public $datePosted;
    public $timePosted;
    public $jobStatus;
    public $isUrgent;
    public $noOfApplicants;
    public $description;
    public $location;
    public $timeFrom;
    public $timeTo;
    public $availableDate;
    public $shift;
    public $salary;
    public $currency;
    public $jobTitle;
    public $categories;

    public function __construct()
    {
    }

    public function getJobsByUser($userID)
    {
        $query = "SELECT * FROM job WHERE accountID = :accountID ORDER BY availableDate DESC, timeFrom DESC";
        $params = ['accountID' => $userID];
        return $this->query($query, $params);
    }

    public function create($data)
    {
        $query = "INSERT INTO job (jobID, accountID, jobTitle, description, location, timeFrom, timeTo, availableDate, shift, salary, currency, noOfApplicants, jobStatus, categories) 
                  VALUES (:jobID, :accountID, :jobTitle, :description, :location, :timeFrom, :timeTo, :availableDate, :shift, :salary, :currency, :noOfApplicants, :jobStatus, :categories)";

        $params = [
            'jobID' => $data['jobID'],
            'accountID' => $data['accountID'],
            'description' => $data['description'],
            'location' => $data['location'],
            'timeFrom' => $data['timeFrom'],
            'timeTo' => $data['timeTo'],
            'availableDate' => $data['availableDate'],
            'shift' => $data['shift'],
            'salary' => $data['salary'],
            'currency' => $data['currency'],
            'jobTitle' => $data['jobTitle'],
            'noOfApplicants' => $data['noOfApplicants'],
            'categories' => $data['categories'],
            'jobStatus' => $data['jobStatus']
        ];
        return $this->query($query, $params);
    }

    public function update($id, $data)
    {
        $query = "UPDATE job 
                    SET description = :description, 
                        location = :location, 
                        timeFrom = :timeFrom, 
                        timeTo = :timeTo,
                        availableDate = :availableDate,
                        shift = :shift,
                        salary = :salary,
                        currency = :currency,
                        jobTitle = :jobTitle,
                        noOfApplicants = :noOfApplicants,
                        jobStatus = :jobStatus,
                        categories = :categories
                    WHERE jobID = :id";

        $params = [
            'id' => $id,
            'description' => $data['description'],
            'location' => $data['location'],
            'timeFrom' => $data['timeFrom'],
            'timeTo' => $data['timeTo'],
            'availableDate' => $data['availableDate'],
            'shift' => $data['shift'],
            'salary' => $data['salary'],
            'currency' => $data['currency'],
            'jobTitle' => $data['jobTitle'],
            'noOfApplicants' => $data['noOfApplicants'],
            'jobStatus' => $data['jobStatus'],
            'categories' => $data['categories']
        ];
        return $this->query($query, $params);
    }

    public function getJobById($id)
    {
        $query = "SELECT * FROM job WHERE jobID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return isset($result[0]) ? $result[0] : null;
    }
    public function getJobSeekerById($id)
    {
        $query = "SELECT seekerID FROM apply_job WHERE jobID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return isset($result[0]) ? $result[0] : null;
    }
    public function getJobSeekerByAvailableId($id)
    {
        $query = "SELECT accountID as seekerID FROM makeavailable WHERE availableID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return isset($result[0]) ? $result[0] : null;
    }
    public function getJobProviderById($id)
    {
        $query = "SELECT accountID FROM job WHERE jobID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return isset($result[0]) ? $result[0] : null;
    }
    public function getJobProviderByAvailableId($id)
    {
        $query = "SELECT providerID FROM req_available WHERE availableID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);
        return isset($result[0]) ? $result[0] : null;
    }

    public function delete($id)
    {
        $query = "DELETE FROM job WHERE jobID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function searchJobsByUser($userID, $searchTerm)
    {
        $searchTerm = '%' . strtolower($searchTerm) . '%';
        $query = "SELECT * FROM job 
                  WHERE accountID = ? 
                  AND (
                      LOWER(jobTitle) LIKE ? OR
                      LOWER(description) LIKE ? OR
                      LOWER(location) LIKE ? OR
                      LOWER(categories) LIKE ?
                  )
                  ORDER BY availableDate DESC, timeFrom DESC";
        return $this->query($query, [$userID, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }

    public function filterJobsByDate($userID, $filterDate)
    {
        $query = "SELECT * FROM job 
                  WHERE accountID = :accountID 
                  AND availableDate = :filterDate
                  ORDER BY availableDate DESC, timeFrom DESC";
        $params = [
            'accountID' => $userID,
            'filterDate' => $filterDate
        ];
        return $this->query($query, $params);
    }
}
