<?php 

// process_comments 

// This script is intended to handle incoming comments on videos, and also to get "reload" the comments on posting one. 

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../config.php');

$c = new CComment($triton['database']); 

// comment incoming
if(isset($_SESSION['user']) && isset($_POST['commenttext'])) {
	$lastRow = $c->addAjax();
	header('Content-type: application/json');
	echo json_encode(array('comment' => $lastRow->id));
	exit;
}

// handle likes
if(isset($_SESSION['user']) && isset($_POST['direction']) && isset($_POST['videoid'])) {
	switch ($_POST['direction']) {
		case 'up':
			$result = $c->addLike($_POST['videoid']);
			break;
		case 'down': // default = dislike :(
			$result = $c->addDislike($_POST['videoid']);
			break;
		default: {
			$result = 0; // nothing happened.
		}
	}
	header('Content-type: application/json');
	echo json_encode(array('result' => $result));
	exit;
}

// request reload. Return the new comment. // lol finns inga kommentarer. 
if(isset($_GET['id'])) {
	$comment = $c->getAjax($_GET['id']);
	header('Content-type: application/json');
	echo json_encode(array('comment' => $comment));
	exit;
}