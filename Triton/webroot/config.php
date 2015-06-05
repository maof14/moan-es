<?php

/* Config file!

*/ 

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

/* 

Define triton paths
*/
define('TRITON_INSTALL_PATH', __DIR__ . '/..');
define('TRITON_THEME_PATH', TRITON_INSTALL_PATH . '/theme/render.php');

/*
include bootstrapping funtions.
*/
include(TRITON_INSTALL_PATH . '/src/bootstrap.php');

/* 

Start the session */

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

$flash = new CFlash();

/** 
 *
 * if want to hide site menu - set to session. 
 *
 */

// finurligt för att gömma menyn, om man vill det. Och låta kontroll med $.ajax ske på denna. 
// $_SESSION['hideMenu'] = false;

/* 

Create the triton variable. 
*/ 

$triton = array();

/*

Site wide settings. 
*/
$triton['lang']			= 'en';
$triton['title_append'] = ' | MOAN Enterprises Solutions';

/* 
* Settings for the database 
*/
$dbpath = realpath(TRITON_INSTALL_PATH.'/db/.htsqlite.db');
$triton['database']['dsn']               = 'sqlite:'.$dbpath; // 'mysql:host=localhost;dbname=maof14;
// $triton['database']['verbose'] 			 = false;
// $triton['database']['username']       = 'root'; // maof14
// $triton['database']['password']       = ''; // 
// $triton['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/* Theme related settings

*/

// using compiled css instead of less when in "production"
$triton['stylesheets'][] = 'style/bootstrap.min.css';
$triton['stylesheets'][] = 'style/code-example.css';
$triton['stylesheet'] 	 = 'style/style.css';
// $triton['stylesheets'][] = 'style/font-awesome-4.3.0/css/font-awesome.min.css';
// $triton['favicon'] = 'favicon.ico';

// custom for project - array of above and below javascript files. 
$triton['js']['above'][] = 'js/modernizr.js';
/* $triton['js']['above'][] = 'js/less.min.js?ts=<?=time()?>'; // forcing download. FAIL! function as string... */ 
$triton['js']['below'][] = 'js/jquery.min.js'; // jQuery before using jQuery.. :) 
$triton['js']['below'][] = 'js/bootstrap.min.js';
$triton['js']['below'][] = 'js/main.js';


$triton['header'] = <<<EOD
<span class='sitetitle'>MOAN Enterprise Solutions</span>
<span class='siteslogan'>Giving accountants a break since 2011</span>
EOD;

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
	], 
	'login' => [
		'text' => 'Log in', 
		'url' => 'login.php'
	],
);

$triton['navmenu'] = CNavigation::GenerateMenu($menu, 'collapse navbar-collapse');

$triton['footer'] = <<<EOD
<nav class='navbar navbar-default navbar-fixed-bottom'>
			<div class='container'>
<footer>
<p class="navbar-text small">Copyright &copy; Mattias Olsson 2015. Powered by Triton.</p>
</footer>
</div>
</nav>
EOD;
