<?php

class AdminController extends Zend_Controller_Action
{

 	public function init(){
 		$this->user_model = new Application_Model_Users;

    }

    public function indexAction(){

    	$userName=$this->getRequest()->getParam('username');
    	
    	if(isset($userName)){
    		$admin = $this->user_model->isAdmin($userName);
    	}else{
    		$admin=0;
    	}
    		
    	
    	if(Zend_Auth::getInstance()->hasIdentity() && $admin == 1){
    		$this->redirect('/admin/admin');
    	}else{
    		echo "<h3>You Are not admin .. please login As Admin first</h3>";
    		$this->redirect('/users/login');
    	}
    }

    public function adminAction(){
    	$this->render("admin");
    }
}