<?php

/**
 * Class for holding Issue data 
 * @author Mukhamad Ikhsan
 *
 */
class Issue extends ActiveResource {
	
	public $site, $format_request;
	
	
	public $id, $project, $description, $priority, $tracker;
	public $status, $author, $subject, $start_date, $due_date;
	public $done_ratio, $estimated_hours;
	
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->site = require('config.php');
	}
	
	public function query($query_string, $options = array ()) {
		$options_string = '';
		if (count($options) > 0) {
			$options_string = '?' . http_build_query ($options);
		}
		$url = $this->site . $this->element_name_plural . '.xml?' . $query_string;				
		return $this->_send_and_receive ($url . $options_string, 'GET');
	}
	
	public function assignVariables() {
		$this->id = $this->_data['id'];
		$this->project = $this->_data['project']->attributes();
		$this->tracker = $this->_data['tracker']->attributes();
		$this->status = $this->_data['status']->attributes();
		$this->priority = $this->_data['priority']->attributes();
		$this->author = $this->_data['author']->attributes();
		$this->subject = $this->_data['subject'];
		$this->start_date = $this->_data['start_date'];		
		$this->due_date = $this->_data['due_date'];
		$this->done_ratio = $this->_data['done_ratio'];
		$this->estimated_hours = $this->_data['estimated_hours'];
		$this->description = $this->_data['description'];		
	}
}