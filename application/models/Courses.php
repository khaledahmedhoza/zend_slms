<?php

class Application_Model_Courses extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'courses' ;


	function getCourseInfo($course_id){
		return $this->find($course_id);
	}



	function listCourses()
	{
		return $this->fetchAll()->toArray();
	}

}
