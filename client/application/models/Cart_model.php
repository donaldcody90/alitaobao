<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends MY_Model
{

     private $table_orders = 'orders';
     private $table_seller = 'sellers';
     private $table_item = 'items';
     private $table_ship_only = 'ship_only';
     private $table_carts = 'vt_cart';

     function __construct()
     {
          parent::__construct();
     }
	
	 // Lay thong tin tu bang Cart
	 function getCartData($cid=null)
	 {
		if($cid == null){
			$currentCustomer =  vst_getCurrentCustomer();
			$user_id=$currentCustomer['cid'];
		}
		$params_where=array('cid'=>$cid);
		$cartData = $this->_getwhere(array(
                    'table'        => $this->table_carts,
                    'param_where'  => $params_where
        ));
		if($cartData)
		{
			$cartDataDecode=unserialize(stripslashes($cartData['cartdata']));
			return $cartDataDecode;
		}else{
			$cartDataDecode=array();
			return $cartDataDecode;
		}
	 }
	 
	 // Update san pham vao bang Cart
	 function updateCartData($cartData,$cid=null){
		if($cid == null){
			$currentCustomer =  vst_getCurrentCustomer();
			$cid=$currentCustomer['cid'];
		}
		$is_check=$this->haveCartData($cid);
		if($is_check)
		{
			$data=array('cartdata'=>serialize($cartData));
			$params_where=array('cid'=>$cid);
			$is_save = $this->_save(array(
						'table'        => $this->table_carts,
						'data'         => $data,
						'param_where'  => $params_where
			));
		}else{
			$data=array('cartdata'=>serialize($cartData),'cid'=>$cid);
			$params_where=array('cid'=>$cid);
			$is_save = $this->_save(array(
						'table'        => $this->table_carts,
						'data'         => $data
			));
		}
	 }
	 
	 function haveCartData($cid)
	 {
		 $sql="SELECT * FROM ".$this->table_carts." WHERE cid=".$cid;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	 }
	 
}

?>
