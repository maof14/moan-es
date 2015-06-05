<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

$db = new CDatabase($triton['database']);
$sql = "SELECT * FROM examples WHERE slug = ?";
$example = $db->executeSelectQueryAndFetch($sql, array($slug));

if(!isset($slug) || count($example) == 0) {
	header('Location: 404.php');
}

$triton['title'] = "Example: {$example->title}";

$article = CTextFilter::doFilter($example->text, 'markdown');


// hur gör man här då. Generera fram en string som man sätter där nere?

$triton['main'] = <<<EOD
{$article}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

