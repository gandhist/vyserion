<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		require('./phpspreadsheet/vendor/autoload.php');

		use PhpOffice\PhpSpreadsheet\Helper\Sample;
		use PhpOffice\PhpSpreadsheet\IOFactory;
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\writer\Xlsx;
/**
* 
*/
class Production extends MX_Controller
{
	
	function __construct()
	{
		# code...
        //$this->load->library('lib_log');
		date_default_timezone_set('Asia/Jakarta');
		$this->load->helper('form_helper');
        $this->load->helper('date');
		$this->load->helper('tanggal_input_helper');
		$this->load->helper('rooster_helper');
		$this->load->model('hr/lov_model','lov');
		$this->load->model('gang_model','gang');
		$this->load->model('gang_master_model','gang_master');
		$this->load->model('rooster_model','rooster');
		$this->load->model('hm_daily_model','veh_daily');
		/*$this->load->model('vm_model','vm');
		$this->load->model('vd_model','vd');
		$this->load->model('lov_model','master_lov');
		$this->load->model('notifikasi_vehicle','v_notif');
		$this->load->model('vehicle_monitoring_model','veh_mon');
		$this->load->model('rpt_vehicle_sarana_model','rpt_vehicle');*/
	}


	public function rpt_rooster()
	{
		$group = "prod";

		$this->load->helper('url');
		$this->load->helper('form_helper');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		/*elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}*/
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$email = $obj_user->username;
			$data['username'] = $email;
			$data['title'] = 'Report Rooster';

	        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';

if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('temp/header');
			$this->load->view('temp/sidebar');
			$this->load->view('rpt_rooster');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_rpt_rooster',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}

	}


