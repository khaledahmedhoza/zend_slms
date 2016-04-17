<?php
class CourseController extends Zend_Controller_Action
{

	private $user_model;
	private $material_model;
	private $course_model;
	private $comment_model;
	private $category_model;



public function init()
{
	/* Initialize action controller here */
	$this->user_model = new Application_Model_Users;
	$this->material_model = new Application_Model_Materials;
	$this->course_model = new Application_Model_Courses;
	$this->comment_model = new Application_Model_Comments;
	$this->category_model = new Application_Model_Categories;
}

public function courseAction()


}
//$this->view->users = $this->model->listUsers();