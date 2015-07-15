<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$triton['title'] = "Example articles";

$db = new CDatabase($triton['database']);
$sql = "SELECT * FROM examples WHERE published = 1 ORDER BY created DESC LIMIT 0, 10"; // add paginering. Custom class for that?
$examples = $db->executeSelectQueryAndFetchAll($sql);

$html = "<div class='examples'>";
foreach($examples as $example) {
	$html .= "<div class='well'>\n";
	$html .= "<div class='media-body'>\n";
	$html .= "<h4 class='media-heading'><a href='example/{$example->slug}' title='View this article'>{$example->title}</a></h4>\n";
	$html .= "<p>{$example->description}</p>\n";
	$html .= "<ul class='list-inline list-unstyled small grey'>\n
				<li><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> " . CFunctions::getAgeString($example->created) . "</li>\n
				<li>|</li>\n
				<li><span class='glyphicon glyphicon-user' aria-hidden='true'></span> by {$example->username}</li>\n
				</ul>\n";
	$html .= "</div>\n</div>\n";
}
$html .= "</div>";

$triton['main'] = <<<EOD
<h1>Example articles</h1>
<p class='lead'>On this page, you can find code example tutorials. Click on an article to learn more.</p>
{$html}
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

