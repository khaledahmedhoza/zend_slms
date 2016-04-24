<?php

class Application_Model_Courses extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'courses';



	function getCourseInfo($course_id){
		return $this->find($course_id);
	}



	function listCourses()
	{
		return $this->fetchAll()->toArray();
	}


	function getDisSkill (){
		$select = $this->select()->from('courses', array('skill_level'))
		->distinct();

		return $this->fetchAll($select);
	}
	function getDisLang (){
		$select = $this->select()->from('courses', array('language'))
		->distinct();

		return $this->fetchAll($select);
	}
	function getDisType (){
		$select = $this->select()->from('courses', array('type'))
		->distinct();

		return $this->fetchAll($select);
	}



	function getCourses($Cname){

		$select = $this->select()->where('course_name LIKE ?',$Cname.'%')->limit(10);
		return $this->fetchAll($select);
	}

	function getData($data){

		$language=$data['language'];
		$skill=$data['skill_level'];
		$type=$data['type'];
		// print_r($data['category_name']);
		$select = $this->select()
		// ->distinct()
		// ->from(array('c' => 'courses'))
		->where('skill_level LIKE ?',$skill.'%')
		->where('language LIKE ?',$language.'%')
		->where('type LIKE ?',$type.'%');

		// $select = $db->select()
  //            ->distinct()
  //            ->from(array('p' => 'products'), 'product_name');

		//->where('category_id = ?',$cat);
		
		return $this->fetchAll($select);
	}

	function getFreqCourses(){
		$dba = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dba->select()->from("courses")->where("student_no > 1")->order("id");
		return $result = $dba->query($select)->fetchAll();
	}

	function getCoursesNames($related_courses){
		for($i=0;$i<sizeof($related_courses);$i++){
			$obj = $this->find($related_courses[$i]['x']);
			$data[$related_courses[$i]['x']] = $obj[0]['course_name'];
		}
		return $data;
	}

	//============views======
	function addCourse ($data){
		// $row->category_name = $data['cat'];
		// return $row->save();

		if (isset($data['module']))
				unset($data['module']);
			if (isset($data['controller']))
				unset($data['controller']);
			if (isset($data['action']))
				unset($data['action']);
			if (isset($data['submit']))
				unset($data['submit']);
			if(isset($data['MAX_FILE_SIZE'])) 
				unset($data['MAX_FILE_SIZE']);

			$this->insert($data);
	}	

	function deleteCourse($id){
		return $this->delete('id='.$id);
	}

	function getCourseById($id){
		return $this->find($id)->toArray();
	}

	function updateCourse($data , $id){
		$arr = array(
			  'course_name' => $data['course_name'],
			  'course_desc' => $data['course_desc'],
			  'category_id' => $data['category_id'],
			  'duration' => $data['duration'],
			  'language' => $data['language'],
			  'instructor' => $data['instructor'],
			  'image' => $data['image']
		    );
		$id=$data['id'];
		$this->update($arr,'id ='.$id);
	}

}

