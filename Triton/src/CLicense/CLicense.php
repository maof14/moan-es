<?php 

class CLicense extends CModel {

	/**
	 *
	 * Class to handle license related things. 
	 *
	 */

	/**
	 *
	 * Constructor. Important for CModel that target table is set. 
	 * @param array $database. The database connection info.
	 * @return void.
	 */
	public function __construct($database) {
		$this->setTargetTable('licenses');
		parent::__construct($database);
	}

	/**
	 *
	 * Function to get the table containing all licenses. 
	 * @return $res - the html from the paginator class. 
	 */
	public function getAll() {

		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
		$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
		$page = isset($_GET['page']) ? (integer) $_GET['page'] : 1;

		// db headers => desired names to display.
		$headers = [
			'id' 			=> 'Id', 
			'companyid' 	=> 'Company id', 
			'companyname' 	=> 'Company name', 
			'licensekey' 	=> 'License key', 
			'validfrom' 	=> 'Valid from', 
			'validto' 		=> 'Valid to'
		];

		$directions = [
			'asc',
			'desc'
		];

		// If there are things in $_GET, and, there are suspicious things in $_GET, then throw Exception.
		if(!empty($_GET)) {
			if(!in_array($orderby, array_keys($headers)) || !in_array($order, array_values($directions))) {
				throw new Exception('What do you think you are doing? Invalid sorting parameters.');
			}
		}

		// First get the number of rows in the license database. Should be in model... 
		$sql = "SELECT COUNT(*) AS c FROM licenses";
		$count = $this->db->executeSelectQueryAndFetch($sql)->c;

		$limit = 10;
		$offset = $page != 1 ? $limit * $page - $limit : 0;
		$max = ceil($count / $limit);

		// Then get the data. 
		$sql = "SELECT * FROM licenses ORDER BY $orderby $order LIMIT $limit OFFSET $offset";
		$licenses = $this->db->executeSelectQueryAndFetchAll($sql);
		$paginator = new CPaginator();

		// get the paginator table, together with the navigation. Todo: Change to bootstrap format. 
		$res = $paginator->getPaginationTable($headers, $licenses, ['table', 'table-striped', 'table-hover']) . $paginator->getPageNavigation($limit, $page, $max, $min=1);
		return $res;
	}

	/**
	 *
	 * Function to generate a License key. 
	 * @return string $res - the license key.
	 */
	private function createLicenseKey() {
		$chars = 'abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
		$charArr = str_split($chars);
		$res = "";
		for($i = 0; $i < 10; $i++) {
			$res .= $charArr[rand(0, count($charArr))];
		}
		return $res;
	}

	/**
	 *
	 * Function to "format" the company name in desired format - All uppercase and no special chars. 
	 * @param string $name - the unformatted company name. 
	 * @return string the formated company name. 
	 */
	private function createCompanyName($name) {
		$res = preg_replace("/[^a-zA-Z0-9]/", "", $name);
		return strtoupper($res);
	}

	/**
	 *
	 * Function to generate the form to create a new license. 
	 * @return string $html - the creation form. 
	 */
	public function getCreateForm() {
		$html = <<<EOD
<form class="form-horizontal hidden" id='form-create-license' method='post'>
<fieldset>

<!-- Form Name -->
<legend>Create new license</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="companyid">Company id</label>
  <div class="controls">
    <input id="companyid" name="companyid" type="text" placeholder="5 digit number" class="input-small" required="">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="companyname">Company name</label>
  <div class="controls">
    <input id="companyname" name="companyname" type="text" placeholder="I.e. MOANENTERPRISESOLUTIONS" class="input-xlarge" required="">
  </div>
</div>

<!-- Text input -->
<div class="control-group">
  <label class="control-label" for="validfrom">Valid from</label>
  <div class="controls">
    <input id="validfrom" name="validfrom" type="text" placeholder="YYYY-MM-DD" class="input-small" required="">
  </div>
</div>

<!-- Text input -->
<div class="control-group">
  <label class="control-label" for="validto">Valid to</label>
  <div class="controls">
    <input id="validto" name="validto" type="text" placeholder="YYYY-MM-DD" class="input-small" required="">
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit"></label>
  <div class="controls">
    <input type='submit' id="submit" name="submit" class="btn btn-primary" value='Create license' />
  </div>
</div>

</fieldset>
</form>
EOD;
		return $html;
	}

	public function getSearchForm() {
		$html = <<<EOD
<form class="form-horizontal hidden" id='search-form'>
<fieldset>

<!-- Form Name -->
<legend>Search licenses</legend>

<!-- Multiple Radios (inline) -->
<div class="control-group">
  <label class="control-label" for="search-on">Search on</label>
  <div class="controls">
    <label class="radio-inline" for="search-on-0">
      <input type="radio" name="search-on" id="search-on-0" value="companyname" checked="checked">
      Company name
    </label>
    <label class="radio-inline" for="search-on-1">
      <input type="radio" name="search-on" id="search-on-1" value="licensekey">
      License key
    </label>
    <label class="radio-inline" for="search-on-2">
      <input type="radio" name="search-on" id="search-on-2" value="validfrom">
      Valid from-date
    </label>
    <label class="radio-inline" for="search-on-3">
      <input type="radio" name="search-on" id="search-on-3" value="validto">
      Valid to-date
    </label>
  </div>
</div>

<!-- Search input-->
<div class="control-group">
  <label class="control-label" for="search-input">Search input</label>
  <div class="controls">
    <input id="search-input" name="search-input" type="search" placeholder="Search string" class="input-xlarge search-query">
    <p class="help-block">Begin typing and see what you find</p>
  </div>
</div>

</fieldset>
</form>

EOD;
	return $html;
	}

	/**
	 *
	 * Function to insert a new license to the database.
	 * @param array data - the data to be inserted to the database. 
	 * @return boolean on success. 
	 */
	public function createNew($data = array()) {
		$sensitive = [
			'licensekey' => $this->createLicenseKey(),
			'companyname' => $this->createCompanyName($data['companyname'])
		];
		$data = array_merge($data, $sensitive);
		return $this->create($data);
	}

}