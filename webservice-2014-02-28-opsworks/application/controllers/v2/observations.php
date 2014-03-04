<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Manages game observations
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Observations extends REST_Controller {
	
	/**
	 * Adds a new observation to the attempt
	 */
	public function index_post($playthruKey) {
		
		// get the data variable
		$data = $this->post("data");
		
		// make sure we got a data variable
		if(!$data) {
			$this->load->view("missing_data", array("data" => array("data")));
			return;
		}
		
		// get a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
		
		// update the observation
		$success = $playthruManager->updateObservation($data, $playthruKey);
		
		// send a response
		$this->response(array("success" => $success));
	}
}