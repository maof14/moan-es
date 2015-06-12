<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "dbtest";

$user = new CUser($triton['database']);
$user->login('maof14', 'mlo313');

$triton['main'] = <<<EOD
<h1 class='welcome'>Welcome!</h1>
<p>This is the page of project &lt; tube &gt; </p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

