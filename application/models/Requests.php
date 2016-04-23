<?php

class Application_Model_Requests extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'requests' ;

	function getRequests(){
		$dba = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dba->select()->from("requests")->order("id");
		return $result = $dba->query($select)->fetchAll();
	}

	function pushRequest($req,$user_id,$username){
			$row = $this->createRow();
			$row->request =$req;
			$row->user_id = $user_id;
			$row->username = $username;
			$row->save();
	}

}

