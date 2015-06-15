<?php 

/** 
 *
 * Theme related functions.
 *
 */

/**
 *
 * Get title for the webpage by concatenating page specific title with site-wide title.
 * @param string $title for specific page visited.
 * @return string/null wether the favicon is defined or not. 
 *
 */

function get_title($title) {
	global $triton;
	return $title . (isset($triton['title_append']) ? $triton['title_append'] : null);
}

/**
 *
 * Function to return the base of the site. For use in HTML-tag <base>. 
 * @return string base.
 *
 */

function getBase() {
	if(strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
		return 'http://localhost:8888/moanenterprisesolutions/Triton/public_html/';
	} else {
		return 'http://www.moanenterprise.com/';
	}
}