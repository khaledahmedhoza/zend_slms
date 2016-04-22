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
        if($this->getRequest()->isGet())
        {
            $category = $this->getRequest()->getparam('category');
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

        $form=new Application_Form_User();
        //////////////login after update element/////////////
        $username = $this->_getParam('username');
       
        if(isset($username)){
            $form->Username->setValue($username);
            $this->render('login');
        }
        ///////////////////////////////////////////////////////

        $userName=$this->getRequest()->getParam('Username');
        $password=$this->getRequest()->getParam('password');

       
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
                        $storage->write($adapter->getResultRowObject(array('name' , 'password' , 'email', 'id','image','username')));
                        
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
        $username = $this->_getParam('username');

        if(isset($username)){
            
            // echo $username;
            // die();
            Zend_Auth::getInstance()->clearIdentity();
            $this->redirect('/users/login/username/'.$username);
        }

        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('/');

    }



    public function settingsAction(){
        $form=new Application_Form_User();

        if(Zend_Auth::getInstance()->hasIdentity()){

            $userInfo = Zend_Auth::getInstance()->getStorage()->read();

                if($this->getRequest()->isPost() ){
                    //update image/////////////////////////////////////////////////////
                    $userInfo = Zend_Auth::getInstance()->getStorage()->read();

                    $userName=$userInfo->username;
                    $id = $userInfo->id;
                    $data = $this->getRequest()->getParams();
                   
                    $uploadedData = $form->getValues();
                    $fullFilePath = $form->image->getFileName();

                    $image=$fullFilePath;

                    $this->user_model->updateImage($id,$image);
                    $this->redirect('users/logout/username/'.$userName);

                  }else{
                    $form->removeElement('age');
                    $form->removeElement('email');
                    $form->removeElement('Username');
                    $form->removeElement('name');
                    $form->removeElement('password');
                    // $form->removeElement('Submit');

                    $this->view->form=$form;
                    $this->view->userInfo=$userInfo;
                  }

        }else{
            echo "<h3>You Don't have access to here please login first</h3>";
        }
         
    }




    public function updateElemAction(){

        if(Zend_Auth::getInstance()->hasIdentity()){
            $userInfo = Zend_Auth::getInstance()->getStorage()->read();

            $userName=$userInfo->username;

            $id = $userInfo->id;
            $elements = $this->getRequest()->getParams();

            foreach($elements as $key => $val){
                    $newName = $val;   
                    $element = $key;
            }    

            $this->user_model->updateElement($id,$newName,$element);


            //////////////Update Storage after update any element.///////////////////////////

            // Zend_Auth::getInstance()->getStorage()->write($element);


            // $db = Zend_Db_Table::getDefaultAdapter();
            

            // $adapter = new Zend_Auth_Adapter_DbTable(
            //         $db,
            //         'users',
            //         'username',
            //         'password'
            //         );

            // $adapter->setIdentity(Zend_Auth::getInstance()->getIdentity());
            
            // Zend_Auth::getInstance()->getStorage()->write($adapter->getResultRowObject(array('name' , 'password' , 'email', 'id','image')));

            $this->redirect('users/logout/username/'.$userName);

        }

    }
}
