<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("order_model");
	}

	public function index(){
		$this->load->view('layout/home', $data);

	}
	
	// Detail Order
	public function detail(){
		$data['template'] = 'order/detail';
		$this->load->view('layout/home', $data);
	}
	
	
}
