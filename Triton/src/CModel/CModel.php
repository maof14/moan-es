<?php 

abstract class CModel {

	use TQueryBuilder;

	private $db;
	private $table;

	/**
	 *
	 * Constructor. 
	 *
	 */
	public function __construct($database) {
		$this->db = new CDatabase($database);
	}

	/**
	 *
	 * Function to set the target table to search in. 
	 *
	 */
	public function setTargetTable($table) {
		$this->table = $table;
	}

	/**
	 *
	 * Function to save a record. Need to update TQueryBuilder for that.
	 *
	 */

	public function save() {
		$params[] = $this;
		$sql = "UPDATE {$this->table} WHERE id = ? SET username = ?";

		// if($this->db->executeQuery($sql, $params)) {
		// 	return true;
		// } else {
		// 	return false;
		// }
	}

	/**
	 *
	 * Function to delete a record.
	 *
	 */

	public function remove() {

	}

	/**
	 *
	 * Function to create a record. 
	 *
	 */

	public function create($example) {
		$columns = null;
		$values = null;

		foreach($example as $key => $val) {
			$columns[] = $key;
			$values[] = $val;
		}

		$sql = $this->insert($this->table, $columns, $values)->getSQL();
		return $this->db->ExecuteQuery($sql);
	}

	/**
	 *
	 * Function to return array of objects. 
	 * @return array of the query results.
	 */
	
	public function find($search = array()) {
		$sql = $this->select()
					->from($this->table)
					->where($search)
					->getSQL();
		return $this->db->ExecuteSelectQueryAndFetchAll($sql);
	}

	/**
	 *
	 * Function to find the first record that matches search. 
	 * @return void.
	 */

	public function findFirst($search = array()) {
		$sql = $this->select()
						->from($this->table)
						->where($search)
						->getSQL();
		$result = $this->db->ExecuteSelectQueryAndFetch($sql);
		foreach($result as $property => $value) {
			$this->$property = $value;
		}
	}
}