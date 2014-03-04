<?php

// The tracker types and any needed parameters.
$config['trackers'] = array(
	// Currently implemented.
	'UniversalGoogleAnalytics' => array('account_id' => 'UA-33982620-2'),
	
	// Not yet implemented.
	'ClassicGoogleAnalytics'   => array('account_id' => 'UA-33982620-1'),
	'MixPanel'                 => array(),
	'StatHat'                  => array(),
	'AyahAnalytics'            => array('attempt_key' => 'must be passed in via data')
);


// Defines all the categorys and the trackers to use for the events.
$config['categories'] = array(
	'game' => array(
		'default' => array('UniversalGoogleAnalytics', 'ClassicGoogleAnalytics', 'AyahDatabase')
	),
	'vpaid' => array(
		'default' => array('UniversalGoogleAnalytics')
	),
	'mraid' => array(
		'default' => array('UniversalGoogleAnalytics', 'ClassicGoogleAnalytics', 'AyahDatabase')
	),
	'interstitial' => array(
		'default' => array('UniversalGoogleAnalytics', 'ClassicGoogleAnalytics', 'AyahDatabase')
	),
);

$config['valid_event_data_names'] = array('campaign', 'action', 'label', 'value');

return $config;
