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
        // Set optional fields to NULL if they are not provided
        $this->district = $this->district ?: 'None';
        $this->addressLine1 = $this->addressLine1 ?: 'None';
        $this->addressLine2 = $this->addressLine2 ?: 'None';
        $this->city = $this->city ?: 'None';
        $this->planID = $this->planID ?: -1;  // -1 no plan

        // Prepare the SQL query to insert data
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

        // Execute the query
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
    public function findRole($user_id)
    {
        $query = "SELECT roleID FROM account_role WHERE accountID = :user_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
public function createIndividual($data)
{
    try {
        $sql = "INSERT INTO individuals (accountID, firstName, lastName, dob, phone) 
                VALUES (:accountID, :firstName, :lastName, :dob, :phone)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':accountID', $data['accountID']);
        $stmt->bindParam(':firstName', $data['firstName']);
        $stmt->bindParam(':lastName', $data['lastName']);
        $stmt->bindParam(':dob', $data['dob']);
        $stmt->bindParam(':phone', $data['phone']);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
public function createOrganization($data)
{
    try {
        $sql = "INSERT INTO organizations (accountID, orgName, contactPerson, contactPhone, address) 
                VALUES (:accountID, :orgName, :contactPerson, :contactPhone, :address)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':accountID', $data['accountID']);
        $stmt->bindParam(':orgName', $data['orgName']);
        $stmt->bindParam(':contactPerson', $data['contactPerson']);
        $stmt->bindParam(':contactPhone', $data['contactPhone']);
        $stmt->bindParam(':address', $data['address']);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


