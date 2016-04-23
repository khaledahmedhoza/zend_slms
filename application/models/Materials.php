<?php

class Application_Model_Materials extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'materials' ;

	function listDocuments($course_id){
		$dba = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dba->select()->from("materials")->where("course_id=$course_id");
		return $result = $dba->query($select)->fetchAll();
	}

	//return the document
	function getDocument($course_id,$doc_no){
		$dbd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $dbd->select()->from("materials")->where("course_id=$course_id and doc_no=$doc_no");
		return $result = $dbd->query($select)->fetchAll();
	}
	
	function getCourseMaterials($course_id){
		$cour = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $cour->select()->from("materials")->where("course_id=$course_id ");
		return $result = $cour->query($select)->fetchAll();
	}

	function deleteDocument($id){
		$this->delete("id=$id");
	}

	function addNewDocument($docno,$courseid,$path){
		$data['material'] = $path;
		$data['course_id'] = $courseid;
		$data['doc_no'] = $docno;
		 $this->insert($data);
	}

}

