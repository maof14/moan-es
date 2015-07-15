<?php 

/**
 *
 * Triton page controller to be accessed from the web root. 
 * Used for viewing a page. Business logic in respective classes. 
 * Requires inclusion of the config.php file, before all other actions. 
 */ 

include(__DIR__ . '/config.php');

$fileContents = CFile::getFileContents('products.md');
$filtered = CTextFilter::doFilter($fileContents, 'markdown');

$triton['title'] = "Our products";
$triton['main'] = <<<EOD
<article class='justify'>
{$filtered}
</article>
EOD;

/**
 *
 * Finally, hand over the page to the rendering phase of Triton. 
 *
 */

include(TRITON_THEME_PATH);

