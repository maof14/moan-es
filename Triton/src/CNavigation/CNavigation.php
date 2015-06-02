<?php 

class CNavigation {
	public static function GenerateMenu($items, $class) {
		$html = "<div class='{$class}' id='navbar'>\n";
		$html .= "<ul class='nav navbar-nav'>\n";
		foreach($items as $key => $item) {
			$active = basename($_SERVER['PHP_SELF'], '.php') == $key ? 'active' : null;
			$html .= "<li class='{$active}'><a href='{$item['url']}'>{$item['text']}</a></li>\n";
		}
		$html .= "</ul>\n";
		$html .= "</div>\n";
		return $html;
	}
}