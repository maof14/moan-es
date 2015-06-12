<?php

/**
 *
 * Config file. Keep in mind that this file loads before all others. 
 * 
 */ 

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

/** 
 *
 * Define Triton paths. 
 * 
 */

define('TRITON_INSTALL_PATH', __DIR__ . '/..');
define('TRITON_THEME_PATH', TRITON_INSTALL_PATH . '/theme/render.php');

/**
 *
 * Include bootstrapping functions.
 *
 */

include(TRITON_INSTALL_PATH . '/src/bootstrap.php');

/**
 *
 * Start the session. 
 *
 */

session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();

/**
 *
 * Create callback function to check if logged in
 * @return Boolean indicating if user is online.
 */

function checkLogin() {
	if(isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}

/**
 *
 * Create "global" flash variable. Use to display flash messages with setMessage().  
 *
 */

$flash = new CFlash();

/** 
 *
 * If want to hide site menu - set to session. 
 *
 */

// Use $.ajax() to determinate if user wants to show / hide the nav menu.
// $_SESSION['hideMenu'] = false;

/**
 *
 * Create the triton global variable. 
 *
 */ 

$triton = array();

/**
 *
 * Site wide settings. 
 * 
 */

$triton['lang']			= 'en';
$triton['title_append'] = ' | MOAN Enterprises Solutions';

/**
 * 
 * Settings for the database. Uncommented MySQL DSN - use that for production?
 *
 */

$dbpath = realpath(TRITON_INSTALL_PATH.'/db/.htsqlite.db');
$triton['database']['dsn']               = 'sqlite:'.$dbpath; // 'mysql:host=localhost;dbname=maof14;
// $triton['database']['verbose'] 			 = false;
// $triton['database']['username']       = 'root'; // maof14
// $triton['database']['password']       = ''; // 
// $triton['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/** 
 *
 * Theme related settings.
 *
 */

/**
 *
 * If LESS - use compiled for production.
 *
 */

$triton['stylesheets'][] = 'style/bootstrap.min.css';
$triton['stylesheets'][] = 'style/code-example.css';
$triton['stylesheet'] 	 = 'style/style.css';

/**
 *
 * Array of "above" and "below" javascript files. Above loads in head, below loads below footer. 
 *
 */

$triton['js']['above'][] = 'js/modernizr.js';
$triton['js']['below'][] = 'js/jquery.min.js'; // jQuery before using jQuery.. :) 
$triton['js']['below'][] = 'js/bootstrap.min.js';
$triton['js']['below'][] = 'js/marked.min.js'; // moved those two vue files to the js lib. 
$triton['js']['below'][] = 'js/vue.min.js';
$triton['js']['below'][] = 'js/main.js';

/**
 *
 * Common header for the page. Not used in MOAN ES. 
 *
 */

$triton['header'] = <<<EOD
<span class='sitetitle'>MOAN Enterprise Solutions</span>
<span class='siteslogan'>Giving accountants a break since 2011</span>
EOD;

/**
 * 
 *
 * Navigation menu options as array. (To be sent to navigation generator.)
 *
 */

$menu = array(
	'start' => [
		'text' => 'Start',
		'url' => 'start.php'
	],
	'products' => [
		'text' => 'Products',
		'url' => 'products.php'
	], 
	'examples' => [
		'text' => 'Examples',
		'url' => 'examples.php'
	],
	'about' => [
		'text' => 'About',
		'url' => 'about.php'
	],
	'contact' => [
		'text' => 'Contact', 
		'url' => 'contact.php'
	]
);

/** 
 *
 *
 * Generate the navigation menu for the page.
 *
 */

$triton['navmenu'] = CNavigation::GenerateMenu($menu, 'collapse navbar-collapse');


/**
 *
 * Common header for the page. 
 *
 */

$triton['footer'] = <<<EOD
<nav class='navbar navbar-default navbar-fixed-bottom'>
	<div class='container'>
		<footer>
			<p class="left navbar-text small">Copyright &copy; Mattias Olsson 2015. Powered by Triton, a product of MOAN Enterprise Solutions.</p><p class='right navbar-text small'><a href='login.php'>Admin page</a></p>
		</footer>
	</div>
</nav>
EOD;
