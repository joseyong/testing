<?php
/** 
 * Created: 10/29/2013
 * Description: An example model
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */ 

// the namespace should correspond
namespace ayah\api\models\v_api_example;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends \AYAH_Model {

	// the function name should correspond to the controller function name
	public function test($publisher_key) {
		$message = __CLASS__."::".__FUNCTION__." - "."Hello!";
		return json_encode(array("publisher_key" => $publisher_key, "message" => $message));
	}
}
