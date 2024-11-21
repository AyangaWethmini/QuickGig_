<?php
// models/Account.php

class Account
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // PDO instance
    }

    // Properties representing the columns in the account table
    public $accountID;
    public $email;
    public $planID;
    public $password;
    public $district;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $accStatus;
    public $lastLogin;

    // Method to create a new account
    public function create()
    {
        $query = "INSERT INTO account (accountID, email, planID, password, district, addressLine1, addressLine2, city, accStatus) 
                  VALUES (:accountID, :email, :planID, :password, :district, :addressLine1, :addressLine2, :city, :accStatus)";
        
        $stmt = $this->db->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':accountID', $this->accountID);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':planID', $this->planID);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':district', $this->district);
        $stmt->bindParam(':addressLine1', $this->addressLine1);
        $stmt->bindParam(':addressLine2', $this->addressLine2);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':accStatus', $this->accStatus);

        return $stmt->execute();
    }

    // Method to find an account by email
    public function findByEmail($email)
    {
        $query = "SELECT * FROM account WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update last login time
    public function updateLastLogin($accountID)
    {
        $query = "UPDATE account SET lastLogin = NOW() WHERE accountID = :accountID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        
        return $stmt->execute();
    }
}
