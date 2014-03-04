<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Manages playthru components
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Component extends REST_Controller {
	
	/**
	 * Gets a component of playthru
	 */
	public function index_get($playthruKey) {
		
		// get a block name
		$blockName = $this->get("name");
		
		// get the optional params
		$params = $this->get("params");
		
		// make sure we have a block (component) name
		if(!$blockName) {
			$this->load->view("missing_data", array("data" => array("name")));
			return;
		}
		
		// load a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
		
		// return the component data
		$this->response(array($blockName => $playthruManager->getBlock($blockName, $playthruKey, $params)));
	}
}