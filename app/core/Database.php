<?php

trait Database
{
	
    // Change connect method to protected
    protected function connect()
    {
        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        return $con;
    }

    public function query($query, $data = [])
    {
        try {
            $con = $this->connect(); // Connect to the database
            $stm = $con->prepare($query);
            
            // Execute the query
            $check = $stm->execute($data);
    
            // Check if query was a SELECT statement
            if ($stm->columnCount() > 0) { 
                // Return fetched results as objects
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                return $result ?: false; // Return results if available, otherwise false
            }
    
            // For non-SELECT queries, return true if execution was successful
            return $check;
        } catch (PDOException $e) {
            // Log or handle database errors
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
}
?>
