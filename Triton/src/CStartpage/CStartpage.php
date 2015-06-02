<?php 

// CStartpage.php 

// Some functions to return data to the first page. 

class CStartpage {
	private $db;

	public function __construct($db) {
		$this->db = new CDatabase($db);
	}

	public function getLatestVideos() {
		$sql = "SELECT v.*, u.acronym FROM video AS v JOIN user AS u ON v.user = u.id ORDER BY v.created DESC LIMIT 0, 20";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		$html = "<div id='sliding-videos'>\n";
		foreach($res as $video) {
			// the rest outside this div, but same format. 
			$html .= "<div class='sliding-video'><figure><a href='video.php?v=" . $video->url . "'><img class='thumbnail' src='img.php?src={$video->src}png&amp;height=250' alt='' /></a><figcaption class='small grey'>" . $video->title. "</figcaption></figure></div>\n";
		}
		$html .= "</div>\n";
		return $html;
	}
}