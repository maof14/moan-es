<?php 
/**
 * This is a triton pagecontroller.
 *
 */
// Include the essential config-file which also creates the $triton variable with its defaults.
include(__DIR__ . '/config.php'); 
 
 
// Do it and store it all in variables in the triton container.
$triton['title'] = "401";
$triton['header'] = "";
$triton['main'] = "This is a Anax 401. You are not authorized to view this page. But you can create an account! :)";
$triton['footer'] = "";
 
// Send the 404 header 
header("HTTP/1.0 401 Unauthorized");
 
 
// Finally, leave it all to the rendering phase of triton.
include(TRITON_THEME_PATH);