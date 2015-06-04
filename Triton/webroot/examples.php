<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "Examples";
$triton['main'] = <<<EOD
<h1>Examples</h1>
<p class='lead'>Here you will find a list with example articles.</p>
<p>Kanske en av dem kan vara en guide till hur man skapar ett nytt macro. Det är ju bra liksom.</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

