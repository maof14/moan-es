<?php 

// processupload.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../config.php');

$process = new CProcessVideo($triton['database']);

$process->moveFile(); // move from temp files
$process->processFile(); // process (convert) file
$process->createThumbnail(); // create thumbnail at 00:00:00.000

$url = $process->insertToDb();
$output = $process->getOutput();
$outputClass = $process->getOutputClass();
$link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$link = str_replace("ajax/process_upload.php", "video.php?v=".$url, $link);

// all is done. 
header('Content-type: application/json');
echo json_encode(array('output' => $output, 'outputClass' => $outputClass, 'url' => $url, 'link' => $link)); 