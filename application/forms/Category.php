<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {

        $this->setAttrib('enctype', 'multipart/form-data');
        $id = new Zend_Form_Element_Hidden("id");

		$categoryname = new Zend_Form_Element_Text("category_name");
		$categoryname->setRequired();
		$categoryname->addValidator(new Zend_Validate_Alpha());
		$categoryname->setlabel("Category Name:");
		$categoryname->setAttrib("class","form-control");

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'btn btn-primary');

		$this->addElements(array($id,$categoryname,$submit));
    }
}    