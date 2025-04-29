<?php
date_default_timezone_set('Asia/Colombo');

class JobStatusUpdater {
    use Database;

    public function updateJobStatuses() {
        $currentDateTime = new DateTime();
        $currentDate = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i:s');

        $this->updateReqAvailableStatuses($currentDate, $currentTime);

        $this->updateApplyJobStatuses($currentDate, $currentTime);
    }

    private function updateReqAvailableStatuses($currentDate, $currentTime) {
        $query = "UPDATE req_available r
                  JOIN makeavailable m ON r.availableID = m.availableID
                  SET r.reqStatus = 3
                  WHERE m.availableDate = :currentDate
                  AND :currentTime BETWEEN m.timeFrom AND m.timeTo
                  AND r.reqStatus = 2";
        $this->query($query, ['currentDate' => $currentDate, 'currentTime' => $currentTime]);

        $query = "UPDATE req_available r
                  JOIN makeavailable m ON r.availableID = m.availableID
                  SET r.reqStatus = 4
                  WHERE m.availableDate <= :currentDate
                  AND :currentTime > m.timeTo
                  AND (r.reqStatus = 3 OR r.reqStatus = 2)";
        $this->query($query, ['currentDate' => $currentDate, 'currentTime' => $currentTime]);
    }

    private function updateApplyJobStatuses($currentDate, $currentTime) {
        $query = "UPDATE apply_job a
                  JOIN job j ON a.jobID = j.jobID
                  SET a.applicationStatus = 3
                  WHERE j.availableDate = :currentDate
                  AND :currentTime BETWEEN j.timeFrom AND j.timeTo
                  AND a.applicationStatus = 2";
        $this->query($query, ['currentDate' => $currentDate, 'currentTime' => $currentTime]);

        $query = "UPDATE apply_job a
                  JOIN job j ON a.jobID = j.jobID
                  SET a.applicationStatus = 4
                  WHERE j.availableDate <= :currentDate
                  AND :currentTime > j.timeTo
                  AND (a.applicationStatus = 3 OR a.applicationStatus = 2)";
        $this->query($query, ['currentDate' => $currentDate, 'currentTime' => $currentTime]);
    }
}