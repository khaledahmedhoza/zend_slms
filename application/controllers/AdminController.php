<?php
class AdminController extends Zend_Controller_Action
{

	private $user_model;
	private $material_model;
	private $course_model;
	private $comment_model;
	private $category_model;



	public function init(){
		/* Initialize action controller here */
		$this->user_model = new Application_Model_Users;
		$this->material_model = new Application_Model_Materials;
		$this->course_model = new Application_Model_Courses;
		$this->comment_model = new Application_Model_Comments;
		$this->category_model = new Application_Model_Categories;
	}

	public function categoriesAction(){

		$catData=$this->category_model->listCat();
        $this->view->Data = $catData;

        //======Add Cat=====
        $data = $this->getRequest()->getparams();
       //check if there are data or not 
       if($this->getRequest()->isPost()){
          $this->category_model->addCat($data);
        }
        //======Edit Cat===== 1-list
        $id = $this->getRequest()->getParam('id');
        $cat = $this->category_model->getCatById($id);
        $this->view->form = $cat;
        //======Edit Cat===== 2-update
        if($this->getRequest()->isPut()){
          $data = $this->getRequest()->getparams();
          $this->category_model->updateCat($data, $id);
        }       	

	}

	public function deleteAction(){
		$id = $this->getRequest()->getparam('id');
		$this->category_model->deleteCat($id);
		$this->redirect('admin/categories');
	}

	public function addAction(){
		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
		$data = $this->getRequest()->getparams();
       //check if there are data or not 
       if($this->getRequest()->isPost()){
          $this->category_model->addCat($data);
		}
	}

	// public function editAction(){
	// 	//List data in modal to edit  
 //        $id = $this->getRequest()->getParam('id');
 //        $cat = $this->category_model->getCatById($id);
 //        $this->view->form = $cat;

 //    	//Get data from form with post method     
 //        if($this->getRequest()->isPost()){
 //            $data = $this->getRequest()->getparams();
 //                //$data->id=$id;
 //               $this->category_model->updateCat($data, $id);
 //        }
 //    }

}