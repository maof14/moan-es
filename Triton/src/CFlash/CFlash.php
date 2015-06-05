<?php 

class CFlash {
	// Members!!

	private $message;
	private $class = array();
	private $hasMessage;

	// Methods!!
	public function __construct() {
		if(isset($_SESSION['flash'])) {
			$this->message = $_SESSION['flash']->message;
			$this->class = $_SESSION['flash']->class;
			$this->hasMessage = true;
		} else {
			$this->hasMessage = false;
		}
	}

	public function hasMessage() {
		if($this->hasMessage == true) {
			return true;
		} else {
			return false;
		}
	}

	public function setMessage($message, $class = array()) {
		$this->hasMessage = true;
		$this->message = $message;
		$this->class = $class;
	}

	public function getMessage() {
		$html = "<div class='";
		foreach($this->class as $class) {
			$html .= "{$class} ";
		}
		$html .= "'>";
		$html .= "{$this->message}</div>";
		$this->hasMessage = false;
		unset($_SESSION['flash']);
		return $html;
	}

}