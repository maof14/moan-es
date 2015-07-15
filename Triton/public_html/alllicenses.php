<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$page = null;
if(isset($_SESSION['user'])) {
	$license = new CLicense($triton['database']);
	$licenseTable = $license->getAll();
	$createForm = $license->getCreateForm();
	$page = <<<EOD
	{$licenseTable}
	{$createForm}
EOD;
} else {
	throw new Exception('Nope. You can\'t be here. Sorry!');
}

$triton['title'] = 'License management';
$triton['main'] = <<<EOD
<h1>License management</h1>
<p class='lead'>Manage customer licenses here.</p>
{$page}
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

