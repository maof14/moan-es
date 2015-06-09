<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$startpage = new CStartpage($triton['database']);

$triton['title'] = "Start";
$triton['main'] = <<<EOD

<article class='justify'>
<h1>Welcome to MOAN Enterprises Solutions</h1>
<p class='lead'>Need to save some time doing SAP work?</p>

	<div class='code-example-container'> <!-- representerar container med område med kod.  -->
		<div class='window-outer-frame'> <!-- representerar svart ytterkant runt fönstret -->
		<div class='title-row'><span class='window-title'><img src='img/notepad.png' alt='notepad icon' class='window-icon'/><span class='title-shadow'>Untitled - Notepad</span></span><div class='window-buttons right'><ul><li class='window-minimize'>_</li><li class='window-maximize'>&#9744;</li><li class='window-close'>X</li></ul></div></div> <!-- - rad uppe -->
			<div class='inner-frame'> <!-- representerar området där det står untitled - notepad. Vit ytterkand -->
			<div class='window-menu-bar'><ul><li><span class='underline'>F</span>ile</li><li><span class='underline'>E</span>dit</li><li>F<span class='underline'>o</span>rmat</li><li><span class='underline'>V</span>iew</li><li><span class='underline'>H</span>elp</li></ul></div>
				<div class='window-program-content'> <!-- representerar programmets specifika innehåll inkl "file, edit" osv  -->
					<div class='window-code-area'> <!-- representerar själva området med kod -->
						<code class='vba-code' id='code-example'>

						</code>
					</div>
				</div>
			</div>
		</div>
	</div>
<a href='#' class='skip-code-write'>Faster, please!</a>
</article>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

