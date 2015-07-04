<?php 

/** 
 *
 * This is a triton pagecontroller
 * Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
 *
 */ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

$db = new CDatabase($triton['database']);

// Create model. 
$example = new CExample($triton['database']);

// Return model from creator model. If that fails, return the 404-page instead. 
if(!$example = $example->findFirst(['slug' => $slug])) {
	// One of these should work. 
	// return header('HTTP/1.0 404 Not Found');
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

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

