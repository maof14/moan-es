<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "Example articles";

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
		$adminBar = "<span class='right top'><a href='editexample.php?id={$example->id}' class='edit-example'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> <a href='#' class='delete-example' example-id={$example->id}><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></span>"; 
	} 
	$html .= "<div class='well'>\n";
	$html .= "<div class='media-body'>\n";
	$html .= "<h4 class='left media-heading'><a href='example.php?slug={$example->slug}'>{$example->title}</a></h4>{$adminBar}\n";
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
<h1>Examples</h1>
<p class='lead'>On this page, you can find code example tutorials. Click on an article to learn more.</p>
{$html}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

