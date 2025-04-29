<?php

require_once APPROOT . '/core/functions.php';

class ManagerModel {
    use Database;

    public function getManagerData($accountID) {
        $managerID = $this->getManagerID($accountID);
        if (!$managerID) {
            $_SESSION['error'] = "An error occurred.";
            return null;
        }
    
        $query = "SELECT manager.*, account.email, account.pp FROM manager INNER JOIN account ON manager.accountID = account.accountID WHERE manager.managerID = :managerID";
        $params = [
            ':managerID' => $managerID
        ];
        
        $result = $this->query($query, $params);
        return $result ? $result[0] : null;
    }

    public function getManagerName($accountID) {
        $query = "SELECT fname FROM manager WHERE accountID = :accountID";
        $params = [
            ':accountID' => $accountID
        ];
        $result = $this->query($query, $params);
        return $result ? $result[0] : null;
    }



    public function createManager($accountID, $gender, $nic, $fname, $lname, $phone) {
        
        if (!preg_match('/^(\d{9}[VXvx]|\d{12})$/', $nic)) {
            $_SESSION['error'] = "Invalid NIC format. Please try again!";
            return false;
        }

     
        if (!preg_match('/^07\d{8}$/', $phone)) {
            $_SESSION['error'] = "Invalid phone number format. Please use the format 07XXXXXXXX.";
            return false;
        }

        
        $managerID = generateCustomID('manager', 'MGR', 'managerID');
        if (!$managerID) {
            $_SESSION['error'] = "Failed to generate manager ID.";
            return false;
        }
    

        $query = "INSERT INTO manager (managerID, accountID, gender, nic, fname, lname, phone)
                  VALUES (:managerID, :accountID, :gender, :nic, :fname, :lname, :phone)";
        
        $params = [
            ':managerID' => $managerID,
            ':accountID' => $accountID,
            ':gender' => $gender,
            ':nic' => $nic,
            ':fname' => $fname,
            ':lname' => $lname,
            ':phone' => $phone
        ];
    
        return $this->query($query, $params);
    }

    public function deleteManager($managerID) {
        $query = "UPDATE  manager SET active = 0 WHERE managerID = :managerID";
        $params = [
            ':managerID' => $managerID
        ];
        return $this->query($query, $params);
    }

    public function getManagerID($accountID) {
        $query = "SELECT managerID FROM manager WHERE accountID = :accountID";
        $params = [
            ':accountID' => $accountID
        ];
        $result =  $this->query($query, $params);
        return $result ? $result[0]->managerID : null;
    }


    public function getManagerAccID($managerID) {
        $query = "SELECT accountID FROM manager WHERE managerID = :managerID";
        $params = [
            ':managerID' => $managerID
        ];
        $result =  $this->query($query, $params);
        return $result ? $result[0]->accountID : null;
    }

    
    
    
}
