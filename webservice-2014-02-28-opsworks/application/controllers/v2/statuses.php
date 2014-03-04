<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/11/2013
 * Description: Public interface for status requests
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Statuses extends REST_Controller {
	
	/**
	 * Gets the status of the server, if we got here, it must be ok!
	 */
	public function server_get() {
		
		// send a response
		$this->response(array("status" => "ok"));
	}
}