<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("customers_model");
	}

	public function index(){
		$data['template'] = 'auth/login';
		$this->load->view('layout/home', $data);
	}
	
	public function login()
	{
		if(is_logged_in()){
			redirect(site_url('customer/profile'));
		}else{
		
		if($this->input->post('login')){
			$param_where = array(
					'cusername'=>trim( $this->input->post('username') ),
					'password'=>vst_password( $this->input->post('password') ),
				);
			
			$result = $this->customers_model->findCustomer($param_where);
			
			if( count($result)>0 ){
				unset($result['password']);
				$this->session->set_userdata('vkt_clientCustomer',$result);
				redirect(site_url('customer/profile'));
				die();
			}else{
				message_flash('Tên đăng nhập hoặc mật khẩu không đúng. Xin vui lòng nhập lại','error');
				redirect(site_url('auth/login'));
			}
		}
		}
        $data['template'] = 'auth/login';
		$this->load->view('layout/home', $data);
	}
	
	public function register(){ 
	
		if(is_logged_in()){
			redirect(site_url('customer/profile'));
		}else{

		if ($this->input->post('save')){

			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|callback__username');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__email');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|is_natural');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|matches[passconf]');
			$this->form_validation->set_rules('passconf', 'Nhập lại mật khẩu', 'trim');
			
			if ($this->form_validation->run()){
				$data = array(
					'cusername' => trim($this->input->post("username")),
					'cfullname' => trim($this->input->post("fullname")),
					'cphone'    => trim($this->input->post("phone")),
					'cemail'    => trim($this->input->post("email")),
					'password' => vst_password($this->input->post("password")),
					'create_date'	=> vst_currentDate($time=true,$formatDate="Y-m-d",$formatTime="H:i:s"),
				);
				var_dump($data);
				$result = $this->customers_model->insertCustomer($data);
				if($result >= 1){
					message_flash('Thêm tài khoản '.$this->input->post('username').' thành công');
				}
				redirect(site_url('customer/profile'));
			}
		}
		}
       	$data['template'] = 'auth/register';
		$this->load->view('layout/home', $data);
	}

	// Forgot password
	public function forgotpass(){
		$data['template'] = 'auth/forgotpass';
		$this->load->view('layout/home', $data);
	}
	
	// Callback email
	public function _email($email = ''){
		$count = $this->customers_model->findCustomer(array('cemail'=>$email));
		if($count >= 1){
			$this->form_validation->set_message('_email', 'Email '.$email.' đã tồn tại');
			return FALSE;
		}
		return TRUE;
	}

	// Callback username
	public function _username($username = ''){
		$count = $this->customers_model->findCustomer(array('cusername'=>$username));
		if($count >= 1){
			$this->form_validation->set_message('_username', 'Tên đăng nhập '.$username.' đã tồn tại');
			return FALSE;
		}
		return TRUE;
	}

}
