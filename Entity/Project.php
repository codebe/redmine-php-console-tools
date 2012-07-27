<?php

/**
 * Class for holding Project data
 * @author Mukhamad Ikhsan
 *
 */
class Project extends ActiveResource {
	
	public $site, $format_request;
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->site = require('config.php');
	}
}