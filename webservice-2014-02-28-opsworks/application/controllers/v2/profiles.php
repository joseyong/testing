<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Handles profile requests
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Profiles extends REST_Controller {
	
	/**
	 * Puts a cookie on the clients browser if it doesn't already exist
	 */
	public function index_post() {
		
		// send a response
		$this->load->view("unavailable");
	}
}