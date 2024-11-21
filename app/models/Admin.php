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
    public $adminId;
    public $name;
    public $email;
    public $password;
}