<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Created: 10/16/2013
 * Description: Invalid API requests can be sent here through routes file by setting the route to ""
 * 
 * @author Adam Aleksa - adam@areyouahuman.com
 * @package ayah api
 */

require(APPPATH.'libraries/REST_Controller.php');

class Undefined extends REST_Controller {}