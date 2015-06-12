<?php

/** 
 * Database wrapper. Provides a database API for the framework but hides details of implementation!! 
 * @todo make static for better serialization. 
 */

class CDatabase {
	
	private $options; // options for PDO
	private $db = null; // PDO Object
	private $stmt = null; // Latest statement used
	
	private static $numQueries = 0; // Count all queries made
	private static $queries = array(); // Save all queries for debugging
	private static $params = array(); // Save all parameters for debugging.
	

	/**
	 *
	 * Constructor. Set up the class. 
	 * @param array $options. The options needed to set up the database. 
	 */

	public function __construct($options) {
		$default = array(
			'dsn' => null, 
			'username' => null,
			'password' => null,
			'driver_options' => null,
			'fetch_style' => PDO::FETCH_OBJ, 
		);
		
		$this->options = array_merge($default, $options);

		try {
			// configured for MySQL. SQLite needs only the dsn.
			$this->db = new PDO($this->options['dsn'], $this->options['username'], $this->options['password'], $this->options['driver_options']);
		}
		catch(Exception $e) {
			throw new PDOException('Could not connect to database, hiding connection details.');
		}
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->options['fetch_style']);
	}
	
	/**
	* Execute a select-query with arguments and return the resultset.
	* 
	* @param string $query the SQL query with ?.
	* @param array $params array which contains the argument to replace ?.
	* @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
	* @return array with resultset.
	*/
	
	private function debug($query, $params=array()) {
		self::$queries[] = $query; 
		self::$params[]  = $params; 
		self::$numQueries++;

		echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>";
	}

	/**
	 *
	 * Function to execute a select-query. 
	 * @param string $query, the SQL query to be executed.
	 * @param array $params, the parameters to be prepared. 
	 * @param boolean $debug, display information about queries. 
	 * @return array of stdObject - the database results as array rows or false on fail. 
	 */

	public function ExecuteSelectQueryAndFetchAll($query, $params=array(), $debug=false) {
		if($debug) {
			$this->debug($query, $params);
		}
		$this->stmt = $this->db->prepare($query);
		$this->stmt->execute($params);
		return $this->stmt->fetchAll();
	}
	
	/**
	 *
	 * Function to execute a select-query. 
	 * @param string $query, the SQL query to be executed.
	 * @param array $params, the parameters to be prepared. 
	 * @param boolean $debug, display information about queries. 
	 * @return stdObject - one database result row or false on fail. 
	 */

	public function ExecuteSelectQueryAndFetch($query, $params=array(), $debug=false) {
		if($debug) {
			$this->debug($query, $params);
		}
		$this->stmt = $this->db->prepare($query);
		$this->stmt->execute($params);
		return $this->stmt->fetch();
	}
	
	/**
	 * Get a html representation of all queries made, for debugging and analysing purpose.
	 * 
	 * @return string with html.
	 */
	public function Dump() {
		$html  = '<p><i>You have made ' . self::$numQueries . ' database queries.</i></p><pre>';
		foreach(self::$queries as $key => $val) {
			$params = empty(self::$params[$key]) ? null : htmlentities(print_r(self::$params[$key], 1)) . '<br/></br>';
			$html .= $val . '<br/></br>' . $params;
		}
		return $html . '</pre>';
	}
	
	/**
	 *
	 * Function to execute a query. 
	 * @param string $query, the SQL query to be executed.
	 * @param array $params, the parameters to be prepared. 
	 * @param boolean $debug, display information about queries. 
	 * @return boolean from statement on success. 
	 */

	public function ExecuteQuery($query, $params=array(), $debug=false) {
		if($debug) {
			$this->debug($query, $params);
		}
		$this->stmt = $this->db->prepare($query);
		return $this->stmt->execute($params);
	}
}