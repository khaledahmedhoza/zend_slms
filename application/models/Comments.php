<?php

class Application_Model_Comments extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'comments' ;
	
	function getCourseReviews($course_id){
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		 $select = $db->select()->from("comments")->where("course_id=$course_id");
		return $result = $db->query($select)->fetchAll();
	}

	function addComment($course_id,$comment_text,$user_info,$doc_no){
		$row = $this->createRow();
		$row->comment = $comment_text;
		$row->course_id = $course_id;
		$row->user_id = $user_info->id;
		$row->username = $user_info->username;
		$row->doc_no = $doc_no;
		return $row->save();
		
	}

	function getDocumentReviews($course_id,$doc_no){
		$dbd = Zend_Db_Table_Abstract::getDefaultAdapter();
		 $select = $dbd->select()->from("comments")->where("course_id=$course_id and doc_no=$doc_no");
		return $result = $dbd->query($select)->fetchAll();
	}

	function delComment($id){
		$this->delete("id=$id");
	}

	function updateComment($comment_id,$comment){
		$this->update($comment, "id=$comment_id");
	}

	function getComment($id){
		return $this->find($id)->toArray();
	}
}

