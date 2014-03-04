<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Manages events
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @author Steve Burkett - steve@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Events extends REST_Controller {
	
	/**
	 * Triggers an evert
	 */
	public function index_post($playthruKey) {
		
		// get the event name
		$name = $this->post("name");
		
		// make sure we have an event name
		if(!$name) {
			$this->load->view("missing_data", array("data" => array("name")));
			return;
		}
		
		// load a factory
		$this->load->library("ayah_factory");
		
		// get a playthru manager
		$playthruManager = $this->ayah_factory->get_backend();
		
		// process the command
		$success = $playthruManager->processCommand("gameevent", $playthruKey, array("event" => $name));
		
		// track the event (eventually make these 2 calls into 1)
		$success = $success && $this->track($playthruKey, $name);
		
		// make sure the return code is true/false (eventually we should expect true/false)
		if($success !== false) {
			$success = true;
		}
		
		// send a response
		$this->response(array("success" => $success));
	}
	
	/**
 	 * Track an event.
 	 *
	 * @param $playthruKey Uniquely identifies each PlayThru product session with an end user.
	 * @param $eventName Unique identifier for an event that includes the category and name of the event.
 	 * @return void
 	 */
	private function track($playthruKey, $eventName) {
		
		// set default response
		$response = false;
		
		// double check that the ayah factory is defined
		if(!is_object($this->ayah_factory)) {
			$this->load->library("ayah_factory");
		}
		
		// get a tracking manager
		$trackingManager = $this->ayah_factory->get_tracking_manager();
			
		// get the category and event from the event_id
		list($category, $event) = $this->__parse_event_id($eventName);
		
		// check if the event name follows convention
		if($category && $event) {
			
			// initial the data to have the attempt_key
			$data = array('attempt_key' =>  $attempt_key);
			
			// get the valid event data names
			$valid_event_data_names = $this->tracking_manager->get_valid_event_data_names();
			
			// add more data (if there is any)
			$data = $this->__get_event_data($valid_event_data_names, $data);
			
			// use the tracking manager to do the tracking
			$response = $this->tracking_manager->track($category, $event, $data);
		}

		// return success or failure
		return $response;
	}
	
	/*
 	* __get_event_data()
 	*
 	* Extracts data from $_REQUEST.
 	*
	* @access private
	* @param array data Array of any current data to which we can add more data.
 	* @return array()
 	*/
	private function __get_event_data($valid_event_data_names, $data=array())
	{
		// Look for each valid event data name.
		foreach ($valid_event_data_names as $name)
		{
			if (isset($_REQUEST[$name])) $data[$name] = $_REQUEST[$name];
		}

		// Return the data.
		return $data;
	}
	
	/*
 	* __parse_event_id()
 	*
 	* Parse the event_id to get the category and event.
 	*
	* @access private
	* @param string event_id Unique identifier for an event that includes the category and name of the event.
 	* @return array Contains the category and the name of the event.
 	*/
	private function __parse_event_id($event_id)
	{
		// All events must match this format: 'category_eventname'
		// examples: 'playthru_ready', 'vpaid_skip'
		if (preg_match("/^([^_]+)_(.+)$/i", $event_id, $matches))
		{
			$category = $matches[1];
			$event = $matches[2];
			return array($category, $event);
		}

		// There was a problem.
		return FALSE;
	}
}