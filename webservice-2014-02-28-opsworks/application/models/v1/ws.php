<?php
/** 
 * Created: 10/25/2013
 * Description: Handles the logic of the ws controller
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */ 

namespace ayah\api\models\v1;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WS extends \AYAH_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library("ayah_versions/beta/ami.php", "", "ami");
	}
	
	public function setruntimeoptions($publisher_key, $game_id, $view_mode) {
		
		if($publisher_key === '') {
			return;
		}
		
		// Get playthru manager
		$playthruManager = $this->ami->get_backend();
		
		// get client parameters
		$params = array();
		
		if (array_key_exists("config", $_POST)) {
			$params = $_POST["config"];
		}
		
		// initialize a playthru and generate a session secret
		$attempt_key = $playthruManager->initializePlaythru($publisher_key, $params);
		
		if(!$attempt_key) {
			return;
		}
		
		$setRuntimeOptionsApiInfo = $playthruManager->processCommand("getsetruntimeoptionsapiinfo", $attempt_key);
		
		$data = array(
			"session_secret" => $attempt_key,
			"status_code" => AYAH_SUCCESS,
			"server_name" => $this->config->item('base_hostname'), 
			"max_width" => $setRuntimeOptionsApiInfo["max_width"],
			"max_height" => $setRuntimeOptionsApiInfo["max_height"]
		);
		
		return $this->outputJSON($data);
	}

	public function script($publisher_key='', $attempt_key = '', $game_id=0, $view_mode='') {
		// get a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		// if no session secret provided, initialize one
		if($attempt_key == "") {
			
			if($publisher_key === '') {
				return;
			}
			
			$attempt_key = $playthruManager->initializePlaythru($publisher_key);
			
			if(!$attempt_key) {
				return;
			}
		}
		
		// ask for a playthru
		return $playthruManager->getBlock("playthru", $attempt_key, $_GET);
	}


	public function chooseGame( $hasFlash, $hasCanvas, $attempt_key, $flashversion) {
		
		// initialize a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		// move client decisions to client in the future,
		// so just pass the params array from the API to playthruManager
		$renderMode = "flash";
		if($hasCanvas) {
			$renderMode = "canvas";
		} elseif(!$hasFlash) {
			print $playthruManager->getBlock("noflash", $attempt_key);
			return;
		}
		
		$this->load->library("Mobile_Detect", "", "mobileDetect");
		$mobile = (int)$this->mobileDetect->isMobile();
		
		$params = array("rendermode" => $renderMode, "mobile" => $mobile);
		
		$params = array_merge($params, $_GET);
		
		$this->trackPageView();
		
		// ask for a game
		return $playthruManager->getBlock("game", $attempt_key, $params);
	}
	
	public function getGameInstance($attempt_key) {
		
		// initialize a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		// ask for a game
		return$playthruManager->getBlock("gameinstance", $attempt_key);
	}
	
	public function getGameAudio($attempt_key) {
		// initialize a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		return $playthruManager->getBlock("gameaudio", $attempt_key);
	}
	
	public function getGameData($attempt_key) {
		// initialize a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		return $playthruManager->getBlock("gamedata", $attempt_key);
	}
	
	public function recordTime($event, $attempt_key, $time = '0') {
		$playthruManager = $this->ami->get_backend();
		return $playthruManager->processCommand("gameevent", $attempt_key, array("event" => $event));
	}
	
	public function doAccessibilityReturn() {
		$this->doAccessibilityFallback(false);
	}	

	public function doAccessibilityFallback($attempt_key, $mode = true) {
		$playthruManager = $this->ami->get_backend();
		return $playthruManager->processCommand("accessibilitybuttonclicked", $attempt_key, array("mode" => $mode));
	}
	
	public function recordAccessibilityString($attempt_key, $response, $challenge, $ordinal) {
		$playthruManager = $this->ami->get_backend();
		$playthruManager->updateObservation(array("challenge" => $challenge, "response" => $response, "ordinal" => $ordinal), $attempt_key);
	}

	public function recordAudioString($attempt_key, $response) {
		$playthruManager = $this->ami->get_backend();
		$playthruManager->updateObservation($response, $attempt_key);
	}

	 public function storeGameObservations($attempt_key, $observation) {
		$playthruManager = $this->ami->get_backend();
		$playthruManager->updateObservation($observation, $attempt_key);
		
		$complete = $playthruManager->processCommand("gamecompletecheck", $attempt_key);
		
		if($complete) {
			$playthruManager->score($attempt_key);
		}
		
		return json_encode($complete);
	}
	
	public function scoreGame($attempt_key) {		
		$playthruManager = $this->ami->get_backend();
		
		// handle audio game
		$engine = $playthruManager->processCommand("getgameengine", $attempt_key);
		if($engine == "audio" || $engine =="easyaudio") {
			$playthruManager->score($attempt_key);
		}
		
		$scoreReport = $playthruManager->getScoreReport($attempt_key);
		
		$ar = array();
		if($scoreReport) {
			$ar["status_code"] = (int)$scoreReport["human"];
		} else {
			$ar["status_code"] = 0;
		}
		
		return $this->outputJSON($ar);
	}
	
	public function sessionRestart($session_secret) {
		$playthruManager = $this->ami->get_backend();
		$playthruManager->processCommand("sessionrestart", $session_secret);
		
		return $playthruManager->getBlock("game", $session_secret);
	}
	
	public function trackPageView() {		
		$url = $this->getAnalyticsUrl();
		return $this->sendAnalytics($url);
	}
	
	public function trackEvent($event) {
		$url = $this->getAnalyticsUrl();
		
		$url .= "&utmt=event&utme=5(AYAH_GAME*$event)";
		return $url;
	}
	
	private function getAnalyticsUrl() {
		
		$cookieNum = rand(0, 0x7fffffff);
		$specialRand = rand(1000000000, 2147483647);
		$today = time();
		
		$url = 
			"https://ssl.google-analytics.com/__utm.gif?" .
			"utmwv=5.3.4" . 
			"&utmn=" . rand(0, 0x7fffffff) . 
			"&utmhn=" . urlencode($_SERVER["HTTP_HOST"]) .
			"&utmr=0" .  
			"&utmp=" . urlencode($_SERVER["REQUEST_URI"]) . 
			"&utmac=UA-33982620-1" . 
			"&utmcc=__utma%3D$cookieNum.$specialRand.$today.$today.$today.2%3B%2B__utmb%3D$cookieNum%3B%2B__utmc%3D$cookieNum%3B%2B__utmz%3D$cookieNum.$today.2.2.utmccn%3D(direct)%7Cutmcsr%3D(direct)%7Cutmcmd%3D(none)%3B&utmu=q~";
		
		return $url;
	}
	
	private function sendAnalytics($url) {
		//put inside div otherwise it puts extra space in the iframe in ie
		return "<div><img src='$url' style='opacity:0.0;filter:alpha(opacity=0);'/></div>";
	}
	
	public function status($publisherKey = "", $mode) {
		
		// use a default key if none provided
		if($publisherKey == "") {
			$publisherKey = "test_publisher_key";
		}
		
		// ask webservice for a status
		$systemStatus = $this->ami->get_backend_health_check();
		$status = $systemStatus->getStatus($publisherKey, $mode);
		
		$json = array("status" => $status);
		
		return $this->outputJSON($json);
	}
	
	public function setProfileData($attempt_key) {
		$playthruManager = $this->ami->get_backend();
		return $playthruManager->processCommand("setprofile", $attempt_key, array("attemptID" => $attempt_key));
	}
	
	public function getTags($attempt_key, $event='complete') {
		$playthruManager = $this->ami->get_backend();
		return $playthruManager->getBlock("campaignTags", $attempt_key, array('event' => $event));
	}
	
	public function wrappers($publisher_key, $wrapperName, $params) {
		
		// require a wrapper name
		if(empty($wrapperName)) {
			$data = array("ERROR" => "missing wrapper name");
			return $this->outputJSON($data);
		}
		
		// get a playthru manager
		$playthruManager = $this->ami->get_backend();
		
		// inititalize a session
		$attempt_key = $playthruManager->initializePlaythru($publisher_key);
		
		// get the wrapper block
		$wrapper = $playthruManager->getBlock("wrapper_" . $wrapperName, $attempt_key, $params);
		
		// check if the wrapper exists
		if($wrapper === null || $wrapper === "") {
			$data = array("ERROR" => "missing wrapper or publisher data, '$wrapperName', '$publisher_key'");
			return $this->outputJSON($data);
		}
		
		return $wrapper;
	}
	
	private function outputJSON(&$struct) {
		return json_encode($struct);
	}
}
