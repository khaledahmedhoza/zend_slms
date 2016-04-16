<?php

class UsersController extends Zend_Controller_Action
{

    private $user_model = null;

    private $material_model = null;

    private $course_model = null;

    private $comment_model = null;

    private $category_model = null;

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

    public function courseAction()
    {
       	$course_id = $this->_request->getParam('course_id');
	$course_data = $this->course_model->getCourseInfo($course_id);
	$course_comments = $this->comment_model->getCourseReviews($course_id);
	$this->view->assign('data',$course_data);
	$this->view->assign('reviews',$course_comments);
    }

    public function startcourseAction()
    {
        $course_id = $this->_request->getParam('course_id');
	$doc_no = $this->_request->getparam('doc_no');
	$doc_list = $this->material_model->listDocuments($course_id);
	$doc = $this->material_model->getDocument($course_id,$doc_no);
	$this->view->assign('listdata',$doc_list);
	$this->view->assign('document',$doc);
    }


}





