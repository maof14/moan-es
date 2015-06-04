<?php 
/**
 * This is a triton pagecontroller.
 *
 */
// Include the essential config-file which also creates the $triton variable with its defaults.
include(__DIR__ . '/config.php'); 
 
// Do it and store it all in variables in the triton container.
$triton['title'] = "404";
$triton['header'] = "";
$triton['main'] = <<<EOD

<h1>Four o four!</h1>
<p class='lead'>This is a Triton 404.</p>
<p>This document is not here. Sorry about that. Try another link!</p>

EOD;
 
// Send the 404 header 
header("HTTP/1.0 404 Not Found");
 
// Finally, leave it all to the rendering phase of triton.
include(TRITON_THEME_PATH);