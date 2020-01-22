<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/**
 * Description of Dashboard
 * @author IMAM SYAIFULLOH
 */
class Template extends MX_Controller
{
    public function __construct()
    {
     parent::__construct();
        $this->load->helper('form_helper');
        $this->load->helper('sidebar_helper');
        $this->load->model('template_model','menu');
		$this->load->model('hr/lov_model','lov');
     
    }
 
    public function index()
    {
     $data['title'] = 'Lesson HMVC Part 2';     
     $this->load->view('title',$data);     
     $this->load->view('header',$data);
     $this->load->view('sidebar',$data);
    }
 
    public function loadview()
    {

        $data['menu'] = $this->menu->get_menu();
        //$data['dd'] = $this->menu->get_dropdown($id_modul, $id_menu);

        $group = "ts";
		$logistic = "inv";
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$username = $obj_user->username;
		$data['username'] = $username;	
		$data['title'] = "Service Heavy Equipment";
		$data['dd_vehicle_code'] = $this->lov->dd_vehicle_op();
        $data['vehicle_code'] = $this->input->post('f_code_unit') ? $this->input->post('f_code_unit') : '';
        $data['dd_operator'] = $this->lov->dd_operator();
        $data['operator_code'] = $this->input->post('f_operator') ? $this->input->post('f_operator') : '';
        $data['dd_vendor'] = $this->lov->dd_vendor();
        $data['vendor_selected'] = $this->input->post('f_progress_by') ? $this->input->post('f_progress_by') : ''; 
			if ($this->ion_auth->in_group($group)) {
				$this->load->view('template/title',$data);
				$this->load->view('template/header');
				$this->load->view('template/sidebar_rev01', $data);
				$this->load->view('ts/f_breakdown');
				$this->load->view('ts/ajax_breakdown');
				$this->load->view('notif');
			}
			elseif($this->ion_auth->in_group($logistic))
			{
				$this->load->view('template/title',$data);
				$this->load->view('template/header');
				$this->load->view('template/sidebar');
				$this->load->view('ts/f_breakdown_log');
				$this->load->view('ts/ajax_breakdown_log');
				$this->load->view('notif');
			}
			else{
				return show_error('You must be an administrator to view this page.');
			}
		}
       
    }
}