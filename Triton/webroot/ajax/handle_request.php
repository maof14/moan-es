<?php 

// handle_request.php
// remove examples in a nice looking way. Mostly for own use. Hopefully. Thats good. 

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../config.php');

header('Content-type: application/json');
echo json_encode('output' => []); 