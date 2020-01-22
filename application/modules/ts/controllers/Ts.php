<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpspreadsheet/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ts extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
        //$this->load->library('lib_log');
		$this->load->helper('form_helper');
		$this->load->helper('tanggal_input_helper');	
		$this->load->model('hr/lov_model','lov');
		$this->load->model('Breakdown_model','bd');
		$this->load->model('mttr_model','mttr');
		$this->load->model('daily_hm_model','hm');
		$this->load->model('production/hm_daily_model','pro');
		date_default_timezone_set('Asia/Jakarta');		
	}

	public function breakdown()
	{
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
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_breakdown');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_breakdown');
			}
			elseif($this->ion_auth->in_group($logistic))
			{
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_breakdown_log');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_breakdown_log');
			}
			else{
				return show_error('You must be an administrator to view this page.');
			}
		}
	}

	public function breakdown_v01()
	{
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
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_breakdown_v01');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_breakdown_v01');
			}
			elseif($this->ion_auth->in_group($logistic))
			{
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_breakdown_log');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_breakdown_log');
			}
			else{
				return show_error('You must be an administrator to view this page.');
			}
		}
	}

	public function add_vehicle_bd()
	{
		$this->_validate_add();
		$data = array(
				'inputdate' => $this->input->post('f_input_date'),
				'inputby' => $this->input->post('f_input_by'),
				'no_kwitansi' => $this->input->post('f_kwitansi'),
				'date_start' => date_input_datetime($this->input->post('f_date_bd')),
				'nap' => $this->input->post('f_code_unit'),
				'task' => $this->input->post('f_task'),
				'schedule' => $this->input->post('f_schedule'),
				'status_damage' => $this->input->post('f_damage'),
				/*'updatedate' => $this->input->post('f_schedule'),
				'updateby' => $this->input->post('f_damage'),*/
				'pm' => $this->input->post('f_pm'),
				'status_level' => $this->input->post('f_status_level'),
				'status_bd' => $this->input->post('status_bd_temp'),
				'status_parts_job' => $this->input->post('f_sts_part_job'),
				'progress_by' => $this->input->post('f_vendor'),
				'mechanic_name' => $this->input->post('f_mechanic'),
				'location' => $this->input->post('f_location'),
				'date_finish_estimate' => date_input_datetime($this->input->post('f_date_estimate')),
				'hm' => $this->input->post('f_hm'),
				'hm_start' => $this->input->post('f_hm_start'),
				'hm_finish' => $this->input->post('f_hm_finish'),
				'shift' => $this->input->post('f_shift'),
				'operator' => $this->input->post('f_operator'),
				'remarks_machine' => $this->input->post('f_remarks_machine'),
				'reason_bd' => $this->input->post('f_reason_bd'),
				'part_replacment' => $this->input->post('f_part'),
				'date_finished' => date_input_datetime($this->input->post('f_date_finish')),
				'no_pr_sr' => $this->input->post('f_pr'),
				'no_po' => $this->input->post('f_po'),
				'cost_estimate' => $this->input->post('f_cost_estimate'),
				'status_cost' => $this->input->post('f_status_cost'),
				'possible_work' => $this->input->post('f_pw'),
				'tdy' => $this->input->post('f_tdy'),
				'ma' => $this->input->post('f_ma'),
				'stand_by' => $this->input->post('f_stby'),
				'ua' => $this->input->post('f_ua'),
				'pa' => $this->input->post('f_pa'),
				'total_down_time' => $this->input->post('f_tdr'),
			);
		// model input ke database
		$this->bd->save($data);
		echo json_encode(array("status" => TRUE));

	}

	public function bd_list()
	{
		$date_now = date("Y-m-d H:i");
		$list = $this->bd->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->no_kwitansi;
			$row[] = $key->code_unit;
			$row[] = $key->nap;
			if (date_input_datetime($key->date_finish_estimate) < $date_now) {
			$row[] = '<span id="span_allowded_code" class= "label label-warning" >'.date_indonesia_datetime($key->date_start).'</span>';
			}
		else{
			$row[] = date_indonesia_datetime($key->date_start);	
		}
			//$row[] = $key->task;
			//$row[] = $key->schedule;
			//$row[] = $key->status_damage;
			//$row[] = $key->pm;
			$row[] = $key->status_level;
			$row[] = $key->status_bd;
			//$row[] = $key->nama_vendor;
			//$row[] = $key->mechanic_name;
			//$row[] = $key->location;
			$row[] = $key->hm;
			//$row[] = $key->shift;
			//$row[] = $key->operator;
			//$row[] = $key->remarks_machine;
			//$row[] = substr($key->reason_bd,0,50);
			$row[] = $key->date_finished;
			//$row[] = $key->no_pr_sr;
			//$row[] = $key->no_po;
			//$row[] = $key->cost_estimate;
			//$row[] = $key->status_cost;
			$row[] = $key->possible_work;
			$row[] = $key->total_down_time;
			$row[] = $key->ma;

			/*$row[] = $key->no_kwitansi;
			$row[] = date_indonesia_datetime($key->date_start);
			$row[] = $key->nap;
			$row[] = $key->code_unit;
			$row[] = $key->task;
			$row[] = $key->schedule;
			$row[] = $key->status_damage;
			$row[] = $key->pm;
			$row[] = $key->status_level;
			$row[] = $key->status_bd;
			$row[] = $key->nama_vendor;
			$row[] = $key->mechanic_name;
			$row[] = $key->location;
			$row[] = $key->hm;
			$row[] = $key->shift;
			$row[] = $key->operator;
			$row[] = $key->remarks_machine;
			$row[] = substr($key->reason_bd,0,50);
			$row[] = $key->date_finished;
			$row[] = $key->no_pr_sr;
			$row[] = $key->no_po;
			$row[] = $key->cost_estimate;
			$row[] = $key->status_cost;
			$row[] = $key->possible_work;
			$row[] = $key->total_down_time;
			$row[] = $key->ma;*/
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$key->id_rn."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$key->id_rn."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->bd->count_all(),
			"recordsFiltered" => $this->bd->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function bd_delete($id)
	{
		$this->bd->delete_by_id($id);
		echo json_encode(array("status"=>TRUE));
	}

	public function edit_vehicle_bd($id)
	{
		$data = $this->bd->get_unit_bd_by_id($id);
		$data->date_start = date_indonesia_datetime($data->date_start);
		$data->date_finished = date_indonesia_datetime($data->date_finished);
		$data->date_finish_estimate = date_indonesia_datetime($data->date_finish_estimate);
		echo json_encode($data);
		//var_dump($data);
	}

	public function update_bd_by_log()
	{
		$data = array(
					'no_pr_sr' => $this->input->post('f_pr'),
					'no_po' => $this->input->post('f_po'),
						);
		$this->bd->update(array("id_rn" => $this->input->post('f_id_emp_act_sk')),$data);
		echo json_encode(array("status" => TRUE));
	}

	public function update_bd()
	{
		$this->_validate_update_bd();
		$data = array(
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'no_kwitansi' => $this->input->post('f_kwitansi'),
				'date_start' => date_input_datetime($this->input->post('f_date_bd')),
				'nap' => $this->input->post('f_code_unit'),
				'task' => $this->input->post('f_task'),
				'schedule' => $this->input->post('f_schedule'),
				'status_damage' => $this->input->post('f_damage'),
				/*'updatedate' => $this->input->post('f_schedule'),
				'updateby' => $this->input->post('f_damage'),*/
				'pm' => $this->input->post('f_pm'),
				'status_level' => $this->input->post('status_lvl_temp'),
				'status_bd' => $this->input->post('status_bd_temp'),
				'status_parts_job' => $this->input->post('f_sts_part_job'),
				'progress_by' => $this->input->post('f_vendor'),
				'mechanic_name' => $this->input->post('f_mechanic'),
				'location' => $this->input->post('f_location'),
				'date_finish_estimate' => date_input_datetime($this->input->post('f_date_estimate')),
				'hm' => $this->input->post('f_hm'),
				'hm_start' => $this->input->post('f_hm_start'),
				'hm_finish' => $this->input->post('f_hm_finish'),
				'shift' => $this->input->post('f_shift'),
				'operator' => $this->input->post('f_operator'),
				'remarks_machine' => $this->input->post('f_remarks_machine'),
				'reason_bd' => $this->input->post('f_reason_bd'),
				'part_replacment' => $this->input->post('f_part'),
				'date_finished' => date_input_datetime($this->input->post('f_date_finish')),
				'no_pr_sr' => $this->input->post('f_pr'),
				'no_po' => $this->input->post('f_po'),
				'cost_estimate' => $this->input->post('f_cost_estimate'),
				'status_cost' => $this->input->post('f_status_cost'),
				'possible_work' => $this->input->post('f_pw'),
				'total_down_time' => $this->input->post('f_tdr'),
				'tdy' => $this->input->post('f_tdy'),
				'ma' => $this->input->post('f_ma'),
				'stand_by' => $this->input->post('f_stby'),
				'ua' => $this->input->post('f_ua'),
				'pa' => $this->input->post('f_pa'),
			);
		$this->bd->update(array("id_rn" => $this->input->post('f_id_emp_act_sk')),$data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate_update_bd()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if ($this->input->post('f_status_level') == 1 && $this->input->post('f_pr') == '') {
			$data['inputerror'][] = 'f_pr';
			$data['error_string'][] = 'No PR dan SR harus di isi jika BD2';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}

	}

	private function _validate_add()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('f_kwitansi') == '')
		{
			$data['inputerror'][] = 'f_kwitansi';
			$data['error_string'][] = 'No Kwitansi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_date_bd') == '')
		{
			$data['inputerror'][] = 'f_date_bd';
			$data['error_string'][] = 'Date Start is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_hm') == '')
		{
			$data['inputerror'][] = 'f_hm';
			$data['error_string'][] = 'HM is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_remarks_machine') == '' || $this->input->post('f_reason_bd') == '' )
		{
			$data['inputerror'][] = 'f_remarks_machine';
			$data['inputerror'][] = 'f_reason_bd';
			$data['error_string'][] = 'Remarks is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function cek_kwitansi($no_kwitansi)
	{

		/*cek inputan no kwitansi*/
		$cek = $this->bd->cek_kwitansi($no_kwitansi);
		
		if ($cek) {
			$data = array();
			$data['inputerror'][] = 'f_kwitansi';
			$data['error_string'][] = 'Data Sudah terinput';
			$data['status'] = FALSE;
		// jika ada data
			echo json_encode($data);
		/*echo "<pre>";
		echo print_r($cek);
		echo "</pre>";*/
		}
		else
		{
			$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
			echo json_encode($data);
		}
		

	}

	public function get_status_unit($id)
	{

		$data = $this->bd->get_status_unit($id);
		if($data)
		{
			$data[0]->date_start = date_indonesia_datetime($data[0]->date_start);
				if ($data[0]->status_bd == 0) {
					$data[0]->status_bd = "BREAKDOWN";
				}
				else{
					$data[0]->status_bd = "OPERATION";

				}
				if ($data[0]->date_start == "") {
					$data[0]->date_start = 0;
				}
			}
			else{
				$data = array("status_bd" => "no_data_stored");
				//$data[0]->status_bd = "OPERATION";
			}
		

		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";*/
		//echo $data[0]->status_bd;
		echo json_encode($data);
	}

	public function get_hm_update($id, $period, $year)
	{
		$data = $this->bd->get_hm_update($id, $period, $year);	
		echo json_encode($data);
	}

	public function rpt_downtime_pdf()
	{

		$start_date = date_input($this->input->post('tmp_start_date'));
		$end_date = date_input($this->input->post('tmp_end_date'));
		$code_unit = $this->input->post('tmp_code_unit');
		$type = $this->input->post('tmp_type');
		$status_bd = $this->input->post('tmp_status_bd');
		$status_level = $this->input->post('tmp_status_level');
		$data = array(
			"start_date" => $this->input->post('tmp_start_date'),
			"end_date" => $this->input->post('tmp_end_date'),
		"code_unit" => $this->input->post('tmp_code_unit'),
		"type" => $this->input->post('tmp_type'),
		"status_bd" => $this->input->post('tmp_status_bd'),
		"status_level" => $this->input->post('tmp_status_level'),
		);
		//$test = $this->bd->rpt_downtime_daily($start_date, $end_date, $code_unit, $type, $status_bd, $status_level);
		//var_dump($test);
		$data = array(
			"data_bd" => $this->bd->rpt_downtime_daily($start_date, $end_date, $code_unit, $type, $status_bd, $status_level),
			"data_bd_det" => $this->bd->rpt_downtime_daily($start_date, $end_date, $code_unit, $type, 0, $status_level)
		);
		$this->load->library('pdf');
		$this->pdf->setPaper('A4','landscape');
	    $timestamp = date("d-m-Y h:i:s");
		$this->pdf->set_option('isRemoteEnabled',false);
		$this->pdf->filename = 'History_Downtime_Report.pdf';
		$this->pdf->load_view('rpt_downtime_view', $data);
        $this->pdf->stream("History_Downtime_Report_".$timestamp.".pdf", array('Attachment'=>0));

	}

	public function rpt_downtime_pdf_v1()
	{
		$this->load->library('pdf');

		$start_date = date_input($this->input->post('tmp_start_date'));
		$end_date = date_input($this->input->post('tmp_end_date'));
		$code_unit = $this->input->post('tmp_code_unit');
		$type = $this->input->post('tmp_type');
		$status_bd = $this->input->post('tmp_status_bd');
		$status_level = $this->input->post('tmp_status_level');
		$data = array(
			"start_date" => $this->input->post('tmp_start_date'),
			"end_date" => $this->input->post('tmp_end_date'),
		"code_unit" => $this->input->post('tmp_code_unit'),
		"type" => $this->input->post('tmp_type'),
		"status_bd" => $this->input->post('tmp_status_bd'),
		"status_level" => $this->input->post('tmp_status_level'),
		);
		//$test = $this->bd->rpt_downtime_daily($start_date, $end_date, $code_unit, $type, $status_bd, $status_level);
		//var_dump($test);
		$data = array(
			"data_bd" => $this->bd->rpt_downtime_daily_v01($start_date, $end_date, $code_unit, $type, $status_bd, $status_level),
			"data_bd_det" => $this->bd->rpt_downtime_daily_v01($start_date, $end_date, $code_unit, $type, 0, $status_level)
		);

		$this->pdf->setPaper('A4','landscape');
	    $timestamp = date("d-m-Y h:i:s");
		$this->pdf->set_option('isRemoteEnabled',false);
		$this->pdf->filename = 'History_Downtime_Report.pdf';
		$this->pdf->load_view('rpt_downtime_view', $data);
        $this->pdf->stream("History_Downtime_Report_".$timestamp.".pdf", array('Attachment'=>0));

	}

	public function rpt_downtime_pdf_v2()
	{
		$obj_user = $this->ion_auth->user()->row();
		$name = $obj_user->first_name;
		$username = $obj_user->username;

		$this->load->library('pdf');
		$this->pdf->setPaper('A4','landscape');

		$start_date = date_input($this->input->post('tmp_start_date'));
		$end_date = date_input($this->input->post('tmp_end_date'));
		$code_unit = $this->input->post('tmp_code_unit');
		$type = $this->input->post('tmp_type');
		$status_bd = $this->input->post('tmp_status_bd');
		$status_level = $this->input->post('tmp_status_level');
		$rpt_type = $this->input->post('tmp_rpt_type');

		$data = array(
			"start_date" => $this->input->post('tmp_start_date'),
			"end_date" => $this->input->post('tmp_end_date'),
			"code_unit" => $this->input->post('tmp_code_unit'),
			"type" => $this->input->post('tmp_type'),
			"status_bd" => $this->input->post('tmp_status_bd'),
			"status_level" => $this->input->post('tmp_status_level'),
		);
		//$test = $this->bd->rpt_downtime_daily($start_date, $end_date, $code_unit, $type, $status_bd, $status_level);
		//var_dump($test);
		if ($rpt_type == "daily") {
			$data = array(
				"start_date" => $this->input->post('tmp_start_date'),
				"end_date" => $this->input->post('tmp_end_date'),
				"code_unit" => $this->input->post('tmp_code_unit'),
				"type" => $this->input->post('tmp_type'),
				"qr_name" => $username,
				"status_bd" => $this->input->post('tmp_status_bd'),
				"status_level" => $this->input->post('tmp_status_level'),
				"rpt_type" => $this->input->post('tmp_rpt_type'),
				"qr_code" => $this->qr_code(),
				"data_bd" => $this->bd->rpt_downtime_daily_v03($start_date, $end_date, $code_unit, $type, $status_bd = 1, $status_level),
				"data_bd_det" => $this->bd->rpt_downtime_daily_v03($start_date, $end_date, $code_unit, $type, 0, $status_level)
			);
			$this->pdf->load_view('rpt_downtime_view', $data);
		}
		else {
			$data = array(
				"data_bd" => $this->bd->rpt_downtime_daily_v01($start_date, $end_date, $code_unit, $type, $status_bd, $status_level),
				"data_bd_det" => $this->bd->rpt_downtime_daily_v01($start_date, $end_date, $code_unit, $type, 0, $status_level)
			);
			$this->pdf->load_view('rpt_downtime_view_01', $data);
		}
		// $this->load->view('rpt_downtime_view', $data);

	    $timestamp = date("d-m-Y h:i:s");
		$this->pdf->set_option('isRemoteEnabled',false);
		$this->pdf->filename = 'History_Downtime_Report.pdf';
        $this->pdf->stream("History_Downtime_Report_".$timestamp.".pdf", array('Attachment'=>0));

	}

	public function test_rpt_baru()
	{
		$start_date = "2018-12-07";
		$end_date = "2018-12-08";
		$code_unit = $this->input->post('tmp_code_unit');
		$type = $this->input->post('tmp_type');
		$status_bd = $this->input->post('tmp_status_bd');
		$status_level = $this->input->post('tmp_status_level');
		$data = $this->bd->rpt_downtime_daily_v02($start_date, $end_date, $code_unit, $type, $status_bd, $status_level);
		$data1 = $this->bd->rpt_downtime_daily_v01($start_date, $end_date, $code_unit, $type, $status_bd, $status_level);
		$dataa = $this->bd->rpt_pauama($start_date,$end_date);
   		$model_unit = $this->bd->model_unit_v1($start_date,$end_date);

		echo "<pre>";
		echo print_r($model_unit);
		echo "</pre>";
	}


	public function rpt_downtime()
	{
		$group = array("ts","inv");
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
	        $data['dd_type'] = $this->lov->dd_vehicle_by_type();
	        $data['type_selected'] = $this->input->post('f_type') ? $this->input->post('f_type') : '';

	        if ($this->ion_auth->in_group($group)) {
	        	$this->load->view('temp/title',$data);
	        	$this->load->view('temp/header');
	        	$this->load->view('temp/sidebar');
	        	$this->load->view('f_rpt_downtime');
	        	$this->load->view('temp/footer');
	        	$this->load->view('notif');
	        	$this->load->view('ajax_rpt_downtime');
	        }
	    else
	    {
	    	return show_error("You must be an administrator to view this page.");
	    }


		}
	}

	public function rpt_xls_list()
	{
		$list = $this->bd->get_datatables_xls();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->no_kwitansi;
			$row[] = $key->type;
			$row[] = $key->model;
			$row[] = $key->serial_number;
			$row[] = $key->manufacturer;
			$row[] = $key->group_name;
			$row[] = $key->work_unit;
			$row[] = $key->code_unit;
			$row[] = $key->nap;
			$row[] = date_indonesia($key->tanggal_start);
			$row[] = substr($key->jam_start, 0,5);
			$row[] = date_indonesia($key->tanggal_finish);
			if (isset($key->jam_finish)) {
			$row[] = substr($key->jam_finish, 0,5);
			}
			else
			{
			$row[] = $key->jam_finish;
			}
			$row[] = $key->task;
			$row[] = $key->schedule;
			$row[] = $key->status_damage;
			$row[] = $key->pm;
			$row[] = $key->status_level;
			$row[] = $key->status_bd;
			$row[] = $key->nama_vendor;
			$row[] = $key->mechanic_name;
			$row[] = $key->location;
			//$row[] = number_format($key->hm,0, ", " ,".");
			$row[] = $key->hm;
			$row[] = $key->shift;
			$row[] = $key->operator;
			$row[] = $key->remarks_machine;
			$row[] = $key->reason_bd;
			$row[] = $key->part_replacment;
			$row[] = $key->no_pr_sr;
			$row[] = $key->no_po;
			$row[] = $key->cost_estimate;
			$row[] = $key->status_cost;
			$row[] = $key->possible_work;
			$row[] = $key->total_down_time;
			$row[] = $key->ma;
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->bd->count_all_xls(),
			"recordsFiltered" => $this->bd->count_filtered_xls(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function teste()
	{
		$start_date = "2019-01-28";  
		$end_date = "2019-02-03";
		$data = $this->mttr->mttr_vs_mtbf($start_date,$end_date);
		echo print_r($data);
	}

	public function mttr_vs_mtbf()
	{
		$group = array("ts");
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		else{
			$obj_user = $this->ion_auth->user()->row();
			$username = $obj_user->username;
			$data['username'] = $username;	
			$data['title'] = "MTTR - MTBF";

	        if ($this->ion_auth->in_group($group)) {
	        	$this->load->view('temp/title',$data);
	        	$this->load->view('temp/header');
	        	$this->load->view('temp/sidebar');
	        	$this->load->view('f_rpt_mttr');
	        	$this->load->view('temp/footer');
	        	$this->load->view('notif');
	        	$this->load->view('ajax_rpt_mttr');
	        }
	    else
	    {
	    	return show_error("You must be an administrator to view this page.");
	    }


		}
	}

	/* report export excel mttr vs mtbf */
	public function rpt_mttr_vs_mtbf()
	{

		$start_date = date_input($this->input->post('f_start_date')); 
		$end_date = date_input($this->input->post('f_end_date'));
		$spreadsheet = new spreadsheet();
		$styeArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; // array untuk membuat all border

		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true); //set widht menjadi autosize

		$spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#1e232b');

		$data = $this->mttr->mttr_vs_mtbf($start_date,$end_date);
		$spreadsheet->getActiveSheet()
    ->fromArray(
        $data,  // The data to set
        NULL,        // Array values with this value will not be set
        'A2'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
	);


		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A1","NAP");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("B1","TYPE");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("C1","GROUP");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("D1","NO MACHINE");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("E1","SERIAL NUMBER");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("F1","MODEL");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("G1","MANUFACTURER");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("H1","TOTAL DOWN TIME");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("I1","TOTAL DAYS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("J1","WORKING HOURS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("K1","POSSIBLE WORKING HOURS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L1","OPERATION WORKING HOURS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("M1","AVERAGE (%)");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("N1","TOTAL EVENT");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("O1","MTBF (%)");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("P1","MTTR (%)");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("Q1","STATUS BREAKDOWN");

		for ($i=2; $i <= count($data) ; $i++) { 
			$status = $spreadsheet->getActiveSheet()->getCell("Q".$i)->getValue();
			$code_unit = $spreadsheet->getActiveSheet()->getCell("B".$i)->getValue();
			
				if ($status == 0 ) {
					$spreadsheet->setActiveSheetIndex(0)->setCellValue("Q".$i,$status)->getStyle('Q'.$i)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44141');
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$i,$code_unit)->getStyle('B'.$i)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44141');
					//$spreadsheet->getActiveSheet()->getStyle("Q".$i)->getFill()->getStartColor()->setARGB('8094b5');				
				}
			}


		$nama_file = date("Y-m-d");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
		header('Content-Disposition: attachment;filename="rpt_mttr_vs_mtbf_'.$start_date.'_'.$end_date.'.xlsx"');
		header('Cache-control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	}
	/* report export excel mttr vs mtbf */


	public function rpt_pauama_daily()
	{
		$start_date = date_input($this->input->post('filter_start'));  
		$end_date = date_input($this->input->post('filter_end'));
		$spreadsheet = new spreadsheet();
		$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '1e232b'],
        ],
    ],
]; //array untuk membuat all border

