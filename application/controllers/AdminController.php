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
       //  $data = $this->getRequest()->getparams();
       // //check if there are data or not 
       // if($this->getRequest()->isPost()){
       //    $this->category_model->addCat($data);
       //  }
        //======Edit Cat===== 1-list
        // $id = $this->getRequest()->getParam('id');
        // $cat = $this->category_model->getCatById($id);
        // $this->view->form = $cat;
        // //======Edit Cat===== 2-update
        // if($this->getRequest()->isPut()){
        //   $data = $this->getRequest()->getparams();
        //   $this->category_model->updateCat($data, $id);
        // }       	

	}

	public function deleteAction(){
		$id = $this->getRequest()->getparam('id');
		$this->category_model->deleteCat($id);
		$this->redirect('admin/categories');
	}

	public function addcategoryAction(){
		// $this->_helper->layout->disableLayout();
  //       $this->_helper->viewRenderer->setNoRender(true);
    $form = new Application_Form_Category();
    $this->view->form=$form;

		$data = $this->getRequest()->getparams();
       //check if there are data or not 
       if($this->getRequest()->isPost()){
          $this->category_model->addCat($data);
          //$this->redirect('admin/categories');
		  }
        $this->view->flag = 1;
        $this->view->form = $form;
        $this->render('addcategory'); 
	}

	public function editcategoryAction(){
		//List data in modal to edit  
    $form = new Application_Form_Category();
    $this->view->form=$form;

        $id = $this->getRequest()->getParam('id');
        $cat = $this->category_model->getCatById($id);
        $this->view->form = $cat;

    	//Get data from form with post method     
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getparams();
            $this->category_model->updateCat($data, $id);
            $this->redirect('admin/categories');
        }

        $form->populate($cat[0]);
        $this->view->form = $form;
        $this->render('addcategory');
    }


    //==========courses==========
    public function coursesAction(){

		$courseData=$this->course_model->listCourses();
        $this->view->Data = $courseData;
    }    

    public function addcourseAction(){
        $form = new Application_Form_Courses();
        $this->view->form=$form;

        $data = $this->getRequest()->getparams();
       //check if there are data or not 
       if($this->getRequest()->isPost()){
              $fullFilePath = $form->image->getFileName();  
              $data['image']=$fullFilePath;

            if($form->isValid($data)){
                if ($this->course_model->addCourse($data))
                $this->redirect('admin/courses');  
            }   
        }
        //============image=================
        // $image = $this->getRequest()->getparam('image');
        //     if ($image->getElement('image')->isUploaded()) {
        //         $extension = pathinfo($image->getElement('image')->getValue(), PATHINFO_EXTENSION); 
      
        //         $image->getElement('image')->addFilter('Rename', array('target' => $user->getUsername() . '.' . $extension,'overwrite' => true));
      
        //       if ($image->getElement('image')->receive()) {
        //           $profile = $course->getProfile();
        //           $profile->setPicture($photo->getElement('image')->getValue());
        //           $profile->save();
        //       }
        //     }

        $this->view->flag = 1;
        $this->view->form = $form;
        $this->render('addcourse');    

    }

  public function deletecourAction(){
		$id = $this->getRequest()->getparam('id');
		$this->course_model->deleteCourse($id);
		$this->redirect('admin/courses');
	}    

  public function editcourseAction(){
    //List data in modal to edit  
        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_Courses();
        $course = $this->course_model->getCourseById($id);

      //Get data from form with post method     
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getparams();
            $fullFilePath = $form->image->getFileName();  
            $data['image']=$fullFilePath;

            if($form->isValid($data)){
                $this->course_model->updateCourse($data, $id);
                $this->redirect('admin/courses');
            }

        }
        $form->populate($course[0]);
        $this->view->form = $form;
        $this->render('addcourse');

    }

}