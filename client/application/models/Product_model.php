<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model
{

    private $table_product = 'vt_product';
	
	function getProduct($pid=0){
		$this->db->select ( '*' );
		$this->db->from($this->table_product);
		if($pid){
			$this->db->where(array('pid'=>$pid));
		}
		$query = $this->db->get();
		return $query->row_array();
	}
}	