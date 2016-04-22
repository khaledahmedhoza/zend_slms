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


	function updateElement($id,$elem,$elemName){
		$params=array(
            'host' =>'localhost',
            'username' =>'root',
            'password' =>'123',
            'dbname' =>'zend');

		$db = Zend_Db::factory('Pdo_Mysql', $params);

		if(isset($data['controller'])) 
			unset($data['controller']);
		if(isset($data['action'])) 
			unset($data['action']);
		if(isset($data['module'])) 
			unset($data['module']);
		if(isset($data['Submit'])) 
			unset($data['Submit']);

		return $db->update('users', array($elemName=>$elem), 'id='.$id);


	}

	function updateImage($id,$image){
		$params=array(
            'host' =>'localhost',
            'username' =>'root',
            'password' =>'123',
            'dbname' =>'zend');

		$db = Zend_Db::factory('Pdo_Mysql', $params);

		if(isset($data['controller'])) 
			unset($data['controller']);
		if(isset($data['action'])) 
			unset($data['action']);
		if(isset($data['module'])) 
			unset($data['module']);
		if(isset($data['Submit'])) 
			unset($data['Submit']);
		$data = array(
		    'image'=> $image,
		    
		);

		// var_dump($image);
		// die();
		// return $db->update('users', $data, 'id='.$id);
		return $db->update('users', $data, 'id='.$id);

	}

}