/*marge cell*/
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("A1:T3"); // judul besar
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("A4:A5"); // no
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("B4:B5"); // type
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("C4:C5"); // model
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("D4:D5"); // tahun
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("E4:E5"); // date receive
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("F4:F5"); // hm
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("G4:G5"); // hm
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("H4:H5"); // hm
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("I4:I5"); // hm
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("M4:P4"); // DATE BREAKDOWN
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("J4:J5"); // STATUS UNIT
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("K4:K5"); // REASON
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("L4:L5"); // PROGRESS
		/*$spreadsheet->setActiveSheetIndex(0)->mergeCells("M4:M5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("N4:N5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("O4:O5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("P4:P5"); // NOTE*/
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("Q4:Q5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("R4:R5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("S4:S5"); // NOTE
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("T4:T5"); // NOTE
		/*marge cell*/

		/*MEMBERI NAMA KOLOM DAN JUDUL*/
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A1","UPDATES PROGRESS UNIT");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A4","NO");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("B4","TYPE");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("C4","MODEL");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("D4","NAP");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("E4","YEAR");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("F4","WH/day(hours)")->getStyle('F4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("G4","BD/day(hours)")->getStyle('G4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("H4","Standby")->getStyle('H4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("I4","MA %")->getStyle('I4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("J4","UA %")->getStyle('J4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("K4","PA %")->getStyle('K4')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('63bc2b');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L4","Upadate HM/KM");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("M4","Time Breakdown");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("M5","Time BD");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("N5","NOW/RFU");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("O5","THR");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("P5","TDY");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("Q4","STATUS UNIT");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("R4","REASON");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("S4","PROGRESS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("T4","NOTES");
		/*MEMBERI NAMA KOLOM DAN JUDUL*/

		$spreadsheet->getActiveSheet()->getStyle('A1:T3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('M4:P4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah


		$data = $this->bd->rpt_pauama($start_date,$end_date);
		$spreadsheet->getActiveSheet()
    ->fromArray(
        $data,  // The data to set
        NULL,        // Array values with this value will not be set
        'C6'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
	);
	

    /*vertical model unit*/
    $model_unit = $this->bd->model_unit_v1($start_date,$end_date);
    $six = 6;
    $no = 1;
    foreach ($model_unit as $key) {
    	$jml = $key['jml_row'];
    	$range = $jml+$six-1;
    	$spreadsheet->setActiveSheetIndex(0)->mergeCells("A".$six.":A".$range."");
    	$spreadsheet->setActiveSheetIndex(0)->mergeCells("B".$six.":B".$range."");
    	$spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$six."",$no);
    	$spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$six."",$key['model']);
	    //$spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setTextRotation(90);
	    $spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
	    $spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setTextRotation(90);
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    	$six = $six+$jml;
    	$no++;
    }

		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true); //set widht menjadi autosize

		$spreadsheet->getActiveSheet()->getStyle('F4')->getFill()->getStartColor()->setARGB('8094b5');
		$spreadsheet->getActiveSheet()->getStyle('G4')->getFill()->getStartColor()->setARGB('8094b5');
		$spreadsheet->getActiveSheet()->getStyle('H4')->getFill()->getStartColor()->setARGB('8094b5');
		$spreadsheet->getActiveSheet()->getStyle('I4')->getFill()->getStartColor()->setARGB('8094b5');
		$spreadsheet->getActiveSheet()->getStyle('J4')->getFill()->getStartColor()->setARGB('8094b5');
		$spreadsheet->getActiveSheet()->getStyle('K4')->getFill()->getStartColor()->setARGB('8094b5');

	

    /*$spreadsheet->setActiveSheetIndex(0)->mergeCells("A6:A24");
    $spreadsheet->setActiveSheetIndex(0)->mergeCells("B6:B24");
    $spreadsheet->getActiveSheet()->getStyle("B6")->getAlignment()->setTextRotation(90);
    $spreadsheet->getActiveSheet()->getStyle("B6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
    $spreadsheet->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue("B6","EXCAVATORS");    */
	//$status = $spreadsheet->getActiveSheet()->getCell('Q17')->getValue();
	for ($i=6; $i < 200 ; $i++) { 
		$status = $spreadsheet->getActiveSheet()->getCell("Q".$i)->getValue();
		$code_unit = $spreadsheet->getActiveSheet()->getCell("C".$i)->getValue();
		$hmkm = number_format($spreadsheet->getActiveSheet()->getCell("L".$i)->getValue(),0, ", " ,".");
		if ($hmkm) {
			# code...
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$i, $hmkm);
		}
			if ($status == "Breakdown" ) {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue("Q".$i,$status)->getStyle('Q'.$i)->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('f44141');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$i,$code_unit)->getStyle('C'.$i)->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('f44141');
				//$spreadsheet->getActiveSheet()->getStyle("Q".$i)->getFill()->getStartColor()->setARGB('8094b5');				
			}
		}
		$spreadsheet->getActiveSheet()->getCell('Q90')->setValue($status);
		$bts_thin_border = count($data)+5;
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A4:T'.$bts_thin_border.'')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas

		$nama_file = date("Y-m-d");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
		header('Content-Disposition: attachment;filename="rpt_update_progress_unit_'.$nama_file.'.xlsx"');
		header('Cache-control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	}

	public function rpt_update_prog_unit()
	{
		$spreadsheet = new spreadsheet();
		$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '1e232b'],
        ],
    ],
]; //array untuk membuat all border
		
		/*marge cell*/
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("A1:L3"); // judul besar
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("A4:A5"); // no
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("B4:B5"); // type
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("C4:C5"); // model
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("D4:D5"); // tahun
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("E4:E5"); // date receive
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("F4:F5"); // hm
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("G4:I4"); // DATE BREAKDOWN
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("J4:J5"); // STATUS UNIT
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("K4:K5"); // REASON
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("L4:L5"); // PROGRESS
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("M4:M5"); // NOTE
		/*marge cell*/

		/*MEMBERI NAMA KOLOM DAN JUDUL*/
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A1","UPDATES PROGRESS UNIT");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A4","NO");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("B4","TYPE");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("C4","MODEL");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("D4","YEAR");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("E4","DATE ARRIVED");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("F4","UPDATES HM");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("G4","DATE BREAKDOWN");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("G5","START");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("H5","NOW/END");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("I5","DAY");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("J4","STATUS UNIT");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("K4","REASON");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L4","PROGRESS");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("M4","NOTES");
		/*MEMBERI NAMA KOLOM DAN JUDUL*/

		/*SET AUTO WIDTH*/
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(12); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12); //set widht menjadi autosize
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(12); //set widht menjadi autosize
		/*SET AUTO WIDTH*/
		/*hide column E*/
		$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setVisible(false);
		/*hide column E*/

		$spreadsheet->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle("G4:I4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah

		/*data*/
		$data = $this->bd->rpt_progress_unit();
		$spreadsheet->getActiveSheet()
    ->fromArray(
        $data,  // The data to set
        NULL,        // Array values with this value will not be set
        'B6'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );

    /*vertical model unit*/
    $model_unit = $this->bd->model_unit();
    $six = 6;
    $no = 1;
    foreach ($model_unit as $key) {
    	$jml = $key['jml_row'];
    	$range = $jml+$six-1;
    	$spreadsheet->setActiveSheetIndex(0)->mergeCells("A".$six.":A".$range."");
    	$spreadsheet->setActiveSheetIndex(0)->mergeCells("B".$six.":B".$range."");
    	$spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$six."",$no);
    	$spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$six."",$key['model']);
	    //$spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setTextRotation(90);
	    $spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
	    $spreadsheet->getActiveSheet()->getStyle("A".$six."")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setTextRotation(90);
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
	    $spreadsheet->getActiveSheet()->getStyle("B".$six."")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


    	$six = $six+$jml;
    	$no++;
    }

    /*$spreadsheet->setActiveSheetIndex(0)->mergeCells("A6:A24");
    $spreadsheet->setActiveSheetIndex(0)->mergeCells("B6:B24");
    $spreadsheet->getActiveSheet()->getStyle("B6")->getAlignment()->setTextRotation(90);
    $spreadsheet->getActiveSheet()->getStyle("B6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
    $spreadsheet->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue("B6","EXCAVATORS");    */

    	$bts_thin_border = count($data)+5;
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A4:M'.$bts_thin_border.'')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas

		/*signature*/
		$bts_signature = $bts_thin_border +2;
		$cell_prepared_by = $bts_signature+1;
		$cell_create_by = $cell_prepared_by+4;
		$date_now = date("d-F-Y");
		/*set align center for signatrue*/
		$spreadsheet->getActiveSheet()->getStyle("L".$bts_signature.":M".$bts_signature."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle("L".$cell_prepared_by.":M".$cell_prepared_by."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle("L".$cell_create_by.":M".$cell_create_by."")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah


		/*merge cell signature*/
		/*$spreadsheet->setActiveSheetIndex(0)->mergeCells("L".$bts_signature.":M".$bts_signature."");
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("L".$cell_prepared_by.":M".$cell_prepared_by."");
		$spreadsheet->setActiveSheetIndex(0)->mergeCells("L".$cell_create_by.":M".$cell_create_by."");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$bts_signature."","Surabaya, ".$date_now." ");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$cell_prepared_by."","Prepared By,");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$cell_create_by."","(Susilo)");*/
		/*signature*/
		$nama_file = date("Y-m-d");

		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
		$drawing->setName('PhpSpreadsheet logo');

		$path_logo = $_SERVER["DOCUMENT_ROOT"].'/hris/assets/company.jpg';
		//$drawing->setPath('.assets/dist/img/photo3.jpg');
		$drawing->setPath($path_logo);
		$drawing->setHeight(36);
		$drawing->setCoordinates("O1");
		$spreadsheet->setActiveSheetIndex(0)->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);

		$drawing->setName('Paid');
