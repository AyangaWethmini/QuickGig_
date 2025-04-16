<?php
// models/Account.php
class Account
{
    use Database;  // Add this line to use the Database trait

    private $db;

    public function __construct($db = null)
    {
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = $this->connect();  // Use the connect method from the trait
        }
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
    public $activationCode;

    // Method to change password
    public function changePassword($accountID, $newPassword)
    {
        $query = "UPDATE account SET password = :password WHERE accountID = :accountID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Method to get user by ID
    public function getUserByID($accountID)
    {
        $query = "SELECT * FROM account WHERE accountID = :accountID LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Method to create a new account
    public function create()
    {
        // Set optional fields to NULL if they are not provided
        $this->district = $this->district ?: 'None';
        $this->addressLine1 = $this->addressLine1 ?: 'None';
        $this->addressLine2 = $this->addressLine2 ?: 'None';
        $this->city = $this->city ?: 'None';
        $this->planID = $this->planID ?: -1;  // -1 no plan
        $this->activationCode = $this->activationCode ?: true;  // -1 no plan



        // Prepare the SQL query to insert data
        $query = "INSERT INTO account (accountID, email, planID, password, district, addressLine1, addressLine2, city, accStatus, activationCode) 
                  VALUES (:accountID, :email, :planID, :password, :district, :addressLine1, :addressLine2, :city, :accStatus, :activationCode)";

        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':accountID', $this->accountID);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':planID', $this->planID);
        $stmt->bindParam(':activationCode', $this->activationCode);
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
    public function createIndividual($data)
    {
        try {
            $this->db->beginTransaction();

            // Insert into individual table
            $sqlIndividual = "INSERT INTO individual (accountID, fname, lname, nic, gender, Phone) 
                          VALUES (:accountID, :fname, :lname, :nic, :gender, :Phone)";
            $stmtIndividual = $this->db->prepare($sqlIndividual);

            $stmtIndividual->bindParam(':accountID', $data['accountID']);
            $stmtIndividual->bindParam(':fname', $data['fname']);
            $stmtIndividual->bindParam(':lname', $data['lname']);
            $stmtIndividual->bindParam(':nic', $data['nic']);
            $stmtIndividual->bindParam(':gender', $data['gender']);
            $stmtIndividual->bindParam(':Phone', $data['Phone']);

            $stmtIndividual->execute();

            // Insert into account_role table
            $sqlRole = "INSERT INTO account_role (accountID, roleID) 
                    VALUES (:accountID, :roleID)";
            $stmtRole = $this->db->prepare($sqlRole);

            $stmtRole->bindParam(':accountID', $data['accountID']);
            $roleID = 2; // Role ID for individual
            $stmtRole->bindParam(':roleID', $roleID);

            $stmtRole->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function createOrganization($data)
    {
        try {
            $this->db->beginTransaction();

            // Insert into organization table
            $sqlOrganization = "INSERT INTO organization (accountID, orgName, BRN) 
                            VALUES (:accountID, :orgName, :brn)";
            $stmtOrganization = $this->db->prepare($sqlOrganization);

            $stmtOrganization->bindParam(':accountID', $data['accountID']);
            $stmtOrganization->bindParam(':orgName', $data['orgName']);
            $stmtOrganization->bindParam(':brn', $data['brn']);

            $stmtOrganization->execute();

            // Insert into account_role table
            $sqlRole = "INSERT INTO account_role (accountID, roleID) 
                    VALUES (:accountID, :roleID)";
            $stmtRole = $this->db->prepare($sqlRole);

            $stmtRole->bindParam(':accountID', $data['accountID']);
            $roleID = 3; // Role ID for organization
            $stmtRole->bindParam(':roleID', $roleID);

            $stmtRole->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getUserData($userId)
    {

        try {
            $sql = "
           SELECT 
                a.accountID, a.email, a.district, a.addressLine1, a.addressLine2, a.city, a.linkedIn, a.facebook, a.pp, 
                i.gender, i.nic, i.fname, i.lname, i.phone, i.bio
            FROM account a
            INNER JOIN individual i ON a.accountID = i.accountID
            WHERE a.accountID = :user_id
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    public function updateUserData($userId, $data)
    {
        try {
            $sql = "
            UPDATE account a
            INNER JOIN individual i ON a.accountID = i.accountID
            SET 
                a.district = :district,
                a.addressLine1 = :addressLine1,
                a.addressLine2 = :addressLine2,
                a.city = :city,
                a.linkedIn = :linkedIn,
                a.facebook = :facebook,
                i.fname = :fname,
                i.lname = :lname,
                i.phone = :phone,
                i.bio = :bio
        ";

            if (!empty($data['pp'])) {
                $sql .= ", a.pp = :pp";
            }

            $sql .= " WHERE a.accountID = :user_id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':district', $data['district']);
            $stmt->bindParam(':addressLine1', $data['addressLine1']);
            $stmt->bindParam(':addressLine2', $data['addressLine2']);
            $stmt->bindParam(':city', $data['city']);
            $stmt->bindParam(':linkedIn', $data['linkedIn']);
            $stmt->bindParam(':facebook', $data['facebook']);
            $stmt->bindParam(':fname', $data['fname']);
            $stmt->bindParam(':lname', $data['lname']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->bindParam(':user_id', $userId);

            if (!empty($data['pp'])) {
                $stmt->bindParam(':pp', $data['pp'], PDO::PARAM_LOB);
            }
            if ($stmt->execute()) {
                error_log("Database Error: Statement execution succeful.");
                return true;
            } else {
                error_log("Database Error: Statement execution failed.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public function getOrgData($userId)
    {

        try {
            $sql = "
           SELECT 
                a.accountID, a.email, a.district, a.addressLine1, a.addressLine2, a.city, a.linkedIn, a.facebook, a.pp, 
                o.orgName, o.phone, o.bio
            FROM account a
            INNER JOIN organization o ON a.accountID = o.accountID
            WHERE a.accountID = :user_id
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    public function updateOrgData($userId, $data)
    {
        try {
            $sql = "
            UPDATE account a
            INNER JOIN organization o ON a.accountID = o.accountID
            SET 
                a.district = :district,
                a.addressLine1 = :addressLine1,
                a.addressLine2 = :addressLine2,
                a.city = :city,
                a.linkedIn = :linkedIn,
                a.facebook = :facebook,
                o.orgName = :orgName,
                o.phone = :phone,
                o.bio = :bio
        ";

            if (!empty($data['pp'])) {
                $sql .= ", a.pp = :pp";
            }

            $sql .= " WHERE a.accountID = :user_id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':district', $data['district']);
            $stmt->bindParam(':addressLine1', $data['addressLine1']);
            $stmt->bindParam(':addressLine2', $data['addressLine2']);
            $stmt->bindParam(':city', $data['city']);
            $stmt->bindParam(':linkedIn', $data['linkedIn']);
            $stmt->bindParam(':facebook', $data['facebook']);
            $stmt->bindParam(':orgName', $data['orgName']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->bindParam(':user_id', $userId);

            if (!empty($data['pp'])) {
                $stmt->bindParam(':pp', $data['pp'], PDO::PARAM_LOB);
            }
            if ($stmt->execute()) {
                error_log("Database Error: Statement execution succeful.");
                return true;
            } else {
                error_log("Database Error: Statement execution failed.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