	/*form validation gang*/
	private function _validate_gang()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_gang_name') == '')
		{
			$data['inputerror'][] = 'f_gang_name';
			$data['error_string'][] = 'Gang Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	/*form validate gang master*/
	private function _validate_gang_master()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_start_date') == '')
		{
			$data['inputerror'][] = 'f_start_date';
			$data['error_string'][] = 'start date Name is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_gang') == '')
		{
			$data['inputerror'][] = 'f_gang';
			$data['error_string'][] = 'gang date Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_empcode') == '')
		{
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'empcode Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


	/*form validation vehicle document*/
	private function _validate_vd()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_doc_no') == '')
		{
			$data['inputerror'][] = 'f_doc_no';
			$data['error_string'][] = 'Nomor Document is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_valid_until') == '')
		{
			$data['inputerror'][] = 'f_valid_until';
			$data['error_string'][] = 'Valid Until is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_doc_type') == '')
		{
			$data['inputerror'][] = 'f_doc_type';
			$data['error_string'][] = 'Document Type Unit is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_nap') == '')
		{
			$data['inputerror'][] = 'f_nap';
			$data['error_string'][] = 'Code Unit is required';
			$data['status'] = FALSE;
		}

	

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	/*start of gang controller*/
	public function gang()
	{	
		/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = "prod";
		if (!$this->ion_auth->logged_in()) {
			/*jika tidak ada session  maka akan di redirect ke halaman login*/
			redirect('auth/login', 'refresh');
			/**/
		}
			else{
				$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
				/*$data['dept'] = $this->lov->dept();*/
				/*$data['empcode'] = $this->emp_rn();*/
				$data['title'] = 'Gang';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_gang');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_gang',$data);
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}

	public function gang_list()
	{
		$list = $this->gang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->gang_name;
			$row[] = date_indonesia($key->start_date);// di format menggunakan helper tanggal_input_helper yang di load di function construct
			$row[] = $key->gang_desc;
			$row[] = $key->remarks;
			if ($key->active == "1") {
			$row[] = "Active";
			}
			else{
				$row[] = "Inactive";
			}
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$key->id_gang."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Inactive" onclick="inactive('."'".$key->id_gang."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->gang->count_all(),
						"recordsFiltered" => $this->gang->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function gang_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$this->_validate_gang();
		/*menyimpan inputan post ke dalam array data*/
		$data = array(
				'id_gang' => $this->input->post('f_id_gang'),
				'gang_name' => $this->input->post('f_gang_name'),
				'start_date' => date_input($this->input->post('f_start_date')),
				'gang_desc' => $this->input->post('f_gang_desc'),
				'active' => $this->input->post('f_active'),
				'remarks' => $this->input->post('f_remarks'),
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
			);
		$insert = $this->gang->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function gang_edit($id)
	{
		$data = $this->gang->get_by_id($id);
		$data->start_date = date_indonesia($data->start_date);
		echo json_encode($data);
	}

	public function gang_update()
	{
		$this->_validate_gang();

		$data = array(
				'id_gang' => $this->input->post('f_id_gang'),
				'gang_name' => $this->input->post('f_gang_name'),
				'start_date' => date_input($this->input->post('f_start_date')),
				'gang_desc' => $this->input->post('f_gang_desc'),
				'active' => $this->input->post('f_active'),
				'remarks' => $this->input->post('f_remarks'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
			);

		$this->gang->update(array('id_gang' => $this->input->post('f_id_gang')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function vm_delete($id)
	{
		//delete file
		//delete file
		$del = $this->vm->get_by_id($id);
		/*==== if wanna delete file / photos
		if(file_exists('upload/'.$emp_attribute->photo) && $emp_attribute->photo)
			unlink('upload/'.$emp_attribute->photo);*/
		
		$this->vm->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	/*fcontroller untuk inactive vehicle*/
	public function inactive_gang($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'active'	=>	"0",
			'updateby'	=>	$this->input->post('f_update_by'),
			'updatedate'	=>	date_input($this->input->post('f_update_date')),
		);
		$this->gang->update(array("id_gang" => $id), $data);
		echo json_encode(array("status" => true));
	}
	/*end of controller gang*/

	/*start of gang master controller*/
	public function gang_master()
	{	
		/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = "prod";
		if (!$this->ion_auth->logged_in()) {
			/*jika tidak ada session  maka akan di redirect ke halaman login*/
			redirect('auth/login', 'refresh');
			/**/
		}
			else{
				$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
				/*$data['dept'] = $this->lov->dept();*/
				/*$data['empcode'] = $this->emp_rn();*/
				$data['title'] = 'Gang Master';
				// dropdown untuk empcode
				$data['dd_gang'] = $this->lov->dd_gang();
		        $data['gang_selected'] = $this->input->post('f_gang') ? $this->input->post('f_gang') : '';

		        // dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_gang_master');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_gang_master');
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}
	/*end of function GANG*/

	public function gang_master_list()
	{
		$list = $this->gang_master->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->empcode;
			$row[] = $key->empname;
			$row[] = date_indonesia($key->start_date);// di format menggunakan helper tanggal_input_helper yang di load di function construct
			$row[] = $key->gang_name;
			$row[] = $key->remarks;
			/*if ($key->active == "1") {
			$row[] = "Active";
			}
			else{
				$row[] = "Inactive";
			}*/
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$key->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Inactive" onclick="inactive('."'".$key->empcode."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->gang_master->count_all(),
						"recordsFiltered" => $this->gang_master->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function gang_master_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$this->_validate_gang_master();
		/*menyimpan inputan post ke dalam array data*/
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'start_date' => date_input($this->input->post('f_start_date')),
				'id_gang' => $this->input->post('f_gang'),
				'remarks' => $this->input->post('f_remarks'),
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
			);
		$insert = $this->gang_master->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function gang_master_edit($id)
	{
		$data = $this->gang_master->get_by_id($id);
		$data->start_date = date_indonesia($data->start_date);
		echo json_encode($data);
	}

	public function gang_master_update()
	{
		$this->_validate_gang_master();

		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'start_date' => date_input($this->input->post('f_start_date')),
				'id_gang' => $this->input->post('f_gang'),
				'remarks' => $this->input->post('f_remarks'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
			);

		$this->gang_master->update(array('empcode' => $this->input->post('f_id_gang_master')), $data);
		echo json_encode(array("status" => TRUE));
	}

	/*fcontroller untuk inactive vehicle*/
	public function inactive_gang_master($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'active'	=>	"0",
			'updateby'	=>	$this->input->post('f_update_by'),
			'updatedate'	=>	date_input($this->input->post('f_update_date')),
		);
		$this->gang_master->update(array("empcode" => $id), $data);
		echo json_encode(array("status" => true));
	}
	/*end of gang master controller*/


	/*start of rooster*/
	public function rooster()
	{	
		/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = "prod";
		if (!$this->ion_auth->logged_in()) {
			/*jika tidak ada session  maka akan di redirect ke halaman login*/
			redirect('auth/login', 'refresh');
			/**/
		}
			else{
				$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
				$a = $this->rooster->last_row_rooster();
				$data['last_id'] = $a->last_id;
				/*$data['dept'] = $this->lov->dept();*/
				/*$data['empcode'] = $this->emp_rn();*/
				$data['title'] = 'Rooster';
				// dropdown untuk empcode
				$data['dd_gang'] = $this->lov->dd_gang();
		        $data['gang_selected'] = $this->input->post('f_gang') ? $this->input->post('f_gang') : '';

		        // dropdown untuk empcode rosster hanya mereferensi dari table gang_master yang sudah di input
				$data['dd_empcode'] = $this->lov->dd_empcode_ros();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_rooster');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_rooster');
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}
	/*end of function GANG*/

	public function rooster_list()
	{
		$list = $this->rooster->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->nik_pim;
			$row[] = $key->empname;
			$row[] = $key->period;
			//$row[] = date_indonesia($key->start_date);// di format menggunakan helper tanggal_input_helper yang di load di function construct
			$row[] = $key->year;
			$row[] = $key->gang_name;
			/*$row[] = $key->code_begin;*/
			if ($key->code_begin == 0) {
				$row[] = "OFF";
			}
			elseif ($key->code_begin == 1) {
				$row[] = "1#pagi";
				
			}
			elseif ($key->code_begin == 2) {
				$row[] = "2#pagi";
				
			}
			elseif ($key->code_begin == 3) {
				$row[] = "3#pagi";
				
			}
			elseif ($key->code_begin == 11) {
				$row[] = "1#malam";
				
			}
			elseif ($key->code_begin == 22) {
				$row[] = "2#malam";
				
			}
			elseif ($key->code_begin == 33) {
				$row[] = "3#malam";
				
			}
			elseif ($key->code_begin == 10) {
				$row[] = "1#reguler";
			}
			elseif ($key->code_begin == 20) {
				$row[] = "2#reguler";
			}
			elseif ($key->code_begin == 30) {
				$row[] = "3#reguler";
			}
			elseif ($key->code_begin == 40) {
				$row[] = "4#reguler";
			}
			elseif ($key->code_begin == 50) {
				$row[] = "5#reguler";
			}
			elseif ($key->code_begin == 60) {
				$row[] = "6#reguler";
			}
			elseif ($key->code_begin == 100) {
				$row[] = "OFF#reguler";
			}
			elseif ($key->code_begin == 612) {
				$row[] = "6#PM";
			}
			elseif ($key->code_begin == 621) {
				$row[] = "6#MP";
			}
			elseif ($key->code_begin == 601) {
				$row[] = "6#OP";
			}
			elseif ($key->code_begin == 602) {
				$row[] = "6#OM";
			}
			$row[] = $key->remarks;
			/*if ($key->active == "1") {
			$row[] = "Active";
			}
			else{
				$row[] = "Inactive";
			}*/
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$key->id_rooster_sk."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Inactive" onclick="inactive('."'".$key->id_rooster_sk."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Rooster" onclick="rooster_edit('."'".$key->id_rooster_sk."'".')"><i class="glyphicon glyphicon-list-alt"></i></a>
			<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Absensi" onclick="absensi_edit('."'".$key->id_rooster_sk."'".')"><i class="fa fa-calendar-check-o "></i></a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rooster->count_all(),
						"recordsFiltered" => $this->rooster->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function cek_data_input($empcode, $period, $year)
	{
		$a = $this->rooster->before_insert_rooster($empcode, $period, $year);
		if (isset($a)) {
			$row = 1;
			/*echo $row;*/
			return $row;
		}
		else {
			$row = 0;
			/*echo $row;*/
			return $row;
		}
	}

	public function last_id()
	{
		$a = $this->rooster->last_row_rooster();
		echo('<pre>');
		print_r($a);
		echo('</pre>');
		echo $a->last_id;

	}

	public function rooster_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		//$this->_validate_gang_master();
		/*menyimpan inputan post ke dalam array data*/
		$save_method = "add";
		$inputby = $this->input->post('f_input_by');
		$inputdate = $this->input->post('f_input_date');
		$id = $this->input->post('f_id_rooster');
		$empcode = $this->input->post('f_empcode');
		$period = $this->input->post('f_period');
		$year = $this->input->post('f_year');
		$begin_work = $this->input->post('f_begin_work');
		$remarks = $this->input->post('f_remarks');
		$day = $this->input->post('f_day');
		$cek = $this->cek_data_input($empcode, $period, $year);

		if ($cek == 1) {
			$data['inputerror'][] = 'f_remarks';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			/*echo "<script>alert('data sudah ada!!!')</script>";*/

		}
	else{
		//$data = $this->tiga_pagi_array(31);
		$period_total = total_hari($period, $year);
		// rooster untuk di excel
		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$data = $this->lead_off($period_total);
					//$this->absensi_rooster_satu_off($empcode, $period, $year);
				break;
				case 1: // jika dimulai dari 1 pagi
					$data = $this->satu_pagi($period_total);
					//$this->absensi_rooster_satu_pagi($empcode, $period, $year);
				break;
				case 2: // jika di mulai dari 2 pagi
					$data = $this->dua_pagi($period_total);
					//$this->absensi_rooster_dua_pagi($empcode, $period, $year);
				break;
				case 3: // jika di mulai dari 3 pagi
					$data = $this->tiga_pagi($period_total);
					//$this->absensi_rooster_tiga_pagi($empcode, $period, $year);
				break;
				case 11: // jika di mulai dari 1 malam
					$data = $this->satu_malam($period_total);
					//$this->absensi_rooster_satu_malam($empcode, $period, $year);
				break;
				case 22: // jika di mulai dari 2 malam
					$data = $this->dua_malam($period_total);
					//$this->absensi_rooster_dua_malam($empcode, $period, $year);
				break;
				case 33: // jika di mulai dari 3 malam
					$data = $this->tiga_malam($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 10: // jika di mulai dari 1 pagi reguler
					$data = $this->reg_p_satu($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 20: // jika di mulai dari 2 pagi reguler
					$data = $this->reg_p_dua($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 30: // jika di mulai dari 3 pagi reguler
					$data = $this->reg_p_tiga($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 40: // jika di mulai dari 4 pagi reguler
					$data = $this->reg_p_empat($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 50: // jika di mulai dari 5 pagi reguler
					$data = $this->reg_p_lima($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 60: // jika di mulai dari 6 pagi reguler
					$data = $this->reg_p_enam($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 100: // jika di mulai dari off reguler
					$data = $this->reg_p_off($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 612: // jika di mulai dari 6 pagi off 6 malam
					$data = $this->reg_pagi_malam_vice_versa($period_total, $day, 1);
				break;
				case 621: // jika di mulai dari 6 malam off 6 pagi
					$data = $this->reg_pagi_malam_vice_versa($period_total, $day, 2);
				break;
				case 601: // jika di mulai dari off pagi malam
					$data = $this->reg_off_pagi_malam_vice_versa($period_total, $day, 2);
				break;
				case 602: // jika di mulai dari off malam pagi
					$data = $this->reg_off_pagi_malam_vice_versa($period_total, $day, 1);
				break;

				
		}

		$data['period'] = $period;
		$data['year'] = $year;
		$data['code_begin'] = $begin_work;
		$data['id_rooster_sk'] = $id;
		$data['empcode'] = $empcode;
		$data['remarks'] = $remarks;
		$data['inputby'] = $inputby;
		$data['inputdate'] = $inputdate;
		$insert = $this->rooster->save($data);


		// rooster absensi di field absensi dan table absensi_rooster
		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$this->absensi_rooster_satu_off($empcode, $period, $year, $id);
				break;
				case 1: // jika dimulai dari 1 pagi
					$this->absensi_rooster_satu_pagi($empcode, $period, $year, $id);
				break;
				case 2: // jika di mulai dari 2 pagi
					$this->absensi_rooster_dua_pagi($empcode, $period, $year, $id);
				break;
				case 3: // jika di mulai dari 3 pagi
					$this->absensi_rooster_tiga_pagi($empcode, $period, $year, $id);
				break;
				case 11: // jika di mulai dari 1 malam
					$this->absensi_rooster_satu_malam($empcode, $period, $year, $id);
				break;
				case 22: // jika di mulai dari 2 malam
					$this->absensi_rooster_dua_malam($empcode, $period, $year, $id);
				break;
				case 33: // jika di mulai dari 3 malam
					$this->absensi_rooster_tiga_malam($empcode, $period, $year, $id);
				break;
				case 10: // jika di mulai dari 1 pagi reguler
					$data = $this->absensi_rooster_reg_p_satu($empcode, $period, $year, $id);
				break;
				case 20: // jika di mulai dari 2 pagi reguler
					$data = $this->absensi_rooster_reg_p_dua($empcode, $period, $year, $id);
				break;
				case 30: // jika di mulai dari 3 pagi reguler
					$data = $this->absensi_rooster_reg_p_tiga($empcode, $period, $year, $id);
				break;
				case 40: // jika di mulai dari 4 pagi reguler
					$data = $this->absensi_rooster_reg_p_empat($empcode, $period, $year, $id);
				break;
				case 50: // jika di mulai dari 5 pagi reguler
					$data = $this->absensi_rooster_reg_p_lima($empcode, $period, $year, $id);
				break;
				case 60: // jika di mulai dari 6 pagi reguler
					$data = $this->absensi_rooster_reg_p_enam($empcode, $period, $year, $id);
				break;
				case 100: // jika di mulai dari off reguler
					$data = $this->absensi_rooster_reg_p_off($empcode, $period, $year, $id);
				break;
				case 612: // jika di mulai dari 6 pagi off 6 malam
					$data = $this->absensi_rooster_reg_pagi_malam($empcode, $period, $year, $id,1, $day);
				break;
				case 621: // jika di mulai dari 6 malam off 6 pagi
					$data = $this->absensi_rooster_reg_pagi_malam($empcode, $period, $year, $id,2, $day);
				break;
				case 601: // jika di mulai dari off pagi malam
					$data = $this->absensi_rooster_off_pagi_malam($empcode, $period, $year, $id,2, $day);
				break;
				case 602: // jika di mulai dari off malam pagi
					$data = $this->absensi_rooster_off_pagi_malam($empcode, $period, $year, $id,1, $day);
				break;
				
		}
		$absen_rooster['inputby'] = $inputby;
		$absen_rooster['inputdate'] = $inputdate;
		$this->rooster->update_rooster(array("id" => $id), $absen_rooster); // update table absensi_rooster
		echo json_encode(array("status" => TRUE));

		}
	}


	public function action_prod()
	{
		$empcode = $this->input->post('f_empcode');
$period = $this->input->post('f_period');
$year = $this->input->post('f_year');
$begin_work = $this->input->post('f_begin_work');
$remarks = $this->input->post('f_remarks');
//$data = $this->tiga_pagi_array(31);
$period_total = total_hari($period, $year);
		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$data = $this->lead_off($period_total);
				break;
				case 1: // jika dimulai dari 1 pagi
					$data = $this->satu_pagi($period_total);
				break;
				case 2: // jika di mulai dari 2 pagi
					$data = $this->dua_pagi($period_total);
				break;
				case 3: // jika di mulai dari 3 pagi
					$data = $this->tiga_pagi($period_total);
				break;
				case 11: // jika di mulai dari 1 malam
					$data = $this->satu_malam($period_total);
				break;
				case 22: // jika di mulai dari 2 malam
					$data = $this->dua_malam($period_total);
				break;
				case 33: // jika di mulai dari 3 malam
					$data = $this->tiga_malam($period_total);
				break;
		}

		$data['period'] = $period;
		$data['year'] = $year;
		$data['code_begin'] = $begin_work;
		$data['empcode'] = $empcode;
		$data['remarks'] = $remarks;

		echo('<pre>');
		print_r($data);
		echo('</pre>');
	}

	public function rooster_edit($id)
	{
		$data = $this->rooster->get_by_id($id);
		//$data->start_date = date_indonesia($data->start_date);
		echo json_encode($data);
	}

	/*mengupdate rooster secara per tanggal*/
	public function rooster_update_tanggal()
	{
		$id_emp_rooster_sk = $this->input->post('f_id_rooster');
		$f_update_by = $this->input->post('f_update_by_rooster');
		$f_update_date = $this->input->post('f_update_date_rooster');
		$empcode = $this->input->post('f_empcode');
		$period = $this->input->post('f_period');
		$year = $this->input->post('f_year');
		//$begin_work = $this->input->post('f_begin_work');
		/*$f_update_date = $this->input->post('f_update_date');*/
		$data['updateby'] = $f_update_by;
		$data['updatedate'] = $f_update_date;
		/*$data['empcode'] = $empcode;
		$data['period'] = $period;
		$data['year'] = $year;*/
		/*$data['code_begin'] = $begin_work;*/
		//$data['id_rooster_sk'] = $id;
		//$data['remarks'] = $remarks;
		/*$data['inputby'] = $inputby;
		$data['inputdate'] = $inputdate;*/
		for ($i=1; $i <= 32 ; $i++) { 
				$data['a'.$i] = $this->input->post('f_day_'.$i);
			}
		$this->rooster->update(array("id_rooster_sk" => $id_emp_rooster_sk), $data);
		echo json_encode(array("status" => true));
	}

	/*mengupdate rooster secara per tanggal*/
	public function update_rooster_absensi()
	{
		$id = $this->input->post('f_id');
		$empcode = $this->input->post('f_empcode');
		$period = $this->input->post('f_period');
		$year = $this->input->post('f_year');
		$start_date = date_input($this->input->post('f_start_date'));
		$end_date = date_input($this->input->post('f_end_date'));
		$begin_work = $this->input->post('f_begin_work');
		$day = $this->input->post('f_day');
		$f_update_by = $this->input->post('f_update_by_absensi');
		$f_update_date = $this->input->post('f_update_date_absensi');
		$data['updateby'] = $f_update_by;
		$data['updatedate'] = $f_update_date;
		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$this->update_absensi_rooster_satu_off($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 1: // jika dimulai dari 1 pagi
					$this->update_absensi_rooster_satu_pagi($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 2: // jika di mulai dari 2 pagi
					$this->update_absensi_rooster_dua_pagi($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 3: // jika di mulai dari 3 pagi
					$this->update_absensi_rooster_tiga_pagi($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 11: // jika di mulai dari 1 malam
					$this->update_absensi_rooster_satu_malam($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 22: // jika di mulai dari 2 malam
					$this->update_absensi_rooster_dua_malam($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 33: // jika di mulai dari 3 malam
					$this->update_absensi_rooster_tiga_malam($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 10: // jika di mulai satu pagi reguler
					$this->update_absensi_rooster_reg_p_satu($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 20: // jika di mulai dari 2 pagi reguler
					$this->update_absensi_rooster_reg_p_dua($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 30: // jika di mulai dari 3 pagi reguler
					$this->update_absensi_rooster_reg_p_tiga($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 40: // jika di mulai dari 4 pagi reguler
					$this->update_absensi_rooster_reg_p_empat($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 50: // jika di mulai dari 5 pagi reguler
					$this->update_absensi_rooster_reg_p_lima($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 60: // jika di mulai dari 6 pagi reguler
					$this->update_absensi_rooster_reg_p_enam($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 100: // jika di mulai dari off reguler
					$this->update_absensi_rooster_reg_p_off($id, $start_date, $end_date);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 612: // jika di mulai pagi - malam
					$this->update_absensi_rooster_reg_pagi_malam($id, $start_date, $end_date, 1, $day);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 621: // jika di mulai malam - pagi
					$this->update_absensi_rooster_reg_pagi_malam($id, $start_date, $end_date, 2, $day);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 601: // jika di mulai dari off reguler
					$this->update_absensi_rooster_off_pagi_malam($id, $start_date, $end_date, 2, $day);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;
				case 602: // jika di mulai dari off reguler
					$this->update_absensi_rooster_off_pagi_malam($id, $start_date, $end_date, 1, $day);
					$this->rooster->update_rooster(array("id" => $id, "tanggal" => $start_date), $data);
					echo json_encode(array("status" => true));
				break;

		}

	}

	public function test_update_by_date()
	{		
		$from = "2018-06-25"; 
		$to = "2018-06-29"; 
		$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo "batasnya : ".$batas;
$data_ar = array();
		for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$date=date("Y-m-d", $date);
/*$dat=date("D", $date);*/
//echo "<td>".$date."</td>";

if ($i<3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = "1800001";
			$data_ar['id'] = "4";
			$data_ar['period'] = "6";
			$data_ar['year'] = "2018";
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";
		}
	}
elseif ($i<7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = "1800001";
			$data_ar['id'] = "4";
			$data_ar['period'] = "6";
			$data_ar['year'] = "2018";
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}

	}
	echo('<pre>');
		print_r($data_ar);
		echo('</pre>');
}


		for ($i=1; $i <= 32 ; $i++) { 
			$data['a'.$i] = "f_day_".$i;
		}
		echo('<pre>');
		print_r($data);
		echo('</pre>');
		$data = array(
			'a13'	=>	"9",
			'a14'	=>	"10",
		);
		print_r($data);
	}

	/*mengupdate rooster secara 1 periode*/
	public function rooster_update()
	{
		//$this->_validate_gang_master();
		$updateby = $this->input->post('f_update_by');
		$updatedate = $this->input->post('f_update_date');
		$id_rooster = $this->input->post('f_id_rooster');
		$id = $this->input->post('f_id_rooster');
		$empcode = $this->input->post('f_empcode');
		$period = $this->input->post('f_period');
		$year = $this->input->post('f_year');
		$begin_work = $this->input->post('f_begin_work');
		$remarks = $this->input->post('f_remarks');
		$day = $this->input->post('f_day');
		//$data = $this->tiga_pagi_array(31);
		$period_total = total_hari($period, $year);
		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$data = $this->lead_off($period_total);
				break;
				case 1: // jika dimulai dari 1 pagi
					$data = $this->satu_pagi($period_total);
				break;
				case 2: // jika di mulai dari 2 pagi
					$data = $this->dua_pagi($period_total);
				break;
				case 3: // jika di mulai dari 3 pagi
					$data = $this->tiga_pagi($period_total);
				break;
				case 11: // jika di mulai dari 1 malam
					$data = $this->satu_malam($period_total);
				break;
				case 22: // jika di mulai dari 2 malam
					$data = $this->dua_malam($period_total);
				break;
				case 33: // jika di mulai dari 3 malam
					$data = $this->tiga_malam($period_total);
				break;
				case 10: // jika di mulai dari 1 pagi reguler
					$data = $this->reg_p_satu($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 20: // jika di mulai dari 2 pagi reguler
					$data = $this->reg_p_dua($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 30: // jika di mulai dari 3 pagi reguler
					$data = $this->reg_p_tiga($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 40: // jika di mulai dari 4 pagi reguler
					$data = $this->reg_p_empat($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 50: // jika di mulai dari 5 pagi reguler
					$data = $this->reg_p_lima($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 60: // jika di mulai dari 6 pagi reguler
					$data = $this->reg_p_enam($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 100: // jika di mulai dari off reguler
					$data = $this->reg_p_off($period_total);
					//$this->absensi_rooster_tiga_malam($empcode, $period, $year);
				break;
				case 612: // jika di mulai dari 6 pagi off 6 malam
					$data = $this->reg_pagi_malam_vice_versa($period_total, $day, 1);
				break;
				case 621: // jika di mulai dari 6 malam off 6 pagi
					$data = $this->reg_pagi_malam_vice_versa($period_total, $day, 2);
				break;
				case 601: // jika di mulai dari off pagi malam
					$data = $this->reg_off_pagi_malam_vice_versa($period_total, $day, 2);
				break;
				case 602: // jika di mulai dari off malam pagi
					$data = $this->reg_off_pagi_malam_vice_versa($period_total, $day, 1);
				break;
				
		}

		$data['period'] = $period;
		$data['year'] = $year;
		$data['code_begin'] = $begin_work;
		$data['empcode'] = $empcode;
		$data['remarks'] = $remarks;
		$data['updateby'] = $updateby;
		$data['updatedate'] = $updatedate;
		$this->rooster->update(array('id_rooster_sk' => $id_rooster), $data); // update table emp_rooster
		


		// menghapus data lama
		$this->rooster->delete_absensi_rooster($id_rooster, $empcode);

		switch ($begin_work) {
				case 0: //  jika dimulai dari off
					$this->absensi_rooster_satu_off($empcode, $period, $year, $id);
				break;
				case 1: // jika dimulai dari 1 pagi
					$this->absensi_rooster_satu_pagi($empcode, $period, $year, $id);
				break;
				case 2: // jika di mulai dari 2 pagi
					$this->absensi_rooster_dua_pagi($empcode, $period, $year, $id);
				break;
				case 3: // jika di mulai dari 3 pagi
					$this->absensi_rooster_tiga_pagi($empcode, $period, $year, $id);
				break;
				case 11: // jika di mulai dari 1 malam
					$this->absensi_rooster_satu_malam($empcode, $period, $year, $id);
				break;
				case 22: // jika di mulai dari 2 malam
					$this->absensi_rooster_dua_malam($empcode, $period, $year, $id);
				break;
				case 33: // jika di mulai dari 3 malam
					$this->absensi_rooster_tiga_malam($empcode, $period, $year, $id);
				break;
				case 10: // jika di mulai dari 1 pagi reguler
					$data = $this->absensi_rooster_reg_p_satu($empcode, $period, $year, $id);
				break;
				case 20: // jika di mulai dari 2 pagi reguler
					$data = $this->absensi_rooster_reg_p_dua($empcode, $period, $year, $id);
				break;
				case 30: // jika di mulai dari 3 pagi reguler
					$data = $this->absensi_rooster_reg_p_tiga($empcode, $period, $year, $id);
				break;
				case 40: // jika di mulai dari 4 pagi reguler
					$data = $this->absensi_rooster_reg_p_empat($empcode, $period, $year, $id);
				break;
				case 50: // jika di mulai dari 5 pagi reguler
					$data = $this->absensi_rooster_reg_p_lima($empcode, $period, $year, $id);
				break;
				case 60: // jika di mulai dari 6 pagi reguler
					$data = $this->absensi_rooster_reg_p_enam($empcode, $period, $year, $id);
				break;
				case 100: // jika di mulai dari off reguler
					$data = $this->absensi_rooster_reg_p_off($empcode, $period, $year, $id);
				break;
				case 612: // jika di mulai dari 6 pagi off 6 malam
					$data = $this->absensi_rooster_reg_pagi_malam($empcode, $period, $year, $id,1, $day);
				break;
				case 621: // jika di mulai dari 6 malam off 6 pagi
					$data = $this->absensi_rooster_reg_pagi_malam($empcode, $period, $year, $id,2, $day);
				break;
				case 601: // jika di mulai dari off pagi malam
					$data = $this->absensi_rooster_off_pagi_malam($empcode, $period, $year, $id,2, $day);
				break;
				case 602: // jika di mulai dari off malam pagi
					$data = $this->absensi_rooster_off_pagi_malam($empcode, $period, $year, $id,1, $day);
				break;
				
				
		}
		$absen_rooster['updateby'] = $updateby;
		$absen_rooster['updatedate'] = $updatedate;
		$this->rooster->update_rooster(array("id" => $id), $absen_rooster); // update table absensi_rooster


		echo json_encode(array("status" => TRUE));
	}

	/*fcontroller untuk inactive vehicle*/
	public function inactive_rooster($id)
	{
		$f_update_by = $this->input->post('f_update_by');
		$f_delete_date = $this->input->post('f_update_date');
		$data = array(
			'is_deleted'	=>	"1",
			'deletedby'	=>	$f_update_by,
			'delete_date'	=>	$f_delete_date,
		);
		$this->rooster->update(array("id_rooster_sk" => $id), $data);
		echo json_encode(array("status" => true));
	}
	/*end of gang master controller*/

	public function period_select($period, $tahun)
	{
		$from ="";
		$to ="";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		
		$periode = $period;
		switch ($periode) {
			case 1:
				$from = "26-12-2017";
				$to = "25-01-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;
			case 2:
				$from = "26-01-2018";
				$to = "25-02-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 3:
				$from = "26-02-2018";
				$to = "25-03-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 4:
				$from = "26-03-2018";
				$to = "25-04-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 5:
				$from = "26-04-2018";
				$to = "25-05-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 6:
				$from = "26-05-2018";
				$to = "25-06-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 7:
				$from = "26-06-2018";
				$to = "25-07-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;
			case 8:
				$from = "26-07-2018";
				$to = "25-08-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 9:
				$from = "26-08-2018";
				$to = "25-09-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 10:
				$from = "26-09-2018";
				$to = "25-10-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 11:
				$from = "26-10-2018";
				$to = "25-11-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;

			case 12:
				$from = "26-11-2018";
				$to = "25-12-2018";
				$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo $batas." Hari";
				break;
		}

	}

	public function test_helper_tot_hari($period, $year)
	{
		echo total_hari($period, $year);
		echo get_from_date_period($period, $year);
		echo get_to_date_period($period, $year);

	}

	public function test_date()
	{
	echo "<table border='1'>";	
echo "<tr>";
		$from = "26-04-2018";
		$to = "26-05-2018";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		echo $batas." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;
		/*$from="2011-05-31";
$to ="2011-06-07";*/
/*while (strtotime($from)<=strtotime($to)){
$from = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
$from=date("Y-m-d D", $from);
//echo $from."<br/>";
	echo "<td>".$from."</td>";
}*/

for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);
echo "<td>".$dat."</td>";
}
echo "</tr><tr>";
for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("d", $date);
$dat=date("D", $date);
echo "<td>".$date."</td>";
}
//echo "</tr><tr>";
/**/
/*for ($i=0; $i < 5 ; $i++) { 
echo "<td>P</td>";
echo "<td>P</td>";
echo "<td>P</td>";

for ($a=0; $a < 1 ; $a++) { 
echo "<td>M</td>";
echo "<td>M</td>";
echo "<td>M</td>";
	# code...
echo "<td>OFF</td>";
}
}*/
/**/
echo "</tr><tr>";

for ($i=1; $i < $batas+1 ; $i++) {
	echo "<td>".$i."</td>";
}
echo "</tr><tr>";



echo "</tr><tr>";

/*echo $this->lead_off($batas+1);
echo "</tr><tr>";
echo $this->tiga_malam($batas+1);
echo "</tr><tr>";
echo $this->dua_malam($batas+1);
//echo $this->dua_pagi($batas+1);
echo "</tr><tr>";
echo $this->tiga_pagi($batas+1);
echo "</tr><tr>";
echo $this->satu_pagi($batas+1);
echo "</tr><tr>";
echo $this->satu_malam($batas+1);
echo "</tr><tr>";
echo $this->lead_off($batas+1);
echo "</tr><tr>";
echo $this->tiga_malam($batas+1);
echo "</tr><tr>";
echo $this->satu_malam($batas+1);
echo "</tr><tr>";
echo $this->satu_pagi($batas+1);
echo "</tr><tr>";
echo $this->satu_malam($batas+1);
echo "</tr><tr>";
echo $this->satu_pagi($batas+1);
echo "</tr><tr>";
echo $this->dua_malam($batas+1);*/
echo "</tr><tr>";
echo view_p_satu($batas+1);
echo "</tr><tr>";
echo view_p_dua($batas+1);
echo "</tr><tr>";
echo view_p_tiga($batas+1);
echo "</tr><tr>";
echo view_off($batas+1);
echo "</tr><tr>";
echo view_m_satu($batas+1);
echo "</tr><tr>";
echo view_m_dua($batas+1);
echo "</tr><tr>";
echo view_m_tiga($batas+1);
echo "</table>";
//$l = $this->dua_malam($batas+1);


//$bust = $this->tiga_pagi_array(31);
/*$bust[] = "cabe";
$bust[] = "terong";
$bust[] = "nangka";*/
/*echo('<pre>');
		print_r($bust);
		echo('</pre>');*/
/*for ($i=1; $i < 31 ; $i++) { 
	if ($i <= 7) {
		if ($i <= 2) {
			echo "<td>P</td>";
		}
		elseif ($i <= 5) {
			echo "<td>M</td>";
		}		
	}
}*/

/*for($a=0; $a<=31; $a++){
        if($a % 2==1 )
        echo "Ini bilangan ganjil: ". $a ."<br>";
    }*/

/*    for($x=1; $x<31; $x++){
        if(is_int($x/3)){
            echo $x. "<br>";
        }
    }*/

	}

	public function test_insert()
	{
$empcode = $this->input->post('f_empcode');
$period = $this->input->post('f_period');
$year = $this->input->post('f_year');
$begin_work = $this->input->post('f_begin_work');
$remarks = $this->input->post('f_remarks');
//$bust = $this->tiga_pagi_array(31);
		$bust['period'] = $period;
		$bust['year'] = $year;
		$bust['code_begin'] = $begin_work;
		$bust['empcode'] = $empcode;
		$bust['f_remarks'] = $remarks;
	$batas = 32;

	$p = $this->reg_p_lima($batas);
		
		echo('<pre>');
		print_r($p);
		echo('</pre>');
	}

	

	public function reg_p_off($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i == 1) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=7) {
		$p['a'.$i] = "1";
			}
		elseif ($i==8) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=14) {
		$p['a'.$i] = "1";
			}
		elseif ($i==15) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=21) {
		$p['a'.$i] = "1";
			}
		elseif ($i==22) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=28) {
		$p['a'.$i] = "1";
			}
		elseif ($i==29) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;
	}

	public function reg_p_satu($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 1) {
		$p['a'.$i] = "1";
			}
		elseif ($i==2) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=8) {
		$p['a'.$i] = "1";
			}
		elseif ($i==9) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=15) {
		$p['a'.$i] = "1";
			}
		elseif ($i==16) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=22) {
		$p['a'.$i] = "1";
			}
		elseif ($i==23) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=29) {
		$p['a'.$i] = "1";
			}
		elseif ($i==30) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;
	}

	public function reg_p_dua($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 2) {
		$p['a'.$i] = "1";
			}
		elseif ($i==3) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=9) {
		$p['a'.$i] = "1";
			}
		elseif ($i==10) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=16) {
		$p['a'.$i] = "1";
			}
		elseif ($i==17) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=23) {
		$p['a'.$i] = "1";
			}
		elseif ($i==24) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=30) {
		$p['a'.$i] = "1";
			}
		elseif ($i==31) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;
	}

	public function reg_p_tiga($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 3) {
		$p['a'.$i] = "1";
			}
		elseif ($i==4) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=10) {
		$p['a'.$i] = "1";
			}
		elseif ($i==11) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=17) {
		$p['a'.$i] = "1";
			}
		elseif ($i==18) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=24) {
		$p['a'.$i] = "1";
			}
		elseif ($i==25) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=31) {
		$p['a'.$i] = "1";
			}
		elseif ($i==32) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;	
	}

	public function reg_p_empat($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 4) {
		$p['a'.$i] = "1";
			}
		elseif ($i==5) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=11) {
		$p['a'.$i] = "1";
			}
		elseif ($i==12) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=18) {
		$p['a'.$i] = "1";
			}
		elseif ($i==19) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=25) {
		$p['a'.$i] = "1";
			}
		elseif ($i==26) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=32) {
		$p['a'.$i] = "1";
			}
		elseif ($i==33) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;	
	}

	public function reg_p_lima($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 5) {
		$p['a'.$i] = "1";
			}
		elseif ($i==6) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=12) {
		$p['a'.$i] = "1";
			}
		elseif ($i==13) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=19) {
		$p['a'.$i] = "1";
			}
		elseif ($i==20) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=26) {
		$p['a'.$i] = "1";
			}
		elseif ($i==27) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=33) {
		$p['a'.$i] = "1";
			}
		elseif ($i==34) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;
	}

	//rooster reguler enam pagi
	public function reg_p_enam($days)
	{
		$p = array();	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 6) {
		$p['a'.$i] = "1";
			}
		elseif ($i==7) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=13) {
		$p['a'.$i] = "1";
			}
		elseif ($i==14) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=20) {
		$p['a'.$i] = "1";
			}
		elseif ($i==21) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=27) {
		$p['a'.$i] = "1";
			}
		elseif ($i==28) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=$i) {
		$p['a'.$i] = "1";
			}	
		}
		return $p;
	}
	//end of rooster reguler enam pagi

	public function tiga_pagi($days)
	{
		$p = array();
	//echo "<table border='1'>";	
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 3) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=6) {
		$p['a'.$i] = "2";
			}
		elseif ($i==7) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=10) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=13) {
		$p['a'.$i] = "2";
			}
		elseif ($i==14) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=17) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=20) {
		$p['a'.$i] = "2";
			}
		elseif ($i==21) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=24) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=27) {
		$p['a'.$i] = "2";
			}
		elseif ($i==28) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=31) {
		$p['a'.$i] = "1";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "2";
			}
		}
		return $p;
	//echo "</table>";	
	}

	public function dua_pagi($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 2) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=5) {
		$p['a'.$i] = "2";
			}
		elseif ($i==6) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=9) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=12) {
		$p['a'.$i] = "2";
			}
		elseif ($i==13) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=16) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=19) {
		$p['a'.$i] = "2";
			}
		elseif ($i==20) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=23) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=26) {
		$p['a'.$i] = "2";
			}
		elseif ($i==27) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=30) {
		$p['a'.$i] = "1";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "2";
			}
		}
		return $p;
	
	}

	public function satu_pagi($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 1) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=4) {
		$p['a'.$i] = "2";
			}
		elseif ($i==5) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=8) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=11) {
		$p['a'.$i] = "2";
			}
		elseif ($i==12) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=15) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=18) {
		$p['a'.$i] = "2";
			}
		elseif ($i==19) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=22) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=25) {
		$p['a'.$i] = "2";
			}
		elseif ($i==26) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=29) {
		$p['a'.$i] = "1";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "2";
			}
		}
		return $p;
	
	}

	public function lead_off($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 1) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=4) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=7) {
		$p['a'.$i] = "2";
			}
		elseif ($i==8) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=11) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=14) {
		$p['a'.$i] = "2";
			}
		elseif ($i==15) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=18) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=21) {
		$p['a'.$i] = "2";
			}
		elseif ($i==22) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=25) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=28) {
		$p['a'.$i] = "2";
			}
		elseif ($i==29) {
		$p['a'.$i] = "0";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "1";
			}
		}
		return $p;
	
	}

	public function lead_off_arrays($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 1) {
		//$p = "0";
		$p['a'.$i] = "0";
			}
		elseif ($i<=4) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=7) {
		$p['a'.$i] = "2";
			}
		elseif ($i==8) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=11) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=14) {
		$p['a'.$i] = "2";
			}
		elseif ($i==15) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=18) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=21) {
		$p['a'.$i] = "2";
			}
		elseif ($i==22) {
		$p['a'.$i] = "0";
			}
			elseif ($i<=25) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=28) {
		$p['a'.$i] = "2";
			}
		elseif ($i==29) {
		$p['a'.$i] = "0";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "1";
			}
		}
		return $p;
	
	}

	public function tiga_malam($days)
	{
		$p = array();
	//echo "<table border='1'>";	

		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 3) {
		$p['a'.$i] = "2";
			}
		elseif ($i==4) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=7) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=10) {
		$p['a'.$i] = "2";
			}
			elseif ($i==11) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=14) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=17) {
		$p['a'.$i] = "2";
			}
			elseif ($i==18) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=21) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=24) {
		$p['a'.$i] = "2";
			}
			elseif ($i==25) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=28) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=31) {
		$p['a'.$i] = "2";
			}
		elseif ($i==32) {
		$p['a'.$i] = "0";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "1";
			}
		}
		return $p;
	//echo "</table>";	
	}

	public function dua_malam($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 2) {
		$p['a'.$i] = "2";
			}
		elseif ($i==3) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=6) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=9) {
		$p['a'.$i] = "2";
			}
			elseif ($i==10) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=13) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=16) {
		$p['a'.$i] = "2";
			}
			elseif ($i==17) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=20) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=23) {
		$p['a'.$i] = "2";
			}
			elseif ($i==24) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=27) {
		$p['a'.$i] = "1";
			}
			elseif ($i<=30) {
		$p['a'.$i] = "2";
			}
		elseif ($i==31) {
		$p['a'.$i] = "0";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "1";
			}
		}
		return $p;
			
	}

	public function satu_malam($days)
	{
		$p = array();
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 1) {
		$p['a'.$i] = "2";
			}
		elseif ($i==2) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=5) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=8) {
		$p['a'.$i] = "2";
			}
			elseif ($i==9) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=12) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=15) {
		$p['a'.$i] = "2";
			}
			elseif ($i==16) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=19) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=22) {
		$p['a'.$i] = "2";
			}
			elseif ($i==23) {
		$p['a'.$i] = "0";
			}
		elseif ($i<=26) {
		$p['a'.$i] = "1";
			}
		elseif ($i<=29) {
		$p['a'.$i] = "2";
			}
			elseif ($i==30) {
		$p['a'.$i] = "0";
			}
		elseif ($i<= $i) {
		$p['a'.$i] = "1";
			}
		}
		return $p;
	
	}

	public function export_rooster()
	{


$data = $this->rooster->rpt_rooster_excel();
		$spreadsheet = new Spreadsheet();

		// Set document properties
/*$spreadsheet->getProperties()->setCreator('Andoyo - Java Web Media')
->setLastModifiedBy('Andoyo - Java Web Medi')
->setTitle('Office 2007 XLSX Test Document')
->setSubject('Office 2007 XLSX Test Document')
->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
->setKeywords('office 2007 openxml php')
->setCategory('Test result file');*/

// Add some data
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A1', 'No')
->setCellValue('B1', 'Nama')
->setCellValue('C1', 'Nik')
->setCellValue('D1', 'Jabatan')
->setCellValue('E1', 'A1');

// Miscellaneous glyphs, UTF-8
$no = 1;
$i=2; 
foreach($data as $key) {
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $no)
		->setCellValue('B'.$i, $key->empname)
		->setCellValue('C'.$i, $key->nik_pim)
		->setCellValue('D'.$i, $key->remarks)
		->setCellValue('E'.$i, $key->a1);
		$i++;
		$no++;
		}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Report Excel');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
