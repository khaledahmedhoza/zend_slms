<?php

class Application_Model_Comments extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'comments' ;
	
	function getCourseReviews($course_id){
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		 $select = $db->select()->from("comments")->where("course_id=$course_id");
		return $result = $db->query($select)->fetchAll();
	}

}

