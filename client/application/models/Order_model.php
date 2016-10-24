<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model
{

     private $table_orders = 'vt_order';
     private $table_customers = 'vt_customer';
     private $table_items = 'vt_order_item';
     private $table_seller = 'vt_order_seller';

     function __construct()
     {
          parent::__construct();
     }

	 // List Order
     function listOrder($filter=array(),$total=0,$start=0){
          vst_buildFilter($filter);
          $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.username,'.$this->table_customers.'.address,'.$this->table_customers.'.fullname,'.$this->table_customers.'.phone,'.$this->table_customers.'.email');
          $query = $this->db->from($this->table_orders);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->order_by($this->table_orders.'.id', 'desc'); 
          
          $query = $this->db->limit($total, $start);
          $query = $this->db->get();

          $records = $query->num_rows();
          $list = $query->result_array();
          /*
		  if($list)
          {
               foreach($list as $key=>$order){
                 $items=$this->getItems($order['id']);
                 $sellers=$this->getSellers($order['id']);
                 $list[$key]['order_summary']=$this->get_Order_Seller_Summary($order,$items,$sellers);
               }
          }
		  */	
          $results = array( 'list'=> $list,'records'=> $records );
          return $results;
     }

    function totalOrder($filter){
        vst_buildFilter($filter);
        $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.*');
        $query = $this->db->from($this->table_orders);
        $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
        $query = $this->db->get();
		return $query->num_rows();
    }

	/*
    lấy danh sách sản phẩm trong một đơn hàng hoặc người bán
   */
   function getItems($oid,$sid=0)
   {
    $this->db->select ( '*' );
    $this->db->from($this->table_items);
    $this->db->where(array('oid'=>$oid));
    if($sid){
      $this->db->where(array('sid'=>$sid)); 
    }
    $query = $this->db->get();
    $res = $query->result_array();
    return $res;
   }
   /*
    lấy danh sách người bán trong 1 đơn hàng
   */
   function getSellers($oid)
   {
    $this->db->select ( '*' );
    $this->db->from($this->table_sellers);
    $this->db->where(array('oid'=>$oid));
    $query = $this->db->get();
    $sellers =  $query->result_array();
    return $sellers;
   }
}

?>