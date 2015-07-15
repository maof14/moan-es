<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$triton['title'] = "All examples";

if(!isset($_SESSION['user'])) {
	throw new Exception('Nope. You can\'t be here. Sorry!');
}

$db = new CDatabase($triton['database']);
$sql = "SELECT * FROM examples ORDER BY created DESC LIMIT 0, 10";
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
		$available = $example->published ? "<span title='Published' class='glyphicon glyphicon-ok' aria-hidden='true'></span> <a href='example/{$example->slug}'><span title='View this article' class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>" : "<span title='Not published' class='icon-available glyphicon glyphicon-minus' aria-hidden='true'></span>";
		$adminBar = "<span class='right top'><a href='edit-example/{$example->id}' class='edit-example'><span title='Edit this example' class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> <a href='#' class='delete-example' example-id={$example->id}><span title='Remove this example' class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> <a href='#' class='publish-example' example-id={$example->id}>{$available}</a></span></span>"; 
	} 
	$html .= "<div class='well'>\n";
	$html .= "<div class='media-body'>\n";
	$html .= "<h4 class='media-heading'>{$example->title}</h4>{$adminBar}\n";
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
<h1>Article management</h1>
<p class='lead'>From this page, you can access the administrative options for the examples. Edit, delete or publish as public example.</p>
<p>To see an unpublished article, enter edit mode for the article. You can also create a <a href='new-example'>new example</a>.</p>
{$html}
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

