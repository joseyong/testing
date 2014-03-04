<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Handles game requests
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Game extends REST_Controller {
	
	/**
	 * Gets a game
	 */
	public function index_get($playthruKey) {
		
		// load a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
				
		//$thiss->trackPageView();
		
		// send a response
		$this->response(array("game" => $playthruManager->getBlock("game", $playthruKey, $this->get())));
	}
}