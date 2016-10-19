<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('is_logged_in'))
{
	function is_logged_in() {
	
	    $CI =& get_instance();
	    $user = $CI->session->userdata('vkt_clientCustomer');
		if($user){
			return true;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('vkt_checkAuth'))
{
	function vkt_checkAuth() {
	    $CI =& get_instance();
		if($CI->router->method !='addtocart')
		{
			$user = $CI->session->userdata('vkt_clientUser');
			if(!$user){
				$CI->load->helper('url');
				redirect(site_url('login'));
			}else{
				return true;
			}
		}else{
			return true; // Allow addtocart function
		}
	}
}

if ( ! function_exists('vst_textDate'))
{
	function vst_textDate() {
		$currentUser=vst_getCurrentUser();
		$txt = $currentUser['username'].' ['.date("d/m/Y H:i:s").']';
		return $txt;
	}
}


if ( ! function_exists('vst_getCurrentCustomer'))
{
	function vst_getCurrentCustomer() {
	    $CI =& get_instance();
	    $user = $CI->session->userdata('vkt_clientCustomer');
		return $user;
	}
}
if ( ! function_exists('vst_FormatDate'))
{
	function vst_FormatDate($date,$formatDate="d-m-Y",$timeFormat="H:i:s",$time=true) {
		
		if($time)  
		{
			$formatDateTime=$formatDate.' '.$timeFormat;
		}else{
			$formatDateTime=$formatDate;
		}
		$valid_date = date($formatDateTime, strtotime($date));
		return $valid_date;
	}
}
if ( ! function_exists('vst_currentDate'))
{
	function vst_currentDate($time=true,$formatDate="Y-m-d",$formatTime="H:i:s") {
		if($time){
			$dateTime=date($formatDate.' '.$formatTime);
		}else{
			$dateTime=date($formatDate);
		}
		return $dateTime;
	}
}

if ( ! function_exists('starts_with'))
{
	function starts_with($haystack, $needle)
	{
		return substr($haystack, 0, strlen($needle))===$needle;
	}
}

if ( ! function_exists('vst_getIPAddress'))
{
	function vst_getIPAddress() {
		return $_SERVER['REMOTE_ADDR'];;
	}
}


if(!function_exists('message_flash')){
	function message_flash($message = '', $type = 'success'){
		$CI =& get_instance();
		$CI->session->set_flashdata('message_flashdata', array(
			'type' => $type,
			'message' => $message
		));
	}
}

if(!function_exists('vst_password')){
	function vst_password($msg){
		return md5($msg);
	}
}

if(!function_exists('vst_pagination')){
	function vst_Pagination(){
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '&laquo; ';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = ' &raquo;';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Trang sau &raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo; Trang trước';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
        $config['per_page'] =5;
        $config['page_query_string'] =true;
        $config['query_string_segment'] ="page";
		$config['base_url'] =vst_currentUrl();
		return $config;
	}
}

if(!function_exists('vst_showPrice')){
	function vst_showPrice($price)
	{
		/*$array = explode(".",$price);
		if(isset($array[1])){
			$price = number_format($array[0]).'.'.$array[1];
		}else{
			$price = number_format($array[0]);	
		}*/
		return number_format($price);
	}
}

if ( ! function_exists('getStoreText'))
{
	function getStoreText($store)
	{
		if($store =='1'){
			return "<span class='bold black'>Kho SG</span>";
		}else if($store =="0"){
			return "<span class='bold green'>Kho HN</span>";
		}else{
			return "<span class='bold red'>N/A</span";
		}
	}
}

if(!function_exists('vst_currentUrl')){
	function vst_currentUrl($withoutPage=true)
	{
		$CI =& get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
		$params=$CI->input->get();
		if(isset($params['page']) && $withoutPage)
			unset($params['page']);
		$http_query=http_build_query($params, '', "&");
		return $http_query ? $url.'?'.$http_query : $url;
	}
}

if(!function_exists('vst_filterData')){
	function vst_filterData($likeFields=array(),$whereFieldsDate=array(),$tablealias=array())
	{
		$CI =& get_instance();
		$params= $CI->input->get();
		//print_r($params);
		unset($params['page']);
		$filterData= array();
		if($params){
			foreach($params as $key=>$value){
				if($value!=''){
					$table_alias="";
					if(isset($tablealias[str_replace('filter_','',$key)]))
					{
						$table_alias= $tablealias[str_replace('filter_','',$key)];
					}
					if(in_array($key,$likeFields))
					{	
						$filterData[str_replace('filter_','',$key)]= array('value'=>trim($value),'condition'=>'like','tbalias'=>$table_alias);
					}
					elseif(in_array($key,$whereFieldsDate))
					{
						$filterData[str_replace('filter_','',$key)]= array('value'=>trim($value),'condition'=>'date','tbalias'=>$table_alias);
					}
					else
					{
						$filterData[str_replace('filter_','',$key)]= array('value'=>trim($value),'condition'=>'where','tbalias'=>$table_alias);
					}
				}
			}
		}
		return $filterData;
		
	}
}


if(!function_exists('vst_getData')){
	function vst_postData()
	{
		$CI =& get_instance();
		$params=$CI->input->post();
		$filterData=array();
		if($params){
			foreach($params as $key=>$value){
				if( $key!='save' && $key!='update' && $value!='' && $key!='updatepass'){
					$filterData[$key]  = $value;
				}
			}
		}
		return $filterData;
	}
}

if(!function_exists('vst_buildFilter')){
	function vst_buildFilter($filter)
	{
		$CI =& get_instance();
		if($filter){
			foreach ($filter as $key => $value) {
				if(!empty($value['tbalias']))
					{
						$key=$value['tbalias'].".".$key;
					}
                switch ($value['condition']) {
					
                   case 'like':
                        $query = $CI->db->like(array($key=>$value['value']));
                        break;
                   case 'where':
                       $query = $CI->db->where(array($key=>$value['value']));
                       break;
                   case 'date':
                   		if (strpos($key, 'startdate_') !== false) {
                   			$key=str_replace("startdate_","",$key);
                   			$query = $CI->db->where( $key.' >=',$value['value'] );
                   		}else if (strpos($key, 'enddate_') !== false) {
						  	$key=str_replace("enddate_","",$key);
							$query = $CI->db->where( $key.' <=',$value['value'] );
						}else{
							$query = $CI->db->where( $key.' ==',$value['value'] );
						}
                      
                   	   break;
                   default:
                       # code...
                     break;
               }
            }
		}
	}
}
if(!function_exists('vst_convertCartString')){
function vst_convertCartString($string)
	{
		$search = array("\'",'\"',"'",'"');
		$replace = array("?","?","?",'?');

		return str_replace($search, $replace, $string);

	}
}

if(!function_exists('get_setting_meta')){
function get_setting_meta($meta_key,$return_row=false)
	{
		$CI =& get_instance();
		$setting_table="settings";
		$CI->db->select("*");
		$CI->db->from($setting_table);
		$CI->db->where(array('meta_key'=>$meta_key));
		$query=$CI->db->get();
		$row=$query->row_array();
		if($row){
			if($return_row)
				return $row;
			return $row['meta_value'];
		}else{
			return false;
		}
	}
}

if(!function_exists('get_support_user')){
function get_support_user($cid)
	{
		$CI =& get_instance();
		$users_table="users";
		$custommers_table="customers";
		$CI->db->select($users_table.'.fullname ,'.$users_table.'.phone');
		$CI->db->from($users_table);
		$CI->db->join ($custommers_table, $custommers_table.'.uid = '.$users_table.'.uid');
		$CI->db->where(array(
						$custommers_table.'.cid'=>$cid));
		$query=$CI->db->get();
		$row=$query->row_array();
		return $row;
	}
}

if ( ! function_exists('getStatusOrder'))
{
	function getStatusOrder($status)
	{
		$statusText="<span class='chuaduyet'>Chưa duyệt</span>";
		switch($status)
		{
			case -1:
				$statusText="<span class='dahuy'>Đã hủy</span>";
				break;
			case 0:
				$statusText="<span class='chuaduyet'>Chưa duyệt</span>";
				break;
			case 1:
				$statusText="<span class='daduyet'>Đã duyệt</span>";
				break;
			case 2:
				$statusText="<span class='dathanhtoan'>Đã thanh toán - chờ mua hàng</span>";
				break;
			case 3:
				$statusText="<span class='damuahang'>Đã mua hàng</span>";
				break;
			case 4:
				$statusText="<span class='hangdave'>Hàng đã về - chờ giao hàng</span>";
				break;
			case 5:
				$statusText="<span class='daketthuc'>Đã kết thúc</span>";
				break;
			default:
				$statusText="<span class='chuaduyet'>Chưa duyệt</span>";
		}
		return $statusText;
	}
}

if ( ! function_exists('get_is_complain'))
{
	function get_is_complain($is_complain)
	{
		switch($is_complain)
		{
			case 0:
				$status="<span class='black'>Không có khiếu nại</span>";
				break;
			case 1:
				$status="<span class=''>Đang khiếu nại</span>";
				break;
			case 2:
				$status="<span class='blue'>Khiếu nại thành công</span>";
				break;
			case 3:
				$status="<span class='red'>Khiếu nại thất bại</span>";
				break;
			case 4:
				$status="<span class='black'>Khiếu nại đã hủy</span>";
				break;
		}
		return $status;
	}
}

// Hàm cho phần lịch sử giao dịch
if ( ! function_exists('get_method_Transaction'))
{
	function get_method_Transaction($value)
	{
		switch($value)
		{
			case 0:
				$value="Tiền mặt";
				break;
			case 1:
				$value="Chuyển khoản";
				break;	
		}
		return $value;
	}
}


if ( ! function_exists('get_type_Transaction'))
{
	function get_type_Transaction($value)
	{
		switch($value)
		{
			
			case 1:
				$value="Thanh toán đơn hàng";
				break;
			case 2:
				$value="Giảm trừ";
				break;	
		}
		return $value;
	}
}
if ( ! function_exists('get_status_Transaction'))
{
	function get_status_Transaction($value)
	{
		switch($value)
		{
			
			case -1:
				$value="Đã hủy";
				break;
			case 0:
				$value="Chưa duyệt";
				break;
			case 1:
				$value="Đã duyệt";
				break;
				
		}
		return $value;
	}
}
if ( ! function_exists('get_cart_number_items'))
{
	function get_cart_number_items($vkt_usercart)
	{
		if(empty($vkt_usercart)){ $value = 0; }
		else{
			$value = 0;
			foreach ($vkt_usercart as $key => $item) {
                foreach ($item['items'] as $k => $v) {
                    $value += ($v['item_quantity']);

                };
            }
		}
		  
		return $value;
	}
}
if ( ! function_exists('getCartData'))
{
	function getCartData($user_id=null)
	{
		$CI = get_instance();
		$CI->load->model('cart_model');
		return $CI->cart_model->getCartData();
	}
}

if ( ! function_exists('get_user_finance')){
	function get_user_finance(){
		$currentCustomer=vst_getCurrentUser();
		$cid  = $currentCustomer['cid']; 
		$CI = get_instance();
		$CI->load->model('order_model');
		$CI->load->model('transaction_model');
		$CI->load->model('ship_model');
		
		
		$user_credits=array(
			'tongthanhtoan'=>0,
			'tongthanhtoandonhang'=>0,
			'tongthanhtoanvandon'=>0,
			'tonggiamtru'=>0,
			
			'tongtienhangchuave'=>0,
			'tongtienhang'=>0,
			'tongtienvandon'=>0,
			
			'notienvandon'=>0,
			'notienhang'=>0,
			
			'tongtienno'=>0,
		);
		$user_transactions=array();
		
		/*  Lay don hang */
		$info_Order = $CI->order_model->findOrder($params_where = array( 'cid'=>$cid ,'status >='=>2),$isList=true );
		if( $info_Order ){
		  foreach ($info_Order as $key => $value) {
			 $total_price_by_order = $CI->order_model->getDetailOrder($value['invoiceid']);
			 
			 $user_transactions[strtotime( $value['create_date'] ).time().$key]=array(
																				'id'=>$value['id'],
																				'invoiceid'=>$value['invoiceid'],
																				'create_date'=>$value['create_date'],
																				'total_price'=>$total_price_by_order['order_summary']['total_price'] * $total_price_by_order['currency_rate'],
																				'status'=>$value['status'],
																				'type'=>3,
																				);
		  }
		}
		
		/* SHIP */
		$info_Invoice_Ship = $CI->ship_model->findInvoiceShip($params_where=array( 'cid'=>$cid ,'status >='=>1),$isList=true);
		if( $info_Invoice_Ship ){
		  foreach ($info_Invoice_Ship as $key => $value) {			 
			 $user_transactions[strtotime( $value['create_date'] ).time().$key]=array(
																				'id'=>$value['id'],
																				'invoiceid'=>$value['invoiceid'],
																				'create_date'=>$value['create_date'],
																				'total_price'=>$value['total_price'],
																				'status'=>$value['status'],
																				'type'=>4,
																				);
		  }
		}
		/* thanh toan */
		$info_Transaction = $CI->transaction_model->findTransaction($params_where=array( 'cid'=>$cid ,'status >='=>1 ) ,$isList=true);
		if( $info_Transaction ){
		  foreach ($info_Transaction as $key => $value) {
			 $user_transactions[strtotime( $value['create_date'] ).time().$key]=array(
																				'id'=>$value['id'],
																				'create_date'=>$value['create_date'],
																				'total_price'=>$value['amount'],
																				'status'=>$value['status'],
																				'type'=>$value['type'],
																				'ref_type'=>$value['ref_type'],
																				);
		  }
		}
		/* sap xep */
		ksort($user_transactions,SORT_DESC);

		/*
			1-	Thanh toán đơn hàng 
			2-	Giảm trừ
			3-	Nợ đơn hàng
			4-	Nợ vận đơn
			$user_credits=array(
				'tongthanhtoandonhang'=>0,
				'tongthanhtoanvandon'=>0,
				'tonggiamtru'=>0,
				
				'tongtienhangchuave'=>0,
				'tongtienhang'=>0,
				'tongtienvandon'=>0,
				'notienvandon'=>0,
				'notienhang'=>0,
				'tongtienno'=>0,
			);
		*/
	
		if($user_transactions)
		{
			foreach($user_transactions as $key=>$value)
			{
				/* Đã thanh tóan */
				if($value['type'] == 1)
				{
					
					
					if($value['ref_type'] == 1){
						$user_credits['tongthanhtoandonhang'] +=$value['total_price'];
					}
					if($value['ref_type'] == 2){
						
						$user_credits['tongthanhtoanvandon'] +=$value['total_price'];
					}
				}
				/* giảm trừ */
				if($value['type'] == 2)
				{
					$user_credits['tonggiamtru'] +=$value['total_price'];
					
				}
				
				/* Đơn hàng */
				if($value['type'] == 3)
				{
					$user_credits['tongtienhang'] +=$value['total_price'];
					
					/* tiền hàng chưa về */
					if($value['status'] == 2 || $value['status'] == 3)
					{
					  $user_credits['tongtienhangchuave'] +=$value['total_price'];
					}
				}
				
				/* vận đơn */
				if($value['type'] == 4)
				{
					$user_credits['tongtienvandon'] +=$value['total_price'];
				}
			}
		}
		
		/* tổng tiền hàng phải giảm đi tổng giảm trừ */
		$user_credits['tongtienhang']= $user_credits['tongtienhang'] - $user_credits['tonggiamtru'];
		/* --------- */
		$user_credits['tongthanhtoan']= $user_credits['tongthanhtoandonhang'] + $user_credits['tongthanhtoanvandon'];
		$user_credits['notienhang']= $user_credits['tongtienhang'] - $user_credits['tongthanhtoandonhang'];
		$user_credits['notienvandon']= $user_credits['tongtienvandon'] - $user_credits['tongthanhtoanvandon'];
		$user_credits['tongtienno']= $user_credits['notienhang'] + $user_credits['notienvandon'];
		return $user_credits;
		
	}
}