header('Cache-Control: max-age=0');
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

	public function header_exp()
	{
		$from = "26-04-2018";
		$to = "26-05-2018";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		//$day = array();
		$day = array('No','Nama','Nik','Jabatan');
		$datee = array(null, null, null, null);
		$datee = array();
		echo $batas." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;
		// menampilkan nama hari
		for ($i=0; $i < $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		//$date=date("d", $date);
		$dat=date("D", $date);
		$day[] = $dat;
		echo "<td>".$dat."</td>";
		}
		// menampilkan tanggal
		for ($i=0; $i < $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		$date=date("d", $date);
		//$dat=date("D", $date);
		$datee[] = $date;
		echo "<td>".$date."</td>";
		}
		$data_array = array($day, $datee);

		echo('<pre>');
		print_r($day);
		echo('</pre>');

		echo('<pre>');
		print_r($datee);
		echo('</pre>');

		$rowArray = ['Value1', 'Value2', 'Value3', 'Value4'];
		echo('<pre>');
		print_r($rowArray);
		echo('</pre>');

		echo('<pre>');
		print_r($data_array);
		echo('</pre>');
		for ($i=65; $i < 91 ; $i++) { 
			$huruf = chr($i);
			echo $huruf;
			echo "</br>";
			//echo $i;
			if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			echo $po;
			echo "</br>";
			}
			//echo "string";
			
			}
		}

