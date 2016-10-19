<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("cart_model");
	}

	public function index(){
		$current_customer = vst_getCurrentCustomer();
		$data['array_product'] = $this->cart_model->getCartData($current_customer['cid']);
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
		);
		$current_customer = vst_getCurrentCustomer();
		$result = $this->cart_model->updateCartData($array_product,$current_customer['cid']);
		if($result){
			echo 'Da them thanh cong';
		}else{
			echo 'Chua them thanh cong';
		}
		$data['array_product'] = $this->cart_model->getCartData($current_customer['cid']);
		//$array_customer = ;
		$data['template'] = 'cart/cart';
		$this->load->view('layout/home', $data);
	
	}
	
	public function checkout(){
		$arr_id = $this->input->post('checkbox[]');
	}
	
	
}
