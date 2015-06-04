<?php 

define('PATH', __DIR__.'/../../files/');

class CFile {
	public static function getFileContents($filename) {
		if(is_file(PATH.$filename)) {
			return file_get_contents(PATH.$filename);	
		} else {
			return false;
		}
	}
}