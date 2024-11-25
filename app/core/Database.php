<?php 

Trait Database
{
	// Purpose: Establishes a connection to the database.
	private function connect()
	{
		$string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
		$con = new PDO($string,DBUSER,DBPASS);
		return $con;
	}

	// Purpose: Executes a SQL query and fetches all matching rows.
	public function query($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result;
			}
		}

		return false;
	}

	// Purpose: Executes a SQL query and fetches a single row.
	public function get_row($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result[0];
			}
		}

		return false;
	}
	
}