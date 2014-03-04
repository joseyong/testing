<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Manages attempt results
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Results extends REST_Controller {
	
	/**
	 * Adds a new observation to the attempt
	 */
	public function index_get($playthruKey) {
		
		// ignore this for now since we always return the same thing
		$tests = $this->get("tests");
		
		// get a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
		
		// get the results
		$scoreReport = $playthruManager->getScoreReport($playthruKey);
		
		// format the results based on the get parameters
		$results = array();
		if($scoreReport) {
			$results["status_code"] = (int)$scoreReport["human"];
		} else if($scoreReport === false) {
			$results["status_code"] = 0;
			$results["error"] = "no results available for playthru_key: $playthruKey";
		}
		
		// send a response
		$this->response($results);
	}
}