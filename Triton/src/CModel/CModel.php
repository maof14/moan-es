<?php 
abstract class CModel {
	use TQueryBuilder;
	private $db;
	private $table;
	private $dsn = array();
	/**
	 *
	 * Constructor. 
	 * @param array $database dsn.
	 */
	public function __construct($database) {
		$this->dsn = $database;
		$this->db = new CDatabase($database);
	}
	/**
	 *
	 * Function to set the target table to search in. 
	 * @param string $table, the table in the database to use.
	 */
	public function setTargetTable($table) {
		$this->table = $table;
	}
	/**
	 *
	 * Function to save i.e update a record.
	 * @param array row - represents a row to be inserted to the database.
	 * Requires $this to be incorporated. @see incorporated.
	 */
	public function save($row) {
		$columns = null;
		$values = null;
		$where = 'id = ' . $this->id;
		foreach($row as $key => $val) {
			$columns[] = $key;
			$values[] = $val;
		}
		$sql = $this->update($this->table, $columns, $values, $where)->getSQL();
		return $this->db->ExecuteQuery($sql);
	}
	/**
	 *
	 * Function to delete a record.
	 * Requires $this to be incorporated. @see incorporated.
	 *
	 */
	public function remove() {
		$where = 'id = ' . $this->id;
		$sql = $this->delete($this->table, $where)->getSQL();
		return $this->db->executeQuery($sql);
	}
	/**
	 *
	 * Function to create a record. 
	 * @param array row - represents a row to be inserted to database. 
	 */
	public function create($row) {
		$columns = null;
		$values = null;
		foreach($row as $key => $val) {
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
	
	public function findAll($search = array()) {
		$sql = $this->select()
					->from($this->table)
					->where($search)
					->getSQL();
		return $this->db->ExecuteSelectQueryAndFetchAll($sql);
	}
	/**
	 *
	 * Function to find the first record that matches search. 
	 * Adjusted to return for CUser model. 
	 * @return void.
	 */
	public function findFirst($search = array(), $incorporate = false) {
		$sql = $this->select()
					->from($this->table)
					->where($search)
					->getSQL();
		if($res = $this->db->ExecuteSelectQueryAndFetch($sql)) {
			if($incorporate) {
				$this->incorporate($res);
				return $this;
			}
			return $res;
		}
		return false;
	}

	public function findByRawSQL($sql, $incorporate = false) {
		if($res = $this->db->ExecuteSelectQueryAndFetch($sql)) {
			if($incorporate) {
				$this->incorporate($res);
				return $this;
			}
			return $res;
		}
		return false;
	}

	/**
	 *
	 * Function to incorporate data as members of the class. 
	 * @param stdObject data - the data to incorporate.
	 * @return void.
	 */
	private function incorporate($data) {
		foreach($data as $property => $value) {
			$this->$property = $value;
		}
	}
}