$drawing->setDescription('Paid');
$drawing->setPath($path_logo);
$drawing->setCoordinates('O15');
$drawing->setOffsetX(110);
$drawing->setRotation(25);
$drawing->getShadow()->setVisible(true);
$drawing->getShadow()->setDirection(45);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
		header('Content-Disposition: attachment;filename="rpt_update_progress_unit_'.$nama_file.'.xlsx"');
		header('Cache-control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	}

	public function test_data()
	{
		$data = $this->bd->rpt_progress_unit();
		$mode_unit = $this->bd->model_unit();
		$test = count($data);

	    foreach ($mode_unit as $key) {
	    	echo $key['model'];
	    	echo $key['jml_row'];
	    }
	}


	public function daily_hmkm()
	{
		$group = "ts";
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$username = $obj_user->username;
		$data['username'] = $username;	
		$data['title'] = "Daily HMKM Unit";
		$data['show_input'] = "<script> $('#box_input').show(); </script>";
		$data['dd_vehicle_code'] = $this->lov->dd_vehicle_op();
        $data['vehicle_code'] = $this->input->post('f_code_unit') ? $this->input->post('f_code_unit') : '';
        $data['dd_operator'] = $this->lov->dd_operator();
        $data['operator_code'] = $this->input->post('f_operator') ? $this->input->post('f_operator') : '';
        $data['dd_vendor'] = $this->lov->dd_vendor();
        $data['vendor_selected'] = $this->input->post('f_progress_by') ? $this->input->post('f_progress_by') : ''; 
			if ($this->ion_auth->in_group($group)) {
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_daily_hmkm');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_daily_hmkm',$data);
			}
			else{
				$data['show_input'] = "$('#box_input').hide();";
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_daily_hmkm'); 
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_daily_hmkm',$data);
			}
		}
	}

	public function closing_hm()
	{
		$group = array("ts","prod");
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$username = $obj_user->username;
			$data['username'] = $username;	
			$data['title'] = "Daily HMKM Unit";
			$data['dd_vehicle_code'] = $this->lov->dd_vehicle_op();
	        $data['vehicle_code'] = $this->input->post('f_code_unit') ? $this->input->post('f_code_unit') : '';
	        $data['dd_operator'] = $this->lov->dd_operator();
	        $data['operator_code'] = $this->input->post('f_operator') ? $this->input->post('f_operator') : '';
	        $data['dd_vendor'] = $this->lov->dd_vendor();
	        $data['vendor_selected'] = $this->input->post('f_progress_by') ? $this->input->post('f_progress_by') : ''; 
	        if ($this->ion_auth->in_group($group)) {
	        	$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_closing_daily_hmkm');
				$this->load->view('temp/footer');
				$this->load->view('ajax_closing_daily_hmkm');
				$this->load->view('notif');
	        }
		    else
		    {
		    	return show_error('You must be an administrator to view this page.');
		    }
		}
	}

	public function add_closing_hm($month, $year)
	{
		//$this->_validate_add();
	
		$cek = $this->cek_before_closing($month, $year);
		if ($cek == 0) {
			/*input or close data*/
			$data = array(
					'inputdate' => $this->input->post('f_input_date'),
					'inputby' => $this->input->post('f_input_by'),
					'period' => $this->input->post('f_period'),
					'year' => $this->input->post('f_year'),
					
				);
			$this->hm->closing_hm_daily($month, $year, $this->input->post('f_input_by'), $this->input->post('f_input_date'));
			echo json_encode(array("status" => TRUE));
		}
		else
		{
			$data['inputerror'][] = 'f_year';
			$data['inputerror'][] = 'f_period';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data closed';
			$data['error_string'][] = 'Data closed, click button "Delete Data" for reclosing';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
	
		}
	}

	public function delete_data_by_period()
	{
		$month = $this->input->post('f_period');
		$year = $this->input->post('f_year');
		$this->hm->delete_data_by_period($month, $year);
		echo json_encode(array("status" =>TRUE));
	}

	public function cek_before_closing($month, $year)
	{
		/*$month = 11;
		$year= 2018;*/
		$data = $this->hm->cek_before_closing($month, $year);
		if ($data > 0) {
			return $dat = 1;
		}
		else
		{
			return $dat = 0;	
		}
	}



	public function daily_hmkm_list()
	{
		$list = $this->hm->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$key->id_hm."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$key->id_hm."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			';
			$row[] = $key->nap;
			$row[] = $key->code_unit;
			$row[] = $key->year;
			$row[] = $key->period;
			$row[] = $key->d1;
			$row[] = $key->d2;
			$row[] = $key->d3;
			$row[] = $key->d4;
			$row[] = $key->d5;
			$row[] = $key->d6;
			$row[] = $key->d7;
			$row[] = $key->d8;
			$row[] = $key->d9;
			$row[] = $key->d10;
			$row[] = $key->d11;
			$row[] = $key->d12;
			$row[] = $key->d13;
			$row[] = $key->d14;
			$row[] = $key->d15;
			$row[] = $key->d16;
			$row[] = $key->d17;
			$row[] = $key->d18;
			$row[] = $key->d19;
			$row[] = $key->d20;
			$row[] = $key->d21;
			$row[] = $key->d22;
			$row[] = $key->d23;
			$row[] = $key->d24;
			$row[] = $key->d25;
			$row[] = $key->d26;
			$row[] = $key->d27;
			$row[] = $key->d28;
			$row[] = $key->d29;
			$row[] = $key->d30;
			$row[] = $key->d31;
			
			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->hm->count_all(),
			'recordsFiltered' => $this->hm->count_filtered(),
			'data' => $data,
		);
		echo json_encode($output);

	}


	public function veh_daily_hm_add()
	{
		$arr_get_big_hm = array(
			'd1' => $this->input->post('f_d1'),
			'd2' => $this->input->post('f_d2'),
			'd3' => $this->input->post('f_d3'),
			'd4' => $this->input->post('f_d4'),
			'd5' => $this->input->post('f_d5'),
			'd6' => $this->input->post('f_d6'),
			'd7' => $this->input->post('f_d7'),
			'd8' => $this->input->post('f_d8'),
			'd9' => $this->input->post('f_d9'),
			'd10' => $this->input->post('f_d10'),
			'd11' => $this->input->post('f_d11'),
			'd12' => $this->input->post('f_d12'),
			'd13' => $this->input->post('f_d13'),
			'd14' => $this->input->post('f_d14'),
			'd15' => $this->input->post('f_d15'),
			'd16' => $this->input->post('f_d16'),
			'd17' => $this->input->post('f_d17'),
			'd18' => $this->input->post('f_d18'),
			'd19' => $this->input->post('f_d19'),
			'd20' => $this->input->post('f_d20'),
			'd21' => $this->input->post('f_d21'),
			'd22' => $this->input->post('f_d22'),
			'd23' => $this->input->post('f_d23'),
			'd24' => $this->input->post('f_d24'),
			'd25' => $this->input->post('f_d25'),
			'd26' => $this->input->post('f_d26'),
			'd27' => $this->input->post('f_d27'),
			'd28' => $this->input->post('f_d28'),
			'd29' => $this->input->post('f_d29'),
			'd30' => $this->input->post('f_d30'),
			'd31' => $this->input->post('f_d31'),
		);
		$biggest_hm = max($arr_get_big_hm);
		$data = array(
			'nap' => $this->input->post('f_code_unit'),
			'year' => $this->input->post('f_year'),
			'period' => $this->input->post('f_period'),
			'd1' => $this->input->post('f_d1'),
			'd2' => $this->input->post('f_d2'),
			'd3' => $this->input->post('f_d3'),
			'd4' => $this->input->post('f_d4'),
			'd5' => $this->input->post('f_d5'),
			'd6' => $this->input->post('f_d6'),
			'd7' => $this->input->post('f_d7'),
			'd8' => $this->input->post('f_d8'),
			'd9' => $this->input->post('f_d9'),
			'd10' => $this->input->post('f_d10'),
			'd11' => $this->input->post('f_d11'),
			'd12' => $this->input->post('f_d12'),
			'd13' => $this->input->post('f_d13'),
			'd14' => $this->input->post('f_d14'),
			'd15' => $this->input->post('f_d15'),
			'd16' => $this->input->post('f_d16'),
			'd17' => $this->input->post('f_d17'),
			'd18' => $this->input->post('f_d18'),
			'd19' => $this->input->post('f_d19'),
			'd20' => $this->input->post('f_d20'),
			'd21' => $this->input->post('f_d21'),
			'd22' => $this->input->post('f_d22'),
			'd23' => $this->input->post('f_d23'),
			'd24' => $this->input->post('f_d24'),
			'd25' => $this->input->post('f_d25'),
			'd26' => $this->input->post('f_d26'),
			'd27' => $this->input->post('f_d27'),
			'd28' => $this->input->post('f_d28'),
			'd29' => $this->input->post('f_d29'),
			'd30' => $this->input->post('f_d30'),
			'd31' => $this->input->post('f_d31'),
			'hm_update' => $biggest_hm,
			'inputby' => $this->input->post('f_input_by'),
			'inputdate' => $this->input->post('f_input_date'),
		);
		$cek = $this->cek_data_daily($this->input->post('f_code_unit'),$this->input->post('f_period'), $this->input->post('f_year'));
		if ($cek==1) {
			//tidak boleh input alias data sudah ada
			$data['inputerror'][] = 'f_year';
			$data['inputerror'][] = 'f_period';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else
		{

		$this->hm->save($data);

		echo json_encode(array('status' =>TRUE));
		}
	}

	// validasi jika double date input
	public function cek_data_daily($nap, $period, $year)
	{
		$row = $this->hm->cek_data($nap, $period, $year);
		if ($row) {
			//echo "tidak boleh input";
			$a = 1;
			return $a;
		}
		else {
		//echo "boleh input";
			$a = 0;
			return $a;
		}
	}

	public function edit_vehicle_daily($id)
	{
		$data = $this->hm->get_unit_by_id($id);
		echo json_encode($data);
		//var_dump($data);
	}

	public function update_vehicle_hmkm()
	{
		$arr_get_big_hm = array(
			'd1' => $this->input->post('f_d1'),
			'd2' => $this->input->post('f_d2'),
			'd3' => $this->input->post('f_d3'),
			'd4' => $this->input->post('f_d4'),
			'd5' => $this->input->post('f_d5'),
			'd6' => $this->input->post('f_d6'),
			'd7' => $this->input->post('f_d7'),
			'd8' => $this->input->post('f_d8'),
			'd9' => $this->input->post('f_d9'),
			'd10' => $this->input->post('f_d10'),
			'd11' => $this->input->post('f_d11'),
			'd12' => $this->input->post('f_d12'),
			'd13' => $this->input->post('f_d13'),
			'd14' => $this->input->post('f_d14'),
			'd15' => $this->input->post('f_d15'),
			'd16' => $this->input->post('f_d16'),
			'd17' => $this->input->post('f_d17'),
			'd18' => $this->input->post('f_d18'),
			'd19' => $this->input->post('f_d19'),
			'd20' => $this->input->post('f_d20'),
			'd21' => $this->input->post('f_d21'),
			'd22' => $this->input->post('f_d22'),
			'd23' => $this->input->post('f_d23'),
			'd24' => $this->input->post('f_d24'),
			'd25' => $this->input->post('f_d25'),
			'd26' => $this->input->post('f_d26'),
			'd27' => $this->input->post('f_d27'),
			'd28' => $this->input->post('f_d28'),
			'd29' => $this->input->post('f_d29'),
			'd30' => $this->input->post('f_d30'),
			'd31' => $this->input->post('f_d31'),
		);
		$biggest_hm = max($arr_get_big_hm);
		$data = array(
			'nap' => $this->input->post('f_code_unit'),
			'year' => $this->input->post('f_year'),
			'period' => $this->input->post('f_period'),
			'd1' => $this->input->post('f_d1'),
			'd2' => $this->input->post('f_d2'),
			'd3' => $this->input->post('f_d3'),
			'd4' => $this->input->post('f_d4'),
			'd5' => $this->input->post('f_d5'),
			'd6' => $this->input->post('f_d6'),
			'd7' => $this->input->post('f_d7'),
			'd8' => $this->input->post('f_d8'),
			'd9' => $this->input->post('f_d9'),
			'd10' => $this->input->post('f_d10'),
			'd11' => $this->input->post('f_d11'),
			'd12' => $this->input->post('f_d12'),
			'd13' => $this->input->post('f_d13'),
			'd14' => $this->input->post('f_d14'),
			'd15' => $this->input->post('f_d15'),
			'd16' => $this->input->post('f_d16'),
			'd17' => $this->input->post('f_d17'),
			'd18' => $this->input->post('f_d18'),
			'd19' => $this->input->post('f_d19'),
			'd20' => $this->input->post('f_d20'),
			'd21' => $this->input->post('f_d21'),
			'd22' => $this->input->post('f_d22'),
			'd23' => $this->input->post('f_d23'),
			'd24' => $this->input->post('f_d24'),
			'd25' => $this->input->post('f_d25'),
			'd26' => $this->input->post('f_d26'),
			'd27' => $this->input->post('f_d27'),
			'd28' => $this->input->post('f_d28'),
			'd29' => $this->input->post('f_d29'),
			'd30' => $this->input->post('f_d30'),
			'd31' => $this->input->post('f_d31'),
			'hm_update' => $biggest_hm,
			'updateby' => $this->input->post('f_update_by'),
			'updatedate' => $this->input->post('f_update_date'),
		);
		$this->hm->update(array("id_hm" => $this->input->post('f_id_hm')),$data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_daily_hm($id)
	{
		$this->hm->delete_by_id($id);
		echo json_encode(array("status" =>TRUE));
	}

	public function get_pw($nap, $date)
	{
		$date = date_input($date);
		$data = $this->pro->get_pw($nap, $date);
		echo json_encode($data);
		
	}

	public function cek_date_estimate_expierd()
	{
		$data = $this->bd->cek_date_estimate_expierd();
		
		if ($data > 1) {
			echo json_encode(array("status" =>TRUE));
		}
		else {
				echo json_encode(array("status" =>FALSE));
		}
	}

	public function cek_no_pr()
	{
		$data = $this->bd->cek_pr_by_status_level();
		if ($data > 0 ) {
			echo json_encode(array("status" => FALSE));
			// jika ada data yang no pr tidak di isi maka status false tidak bisa print
		}
		else 
		{
			echo json_encode(array("status" => TRUE));
			// jika data yang > bd2 sudah terisi no pr nya boleh print
		}
	}

	public function get_biggest_hm()
	{
		$arr_get_big_hm = array(
			'd1' => $this->input->post('f_d1'),
			'd2' => $this->input->post('f_d2'),
			'd3' => $this->input->post('f_d3'),
			'd4' => $this->input->post('f_d4'),
			'd5' => $this->input->post('f_d5'),
			'd6' => $this->input->post('f_d6'),
			'd7' => $this->input->post('f_d7'),
			'd8' => $this->input->post('f_d8'),
			'd9' => $this->input->post('f_d9'),
			'd10' => $this->input->post('f_d10'),
			'd11' => $this->input->post('f_d11'),
			'd12' => $this->input->post('f_d12'),
			'd13' => $this->input->post('f_d13'),
			'd14' => $this->input->post('f_d14'),
			'd15' => $this->input->post('f_d15'),
			'd16' => $this->input->post('f_d16'),
			'd17' => $this->input->post('f_d17'),
			'd18' => $this->input->post('f_d18'),
			'd19' => $this->input->post('f_d19'),
			'd20' => $this->input->post('f_d20'),
			'd21' => $this->input->post('f_d21'),
			'd22' => $this->input->post('f_d22'),
			'd23' => $this->input->post('f_d23'),
			'd24' => $this->input->post('f_d24'),
			'd25' => $this->input->post('f_d25'),
			'd26' => $this->input->post('f_d26'),
			'd27' => $this->input->post('f_d27'),
			'd28' => $this->input->post('f_d28'),
			'd29' => $this->input->post('f_d29'),
			'd30' => $this->input->post('f_d30'),
			'd31' => $this->input->post('f_d31'),
		);

		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";*/
		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";

		$a = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "seventeen" => 17
);

		foreach ($data as $k => $v) {
		    echo "\$a[$k] => $v.\n";
			
		}*/


		echo max($arr_get_big_hm);
	}

	public function qr_code()
	{
		$obj_user = $this->ion_auth->user()->row();
		$name = $obj_user->first_name;
		$username = $obj_user->username;
		$this->load->library('ciqrcode');

		$params['data'] = 'Generate by : '.$username;
		$params['level'] = 'L';
		$params['size'] = 10;
		$params['savename'] =  FCPATH.'/upload/qrcode/'.$username.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().''.$username.'.png" />';
		
	}

	




}

?>