<?php

class Application_Model_Categories extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'categories';


	function getCatId ($data){
		$category=$data['category'];
		$select = $this->select('id')->where('category_name LIKE ? ',$category.'%');

		return $this->fetchAll($select);

	}

	function listCat(){

		return $this->fetchAll()->toArray();
	}

	function addCat ($data){
		$row->category_name = $data['cat'];
		return $row->save();
	}	

	function deleteCat($id){
		return $this->delete('id='.$id);
	}
	function getCatById($id){
		return $this->find($id)->toArray();
	}

	function updateCat($data , $id){
		$arr=$data['catName'];
		$this->update($arr, 'id ='.$id);
	}

}

