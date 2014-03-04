<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route = array();


// this way when we route stuff to "" it gets sent here
$route['default_controller'] = "default";
$route['404_override'] = '';
 
// regex for alphanumeric, use $1, $2, etc to access this values because of the parenthesis
$KEY = "([a-zA-Z0-9_-]+)";


// regex that matches either the default version or if they left the version blank
$DEFAULT_VERSION = "(?:v2/)?";


/*****************************************
 * Version 1 (and legacy)
 ****************************************/
$route["v1/(:any)"] = "v1/$1";
$route["ws"] = "v1/ws";
$route["ws/(:any)"] = "v1/ws/$1";
$route["track"] = "track";


/*****************************************
 * Version 2 (default)
 ****************************************/


// publishers
$route[$DEFAULT_VERSION."publishers/$KEY"] = "v2/publishers/index/$2";
$route[$DEFAULT_VERSION."publishers/$KEY/$KEY"] = "v2/publishers/$2/$1";


// playthrus
$route[$DEFAULT_VERSION."playthrus"] = "v2/playthrus";
$route[$DEFAULT_VERSION."game"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/game"] = "v2/game/index/$1";
$route[$DEFAULT_VERSION."component"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/component"] = "v2/component/index/$1";
$route[$DEFAULT_VERSION."attributes"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/attributes"] = "v2/attributes/index/$1";
$route[$DEFAULT_VERSION."observations"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/observations"] = "v2/observations/index/$1";
$route[$DEFAULT_VERSION."results"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/results"] = "v2/results/index/$1";
$route[$DEFAULT_VERSION."events"] = "";
$route[$DEFAULT_VERSION."playthrus/$KEY/events"] = "v2/events/index/$1";


// profiles
$route[$DEFAULT_VERSION."profiles"] = "v2/profiles";


/* End of file routes.php */
/* Location: ./application/config/routes.php */