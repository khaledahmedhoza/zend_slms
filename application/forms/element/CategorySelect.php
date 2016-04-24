<?php 

class Application_Form_Element_CategorySelect extends Zend_Form_Element_Select {
    public function init() {
    	$category = new Application_Model_Categories;
        // $oCountryTb = new Application_Model_Country();
        $this->addMultiOption(0, 'Please select...');
        foreach ($cat->fetchAll() as $cat) {
            $this->addMultiOption($cat['id'], $cat['category_name']);
        }
    }
}



?>