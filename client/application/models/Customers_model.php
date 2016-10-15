<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends MY_Model
{

     private $table_customers = 'vt_customer';
    

     function __construct()
     {
          parent::__construct();
     }
       /*
          Function findUser
          param_where = array(fieldName=>fieldValue)
       */
     function findCustomer($params_where){
           $customer = $this->_getwhere(array(
                    'table'        => $this->table_customers,
                    'param_where'  => $params_where
        ));
          return $customer;
       }

     function updateCustomer($data,$params_where){
           $customer = $this->_save(array(
                                        'table'        => $this->table_customers,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $customer;
       }

     function insertCustomer($data){
          return $this->_save(array(
               'table' => $this->table_customers,
               'data' => $data
          ));
     }

     function deleteCustomer($params_where){
          return $this->_del(array(
               'table'        => $this->table_customers,
               'param_where'  => $params_where
          ));
     }

     function listCustomer($filter,$total,$start){
          vst_buildFilter($filter);
          $query = $this->db->limit($total, $start);
          $query = $this->db->get($this->table_customers);
          return $query->result_array();
     }

     function totalCustomer($filter){
          vst_buildFilter($filter);
          $query = $this->db->get($this->table_customers);
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
          return $this->updateCustomer($data,$params_where);
     }

}

?>
