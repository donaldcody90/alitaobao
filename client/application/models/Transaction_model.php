<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends MY_Model
{

     private $table_transactions = 'transactions';
     private $table_customers = 'customers';

     function __construct()
     {
          parent::__construct();
     }

     function findTransaction($params_where,$is_list=false){
          $transactions = $this->_getwhere(array(
                         'table'        => $this->table_transactions,
                         'param_where'  => $params_where,
                         'list'=>$is_list
          ));
          return $transactions;
    }

     function insertTransaction($data){
          return $this->_save(array(
               'table' => $this->table_transactions,
               'data' => $data
          ));
     }

     function listTransaction($filter=array(),$total=0,$start=0){
          vst_buildFilter($filter);
          $query = $this->db->select ($this->table_transactions.'.*,'.$this->table_customers.'.*');
          $query = $this->db->from($this->table_transactions);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_transactions.'.cid');
          $query = $this->db->order_by($this->table_transactions.'.id', 'desc'); 
          $query = $this->db->limit($total, $start);
          $query = $this->db->get();
          return $query->result_array();
     }

     function totalTransaction($filter=array()){
          vst_buildFilter($filter);
          $query = $this->db->select ($this->table_transactions.'.*,'.$this->table_customers.'.*');
          $query = $this->db->from($this->table_transactions);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_transactions.'.cid');
          $query = $this->db->get();
          return $query->num_rows();
     }

     function updateTransaction($data,$params_where){
          return $this->_save(array(
               'table' => $this->table_transactions,
               'data' => $data,
               'param_where'  => $params_where
          ));
     }
	
	

	
	
}

?>