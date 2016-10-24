<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("cart_model");
		$this->load->model("customers_model");
	}

	public function index(){
		$current_customer = vst_getCurrentCustomer();
	
		$data['array_product'] = $this->cart_model->getCartData(1);
		var_dump($data['array_product']);
		$data['template'] = 'cart/cart';
		$this->load->view('layout/home', $data);
		
	}
	
	// Detail Order
	public function addToCart(){
		
		$array_product = array(
			'id' => $this->input->post('pid'),
			'name' => $this->input->post('name'),
			'image' => $this->input->post('image'),
			'link' => $this->input->post('link'),
			'price' => $this->input->post('price'),
			'qty' => $this->input->post('qty'),
			'sid' => $this->input->post('sid'),
		);
		$current_customer = vst_getCurrentCustomer();
		
		$cartdata = $this->cart_model->haveCartData($current_customer['cid']);
	
		if($cartdata != null){
			$cartdata_arr = unserialize(stripslashes($cartdata[0]['cartdata']));
			foreach($cartdata_arr as $key => $value){
				if($array_product['sid'] == $key){
					foreach($cartdata_arr[$key]['item'] as $key1=>$value1){
						if($array_product['id'] == $value1['id']){
							$cartdata_arr[$key]['item'][$key1]['qty'] = $cartdata_arr[$key]['item'][$key1]['qty'] + $array_product['qty'];
						}else{
							$cartdata_arr[$key]['item'][$array_product['id']] = $array_product;
						}
					}
				}else{
					$seller = vst_getSeller($array_product['sid']);
					$cartdata_arr[$array_product['sid']]['sid'] = $array_product['sid'];
					$cartdata_arr[$array_product['sid']]['seller_name'] = $seller['seller_name'];
					$cartdata_arr[$array_product['sid']]['item'][$array_product['id']] = $array_product;
				}
			}
		}else{
			$seller = vst_getSeller($array_product['sid']);
			$cartdata_arr  = array(
					$array_product['sid'] => array(	 
							'sid' => $array_product['sid'],
							'seller_name' => $seller['seller_name'],
							'item' => array(
								$array_product['id'] => $array_product,	
							),
						),
				);
		}
		$result = $this->cart_model->updateCartData($cartdata_arr,$current_customer['cid']);
		
		if($result){
			message_flash('Bạn đã thêm thành công!','success');
			redirect(site_url('cart'));
		}else{
			message_flash('Bạn chưa thêm thành công!','error');
			redirect(site_url('cart'));
		}
	
	}
	
	
	// Insert Order vào DB
	public function checkout(){
		
		$arr_id = $this->input->post('checkbox');
		$currentCustomer = vst_getCurrentCustomer();
		$vkt_cart = $this->cart_model->getCartData($currentCustomer['cid']);
	
		if($this->input->post('confirm_order')){
		$checkbox = $this->input->post('checkbox');
		if(count($checkbox)){
				//$vkt_cart = $this->session->userdata('vkt_cart');
				
				
				if(!count($vkt_cart)){
					message_flash('Giỏ hàng trống!','error');
					//redirect(site_url('cart'));
				}
				
				$seller_item_selected=array();
				foreach($checkbox as $checked_items){
					
						$temp=explode('{:::}',$checked_items);
						$seller_item_selected[$temp[0]]['items'][]=$temp[1];
				}
				
				if(!count($seller_item_selected))
				{
					message_flash('Bạn chưa chọn mua sản phẩm nào!','error');
					//redirect(site_url('cart'));
				}
				
				//$currentCustomer=vst_getCurrentUser();
				
				$username  = $currentCustomer['username'];				
				$invoiceid = $this->created_invoiceid($username);
				$params_where = array(
				  'cid'=> $currentCustomer['cid']
				);
			
				$customers = $this->customers_model->findCustomer($params_where);
				$fee_service_rate =get_setting_meta('fee_service_rate');
				
				if($customers['fee_service_rate'] > 0){
					$fee_service_rate=$customers['fee_service_rate'];
				}
				$currency_rate=get_setting_meta("currency_rate");
				
				$order_data=array(
					'cid'=>$currentCustomer['cid'],
					'invoiceid'=>$invoiceid,
					'create_date'=> vst_currentDate($time=true,$formatDate="Y-m-d",$formatTime="H:i:s"),
					'currency_rate'=>$currency_rate,
					'fee_service_percent'=>$fee_service_rate,
					'status'=> 1,
					'store' => 0
				);
			
				$oid=$this->cart_model->createOrder($order_data);
				if($oid){
					foreach($vkt_cart as $seller_id=>$sellers_info)
					{
						if(isset($seller_item_selected[$seller_id]) && count($seller_item_selected[$seller_id]['items'])){
							// Insert Seller Info
							$seller_data=array(
								'oid'=>$oid,
								'sellerid'=>$seller_id,
								'sellername'=>$sellers_info['seller_name']					
							);
							
							$items_selected=$seller_item_selected[$seller_id]['items'];
							
							$sid=$this->cart_model->createSeller($seller_data);
							
							if($sid)
							{
								 if(count($sellers_info['item']))
								 {
									 foreach($sellers_info['item'] as $outer_id=>$item)
									 {
										 if(in_array($outer_id,$items_selected))
										 {
											 $item_data=array(
												'oid'=>$oid,
												'sid'=>$sid,
												'item_id'=>$item['id'],
												'item_title'=>$item['name'],
												'item_image'=>$item['image'],
												'item_link'=>$item['link'],
												'item_price'=>$item['price'],
												'item_quantity'=>$item['qty'],
												'item_attrs'=>'',
												'item_note'=>'',
												
											);
											$new_item_id=$this->cart_model->insertItem($item_data);
											if($new_item_id){
												// unset when insert success
												unset($vkt_cart[$seller_id]['items'][$outer_id]);
											}
										 }
										 
									 }
								 }
									
							}
						}
					}
					foreach($vkt_cart as $seller_id=>$sellers_info)
					{
						if(!count($vkt_cart[$seller_id]['item']))
						{
							unset ($vkt_cart[$seller_id]);
						}
					}
					// Set again cart data
					//$this->session->set_userdata('vkt_cart',$vkt_cart);
					$this->cart_model->updateCartData($vkt_cart);
				}
				message_flash('Bạn vừa tạo thành công đơn hàng: '.$invoiceid,'success');
				redirect(site_url('order/lists'));
			}else{
				message_flash('Bạn chưa chọn mua sản phẩm nào!','error');
				redirect(site_url('cart'));
			}	
		
		}
		die();
		$arr['vkt_cart'] = $vkt_cart;
		$arr['fee_service_rate'] = $fee_service_rate;
		$arr['user'] = $currentCustomer;
		$this->load->view('layout/home', $arr);
	}
	
	public function created_invoiceid($username)
	{
		$i = 1;
		do {
		    $invoiceid = $username.'-'.vst_currentDate($time=false,$formatDate="Y-m-d",$formatTime="").'-'.$i;
		    $i++;
		} while ( $this->cart_model->checkInvoice( $params_where=array('invoiceid'=>$invoiceid) ) );

		return $invoiceid;
	}
	
	
}
