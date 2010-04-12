<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Mongo_DB Example Blog Model
* 
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*          @benedmunds
* 
* 
* Location: http://github.com/benedmunds/CodeIgniter-Mongo_DB
*          
* Created:  04.11.2010
* 
* Description:  Example to show how to use MongoDB is your models
* 
* Requirements: PHP5 or above
* 
*/ 

class Blog_model extends mongo_db
{	
	public function __construct()
	{
		parent::__construct();
		
		//set the collection
		$this->collection('posts');
	}
	
	
	/**
	 * add_post
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function add_post($data)
	{		
		return $this->db->posts->insert($data);
	}
	
	/**
	 * get_post
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_post($id)
	{		
		return $this->db->find_one(array('id' => $id));
	}	
}
