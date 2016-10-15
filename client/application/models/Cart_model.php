<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends MY_Model
{

     private $table_orders = 'orders';
     private $table_seller = 'sellers';
     private $table_item = 'items';
     private $table_ship_only = 'ship_only';
     private $table_carts = 'carts';

     function __construct()
     {
          parent::__construct();
     }
	 
	 function createOrder($data)
	 {
		 return $this->_save(array(
               'table' => $this->table_orders,
               'data' => $data
          ));
	 }
	 /* convert old cart to new cart */
	 function convertCartData()
	 {
		 $sql="SELECt * FROM carts";
		 $query = $this->db->get($this->table_carts);
		 $cartdata=$query->result_array();
		 if($cartdata)
		 {
			 foreach($cartdata as $cart)
			 {
				 if($cart['user_id'])
				 {
					/* $dataItems=unserialize(stripslashes($cart['cart_data']));
					 $cartData=$this->getParseItem($dataItems['items']);
					 $data=array('cart_data'=>serialize( $cartData));
					 $params_where=array('id'=>$cart['id']);
					 $is_update = $this->_save(array(
                                        'table'        => $this->table_carts,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                    ));
					if(!$is_update){
						echo "ERROR :".$cart['id'];
					}*/
				 }else{
					/* $sql="DELETE FROM carts WHERE id=".$cart['id'];
					  $this->db->query($sql);
					  */
				 }
			 }
		 }
		 //print_r($cartdata);
		 
	 }
	 /* function for parse data from old cart */
	 function getParseItem($dataItems)
	 {
		 $vkt_cart=array();
		 if($dataItems)
		 {
			 foreach($dataItems as $key=>$product)
			 {
				 $product['item_note']=$product['comment'];
				 $product['item_quantity']=preg_replace("/[^0-9]/","",$product['item_quantity']);
				 unset($product['comment']);
				 $seller_id=trim($product['seller_id']);
				 $outer_id=$key;
				 if(isset($vkt_cart[$seller_id]))
							{
								if(isset($vkt_cart[$seller_id]['items'][trim($outer_id)]))
								{
									$vkt_cart[$seller_id]['items'][trim($outer_id)]['item_quantity'] +=$product['item_quantity'];
								}else{
									$vkt_cart[$seller_id]['items'][trim($outer_id)]=$product;
								}
								
							}else{
								$vkt_cart[$seller_id]['seller_id']=$product['seller_id'];
								$vkt_cart[$seller_id]['seller_name']=$product['seller_name'];
								$vkt_cart[$seller_id]['items'][trim($outer_id)]=$product;
								
							}
			 }
		 }
		 return $vkt_cart;
	 }
	 
	 function getCartData($user_id=null)
	 {
		if($user_id == null){
			$currentCustomer =  vst_getCurrentUser();
			$user_id=$currentCustomer['cid'];
		}
		$params_where=array('user_id'=>$user_id);
		$cartData = $this->_getwhere(array(
                    'table'        => $this->table_carts,
                    'param_where'  => $params_where
        ));
		if($cartData)
		{
			$cartDataDecode=unserialize(stripslashes($cartData['cart_data']));
			return $cartDataDecode;
		}else{
			$cartDataDecode=array();
			return $cartDataDecode;
		}
	 }
	 function haveCartData($user_id)
	 {
		 $sql="SELECT * FROM ".$this->table_carts." WHERE user_id=".$user_id;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	 }
	 function updateCartData($cartData,$user_id=null){
		if($user_id == null){
			$currentCustomer =  vst_getCurrentUser();
			$user_id=$currentCustomer['cid'];
		}
		$is_check=$this->haveCartData($user_id);
		if($is_check)
		{
			$data=array('cart_data'=>serialize($cartData));
			$params_where=array('user_id'=>$user_id);
			$is_save = $this->_save(array(
						'table'        => $this->table_carts,
						'data'         => $data,
						'param_where'  => $params_where
			));
		}else{
			$data=array('cart_data'=>serialize($cartData),'user_id'=>$user_id);
			$params_where=array('user_id'=>$user_id);
			$is_save = $this->_save(array(
						'table'        => $this->table_carts,
						'data'         => $data
			));
		}
	 }
	 
	 //Function for shiponly custommer
	 function createShipOnly($data)
	 {
		 return $this->_save(array(
               'table' => $this->table_ship_only,
               'data' => $data
          ));
	 }
	 
	function listShipOnly($filter)
	 {
		  vst_buildFilter($filter);
          //$query = $this->db->limit($total, $start);
          $query = $this->db->get($this->table_ship_only);
          return $query->result_array();
	 }
	 
	 function updateOnlyShip($data,$params_where){
           $ship = $this->_save(array(
                                        'table'        => $this->table_ship_only,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $ship;
       }
	 
	 
	 
	function checkInvoice($params_where){
      $result = $this->_getwhere(array(
                     'table'        => $this->table_orders,
                     'param_where'  => $params_where,
                     'list'=>true
      ));
      return $result;
	}
	 function createSeller($data)
	 {
		 return $this->_save(array(
               'table' => $this->table_seller,
               'data' => $data
          ));
	 }
	 function insertItem($data)
	 {
		 return $this->_save(array(
               'table' => $this->table_item,
               'data' => $data
          ));
	 }
	 
	
	 
	 
	 
     /*
          Function findUser
          param_where = array(fieldName=>fieldValue)
     */
     function findUser($params_where){
           $user = $this->_getwhere(array(
                    'table'        => $this->table_users,
                    'param_where'  => $params_where
        ));
          return $user;
       }

     function updateUser($data,$params_where){
           $user = $this->_save(array(
                                        'table'        => $this->table_users,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $user;
       }

     function insertUser($data){
          return $this->_save(array(
               'table' => $this->table_users,
               'data' => $data
          ));
     }

     function deleteUser($params_where){
          return $this->_del(array(
               'table'        => $this->table_users,
               'param_where'  => $params_where
          ));
     }

     function listUser($filter,$total,$start){
          vst_buildFilter($filter);
          $query = $this->db->limit($total, $start);
          $query = $this->db->get($this->table_users);
          return $query->result_array();
     }

     function totalUser($filter){
          vst_buildFilter($filter);
          $query = $this->db->get($this->table_users);
          return $query->num_rows();
     }

     function lastLogin($uid){
          $ip=vst_getIPAddress();
          $date=vst_currentDate();
          $data = array(
                         'lastlogin'  => $date,
                         'ip'         => $ip,
                         'lastlogin ' => $date
                      );
          $params_where = array( 'uid' => $uid );
          return $this->updateUser($data,$params_where);
     }
	 function listall_order($cid){
		 $params_where = array( 'cid' => $cid );
		 $query = $this->db->get($this->table_orders);
		 return $query->num_rows();
	 }
}

?>
