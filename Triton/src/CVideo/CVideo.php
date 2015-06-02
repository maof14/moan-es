<?php 

// CVideo

class CVideo {

	private $id;
	private $user;
	private $url;
	private $title;
	private $description;
	private $src;
	private $db;
	private $likes;
	private $dislikes;
	// src blir fel, ändra i CProcessVideo
	public function __construct($db, $url) {
		$this->db = new CDatabase($db);
		$sql 				= "SELECT v.*, u.acronym FROM video AS v JOIN user AS u ON v.user = u.id WHERE v.url = ?";
		$params[] 			= $url;
		$res 				= $this->db->ExecuteSelectQueryAndFetch($sql, $params);
		if(!empty($res)) {
			$this->id 			= $res->id;
			$this->user 		= $res->user;
			$this->title 		= $res->title;
			$this->description 	= $res->description;
			$this->src 			= $res->src;
			$this->created 		= $res->created;
			$this->likes		= $res->likes;
			$this->dislikes		= $res->dislikes;
			$this->acronym 		= $res->acronym;
		} else {
			exit("This video doesn't exist!");
		}
	}
	public function getMember($member) {
		return $this->$member;
	}
	public function getLikeRatio() {
		$total = $this->likes + $this->dislikes;
		if($total == 0) {
			$total = 1;
		}
		return round(($this->likes / $total) * 100);
	}
}