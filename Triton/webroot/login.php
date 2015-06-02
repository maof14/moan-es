<?php 

/* ** 

This is triton pagecontroller from oophp project

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)

include(__DIR__ . '/config.php');

$user = new CUser($triton['database']);

if(isset($_POST['login'])) {
	$username = $_POST['txtusername'];
	$password = $_POST['txtpassword'];
	$user->login($username, $password);
} elseif(isset($_POST['logout'])) {
	$user->logout();
}

$prompt = $user->getLoginPrompt();

$triton['title'] = "My pages";

$triton['main'] = <<<EOD
$prompt
{$user->getStatus()}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

