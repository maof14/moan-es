<?php 

// CUser. restart. 

class CUser extends CModel {

	private $isAuthenticated;

	/**
	 *
	 * Constructor for the class.
	 * @param array $database with database DSN.
	 */

	public function __construct($database) {
		$this->setTargetTable('users');
		parent::__construct($database);

		// print_r($_SESSION); // visar Array (). Alltså finns den inte i session vid construct. För att session rensas någonstans INNAN detta händer. 
		if(isset($_SESSION['user'])) {
			$u = unserialize($_SESSION['user']);
			$this->id = $u->id;
			$this->username = $u->username;
			$this->email = $u->email;
			$this->text = $u->text;
			$this->created = $u->created;
			$this->isAuthenticated = $u->isAuthenticated;
			$u = null;
		} else {
			$this->isAuthenticated = false;
		}
	}

	/**
	 *
	 * Function to login the user.
	 * @param string $email, the users email, 
	 * @param string $password, the users password.
	 * @return boolean success. 
	 */

	public function login($email, $password) {
		if($user = $this->findFirst(['email' => $email])) {
			if(password_verify($password, $user->password)) {
				$this->id = $user->id;
				$this->username = $user->username;
				$this->email = $user->email;
				$this->text = $user->text;
				$this->created = $user->created;
				$this->isAuthenticated = true;
				$_SESSION['user'] = serialize($this);
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
	 * @return redirect.
	 */

	public function logout() {
		$this->isAuthenticated = false;
		unset($_SESSION['user']);
		$_SESSION = array();
		return header('Location: login.php?action=logout');
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
	 */

	public function isAuthenticated() {
		return $this->isAuthenticated;
	}

	/**
	 *
	 * Function to get link to Gravatar image.
	 * @return string link to Gravatar image.
	 */
	
	public function getGravatar($size = 80) {
		$email = $this->email;
		$url = "http://www.gravatar.com/avatar/";
		$default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
		return  $url . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
	}

	/**
	 *
	 * Magic method to help serialize the CUser object in $_SESSION. 
	 * @return array of members to serialize. 
	 */

	public function __sleep() {
		foreach($this as $property => $value) {
			$prop[] = $property;
		}
		return $prop;
	}

}




