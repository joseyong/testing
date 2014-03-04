<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/15/2013
 * Description: Public interface for publisher requests
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Publishers extends REST_Controller {
	
	/**
	 * Returns a publisher object
	 */
	public function index_get($publisher_key) {
		
		// send a response
		$this->load->view("unavailable");
		
		/*
		// get a factory object
		$this->load->library("Ayah_factory", "", "ayah_factory");
		
		// get an account object
		$accountObject = $this->ayah_factory->get_domain_object("account", $publisher_key);
		
		$this->response(array("publisher_data" => $accountObject->get()));*/
	}
	
	/**
	 * Performs a check of the publisher's associated data
	 */
	public function healthcheck_get($publisher_key) {
			
		// get the mode or set it to the default
		$mode = $this->get("mode");
		if(!$mode) {
			$mode = "simple";
		}
		
		// get a factory 
		$this->load->library("ayah_factory");
		
		// get a health check unit test
		$systemStatus = $this->ayah_factory->get_backend_health_check();
		
		// get the status
		$status = $systemStatus->getStatus($publisher_key, $mode);
		
		// send a response
		$this->response(array("status" => $status, "publisher_key" => $publisher_key, "mode" => $mode));
	}
}