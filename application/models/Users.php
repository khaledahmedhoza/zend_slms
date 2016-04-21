<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'users' ;

	function register($data){	

		if(isset($data['controller'])) 
			unset($data['controller']);
		if(isset($data['action'])) 
			unset($data['action']);
		if(isset($data['module'])) 
			unset($data['module']);
		if(isset($data['Submit'])) 
			unset($data['Submit']);
		if(isset($data['MAX_FILE_SIZE'])) 
			unset($data['MAX_FILE_SIZE']);
		
		return $this->insert($data);
	}



}

