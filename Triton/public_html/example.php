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

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