$data = $this->rooster->rpt_rooster_excel();
$jml = count($data);
echo $data;
		echo "<hr>";
		echo('<pre>');
		print_r($data);
		echo('</pre>');
		echo "<table border=1>";
		echo "<tr>";
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($data as $key) {
				echo "<td>";
				echo $no; // menampilkan nomor urut
				echo "</td>";
				echo "<td>";
				echo $key->empname; // menampilkan nama
				echo "</td><td>";
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
				/*for ($i=1; $i < 2; $i++) { */
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											/*switch ($key->$cell) {
											case 0:
											$key->$cell = "OFF";
											break;
											case 1:
											$key->$cell = "P";
											break;
											case 2:
											$key->$cell = "M";
											break;
											}*/
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												//$po = "A".$huruf_;
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
											}
												echo $cell;
												echo $key->$cell;
												echo $setval;
												echo "</td><td>";
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
											}
										echo $cell;
										echo $key->$cell;
										echo $setval;
										echo "</td><td>";
										$i++;
									}
					$v++;
				/*}*/
				}
		echo "</tr>";
		$no++;
		$no_v++;
			}
		echo "</table>";

	}

	public function test_laporan(){
		$from = "26-04-2018";
		$to = "26-05-2018";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$data['data'] = $this->rooster->rpt_absensi_finger();
		$data['rooster'] = $this->satu_pagi($batas+1);

		echo('<pre>');
		print_r($data);
		echo('</pre>');
		$this->load->view('test_laporan_aja',$data);
	}

	public function test_shift()
	{
		$from = "26-04-2018";
		$to = "26-05-2018";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		echo $batas;
		$data = $this->satu_pagi($batas+1);
		$from = date_create(date("Y-m-d",strtotime(get_from_date_period("02", "2019"))));
		$to = date_create(date("Y-m-d",strtotime(get_to_date_period("02", "2019"))));
		$total = date_diff($from, $to);
		echo $total->format('%a')+1;
		echo('<pre>');
		print_r($total);
		echo('</pre>');

		foreach ($data as $key) {

		}

	}

	public function download_rooster()
	{
		$period = $this->input->post('periode');
		$year= $this->input->post('tahun');
		$print_date= $this->input->post('print_date');
		$dept= $this->input->post('f_dept');
		$this->export_rooster_rev1($period, $year, $print_date);			
		
		if ($dept == "0" ) {
			$this->export_rooster_rev1();			
		}
		else
		{
			$this->export_rooster_ex_pro_rev1($period, $year, $print_date);
		} 
	}

	// DOWNLOAD ROOSTER all departement
	public function export_rooster_ex_pro_rev1()
	{
		$from = "26-04-2018";
		$to = "26-05-2018";
		/*parameter untuk di query filter nya berdasarkan operator*/
		$ts = "14"; // dept TS
		$eng = "15"; // dept eng
		$ga = "16"; // opr water tank
		$log = "17"; //opr motor grader
		$hse = "18"; //opr dozer
		$hr = "19"; //opr exa
		$it = "20"; //opr dt
		$fin = "21"; //opr oht

		$period = $this->input->post('periode');
		$year= $this->input->post('tahun');
		$print_date= $this->input->post('print_date');
		
		$from = get_from_date_period($period, $year);
		$to = get_to_date_period($period, $year);
		$get_date = get_date_period($period, $year);
		$a = date_create(date("Y-m-d",strtotime($get_date->start_date)));
		$b = date_create(date("Y-m-d",strtotime($get_date->end_date)));
		//$b = date("Y-m-d",strtotime($to));
		$total = total_hari($period, $year);
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$total = $batas;
		$day = array('No','Nama','Nik','Jabatan');
		$datee = array(null, null, null, null);
		echo $batas." Hari";
		echo "<br>";
		echo "Periode ".$get_date->start_date." - ".$get_date->end_date;
		// menampilkan nama hari
		for ($i=0; $i <= $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($get_date->start_date)),date("d",strtotime($get_date->start_date))+$i,date("Y",strtotime($get_date->start_date)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		//$date=date("d", $date);
		$dat=date("D", $date);
		$day[] = $dat;
		echo "<td>".$dat."</td>";
		}
		// menampilkan tanggal
		for ($i=0; $i <= $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($get_date->start_date)),date("d",strtotime($get_date->start_date))+$i,date("Y",strtotime($get_date->start_date)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		$date=date("d", $date);
		//$dat=date("D", $date);
		$datee[] = $date;
		echo "<td>".$date."</td>";
		}
		$data_array = array($day, $datee);
		$spreadsheet = new Spreadsheet();

		// Set document properties
/*$spreadsheet->getProperties()->setCreator('Andoyo - Java Web Media')
->setLastModifiedBy('Andoyo - Java Web Medi')
->setTitle('Office 2007 XLSX Test Document')
->setSubject('Office 2007 XLSX Test Document')
->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
->setKeywords('office 2007 openxml php')
->setCategory('Test result file');*/

// Add some data
$spreadsheet->getActiveSheet()
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
$spreadsheet->getActiveSheet()->mergeCells('A1:A2');
$spreadsheet->getActiveSheet()->mergeCells('B1:B2');
$spreadsheet->getActiveSheet()->mergeCells('C1:C2');
$spreadsheet->getActiveSheet()->mergeCells('D1:D2');
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->getActiveSheet()->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->getActiveSheet()->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}

//  hand picker

/* end hand picker*/
/*$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);*/

/* FOR COLLOR RED $spreadsheet->getActiveSheet()->getStyle('B3:B7')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/
// Miscellaneous glyphs, UTF-8

/*$no = 1;
$a = 1;
$i=3; 
foreach($data as $key) {
	$n = "a".$a;
	if ($key->$n == 0) {
			$key->$n = "OFF";
			}
			elseif ($key->$n == 1) {
			$key->$n = "P";
			}
			elseif ($key->$n == 2) {
			$key->$n = "M";
			}
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $no)
		->setCellValue('B'.$i, $key->empname)
		->setCellValue('C'.$i, $key->nik_pim)
		->setCellValue('D'.$i, $key->remarks)
		->setCellValue('E'.$i, $key->$n)
		->setCellValue('F'.$i, $key->a2)
		->setCellValue('G'.$i, $key->a3);
		$i++;
		$a++;
		$no++;
		}*/
		$data = $this->rooster->rpt_rooster_excel($period, $year, $ts); // memanggil model operator OHT

		$jml_array = count($data);
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($data as $key) {
				/*echo "<td>";
				echo $no; // menampilkan nomor urut
				echo "</td>";
				echo "<td>";
				echo $key->empname; // menampilkan nama
				echo "</td><td>";*/

				$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
	
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
				/*for ($i=1; $i < 2; $i++) { */
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											/*switch ($key->$cell) {
											case 0:
											$key->$cell = "OFF";
											break;
											case 1:
											$key->$cell = "P";
											break;
											case 2:
											$key->$cell = "M";
											break;
											}*/
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												//$po = "A".$huruf_;
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
												

												/*echo $cell;
												echo $key->$cell;
												echo $setval;
												echo "</td><td>";*/
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);
											
											}
										/*echo $cell;
										echo $key->$cell;
										echo $setval;
										echo "</td><td>";*/
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				/*}*/
				}
		/*echo "</tr>";*/
		$no++;
		$no_v++;
			}

			

			$data_tot = $this->rooster->total_pagi_malam($period, $year, $ts);
			$no_ttl = $jml_array+4;
			$no_tt = $no_ttl+1;
			$no_t = $no_tt+1;
			$no_total = 0;
		$spreadsheet->getActiveSheet()->mergeCells('A'.$no_ttl.':C'.$no_t.'');
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$no_ttl, "TOTAL MAN POWER ");

		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_ttl, "PAGI");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_tt, "MALAM");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_t, "OFF")->getStyle('D'.$no_t)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');

    /*$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/

			$spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[0],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_ttl         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
		    $spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[1],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_tt         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
		    $spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[2],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_t         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

// Rename worksheet
$spreadsheet->getActiveSheet(0)->setTitle('Technical Support');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// sheeet untuk trafficman and general helper
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'ENGINEERING');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $eng); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(1)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(1)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(1)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(1)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $eng);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $eng); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER ");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(1);
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(1)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(1)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// end of sheet trafficman and general helper




// membuat sheet baru
$awl = date_input($get_date->start_date);
$akr = date_input($get_date->end_date);
//$absen = $this->rooster->rpt_absensi_except_pro($get_date->start_date, $get_date->end_date);
$absen = $this->rooster->rpt_absensi_except_pro_rev01($get_date->start_date, $get_date->end_date);

// Create a new worksheet called "My Data"
$myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Absensi');
// Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
$spreadsheet->addSheet($myWorkSheet);

/*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(2)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(2)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
// Add some data
$spreadsheet->setActiveSheetIndex(2)
        ->setCellValue('A1', 'No Pegawai')
        ->setCellValue('B1', 'Nama')
        ->setCellValue('C1', 'Tanggal')
        ->setCellValue('D1', 'Shift')
        ->setCellValue('E1', 'Akhir Tugas')
        ->setCellValue('F1', 'Masuk')
        ->setCellValue('G1', 'Keluar')
        ->setCellValue('H1', 'Telat');
$spreadsheet->getActiveSheet(2);

$rn_abesen = 2;
foreach ($absen as $key) {
	# code...
$spreadsheet->setActiveSheetIndex(2)
		->setCellValue('A'.$rn_abesen, $key->nik_pim)
		->setCellValue('B'.$rn_abesen, $key->empname)
		->setCellValue('C'.$rn_abesen, $key->tanggal)
		->setCellValue('D'.$rn_abesen, $key->shift)
		->setCellValue('E'.$rn_abesen, $key->tanggal)
		->setCellValue('F'.$rn_abesen, $key->check_in)
		->setCellValue('G'.$rn_abesen, $key->check_out)
		->setCellValue('H'.$rn_abesen, $key->late);
$rn_abesen++;
}

// sheeet untuk checker
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'GENERAL AFFAIRS');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $ga); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(3)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(3)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(3)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(3)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $ga);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $ga); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(3);
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(3)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(3)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF CHECKER


// sheeet untuk wt
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'LOGISTIC');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $log); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(4)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(4)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(4)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(4)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $log);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $log); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(4);
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(4)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(4)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF WT

// sheeet untuk mg
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'LOGISTICS');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $log); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(5)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(5)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(5)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(5)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $log);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $log); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(5);
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(5)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(5)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF mg

// sheeet untuk bd
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'HSE');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $hse); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(6)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(6)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(6)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(6)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $hse);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $hse); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(6);
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(6)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(6)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF bd
// sheeet untuk ex
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'HUMAN RESOURCES');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $hr); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(7)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(7)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(7)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(7)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $hr);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $hr); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(7);
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(7)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(7)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF ex

// sheeet untuk dt
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'IT');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $it); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(8)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(8)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(8)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(8)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $it);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $it); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('A'.$cell_pagi, "TOTAL MAN POWER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(8);
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(8)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(8)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF dt

// sheeet untuk PIT SERVICE
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'FINANCE');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $fin); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(9)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(9)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(9)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(9)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $fin);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $fin); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('A'.$cell_pagi, "TOTAL PIT SERVICES");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(9);
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(9)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(9)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF PIT SERVICE

/* sheet
jika akan menambah sheet pada report excel :
1. copy paste saja dari list code yang sudah di remarks
2. ganti di setiap parameter gang code model
3. ganti nama sheet
4. ganti setactivesheetindex() sesuaikan dengan urutan sheet terakhir
*/
/*$spreadsheet->getActiveSheet(1)->getStyle('B3:B7')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/

// Redirect output to a client’s web browser (Xlsx)
$nama_file = date("Y-m-d H:i:s");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rooster-'.$year.$period.'_'.$nama_file.'.xlsx"');
header('Cache-Control: max-age=0');
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

	public function export_rooster_rev1()
	{
		$from = "26-04-2018";
		$to = "26-05-2018";
		/*parameter untuk di query filter nya berdasarkan operator*/
		$tgh = "4"; // opr trafficman general helper
		$ck = "5"; // opr checker
		$wt = "6"; // opr water tank
		$mg = "7"; //opr motor grader
		$bd = "8"; //opr dozer
		$ex = "9"; //opr exa
		$dt = "10"; //opr dt
		$oht = "11"; //opr oht
		$pit = "12"; // pit service
		$hp = "3"; //handpicker

		$period = $this->input->post('periode');
		$year= $this->input->post('tahun');
		$print_date= $this->input->post('print_date');
		$get_period = get_date_period($period, $year);
		$from = $get_period->start_date;
		$to = $get_period->end_date;
		//$from = get_from_date_period($period, $year);
		//$to = get_to_date_period($period, $year);
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));
		$total = total_hari($period, $year);
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$day = array('No','Nama','Nik','Jabatan');
		$datee = array(null, null, null, null);
		echo $batas." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;
		// menampilkan nama hari
		for ($i=0; $i <= $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		//$date=date("d", $date);
		$dat=date("D", $date);
		$day[] = $dat;
		echo "<td>".$dat."</td>";
		}
		// menampilkan tanggal
		for ($i=0; $i <= $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		$date=date("d", $date);
		//$dat=date("D", $date);
		$datee[] = $date;
		echo "<td>".$date."</td>";
		}
		$data_array = array($day, $datee);
		$spreadsheet = new Spreadsheet();

		// Set document properties
