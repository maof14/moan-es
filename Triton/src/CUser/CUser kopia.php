<?php 

// CUser. restart. 

class CUser {

	private $id; 
	private $username;
	private $email;
	private $name;
	private $created;
	private $isAuthenticated;
	private $db;

	/**
	 *
	 * Constructor for the class.
	 * @param array $database with database DSN.
	 *
	 */

	public function __construct($database) {
		$this->db = new CDatabase($database);
		if(isset($_SESSION['user'])) {
			$this->id = $_SESSION['user']->id;
			$this->username = $_SESSION['user']->username;
			$this->email = $_SESSION['user']->email;
			$this->created = $_SESSION['user']->created;
			$this->isAuthenticated = true;
		} else {
			$this->isAuthenticated = false;
		}
	}

	/**
	 *
	 * Function to login the user.
	 * @param $email, the users email, $password, the users password.
	 * @return boolean success. 
	 *
	 */
	// snyggt alltså. Kl 00:07, efter 3 bärs och lite till. :)) 

	public function login($email, $password) {
		$sql = "SELECT * FROM users WHERE email = ?";
		$params[] = $email;
			if($res = $this->db->ExecuteSelectQueryAndFetch($sql, $params)) {
				$this->db = null;
				if(password_verify($password, $res->password)) {
				$this->id = $res->id;
				$this->username = $res->username;
				$this->email = $res->email;
				$this->text = $res->text;
				$this->created = $res->created;
				$this->isAuthenticated = true;
				$_SESSION['user'] = $this;
				return true;
			} else {
				$_SESSION = array();
				$this->isAuthenticated = false;
				return false;
			}
		}
	}

	/** 
	 *
	 * Function to log out the user.
	 * @return void.
	 *
	 */

	public function logout() {
		$this->isAuthenticated = false;
		unset($_SESSION['user']);
		$_SESSION = array();
		header('Location: login.php?action=logout');
	}

	/**
	 *
	 * Function to return the userid of the user.
	 * @return string the userid. 
	 */

	public function getId() {
		return $this->id;
	}

	/**
	 *
	 * Function to return the username of the user.
	 * @return string the username. 
	 */

	public function getUsername() {
		return $this->username;
	}

	/**
	 *
	 * Function to return if user is authenticated.
	 * @return bool user authenticated.
	 *
	 */

	public function isAuthenticated() {
		return $this->isAuthenticated;
	}

	/**
	 *
	 * Function to get link to Gravatar avatar.
	 * @return string link to Gravatar.
	 *
	 */
	
	public function getGravatar($size = 80) {
		$email = $this->email;
		$url = "http://www.gravatar.com/avatar/";
		$default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
		return  $url . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
	}

}




