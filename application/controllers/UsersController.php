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
    public function testAction()
    { 
        //1) get selected data
        // $data=$this->getRequest()->getParams();
        // $skill = $data['skill_level'];
        // $language = $data['language'];
        // //2) send to courses 
        // if ($totalData=$this->course_model->getData($data)){
        //     $this->view->data = $totalData;
        //     $this->redirect('users/search');
        // }            
    }   
    public function searchAction()
    { 
                    //1)==========list categories=====>>>
                    $catData=$this->category_model->listCat();
                    $this->view->catData = $catData;

                    //2)=========List courses=========>>>
                    $courseData=$this->course_model->listCourses();
                    $this->view->courseData = $courseData;

                    //3)======PostMethod=====Simple search======//
                   $Cname = $this->getRequest()->getparam('search');
                   if($this->getRequest()->isPost()){
                        if ($result=$this->course_model->getCourses($Cname)){
                                $this->view->search = $result;
                        }
                    }
                    //4)=====GetMethod====droplist=====//
                    $data=$this->getRequest()->getParams();
                    if($this->getRequest()->isGet()){
                        if ($totalData=$this->course_model->getData($data)){
                                $this->view->data = $totalData;
                            } 
                    }                   

                    //=======Search adv=======//
        // if($this->getRequest()->isGet())
        // {
        //     $category = $this->getRequest()->getparam('category');
        //     $data=$this->getRequest()->getParams();
        //     ///send cat name and get cat id 
        //     if($this->category_model->getCatId($category)) { 
        //         for($i=0; $i<count($this->category_model->getCatId($category)); $i++){
        //             $cat=$this->category_model->getCatId($category)[$i]['id'];
        //             //print_r($cat);
        //         }      
  
        //     }

        //     if ($totalData=$this->course_model->getData($data,$cat)){
        //             $this->view->data = $totalData;

        //     }
        // }


    }



    //registration without confirmation code/////////////////////////////////
    // public function registerAction(){   

    // 	$form=new Application_Form_User();


    //     if($this->getRequest()->isPost()){

    //         if(($form->isValid($_POST))){
    //             $data=$this->getRequest()->getParams();

    //             //set false for first registration and normal users////
    //             $data['is_admin']='false';
    //             $data['is_banned']='false';
    //             // success - do something with the uploaded file
    //             $uploadedData = $form->getValues();
    //             $fullFilePath = $form->image->getFileName();
                
    //             $data['image']=$fullFilePath;

              
    //             if($this->user_model->register($data)){
    //                 $this->redirect('/');
    //             }
    //         }else{
    //             // echo "NOt Valid form";
    //             $notValidReg='true';
    //             $this->view->notValidR=$notValidReg;
    //             $this->view->form=$form;
    //             $this->render('register');
    //         }
        	
    //     }else{
    //         $this->view->form=$form;
    //         $this->render('register');
    //     }
    // }
    /////////////////////////////////////////////////////////////////////////



    public function loginAction(){

        $form=new Application_Form_User();
        //////////////login after update element/////////////
        $username = $this->_getParam('username');
       
        if(isset($username)){
            $form->username->setValue($username);
            $this->render('login');
        }
        ///////////////////////////////////////////////////////
        //////Normal login////////
        $userName=$this->getRequest()->getParam('username');
        $password=$this->getRequest()->getParam('password');

        // $form->getElement('Username')->removeValidator('Db_NoRecordExists');

        ///Validation With Form /////////////////////////////////////////////////
        //$form->getElement('Username')->removeValidator("Db_NoRecordExists");
        // && $form->isValid($this->getRequest()->getPost())
        //&& $form->isValid(array('Username'=>$userName,'password'=>$password))
        if($this->getRequest()->isPost()){
                
                $db = Zend_Db_Table::getDefaultAdapter();
                $adapter = new Zend_Auth_Adapter_DbTable(
                        $db,
                        'users',
                        'username',
                        'password'
                        );

                
                $status = $this->user_model->isActive($userName);
               
                $admin = $this->user_model->isAdmin($userName);
                // echo $admin;
                // die();

                ////////admin user//////////////////////////////////////
                if(isset($admin) && $admin == 1){

                    $adapter->setIdentity($userName);
                    $adapter->setCredential($password);
             
                    $result = $adapter->authenticate();   
                    if ($result->isValid()) {
                            $auth = Zend_Auth::getInstance();
                            $storage = $auth->getStorage();
                            $storage->write($adapter->getResultRowObject(array('name' , 'password' , 'email', 'id','image','username','is_admin')));
                            
                            $this->view->loginFlag="true";
                        $this->redirect("/admin/index/username/".$userName);
                    }
                /////////inActive User//////////////////////////////////////
                }else if($status == 0){
                    $this->view->inActive="true";
                    
                    $form->removeElement('age');
                    $form->removeElement('email');
                    $form->removeElement('image');
                    $form->removeElement('name');
                    $this->view->form = $form;
                    $this->render('login');

                ///////NOrmal User///////////////////////////////////////////
                }else{
         
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
                }
            
        //when access login while already logged in user//////////////////
        }else if(Zend_Auth::getInstance()->hasIdentity()){
            echo "<h2>Logout first to enter with another user</h2>";
            $this->render('index');
            
        //get method render login form //////////////////////////////////           
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
        //logout after update user data////////////////////////
        $username = $this->_getParam('username');

        if(isset($username)){
            
            // echo $username;
            // die();
            Zend_Auth::getInstance()->clearIdentity();
            $this->redirect('/users/login/username/'.$username);
        }

        ///normal logout//////////////////////////////////////
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('/');

    }

    //profile action//////////////////////////////////////////////////
    public function settingsAction(){
        $form=new Application_Form_User();

        //check if it's logged uer or not //////////////////////////////
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
                    $form->removeElement('username');
                    $form->removeElement('name');
                    $form->removeElement('password');
                    // $form->removeElement('Submit');

                    $this->view->form=$form;
                    $this->view->userInfo=$userInfo;
                  }

        //when access this page and i didn't have user log-in .....
        }else{
            echo "<h3>You Don't have access to here please login first</h3>";
        }
         
    }


    //abstract function to update element ........
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


