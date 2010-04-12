<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Mongo_DB Config
* 
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*          
* 
* Location: http://github.com/benedmunds/CodeIgniter-Mongo_DB
*          
* Created:  04.11.2010
* 
* Description:  MongoDB to be extended by models that need to use MongoDB or can be used in controller by loading it as a model
* 
*/

	/**
	 * Server
	 **/
	$config['server_address'] = '127.0.0.1';
	$config['server_port']    = '27017';
	
	/**
	 * Deafult Database
	 **/
	$config['database'] = 'foo';
		
/* End of file mongodb.php */
/* Location: ./system/application/config/mongodb.php */
