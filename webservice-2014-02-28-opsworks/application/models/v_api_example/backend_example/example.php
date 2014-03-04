<?php
/** 
 * Created: 10/29/2013
 * Description: An example model
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */ 

// the namespace should correspond
namespace ayah\api\models\v_api_example\backend_example;;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once __DIR__."/../example.php";

class Example extends \ayah\api\models\v_api_example {
	
	// overload the parent function
	public function test($publisher_key) {
		$message = __CLASS__."::".__FUNCTION__." - "."Hello!";
		return array("publisher_key" => $publisher_key, "message" => $message);
	}
}
