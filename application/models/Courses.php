<?php

class Application_Model_Courses extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'courses';


	function listCourses(){

		return $this->fetchAll()->toArray();
	}

	function getCourses($Cname){

		$select = $this->select()->where('course_name LIKE ?',$Cname.'%')->limit(10);
		return $this->fetchAll($select);
	}

	function getData($data,$cat){

		$skill = $data['skill'];
		$language = $data['language'];
		$category = $data['category'];

		$select = $this->select()->where('skill_level LIKE ?',$skill.'%')
		->where('language LIKE ?',$language.'%')
		->where('category_id = ?',$cat);
		
		return $this->fetchAll($select);
	}

}