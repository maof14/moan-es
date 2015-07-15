<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$user = new CUser($triton['database']);

if(isset($_POST['login'])) {
	$username = $_POST['email'];
	$password = $_POST['password'];
	if($user->login($username, $password)) {
		$action = 'loginsuccess';
		$flash->setMessage('You successfully logged in.', ['alert', 'alert-success']);
	} else {
		$action = 'loginfailed';
		$flash->setMessage('Wrong credentials. Try again.', ['alert', 'alert-danger']);
	}
} elseif(isset($_POST['logout'])) {
	$user->logout();
} 

$loginPage = null;

if(checkLogin() == false) {
	$loginPage = <<<EOD
<p class='lead'>Log in here.</p>
<form class="form-signin" method="post">
	<div class='row'>
		<div class='form-group col-md-3'>
			<h1 class='form-signin-header'>Sign in</h1>
			<input type="text" id="email" name="email" class="form-control" placeholder="Email" />
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" />
		</div>
	</div>
	<div class='row'>
		<div class='form-group col-md-3'>
			<input type="submit" id='login' name='login' value="Sign in" class="btn btn-lg btn-primary btn-block" />
		</div>
	</div>
</form>	
EOD;
} else {
	$loginPage = <<<EOD
<p class='lead'>Log out here.</p>
<p>You are currently logged in as user: <strong>{$user->getUsername()}</strong></p>
<ul class='admin-options'>
<li><a href='all-examples'>Article management</a></li>
<li> | </li>
<li><a href='all-licenses'>License management</a></li>
</ul>
<form class="form-signin" method="post">
	<div class='row'>
		<div class='form-group col-md-3'>
			<input type="submit" id='logout' name='logout' value="Sign out" class="btn btn-lg btn-primary btn-block" />
		</div>
	</div>
</form>	
EOD;
}

$triton['title'] = 'Admin page';

$triton['main'] = <<<EOD
<h1>Administrative pages</h1>
{$loginPage}
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);
