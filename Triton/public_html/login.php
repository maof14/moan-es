<?php 

/* ** 

This is triton pagecontroller from oophp project

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)

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
<p>While you're at it, want to create an <a href='newexample.php'>example tutorial</a>?
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

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

// echo dump($_SESSION);

// dump på session här, efter login, visar session. Alltså är det någontingting som händer innan man försöker logga in. Alltså innan sidan laddas om igen, så är session nollställt. Det är bra att jag har kommit fram till det. 