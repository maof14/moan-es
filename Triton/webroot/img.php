<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)

include(__DIR__ . '/config.php');

error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly

$triton['title'] = "Bildvisare";

header("Cache-Control: public");
$img = new CImage2();

$triton['main'] = <<<EOD
<h1>Här kan man testköra image</h1>
<p>Här är lite exempeltext</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

