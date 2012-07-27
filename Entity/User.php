<?php

/**
 * Class for holding User data
 * @author Mukhamad Ikhsan
 *
 */
class User extends ActiveResource {

	public $site, $format_request;

	public function __construct($data = array()) {
		parent::__construct($data);
		$this->site = require('config.php');
	}
}