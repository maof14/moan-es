<?php

class CFunctions {
	/**
	 *
	 * Static class to hold some common functions. 
	 *
	 */

	/**
	 * Return a string showing the age of the post. 
	 * @param string date - the date to create "days ago" etc from. 
	 * @return string representing age of the post.
	 */ 
	public static function getAgeString($date) {
		$now = time();
		$oldTime = strtotime($date);
		$datediff = $now - $oldTime;
		$days = floor($datediff/(60*60*24));
		switch (true) {
			case ($days == 0): return 'today'; break;
			case ($days == 1): return 'yesterday'; break;
			case ($days <= 7): return $days . ' days ago'; break;
			default:
				$weeks = floor($days/7);
				switch (true) {
					case ($weeks == 1):
						return 'a week ago';
						break;
					case ($weeks <= 5): 
						return $weeks . ' weeks ago';
						break;
					case ($weeks <= 52): 
						$months = floor($days/30);
						return $months . ' months ago';
						break;
					default:
						$years = floor($days/365);
						if($years == 1) {
							return $years . ' year ago';
						} else {
							return $years . ' years ago';
						}
						break;
				}
		}
	}
}