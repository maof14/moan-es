<?php 

// handle_request.php
// remove examples in a nice looking way. Mostly for own use. Hopefully. Thats good. 

// include essential config.php file for project. 
require(__DIR__ . '/../config.php');

// if user is online...
if(isset($_SESSION['user'])) {
	// get action
	$action = isset($_GET['action']) ? $_GET['action'] : null;
	// if action is delete
	if($action = 'delete') {
		// get id to perform action on. 
		$id = isset($_GET['id']) ? $_GET['id'] : null;
		// if id is specified.
		if($id) {
			// create example obj. 
			$example = new CExample($triton['database']);
			// if found.
			if($example = $example->findFirst(['id' => $id], true)) {
				// try remove
				$success = $example->remove();
			} else {
				$success = false;
			}
		}
	}
}

// display boolean success. 
header('Content-type: application/json');
echo json_encode(array('output' => ['success' => $success])); 