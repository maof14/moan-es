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
<div class='jumbotron'>
<h1>Excel in SAP, the easy way.</h1>
<p>Welcome to MOAN Enterprise. Using our Excel Add-in tools, you will get your everyday SAP tasks done in no-time.</p>
<p><a class="btn btn-primary btn-lg" href="products.php" role="button">Find out more</a>
</div>
<!-- <p class='lead'>Need to save some time doing SAP and Excel work?</p> -->
	<div class='row space-below'>
		<div class='col-md-6'>
			<h2>Fasten your seatbelts!</h2>
			<p>We at MOAN Enterprise strive to help our customers achieve efficiency in everyday work by speeding up their SAP and Excel tasks through simple, powerful and reliable scripts.</p>
			<p>Find out more by navigating to our <a href='products.php'>products</a> page, or find out just how easily a new script is created by checking out the <a href='examples.php'>examples</a>.</p>
		</div>
		<div class='col-md-6'>
			<div class='code-example-container'>
				<div class='window-outer-frame'>
					<div class='title-row'><span class='window-title'><img src='img/notepad.png' alt='notepad icon' class='window-icon'/><span class='title-shadow'>Untitled - Notepad</span></span><div class='window-buttons right'><ul><li class='window-minimize'>_</li><li class='window-maximize'>&#9744;</li><li class='window-close'>X</li></ul></div></div>
					<div class='inner-frame'>
					<div class='window-menu-bar'><ul><li><span class='underline'>F</span>ile</li><li><span class='underline'>E</span>dit</li><li>F<span class='underline'>o</span>rmat</li><li><span class='underline'>V</span>iew</li><li><span class='underline'>H</span>elp</li></ul></div>
						<div class='window-program-content'>
							<div class='window-code-area'>
								<code class='vba-code' id='code-example'>

								</code>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- <p class='text-center'><a href='#' class='skip-code-write'>Faster, please!</a></p> -->
		</div>
	</div>
</article>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