/*$spreadsheet->getProperties()->setCreator('Andoyo - Java Web Media')
->setLastModifiedBy('Andoyo - Java Web Medi')
->setTitle('Office 2007 XLSX Test Document')
->setSubject('Office 2007 XLSX Test Document')
->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
->setKeywords('office 2007 openxml php')
->setCategory('Test result file');*/

// Add some data
$spreadsheet->getActiveSheet()
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
$spreadsheet->getActiveSheet()->mergeCells('A1:A2');
$spreadsheet->getActiveSheet()->mergeCells('B1:B2');
$spreadsheet->getActiveSheet()->mergeCells('C1:C2');
$spreadsheet->getActiveSheet()->mergeCells('D1:D2');
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->getActiveSheet()->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->getActiveSheet()->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}

//  hand picker

/* end hand picker*/
/*$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);*/

/* FOR COLLOR RED $spreadsheet->getActiveSheet()->getStyle('B3:B7')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/
// Miscellaneous glyphs, UTF-8

/*$no = 1;
$a = 1;
$i=3; 
foreach($data as $key) {
	$n = "a".$a;
	if ($key->$n == 0) {
			$key->$n = "OFF";
			}
			elseif ($key->$n == 1) {
			$key->$n = "P";
			}
			elseif ($key->$n == 2) {
			$key->$n = "M";
			}
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $no)
		->setCellValue('B'.$i, $key->empname)
		->setCellValue('C'.$i, $key->nik_pim)
		->setCellValue('D'.$i, $key->remarks)
		->setCellValue('E'.$i, $key->$n)
		->setCellValue('F'.$i, $key->a2)
		->setCellValue('G'.$i, $key->a3);
		$i++;
		$a++;
		$no++;
		}*/
		$data = $this->rooster->rpt_rooster_excel($period, $year, $oht); // memanggil model operator OHT

		$jml_array = count($data);
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($data as $key) {
				/*echo "<td>";
				echo $no; // menampilkan nomor urut
				echo "</td>";
				echo "<td>";
				echo $key->empname; // menampilkan nama
				echo "</td><td>";*/

				$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
	
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
				/*for ($i=1; $i < 2; $i++) { */
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											/*switch ($key->$cell) {
											case 0:
											$key->$cell = "OFF";
											break;
											case 1:
											$key->$cell = "P";
											break;
											case 2:
											$key->$cell = "M";
											break;
											}*/
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												//$po = "A".$huruf_;
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
												

												/*echo $cell;
												echo $key->$cell;
												echo $setval;
												echo "</td><td>";*/
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);
											
											}
										/*echo $cell;
										echo $key->$cell;
										echo $setval;
										echo "</td><td>";*/
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				/*}*/
				}
		/*echo "</tr>";*/
		$no++;
		$no_v++;
			}

			

			$data_tot = $this->rooster->total_pagi_malam($period, $year, $oht);
			$no_ttl = $jml_array+4;
			$no_tt = $no_ttl+1;
			$no_t = $no_tt+1;
			$no_total = 0;
		$spreadsheet->getActiveSheet()->mergeCells('A'.$no_ttl.':C'.$no_t.'');
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$no_ttl, "TOTAL OPERATOR OHT");

		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_ttl, "PAGI");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_tt, "MALAM");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$no_t, "OFF")->getStyle('D'.$no_t)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');

    /*$spreadsheet->setActiveSheetIndex(0)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/

			$spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[0],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_ttl         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
		    $spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[1],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_tt         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
		    $spreadsheet->getActiveSheet(0)->fromArray(
		        $data_tot[2],  // The data to set
		        NULL,        // Array values with this value will not be set
		        'E'.$no_t         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

// Rename worksheet
$spreadsheet->getActiveSheet(0)->setTitle('OHT');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// sheeet untuk trafficman and general helper
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'TRAFFICMAN AND GENERAL HELPER');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $tgh); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(1)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(1)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(1)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(1)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(1)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $tgh);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $tgh); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('A'.$cell_pagi, "TOTAL TRAFFICMAN & GENERAL HELPER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(1);
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(1)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(1)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(1)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(1)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// end of sheet trafficman and general helper




// membuat sheet baru
$awl = date_input($from);
$akr = date_input($to);
//$absen = $this->rooster->rpt_absensi_finger($awl,$akr);
$absen = $this->rooster->rpt_absensi_pro_rev01($awl,$akr);

// Create a new worksheet called "My Data"
$myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Absensi');
// Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
$spreadsheet->addSheet($myWorkSheet);

/*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(2)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(2)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
// Add some data
$spreadsheet->setActiveSheetIndex(2)
        ->setCellValue('A1', 'No Pegawai')
        ->setCellValue('B1', 'Nama')
        ->setCellValue('C1', 'Jabatan')
        ->setCellValue('D1', 'Tanggal')
        ->setCellValue('E1', 'Shift')
        ->setCellValue('F1', 'Akhir Tugas')
        ->setCellValue('G1', 'Masuk')
        ->setCellValue('H1', 'Keluar')
        ->setCellValue('I1', 'Telat');
$spreadsheet->getActiveSheet(2);

$rn_abesen = 2;
foreach ($absen as $key) {
	# code...
$spreadsheet->setActiveSheetIndex(2)
		->setCellValue('A'.$rn_abesen, $key->nik_pim)
		->setCellValue('B'.$rn_abesen, $key->empname)
		->setCellValue('C'.$rn_abesen, $key->remarks)
		->setCellValue('D'.$rn_abesen, $key->tanggal)
		->setCellValue('E'.$rn_abesen, $key->shift)
		->setCellValue('F'.$rn_abesen, $key->tanggal)
		->setCellValue('G'.$rn_abesen, $key->check_in)
		->setCellValue('H'.$rn_abesen, $key->check_out)
		->setCellValue('I'.$rn_abesen, $key->late);
$rn_abesen++;
}

// sheeet untuk checker
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'CHECKER');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $ck); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(3)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(3)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(3)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(3)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(3)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $ck);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $tgh); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('A'.$cell_pagi, "TOTAL CHECKER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(3);
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(3)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(3)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(3)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(3)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF CHECKER


// sheeet untuk wt
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'WT');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $wt); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(4)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(4)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(4)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(4)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(4)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $wt);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $wt); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('A'.$cell_pagi, "TOTAL OPERATOR WATER TRUCK");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(4);
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(4)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(4)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(4)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(4)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF WT

// sheeet untuk mg
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'MG');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $mg); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(5)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(5)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(5)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(5)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(5)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $mg);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $mg); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('A'.$cell_pagi, "TOTAL OPERATOR MOTOR GRADER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(5);
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(5)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(5)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(5)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(5)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF mg

// sheeet untuk bd
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'BD');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $bd); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(6)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(6)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(6)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(6)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(6)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $bd);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $bd); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('A'.$cell_pagi, "TOTAL OPERATOR BULLDOZER");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(6);
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(6)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(6)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(6)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(6)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF bd
// sheeet untuk ex
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'EX');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $ex); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(7)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(7)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(7)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(7)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(7)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $ex);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $ex); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('A'.$cell_pagi, "TOTAL OPERATOR EXCAVATORS");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(7);
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(7)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(7)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(7)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(7)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF ex

// sheeet untuk dt
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'DT');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $dt); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(8)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(8)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(8)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(8)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(8)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $dt);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $dt); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('A'.$cell_pagi, "TOTAL OPERATOR DUMP TRUCKS");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(8);
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(8)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(8)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(8)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(8)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF dt

// sheeet untuk PIT SERVICE
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'PIT SERVICE');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $pit); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(9)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(9)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(9)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(9)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(9)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $pit);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $pit); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('A'.$cell_pagi, "TOTAL PIT SERVICES");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(9);
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(9)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(9)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(9)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(9)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(9)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF PIT SERVICE

// sheeet untuk hand picker
$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'HAND PICKER');
$spreadsheet->addSheet($sheet_tgh);
$general = $this->rooster->rpt_rooster_excel($period, $year, $hp); // memanggil model operator OHT
// sebagai batas awal total pagi malam off
$gen_helper = count($general);
// header laporan nama hari dan tanggal
$spreadsheet->setActiveSheetIndex(10)
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */
$spreadsheet->setActiveSheetIndex(10)->mergeCells('A1:A2');
$spreadsheet->setActiveSheetIndex(10)->mergeCells('B1:B2');
$spreadsheet->setActiveSheetIndex(10)->mergeCells('C1:C2');
$spreadsheet->setActiveSheetIndex(10)->mergeCells('D1:D2');
    /*merge untuk menyesuaikan dengan 2 baris kolom nama hari dan tanggal */

    /*membuat autosize kepada setiap nama cell*/
for ($i=65; $i <91 ; $i++) { 
	$hur = chr($i);
$spreadsheet->setActiveSheetIndex(10)->getColumnDimension($hur)->setAutoSize(true);
	if ($i == 90) {
				# code...
			for ($a=65; $a < 91 ; $a++) { 
			$huruf_ = chr($a);
			$po = "A".$huruf_;
			//echo $po;
$spreadsheet->setActiveSheetIndex(10)->getColumnDimension($po)->setAutoSize(true); // output berupa AA AB AC s/d AZ
			//echo "</br>";
			}
			}
}
    /*membuat autosize kepada setiap nama cell*/
    // model data rooster dan total kehadiran
$total_kehadiran_trafficman = $this->rooster->total_pagi_malam($period, $year, $hp);
$kl = $this->rooster->rpt_rooster_excel($period, $year, $hp); // memanggil model operator OHT


$cell_pagi = $gen_helper+4; // set nomor cell untuk cell pagi
$cell_malem = $cell_pagi+1; // set nomor cell untuk cell malam
$off = $cell_malem+1;		// set nomor cell untuk cell off
/*total operator*/
// menampilkan judul total kehadiran harian
$spreadsheet->getActiveSheet()->mergeCells('A'.$cell_pagi.':C'.$off.'');
		$spreadsheet->setActiveSheetIndex(10)
		->setCellValue('A'.$cell_pagi, "TOTAL PIT SERVICES");
/*total operator*/
    $spreadsheet->setActiveSheetIndex(10);
		$spreadsheet->setActiveSheetIndex(10)->setCellValue('D'.$cell_pagi, "PAGI");
		$spreadsheet->setActiveSheetIndex(10)->setCellValue('D'.$cell_malem, "MALAM");
		$spreadsheet->setActiveSheetIndex(10)->setCellValue('D'.$off, "OFF")->getStyle('D'.$off)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
$no_ttal = $cell_pagi;
    foreach ($total_kehadiran_trafficman as $key) {
    	$spreadsheet->setActiveSheetIndex(10)
		->setCellValue('E'.$no_ttal, $key->a1)
		->setCellValue('F'.$no_ttal, $key->a2)
		->setCellValue('G'.$no_ttal, $key->a3)
		->setCellValue('H'.$no_ttal, $key->a4)
		->setCellValue('I'.$no_ttal, $key->a5)
		->setCellValue('J'.$no_ttal, $key->a6)
		->setCellValue('K'.$no_ttal, $key->a7)
		->setCellValue('L'.$no_ttal, $key->a8)
		->setCellValue('M'.$no_ttal, $key->a9)
		->setCellValue('N'.$no_ttal, $key->a10)
		->setCellValue('O'.$no_ttal, $key->a11)
		->setCellValue('P'.$no_ttal, $key->a12)
		->setCellValue('Q'.$no_ttal, $key->a13)
		->setCellValue('R'.$no_ttal, $key->a14)
		->setCellValue('S'.$no_ttal, $key->a15)
		->setCellValue('T'.$no_ttal, $key->a16)
		->setCellValue('U'.$no_ttal, $key->a17)
		->setCellValue('V'.$no_ttal, $key->a18)
		->setCellValue('W'.$no_ttal, $key->a19)
		->setCellValue('X'.$no_ttal, $key->a20)
		->setCellValue('Y'.$no_ttal, $key->a21)
		->setCellValue('Z'.$no_ttal, $key->a22)
		->setCellValue('AA'.$no_ttal, $key->a23)
		->setCellValue('AB'.$no_ttal, $key->a24)
		->setCellValue('AC'.$no_ttal, $key->a25)
		->setCellValue('AD'.$no_ttal, $key->a26)
		->setCellValue('AE'.$no_ttal, $key->a27)
		->setCellValue('AF'.$no_ttal, $key->a28)
		->setCellValue('AG'.$no_ttal, $key->a29)
		->setCellValue('AH'.$no_ttal, $key->a30)
		->setCellValue('AI'.$no_ttal, $key->a31)
		->setCellValue('AJ'.$no_ttal, $key->a32);
		$no_ttal++;
    }
    /*memlakukan perulangan untuk menampilkan total kehadiran harian di mulai dari pagi malam off*/
