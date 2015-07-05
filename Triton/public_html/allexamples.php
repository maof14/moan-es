<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "All examples";

if(!isset($_SESSION['user'])) {
	throw new Exception('Nope. You can\'t be here. Sorry!');
}

$db = new CDatabase($triton['database']);
$sql = "SELECT * FROM examples ORDER BY created DESC LIMIT 0, 10"; // add paginering. Custom class for that?
$examples = $db->executeSelectQueryAndFetchAll($sql);

$adminBar = null;
if(checkLogin()) {
	$admin = true;
} else {
	$admin = false;
}

$html = "<div class='examples'>";
foreach($examples as $example) {
	if($admin) {
		$available = $example->published ? "<span title='Published' class='glyphicon glyphicon-ok' aria-hidden='true'></span>" : "<span title='Not published' class='icon-available glyphicon glyphicon-minus' aria-hidden='true'></span>";
		$adminBar = "<span class='right top'><a href='editexample.php?id={$example->id}' class='edit-example'><span title='Edit this example' class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> <a href='#' class='delete-example' example-id={$example->id}><span title='Remove this example' class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> <a href='#' class='publish-example' example-id={$example->id}>{$available}</a></span></span>"; 
	} 
	$html .= "<div class='well'>\n";
	$html .= "<div class='media-body'>\n";
	$html .= "<h4 class='media-heading'><a href='example/{$example->slug}' title='View this article'>{$example->title}</a></h4>{$adminBar}\n";
	$html .= "<p>{$example->description}</p>\n";
	$html .= "<ul class='list-inline list-unstyled small grey'>\n
				<li><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> {$example->created}</li>\n
				<li>|</li>\n
				<li><span class='glyphicon glyphicon-user' aria-hidden='true'></span> by {$example->username}</li>\n
				</ul>\n";
	$html .= "</div>\n</div>\n";
}
$html .= "</div>";

$triton['main'] = <<<EOD
<h1>All example articles</h1>
<p class='lead'>From this page, you can access the administrative options for the examples. Edit, delete or publish as public example.</p>
{$html}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

