<?php

class UsersController extends Zend_Controller_Action
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

    public function searchAction()
    { 
        //======Simple search======//
       $Cname = $this->getRequest()->getparam('search');
       //check if there are data or not 
       if($this->getRequest()->isPost()){
            if ($result=$this->course_model->getCourses($Cname)){
                    $this->view->search = $result;

            }
        }
        //=======Search adv=======//
        $category = $this->getRequest()->getparam('category');
        if($this->getRequest()->isGet())
        {
            $data=$this->getRequest()->getParams();
            ///send cat name and get cat id 
            if($this->category_model->getCatId($data)) { 
                for($i=0; $i<count($this->category_model->getCatId($data)); $i++){
                    $cat=$this->category_model->getCatId($data)[$i]['id'];
                    //print_r($cat);
                }    
            }
            if ($totalData=$this->course_model->getData($data,$cat)){
                    $this->view->data = $totalData;

            }
        }

        //==========list categories=====>>>
        $catData=$this->category_model->listCat();
        $this->view->catData = $catData;

        //=========List courses=========>>>
        $courseData=$this->course_model->listCourses();
        $this->view->courseData = $courseData;


    }



    public function registerAction(){

    	$form=new Application_Form_User();


        if($this->getRequest()->isPost()){

            // if(($form->isValid($_POST))){
                $data=$this->getRequest()->getParams();

                //set false for first registration and normal users////
                $data['is_admin']='false';
                $data['is_banned']='false';
                // success - do something with the uploaded file
                $uploadedData = $form->getValues();
                $fullFilePath = $form->image->getFileName();
                
                $data['image']=$fullFilePath;

                if($this->user_model->register($data)){
                    $this->redirect('/');
                // }
            }else{
                echo "NOt Valid form";
            }
        	
        }else{
            $this->view->form=$form;
            $this->render('register');
        }
    }




    public function loginAction(){
        $userName=$this->getRequest()->getParam('Username');
        $password=$this->getRequest()->getParam('password');

        $form=new Application_Form_User();
        // $form->getElement('Username')->removeValidator('Db_NoRecordExists');

        $db = Zend_Db_Table::getDefaultAdapter();



///Validation With Form /////////////////////////////////////////////////

//&& $form->isValid($this->getRequest()->getPost())
        if($this->getRequest()->isPost() ){
        
                 $adapter = new Zend_Auth_Adapter_DbTable(
                    $db,
                    'users',
                    'username',
                    'password'
                    );
     
                    $adapter->setIdentity($userName);
                    $adapter->setCredential($password);
         
                   $result = $adapter->authenticate();   
                    if ($result->isValid()) {
                        $auth = Zend_Auth::getInstance();
                        $storage = $auth->getStorage();
                        $storage->write($adapter->getResultRowObject(array('name' , 'password' , 'email', 'id')));
                        
                        $this->view->loginFlag="true";
                        $this->_redirect('/');
                          
                    }else{
                        $notValid='';
                        $this->view->notValid="1";
                        $form->removeElement('age');
                        $form->removeElement('email');
                        $form->removeElement('image');
                        $form->removeElement('name');
                        $this->view->form = $form;
                        $this->render('login');
                    }

            
        }else{
            $form->removeElement('age');
            $form->removeElement('email');
            $form->removeElement('image');
            $form->removeElement('name');

            $this->view->form=$form;
            $this->render('login');
        }
    }

    public function logoutAction(){
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('/');
    }

}



