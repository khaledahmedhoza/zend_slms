<?php

class Application_Form_Courses extends Zend_Form
{

    public function init()
    {
    	// $this->setAttrib('enctype', 'multipart/form-data');


        $id = new Zend_Form_Element_Hidden("id");

		$coursename = new Zend_Form_Element_Text("course_name");
		$coursename->setRequired();
		$coursename->addValidator(new Zend_Validate_Alpha());
		$coursename->setlabel("Course Name:");
		$coursename->setAttrib("class","form-control");
		// $coursename->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );

		$coursedesc = new Zend_Form_Element_Text("course_desc");
		$coursedesc->setRequired();
		$coursedesc->setlabel("Course Description:");
		$coursedesc->setAttrib("class","form-control");
		// $coursedesc->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );


		$duration = new Zend_Form_Element_Text("duration");
		$duration->setRequired();
		$duration->setlabel("Course Duration:");
		$duration->setAttrib("class","form-control");
		$duration->addValidator('regex', false, array('/^[0-9]/'));
		// $duration->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );

		$language = new Zend_Form_Element_Text("language");
		$language->setRequired();
		$language->setlabel("Language:");
		$language->setAttrib("class","form-control");
		$language->addValidator(new Zend_Validate_Alpha());
		// $language->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );

		$skilllevel = new Zend_Form_Element_Text("skill_level");
		$skilllevel->setRequired();
		$skilllevel->setlabel("Skill Level:");
		$skilllevel->setAttrib("class","form-control");
		$skilllevel->addValidator(new Zend_Validate_Alpha());
		// $skilllevel->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );

		$instructor = new Zend_Form_Element_Text("instructor");
		$instructor->setRequired();
		$instructor->setlabel("Instructor:");
		$instructor->setAttrib("class","form-control");
		$instructor->addValidator(new Zend_Validate_Alpha());
		// $instructor->setDecorators(
  //           $this->getBootstrapDecorator()
  //       );
        //$category = new Zend_Form_Element_Multiselect("category");
        
        $this->addElement(new Application_Form_Element_CategorySelect('category_id'));
        //$this->setlabel("Select Category:");

        // image Input
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Course image');
        $image->setAttrib('class', 'form-control');
        $image->setDestination('/var/www/html/zendProject/zend_slms/upload');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'btn btn-primary');

		$this->addElements(array($id,$coursename,$coursedesc,$language,$skilllevel,$duration,$instructor,$image,$submit));
    }

    // private function getBootstrapDecorator()
    // {
    //     return array(
    //         'ViewHelper',
    //         'Description',
    //         'Errors',
    //         array(
    //             'Label',
    //             array(
    //                 'tag' => 'label',
    //                 'class' => 'control-label'
    //             )
    //         ),
    //         array(
    //             'HtmlTag',
    //             array(
    //                 'tag' => 'div',
    //                 'class' => 'form-group'
    //             )
    //         )
    //     );
    // }
}

class Application_Form_Element_CategorySelect extends Zend_Form_Element_Select {
    public function init() {
        $category = new Application_Model_Categories();
        // $oCountryTb = new Application_Model_Country();
        $this->addMultiOption(0, 'Select Category...');
        foreach ($category->fetchAll() as $cat) {
            $this->addMultiOption($cat['id'], $cat['category_name']);
        }
    }
}


