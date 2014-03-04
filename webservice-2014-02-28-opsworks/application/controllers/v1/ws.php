<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WS extends AYAH_Controller {

	public function __construct() {
		parent::__construct();
		
		// get a model to do the mapping
		$this->load->model("versioned_model_mapper");
	}

	public function setruntimeoptions($publisher_key = '', $game_id = 0, $view_mode='') {
		$mappingData = array("key" => $publisher_key, "type" => "publisher");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->setruntimeoptions($publisher_key, $game_id, $view_mode);
	}
	
	public function script($publisher_key='', $attempt_key = '', $game_id=0, $view_mode='') {
		$mappingData = array("key" => $publisher_key, "type" => "publisher");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		header('Content-type: text/javascript');
		print $this->ws_model->script($publisher_key, $attempt_key, $game_id, $view_mode);
	}

	public function chooseGame( $hasFlash, $hasCanvas, $attempt_key, $flashversion) {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->chooseGame($hasFlash, $hasCanvas, $attempt_key, $flashversion);
	}
	
	public function getGameInstance() {
		$attempt_key = $this->input->post("session_secret");
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		header('Content-type: text/plain');
		print $this->ws_model->getGameInstance($attempt_key);
	}
	
	public function getGameAudio($attempt_key) {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3");
		print $this->ws_model->getGameAudio($attempt_key);
	}
	
	public function getGameData($attempt_key) {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->getGameData($attempt_key);
	}
	
	public function recordTime($event, $attempt_key, $time = '0') {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->recordTime($event, $attempt_key, $time);
	}
	
	public function doAccessibilityReturn() {
		$this->doAccessibilityFallback(false);
	}	

	public function doAccessibilityFallback($mode = true) {
		$attempt_key = $this->input->post("session_secret");
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->doAccessibilityFallback($attempt_key, $mode);
	}
	
	public function recordAccessibilityString() {
		$attempt_key =  ( isset($this->input) && $this->input->post("session_secret") ) ?  trim($this->input->post("session_secret")) : "" ;
		$response =  ( isset($this->input) && $this->input->post("response") ) ?  trim($this->input->post("response")) : "" ;
		$challenge = $_POST['challenge'];
		$ordinal =  ( isset($this->input) && $this->input->post("ordinal") ) ?  trim($this->input->post("ordinal")) : "" ;
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->recordAccessibilityString($attempt_key, $response, $challenge, $ordinal);
	}

	public function recordAudioString() {
		$attempt_key =  ( isset($this->input) && $this->input->post("session_secret") ) ?  trim($this->input->post("session_secret")) : "" ;
		$response =  ( isset($this->input) && $this->input->post("response") ) ?  trim($this->input->post("response")) : "" ;
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->recordAudioString($attempt_key, $response);
	}

	 public function storeGameObservations() {
		$attempt_key =  ( isset($this->input) && $this->input->post("session_secret") ) ? trim($this->input->post("session_secret")) : "";
    	$observation =  ( isset($this->input) && $this->input->post("od") ) ? trim($this->input->post("od")) : "";
		if($observation == "" && isset($this->input) && $this->input->post("observation_data")) {
			$observation = $this->input->post("observation_data");
		}
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		header('Content-type: text/json');
		print $this->ws_model->storeGameObservations($attempt_key, $observation);
	}
	
	public function scoreGame() {
		$attempt_key =  ( isset($this->input) && $this->input->post("session_secret") ) ? trim($this->input->post("session_secret")) : "";
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->scoreGame($attempt_key);
	}
	
	
	public function sessionRestart($attempt_key) {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->sessionRestart($attempt_key);
	}

	public function trackPageView() {
		$this->load->model("v1/ws", "ws_model");
		print $this->ws_model->trackPageView();
	}
	
	public function trackEvent($event) {
		$this->load->model("v1/ws", "ws_model");
		print $this->ws_model->trackEvent($event);
	}
	
	public function status($publisher_key = "") {
		// get the mode
		$mode = "simple";
		
		if(isset($_GET["mode"])) {
			$mode = $_GET["mode"];
		}
		
		$mappingData = array("key" => $publisher_key, "type" => "publisher");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->status($publisher_key, $mode);
	}
	
	public function setProfileData() {
		$attempt_key =  ( isset($this->input) && $this->input->post("session_secret") ) ? trim($this->input->post("session_secret")) : "";
		
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->setProfileData($attempt_key);
	}
	
	public function getTags($attempt_key) {
		$mappingData = array("key" => $attempt_key, "type" => "attempt");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->getTags($attempt_key);
	}
	
	public function wrappers($wrapperName = "") {
		
		// require a wrapper name
		if(empty($wrapperName)) {
			$data = array("ERROR" => "missing wrapper name");
			return $this->outputJSON($data);
		}
		
		// require a publisher id
		if(!isset($_GET["pub_key"])) {
			$data = array("ERROR" => "missing pub_key in GET request");
			return $this->outputJSON($data);
		}
		
		$publisher_key = $_GET["pub_key"];
		
		// get additional params
		$params = $_GET;
		unset($params["pub_key"]);
		
		$mappingData = array("key" => $publisher_key, "type" => "publisher");
		$model = $this->versioned_model_mapper->getModel("v1", "ws", $mappingData);
		$this->load->model($model, "ws_model");
		print $this->ws_model->wrappers($publisher_key, $wrapperName, $params);
	}
	
	// Legacy interfaces to support
	public function index() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function modal($publisher_key='', $game_id=0, $view_mode='', $data='', $dev_mode='') {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function inline($publisher_key='', $game_id=0, $view_mode='', $data) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function reportError() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function storeCookie() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function recordConversion($session_secret = FALSE) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function choosemethod($publisher_key) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function getIframe() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function getInit($session_secret = '', $time = 0) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function getFeedbackInfo() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function setFeedbackResponse() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function initializeProfile($session_secret) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function initializeProfileHelper($session_secret) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	private function setProfile($session_secret) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function recordEvent($session_secret, $event, $time) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	private function curl_post_async($url, $params = array()) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function no_flash() {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}
	public function getGameImage($session_secret) {
		error_log(__CLASS__.'::'.__FUNCTION__.' - Legacy function called');
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
