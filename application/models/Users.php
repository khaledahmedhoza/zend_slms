<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'users' ;

	// function register($data){	

	// 	if(isset($data['controller'])) 
	// 		unset($data['controller']);
	// 	if(isset($data['action'])) 
	// 		unset($data['action']);
	// 	if(isset($data['module'])) 
	// 		unset($data['module']);
	// 	if(isset($data['Submit'])) 
	// 		unset($data['Submit']);
	// 	if(isset($data['MAX_FILE_SIZE'])) 
	// 		unset($data['MAX_FILE_SIZE']);
		
	// 	return $this->insert($data);
	// }


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

////////////////registration with confirmation mail/////////////////////////////////

	public function create($name,$username, $email, $password,$age , $token)
    {
        $row = $this->createRow();
        if ($row) 
        {
            try
            {
                $row->username = $username;
                $row->name = $name;
                // $row->password = md5($password);
                $row->password = $password;
                $row->email = $email;
                $row->age = $age;
                // $row->image = $image;
                $row->status = 0;
                $row->token = $token;
                $id = $row->save();
                return $id;
            }
            catch(Zend_Exception $e)
            {
                throw new Zend_Exception('An unknown error has occurred: ' . $e->getMessage());
            }
        }
        else
        {
           throw new Zend_Exception("An unknown error has occurred. The user could not be created!");
        }
    }



	private static function uuid()
    {
        $result = sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
                          mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
                          mt_rand(0, 65535), // 16 bits for "time_mid"
                          mt_rand(0, 4095), // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
                          bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
            // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
            // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
            // 8 bits for "clk_seq_low"
                          mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)); // 48 bits for "node"
        return $result;
    }

    public function getActivationToken()
	{
	     return $this->uuid();
	}


 	public function validateActivationToken($token, $email) 
    {
        $select = $this->select()->where('token =?', $token)->where('email =?', $email);
        $row = $this->fetchRow($select);
        if(is_null($row->id))
        {
            return 0;
        }
        else
        {
            return $row->id;
        }
    }

    public function activateUser($id)
    {
        $row = $this->find($id)->current();
        if($row)
        {
             try
             {	
                $row->status = 1;
                $row->save();    
	             return $row;
            }
            catch(Zend_Exception $e)
            {
                throw new Zend_Exception('An error has occurred activation the user account: ' . $e->getMessage());
            }
        }
        else
        {
            throw new Zend_Exception('Could not activate user account');
        }
    }

    public function isActive($userName){
    	
		$select = $this->select()->where('username =?', $userName);
        $row = $this->fetchRow($select);
        
        if(isset($row)){
        	if(is_null($row->status))
	        {
	            return 0;
	        }
	        else
	        {
	        	// var_dump($row->status);
	            return $row->status;
	        }
        }else{
        	return -1;
        }
        
   	}

   	public function isAdmin($userName){
    	
		$select = $this->select()->where('username =?', $userName);
        $row = $this->fetchRow($select);
        if(isset($row)){
	        if(is_null($row->is_admin))
	        {
	            return 0;
	        }
	        else
	        {
	        	// var_dump($row->status);
	            return $row->is_admin;
	        }
	    }else{
        	return -1;
        }
   	}



   	function listUsers(){
		return $this->fetchAll()->toArray();
	}

	function deleteUser($id){
		return $this->delete('id='.$id);
	}

	function editUser($id,$data){

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
		if(isset($data['MAX_FILE_SIZE'])) 
			unset($data['MAX_FILE_SIZE']);

		return $db->update('users', $data, 'id = '.$id);
	}

	function getUserById($id){
		return $this->find($id)->toArray();
	}

}

