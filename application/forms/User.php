<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
  
    	$this->setAttrib('class', 'form-horizontal'); // Bootstrap Form
    	$this->setAttrib('enctype', 'multipart/form-data');


        $id= new Zend_Form_Element_Hidden('id');

        $name= new Zend_Form_Element_Text('name');
        $name->addValidator(new Zend_Validate_Alpha(array('allowwhitespace' => true)));
        $name->addValidator('StringLength', false, array(6, 20));
        $name->setRequired(true);
        $name->addValidator('regex', false, array('/^[a-zA-Z ]/'));



        // $name->setLabel("Name :-");
        $name->setAttrib("placeholder","enter your name");
        $name->setAttrib('class', 'form-control');
        $name->setDecorators(
            $this->getBootstrapDecorator()
        );

		$Username= new Zend_Form_Element_Text('username');
        $Username->setRequired(true);
       
        // $name->setLabel("Name :-");
        $Username->setAttrib("placeholder","enter your Username");
        $Username->setAttrib('class', 'form-control');
        $Username->setDecorators(
            $this->getBootstrapDecorator()
        );
        $Username->addValidator(new Zend_Validate_Db_NoRecordExists(
        	array(
        		'table' => 'users',
        		'field' => 'username'
        		)
        	));

        $password= new Zend_Form_Element_Password('password');
		$password->setRequired(true);
        // $password->addValidator(new Zend_Validate_Alpha());
        $password->addValidator(new Zend_Validate_StringLength(
        	array(
        		'min'=>5 ,
        		'max'=>10
        		)
        	));

        // $password->setLabel("Password :-");
        $password->setAttrib("placeholder","enter your password");
      	$password->setAttrib('class', 'form-control');
        $password->setDecorators(
            $this->getBootstrapDecorator()
        );


        $email= new Zend_Form_Element_Text('email');
		$email->setRequired(true);
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->addValidator(new Zend_Validate_Db_NoRecordExists(
        	array(
        		'table' => 'users',
        		'field' => 'email'
        		)
        	));
        // $email->setLabel("Email :-");
        $email->setAttrib("placeholder","enter your email");  
        $email->setAttrib('class', 'form-control');
        $email->setDecorators(
            $this->getBootstrapDecorator()
        );

 		$age= new Zend_Form_Element_Text('age');
        $age->setRequired();
        // $age->addValidator('Digit');

        // $age->setLabel("Age :-");
        $age->setAttrib("placeholder","enter your age");
        $age->setAttrib("type","number");
        $age->setAttrib('class', 'form-control');
        $age->setDecorators(
            $this->getBootstrapDecorator()
        );

       // image Input
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Upload Your image');
        $image->setAttrib('class', 'form-control');
        $image->setDestination('/var/www/html/slms/upload');
        


        $submit= new Zend_Form_Element_Submit('Submit');
        // $submit->setAttrib('class', 'form-control');
        $submit->setAttrib('class', 'btn btn-primary');
        // $submit->setDecorators(
        //     $this->getBootstrapDecorator()
        // );

         $this->addElements(array($id,$name,$Username, $password,$age,$email, $image, $submit));
    }

    private function getBootstrapDecorator()
    {
        return array(
            'ViewHelper',
            'Description',
            'Errors',
            array(
                'Label',
                array(
                    'tag' => 'label',
                    'class' => 'control-label'
                )
            ),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div',
                    'class' => 'form-group'
                )
            )
        );
    }

}

