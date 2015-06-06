<?php 

class CExample extends CModel {

	// dyn properties. orkar inte skriva ut de . 

	public function __construct($database) {
		$this->setTargetTable('examples');
		parent::__construct($database);
	}

	/**
	 *
	 * Function to create a slug, based on the member title, or param. 
	 * @param $title - the title to create slug for.
	 */

    public function slugify($str) { 
        $str = mb_strtolower(trim($str)); 
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str); 
        $str = preg_replace('/[^a-z0-9-]/', '-', $str); 
        $str = trim(preg_replace('/-+/', '-', $str), '-'); 
        return $str;
    }
}