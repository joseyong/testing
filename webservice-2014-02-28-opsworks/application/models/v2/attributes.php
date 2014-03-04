<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playthru_Queue extends CI_Model {
	
	/*public function __construct() {
		// Call parent construct to run all needed CI code.
		parent::__construct();
	}*/
	
	
	/**
	 * Adds the playthru key to the queue
	 * 
	 * @param $playthruKey a unique identifier for an instance of playthru
	 * @param $publisherKey a unique identifier for a publisher
	 */
	public function addToQueue($playthruKey, $publisherKey) {
		
		$write_to_db = $this->config->item("write_to_db");
		
		if($write_to_db) {
			$hostname = $this->config->item("write_hostname");
			$username = $this->config->item("write_username");
			$password = $this->config->item("write_password");
			$database = $this->config->item("write_database");
			
			$writeDB = @mysql_connect($hostname, $username, $password);
			if($writeDB && @mysql_select_db($database, $writeDB)) {
				$query = "INSERT INTO AttemptQueue (attempt_key, publisher_key) values ('" . mysql_escape_string($playthruKey) . "', '" . mysql_escape_string($publisherKey) . "')";
				$result = mysql_query($query);
				
				if(!$result) {
					error_log(__CLASS__ . "::" . __FUNCTION__ . "-insert into AttemptQueue failed, $query");
					$date = new DateTime();
					$now = $date->format('Y-m-d H:i:s');
					$this->load->helper('file');
					write_file('/tmp/AQ_insert_failed.txt', "date=$now, attemptID=$playthruKey\n", 'a+');
				}
			} else {
				error_log(__CLASS__ . "::" . __FUNCTION__ . "-writeDB could not initialize");
				$date = new DateTime();
				$now = $date->format('Y-m-d H:i:s');
				$this->load->helper('file');
				write_file('/tmp/Database_not_found.txt', "date=$now, attemptID=$playthruKey, hostname=$hostname\n", 'a+');
			}
			
			@mysql_close($writeDB);
		} else {
			$date = new DateTime();
			$now = $date->format('Y-m-d H:i:s');
			$this->load->helper('file');
			write_file('/tmp/Database_not_found.txt', "date=$now, attemptID=$playthruKey, write_to_db = false\n", 'a+');
		}
	}

	/**
	 * Marks a playthru as complete
	 * 
	 * @param $playthruKey a unique identifier for a playthru
	 */
	public function setPlaythruComplete($playthruKey) {
		
		$write_to_db = $this->config->item("write_to_db");
		
		if($write_to_db) {
			$hostname = $this->config->item("write_hostname");
			$username = $this->config->item("write_username");
			$password = $this->config->item("write_password");
			$database = $this->config->item("write_database");
			
			$writeDB = @mysql_connect($hostname, $username, $password);
			if($writeDB && @mysql_select_db($database, $writeDB)) {
				$query = "UPDATE AttemptQueue set complete = 1 WHERE attempt_key = '" . mysql_escape_string($playthruKey) . "'";
				$result = mysql_query($query);
			}
			
			@mysql_close($writeDB);
		}
	}
}
