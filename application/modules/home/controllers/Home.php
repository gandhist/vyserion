<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model','m_notif');
		
		
	}
	public function index()
	{
		$hr = "hr";
		$ga = "ga";
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		/*else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}*/
	else {
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['title'] = 'Human Resources Information System';
		$this->load->view('temp/title',$data);
		
		   if ($this->ion_auth->in_group($hr)) {
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('content');
				$this->load->view('notif'); 
			}
			elseif($this->ion_auth->in_group($ga)){
				$this->load->view('temp/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('content');
				$this->load->view('vehicle/notif'); 
			}
		else
		{
			$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('content');
				/*$this->load->view('notif'); */	
		}

		}
	}

	public function cek_notif()
	{
		$data = $this->m_notif->notif();
		foreach ($data as $key) {
			$row [] = array();
			$row = $key->notif;
			
		}
		//echo '<pre>'; print_r($row);
		echo json_encode($row);
	}

	public function new_employee()
	{
		$data = $this->m_notif->karyawan_baru();
		foreach ($data as $key) {
			$row [] = array();
			$row = $key->jumlah;
			
		}
		//echo '<pre>'; print_r($row);
		echo json_encode($row);
	}

	public function list_notif_exp()
	{
		$no = 0;
		$list = $this->m_notif->list_notif_exp();
		$data = array();
		foreach ($list as $key) {
			$row = array();
			$row[] =  $key->empcode;
			$row[] =  $key->empname;
			$row[] =  $key->end_date;
			$row[] =  $key->due_date;
			$data[] = $row;
		
		}
		//echo '<pre>'; print_r($data);
		foreach ($data as $out) {
			$output = array(
			"empcode" => $data[$no][0],
			"empname" => $data[$no][1],
			"end_date" => $data[$no][2],
			"due_date" => $data[$no][3],
		);
			$no++;
			$a[] = $output;
		}
			echo json_encode($a);
		//echo '<pre>'; print_r($a);

		/*$output = array(
			"empcode" => $data[0][0],
			"empname" => $data[0][1],
			"end_date" => $row[0][2],
			"due_date" => $row[0][3],
		);*/
		//echo json_encode($output);
		//echo print_r($data);
	}

}
