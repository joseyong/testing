<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/11/2013
 * Description: Public interface for playthru requests
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Playthrus extends REST_Controller {
	
	/**
	 * Creates an instance of playthru
	 */
	public function index_post() {
		
		// get a publisher key
		$publisherKey = $this->post("publisher_key");
		
		// get a playthru type
		$type = $this->post("type");
		
		// set some defaults for error checking
		$errorArray = array();
		
		// make sure we get a publisher key
		if(!$publisherKey) {
			$errorArray[] = "publisher_key";
		}
		
		// make sure we get a playthru type
		if(!$type) {
			$errorArray[] = "type";
		}
		
		// if we're missing data, return an error message
		if(count($errorArray) > 0) {
			$this->load->view("missing_data", array("data" => $errorArray));
			return;
		}
		
		// get a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
		
		// initialize a playthru
		$playthruKey = $playthruManager->initializePlaythru($publisherKey);
		
		// tell the playthru about the client parameters
		$params = $this->post();
		unset($params["publisher_key"]);
		unset($params["type"]);
		
		// add the playthru key to the queue
		$this->load->model("playthru_queue");
		$this->playthru_queue->addToQueue($playthruKey, $publisherKey);
		
		// send a response
		$this->response(array("playthru_key" => $playthruKey, "playthru" => $playthruManager->getBlock("playthru", $playthruKey, $params)));
	}
}