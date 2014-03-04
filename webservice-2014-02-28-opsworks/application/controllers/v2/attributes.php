<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Manages playthru attributes
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Attributes extends REST_Controller {
	
	/**
	 * Updates an existing or creates a new attribute
	 */
	public function index_put($playthruKey) {
		
		// get the put variables
		$attributes = $this->put();
		
		// make sure we have at least one attribute
		if(!is_array($attributes) || count($attributes) <= 0) {
			$this->load->view("missing_data", array("data" => array("<attribute_name>")));
			return;
		}
		
		// load a factory
		$this->load->library("ayah_factory");
		
		// get an attempt object (attempt=playthru)
		$attemptObject = $this->ayah_factory->get_domain_object("attempt", $playthruKey);
		
		// make sure the attempt object exists
		if(!$attemptObject) {
			$this->load->view("error", array("message" => "invalid playthru_key: $playthruKey"));
			return;
		}
		
		// set the attributes
		$attemptObject->set($attributes);

		// send a response
		$this->response($attributes);
	}
}