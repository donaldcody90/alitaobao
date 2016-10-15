<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain_model extends MY_Model
{

     private $table_orders = 'orders';
     private $table_customers = 'customers';
     private $table_items = 'items';
     private $table_sellers = 'sellers';
     private $table_complain = 'complain';
     private $table_seller_note = 'seller_note';
     private $table_settings = 'settings';

     function __construct()
     {
          parent::__construct();
     }

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
    if($res)
    {
         foreach($res as $key=>$value){
           $res[$key]['complain']=$this->getComplain($value['id']);
         }
    }
    return $res;
   }
   
     function getComplain($oitem_id)
     {
      $this->db->select ( '*' );
      $this->db->from($this->table_complain);
      $this->db->where(array('oitem_id'=>$oitem_id));
      $query = $this->db->get();
      return $query->result_array();
     }

    function totalComplain($filter,$param=false){
        $query = $this->db->select ($this->table_items.'.*,'.$this->table_orders.'.invoiceid,'.$this->table_customers.'.store,'.$this->table_sellers.'.*');
        $query = $this->db->from($this->table_items);
        $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_items.'.oid');
        $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
        $query = $this->db->join ($this->table_sellers, $this->table_sellers.'.id = '.$this->table_items.'.sid');
        vst_buildFilter($filter);
		//$this->db->where($this->table_customers.'.cid',$cid);
        $query = $this->db->where_not_in($this->table_items.'.is_complain',0);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
     function listComplain($filter=array(),$total=0,$start=0){
		 
          $query = $this->db->select ($this->table_items.'.*,'.$this->table_orders.'.invoiceid,'.$this->table_customers.'.store,'.$this->table_sellers.'.sellerid',$this->table_sellers.'.sellername',$this->table_sellers.'.shopid',$this->table_sellers.'.fee_shipnd');
          $query = $this->db->from($this->table_items);
          $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_items.'.oid');
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->join ($this->table_sellers, $this->table_sellers.'.id = '.$this->table_items.'.sid');
          vst_buildFilter($filter);
		//$this->db->where($this->table_customers.'.cid',$cid);
          $query = $this->db->where_not_in($this->table_items.'.is_complain',0);
          $query = $this->db->limit($total, $start);
          $query = $this->db->get();
          $list = $query->result_array();
          if($list)
          {
               foreach($list as $key=>$value){
                 $list[$key]['complain']=$this->getComplain($value['id']);
               }
          }
          return $list;
     }
	
	/*
	function listComplain($filter=array(),$total=0,$start=0){
          $query = $this->db->select ($this->table_items.'.*,'.$this->table_orders.'.invoiceid,'.$this->table_customers.'.store,'.$this->table_sellers.'.shopid');
          $query = $this->db->from($this->table_items);
          $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_items.'.oid');
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->join ($this->table_sellers, $this->table_sellers.'.id = '.$this->table_items.'.sid');
          vst_buildFilter($filter);
          $query = $this->db->where_not_in($this->table_items.'.is_complain',0);
          $query = $this->db->limit($total, $start);
          $query = $this->db->get();
          $list = $query->result_array();
		  $list['sql'] = $this->db->last_query();
          if($list)
          {
               foreach($list as $key=>$value){
				   if(isset($value['id'])){
                 $list[$key]['complain']=$this->getComplain($value['id']);
				 }
               }
          }
          return $list;
     }
	*/
    function getComplainStatusSummury($filter){
      
      $complain_status_sum = $this->config->item('site')['complain_status'];
      $this->db->select ('is_complain, COUNT(*) as total_complain');
      $this->db->from ($this->table_items);
	  $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_items.'.oid');
      $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
	  vst_buildFilter($filter);
      $this->db->where_not_in($this->table_items.'.is_complain',0);
      $this->db->group_by('is_complain');
      $query = $this->db->get();
      $results=$query->result_array();
	//  print_r($results);
      $total_complain=0;
      if($results)
      { 
        foreach($results as $item)
        {
          $complain_status_sum[$item['is_complain']]['count']=$item['total_complain'];
          $total_complain +=$item['total_complain'];
        }
      }
      $complain_status_sum["-99"]['count']=$total_complain;
      unset($complain_status_sum["0"]);
      return $complain_status_sum;
	//  print_r($complain_status_sum);die();
    }

} 
?>
