<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		/*$this->load->model('emp_model','emp_attribute');
		date_default_timezone_set('Asia/Jakarta');*/
	}
	public function index()
	{	//jika 
		/*if ($this->auth->is_logged_in()== false) {
			$this->login();
		}
		else
		{
			redirect('home/home');
		}*/
		
		$data['title'] = 'Login to HRIS';
		$this->load->view('v_login',$data);
		
	}

	public function login()
	{
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		if ($username == 'gandhi' and $password == 'ganteng') {
			$this->restrict();
		}
	else{
		redirect('login');
	}

		
	}

	public function restrict()
	{
		//$this->_validate();
		redirect('home');
	}
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'username name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'password Status is required';
			$data['status'] = FALSE;
		}

		
	}

}