///////////////////////////registration with confirmation Mail //////////////////////////////////

    public function registerAction()
    {


          $form = new Application_Form_User();
         if($this->_request->isPost() && $form->isValid($_POST))
          {
               //code to process the form
               $model = new Application_Model_Users();
               $formValues = $this->_request->getParams();
              $token = $model->getActivationToken();
              // echo $token;
              // die();
              // $nameWS = str_replace(' ', '', trim($formValues['name']->getName()));

              $id = $model->create($formValues['name'],
                                    $formValues['username'],
                                    
                                    $formValues['email'],
                                    $formValues['password'],
                                    $formValues['age'],
                                    // $formValues['password'],
                                    $token);
               if(isset($id))
               {
                   $mail = new Application_Model_Mail();
                   $mail->sendActivationEmail($formValues['username'], $formValues['email'], $token);
                   $this->_redirect('users/register-success');
               }
               else
               {
                   throw new Zend_Exception('Registration Error');
               }
          }
          else
          {
            $this->view->form=$form;
            $this->render('register');  
            }


    }

    public function registerSuccessAction(){
        $this->render('register-success');
    }


    public function activateAction()
    {
        $token = $this->_request->getParam('token');
        $email = $this->_request->getParam('email');
        if(isset($token) && isset($email))
        {
            $user = new Application_Model_Users();
            $result = $user->validateActivationToken($token, $email);
            if($result > 0)
           {
                $user->activateUser($result);
                $this->_redirect('/users/activation-success');
          }
          else
          {
                throw new Zend_Exception('There was an error activating you account');
          }
       }
       else
       {
            throw new Zend_Exception('Activation link incorrect');
       }
    }

    public function activationSuccessAction(){
        $this->render('activation-success');
    }


    //////////list Users//////////////////
    public function listAction(){
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();                        if(isset($userInfo))
                $isAdmin=$userInfo->is_admin;
                            
            if(Zend_Auth::getInstance()->hasIdentity() && $isAdmin == 1){
                $this->view->users=$this->user_model->listUsers();
            }else{
                $this->view->error="You Can't access this without admin login";
            }
    }

    //////////delete User/////////////////
    public function deleteUserAction(){

        $userInfo = Zend_Auth::getInstance()->getStorage()->read();                        if(isset($userInfo))
                $isAdmin=$userInfo->is_admin;
                            
            if(Zend_Auth::getInstance()->hasIdentity() && $isAdmin == 1){
                $id = $this->getRequest()->getParam('id');
                if($id){
                    if($this->user_model->deleteUser($id)){
                        $this->redirect('users/list');
                    }
                }
            }else{
                $this->view->error="You Can't access this without admin login";
            }
    }

    ////update user///////////////////////
    public function updateUserAction()
    {
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();                        if(isset($userInfo))
                $isAdmin=$userInfo->is_admin;
                            
            if(Zend_Auth::getInstance()->hasIdentity() && $isAdmin == 1){

                if($this->getRequest()->isPost()){

                    $id = $this->getRequest()->getParam('id');
                    $data = $this->getRequest()->getParams();
                    $this->user_model->editUser($id,$data);
                    $this->redirect('users/list');
                    
                }else{

                    $id = $this->getRequest()->getParam('id');
                    $form = new Application_Form_User();
                    $user = $this->user_model->getUserById($id);
                    $form->populate($user[0]);
                    $this->view->form = $form;

                    $this->render('update-user');
                }
            }else{
                $this->view->error="You Can't access this without admin login";
            }
        
    }



    public function setBanAction(){
        $id=$this->_getParam('id');

        $this->user_model->updateElement($id,'1','is_banned');

        $this->redirect('/users/list');
    }

    public function setDeBanAction(){
        $id=$this->_getParam('id');

        $this->user_model->updateElement($id,'0','is_banned');

        $this->redirect('/users/list');
    }
}
}
