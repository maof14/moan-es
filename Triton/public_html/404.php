<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

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

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);