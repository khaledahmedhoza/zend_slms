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

	}

	public function deleteAction(){
		$id = $this->getRequest()->getparam('id');
		$this->category_model->deleteCat($id);

	}

	function getCatById($id){
		return $this->find($id)->toArray();
	}


	public function editAction()
    {  
        $id = $this->getRequest()->getParam('id');
        $cat = $this->category_model->getCatById($id);

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getparams();
            if($form->isValid($data)){
                //$data->id=$id;
                if ($this->category_model->updateCat($data, $id));
            } 
        }

    }

}