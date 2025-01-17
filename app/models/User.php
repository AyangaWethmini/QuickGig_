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

    public function getUsers()
    {
        $query = 'SELECT ar.roleID, a.accountID, a.email 
              FROM account_role ar
              JOIN account a ON ar.accountID = a.accountID';
        return $this->query($query) ?? []; // Ensure it returns an array
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
}
