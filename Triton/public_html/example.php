<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

$db = new CDatabase($triton['database']);

// Create model. 
$example = new CExample($triton['database']);

// Find the example with raw sql by slug. 
if(!$example = $example->findByRawSQL("SELECT * FROM examples WHERE slug = '{$slug}' AND published = 1")) {
	return header('Location: ../404.php');
}

$triton['title'] = "{$example->title}";

$text = stripslashes($example->text);

$article = CTextFilter::doFilter($text, 'markdown');

$triton['main'] = <<<EOD
<article class='justify'>
{$article}
</article>
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

