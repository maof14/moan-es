<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$triton['title'] = "About the site";
$triton['main'] = <<<EOD
<article class='justify'>
<h1>About</h1>
<p class='lead'>What is this site all about?</p>
<div class='row'>
<div class='col-md-6'>
<h2>The site</h2>
<p>Working as an accountant, I have made countless of updates to objects in SAP. Until I found out that those can quite easily be automated.</p>
<p>To smooth out the process of running these kinds of scripts, we at MOAN Enterprise Solutions have come up with a few tools for you to automate such repetative, yet neccessary SAP tasks.</p>
<p>We believe that the usage of these scripts is largely unknown and want to spread the word with this website as well as helping you out with it.</p>
<p>Check out the <a href='examples'>examples</a> to get started.</p>
<h2>Our vision</h2>
<p>Some work are really meant for robots. We firmly believe that everything that could possibly be automated, should be.</p>
<h2>Our mission</h2>
<p>Our mission is, of course, to make our vision come true. We want to achieve this by helping people to take advantage of automation technologies where this is possible.</p>
<h2>...MOAN?</h2>
<p>Our name is an abbreviation of <strong>M</strong>attias <strong>O</strong>lsson <strong>A</strong>utomatio<strong>n</strong>.</p>
<p>It does also represent what you won't do, when our solutions is installed.</p>
</div>
<div class='col-md-6'>
<h2>About our developers</h2>
<table>
<tr rowspan=2><td class='profile-pic-width'><img src='img.php?src=10468700_10152545179440876_7498714125452152732_n.jpg&width=100' class='image-cell-spaceing img-circle' alt='Picture of Mattias'></td><td class='top-align'><h4 class='top'>Mattias Olsson</h4><p><strong>Founder, developer.</strong></p></td></tr>
<tr><td colspan=2><p>Mattias has many years of experience with operational work in SAP and Excel (8 years to be exact!). He also have a firm experince in working with PHP and the common web design technologies such as HTML, CSS, Javascript and databases.</p><p>Mattias has taken university coarses in Business economics, Economics, Geology and Web development.</p><p>Something totally irrelevant: Mattias is kind of a space-nerd, reading all books he finds on the topic.</p></td></tr>
<tr rowspan=2><td class='profile-pic-width'><img src='img.php?src=11060962_10152776411030959_6049572993166866429_n.jpg&width=100' class='image-cell-spaceing img-circle' alt='Picture of Marcus'></td><td class='top-align'><h4 class='top'>Marcus Olsson</h4><p><strong>Developer, tester.</strong></p></td></tr>
<tr><td colspan=2><p>Marcus is about to start studying to become a game developer, and is also currently helping out in the process of creating scripts for MOAN Enterprises.</p><p>Something totally irrelevant: Marcus all time favourite game is Red Dead Redemption.</p></td></tr>
</table>
</div>
</div>
</article>
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

