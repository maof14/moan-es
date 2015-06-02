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
$triton['main'] = "This is a Anax 404. Document is not here.";
$triton['footer'] = "";
 
// Send the 404 header 
header("HTTP/1.0 404 Not Found");
 
 
// Finally, leave it all to the rendering phase of triton.
include(TRITON_THEME_PATH);