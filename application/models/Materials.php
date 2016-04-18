<?php

class Application_Model_Materials extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'materials' ;
	//$db = Zend_Db_Table_Abstract::getDefaultAdapter();
	//return list of documents
	function listDocuments($course_id){
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from("materials")->where("course_id=$course_id");
		return $result = $db->query($select)->fetchAll();
	}

	//return the document
	function getDocument($course_id,$doc_no){
		$dbd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dbd->select()->from("materials")->where("course_id=$course_id and doc_no=$doc_no");
		return $result = $dbd->query($select)->fetchAll();
	}

}

