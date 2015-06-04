<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "About the site";
$triton['main'] = <<<EOD
<h1>About</h1>
<p class='lead'>What is all this?</p>
<p>Working as an accountant, I have made countless of updates to objects in SAP. Until I found out that those can quite easily be automated.</p>
<p>To smoothe the process, we at MOAN Enterprise Solutions have come up with a few tools to automate such SAP tasks.</p>
<p>We are also happy to help you out with any other Excel automation. That is the future!</p>
<p>Automating repetative SAP tasks is a major increase in effectiveness and health.</p>
<p>Check out the <a href='examples.php'>examples</a> to get started.</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

