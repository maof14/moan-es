<?php 

class CPaginator {

	/**
	 *
	 * Class to generate the pagination table of data. 
	 * @todo - add functionality to generate pagination to the wells instead of only a table. 
	 */

	private $currentPage;

	public function __construct($rowCount = null) {
		$this->currentPage = $this->getPage();
	}

	/**
	 *
	 * Function to create pagination of SQL result. 
	 * @param string array $headers - accoc array of db header names and the desired names as values. 
	 * @param stdClass array $sqlResult - the array of rows form the database.
	 * @param string array $class - the classes to add to the table element. 
	 * @return string $html - html table of data. 
	 */
	public function getPaginationTable($headers = array(), $sqlResult = array(), $class = array()) {
		$headerCount = count($headers);
		$html = "<table class='";
		foreach($class as $c) {
			$html .= "$c ";
		}
		$html .= "'>\n";
		$html .= "<thead>";
		$html .= "<tr>";
		foreach($headers as $key => $value) {
			$headerKeys[] = $key;
			$html .= "<th>{$value} " . $this->orderby($key) . "</th>\n";
		}
		$html .= "</tr>\n";
		$html .= "</thead>\n";
		$html .= "<tbody>\n";
		foreach($sqlResult as $dbRow) {
			$html .= "<tr>\n";
			foreach($headerKeys as $header) {
				$html .= "<td>{$dbRow->$header}</td>";
			}
			$html .= "</tr>\n";
		}
		$html .= "</tbody>\n";
		$html .= "</table>\n";
		return $html;
	}

	/**
	 *
	 * Function to get the query string. 
	 * @param array $options - the options for the query string. 
	 * @param string $prepend - the character to prepend the string. 
	 * @return string - the query string. 
	 */
	private function getQueryString($options=array(), $prepend='?') {
		// parse query string into array
		$query = array();
		
		parse_str($_SERVER['QUERY_STRING'], $query);

		// Modify the existing query string with new options
		$query = array_merge($query, $options);

		// Return the modified querystring
		return $prepend . htmlentities(http_build_query($query));
	}

	/**
	 *
	 * Function to get the links in the pagination. 
	 * @return html code with the order links. 
	 */
	private function orderby($column) {
		$nav  = "<a href='" . $this->currentPage . $this->getQueryString(array('orderby'=>$column, 'order'=>'asc')) . "'>&darr;</a>";
		$nav .= "<a href='" . $this->currentPage . $this->getQueryString(array('orderby'=>$column, 'order'=>'desc')) . "'>&uarr;</a>";
		return "<span class='orderby'>" . $nav . "</span>";
	}

	/**
	 *
	 * Function to extract the current page from the REQUEST_URI, when using ReWritemods. 
	 * @return string $page, the current page. 
	 */
	private function getPage() {
		$url = $_SERVER['REQUEST_URI'];
		$parts = explode("/", $url);
		$page = $parts[count($parts) - 1];
		$page = strpos($page, "?") ? substr($page, 0, strpos($page, "?")) : $page;
		return $page;
	}

	/**
	 * Create navigation among pages.
	 *
	 * @param integer $hits per page.
	 * @param integer $page current page.
	 * @param integer $max number of pages. 
	 * @param integer $min is the first page number, usually 0 or 1. 
	 * @return string as a link to this page.
	 */
	public function getPageNavigation($hits, $page, $max, $min=1) {
		$nav = "<nav>\n<ul class='pagination pagination-sm'>\n";
		$nav .= ($page != $min) ? "<li><a href='" . $this->currentPage . $this->getQueryString(array('page' => $min)) . "'>&laquo;&laquo;</a></li>" : '<li class="disabled"><a href="' . $this->currentPage . '">&laquo;&laquo;</a></li>';
		$nav .= ($page > $min) ? "<li><a href='" . $this->currentPage . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&laquo;</a></li> " : '<li class="disabled"><a href="' . $this->currentPage . '">&laquo;</a></li>';
		for($i=$min; $i<=$max; $i++) {
			if($page == $i) {
				$nav .= '<li class="active"><a href="' . $this->currentPage . '">' . $i . '</a></li>';
			}
			else {
				$nav .= "<li><a href='" . $this->currentPage . $this->getQueryString(array('page' => $i)) . "'>$i</a></li>";
			}
		}
		$nav .= ($page < $max) ? "<li><a href='" . $this->currentPage . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&raquo;</a></li>" : '<li class="disabled"><a href="' . $this->currentPage . '">&raquo;</a></li>';
		$nav .= ($page != $max) ? "<li><a href='" . $this->currentPage . $this->getQueryString(array('page' => $max)) . "'>&raquo;&raquo;</a></li>" : '<li class="disabled"><a href="' . $this->currentPage . '">&raquo;&raquo;</a></li>';
		$nav .= "</ul>\n</nav>";
		return $nav;
	}

}