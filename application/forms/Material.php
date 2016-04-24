<?php

class Application_Form_Material extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib('enctype', 'multipart/form-data');
        //$id = new Zend_Form_Element_Hidden("id");
        // $this->setMethod('post');
        //$this->setAttrib('class', 'form-horizontal'); // Bootstrap Form
    	
        

    	//material upload
    	$doc_path = new Zend_Form_Element_File('docpath');
    	$doc_path->setLabel('Upload Your document');
    	$doc_path->setAttrib('class', 'form-control');
    	$doc_path->setRequired();
    	$doc_path->addValidator(new Zend_Validate_Alpha());
	    $destination = APPLICATION_PATH.'/../public/upload';
    	$doc_path->setDestination($destination);

    	

        //document number
        $doc_no = new Zend_Form_Element_Text('doc_no');
        $doc_no->setRequired();
        $doc_no->addValidator(new Zend_Validate_Alpha());
        $doc_no->setAttrib("placeholder","enter document number");
        $doc_no->setAttrib('class', 'form-control');
        $doc_no->setDecorators(
            $this->getBootstrapDecorator()
        );

       


        $submit= new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'form-control');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setDecorators(
            $this->getBootstrapDecorator()
        );

        $this->addElements(array($doc_path,$doc_no, $submit));
    }

    private function getBootstrapDecorator()
    {
        return array(
            'ViewHelper',
            'Description',
            'Errors',
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

