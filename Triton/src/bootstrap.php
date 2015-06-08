<?php 

/** 
 *
 * bootstrap.php
 * Bootstrapping functions, essential and needed for Triron to work together with some common helpers. 
 *
 */ 

/** 
 *
 *
 * Default exception handler
 * @param exception - the exception thrown. 
 */

function myExceptionHandler($exception) {
	echo "Triton: Uncaught exeption; <p>" . $exception->getMessage() . "<p><pre>" . $exception->getTraceAsString(), "</pre>"; // punkt här emellan???
}
set_exception_handler('myExceptionHandler');

/**
 *
 *
 * Autoloader for classes, eliminating the need to manually include them.
 * @param string $class - the class requested.
 */

function myAutoLoader($class) {
	$path = TRITON_INSTALL_PATH . "/src/{$class}/{$class}.php";
	if(is_file($path)) {
		include($path);
	} else {
		throw new Exception("Classfile '{$class} does not exist.");
	}
}

/**
 *
 * Class autoloader event.
 * @param function to call. 
 *
 */

spl_autoload_register('myAutoLoader');

/** 
 *
 *
 * Variable Dump function. Get debug information printed in a nice way. 
 * @param $array, the variable to print.
 */ 

function dump($array) {
	return "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}