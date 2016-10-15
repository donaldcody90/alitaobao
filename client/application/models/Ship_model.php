<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ship_model extends MY_Model
{

     private $table_orders = 'orders';
     private $table_customers = 'customers';
     private $table_ships = 'ships';
     private $table_settings = 'settings';
     private $table_invoice_ships = 'invoice_ships';
     private $table_store_ships = 'store_ships';
     private $table_users = 'users';
     private $table_transactions = 'transactions';

     function __construct()
     {
          parent::__construct();
     }

   function listInvoiceShips($filter=array(),$total=0,$start=0){
      vst_buildFilter($filter);
      $query = $this->db->select ($this->table_invoice_ships.'.*,'.$this->table_customers.'.*,'.$this->table_invoice_ships.'.note as note_invoiceShips ');
      $query = $this->db->from($this->table_invoice_ships);
      $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_invoice_ships.'.cid');
      $query = $this->db->order_by($this->table_invoice_ships.'.id', 'desc'); 
      $query = $this->db->limit($total, $start);
      $query = $this->db->get();

      $list = $query->result_array();
      return $list;
   }

   function totalInvoiceShips($filter=array()){
      vst_buildFilter($filter);
      $query = $this->db->select ($this->table_invoice_ships.'.*,'.$this->table_customers.'.*');
      $query = $this->db->from($this->table_invoice_ships);
      $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_invoice_ships.'.cid');
      $query = $this->db->get();

      $list = $query->num_rows();
      return $list;
   }

  function findInvoiceShip($param_where,$isList=false){
    $result = $this->_getwhere(array(
                   'table'        => $this->table_invoice_ships,
                   'param_where'  => $param_where,
                   'list'=>$isList
    ));
    return $result;
  }
  function detailInvoiceShip($refid = ''){
		
		$query = $this->db->select ('*,SUM(amount) as total_paid');
        $query = $this->db->from($this->table_transactions);
        if($refid){
			$query = $this->db->where(array('refid'=>$refid));
		}
		$query = $this->db->group_by('refid');
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
   
    
   //Kiem tra tên vận đoen xem vận đơn có trong bảng invoice_ships
   function checkInvoice($params_where){
      $result = $this->_getwhere(array(
                     'table'        => $this->table_invoice_ships,
                     'param_where'  => $params_where,
                     'list'=>true
      ));
      return $result;
   }

  function insertInvoiceShips($data,$params_where){
         $result = $this->_save(array(
                                      'table'        => $this->table_invoice_ships,
                                      'data'         => $data,
                                      'param_where'  => $params_where
                                 ));
        return $result;
   }

    function getShips($oid=''){
      if( $oid!='' ){
        $param_where  = array('oid'=>$oid);
      }else{
        $param_where  = array();
      }
      $result = $this->_getwhere(array(
                     'table'        => $this->table_ships,
                     'param_where'  => $param_where,
                     'list'=>true
      ));
      return $result;
    }

    function getCustomer_by_id($oid){
      $query = $this->db->select ($this->table_orders.'.cid,'.$this->table_customers.'.*,');
      $query = $this->db->from($this->table_orders);
      $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
      $query = $this->db->where ( array($this->table_orders.'.id'=>$oid) );
      $query = $this->db->get();
      $result =  $query->row_array();
      return $result;
    }

    function getShip_undefined($total=0,$start=0){

      $query = $this->db->query("select store_ships.*,users.username from store_ships  inner join users  on store_ships.cn_receive_uid=users.uid where store_ships.shipid not in (select shipid from ships) order by store_ships.id limit ".$start.",".$total);
      $result = $query->result_array();
      return $result;
    }

    function totalShip_undefined(){

      $query = $this->db->query("select store_ships.*,users.username from store_ships  inner join users  on store_ships.cn_receive_uid=users.uid where store_ships.shipid not in (select shipid from ships) order by store_ships.id");
      $result = $query->num_rows();
      return $result;
    }

   function updateShipid($data,$params_where){
        return $this->_save(array(
             'table' => $this->table_ships,
             'data' => $data,
             'field_where_in'=>'shipid',
             'param_where_in'  => $params_where
        ));
   }
 
    function findStoreShip($params_where,$is_list=false){
		 $user = $this->_getwhere(array(
                    'table'        => $this->table_store_ships,
                    'param_where'  => $params_where,
                    'list'         => $is_list
        ));
		return $user;
	}
   function search_transport_id($filter){
		vst_buildFilter($filter);
		$query = $this->db->select($this->table_store_ships.'.*');
		$query = $this->db->from($this->table_store_ships);
		$query = $this->db->get();
		$data_cn =  $query->row_array();
		
		if($data_cn){
			vst_buildFilter($filter);
			$query = $this->db->select($this->table_ships.'.*');
			$query = $this->db->from($this->table_ships);
			$query = $this->db->get();
			$data_vn =  $query->row_array();
		}
		if($data_vn){
			$result = array(
				'data_cn'=>$data_cn,
				'data_vn'=>$data_vn,
			);
			return $result;
		}else{
			return $data_cn;
		}
		
   }

}

?>
