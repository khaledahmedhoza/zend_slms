<?php

class Application_Model_Assocrules extends Zend_Db_Table_Abstract
{

	/** Table name */
	protected $_name= 'assoc_rules' ;

	function updateTable($final_result){

		//delete all rows first
		$where = '1';
		$this->delete($where);

		//update table
		foreach ($final_result as $key => $value) {
			$row = $this->createRow();
			$row->y =$key;
			$row->x = $value;
			$row->save();
		}
	}

	function getRelatedCourses($yid){
		$dba = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dba->select()->from("assoc_rules","x")->where("y = $yid");
		return $result = $dba->query($select)->fetchAll();
	}


}

