<?php 

// CUser. restart. 

class CUser {

	private $id; 
	private $acronym;
	private $name;
	private $text;
	private $created;
	private $isAuthenticated;
	private $db;

	// $id - if one would want to look at another user. For later. 
	public function __construct($db, $id = null) {
		$this->db = new CDatabase($db);
		if(isset($id)) {
			$sql = "SELECT * FROM user WHERE id = ?";
			$params[] = $id;
			$res = $this->db->ExecuteSelectQueryAndFetch($sql, $params);
			$this->id = $res->id;
			$this->acronym = $res->acronym;
			$this->name = $res->name;
			$this->email = $res->email;
			$this->text = $res->text;
			$this->created = $res->created;
		} else if(isset($_SESSION['user'])) {
			$this->id = $_SESSION['user']->id;
			$this->acronym = $_SESSION['user']->acronym;
			$this->name = $_SESSION['user']->name;
			$this->email = $_SESSION['user']->email;
			$this->text = $_SESSION['user']->text;
			$this->created = $_SESSION['user']->created;
			$this->isAuthenticated = true;
		}
	}

	public function createUser() {
		if($_POST['password'] == $_POST['repeatpassword']) {
			$sql = "INSERT INTO user(acronym, email, name, password, text, created) VALUES(?, ?, ?, ?, ?, ?)";
			$params[] = $_POST['acronym'];
			$params[] = $_POST['email'];
			$params[] = $_POST['name'];
			$params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$params[] = $_POST['text'];
			$params[] = date(DATE_RFC822);
			return $this->db->ExecuteQuery($sql, $params);
		}
	}

	public function login($username, $password) {
		// $_SESSION = array();
		// verifiera: boolean password_verify ( string $password , string $hash )
		// vet ej
		$sql = "SELECT * FROM user WHERE acronym = ?";
		$params[] = $username;
		$res = $this->db->ExecuteSelectQueryAndFetch($sql, $params);
		
		if(password_verify($password, $res->password)) {
			$this->id = $res->id;
			$this->acronym = $res->acronym;
			$this->name = $res->name;
			$this->email = $res->email;
			$this->text = $res->text;
			$this->created = $res->created;
			$this->isAuthenticated = true;
			$_SESSION['user'] = $this;
		} else {
			$_SESSION = array();
		}
		$this->db = null;
		header("Location: login.php?p=login");
	}

	public function logout() {
		$this->isAuthenticated = false;
		unset($_SESSION['user']);
		$_SESSION = array();
		header('Location: login.php?p=logout');
	}

	public function isAuthenticated() {
		return $this->isAuthenticated;
	}

	public function getId() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getAcronym() {
		return $this->acronym;
	}

	// Allt nedan kopirat från oophp-klassen. 
	public function getStatus() {
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
		if($acronym) {
			$output = "Du är inloggad som $acronym ({$_SESSION['user']->name})";
		} else {
			$output = "Du är inte inloggad.";
		}
		return $output;
	}

	public static function getLoginMenu() {
		$html = "<nav class='user right'>\n";
		if(!isset($_SESSION['user'])) {
			$html .= "<a href='login.php?p=login'>Logga in</a>\n";
		} else {
			$html .= "<a href='profile.php'>Min sida</a>\n";
			$html .= "<a href='login.php?p=logout'>Logga ut</a>\n";
		}
		$html .= "</nav>\n";
		return $html;
	}
	
	public function getLoginPrompt() {
		if(!isset($_SESSION['user'])) {
			$action = "Log in";
			$submit = "login";
			$colspan = "colspan=2";
			$fields = "<tr>\n";
			$fields .= "<td><label>Username: </label></td>\n";
			$fields .= "<td><input type='text' name='txtusername'></td>\n";
			$fields .= "</tr>\n";
			$fields .= "<tr>\n";
			$fields .= "<td><label>Password: </label></td>\n";
			$fields .= "<td><input type='password' name='txtpassword'></td>\n";
			$fields .= "</tr>\n";
		} else {
			$action = "Log out";
			$submit = "logout";
			$colspan = null;
			$fields = null;
		}
		
		$html = "<h1>$action</h1>\n";
		$html .= "<p>Log in or out here.</p>\n";
		$html .= "<form method='post' class='form-table'>\n";
		$html .= "<fieldset>\n";
		$html .= "<table>\n";
		$html .= $fields;
		$html .= "<tr>\n";
		$html .= "<td $colspan><input type='submit' name='$submit' value='$action' class='btn'></td>\n";
		$html .= "</tr>\n";
		$html .= "</table>\n";
		$html .= "</fieldset>\n";
		$html .= "</form>\n";
		return $html;
	}

	public function getGravatar($size = 80) {
		$email = $this->email;
		$url = "http://www.gravatar.com/avatar/";
		$default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
		return  $url . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
	}
	public function getMember($member) {
		return $this->$member;
	}

	public function getVideoList() {
		$sql = "SELECT * FROM video WHERE user = ? ORDER BY created DESC";
		$params[] = $this->id;
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
		$vidCount = count($res);
		$html = "<table>\n";
		$col = 0;
		$row = 0;
		$i = 0;
		foreach($res as $video) {
			if($col % 4 == 0) {
				$html .= "<tr>\n"; // table row
				$row++;
			}
			$html .= "<td class='center'><figure><a href='video.php?v=" . $video->url . "'><img class='thumbnail' src='img.php?src={$video->src}png&amp;width=100' alt='' /></a><figcaption class='small grey'>" . $video->title. "</figcaption></figure></td>\n"; // table data (column)
			$col++;
			if($col == 4 || $i == $vidCount - 1) {
				$html .= "</tr>\n";
				$row++;
			}
			$i++;
		}
		$html .= "</table>\n";
		return $html;
	}
}