/* end of header laporan*/
/*perulangan data absensi rooster*/
		$no = 1; // nomor urut
		$no_v = 3; // nomor urut cell dimulai dari baris ke 3
			foreach ($general as $key) {
				$spreadsheet->setActiveSheetIndex(10)
		->setCellValue('A'.$no_v, $no)
		->setCellValue('B'.$no_v, $key->empname)
		->setCellValue('C'.$no_v, $key->nik_pim)
		->setCellValue('D'.$no_v, $key->remarks);
				// perulangan hanya huruf A saja, karena di table database hanya dari a1 - a32
				for ($a=65; $a < 66 ; $a++) { 
					$hrf_a = strtolower(chr($a)); // menampilkan huruf a kecil
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
									/*perulangan nama cell untk setcellvalue dengan uppercase */
									for ($c=69; $c < 92 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
											
											$k = $i;
											if ($c == 91) {
												for ($a=65; $a < 75 ; $a++) { 
												$huruf_ = chr($a);
												$cell = $hrf_a.$k;

												$setval = "A".$huruf_.$v;
												if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell);

											}
												$k++;
												}
											}
											if ($key->$cell == 0) {
											$key->$cell = "OFF";
											$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell)->getStyle($setval)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
											}
											elseif ($key->$cell == 1) {
											$key->$cell = "P";
												$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell);

											}
											elseif ($key->$cell == 2) {
											$key->$cell = "M";
												$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell);
											
											}
												$spreadsheet->setActiveSheetIndex(10)->setCellValue($setval, $key->$cell);

										$i++;
									}
					$v++;
				}
		$no++;
		$no_v++;
			}
			/*footer total yang bekerja*/
$spreadsheet->getActiveSheet(10)->getPageSetup()->setFitToWidth(100);
$spreadsheet->getActiveSheet(10)->getPageSetup()->setFitToHeight(0);
		    /*end of total yang bekerja*/
// END OF hand picker
/* sheet
jika akan menambah sheet pada report excel :
1. copy paste saja dari list code yang sudah di remarks
2. ganti di setiap parameter gang code model
3. ganti nama sheet
4. ganti setactivesheetindex() sesuaikan dengan urutan sheet terakhir
*/
/*$spreadsheet->getActiveSheet(1)->getStyle('B3:B7')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');*/

// Redirect output to a client’s web browser (Xlsx)
$nama_file = date("Y-m-d H:i:s");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rooster-'.$year.$period.'_'.$nama_file.'.xlsx"');
header('Cache-Control: max-age=0');
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

	public function test_query($period, $year, $oht)
	{	
		$peri = $period;
		$thn = $year;
		$oh = 11;
		$tgh = 4;
		//$data = $this->rooster->total_pagi_malam($period, $tahun, $id_gang);
		$absen = $this->rooster->rpt_absensi_finger($peri, $thn);
		$data_tot = $this->rooster->total_pagi_malam($peri, $thn, $oh);
			$tg = $this->rooster->total_pagi_malam($period, $year, $oh);
$gen = $this->rooster->total_pagi_malam($period, $year, $tgh);

			echo $data_tot[0][0];
		echo('<pre>');
		print_r($gen);
		echo('</pre>');
		echo $from = get_from_date_period($period, $year);
		echo $to = get_to_date_period($period, $year);
		

	}

	public function draw_calendar($month,$year){

	// Draw table for Calendar 
		$calendar = '
		<table cellpadding="0" cellspacing="0" class="calendar">';

	// Draw Calendar table headings 
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar.= '<tr class="calendar-row">
		<td class="calendar-day-head">'.implode('</td>
			<td class="calendar-day-head">',$headings).'</td>
		</tr>
		';

	//days and weeks variable for now ... 
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();

	// row for week one 
		$calendar.= '
		<tr class="calendar-row">';

	// Display "blank" days until the first of the current week 
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '
			<td class="calendar-day-np"> </td>
			';
			$days_in_this_week++;
		endfor;

	// Show days.... 
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			if($list_day==date('d') && $month==date('n'))
			{
				$currentday='currentday';
			}else
			{
				$currentday='';
			}
			$calendar.= '
			<td class="calendar-day '.$currentday.'">';

			// Add in the day number
			if($list_day<date('d') && $month==date('n'))
			{
				$showtoday='<strong class="overday">'.$list_day.'</strong>';
			}else
			{
				$showtoday=$list_day;
			}
			$calendar.= '
			<div class="day-number">'.$showtoday.'</div>
			';

		// Draw table end
			$calendar.= '</td>
			';
			if($running_day == 6):
				$calendar.= '</tr>
				';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '
					<tr class="calendar-row">';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

	// Finish the rest of the days in the week
		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= '
				<td class="calendar-day-np"> </td>
				';
			endfor;
		endif;

	// Draw table final row
		$calendar.= '</tr>
		';

	// Draw table end the table 
		$calendar.= '</table>
		';

	// Finally all done, return result 
		echo $calendar;
}



/*controller ini akan di panggil saat user input rooster 
jadi di sini dalam satu form akan menginput ke 2 table yaitu 
1. table emp_rooster untuk laporan excel produksi
2. table absensi_rooster untuk data absensi yang di butuhkan HR dan PRODUKSI*/
/*public function test_rooster()
	{
		$empcode = "1800001";
		$period = "5";
		$tahun = "2018";
		$from = "26-04-2018";
		$to = "26-05-2018";
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		echo $batas." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;
		for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}
echo "</tr><tr>";
$data_ar = array();
for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i < 3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
	elseif ($i<6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);

	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}

		echo('<pre>');
		print_r($data_ar);
		echo('</pre>');
}*/


public function absensi_rooster_satu_pagi($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "5";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i < 1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
	elseif ($i<4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

}

public function absensi_rooster_dua_pagi($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "5";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i < 2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
	elseif ($i<5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

}

public function absensi_rooster_tiga_pagi($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "3";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i < 3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
	elseif ($i<6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

}


public function absensi_rooster_satu_malam($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "3";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i<1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$this->rooster->insert_rooster_absensi($data_ar);
	

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for satu malam


public function absensi_rooster_dua_malam($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "3";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i<2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for dua malam

public function absensi_rooster_tiga_malam($empcode, $period, $tahun, $id)
	{
		/*$empcode = "1800001";
		$period = "3";
		$tahun = "2018";*/
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
		/*echo $jml_hari." Hari";
		echo "<br>";
		echo "Periode ".$from." - ".$to;*/
		/*for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
//$date=date("d", $date);
$dat=date("D", $date);


echo "<td>".$dat."</td>";
}*/
/*echo "</tr><tr>";*/
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);
//echo "<br>";
//$dat=date("D", $date);
//echo "<td>".$date."</td>";
	if ($i<3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	

/*	if (!$insert) {
		echo "data not saved";
	}
else
{
	echo "data saved";
}*/

		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam


public function absensi_rooster_satu_off($empcode, $period, $tahun, $id)
	{

		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		//$b = date("Y-m-d",strtotime($to));

		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$date=date("Y-m-d", $date);

	if ($i==0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i<28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	}
elseif ($i==28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
		} // end for

} // end for satu off

/*rooster untuk reguler pagi*/

public function absensi_rooster_reg_p_off($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i==0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
		} // end for
} // end for satu off

public function absensi_rooster_reg_p_satu($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam

public function absensi_rooster_reg_p_dua($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam

public function absensi_rooster_reg_p_tiga($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam

public function absensi_rooster_reg_p_empat($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==32) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam

public function absensi_rooster_reg_p_lima($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=32) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam

public function absensi_rooster_reg_p_enam($empcode, $period, $tahun, $id)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
	if ($i<= 5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}
elseif ($i==6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	}
elseif ($i==34) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/*echo('<pre>');
		print_r($data_ar);
		echo('</pre>');*/
		} // end for

} // end for tiga malam





public function rooster_update_satu_pagi()
{
	$from = "2018-06-13"; 
		$to = "2018-06-25"; 
		$a = date_create(date("Y-m-d",strtotime($from)));
				$b = date_create(date("Y-m-d",strtotime($to)));
				$c = date_diff($a,$b);
				$batas = $c->format('%a');
				echo "batasnya : ".$batas;
$data_ar = array();
		for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
$id = "29";
if ($i<3) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  }
elseif ($i==3) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  }
elseif ($i<7) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  }
elseif ($i<10) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  }
elseif ($i==10) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  }
elseif ($i<14) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  }
elseif ($i<17) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  }
elseif ($i==17) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  }
elseif ($i<21) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  }
elseif ($i<24) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  }

	echo('<pre>');
		print_r($data_ar);
		echo('</pre>');
}
}

	public function update_absensi_rooster_satu_off($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i==0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "2";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
		} // end for

} // end for satu off


public function update_absensi_rooster_satu_pagi($id, $start_date, $end_date)
  {
    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');

$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);
  if ($i < 1) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";
    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
  elseif ($i<4) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==4) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<8) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<11) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==11) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<15) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<18) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==18) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<22) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<25) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==25) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<29) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<31) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

}

public function update_absensi_rooster_dua_pagi($id, $start_date, $end_date)
  {
    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));
    //$b = date("Y-m-d",strtotime($to));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

  if ($i < 2) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";
    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
  elseif ($i<5) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==5) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<9) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<12) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==12) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<16) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<19) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==19) {
    for ($a=0; $a < 1; $a++) { 
     $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<23) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<26) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==26) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<30) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<33) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

}

public function update_absensi_rooster_tiga_pagi($id, $start_date, $end_date)
  {
    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');
   
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

  if ($i < 3) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";
    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
  elseif ($i<6) {
    for ($a=0; $a < 1; $a++) { 
     $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==6) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<10) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<13) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==13) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<17) {
    for ($a=0; $a < 1; $a++) { 
     $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<20) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==20) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<24) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<27) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==27) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<31) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

}


public function update_absensi_rooster_satu_malam($id, $start_date, $end_date)
  {
    
    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

  if ($i<1) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==1) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<5) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<8) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==8) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<12) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<15) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==15) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<19) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<22) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==22) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<26) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<29) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==29) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<33) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

} // end for satu malam


public function update_absensi_rooster_dua_malam($id, $start_date, $end_date)
  {
    
    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');
   
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

  if ($i<2) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==2) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<6) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<9) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==9) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<13) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<16) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==16) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<20) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<23) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==23) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<27) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<30) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==30) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<33) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

} // end for dua malam

public function update_absensi_rooster_tiga_malam($id, $start_date, $end_date)
  {

    $from = $start_date;
    $to = $end_date;
    $a = date_create(date("Y-m-d",strtotime($from)));
    $b = date_create(date("Y-m-d",strtotime($to)));

    $c = date_diff($a,$b);
    $batas = $c->format('%a');
   
    
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));

$date=date("Y-m-d", $date);

  if ($i<3) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==3) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<7) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<10) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==10) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<14) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<17) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==17) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<21) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<24) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==24) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<28) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<31) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "2";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i==31) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "0";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }
elseif ($i<33) {
    for ($a=0; $a < 1; $a++) { 
      $data_ar['id'] = $id;
      $data_ar['tanggal'] = $date;
      $data_ar['shift'] = "1";

    }
  $this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
  }

    /*echo('<pre>');
    print_r($data_ar);
    echo('</pre>');*/
    } // end for

} // end for tiga malam

// update table absensi untuk rooster reguler pagi
public function update_absensi_rooster_reg_p_off($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i==0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for satu off

public function update_absensi_rooster_reg_p_satu($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=7) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=14) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=28) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for satu off

public function update_absensi_rooster_reg_p_dua($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=1) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=8) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=15) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=22) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=29) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for reguler dua

public function update_absensi_rooster_reg_p_tiga($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=2) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=9) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=16) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=23) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=30) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for reguler dua

public function update_absensi_rooster_reg_p_empat($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=3) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=10) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=17) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=24) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for reguler dua


public function update_absensi_rooster_reg_p_lima($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=4) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=11) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=18) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=25) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==26) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=32) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==31) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for reguler dua

public function update_absensi_rooster_reg_p_enam($id, $start_date, $end_date)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
$data_ar = array();
for ($i=0; $i <= $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=5) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==6) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=12) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==13) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=19) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==20) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=21) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==27) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=33) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==34) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";

		}
	$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

		} // end for

} // end for reguler dua


public function data_karyawan_produksi()
{
	//$host = "localhost"; // alamat database
	$host = "192.168.11.7"; // alamat database
	$user = "gandhi"; // username
	$password = "gandhi13"; // password
	$db_or_dsn_name = "hris"; // database name

	ini_set('display_errors', 0);

	// panggil library php jasper dan tcpdf
	$this->load->library('PHPJasperXML');
	$this->load->library('tcpdf/TCPDF');

	$path = site_url('report/karyawan_produksi.jrxml');
	//$path = site_url('report/hse.jrxml');
	//$path = site_url('report/dakar_finance.jrxml');
	$xml = simplexml_load_file($path);
	$PHPJasperXML = new PHPJasperXML();
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $user, $password, $db_or_dsn_name);
	ob_start();
	$PHPJasperXML->outpage("I"); // I untuk preview dan D untuk force download
	ob_end_flush();
}

