<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model
{

     private $table_users = 'users';
    

     function __construct()
     {
          parent::__construct();
     }
	  /*
		Function findUser
		param_where = array(fieldName=>fieldValue)
	  */
     function findUser($params_where,$is_list=false){
		 $user = $this->_getwhere(array(
                    'table'        => $this->table_users,
                    'param_where'  => $params_where,
                    'list'         => $is_list
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

     function listUser(){
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
	 
	 
	 
}

?>
