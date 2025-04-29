<?php

class SeekerComplaint
{
    use Database;

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

    public function getComplaints()
    {
        $id = $_SESSION['user_id'];
        $query = 'SELECT * FROM complaint WHERE complainantID = ? ORDER BY complaintDate DESC, complaintTime DESC';
        return $this->query($query, [$id]);
    }

    public function getComplaintById($id)
    {
        $query = "SELECT * FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        $result = $this->query($query, $params);

        return isset($result[0]) ? $result[0] : null;
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

    public function delete($id)
    {
        $query = "DELETE FROM complaint WHERE complaintID = :id";
        $params = ['id' => $id];
        return $this->query($query, $params);
    }
}