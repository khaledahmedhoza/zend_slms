<?php

class IndexController extends Zend_Controller_Action
{
		private $user_model;
		//private request_model;
		private $material_model;
		private $course_model;
		private $comment_model;
		private $category_model;

    public function init()
    {
        /* Initialize action controller here */
        	$this->user_model = new Application_Model_Users;
			//$this->request_model = new Application_Model_Requests;
			$this->material_model = new Application_Model_Materials;
			$this->course_model = new Application_Model_Courses;
			$this->comment_model = new Application_Model_Comments;
			$this->category_model = new Application_Model_Categories;
    }

    public function indexAction()
    {
        // action body
    }

    public function homeAction()
    {
       	$this->view->index = $this->course_model->listCourses();

       //	'data' => $this->listCourses()->fetchAll(),

    }

}

