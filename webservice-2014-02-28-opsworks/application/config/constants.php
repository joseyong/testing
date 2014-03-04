<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define("AYAH_COOKIE", "AYAH_Cookie");

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* AYAH-specific constants */
define('AYAH_SUCCESS', 1);

define('AYAH_DONT_STOP', 0);

define('AYAH_FAIL_CORRECTNESS', -1);
define('AYAH_FAIL_SCORING', -2);
define('AYAH_SCORE_REQUESTED_ALREADY', -3);
define('AYAH_ALREADY_SCORED', -4);
define('AYAH_TOO_MANY_MISTAKES', -5);
define('AYAH_INVALID_OBSERVATION', -6);
define('AYAH_DUPLICATE_OBSERVATION', -7);
define('AYAH_SIMILAR_OBSERVATION', -8);
define('AYAH_PLAYED_TOO_FREQUENTLY', -9);
define('AYAH_WATERMARK_NOT_VALID', -10);
define('AYAH_REQUIRED_EVENTS_FAILED', -11);
define('AYAH_DEFAULT', -999);


define('AYAH_BAD_PUBLISHER_KEY', -99);

define('AYAH_BAD_INPUT', -100);
define('AYAH_UNRECOGNIZED_FILE', -101);
define('AYAH_MALFORMED_DESCRIPTION_FILENAME', -102);
define('AYAH_MALFORMED_GAME_DESCRIPTION', -103);
define('AYAH_INVALID_GAME_ID', -104);
define('AYAH_QUERY_FAILED_GAMEISSUES', -105);
define('AYAH_QUERY_FAILED_GAMEMODE', -106);
define('AYAH_QUERY_FAILED_ACCESSIBLITYSTRING', -107);
define('AYAH_QUERY_FAILED_GAMECOOKIEDATA', -108);
define('AYAH_QUERY_FAILED_SESSIONRESTART', -109);

define('AYAH_MISSING_FINGERPRINT_DATA',	-201);

define('AYAH_AUDITERROR_EVENTIP', -301);
define('AYAH_AUDITERROR_EVENT', -302);
define('AYAH_AUDITERROR_EVENTTYPE', -303);



/* End of file constants.php */
/* Location: ./application/config/constants.php */
