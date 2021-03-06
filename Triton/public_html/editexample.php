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
	$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
	$example = new CExample($triton['database']);
	// incorporate = true;
	$example = $example->findFirst(['id' => $id], true);

	$text = stripslashes($example->text);

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
			<textarea v-model='input' debounce='300' id="text" name="text" class="form-control" placeholder="Your example article" cols="10" rows="20">{$text}</textarea>			<div class='input-group'>
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
		'text' => addslashes($_POST['text']),
		'description' => $_POST['description']
	];
	$u = null;
	if($example->save($updatedexample)) {
		$flash->setMessage('Example saved!', ['alert', 'alert-success']);
		return header("Location: ../edit-example/{$id}");
	} else {
		throw new Exception('Unknown error inserting to database.');
	}
}

$triton['title'] = 'Edit example';
$triton['main'] = <<<EOD
<h1>Edit example</h1>
<p class='lead'>Edit an existing example on this page.</p>
{$page}
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

