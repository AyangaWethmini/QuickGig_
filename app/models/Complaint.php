<?php
// models/Complaint.php

class Complaint
{
    use Database;

    public $complainantID;
    public $content;
    public $complaintDate;
    public $complaintTime;
    public $complaintStatus;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
    }


    public function updateStatus($complaintId, $status)
    {
        try {
            $query = "UPDATE complaint SET complaintStatus = :status WHERE complaintID = :id";
            $params = [
                ':status' => $status,
                ':id' => $complaintId
            ];

            return $this->query($query, $params);
        } catch (Exception $e) {
            error_log("Error updating complaint status: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaints()
    {
        $id = $_SESSION['user_id'];
        $query = 'SELECT * FROM complaint where complainantID = ? ORDER BY complaintDate DESC, complaintTime DESC';
        return $this->query($query, [$id]);
    }

    public function getAllComplaints()
    {
        $query = 'SELECT * FROM complaint ORDER BY complaintDate DESC, complaintTime DESC';
        return $this->query($query);
    }

    public function getComplaintsCount()
    {
        $query = "SELECT COUNT(*) AS totalComplaints FROM complaint";
        $result = $this->query($query);
        return $result[0]->totalComplaints ?? 0;
    }

    public function create($data)
    {
        $query = "INSERT INTO complaint (complaintID, complainantID, complaineeID, content, complaintDate, complaintTime, complaintStatus, jobOrAvailable, applicationOrReq) 
                VALUES (:complaintID, :complainantID, :complaineeID, :content, :complaintDate, :complaintTime, :complaintStatus, :jobOrAvailable, :applicationOrReq)";

        $params = [
            'complaintID' => $data['complaintID'],
            'complainantID' => $data['complainantID'],
            'complaineeID' => $data['complaineeID'],
            'content' => $data['content'],
            'complaintDate' => $data['complaintDate'],
            'complaintTime' => $data['complaintTime'],
            'complaintStatus' => $data['complaintStatus'],
            'jobOrAvailable' => $data['jobOrAvailable'],
            'applicationOrReq' => $data['applicationOrReq']
        ];

        return $this->query($query, $params);
    }

    public function delete($id)
    {
        $query = "DELETE FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }

    public function getComplaintById($complaintId)
    {
        try {
            $query = "SELECT * FROM complaint WHERE complaintID = :complaintId LIMIT 1";
            $params = [':complaintId' => $complaintId];

            $result = $this->query($query, $params);

            // Debug logging
            error_log("Query result for complaint ID $complaintId: " . print_r($result, true));

            if (!$result) {
                error_log("No complaint found for ID: $complaintId");
                return false;
            }

            return $result[0];
        } catch (Exception $e) {
            error_log("Error in getComplaintById: " . $e->getMessage());
            return false;
        }
    }


    public function update($id, $data)
    {
        $query = "UPDATE complaint SET content = :content, complaintDate = :complaintDate, complaintTime = :complaintTime WHERE complaintID = :id";
        $params = [
            'id' => $id,
            'content' => $data['content'],
            'complaintDate' => $data['complaintDate'],
            'complaintTime' => $data['complaintTime']
        ];
        return $this->query($query, $params);
    }
}
