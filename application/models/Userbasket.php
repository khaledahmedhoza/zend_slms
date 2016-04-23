<?php

class Application_Model_Userbasket extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'user_basket' ;

	function getUserCourses($id){
		$dbd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dbd->select()->from("user_basket","course_id")->where("user_id=$id")->order("course_id");
		return $result = $dbd->query($select)->fetchAll();
	}

}

