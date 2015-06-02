<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "About";
$triton['main'] = <<<EOD
<h1 class='font-shadow'>About this site</h1>
<p>This site is made by Mattias Olsson as part of a project on Blekinge Tekniska Högskola in the JavaScript coarse.</p>
<p>The goal of this site was for me to learn Javascript and some HTML5 technologies such as to handle video. Another goal were to make a video player plugin. You can find more details on that <a href='plugin.php'>here</a>.</p>
<p>In order to actually upload things on this site, you need to have <strong><a href='https://www.ffmpeg.org/'>ffmpeg</a></strong> installed on the server. This is neccessary to be able to convert the videos to different formats supported by the browsers.</p>
<p>Currently this site allows video clips of mime type video/quicktime and video/mp4 (iPhone videos and other Mac-generated), and that is the only mime I have tested. It will probably work with more formats as the videos are converted straight to mp4.</p>
<p>See my <a href='https://github.com/maof14/'>Github page</a> for more information on this site and its plugin features.</p>
<p>This page uses a boilerplate template called Triton, originally a template created by Mikael Roos at BTH. See more on <a href='https://github.com/mosbth'>Github</a>.</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

