<?php 

/* render content to theme
*/ 

// Extract the data array to variables for easier access in the template files.


extract($triton);

// include the template funtions.
include(__DIR__ . '/functions.php');

// include the template file.
include(__DIR__ . '/index.tpl.php');

