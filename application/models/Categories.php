<?php

class Application_Model_Categories extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name= 'categories';


	function getCatId ($data){
		$category=$data['category_name'];
		$select = $this->select('id')->where('category_name LIKE ? ',$category.'%');

		return $this->fetchAll($select);

	}

	function listCat(){

		return $this->fetchAll()->toArray();
	}

	function addCat ($data){
		// $row->category_name = $data['cat'];
		// return $row->save();

		if (isset($data['module']))
				unset($data['module']);
			if (isset($data['controller']))
				unset($data['controller']);
			if (isset($data['action']))
				unset($data['action']);
			if (isset($data['submit']))
				unset($data['submit']);

			$this->insert($data);
	}	

	function deleteCat($id){
		return $this->delete('id='.$id);
	}
	function getCatById($id){
		return $this->find($id)->toArray();
	}

	function updateCat($data , $id){
		$arr = array(
			  'category_name' => $data['category_name']
		    );
		$id=$data['id'];
		$this->update($arr,'id ='.$id);
	}

}

