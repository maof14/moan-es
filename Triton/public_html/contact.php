<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$triton['title'] = "Contact us";
$triton['main'] = <<<EOD
<article class='justify'>
<h1>Contact us</h1>
<p class='lead'>We would love to hear from you!</p>
<h2>Social networks</h2>
<p>If you have any questions regarding our products or services, be sure to throw us a mail at <a href='mailto:mattias.olsson@moanenterprise.com'>this adress</a>.</p>
<p>You can also contact me here:</p>
<ul class='contact'>
	<li><a href='https://www.linkedin.com/profile/view?id=403433860' target='_blank'>LinkedIn</a></li>
	<li><a href='https://www.github.com/maof14' target='_blank'>GitHub</a></li>
	<li><a href='https://www.twitter.com/mattias119' target='_blank'>Twitter</a></li>
	<li><a href='https://www.facebook.com/mattiasnolsson' target='_blank'>Facebook</a>, why not?</li>
</ul>
<h2>Address</h2>
<ul class='contact'>
<li>Mattias Olsson</li>
<li>Skebokvarnsvägen 376</li>
<li>124 50 Bandhagen</li>
<li>Sweden</li>
</ul>
</article>
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

