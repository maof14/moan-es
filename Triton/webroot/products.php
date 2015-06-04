<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$fileContents = CFile::getFileContents('products.md');
$filtered = CTextFilter::doFilter($fileContents, 'markdown');

$triton['title'] = "Products";
$triton['main'] = <<<EOD
{$filtered}
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

