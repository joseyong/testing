<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Created: 10/1/2013
 * Description: CI controller responsible for processing all tracking calls.
 * 
 * @author Steve Burkett - steve@areyouahuman.com
 * @package AYAH API
 */
class Track extends CI_Controller
{
	/**
	* Debug mode.
	* 
	* @access private
	* @var boolean
	*/
	private $__debug = FALSE;

	/**
	* Debug messages.
	* 
	* @access private
	* @var array
	*/
	private $__debug_messages = array();

	/*
 	* __construct()
 	*
 	* The constructor.
 	*
	* @access public
 	* @return void
 	*/
	public function __construct()
	{
		// Call parent construct to run all needed CI code.
		parent::__construct();
		
		// Set debug mode.
		$this->__debug = (isset($_GET['debug']) and $_GET['debug'])? TRUE : FALSE;
	}
	
	/*
 	* event()
 	*
 	* Track an event.
 	*
	* @access public
	* @param string attempt_key Uniquely identifies each PlayThru product session with an end user.
	* @param string event_id Unique identifier for an event that includes the category and name of the event.
 	* @return void
 	*/
	public function event($attempt_key, $event_id)
	{
		$this->__add_debug("attempt_key='$attempt_key'");
		$this->__add_debug("event_id='$event_id'");
		
		// Get the tracking manager.
		if ($this->__get_tracking_manager())
		{
			// Get the category and event from the event_id.
			list($category, $event) = $this->__parse_event_id($event_id);
			if ($category and $event)
			{
				$this->__add_debug("category='$category'");
				$this->__add_debug("event='$event'");

				// Initial the data to have the attempt_key.
				$data = array('attempt_key' =>  $attempt_key);

				// Get the valid event data names.
				$valid_event_data_names = $this->tracking_manager->get_valid_event_data_names();
				$this->__add_debug("valid_event_data_names='".implode(",", $valid_event_data_names)."'");

				// Add more data (if there is any).
				$data = $this->__get_event_data($valid_event_data_names, $data);
				foreach ($data as $key => $value)
				{
					$this->__add_debug("$key='$value'");
				}

				// Use the tracking manager to do the tracking.
				$response = $this->tracking_manager->track($category, $event, $data);
				if ($response)
				{
					$this->__show_debug("Success! response='$response'");
				}
				else
				{
					$this->__show_debug("Failed!");
				}
			}
			else
			{
				$this->__show_debug("Unable to get the category and event from event_id='$event_id'");
			}
		}

		// No need to return anything.
		return NULL;
	}
	
	/*
 	* __get_tracking_manager()
 	*
 	* Responsible for getting the Tracking Manager.
 	*
	* @access private
 	* @return object An ayah\TrackingManager object.
 	*/
	private function __get_tracking_manager()
	{
		// Load the factory to get AYAH objects.
		$this->load->library("Ayah_factory", null, "ayah_factory");
		if (is_object($this->ayah_factory))
		{
			// Use the ayah factory to get the tracking manager.
			$this->tracking_manager = $this->ayah_factory->get_tracking_manager();
			if (is_object($this->tracking_manager))
			{
				return TRUE;
			}
			else
			{
				$this->__add_debug("Unable to get the tracking manager.");
			}
		}
		else
		{
			$this->__add_debug("Unable to get the ayah_factory.");
		}
		
		// There was a problem.
		return FALSE;
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

	/*
 	* __add_debug()
 	*
 	* Add a debug message.
 	*
	* @access private
 	* @return void
 	*/
	private function __add_debug($message)
	{
		$this->__debug_messages[] = $message;
	}

	/*
 	* __show_debug()
 	*
 	* Show the debug messages if debug mode is on.
 	*
	* @access private
 	* @return void
 	*/
	private function __show_debug($output)
	{
		// Only output if debug mode is TRUE.
		if ($this->__debug)
		{
			// Add the passed output to the array of debug messages.
			$this->__add_debug($output);

			// Load the view to display the debug messages.
			$this->load->view('track/debug', array('output' => $this->__debug_messages));
		}
	}
}
