<?php

class Application_Form_Courses extends Zend_Form
{

    public function init()
    {

        $this->setAttrib('enctype', 'multipart/form-data');
        $id = new Zend_Form_Element_Hidden("id");

		$coursename = new Zend_Form_Element_Text("course_name");
		$coursename->setRequired();
		$coursename->addValidator(new Zend_Validate_Alpha());
		$coursename->setlabel("Course Name:");
		$coursename->setAttrib("class","form-control");


		$coursedesc = new Zend_Form_Element_Text("course_desc");
		$coursedesc->setRequired();
		$coursedesc->setlabel("Course Description:");
		$coursedesc->setAttrib("class","form-control");


		$duration = new Zend_Form_Element_Text("duration");
		$duration->setRequired();
		$duration->setlabel("Course Duration:");
		$duration->setAttrib("class","form-control");
		$duration->addValidator('regex', false, array('/^[0-9]/'));


		$language = new Zend_Form_Element_Text("language");
		$language->setRequired();
		$language->setlabel("Language:");
		$language->setAttrib("class","form-control");
		$language->addValidator(new Zend_Validate_Alpha());

    $type = new Zend_Form_Element_Text("type");
    $type->setRequired();
    $type->setlabel("Type:");
    $type->setAttrib("class","form-control");
    $type->addValidator(new Zend_Validate_Alpha());


		$skilllevel = new Zend_Form_Element_Text("skill_level");
		$skilllevel->setRequired();
		$skilllevel->setlabel("Skill Level:");
		$skilllevel->setAttrib("class","form-control");
		$skilllevel->addValidator(new Zend_Validate_Alpha());


		$instructor = new Zend_Form_Element_Text("instructor");
		$instructor->setRequired();
		$instructor->setlabel("Instructor:");
		$instructor->setAttrib("class","form-control");
		$instructor->addValidator(new Zend_Validate_Alpha());

        
    $this->addElement(new Application_Form_Element_CategorySelect('category_id'));

        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Course image');
        $image->setAttrib('class', 'form-control');
        $image->setDestination('/var/www/html/zendProject/zend_slms/upload');
        // $image->setDestination('/var/www/html/zendProject/zend_slms/upload');
        // ensure only one file
        // $image->addValidator('Count', false, 1);
        // // max 2MB
        // $image->addValidator('Size', false, 2097152)
        //       ->setMaxFileSize(2097152);
        // only JPEG, PNG, or GIF
        $image->addValidator('Extension', false, 'jpg,png,gif');
        $image->setValueDisabled(true);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'btn btn-primary');

		$this->addElements(array($id,$coursename,$coursedesc,$language,$skilllevel,$duration,$type,$instructor,$image,$submit));
    }
}

class Application_Form_Element_CategorySelect extends Zend_Form_Element_Select {
    public function init() {
        $category = new Application_Model_Categories();
        $this->addMultiOption(0, 'Select Category...');
        foreach ($category->fetchAll() as $cat) {
            $this->addMultiOption($cat['id'], $cat['category_name']);
        }
    }
}


