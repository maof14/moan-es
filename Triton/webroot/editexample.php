<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$page = null;

if(isset($_SESSION['user'])) {
	$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
	$example = new CExample($triton['database']);
	// incorporate = true;
	$example = $example->findFirst(['id' => $id], true);

	$page = <<<EOD
<form class="form-newpost" method="post">
	<div id='editor'>
	<div class='row'>
		<div class="form-group col-md-6">
			<label for='title'>Title</label>
			<input type="text" id="title" name="title" class="form-control" placeholder="Example title" value='{$example->title}'/>
			<label for='description'>Description</label>
			<input type='text' id='description' name='description' class='form-control' placeholder='Short description of example' value='{$example->description}'/>
			<label for='text'>Text</label>
			<textarea v-model='input' debounce='300' id="text" name="text" class="form-control" placeholder="Your example article" cols="10" rows="20">{$example->text}</textarea>			<div class='input-group'>
		</div>
	</div>
	<div class='col-md-6'>
		<label for='markdown-preview'>Markdown preview</label>
		<div id='markdown-preview' v-html='input | marked'>
			<!-- add a border here -->
		</div>
	</div>
	</div>
	<div class='row'>
		<div class='form-group'>
			<div class='col-md-3'>
				<input type="submit" id="submit" name="submit" value="Save" class="btn btn-lg btn-primary btn-block" />	
			</div>
			<div class='col-md-3'>
				<input class='btn btn-lg btn-warning btn-block' type='reset' value='Clear' />
			</div>
		</div>
	</div>
	</div>
</form>
EOD;
} else {
	throw new Exception('Nope. You can\'t be here. Sorry!');
}

if(isset($_POST['submit'])) {
	$u = unserialize($_SESSION['user']);
	$updatedexample = [
		'userid' => $u->getId(),
		'username' => $u->getUsername(),
		'title' => $_POST['title'],
		'text' => $_POST['text'],
		'created' => date(DATE_RFC822),
		'description' => $_POST['description']
	];
	$u = null;
	if($example->save($updatedexample)) {
		return header('Location: examples.php');
	} else {
		throw new Exception('Unknown error inserting to database.');
	}
}

$triton['title'] = 'Create example';
$triton['main'] = <<<EOD
<h1>Create new example</h1>
<p class='lead'>Create new tutorial example on this page.</p>
{$page}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

