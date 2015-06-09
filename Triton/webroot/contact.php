<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "Contact";
$triton['main'] = <<<EOD
<article class='justify'>
<h1>Contact</h1>
<p class='lead'>We would love to hear from you!</p>
<p>If you have any questions regarding our products, services or support, be sure to throw us a mail at <a href='mailto:mattias.olsson@hotmail.se'>this adress</a>.</p>
<p>You can also contact me here:</p>
<ul>
	<li><a href='https://www.linkedin.com/profile/view?id=403433860' target='_blank'>LinkedIn</a></li>
	<li><a href='https://www.github.com/maof14' target='_blank'>GitHub</a></li>
	<li><a href='https://www.twitter.com/mattias119' target='_blank'>Twitter</a></li>
	<li><a href='https://www.facebook.com/mattiasnolsson' target='_blank'>Facebook</a>, why not?</li>
</ul>
</article>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

