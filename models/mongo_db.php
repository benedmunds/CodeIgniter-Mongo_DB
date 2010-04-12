<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  MongoDB
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
* Description:  MongoDB to be extended by models that need to use MongoDB or can be used in controller by loading it as a model
* 
* Requirements: PHP5 or above
* 
*/ 

// CI 2.0 Compatibility
if(!class_exists('CI_Model')) { class CI_Model extends Model {} }

class Mongo_db extends CI_Model
{
	/**
	 * CodeIgniter super-object
	 *
	 * @var object
	 **/
	public $ci;
	/**
	 * Our mongo connection handler
	 *
	 * @var string
	 **/
	public $handle;
	
	/**
	 * Our mongo db object
	 *
	 * @var string
	 **/
	public $db;
	
	/**
	 * Current collection
	 *
	 * @var string
	 **/
	public $collection;
	
	/**
	 * The database name
	 *
	 * @var string
	 **/
	public $database_name;
	
	/**
	 * The server IP address
	 *
	 * @var string
	 **/
	protected $server;
	
	/**
	 * The server port
	 *
	 * @var string
	 **/
	protected $port;
	
	
	public function __construct($database=FALSE)
	{
		parent::__construct();
		
		//get the CI object
		$this->ci =& get_instance();
		
		//load the config file
		$this->ci->load->config('mongo_db', TRUE);
		
		//connect to the server and database
		$this->connect($database);
	}
	
	
	/**
	 * connect
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function connect($database=FALSE)
	{		
		//get the server address and port from the config
		$this->server  = $this->ci->config->item('server_address', 'mongo_db');
		$this->port    = $this->ci->config->item('server_port', 'mongo_db');
		
		
		//connect to the mongodb instance 
		if (!isset($this->handle) || empty($this->handle)) 
		{
			$this->handle = new Mongo($this->server.':'.$this->port);
		}
		
		//use the default db from the config if no db is defined
		if (!$database) 
		{
			$database = $this->ci->config->item('database', 'mongo_db');
		}
		
		//store the db name for public use
		$this->database_name = $database;
		
		//set the database
		$this->db = $this->handle->$database;	
		
		return $this->db;
	}
	
	/**
	 * collection
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	function collection($collection)
	{	
		$this->collection = $collection;
		
		$this->handle->selectDB($this->database_name)->selectCollection($collection);
	
		return $this->db;
	}
	
	/**
	 * find_one
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function find_one($query, $fields=array())
	{		
		return $this->db->{$this->collection}->findOne($query, $fields);
	}

	
	/**
	 * pass through to property from mongodb class
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
    public function __get($prop) 
    {
    	return $this->db->$prop;
    }
    
	
	/**
	 * pass through to the appropriate method
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
    public function __call($method, $args)
    {
    	if (is_object($this->$method) && method_exists($this, $method))
    	{
    		return $this->$method($args);
    	}
    	elseif (is_object($this->db->$method) && method_exists($this->db, $method))
    	{
    		return $this->db->$method($args);
    	}
    	elseif (is_object($this->db->{$this->collection}->$method) && method_exists($this->db->{$this->collection}, $method))
    	{
        	return $this->db->{$this->collection}->$method($args);
    	}
    }
    
	
}
