<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends MY_Model
{

    private $table_category = 'vt_category';
    private $table_product = 'vt_product';
	
	function getCategoryTree($cat_id=0){
		$this->db->select ( '*' );
		$this->db->from($this->table_category);
		if($cat_id){
			$this->db->where(array('id'=>$cat_id));
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function getAllProduct($cat_id=0){
		$this->db->select ( '*' );
		$this->db->from($this->table_product);
		if($cat_id){
			$this->db->where(array('cat_id'=>$cat_id));
		}
		$query = $this->db->get();
		return $query->result_array();
	}
}	