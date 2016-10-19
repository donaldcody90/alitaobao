<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("cart_model");
	}

	public function index(){
		$data['template'] = 'cart/cart';
		$this->load->view('layout/home', $data);

	}
	
	// Detail Order
	public function addToCart(){
		$array_product = array(
			'id' => $this->input->post('pid');
			'pname' => $this->input->post('pname');
			'pimage' => $this->input->post('pimage');
			'plink' => $this->input->post('plink');
		);
		$current_customer = vst_getCurrentCustomer();
		$array_customer = ;
		$data['template'] = 'cart/cart';
		$this->load->view('layout/home', $data);
	}
	
	
}
