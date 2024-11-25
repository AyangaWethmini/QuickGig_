<?php 

/**
 * Main Model trait
 */
Trait Model
{
	use Database;

	protected $limit = 10;
	protected $offset = 0;
	protected $order_type = "desc";
	protected $order_column = "id";
	public $errors = [];

	// Retrieves all rows from the table
	public function findAll()
	{
		$query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";

		$result = $this->query($query);
		return $result ?: [];
	}

	// Fetches rows that match specified conditions
	public function where($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "SELECT * FROM $this->table WHERE ";

		foreach ($keys as $key) {
			$query .= "$key = :$key AND ";
		}

		foreach ($keys_not as $key) {
			$query .= "$key != :$key AND ";
		}

		$query = rtrim($query, " AND ");
		$query .= " ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";

		$data = array_merge($data, $data_not);
		$result = $this->query($query, $data);

		return $result ?: [];
	}

	// Fetches the first row matching the specified conditions
	public function first($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "SELECT * FROM $this->table WHERE ";

		foreach ($keys as $key) {
			$query .= "$key = :$key AND ";
		}

		foreach ($keys_not as $key) {
			$query .= "$key != :$key AND ";
		}

		$query = rtrim($query, " AND ");
		$query .= " LIMIT 1";

		$data = array_merge($data, $data_not);
		$result = $this->query($query, $data);

		return $result[0] ?? false;
	}

	// Inserts a new row into the table
	public function insert($data)
	{
		// Remove unwanted data
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		if (empty($data)) {
			$this->errors[] = "No valid data provided for insertion.";
			return false;
		}

		$keys = array_keys($data);
		$query = "INSERT INTO $this->table (".implode(",", $keys).") VALUES (:".implode(",:", $keys).")";

		return $this->query($query, $data) !== false;
	}

	// Updates an existing row in the table
	public function update($id, $data, $id_column = 'id')
	{
		// Remove unwanted data
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		if (empty($data)) {
			$this->errors[] = "No valid data provided for update.";
			return false;
		}

		$keys = array_keys($data);
		$query = "UPDATE $this->table SET ";

		foreach ($keys as $key) {
			$query .= "$key = :$key, ";
		}

		$query = rtrim($query, ", ");
		$query .= " WHERE $id_column = :$id_column";

		$data[$id_column] = $id;
		return $this->query($query, $data) !== false;
	}

	// Deletes a row from the table
	public function delete($id, $id_column = 'id')
	{
		$query = "DELETE FROM $this->table WHERE $id_column = :$id_column";
		$data = [$id_column => $id];

		return $this->query($query, $data) !== false;
	}
}
