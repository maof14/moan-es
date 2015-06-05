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
<p class='lead'>What is this site all about?</p>
<div class='row'>
<div class='col-md-6'>
<h2>The site</h2>
<p>Working as an accountant, I have made countless of updates to objects in SAP. Until I found out that those can quite easily be automated.</p>
<p>To smooth out the process of running these kinds of scripts, we at MOAN Enterprise Solutions have come up with a few tools for you to automate such repetative, but neccessary SAP tasks.</p>
<p>We believe that the usage of these scripts is largely unknown and want to spread the word with this website as well as helping you out with it.</p>
<p>Check out the <a href='examples.php'>examples</a> to get started.</p>
</div>
<div class='col-md-6'>
<h2>About our developers</h2>
<table>
<tr rowspan=2><td class='profile-pic-width'><img src='img.php?src=10468700_10152545179440876_7498714125452152732_n.jpg&width=100' class='image-cell-spaceing img-circle border' alt='Picture of Mattias'></td><td class='top-align'><h4 class='top'>Mattias Olsson</h4><p><strong>Founder, developer.</strong></p></td></tr>
<tr><td colspan=2><p>Mattias has many years of experience with operational work in SAP and Excel (8 years to be exact!). He also have a firm experince in working with PHP and the common web design technologies such as HTML, CSS, Javascript and databases.</p><p>Something totally irrelevant: Mattias is kind of a space-nerd, reading all books he finds on the topic :).</p></td></tr>
</table>
</div>
</div>
<h2>Our vision</h2>
<p>Some work are really meant for robots. We firmly believe that everything that could possibly be automated, should be.</p>

EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

