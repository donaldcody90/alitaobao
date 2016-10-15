<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("customers_model");
	}

	public function index(){
		$data['template'] = 'customer/customer';
		$this->load->view('layout/home', $data);

	}
	
	// Profile Customer
	public function profile(){
		$customer = $this->session->userdata('vkt_clientCustomer');
		$data['customer'] = $customer;
		$data['template'] = 'customer/profile';
		$this->load->view('layout/home', $data);
	}
	// Change password
	
	
	public function changepass(){
		if (is_logged_in()) { 
			$customer = vst_getCurrentUser();
			$cusername  = $customer['cusername'];
		}
		$param_where = array('cusername'=>$cusername);
		if( $this->input->post('updatepass')){
			
			$this->form_validation->set_rules('currentpassword', 'Mật khẩu hiện tại', 'trim|required');
			$this->form_validation->set_rules('newpassword', 'Mật khẩu mới', 'trim|required|min_length[6]|matches[passconfirm]');
			$this->form_validation->set_rules('passconfirm', 'Nhập lại mật khẩu', 'trim');
			if ($this->form_validation->run()){
				
				$old_pass = vst_password($this->input->post('currentpassword'));
				$currentCustomer = $this->customers_model->findCustomer($param_where);
				if($old_pass == $currentCustomer['password']){
					$password  = vst_password($this->input->post('newpassword'));
					$data = array('password'=>$password);
					$result  =$this->customers_model->updateCustomer($data,$param_where);
					if($result >= 1){
					message_flash('Cập nhật mật khẩu thành công','success');
					}
					redirect(site_url('customer/changepass'));
				}else{
					message_flash('Mật khẩu hiện tại chưa đúng','errors');
					redirect(site_url('customer/changepass'));
				}
			}
		}
		$data['result']  = $this->customers_model->findCustomer($param_where);
        $data['template'] = 'customer/changepass';
		$this->load->view('layout/home', $data);
	}

	public function logout(){
		if($this->session->userdata('vkt_clientCustomer')){
			  $this->session->unset_userdata('vkt_clientCustomer');
		  }
		  $this->session->sess_destroy();
         redirect(site_url('auth'));
	}
}
