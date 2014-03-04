<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/27/2013
 * Description: Figures out the correct version of the model being requested
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

class Versioned_Model_Mapper extends AYAH_Model {
	
	/**
	 * Gets the correct versioned model name
	 * 
	 * @param $apiVersion the version of the api the model corresponds to
	 * @param $modelName the name of the model to load
	 * @param $mappingData an array with information used to find the mapping
	 * 
	 * @return string the model name
	 */
	public function getModel($apiVersion, $modelName, $mappingData) {
		
		// get the version
		$version = $this->__getVersion($mappingData);
		
		// get the versioned model name
		$versionedModelName = $apiVersion.'/'.$version.'/'.$modelName;
		
		// check if the file exists
		if(file_exists(APPPATH.'models/'.$versionedModelName.EXT)) {
			// if it exists, we've found the model name
			return $versionedModelName;
		}
		
		// try a level up (the default model name)
		$defaultModelName = $apiVersion.'/'.$modelName;
		
		// check if the file exists
		if(file_exists(APPPATH.'models/'.$defaultModelName.EXT)) {
			// return the 'default' model
			return $defaultModelName;
		} else {
			error_log(__CLASS__.'::'.__FUNCTION__.' - '.'could not find model '.$defaultModelName);
		}
		
		return null;
	}
	
	/**
	 * Gets the version based on the mapping data
	 * 
	 * @param $mappingData an array with information used to find the mapping
	 * 
	 * @return string the version
	 */
	private function __getVersion($mappingData) {
		
		// check that the type is specified
		if(isset($mappingData["type"])) {
			
			// check that the key is specified
			if(isset($mappingData["key"])) {
				
				// get the function name
				$func = '__'.$mappingData['type'];
				
				// check that the function exists
				if(is_callable(array($this, $func))) {
					
					// call the correct function implementation
					$this->$func($mappingData['key']);
				} else {
					error_log(__CLASS__.'::'.__FUNCTION__.' - '.'function not found '.$func);
				}
			} else {
				error_log(__CLASS__.'::'.__FUNCTION__.' - '.'missing mappingData \'key\'');
			}
		} else {
			error_log(__CLASS__.'::'.__FUNCTION__.' - '.'missing mappingData \'type\'');
		}
		
		// return a default
		return "beta";
	}
	
	private function __publisher($key) {
		return "beta";
	}
	
	private function __attempt($key) {
		return "beta";
	}
}
