<?php

class User
{
    use Database;

    public $accountID;
    public $roleID;

    public function __construct()
    {
        // $this->db = Database; // PDO instance
    }

    use Model;

    // Add these new methods
    public function getTotalUsers()
    {
        $query = "SELECT COUNT(*) as count 
              FROM account_role ar 
              JOIN account a ON ar.accountID = a.accountID 
              WHERE ar.roleID NOT IN (0, 1)";
        $result = $this->query($query);
        return $result[0]->count;
    }

    public function getUsersPaginated($start, $limit)
    {
        // Cast parameters to integers to ensure proper SQL syntax
        $start = (int)$start;
        $limit = (int)$limit;

        $query = "SELECT ar.roleID, a.accountID, a.email, a.activationCode 
              FROM account_role ar
              JOIN account a ON ar.accountID = a.accountID 
              WHERE ar.roleID NOT IN (0, 1)
              ORDER BY a.accountID  -- Add an ORDER BY clause for consistent pagination
              LIMIT $start, $limit";  // Use direct integers instead of parameters for LIMIT

        $result = $this->query($query);
        return $result ?: [];
    }

    public function getUsers()
    {
        $query = 'SELECT ar.roleID, a.accountID, a.email, a.activationCode 
              FROM account_role ar
              JOIN account a ON ar.accountID = a.accountID';
        return $this->query($query) ?? []; // Ensure it returns an array
    }

    public function activateUserById($accountID)
    {
        // Debugging: Check if the accountID is received
        // echo "Account ID in Model: " . $accountID;
        // exit;

        // Prepare the SQL query to update the activationCode
        $query = "UPDATE account SET activationCode = :activationCode WHERE accountID = :accountID";

        // Bind parameters and execute the query
        $params = [
            ':activationCode' => true, // Set activationCode to true
            ':accountID' => $accountID
        ];

        // Execute the query
        return $this->query($query, $params);
    }

    public function deactivateUserById($accountID)
    {
        // Debugging: Check if the accountID is received
        // echo "Account ID in Model: " . $accountID;
        // exit;

        // Prepare the SQL query to update the activationCode
        $query = "UPDATE account SET activationCode = :activationCode WHERE accountID = :accountID";

        // Bind parameters and execute the query
        $params = [
            ':activationCode' => false, // Set activationCode to true
            ':accountID' => $accountID
        ];

        // Execute the query
        return $this->query($query, $params);
    }
 
    public function deleteUserById($accountID)
    {
        try {
            // $this->db->beginTransaction();

            // Delete from account_role table
            $queryRole = 'DELETE FROM account_role WHERE accountID = :accountID';
            $this->query($queryRole, ['accountID' => $accountID]);

            // Delete from account table
            $queryAccount = 'DELETE FROM account WHERE accountID = :accountID';
            $this->query($queryAccount, ['accountID' => $accountID]);

            // $this->db->commit();
            return true;
        } catch (PDOException $e) {
            // $this->db->rollBack();
            error_log('Failed to delete user: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId)
    {
        $query = "SELECT * FROM account WHERE accountID = :userId";
        $params = [':userId' => $userId];

        $result = $this->query($query, $params);
        return $result ? $result[0] : false;
    }
}
