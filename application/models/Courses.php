<?php

class Application_Model_Courses extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'courses' ;


	function listCourses()
	{
		return $this->fetchAll()->toArray();
	}

}