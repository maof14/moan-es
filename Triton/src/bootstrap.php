<?php 

/* 
Bootstrapping functions, essential and needed for Triron to work together with some common helpers

*/ 

/* Default exception handler
*/

function myExeptionHandler($exeption) {
	echo "Triton: Uncaught exeption; <p>" . $exeption->getMessage() . "<p><pre>" . $exeption->getTraceAsString(), "</pre>"; // punkt här emellan???
}
set_exception_handler('myExeptionHandler');

/*

Autoloader for classes
*/

function myAutoLoader($class) {
	$path = TRITON_INSTALL_PATH . "/src/{$class}/{$class}.php";
	if(is_file($path)) {
		include($path);
	} else {
		throw new Exception("Classfile '{$class} does not exist.");
	}
}
spl_autoload_register('myAutoLoader');

/* dump function.. 
*/ 
function dump($array) {
	return "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}