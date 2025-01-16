<?php

class User
{
    use Database;

    public $accountID;
    public $roleID;

    public function __construct()
    {
        // $this->db = new Database; // PDO instance
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
        $query = 'DELETE FROM account WHERE accountID = :accountID';
        return $this->query($query, ['accountID' => $accountID]);
    }
}