/*module HM unit*/
public function hm_unit(){
	/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = "prod";
		
		
		if (!$this->ion_auth->logged_in()) {
			/*jika tidak ada session  maka akan di redirect ke halaman login*/
			redirect('auth/login', 'refresh');
			/**/
		}
		else{
			$data['show_input'] = "$('#border_input').show();";
				$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
				/*$data['dept'] = $this->lov->dept();*/
				/*$data['empcode'] = $this->emp_rn();*/
				$data['title'] = 'HMKM Daily Poduction';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		        $data['dd_operator'] = $this->lov->dd_operator();
		        $data['operator_code'] = $this->input->post('f_operator') ? $this->input->post('f_operator') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        

		        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle_op();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';        

		        //dropdown untuk vehicle code
				$data['dd_material_code'] = $this->lov->dd_materials_produksi();
		        $data['material_code'] = $this->input->post('f_material') ? $this->input->post('f_material') : '';     
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_hm_unit');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_hm_unit',$data);
		        }
			    else
			    {
				$data['show_input'] = "$('#border_input').hide();";
				$this->load->view('temp/title',$data);
				$this->load->view('temp/header');
				$this->load->view('temp/sidebar');
				$this->load->view('f_hm_unit');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_hm_unit',$data);

						//return show_error('You must be an administrator to view this page.');

			    }
		}
	}

	public function veh_daily_list()
	{
		$list = $this->veh_daily->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $veh_doc) {
			$no++;
			$row = array();
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id_rn."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id_rn."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$row[] = $no;
			$row[] = $veh_doc->date;
			$row[] = $veh_doc->code_unit;
			$row[] = $veh_doc->nap;
			$row[] = $veh_doc->shift;
			$row[] = $veh_doc->empname;
			$row[] = $veh_doc->nik;
			$row[] = $veh_doc->hm_start;
			$row[] = $veh_doc->hm_end;
			$row[] = $veh_doc->total_hm;
			$row[] = $veh_doc->distance;
			$row[] = $veh_doc->material;
			$row[] = $veh_doc->nap_unit_loading;
			$row[] = $veh_doc->jam_07;
			$row[] = $veh_doc->jam_08;
			$row[] = $veh_doc->jam_09;
			$row[] = $veh_doc->jam_10;
			$row[] = $veh_doc->jam_11;
			$row[] = $veh_doc->jam_12;
			$row[] = $veh_doc->jam_01;
			$row[] = $veh_doc->jam_02;
			$row[] = $veh_doc->jam_03;
			$row[] = $veh_doc->jam_04;
			$row[] = $veh_doc->jam_05;
			$row[] = $veh_doc->total_ritase;
			$row[] = $veh_doc->total_bcm_ton;
			$row[] = $veh_doc->remarks;
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->veh_daily->count_all(),
						"recordsFiltered" => $this->veh_daily->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}

	private function _validate_v_daily()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_date') == '')
		{
			$data['inputerror'][] = 'f_date';
			$data['error_string'][] = 'Tanggal is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_nap') == '')
		{
			$data['inputerror'][] = 'f_nap';
			$data['error_string'][] = 'nap is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function veh_daily_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$nap = $this->input->post('f_nap');
		$date = date_input($this->input->post('f_date'));
		$shift = $this->input->post('f_shift');
		$this->_validate_v_daily(); // validasi inputan kosong
		$cek = $this->cek_v_daily($nap,$date, $shift);
		
		if ($cek == 1) {
			$data['inputerror'][] = 'f_date';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else
		{
			/*menyimpan inputan post ke dalam array data*/
			$data = array(
					'inputby' => $this->input->post('f_input_by'),
					'inputdate' => $this->input->post('f_input_date'),
					'date' => date_input($this->input->post('f_date')),
					'nap' => $this->input->post('f_nap'),
					'shift' => $this->input->post('f_shift'),
					'operator_code' => $this->input->post('f_operator'),
					'hm_start' => $this->input->post('f_start'),
					'hm_end' => $this->input->post('f_stop'),
					'total_hm' => $this->input->post('f_total_hm'),
					'distance' => $this->input->post('f_distance'),
					'material' => $this->input->post('f_material'),
					'nap_unit_loading' => $this->input->post('f_loader'),
					'jam_07' => $this->input->post('f_7'),
					'jam_08' => $this->input->post('f_8'),
					'jam_09' => $this->input->post('f_9'),
					'jam_10' => $this->input->post('f_10'),
					'jam_11' => $this->input->post('f_11'),
					'jam_12' => $this->input->post('f_12'),
					'jam_01' => $this->input->post('f_1'),
					'jam_02' => $this->input->post('f_2'),
					'jam_03' => $this->input->post('f_3'),
					'jam_04' => $this->input->post('f_4'),
					'jam_05' => $this->input->post('f_5'),
					'total_ritase' => $this->input->post('f_total_ritase'),
					'total_bcm_ton' => $this->input->post('f_total_bcm_ton'),
					'remarks' => $this->input->post('f_remarks'),
				);
			$insert = $this->veh_daily->save($data);

			echo json_encode(array("status" => TRUE));
		}
	}

	public function cek_v_daily($nap, $date, $shift)
	{
		$a = $this->veh_daily->cek_data($nap, $date, $shift);
		if (isset($a)) {
		$baris = 1;
		return $baris;
		}
		else
		{
			$baris = 0;
			//echo $baris;
			return $baris;
		}
	}

	public function get_vehicle_entity($nap)
	{
		$data = $this->veh_daily->get_last_km($nap);
		//echo $data->nap;
		$left_nap = substr($data->nap, 0,1);
		$code_unit = strtolower(substr($data->code_unit, 0,2));
		if ($left_nap == '6') {
			if ($code_unit == 'dt') {
				//echo "DT";
				$data->code_unit = $code_unit;
			}
			else if ($code_unit == 'hi') {
				//echo "hino";
				$data->code_unit = $code_unit;
			}
			echo json_encode($data);
		}
		else {
			//echo $left_nap;	
			echo json_encode($data);
		}
		//echo json_encode($data);
	}

	public function cek_data($tanggal)
	{
		$tanggal = date_input($tanggal);
		$cek = $this->veh_daily->cek_data_import($tanggal);
		if ($cek) {
			//echo "ada data, hapus data?";
			$a = 1;
			return $a;
		}
		else
		{
			//echo "tidak ada data, boleh input";
			$a = 0;
			return $a;
		}
	}

	public function import_daily_hmkm() {
		$tanggal = $this->input->post('f_date_upload');
		$cek_data = $this->cek_data($tanggal);
		if ($cek_data == 1) {
			$data['inputerror'][] = 'f_date_upload';
			$data['error_string'][] = 'Tanggal sudah terinput'; //show ajax error
			$data['date'][] = $tanggal; //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
			
		}
		else {
			if (!empty($_FILES['file_import']['name'])) {
			$upload = $this->_do_upload();
		}
		if(empty($_FILES['file_import']['name'])) //upload and validate
        {
            $data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'No File Selected'; //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		}

				
		//$insert = $this->emp_attribute->save($data);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path'] = 'upload/produksi';
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['file_name'] = round(microtime(true)*1000);
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_import')) {
			/*jika file upload tidak sesuai atau kosong*/
			$data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'Upload Error: '. $this->upload->display_errors('','') ;
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else 
		{
			$this->upload->do_upload('file_import');
			$data = $this->upload->data();

			$this->load->library('Spreadsheet_Excel_Reader');
			$this->load->helper('time_stamp_helper');
			$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

			$this->spreadsheet_excel_reader->read($data['full_path']);
			$sheets = $this->spreadsheet_excel_reader->sheets[0];
			error_reporting(0);
			$user = $this->ion_auth->user()->row();
			$usr = $user->username;
			$data['username'] = $usr;

			$data_excel = array();
			for ($i = 2; $i <= 400 ;$i++) { 
				if ($sheets['cells'][$i][2] == '') break; //jika tanggal tidak terisi maka process import aborted sampai tanggal terakhir di isi dalam sheet tersebut
				$nap = str_replace("'", "", $sheets['cells'][$i][4]); // mengganti jika ada karakter ' maka akan di hapus
				$data_excel[$i -1]['date'] = $this->date_import_excel($sheets['cells'][$i][2]);
				$data_excel[$i -1]['nap'] = $nap;
				$data_excel[$i -1]['shift'] = $sheets['cells'][$i][5];
				$data_excel[$i -1]['operator_code'] = $sheets['cells'][$i][7];
				$data_excel[$i -1]['hm_start'] = $sheets['cells'][$i][8];
				$data_excel[$i -1]['hm_end'] = $sheets['cells'][$i][9];
				$data_excel[$i -1]['total_hm'] = round($sheets['cells'][$i][10],2);
				$data_excel[$i -1]['distance'] = $sheets['cells'][$i][11];
				$data_excel[$i -1]['material'] = $sheets['cells'][$i][12];
				$data_excel[$i -1]['nap_unit_loading'] = $sheets['cells'][$i][13];
				$data_excel[$i -1]['jam_07'] = $sheets['cells'][$i][14];
				$data_excel[$i -1]['jam_08'] = $sheets['cells'][$i][15];
				$data_excel[$i -1]['jam_09'] = $sheets['cells'][$i][16];
				$data_excel[$i -1]['jam_10'] = $sheets['cells'][$i][17];
				$data_excel[$i -1]['jam_11'] = $sheets['cells'][$i][18];
				$data_excel[$i -1]['jam_12'] = $sheets['cells'][$i][19];
				$data_excel[$i -1]['jam_01'] = $sheets['cells'][$i][20];
				$data_excel[$i -1]['jam_02'] = $sheets['cells'][$i][21];
				$data_excel[$i -1]['jam_03'] = $sheets['cells'][$i][22];
				$data_excel[$i -1]['jam_04'] = $sheets['cells'][$i][23];
				$data_excel[$i -1]['jam_05'] = $sheets['cells'][$i][24];
				$data_excel[$i -1]['total_ritase'] = $sheets['cells'][$i][25];
				$data_excel[$i -1]['total_bcm_ton'] = $sheets['cells'][$i][26];
				$data_excel[$i -1]['inputby'] = $data['username'];
				$data_excel[$i -1]['inputdate'] = time_stamp();
			}
			return $this->db->insert_batch('vehicle_daily_activity',$data_excel);
		}
		/*echo "<pre>";
		echo print_r($data_excel);
		echo "</pre>";*/
	}

	/*fungsi untuk memformat hasil import dari excel 01/03/2018 yang berupa integer 43160 ketika di database
	maka di buat nya fungsi ini untuk merubah format tersebut dan di gunakan ketika akan di import ke mysql*/
	function date_import_excel($tanggal)
	{
		$unix_date = ($tanggal - 25569) * 86400;
		return gmdate("Y-m-d", $unix_date);
		//return $newDate;
	}

	function delete_masal($date)
	{	
		$date = date_input($date);
		//$del = $this->veh_daily->get_by_id($id);		
		$this->veh_daily->delete_masal($date);
		echo json_encode(array("status" => TRUE));
	}

	function get_illegeal_char(){
		$char = "'92-01";
		$new = str_replace("'", "", $char);
		//new = preg_replace("'", "", $char);
		echo $new;
	}


	/* setting rooster excel untuk 6 pagi - 6 malam vice versa */
	
	public function reg_pagi_malam_vice_versa($days, $begin_work, $shift)
	{
		$p = array();	
		$jml_hari = $days;
		switch ($begin_work) {
				case 1:
				$day = 1;
				break;
				case 2:
				$day = 2;
				break;
				case 3:
				$day = 3;
				break;
				case 4:
				$day = 4;
				break;
				case 5:
				$day = 5;
				break;
				case 6:
				$day = 6;
				break;
		}
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= $day) {
		//$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_a = $day +1;
			}
		elseif ($i==$par_a) { // 7
		$p['a'.$i] = "0";
		$par_b = $par_a+$day;
			}
		elseif ($i<=$par_b) { // 13
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_c = $par_b+1;
			}
		elseif ($i==$par_c) { //14
		$p['a'.$i] = "0";
		$par_d = $par_c + $day;
			}
		elseif ($i<=$par_d) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_e = $par_d+1;
			}
		elseif ($i==$par_e) { // 21
		$p['a'.$i] = "0";
		$par_f = $par_e + $day;
			}
		elseif ($i<=$par_f) { // 27
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_g = $par_f + 1;
			}
		elseif ($i==$par_g) { //28
		$p['a'.$i] = "0";
		$par_h = $par_g + $day;
			}
		elseif ($i<=$par_h) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_i = $par_h+1;
			}
		elseif ($i==$par_i) { // 20
		$p['a'.$i] = "0";
		$par_j = $par_i+$day;
			}
		elseif ($i<=$par_j) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_k = $par_j+1;
			}
		elseif ($i==$par_k) { // 20
		$p['a'.$i] = "0";
		$par_l = $par_k+$day;
			}
		elseif ($i<=$par_l) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_m = $par_l+1;
			}
		elseif ($i==$par_m) { // 20
		$p['a'.$i] = "0";
		$par_n = $par_m+$day;
			}
		elseif ($i<=$par_n) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_o = $par_n+1;
			}
		elseif ($i==$par_o) { // 20
		$p['a'.$i] = "0";
		$par_p = $par_o+$day;
			}
		elseif ($i<=$par_p) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_q = $par_p+1;
			}
		elseif ($i==$par_q) { // 20
		$p['a'.$i] = "0";
		$par_r = $par_q+$day;
			}
		elseif ($i<=$par_r) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_s = $par_r+1;
			}
		
		/*  */
		elseif ($i==$par_s) { //28
			$p['a'.$i] = "0";
			$par_t = $par_s + $day;
				}
			elseif ($i<=$par_t) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_u = $par_t+1;
				}
			elseif ($i==$par_u) { // 20
			$p['a'.$i] = "0";
			$par_v = $par_u+$day;
				}
			elseif ($i<=$par_v) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_w = $par_v+1;
				}
			elseif ($i==$par_w) { // 20
			$p['a'.$i] = "0";
			$par_x = $par_w+$day;
				}
			elseif ($i<=$par_x) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_y = $par_x+1;
				}
			elseif ($i==$par_y) { // 20
			$p['a'.$i] = "0";
			$par_z = $par_y+$day;
				}
			elseif ($i<=$par_z) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
				}
			elseif ($i==$par_aa) { // 20
			$p['a'.$i] = "0";
			$par_ab = $par_aa+$day;
				}
			elseif ($i<=$par_ab) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
				}
			elseif ($i==$par_ac) { // 20
			$p['a'.$i] = "0";
			$par_ad = $par_ac+$day;
				}
			elseif ($i<=$par_ad) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
				}
		/*  */

		elseif ($i<=$i) { // n
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			}	
			//$day++;
		}
		/* echo "<pre>";
		print_r($p);
		echo "</pre>"; */
		return $p;
	}
	/* end 6 pagi - 6 malam */

	/* simpan data untuk ke table absensi rooster
	parameter 
	1. empcode
	2. periode rooster
	3. tahun rooster 
	4. id unutk di table
	5. shift rooster ini di awali oleh shift apa
	6. begin work di mulai berapa hari 
	*/
	
	public function absensi_rooster_reg_pagi_malam($empcode, $period, $tahun, $id, $shift, $begin_work)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
$begin_work -= 1;
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<= $begin_work) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			//$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_a = $begin_work+1;
		}
	}
elseif ($i==$par_a) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_b = $par_a + $begin_work +1;
		}
	}
elseif ($i<=$par_b) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_c = $par_b+1;
		}
	}
elseif ($i==$par_c) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_d = $par_c + $begin_work +1;
		}
	}
