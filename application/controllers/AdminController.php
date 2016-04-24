<?php

class AdminController extends Zend_Controller_Action
{

	    private $user_model = null;

	    private $material_model = null;

	    private $course_model = null;

	    private $comment_model = null;

	    private $category_model = null;

	    private $user_basket_model = null;

	    private $assoc_rules_model = null;

	    private $request_model = null;

	    public function init()
	    {
		/* Initialize action controller here */
			$this->user_model = new Application_Model_Users;
			$this->request_model = new Application_Model_Requests;
			$this->material_model = new Application_Model_Materials;
			$this->course_model = new Application_Model_Courses;
			$this->comment_model = new Application_Model_Comments;
			$this->category_model = new Application_Model_Categories;
		$this->user_basket_model = new Application_Model_Userbasket;
		$this->assoc_rules_model = new Application_Model_Assocrules;
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
	public function categoriesAction(){

		$catData=$this->category_model->listCat();
        $this->view->Data = $catData;   	

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

              if($form->isValid($data)){

                  if($form->getElement('image')->receive()){
                    $data['image'] = $form->getElement('image')->getValue();
                    $this->course_model->addCourse($data);
                    }
              }
   
        }

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

	
    public function materialsAction()
    {
        // action body
	$courses = $this->course_model->listCourses();
	$this->view->assign('courses',$courses);
    }

    public function showmaterialsAction()
    {
        // action body
	$course_id =  $this->_request->getParam('course_id');
	$materials = $this->material_model->getCourseMaterials($course_id);
	//$this->view->assign('mat',$materials);
	
		echo json_encode($materials);
	 die();
    }

    public function editmaterialAction()
    {
        // action body
        $form=new Application_Form_Material();
        $course_id = $this->_request->getParam('course_id');

        if($this->getRequest()->isPost()){

           $data = $this->_request->getParams();
            $doc_no = $data['doc_no'];
            $uploadedData = $form->getValues();
            $fullFilePath = $form->doc_path->getFileName();
            $path =$fullFilePath;
            $this->material_model->addNewDocument($doc_no,$course_id,$path);
            //$this->redirect('/');
        }else{
            $this->view->form=$form;
            $this->render();
        }
    }

    public function deletematerialAction()
    {
        // action body
	$doc_id = $this->_request->getParam('doc_id');
	$this->material_model->deleteDocument($doc_id);
	die();
    }

    public function showmaterialcommentsAction()
    {
        // action body
	$course_id =  $this->_request->getParam('course_id');
	$doc_no = $this->_request->getParam('doc_no');
	$comments = $this->comment_model->getDocumentReviews($course_id,$doc_no);
	echo json_encode($comments); die();

    }

    public function addnewcommentAction()
    {
        // action body
	$course_id = $this->_request->getParam('course_id');
	$comment = $this->_request->getParam('com');
	$doc_no = $this->_request->getParam('doc_no');

	$authorization = Zend_Auth::getInstance();
	$user_info = $authorization->getIdentity();

	$this->comment_model->addComment($course_id,$comment,$user_info,$doc_no);
	die();
    }

    public function deletecommentAction()
    {
        // action body
        $comment_id = $this->_request->getParam('com_id');
        $del_com= $this->comment_model->delComment($comment_id);
    }

    public function updatecommentAction()
    {
        // action body
        $comment_id = $this->_request->getParam('com_id');
        $comment = $this->_request->getParam('com');
        $com_arr = $this->comment_model->getComment($comment_id);
        $com_arr[0]['comment'] = $comment;
        //var_dump($com_arr); die();
        $this->comment_model->updateComment($comment_id,$com_arr[0]);
    }

    public function updaterecommendationAction()
    {
        //get the most played courses
        $courses = $this->course_model->getFreqCourses();

        //get list of users on system
        $users = $this->user_model->listAllUsers();

        //each user has list of courses  :  user_id=>(list of courses by id)
        for($i=0;$i<sizeof($users);$i++){
            $user_basket[$users[$i]['id']] = $this->user_basket_model->getUserCourses($users[$i]['id']);
            $basket = array();
            for($j=0;$j<sizeof($user_basket[$users[$i]['id']]);$j++){
                array_push($basket, $user_basket[$users[$i]['id']][$j]['course_id'] );
            }
            $user_basket[$users[$i]['id']] = $basket;
        }

        //get distinct pairs of courses
        $output = array();
        $all_pairs = array();
        for($i=0;$i<sizeof($users);$i++){
            
           for($j=0;$j<sizeof($user_basket[$users[$i]['id']]);$j++){

                $course_id_in_basket= $user_basket[$users[$i]['id']][$j];
                //var_dump($user_basket[$users[$i]['id']][$j]['course_id']);
                for($m=$j+1;$m<sizeof($user_basket[$users[$i]['id']]);$m++){

                    $other_course_in_basket=$user_basket[$users[$i]['id']][$m] ;
                    //$output[] = array($course_id_in_basket=>$other_course_in_basket) ;
                    $union = array( $course_id_in_basket , $other_course_in_basket ) ;
                    $union_hashed = md5(implode('', $union ) );

                    //check distinct
                    $distinct = 1 ;
                    for($dd=0;$dd<sizeof($output);$dd++){
                        if($output[$dd]== $union_hashed){
                            $distinct = 0;
                            break;
                        }
                    }
                    if($distinct) array_push($output, $union_hashed );
                    array_push($all_pairs, $union_hashed );

                   
                }
            }
        }
         //count pairs
                    for($a=0;$a<sizeof($output);$a++){
                        $first_time=1;
                        for($b=0;$b<sizeof($all_pairs);$b++){
                            if($output[$a]==$all_pairs[$b]){
                                if($first_time==0){
                                    $count[$output[$a]] += 1;
                                }else{
                                     $count[$output[$a]] = 1;
                                     $first_time =0;
                                }
                            }
                        }
                    }
//print_r($courses[0]['id']);
        //calculate confidence of pairs
        for($z=0;$z<sizeof($output);$z++){
            if($count[$output[$z]]<2){
                //echo $z."less";
               continue;
            }else{
                for($i=0;$i<sizeof($courses);$i++){
                    //echo $output[1];
                    for($j=$i+1;$j<sizeof($courses);$j++){
                         
                        if(md5(implode('', array($courses[$i]['id'],$courses[$j]['id']) ) ) == $output[$z]){
                            $confidence = $count[$output[$z]] / $courses[$i]['student_no'] ;
                            //echo $confidence;
                            //echo "<br>";
                            if($confidence > .3 ){
                                $final_result[$courses[$j]['id']] = $courses[$i]['id'];
                            } 
                        }
                    }
                }
            }
        }
     // print_r($final_result);
        $assoc_rules_table = $this->assoc_rules_model->updateTable($final_result);
    
    }

    public function viewrequestAction()
    {
        // action body
        $requests = $this->request_model->getRequests();
        $this->view->assign('req',$requests);
    }

}

