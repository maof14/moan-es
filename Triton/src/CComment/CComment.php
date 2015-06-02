<?php

// CComment.php

// Class to handle comments and such.

class CComment {
	// Members !! 

	private $db;

	public function __construct($db=null) {
		// pga kanske inte nödvändig i ajax. 
		if(isset($db)) {
			$this->db = new CDatabase($db);
		}
	}

	// To be called from the Ajax script. Borde fungera.
	public function addAjax() {
		$user = $_SESSION['user'];
		$sql = "INSERT INTO comment(userid, videoid, text, created) VALUES(?, ?, ?, ?)";
		$params[] = $user->getId();
		$params[] = $_POST['videoid'];
		$params[] = $_POST['commenttext'];
		$params[] = date(DATE_RFC822);
		if($this->db->ExecuteQuery($sql, $params)) {
			$sql = "SELECT LAST_INSERT_ROWID() AS id";
			$lastRow = $this->db->ExecuteSelectQueryAndFetch($sql);
		} else {
			$lastRow = null;
		}
		return $lastRow;
	}

	public function getAjax($id) {
		$sql = "SELECT c.*, u.acronym FROM comment AS c  
			JOIN user AS u ON c.userid = u.id
			WHERE c.id = ?";
		$params[] = $id;
		$res = $this->db->ExecuteSelectQueryAndFetch($sql, $params);
		$comment['id'] = $res->id;
		$comment['userid'] = $res->userid;
		$comment['videoid'] = $res->videoid;
		$comment['text'] = $res->text;
		$comment['created'] = $res->created;
		$comment['acronym'] = $res->acronym;
		return $comment;
	}

	// skall använda buttons för bättre Ajax-kompabilitet. Och ska ha rolig ikon på knappen. :) 
	public function getForm($videoId) {
		$html = "<div id='new-comment'>\n";
		$html .= "<h2>Add a comment</h2>\n";
		$html .= "<form method='post' class='form-table'>\n";
		$html .= "<fieldset>\n";
		$html .= "<table>\n";
		$html .= "<tr>\n";
		$html .= "<td><textarea id='commenttext' name='commenttext'></textarea></td>\n";
		$html .= "</tr>\n";
		$html .= "<tr>\n";
		$html .= "<td><button type='button' id='comment-add' class='btn'><i class='fa fa-comment'></i> Add comment</button><input type='hidden' name='videoid' value='{$videoId}'></td>\n";
		$html .= "</tr>\n";
		$html .= "</table>\n";
		$html .= "</fieldset>\n";
		$html .= "</form>\n";
		$html .= "</div>\n";
		return $html;
	}

	// returnera alla comments på en video. 
	public function getComments($id) {
		$sql = "SELECT c.*, u.acronym FROM comment AS c  
				JOIN user AS u ON c.userid = u.id
				WHERE c.videoid = ? 
				ORDER BY c.created DESC";
		$params[] = $id;
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);

		if(!empty($res)) {
			$html = "<div class='comments'>\n";
			foreach($res as $comment) {
				$html .= "<div id='comment-{$comment->id}' class='comment'>\n";
				$html .= "<span class='comment-header'>Posted by <span class='data'><a href='profile.php?id={$comment->userid}'>{$comment->acronym}</a></span> on <span class='data'>{$comment->created}</span></span><br />";
				$html .= "{$comment->text}\n";
				$html .= "</div>\n";
			}
			$html .= "</table>\n";
			$html .= "</div>\n";
			return $html;
		}
		return '<span class="comment"><span class="no-comments">No comments on this video yet. Be the first!</span></span>';
	}

	public function addLike($videoId) {
		$sql = "UPDATE video SET likes = likes + 1 WHERE id = ?";
		$params[] = $videoId;
		if($this->db->ExecuteQuery($sql, $params)) {
			$sql = "SELECT likes, dislikes FROM video WHERE id = ?";
			$res = $this->db->ExecuteSelectQueryAndFetch($sql, $params);
			return array('result' => 1, 'likes' => $res->likes, 'dislikes' => $res->dislikes);
		} else {
			return false;
		}
	}

	public function addDislike($videoId) {
		$sql = "UPDATE video SET dislikes = dislikes + 1 WHERE id = ?";
		$params[] = $videoId;
		if($this->db->ExecuteQuery($sql, $params)) {
			$sql = "SELECT likes, dislikes FROM video WHERE id = ?";
			$res = $this->db->ExecuteSelectQueryAndFetch($sql, $params);
			return array('result' => -1, 'likes' => $res->likes, 'dislikes' => $res->dislikes);
		} else {
			return false;
		}
	}
}