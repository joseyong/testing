<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/29/2013
 * Description: An example controller
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

class Example extends AYAH_Controller {

	public function __construct() {
		parent::__construct();
		
		// get a model to do the mapping
		$this->load->model("versioned_model_mapper");
	}
	
	// We need either a publisher key or an attempt key, along with whatever other data you require
	public function test($publisher_key) {
		// type = [publisher || attempt]
		$mappingData = array("key" => $publisher_key, "type" => "publisher");
		// API version, Controller name, Mapping data
		$model = $this->versioned_model_mapper->getModel("v_api_example", "example", $mappingData);
		// rename it to a variable
		$this->load->model($model, "example_model");
		// pass the data along to the corresponding model function that does the work
		print $this->example_model->test($publisher_key);
	}
}