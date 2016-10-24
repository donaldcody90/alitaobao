<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("category_model");
	}
	
	public function index(){
		$data['template'] = 'category/category';
		$this->load->view('layout/home', $data);
	}
	
	// Show all product in one Category
	public function category(){
		$cat_id = $this->input->get('cat_id'); 
		
		$list_product = $this->category_model->getAllProduct($cat_id);
		$data['list_product'] = $list_product;
		$data['template'] = 'category/category';
		$this->load->view('layout/home', $data);
	}
}
?>	