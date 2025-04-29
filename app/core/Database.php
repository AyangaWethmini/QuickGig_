<?php

trait Database
{

    protected function connect()
    {
        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        return $con;
    }

    public function query($query, $data = [])
    {
        try {
            $con = $this->connect(); 
            $stm = $con->prepare($query);

           
            $check = $stm->execute($data);

            
            if ($stm->columnCount() > 0) {
               
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                return $result ?: false; 
            }

           
            return $check;
        } catch (PDOException $e) {
           
            error_log('Database Query Error: ' . $e->getMessage());
            return false;
        }
    }


    public function get_row($query, $data = [])
    {
        $con = $this->connect(); // Use the connect method here
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result[0]; // Return only the first result
            }
        }
        return false;
    }

    public function lastInsertId() {
        try {
            $con = $this->connect(); // Connect to the database
            return $con->lastInsertId(); // Get the last inserted ID
        } catch (PDOException $e) {
            error_log("Error getting last insert ID: " . $e->getMessage());
            return false;
        }
    }
}