elseif ($i<=$par_d) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_e = $par_d+1;
		}
	}
elseif ($i==$par_e) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_f = $par_e + $begin_work +1;

		}
	}
elseif ($i<=$par_f) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_g = $par_f+1;
		}
	}
elseif ($i==$par_g) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_h = $par_g + $begin_work +1;

		}
	}
elseif ($i<=$par_h) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_i = $par_h+1;
		}
	}
elseif ($i==$par_i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_j = $par_i + $begin_work +1;
		}
	}

	elseif ($i<=$par_j) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_k = $par_j+1;
		}
	}
elseif ($i==$par_k) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_l = $par_k + $begin_work +1;
		}
	}
elseif ($i<=$par_l) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_m = $par_l+1;
		}
	}
elseif ($i==$par_m) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_n = $par_m + $begin_work +1;

		}
	}
elseif ($i<=$par_n) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_o = $par_n+1;
		}
	}
elseif ($i==$par_o) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_p = $par_o + $begin_work +1;

		}
	}
elseif ($i<=$par_p) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_q = $par_p+1;
		}
	}
elseif ($i==$par_q) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_r = $par_q + $begin_work +1;
		}
	}

	elseif ($i<=$par_r) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_s = $par_r+1;
		}
	}
elseif ($i==$par_s) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_t = $par_s + $begin_work +1;
		}
	}

	elseif ($i<=$par_t) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_u = $par_t+1;
		}
	}
elseif ($i==$par_u) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_v = $par_u + $begin_work +1;
		}
	}
elseif ($i<=$par_v) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_w = $par_v+1;
		}
	}
elseif ($i==$par_w) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_x = $par_w + $begin_work +1;

		}
	}
elseif ($i<=$par_x) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_y = $par_x+1;
		}
	}
elseif ($i==$par_y) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_z = $par_y + $begin_work +1;

		}
	}
elseif ($i<=$par_z) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
		}
	}
elseif ($i==$par_aa) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ab = $par_aa + $begin_work +1;
		}
	}

	elseif ($i<=$par_ab) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
		}
	}
elseif ($i==$par_ac) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ad = $par_ac + $begin_work +1;

		}
	}
elseif ($i<=$par_ad) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
		}
	}


elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/* echo('<pre>');
		print_r($data_ar);
		echo('</pre>'); */
		} // end for

} // end for tiga malam
	/* end off absensi rooster */

	/* update absesni 6 pagi malam vice versa */

	public function update_absensi_rooster_reg_pagi_malam($id, $start_date, $end_date, $shift, $begin_work)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		//$jml_hari = total_hari($period, $tahun);
$data_ar = array();
$begin_work -= 1;
for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<= $begin_work) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_a = $begin_work+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_a) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_b = $par_a + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
	elseif ($i<=$par_b) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_c = $par_b+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_c) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_d = $par_c + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_d) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_e = $par_d+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_e) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_f = $par_e + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_f) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_g = $par_f+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_g) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_h = $par_g + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_h) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_i = $par_h+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_j = $par_i + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

	elseif ($i<=$par_j) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_k = $par_j+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_k) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_l = $par_k + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_l) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_m = $par_l+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_m) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_n = $par_m + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_n) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_o = $par_n+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_o) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_p = $par_o + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_p) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_q = $par_p+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_q) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_r = $par_q + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

	elseif ($i<=$par_r) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_s = $par_r+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_s) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_t = $par_s + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

	elseif ($i<=$par_t) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_u = $par_t+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_u) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_v = $par_u + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_v) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_w = $par_v+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_w) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_x = $par_w + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_x) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_y = $par_x+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_y) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_z = $par_y + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_z) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_aa) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ab = $par_aa + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}

	elseif ($i<=$par_ab) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_ac) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ad = $par_ac + $begin_work +1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_ad) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
			
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}


elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";	
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	//$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
		/* echo('<pre>');
		print_r($data_ar);
		echo('</pre>'); */
		} // end for

} // end for tiga malam
	/* end of update absensi 6 pagi malam vice versa */

	/* update absensi off */
	public function update_absensi_rooster_off_pagi_malam($id, $start_date, $end_date, $shift, $begin_work)
	{
		$from = $start_date;
		$to = $end_date;
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		
$data_ar = array();
$begin_work -= 1;
for ($i=0; $i < $batas ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$par_a = $begin_work+1;
			$data_ar['shift'] = "0" ;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i<=$par_a) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_c = $par_a+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);
	}
elseif ($i==$par_c) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_d = $par_c + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_d) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_e = $par_d+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_e) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_f = $par_e + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_f) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_g = $par_f+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_g) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_h = $par_g + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_h) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_i = $par_h+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_j = $par_i + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	elseif ($i<=$par_j) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_k = $par_j+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_k) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_l = $par_k + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_l) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_m = $par_l+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_m) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_n = $par_m + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_n) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_o = $par_n+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_o) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_p = $par_o + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_p) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_q = $par_p+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_q) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_r = $par_q + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	elseif ($i<=$par_r) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_s = $par_r+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_s) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_t = $par_s + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	elseif ($i<=$par_t) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_u = $par_t+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_u) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_v = $par_u + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_v) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_w = $par_v+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_w) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_x = $par_w + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_x) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_y = $par_x+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_y) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['shift'] = "0";
			$par_z = $par_y + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_z) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_aa) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ab = $par_aa + $begin_work +1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	elseif ($i<=$par_ab) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i==$par_ac) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ad = $par_ac + $begin_work +1;

		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}
elseif ($i<=$par_ad) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}


elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['id'] = $id;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
		$this->rooster->update_rooster(array("id" => $id, "tanggal" => $date), $data_ar);

	}

	//$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
	/* 	echo('<pre>');
		print_r($data_ar);
		echo('</pre>'); */
		} // end for

} // end for tiga malam

	/* update absensi off */

	public function absensi_rooster_off_pagi_malam($empcode, $period, $tahun, $id, $shift, $begin_work)
	{
		$from = date_input(get_from_date_period($period, $tahun));
		$to = date_input(get_to_date_period($period, $tahun));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
		$jml_hari = total_hari($period, $tahun);
$data_ar = array();
$begin_work -= 1;
for ($i=0; $i < $jml_hari ; $i++) { 
$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
$date=date("Y-m-d", $date);

	if ($i<=0) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			//$data_ar['shift'] = "1";
			$par_a = $begin_work+1;
			$data_ar['shift'] = "0" ;
			
		}
	}
elseif ($i<=$par_a) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_c = $par_a+1;
		}
	}
elseif ($i==$par_c) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_d = $par_c + $begin_work +1;
		}
	}
elseif ($i<=$par_d) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_e = $par_d+1;
		}
	}
elseif ($i==$par_e) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_f = $par_e + $begin_work +1;

		}
	}
elseif ($i<=$par_f) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_g = $par_f+1;
		}
	}
elseif ($i==$par_g) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_h = $par_g + $begin_work +1;

		}
	}
elseif ($i<=$par_h) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_i = $par_h+1;
		}
	}
elseif ($i==$par_i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_j = $par_i + $begin_work +1;
		}
	}

	elseif ($i<=$par_j) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_k = $par_j+1;
		}
	}
elseif ($i==$par_k) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_l = $par_k + $begin_work +1;
		}
	}
elseif ($i<=$par_l) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_m = $par_l+1;
		}
	}
elseif ($i==$par_m) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_n = $par_m + $begin_work +1;

		}
	}
elseif ($i<=$par_n) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_o = $par_n+1;
		}
	}
elseif ($i==$par_o) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_p = $par_o + $begin_work +1;

		}
	}
elseif ($i<=$par_p) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_q = $par_p+1;
		}
	}
elseif ($i==$par_q) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_r = $par_q + $begin_work +1;
		}
	}

	elseif ($i<=$par_r) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_s = $par_r+1;
		}
	}
elseif ($i==$par_s) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_t = $par_s + $begin_work +1;
		}
	}

	elseif ($i<=$par_t) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_u = $par_t+1;
		}
	}
elseif ($i==$par_u) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_v = $par_u + $begin_work +1;
		}
	}
elseif ($i<=$par_v) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_w = $par_v+1;
		}
	}
elseif ($i==$par_w) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_x = $par_w + $begin_work +1;

		}
	}
elseif ($i<=$par_x) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_y = $par_x+1;
		}
	}
elseif ($i==$par_y) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_z = $par_y + $begin_work +1;

		}
	}
elseif ($i<=$par_z) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
		}
	}
elseif ($i==$par_aa) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ab = $par_aa + $begin_work +1;
		}
	}

	elseif ($i<=$par_ab) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = ($shift =="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
		}
	}
elseif ($i==$par_ac) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "0";
			$par_ad = $par_ac + $begin_work +1;

		}
	}
elseif ($i<=$par_ad) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
			$data_ar['shift'] = ($shift =="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
		}
	}


elseif ($i<=$i) {
		for ($a=0; $a < 1; $a++) { 
			$data_ar['empcode'] = $empcode;
			$data_ar['id'] = $id;
			$data_ar['period'] = $period;
			$data_ar['year'] = $tahun;
			$data_ar['tanggal'] = $date;
			$data_ar['shift'] = "1";
		}
	}

	$insert =	$this->rooster->insert_rooster_absensi($data_ar);
	
	/* 	echo('<pre>');
		print_r($data_ar);
		echo('</pre>'); */
		} // end for

} // end for tiga malam
	/* end off absensi rooster */

	/* off pagi malam */
	public function reg_off_pagi_malam_vice_versa($days, $begin_work, $shift)
	{
		$p = array();	
		$jml_hari = $days;
		switch ($begin_work) {
			case 1:
			$day = 1;
			break;
			case 2:
			$day = 2;
			break;
			case 3:
			$day = 3;
			break;
			case 4:
			$day = 4;
			break;
			case 5:
			$day = 5;
			break;
			case 6:
			$day = 6;
			break;
		}
		$par_a = 1;
		for ($i=1; $i <= $jml_hari ; $i++) { 
			if ($i <= 0) {
		//$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			}
		elseif ($i==$par_a) { // 7
		$p['a'.$i] = "0";
		$par_b = $par_a+$day;
			}
		elseif ($i<=$par_b) { // 13
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_c = $par_b+1;
			}
		elseif ($i==$par_c) { //14
		$p['a'.$i] = "0";
		$par_d = $par_c + $day;
			}
		elseif ($i<=$par_d) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_e = $par_d+1;
			}
		elseif ($i==$par_e) { // 21
		$p['a'.$i] = "0";
		$par_f = $par_e + $day;
			}
		elseif ($i<=$par_f) { // 27
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_g = $par_f + 1;
			}
		elseif ($i==$par_g) { //28
		$p['a'.$i] = "0";
		$par_h = $par_g + $day;
			}
		elseif ($i<=$par_h) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_i = $par_h+1;
			}
		elseif ($i==$par_i) { // 20
		$p['a'.$i] = "0";
		$par_j = $par_i+$day;
			}
		elseif ($i<=$par_j) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_k = $par_j+1;
			}
		elseif ($i==$par_k) { // 20
		$p['a'.$i] = "0";
		$par_l = $par_k+$day;
			}
		elseif ($i<=$par_l) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_m = $par_l+1;
			}
		elseif ($i==$par_m) { // 20
		$p['a'.$i] = "0";
		$par_n = $par_m+$day;
			}
		elseif ($i<=$par_n) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_o = $par_n+1;
			}
		elseif ($i==$par_o) { // 20
		$p['a'.$i] = "0";
		$par_p = $par_o+$day;
			}
		elseif ($i<=$par_p) { // 20
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
		$par_q = $par_p+1;
			}
		elseif ($i==$par_q) { // 20
		$p['a'.$i] = "0";
		$par_r = $par_q+$day;
			}
		elseif ($i<=$par_r) { // 20
		$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
		$par_s = $par_r+1;
			}
		
		/*  */
		elseif ($i==$par_s) { //28
			$p['a'.$i] = "0";
			$par_t = $par_s + $day;
				}
			elseif ($i<=$par_t) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_u = $par_t+1;
				}
			elseif ($i==$par_u) { // 20
			$p['a'.$i] = "0";
			$par_v = $par_u+$day;
				}
			elseif ($i<=$par_v) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_w = $par_v+1;
				}
			elseif ($i==$par_w) { // 20
			$p['a'.$i] = "0";
			$par_x = $par_w+$day;
				}
			elseif ($i<=$par_x) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_y = $par_x+1;
				}
			elseif ($i==$par_y) { // 20
			$p['a'.$i] = "0";
			$par_z = $par_y+$day;
				}
			elseif ($i<=$par_z) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_aa = $par_z+1;
				}
			elseif ($i==$par_aa) { // 20
			$p['a'.$i] = "0";
			$par_ab = $par_aa+$day;
				}
			elseif ($i<=$par_ab) { // 20
			$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			$par_ac = $par_ab+1;
				}
			elseif ($i==$par_ac) { // 20
			$p['a'.$i] = "0";
			$par_ad = $par_ac+$day;
				}
			elseif ($i<=$par_ad) { // 20
			$p['a'.$i] = ($shift=="1") ? "2" : "1" ;
			$par_ae = $par_ad+1;
				}
		/*  */

		elseif ($i<=$i) { // n
		$p['a'.$i] = ($shift=="1") ? "1" : "2" ;
			}	
			//$day++;
		}
		/* echo "<pre>";
		print_r($p);
		echo "</pre>"; */
		return $p;
	}
	/* end off pagi malam */
	

	

	public function fuckingshit()
	{
		$biskuit = array(
			'donat','bakpia','laksan','burgo','pukis','cakwe'
		);
		for ($i=0; $i < count($biskuit) ; $i++) { 
			if ($i %3 == 0) {
				
				echo $biskuit[$i];
			}
		}
	}

	public function sse()
	{

		$period = 6;
		$year = 2019;
		$start_date = get_date_period($period, $year)->start_date;
		$end_date = get_date_period($period, $year)->end_date;
		
		$period_total = beda_tanggal($start_date, $end_date );
		
		$data = $this->new_rooster($period_total);
		echo "<pre>";
		echo print_r($data);
		echo "</pre>";

		// for ($i=0; $i < count($data) ; $i++) { 
		// 	echo $data[$i];
		// }

		


	}

	public function new_rooster($days)
	{
		$start = 3;
		$hari_off = $start+1;
		$p = array();
		$off_day = array();
		$a = 1;
		$jml_hari = $days;
		for ($i=1; $i <= $jml_hari ; $i++) {
			
			
			if ($i % 3 == 0) {
				$p['a'.$i] = "0";
				$off_day[] = $i;
			}

			// if ($i % 7 == 0) {
			// 	$p['a'.$i] = "0";
			// 	$off_day[] = $i;
			// }

		}
		
		return $p;
	}




} // end of controller