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
class Vehicle extends MX_Controller
{
	
	function __construct()
	{
		# code...
		date_default_timezone_set('Asia/Jakarta');
        $this->load->library('lib_log');
		$this->load->helper('form_helper');
        $this->load->helper('date');
		$this->load->helper('tanggal_input_helper');
		$this->load->model('hr/lov_model','lov');
		$this->load->model('vm_model','vm');
		$this->load->model('vd_model','vd');
		$this->load->model('lov_model','master_lov');
		$this->load->model('notifikasi_vehicle','v_notif');
		$this->load->model('vehicle_monitoring_model','veh_mon');
		$this->load->model('rpt_vehicle_sarana_model','rpt_vehicle');
		$this->load->model('veh_daily','vm_daily');
		$this->load->model('service_setup_model','ss_model');
		$this->load->model('monitoring_p2h_model','p2h_mon_model');
		$this->load->model('veh_next_services');
		$this->load->model('Vehicle_fuel_model','veh_fuel');
		header("Access-Control-Allow-Origin: *"); 
	}

	/*controller ini akan menampilkan jumlah notifikasi ke yang di request dari ajax di menu view*/
	public function cek_notif()
	{
		$data = $this->v_notif->notif();
		foreach ($data as $key) {
			$row[] = array();
			$row = $key->notif;
		}
		echo json_encode($row);

	}

	/*menampilkan detail dari notifikasi*/
	public function list_notif_exp()
	{
		$no = 0;
		$list = $this->v_notif->list_notif_vehicle();
		$data = array();
		foreach ($list as $key) {
			$row = array();
			$row[] =  $key->nap;
			$row[] =  $key->doc_type;
			$row[] =  $key->nomor_plat;
			$row[] =  $key->code_unit;
			$row[] =  $key->valid_until;
			$row[] =  $key->due_date;
			$data[] = $row;
		}
		//echo '<pre>'; print_r($data);
		foreach ($data as $out) {
			$output = array(
			"nap" => $data[$no][0],
			"doc_type" => $data[$no][1],
			"nomor_plat" => $data[$no][2],
			"code_unit" => $data[$no][3],
			"valid_until" => date_indonesia($data[$no][4]),
			"due_date" => $data[$no][5],
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


	/*form validation vehicle master*/
	private function _validate_vm()
	{

		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_nap') == '')
		{
			$data['inputerror'][] = 'f_nap';
			$data['error_string'][] = 'Nap is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_code_unit') == '')
		{
			$data['inputerror'][] = 'f_nap';
			$data['error_string'][] = 'Code Unit is required';
			$data['status'] = FALSE;
		}

		/*if($this->input->post('f_nopol') == '')
		{
			$data['inputerror'][] = 'f_nopol';
			$data['error_string'][] = 'Nomor Polisi is required';
			$data['status'] = FALSE;
		}*/

		/*if($this->input->post('f_empcode') == '')
		{
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'User is required';
			$data['status'] = FALSE;
		}*/

		if($this->input->post('f_status_unit') == '')
		{
			$data['inputerror'][] = 'f_status_unit';
			$data['error_string'][] = 'Status Unit is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_no_rangka') == '')
		{
			$data['inputerror'][] = 'f_no_rangka';
			$data['error_string'][] = 'No Rangka Unit is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_no_mesin') == '')
		{
			$data['inputerror'][] = 'f_no_mesin';
			$data['error_string'][] = 'No Mesin is required';
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

	/*form validation vehicle service setup*/
	private function _validate_serv_setup()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_month') == '')
		{
			$data['inputerror'][] = 'f_month';
			$data['error_string'][] = 'Bulan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_tahun') == '')
		{
			$data['inputerror'][] = 'f_tahun';
			$data['error_string'][] = 'Tahun is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_last_service') == '')
		{
			$data['inputerror'][] = 'f_last_service';
			$data['error_string'][] = 'Last Service  is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_next_service') == '')
		{
			$data['inputerror'][] = 'f_next_service';
			$data['error_string'][] = 'Next Service is required';
			$data['status'] = FALSE;
		}

	

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	/*form validation vehicle service setup*/
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

	/*form validation vehicle fuel consumption*/
	private function _validate_veh_fuel()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		if ($this->input->post('f_date') == '') {
			$data['inputerror'][] = 'f_date';
			$data['error_string'][] = 'Date is required';
			$data['status'] = FALSE; 
		}
		if ($this->input->post('f_qty') == '') {
			$data['inputerror'][] = 'f_qty';
			$data['error_string'][] = 'Quantity is required';
			$data['status'] = FALSE;
		}
		if ($this->input->post('f_hmkm') == '') {
			$data['inputerror'][] = 'f_hmkm';
			$data['error_string'][] = 'HMKM is required';
			$data['status'] = FALSE;
		}
		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	private function is_exist_vehicle_fuel($date, $nap)
	{
		$a = $this->veh_fuel->cek_data($nap, $date);
		if (isset($a)) {
			$baris = 1;
			return $baris;	
		}
		else
		{
			$baris = 0;
			return $baris;
		}
	}

	public function master_vehicle()
	{	
		/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = array("ga","inv");
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
				$data['title'] = 'Master Vehicle';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	

		        /*drop down untuk vehicle group*/
		        $data['dd_vehicle_group'] = $this->lov->dd_vehicle_group();
		        $data['vehicle_group_selected'] = $this->input->post('f_group') ? $this->input->post('f_group') : '';        
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_master_vehicle');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_master_vehicle',$data);
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}
	/*end of function master_vehicle*/

	public function vm_list()
	{
		$list = $this->vm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $veh_master) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $veh_master->nomor_plat;
			$row[] = $veh_master->code_unit;
			$row[] = $veh_master->nap;
			$row[] = $veh_master->pic_code;
			$row[] = $veh_master->type;
			$row[] = $veh_master->year;
			$row[] = $veh_master->ownership;
			//$row[] = $veh_master->status_unit;
			if ($veh_master->status_unit == "rfu") {
			$row[] = "Ready";
			}
			else{
				$row[] = "Breakdown";
			}
			$row[] = $veh_master->remarks;
			$row[] = date_indonesia($veh_master->date_receive);// di format menggunakan helper tanggal_input_helper yang di load di function construct
			$row[] = $veh_master->no_frame;
			$row[] = $veh_master->no_machine;
			$row[] = $veh_master->cylinder;
			$row[] = $veh_master->remarks;

			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_master->id_vehicle."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Inactive" onclick="inactive('."'".$veh_master->id_vehicle."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->vm->count_all(),
						"recordsFiltered" => $this->vm->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function vm_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$this->_validate_vm();
		/*menyimpan inputan post ke dalam array data*/
		$data = array(
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
				'code_unit' => $this->input->post('f_code_unit'),
				'nomor_plat' => $this->input->post('f_nopol'),
				'nap' => $this->input->post('f_nap'),
				'pic_code' => $this->input->post('f_empcode'),
				'year' => $this->input->post('f_tahun'),
				'ownership' => $this->input->post('f_ownership'),
				'status_unit' => $this->input->post('f_status_unit'),
				'groups' => $this->input->post('f_group'),
				'work_unit' => $this->input->post('f_work_unit'),
				'type' => $this->input->post('f_jenis_type'),
				'type_unit' => $this->input->post('f_jenis_type'),
				'model' => $this->input->post('f_model'),
				'manufacturer' => $this->input->post('f_manufacturer'),
				'no_frame' => $this->input->post('f_no_rangka'),
				'no_machine' => $this->input->post('f_no_mesin'),
				'serial_number' => $this->input->post('f_sn'),
				'engine_model' => $this->input->post('f_engine_model'),
				'engine_sn' => $this->input->post('f_engine_sn'),
				'cylinder' => $this->input->post('f_silinder'),
				'date_receive' => date_input($this->input->post('f_tanggal_terima')),
				'kelipatan_pm' => $this->input->post('f_pm_service'),
				'remarks' => $this->input->post('f_remarks'),
				'active' => $this->input->post('f_active'),
				'to_rpt_bd' => $this->input->post('f_to_rpt_bd'),
				'to_rpt_hm' => $this->input->post('f_to_rpt_hm'),
			);
		$insert = $this->vm->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function test_code_unit()
	{
		$code_unit = "PIM 969/PIM. 01";
		$a = explode("/", $code_unit);
		echo "<pre>";
		print_r($a);
		echo "</pre>";
	}

	public function vm_edit($id)
	{
		$data = $this->vm->get_by_id($id);
		$data->date_receive = date_indonesia($data->date_receive);
		echo json_encode($data);
	}

	public function vm_update()
	{
		$this->_validate_vm();

		$data = array(
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'id_vehicle' => $this->input->post('f_id_vehicle'),
				'code_unit' => $this->input->post('f_code_unit'),
				'nomor_plat' => $this->input->post('f_nopol'),
				'nap' => $this->input->post('f_nap'),
				'pic_code' => $this->input->post('f_empcode'),
				'year' => $this->input->post('f_tahun'),
				'ownership' => $this->input->post('f_ownership'),
				'status_unit' => $this->input->post('f_status_unit'),
				'groups' => $this->input->post('f_group'),
				'work_unit' => $this->input->post('f_work_unit'),
				'type' => $this->input->post('f_jenis_type'),
				'type_unit' => $this->input->post('f_jenis_type'),
				'model' => $this->input->post('f_model'),
				'manufacturer' => $this->input->post('f_manufacturer'),
				'no_frame' => $this->input->post('f_no_rangka'),
				'no_machine' => $this->input->post('f_no_mesin'),
				'serial_number' => $this->input->post('f_sn'),
				'engine_model' => $this->input->post('f_engine_model'),
				'engine_sn' => $this->input->post('f_engine_sn'),
				'cylinder' => $this->input->post('f_silinder'),
				'date_receive' => date_input($this->input->post('f_tanggal_terima')),
				'kelipatan_pm' => $this->input->post('f_pm_service'),
				'remarks' => $this->input->post('f_remarks'),
				'active' => $this->input->post('f_active'),
				'to_rpt_bd' => $this->input->post('f_to_rpt_bd'),
				'to_rpt_hm' => $this->input->post('f_to_rpt_hm'),
			);

		$this->vm->update(array('id_vehicle' => $this->input->post('f_id_vehicle')), $data);
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
	public function inactive($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'active'	=>	"0",
		);
		$this->vm->update(array("id_vehicle" => $id), $data);
		echo json_encode(array("status" => true));
	}


	/*controller vehicle document*/
	public function vehicle_document()
	{
		$group = "ga";
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
				$data['title'] = 'Vehicle Document';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        

		        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_vehicle_document');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_vehicle_document',$data);
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}

		public function vehdoc_list()
	{
		$list = $this->vd->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $veh_doc) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $veh_doc->doc_no;
			$row[] = $veh_doc->nomor_plat;
			$row[] = $veh_doc->nap;
			$row[] = $veh_doc->code_unit;
			/*$row[] = $veh_doc->code_unit;*/
			$row[] = $veh_doc->doc_type;
			$row[] = date_indonesia($veh_doc->valid_until);// di format menggunakan helper tanggal_input_helper yang di load di function construct
			$row[] = $veh_doc->remarks;
			//$row[] = $veh_doc->status;
			if ($veh_doc->status == 'draft') {
				$row[] = '<span class="label label-danger">'.$veh_doc->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
			if ($veh_doc->status == 'submit') {
				$row[] = '<span class="label label-warning">'.$veh_doc->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
			if ($veh_doc->status == 'approve') {
				$row[] = '<span class="label label-primary">'.$veh_doc->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id_document."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
			if ($veh_doc->status == 'closed') {
				$row[] = '<span class="label label-danger">'.$veh_doc->status.'</span>';
				$row[] = '<span class="label label-danger">'.$veh_doc->status.'</span>';
			}

			
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->vd->count_all(),
						"recordsFiltered" => $this->vd->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function vehdoc_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$this->_validate_vd();
		/*menyimpan inputan post ke dalam array data*/
		$data = array(
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
				'doc_no' => $this->input->post('f_doc_no'),
				'nap' => $this->input->post('f_nap'),
				'doc_type' => $this->input->post('f_doc_type'),
				'valid_until' => date_input($this->input->post('f_valid_until')),
				'masa_berlaku' => $this->input->post('f_masa_berlaku'),
				'remarks' => $this->input->post('f_remarks'),
				'status' => $this->input->post('f_status'),
			);
		$insert = $this->vd->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function vehdoc_edit($id)
	{
		$data = $this->vd->get_by_id($id);
		$data->valid_until = date_indonesia($data->valid_until);
		echo json_encode($data);
	}

	public function vehdoc_update()
	{
		$this->_validate_vd();

		$data = array(
				'id_document' => $this->input->post('f_id_vehicle_doc'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'doc_no' => $this->input->post('f_doc_no'),
				'nap' => $this->input->post('f_nap'),
				'doc_type' => $this->input->post('f_doc_type'),
				'valid_until' => date_input($this->input->post('f_valid_until')),
				'masa_berlaku' => $this->input->post('f_masa_berlaku'),
				'remarks' => $this->input->post('f_remarks'),
				'status' => $this->input->post('f_status'),
				'no_ref_sr' => $this->input->post('f_sr'),
				'no_ref_ppd' => $this->input->post('f_ppd'),
			);

		$this->vd->update(array('id_document' => $this->input->post('f_id_vehicle_doc')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function vehdoc_delete($id)
	{
		//delete file
		//delete file
		//$del = $this->vd->get_by_id($id);
		/*==== if wanna delete file / photos
		if(file_exists('upload/'.$emp_attribute->photo) && $emp_attribute->photo)
			unlink('upload/'.$emp_attribute->photo);*/
		
		$this->vd->delete_by_id($id);
		echo json_encode(array("status" => TRUE));

	}


	/*controller untuk list document vehicle expierd */
	public function vehicle_monitoring()
	{

	$group = "ga";
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
	else{

		 	$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
		 $data = array(
            'title' => 'Vehicle Monitoring',
            'username' => $email,


		);
		 //dropdown untuk vehicle code
		$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
			 if ($this->ion_auth->in_group($group)) {
			$this->load->view('temp/title',$data);
			$this->load->view('template/header_ga');
			$this->load->view('temp/sidebar');
			$this->load->view('f_veh_mon');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_veh_mon');
	        }
		    else
		    {
					return show_error('You must be an administrator to view this page.');

	    }

		}
	}


	/*list ajax untuk vehicle monitoring*/
	public function veh_mon_list()
{
	$list = $this->veh_mon->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $a->nomor_plat;
			$row[] = $a->nap;
			$row[] = $a->code_unit;
			$row[] = $a->doc_type;
			$row[] = date_indonesia($a->valid_until);
			$row[] = $a->due_date. ' Hari Lagi';
			$row[] = $a->remarks;
			if ($a->due_date < 0) {
				$row[] = '<span class="label label-danger">EXPIRED</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Close it" onclick="close_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Close</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Approve it" onclick="approve_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Approve</a>';
			}
		else{
			if ($a->status == 'draft') {
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Close it" onclick="close_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Close</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Approve it" onclick="approve_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Approve</a>
				<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Update it" onclick="edit('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Update SR/PPD</a>';

			}
			if ($a->status == 'submit') {
				$row[] = '<span class="label label-warning">'.$a->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Close it" onclick="close_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Close</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Approve it" onclick="approve_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Approve</a>
				<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Update it" onclick="edit('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Update SR/PPD</a>';
			}
			if ($a->status == 'approve') {
				$row[] = '<span class="label label-primary">'.$a->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Close it" onclick="close_data('."'".$a->id_document."'".')"><i class="glyphicon glyphicon-pencil"></i> Close</a>';
			}
			if ($a->status == 'closed') {
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
			}
		}
			//$row[] = $a->status;
			

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->veh_mon->count_all(), 
			'recordsFiltered' => $this->veh_mon->count_filtered(), 
			'data' => $data,  
		);
		// output to json format
		echo json_encode($output);
	}

	/*fcontroller untuk close data monitoring*/
	public function close_data($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'status'	=>	"closed",
		);
		$this->veh_mon->update(array("id_document" => $id), $data);
		echo json_encode(array("status" => true));
	}

	/*fcontroller untuk approve data monitoring*/
	public function approve_data($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'status'	=>	"approve",
		);
		$this->veh_mon->update(array("id_document" => $id), $data);
		echo json_encode(array("status" => true));
	}

	/*report untuk menampilkan hasil pdf sesuai dengan report yang berlaku saat ini*/
	public function rpt_sarana()
	{
		$group = "ga";

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
			$data['title'] = 'Report Rekap Sarana';
			//dd empcode
			$data['dd_empcode'] = $this->master_lov->dd_empcode();
	        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
	        //dd grade status
	        $data['dd_dept'] = $this->master_lov->dd_dept();
	        $data['dd_dept_selected'] = $this->input->post('departement') ? $this->input->post('departement') : '';
	        //
	        $data['dd_emp_pos'] = $this->master_lov->dd_emp_position();
	        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
	        //dd empoyee status
			$data['dd_emp_status'] = $this->master_lov->dd_emp_status();
	        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

	        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';

if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('template/header_ga');
			$this->load->view('temp/sidebar');
			$this->load->view('rpt_sarana');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_rpt_sarana',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}

	}

	// report slip gaji pdf
	public function rpt_sarana_support(){
	//$this->load->helper('detail_lembur_helper');
    $this->load->library('pdf');
    $empcode = $this->input->post('filter_empcode');
    $dept_id = $this->input->post('filter_dept');
    $position_id = $this->input->post('filter_position');
    $month = $this->input->post('filter_month');
    $year = $this->input->post('filter_year');
    $print_date = $this->input->post('print_date');
    $order_by = $this->input->post('order_by');
    $prepared_by = $this->input->post('prepared_by');
    //$this->_validatee();
    $data = array(
        /*"emp_attrb" => $this->rpt_slip_gaji->slip_gaji($empcode, $dept_id, $position_id, $year, $month),*/
		"list_asset" => $this->rpt_vehicle->report_asset_sarana($order_by),
        "bulan" => $month,
        "print_date" => $print_date,
        "prepared_by" => $prepared_by,
        "tahun" => $year
    );

	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','landscape');
    $this->pdf->filename = "Daftar Asset Sarana Support.pdf";
    $this->pdf->load_view('rpt_sarana_support', $data);
	}

	public function rpt_veh()
	{
		$list = $this->rpt_vehicle->report_asset_sarana();
		echo('<pre>');
		print_r($list);
		echo('</pre>');
	}


	

	public function cek_user()
	{
		$obj_user = $this->ion_auth->user()->row();
				//$email = $obj_user->username;
				echo('<pre>');
		print_r($obj_user);
		echo('</pre>');
		$list = array('hr','ga');
		$grup = $this->ion_auth->in_group("ga");
/*echo('<pre>');
		print_r($grup);
		echo('</pre>');*/
		if ($grup == 1) {
		/*$this->load->view('header_except_hr');*/
		  echo "dia grup ga";
		        }
		    else
		    {
		  echo "dia bukan grup ga";

		/*$this->load->view('header');*/
		    }


	}

	public function a()
	{
		$obj_user = $this->ion_auth->user()->result();
		echo('<pre>');
		print_r($obj_user);
		echo('</pre>');

		foreach ($obj_user as $key) {
			echo "Id nya adalah ".$key->id;
			$groupnya = $this->ion_auth->get_users_groups($key->id)->result();

			echo('<pre>');
		print_r($groupnya);
		echo('</pre>');
			echo $groupnya[0]->id;
		}

	}


	public function cek_notif_email()
	{
		$cek = $this->cek_kendaraan();
		$cek_p2h = $this->cek_p2h();
		$cek_nxs = $this->cek_next_service();
		if ($cek > 0 and $cek_p2h > 0 and $cek_nxs > 0) {
			$this->send_mail();
			$this->send_mail_p2h();
			$this->send_mail_next_serv();
		}
	elseif ($cek > 0 and $cek_p2h > 0) {
			$this->send_mail();
			$this->send_mail_p2h();
		}
		elseif ($cek > 0 and $cek_nxs > 0) {
			$this->send_mail();
			$this->send_mail_next_serv();
		}
		elseif ($cek_p2h > 0 and $cek_nxs > 0) {
			$this->send_mail_p2h();
			$this->send_mail_next_serv();
		}
	elseif ($cek_p2h > 0) {
			$this->send_mail_p2h();
		}
		elseif ($cek > 0) {
			$this->send_mail();
		}
		elseif ($cek_nxs > 0) {
			$this->send_mail_next_serv();
		}
		else
		{
			echo "tidak kirim email";
		}
	}
	
	public function cek_kendaraan()
	{
		/*$data = $this->v_notif->notif();
		foreach ($data as $key) {
			$row[] = array();
			$row = $key->notif;
		}
		echo json_encode($row);*/
		$l = $this->v_notif->notif_vehdoc();
		foreach ($l as $key) {
			$total_notif =  $key->notif;
		}
		return $total_notif;
		/*echo('<pre>');
		print_r($l);
		echo('</pre>');*/
	}

	public function cek_p2h()
	{
		$p2h = $this->v_notif->notif_p2h();
		foreach ($p2h as $key) {
			$total_notif =  $key->notif;
		}
		return $total_notif;
	}

	public function cek_next_service()
	{
		$nx_serv = $this->v_notif->notif_next_service();
		foreach ($nx_serv as $key) {
			$total_notif =  $key->notif;
		}
		return $total_notif;
	}
// send mail surat kendaraan
	public function send_mail()
	{

		/*documentation from send grid how to send mail using server sendgrid

$this->load->library('email');

$this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_user' => 'sendgridusername',
  'smtp_pass' => 'sendgridpassword',
  'smtp_port' => 587,
  'crlf' => "\r\n",
  'newline' => "\r\n"
));

$this->email->from('your@example.com', 'Your Name');
$this->email->to('someoneexampexample@example.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('them@their-example.com');
$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->send();

echo $this->email->print_debugger();
		*/


		/*send grid

		username : gandhitabrani
		password : 64ndH1134
		https://app.sendgrid.com/guide/integrate/langs/smtp
		server : smtp.sendgrid.net
		ports : 
25, 587	(for unencrypted/TLS connections)
465	(for SSL connections)
username : gandhi13
password : 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

	
		*/
		/*
		1. cek terlebih dahulu list expierd, jikalau lebih dari 1 yang menjelang habis kontrak
		maka kirim kan email ke pak deden dan pak yos
		2. interval kirim email di set 10 hari sebelum kontrak berakhir

		*/
		$param = 2; // parameter database untuk tujuan email surat kendaraan
		$target_cc = "cc"; // parameter database untuk cc email
		$target_to = "to"; // parameter database untuk cc email
		$alamat_email_to = $this->master_lov->email_notifikasi($param,$target_to);
		$alamat_email_cc = $this->master_lov->email_notifikasi($param,$target_cc);
		$habis_kontrak = '2';
		$config['protocol'] = "smtp";
        //$config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_host'] = "ssl://smtp.sendgrid.net";
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "10";
        $config['smtp_user'] = "gandhitabrani";
        $config['smtp_pass'] = "64ndH1134";
        $config['charset'] = "iso-8859-1";
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        
        $this->email->initialize($config);
		$data['email'] = $this->v_notif->data_email();		
		$from = 'noreply@prime-pim.com';
		/*$cc = 'supatno@prime-pim.com';*/
		//$to = array('ehakurniawati@yahoo.com','giyantonurrahman99@gmail.com','oria98@yahoo.com');
		//$to = 'gandhisaputra13@gmail.com';
		//$to = array('gandhi.saputra@prime-pim.com');
		$subjek = 'LIST VEHICLE DOCUMENT EXPIRED';
		$isi = $this->load->view('template_email_vehicle',$data,true);
		$this->load->library('email');
		$to = array();
        $cc = array();
		foreach ($alamat_email_to as $key) {
			$to[] = $key->email;
		}
		foreach ($alamat_email_cc as $key) {
			$cc[] = $key->email;
		}
		$this->email->from($from,'noreply@prime-pim.com');
		$this->email->to($to);
		$this->email->cc($cc);
		//$this->email->cc(array('anang.sasongko@prime-pim.com','supatno@prime-pim.com','logisticadmin2.sby@prime-pim.com','finance.lahat@prime-pim.com','giyantonurrahman99@gmail.com','deden.azmoko@prime-pim.com','admin.sby@prime-pim.com'));
		$this->email->subject($subjek);
		$this->email->message($isi);
		/*$this->email->send();*/
		
			if ($this->email->send()) {
				echo "email kendaraan sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
	
	}

	public function template_email_vehicle()
	{
		$data['email'] = $this->v_notif->data_email();		
		//$a = $this->v_notif->data_email();		
		$this->load->view('template_email_vehicle',$data);
		/*echo('<pre>');
		print_r($a);
		echo('</pre>');*/
	}

	public function send_mail_p2h()
	{

		/*documentation from send grid how to send mail using server sendgrid

$this->load->library('email');

$this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_user' => 'sendgridusername',
  'smtp_pass' => 'sendgridpassword',
  'smtp_port' => 587,
  'crlf' => "\r\n",
  'newline' => "\r\n"
));

$this->email->from('your@example.com', 'Your Name');
$this->email->to('someoneexampexample@example.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('them@their-example.com');
$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->send();

echo $this->email->print_debugger();
		*/


		/*send grid

		username : gandhitabrani
		password : 64ndH1134
		https://app.sendgrid.com/guide/integrate/langs/smtp
		server : smtp.sendgrid.net
		ports : 
25, 587	(for unencrypted/TLS connections)
465	(for SSL connections)
username : gandhi13
password : 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

	
		*/
		/*
		1. cek terlebih dahulu list expierd, jikalau lebih dari 1 yang menjelang habis kontrak
		maka kirim kan email ke pak deden dan pak yos
		2. interval kirim email di set 10 hari sebelum kontrak berakhir

		*/
		$param = 4; // parameter database untuk tujuan email surat kendaraan
		$target_cc = "cc"; // parameter database untuk cc email
		$target_to = "to"; // parameter database untuk cc email
		$alamat_email_to = $this->master_lov->email_notifikasi($param,$target_to);
		$alamat_email_cc = $this->master_lov->email_notifikasi($param,$target_cc);
		$habis_kontrak = '2';
		$config['protocol'] = "smtp";
        //$config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_host'] = "ssl://smtp.sendgrid.net";
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "10";
        $config['smtp_user'] = "gandhitabrani";
        $config['smtp_pass'] = "64ndH1134";
        $config['charset'] = "iso-8859-1";
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        
        $this->email->initialize($config);
		$data['email'] = $this->vm_daily->notif_tidak_p2h();		
		$from = 'noreply@prime-pim.com';
		/*$cc = 'supatno@prime-pim.com';*/
		//$to = array('ehakurniawati@yahoo.com','giyantonurrahman99@gmail.com','oria98@yahoo.com');
		//$to = 'gandhisaputra13@gmail.com';
		//$to = array('gandhi.saputra@prime-pim.com');
		$to = array();
        $cc = array();
		foreach ($alamat_email_to as $key) {
			$to[] = $key->email;
		}
		foreach ($alamat_email_cc as $key) {
			$cc[] = $key->email;
		}
		$subjek = 'LIST OF UNIT NOT P2H';
		$isi = $this->load->view('template_email_tidak_p2h',$data,true);
		$this->load->library('email');

		$this->email->from($from,'noreply@prime-pim.com');
		$this->email->to($to);
		$this->email->cc($cc);
		//$this->email->cc(array('anang.sasongko@prime-pim.com','logisticadmin2.sby@prime-pim.com','edi.suyadi@prime-pim.com','deden.azmoko@prime-pim.com','mashud_ashari@yahoo.co.id','jislerdaulay7644@gmail.com','yulian.camantara@gmail.com','indra.mustari@prime-pim.com','supatno@prime-pim.com','sugiono@prime-pim.com'));
		$this->email->subject($subjek);
		$this->email->message($isi);
		/*$this->email->send();*/
		
			if ($this->email->send()) {
				echo "email p2h sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
	
	}

	public function template_email_tidak_p2h()
	{
		$data['email']= $this->vm_daily->notif_tidak_p2h();		
		//$a = $this->v_notif->data_email();		
		$this->load->view('template_email_tidak_p2h',$data);
		/*echo('<pre>');
		print_r($data);
		echo('</pre>');*/
	}

	// kirim email next service
	public function send_mail_next_serv()
	{

		/*documentation from send grid how to send mail using server sendgrid

$this->load->library('email');

$this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_user' => 'sendgridusername',
  'smtp_pass' => 'sendgridpassword',
  'smtp_port' => 587,
  'crlf' => "\r\n",
  'newline' => "\r\n"
));

$this->email->from('your@example.com', 'Your Name');
$this->email->to('someoneexampexample@example.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('them@their-example.com');
$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->send();

echo $this->email->print_debugger();
		*/


		/*send grid

		username : gandhitabrani
		password : 64ndH1134
		https://app.sendgrid.com/guide/integrate/langs/smtp
		server : smtp.sendgrid.net
		ports : 
25, 587	(for unencrypted/TLS connections)
465	(for SSL connections)
username : gandhi13
password : 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

	
		*/
		/*
		1. cek terlebih dahulu list expierd, jikalau lebih dari 1 yang menjelang habis kontrak
		maka kirim kan email ke pak deden dan pak yos
		2. interval kirim email di set 10 hari sebelum kontrak berakhir

		*/
		$param = 3; // parameter database untuk tujuan email surat kendaraan
		$target_cc = "cc"; // parameter database untuk cc email
		$target_to = "to"; // parameter database untuk cc email
		$alamat_email_to = $this->master_lov->email_notifikasi($param,$target_to);
		$alamat_email_cc = $this->master_lov->email_notifikasi($param,$target_cc);
		$habis_kontrak = '2';
		$config['protocol'] = "smtp";
        //$config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_host'] = "ssl://smtp.sendgrid.net";
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "10";
        $config['smtp_user'] = "gandhitabrani";
        $config['smtp_pass'] = "64ndH1134";
        $config['charset'] = "iso-8859-1";
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        
        $this->email->initialize($config);
		$data['email']= $this->vm_daily->list_notif_next_service();		
		$from = 'noreply@prime-pim.com';
		/*$cc = 'supatno@prime-pim.com';*/
		//$to = array('ehakurniawati@yahoo.com','giyantonurrahman99@gmail.com','oria98@yahoo.com');
		//$to = 'gandhisaputra13@gmail.com';
		//$to = array('gandhi.saputra@prime-pim.com');
		$to = array();
        $cc = array();
		foreach ($alamat_email_to as $key) {
			$to[] = $key->email;
		}
		foreach ($alamat_email_cc as $key) {
			$cc[] = $key->email;
		}
		$subjek = 'LIST OF UNIT NEXT SERVICES';
		$isi = $this->load->view('template_email_next_serv',$data,true);
		$this->load->library('email');

		$this->email->from($from,'noreply@prime-pim.com');
		$this->email->to($to);
		$this->email->cc($cc);
		//$this->email->cc(array('anang.sasongko@prime-pim.com','logisticadmin2.sby@prime-pim.com','edi.suyadi@prime-pim.com','deden.azmoko@prime-pim.com','mashud_ashari@yahoo.co.id','jislerdaulay7644@gmail.com','yulian.camantara@gmail.com','indra.mustari@prime-pim.com','supatno@prime-pim.com','sugiono@prime-pim.com'));
		$this->email->subject($subjek);
		$this->email->message($isi);
		/*$this->email->send();*/
		
			if ($this->email->send()) {
				echo "email vehicle service sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
	
	}

	public function template_email_next_serv()
	{
		$data['email']= $this->vm_daily->list_notif_next_service();		
		//$a = $this->v_notif->data_email();		
		$this->load->view('template_email_next_serv',$data);
		/*echo('<pre>');
		print_r($data);
		echo('</pre>');*/
	}

	/*controller vehicle document*/
	public function vehicle_service()
	{
		$group = "ga";
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
				$data['title'] = 'Vehicle Services';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        

		        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_vehicle_service');
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_vehicle_service',$data);
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}


	public function veh_daily_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$nap = $this->input->post('f_nap');
		$date = date_input($this->input->post('f_date'));
		$this->_validate_v_daily(); // validasi inputan kosong
		$cek = $this->cek_v_daily($nap,$date);
		
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
				'tanggal' => date_input($this->input->post('f_date')),
				'kondisi' => $this->input->post('f_condition'),
				'nap' => $this->input->post('f_nap'),
				'shift1' => $this->input->post('f_shift_satu'),
				'start_satu' => $this->input->post('f_start_satu'),
				'stop_satu' => $this->input->post('f_stop_satu'),
				'total_satu' => $this->input->post('f_km_total_satu'),
				'remarks_satu' => $this->input->post('f_remarks_satu'),
				'shift2' => $this->input->post('f_shift_dua'),
				'start_dua' => $this->input->post('f_start_dua'),
				'stop_dua' => $this->input->post('f_stop_dua'),
				'total_dua' => $this->input->post('f_km_total_dua'),
				'remarks_dua' => $this->input->post('f_remarks_dua'),
			);
		$insert = $this->vm_daily->save($data);

		echo json_encode(array("status" => TRUE));
	}
	}

	public function cek_v_daily($nap, $date)
	{
		$a = $this->vm_daily->cek_data($nap, $date);
		if (isset($a)) {
		$baris = 1;
		//echo $baris;
		return $baris;
		}
	else
	{
		$baris = 0;
		//echo $baris;
		return $baris;
	}
	}

	public function veh_daily_list()
	{
		$list = $this->vm_daily->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $veh_doc) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $veh_doc->tanggal;
			$row[] = $veh_doc->nap;
			switch ($veh_doc->kondisi) {
				case 'READY':
				$row[] = '<span class="label label-info">READY</span>';
					break;
					case 'KM ERROR':
				$row[] = '<span class="label label-primary">KM ERROR</span>';
					break;
					case 'STANDBY':
				$row[] = '<span class="label label-success">STANDBY</span>';
					break;
					case 'BREAKDOWN':
				$row[] = '<span class="label label-danger">BREAKDOWN</span>';
					break;
					case 'TROUBLES':
				$row[] = '<span class="label label-default">TROUBLES</span>';
					break;
					case 'TIDAK P2H':
				$row[] = '<span class="label label-warning">TIDAK P2H</span>';
					break;
			}
			//$row[] = $veh_doc->kondisi;
			$row[] = $veh_doc->shift1;
			$row[] = $veh_doc->start_satu;
			$row[] = $veh_doc->stop_satu;
			$row[] = $veh_doc->total_satu;
			$row[] = $veh_doc->remarks_satu;
			$row[] = $veh_doc->shift2;
			$row[] = $veh_doc->start_dua;
			$row[] = $veh_doc->stop_dua;
			$row[] = $veh_doc->total_dua;
			$row[] = $veh_doc->remarks_dua;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->vm_daily->count_all(),
						"recordsFiltered" => $this->vm_daily->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function veh_daily_edit($id)
	{
		$data = $this->vm_daily->get_by_id($id);
		$data->tanggal = date_indonesia($data->tanggal);
		echo json_encode($data);
	}

	public function get_last_km($id)
	{
		$data = $this->vm_daily->get_last_km($id);
		$data->tanggal = date_indonesia($data->tanggal);
		echo json_encode($data);
	}

	public function veh_daily_update()
	{
		//$this->_validate_vd();

		$data = array(
				'id' => $this->input->post('f_id_vehicle_doc'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'tanggal' => date_input($this->input->post('f_date')),
				'kondisi' => $this->input->post('f_condition'),
				'nap' => $this->input->post('f_nap'),
				'shift1' => $this->input->post('f_shift_satu'),
				'start_satu' => $this->input->post('f_start_satu'),
				'stop_satu' => $this->input->post('f_stop_satu'),
				'total_satu' => $this->input->post('f_km_total_satu'),
				'remarks_satu' => $this->input->post('f_remarks_satu'),
				'shift2' => $this->input->post('f_shift_dua'),
				'start_dua' => $this->input->post('f_start_dua'),
				'stop_dua' => $this->input->post('f_stop_dua'),
				'total_dua' => $this->input->post('f_km_total_dua'),
				'remarks_dua' => $this->input->post('f_remarks_dua'),
			);

		$this->vm_daily->update(array('id' => $this->input->post('f_id_vehicle_doc')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function veh_daily_delete($id)
	{	
		$this->vm_daily->delete_by_id($id);
		echo json_encode(array("status" => TRUE));

	}

/*controller untuk service setup atau header dari vehicle services*/
public function service_setup()
	{
		$group = "ga";
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
				$data['title'] = 'Services Setup';
				// dropdown untuk empcode
				$data['dd_empcode'] = $this->lov->dd_empcode();
		        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

				// dropdown untuk emp status
				$data['dd_emp_status'] = $this->lov->dd_emp_status();
		        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		        // dropdown untuk attd code
				$data['dd_attd_code'] = $this->lov->dd_attd_code();
		        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';	        

		        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_service_setup');
				$this->load->view('temp/sidebar');
				$this->load->view('notif');
				$this->load->view('ajax_service_setup',$data);
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}


	public function ser_set_add()
	{
		/*validasi jikalau inputan yang tidak boleh tidak di isi malah tidak di isi*/
		$this->_validate_serv_setup();
		/*menyimpan inputan post ke dalam array data*/
		$data = array(
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
				'nap' => $this->input->post('f_nap'),
				'nomor_plat' => $this->input->post('f_nopol'),
				'year' => $this->input->post('f_year'),
				'code_unit' => $this->input->post('f_code_unit'),
				'ownership' => $this->input->post('f_status'),
				'pic_code' => $this->input->post('f_users'),
				'bulan' => $this->input->post('f_month'),
				'tahun' => $this->input->post('f_tahun'),
				'service_at' => $this->input->post('f_service_at'),
				'last_service' => $this->input->post('f_last_service'),
				'next_service' => $this->input->post('f_next_service'),
			);
		$insert = $this->ss_model->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ser_set_list()
	{
		$list = $this->ss_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $veh_doc) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $veh_doc->nap;
			$row[] = $veh_doc->nomor_plat;
			$row[] = $veh_doc->code_unit;
			$row[] = $veh_doc->bulan;
			$row[] = $veh_doc->tahun;
			$row[] = $veh_doc->last_service;
			$row[] = $veh_doc->next_service;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$veh_doc->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$veh_doc->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->ss_model->count_all(),
						"recordsFiltered" => $this->ss_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ser_set_edit($id)
	{
		$data = $this->ss_model->get_by_id($id);
		/*$data->tanggal = date_indonesia($data->tanggal);*/
		echo json_encode($data);
	}

	public function get_vehicle_by_id($id)
	{
		$data = $this->ss_model->get_vehicle_by_id($id);
		echo json_encode($data);
	}

	public function ser_set_update()
	{
		//$this->_validate_vd();

		$data = array(
				'id' => $this->input->post('f_id_vehicle_doc'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'nap' => $this->input->post('f_nap'),
				'nomor_plat' => $this->input->post('f_nopol'),
				'year' => $this->input->post('f_year'),
				'code_unit' => $this->input->post('f_code_unit'),
				'ownership' => $this->input->post('f_status'),
				'pic_code' => $this->input->post('f_users'),
				'bulan' => $this->input->post('f_month'),
				'tahun' => $this->input->post('f_tahun'),
				'service_at' => $this->input->post('f_service_at'),
				'last_service' => $this->input->post('f_last_service'),
				'next_service' => $this->input->post('f_next_service'),
			);

		$this->ss_model->update(array('id' => $this->input->post('f_id_vehicle_doc')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function rpt_services()
	{
		$group = "ga";

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
			$data['title'] = 'Report Vehicle Services';
			//dd empcode
			$data['dd_empcode'] = $this->master_lov->dd_empcode();
	        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
	        //dd grade status
	        $data['dd_dept'] = $this->master_lov->dd_dept();
	        $data['dd_dept_selected'] = $this->input->post('departement') ? $this->input->post('departement') : '';
	        //
	        $data['dd_emp_pos'] = $this->master_lov->dd_emp_position();
	        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
	        //dd empoyee status
			$data['dd_emp_status'] = $this->master_lov->dd_emp_status();
	        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

	        //dropdown untuk vehicle code
				$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
		        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';

if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('template/header_ga');
			$this->load->view('temp/sidebar');
			$this->load->view('rpt_services');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_rpt_services',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}
	}

	public function process_rpt_services()
	{
		$jenis = $this->input->get('f_rpt_type');
		$bulan = $this->input->get('filter_month');
		$tahun = $this->input->get('filter_year');
		$tgl_cetak = $this->input->get('print_date');
		$created_by = $this->input->get('f_create_by');
		/*echo $jenis;
		echo $bulan;
		echo $tahun;
		echo $tgl_cetak;
		echo $created_by;*/
		switch ($jenis) {
			case 'daily':
				$this->daily_report($bulan, $tahun);
				break;
			
			case 'monthly':
				$this->rpt_km_monthly($bulan, $tahun, $created_by);
				break;
		}
	}

	public function ser_set_delete($id)
	{	
		$this->ss_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));

	}
/*end of controller untuk service setup atau header dari vehicle services*/
public function test_sheet(
){
	$bulan = 5;
	$tahun = 2018;
	$nap = "97-68";
	//$data = $this->ss_model->get_sheet_name($bulan,$tahun, $nap);
	//$data = $this->ss_model->get_vehicle_by_id($nap);
	//$data = $this->ss_model->get_data_daily_report($bulan,$tahun, $nap);
	//$data = $this->vm_daily->rpt_monthly_km($bulan,$tahun);
	$data = $this->vm_daily->notif_tidak_p2h();
	echo json_encode($data);
	//print_r($data);
	
}

public function list_notif_tidak_p2h()
{
	$data = $this->vm_daily->notif_tidak_p2h();
	echo json_encode($data);
}

public function list_notif_next_service()
{
	$data = $this->vm_daily->list_notif_next_service();
	echo json_encode($data);
}


public function test_date ()
{
	$from = "01-06-2018";
		$to = "30-06-2018";
		/*parameter untuk di query filter nya berdasarkan operator*/
		
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$batas = $c->format('%a');
	/*for ($i=0; $i <= $batas ; $i++) { 
		//$date = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
		//$date=date("d", $date);
		echo "<td>".$dat."</td>";
		echo "<br>";
		}*/
		echo "<table border='1'>";
		echo "<tr>";
		$daily = $this->ss_model->get_data_daily_report(6,2018,"97-76"); // model KM harian
		$i = 0;
		foreach ($daily as $key) {
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		$dat=date("Y-m-d", $date);
			//echo $key->tanggal."<br>";
			if ($dat == $key->tanggal ) {
			echo "<td>data ".$key->tanggal."</td>";
			}
		else{
			echo "<td>loop ".$dat."</td>";
		}
			echo "<td>data ".$key->tanggal."</td>";
			echo "<td>loop luar".$dat."</td>";
		echo "</tr>";
		$i++;
		}
		echo "</table>";

}
/*report daily operational */

public function daily_report($bulan, $tahun)
{
	/*$bulan = 5;
	$tahun = 2018;*/
	$data = $this->ss_model->get_sheet_name(); // data sheet name

		$spreadsheet = new Spreadsheet();
$i = 0; // parameter untuk mengulang pemberian nama sheet
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '1e232b'],
        ],
    ],
]; //array untuk membuat all border
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman'); //membuat default font menjadii times new roman

foreach ($data as $key) {
	$nap = $key->nap; //manipulasi agar mendapatkan nomor nap, supaya bisa di pakai utk model yang lainnya

		$sheet_tgh = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'test'); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_tgh); // add sheet
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A1:I1');// merge judul
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A2:I2'); //merge sub judul
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A4:C4'); //merge properti
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A5:C5'); //Tahun unit
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A6:C6'); //codeunit
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A7:C7'); //nap
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('D4:F4'); //bulan
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('D5:F5'); //status
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('D6:F6'); // user
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('D7:F7'); // dept
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('H6:J6'); // last km
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('H7:J7'); // next KM
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('H7:J7'); // next KM
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('A8:A9'); // header tanggal
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('B8:C8'); // header Shift satu
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('D8:D9'); // header Total KM shift 1
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('E8:E9'); // header NOTe shift 1
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('F8:G8'); // header Shift dua
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('H8:H9'); // header Total KM shift 2
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('I8:I9'); // header Note shift 2
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('B43:C43'); // MARGE GRAND TOTAL SHIFT 1
		$spreadsheet->setActiveSheetIndex($i)->mergeCells('F43:G43'); // MARGE GRAND TOTAL SHIFT 2
		$spreadsheet->setActiveSheetIndex($i)
		->setCellValue('A1', "Daily Operational Report")
		->setCellValue('A2', "Unit Sarana");
		/*$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath(base_url().'assets/login.jpg');
$drawing->setHeight(36);
$spreadsheet->getActiveSheet()->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);*/
		$grand_total = $this->ss_model->grand_total_daily($bulan,$tahun,$nap); // grand total
		foreach ($grand_total as $total) {
		$spreadsheet->setActiveSheetIndex($i)
		->setCellValue('B43', "Grand Total : ")
		->setCellValue('F43', "Grand Total : ")
		->setCellValue('D43', $total->gt_shift_satu)
		->setCellValue('H43', $total->gt_shift_dua)
		->getStyle('A43:I43')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('6098f2');
		}

		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(24); // mengubah font menjadi 24
		$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(24);	// mengubah font menjadi 24
		$spreadsheet->getActiveSheet()->getStyle('A43:H43')->getFont()->setSize(14);	// mengubah font menjadi 14
		$spreadsheet->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->setActiveSheetIndex($i) // header laporan
		->setCellValue('A4', "No Polisi : ".$key->nomor_plat)
		->setCellValue('A5', "Tahun : ".$key->year)
		->setCellValue('A6', "Code Unit : ".$key->code_unit)
		->setCellValue('A7', "NAP : ".$key->nap)
		->setCellValue('D4', "Bulan : ".$bulan."-".$tahun)
		->setCellValue('D5', "Status : ".$key->ownership)
		->setCellValue('D6', "User : ".$key->pic_code)
		->setCellValue('D7', "Dept : - ")
		->setCellValue('H6', "Last KM : ".$key->last_service)
		->setCellValue('H7', "Next KM : ".$key->next_service);
		$spreadsheet->setActiveSheetIndex($i) // nama field laporan
		->setCellValue('A8', "TGL")
		->setCellValue('B8', "SHIFT 1 (KM)")
		->setCellValue('B9', "START")
		->setCellValue('C9', "STOP")
		->setCellValue('D8', "TOTAL")
		->setCellValue('E8', "NOTE")
		->setCellValue('F8', "SHIFT 2 (KM)")
		->setCellValue('F9', "START")
		->setCellValue('G9', "STOP")
		->setCellValue('H8', "TOTAL")
		->setCellValue('I8', "NOTE")
		->getStyle('A8:I9')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('6098f2');
	    /*mendapatkan data report daily*/
		$daily = $this->ss_model->get_data_daily_report($bulan,$tahun, $nap); // model KM harian
		$begin = 10; // dimulai dari baris cell ke 10
		foreach ($daily as $dil) {
			$spreadsheet->setActiveSheetIndex($i)
		->setCellValue('A'.$begin, date_indonesia($dil->tanggal))
		->setCellValue('B'.$begin, $dil->start_satu)
		->setCellValue('C'.$begin, $dil->stop_satu)
		->setCellValue('D'.$begin, $dil->total_satu)
		->setCellValue('E'.$begin, $dil->remarks_satu)
		->setCellValue('F'.$begin, $dil->start_dua)
		->setCellValue('G'.$begin, $dil->stop_dua)
		->setCellValue('H'.$begin, $dil->total_dua)
		->setCellValue('I'.$begin, $dil->remarks_dua);
		/*->setCellValue('B'.$begin, $key->start_satu);*/
		$begin++;
		}

$spreadsheet->setActiveSheetIndex($i)->setTitle($key->code_unit); // membuat nama sheet berdasarkan kode unit
$spreadsheet->setActiveSheetIndex($i)->getStyle('A8:I42')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
/*mengatur width sesuai kebutuhan*/
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('A')->setWidth(12); //set width menjadi 12
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('B')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('C')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('D')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('E')->setAutoSize(true); //set widht menjadi autosize
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('F')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('G')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('H')->setWidth(12);
$spreadsheet->setActiveSheetIndex($i)->getColumnDimension('I')->setAutoSize(true);

/*footer laporan*/
    $spreadsheet->setActiveSheetIndex($i)
		->setCellValue('A44', "-")
		->setCellValue('A45', "-")
		->setCellValue('A46', "-")
		->setCellValue('I44', "APPROVED BY")
		->setCellValue('I50', "GA DEPARTEMENT")
		->setCellValue('A47', "-");
	    $spreadsheet->setActiveSheetIndex($i)
		->setCellValue('B44', "Daily report sebagai fungsi kontrol unit sarana operasional.")
		->setCellValue('B45', "Di-isi oleh user, driver atau pengguna unit sarana.")
		->setCellValue('B46', "Dilaporkan mingguan ke Management Site, bulanan ke KP - Surabaya.")
		->setCellValue('B47', "Dilakukan review mingguan oleh HRGA Site, untuk monitoring.")
		->setCellValue('B48', "Koordinasi user/driver dan problem solving.");

$i++;
}
	$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DAILY P2H BULAN-'.$bulan.'-'.$tahun.'-'.$nama_file.' .xlsx"');
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
/*end of report daily operational*/

public function rpt_km_monthly($bulan, $tahun, $admin)
{
	/*$bulan = 5;
	$tahun = 2018;*/
	$from = "01-".$bulan."-".$tahun;
	/*$admin = "Ria Oktaviani";*/
	$batas = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
	switch ($bulan) {
		case 1:
			$bln = "Januari";
			break;
			case 2:
			$bln = "Februari";
			break;
			case 3:
			$bln = "Maret";
			break;
			case 4:
			$bln = "April";
			break;
			case 5:
			$bln = "Mei";
			break;
			case 6:
			$bln = "Juni";
			break;
			case 7:
			$bln = "Juli";
			break;
			case 8:
			$bln = "Agustus";
			break;
			case 9:
			$bln = "September";
			break;
			case 10:
			$bln = "Oktober";
			break;
			case 11:
			$bln = "November";
			break;
			case 12:
			$bln = "Desember";
			break;
	}



		$spreadsheet = new Spreadsheet();

		$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '111111'],
        ],
    ],
]; //array untuk membuat all border
$styleArray_judul = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '111111'],
        ],
    ],
]; //array untuk membuat all border
$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(4); //set width menjadi 12
$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(12); //set width menjadi 12
$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10); //set width menjadi 12
$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(5); //set width menjadi 12
$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(16); //set width menjadi 12

		$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman'); //membuat default font menjadii times new roman
		

		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:AK4');// merge judul
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', "DAILY INPUT SERVICE METER UNIT ".strtoupper($bln). " ".$tahun)
		->setCellValue('A6', "Admin : ".$admin)
		->setCellValue('A7', "Periode : ".$bulan."-".$tahun);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(18); // mengubah font menjadi 24
		$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		/*NOTE*/
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A44', "1. Lebih dioptimalkan PERAWATAN sarana untuk setiap user")
		->setCellValue('A45', "2. Lebih dioptimalkan PEMAKAIAN sarana dengan cara yang aman")
		->setCellValue('A46', "3. Lebih dioptimalkan KEBERSIHAN sarana baik diluar maupun didalam")
		->setCellValue('A47', "4. Lebih dioptimalkan RASA MEMILIKI terhadap sarana yang digunakan")
		->setCellValue('A48', "5. lebih dioptimalkan RASA TANGGUNG JAWAB terhadap sarana yang digunakan");
		/*END OF NOTE*/


		/*KETERANGAN WARNA*/
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K44', "KETERANGAN : ");

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K45', "TIDAK ADA P2H")
		->getStyle('K45')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('a442f4');

	    $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K46', "KM ERROR")
		->getStyle('K46')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('858e9b');

	    $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K47', "STANDBY")
		->getStyle('K47')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('757889');

	    $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K48', "BREAKDOWN")
		->getStyle('K48')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('0e7c55');

	    $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('K49', "TROUBLES")
		->getStyle('K49')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('897a75');
		/* END OF KETERANGAN WARNA*/



		$no = 11;
	    $urut = 0;
	    $urutan = 0;
		$data = $this->vm_daily->rpt_monthly_km($bulan,$tahun);
		switch ($batas) {
			case '32':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AK10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AK38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AK10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas

			foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
				/*->setCellValue('F'.$no, $key->D1)
				->setCellValue('G'.$no, $key->D2)
				->setCellValue('H'.$no, $key->D3)
				->setCellValue('I'.$no, $key->D4)
				->setCellValue('J'.$no, $key->D5)
				->setCellValue('K'.$no, $key->D6)
				->setCellValue('L'.$no, $key->D7)
				->setCellValue('M'.$no, $key->D8)
				->setCellValue('N'.$no, $key->D9)
				->setCellValue('O'.$no, $key->D10)
				->setCellValue('P'.$no, $key->D11)
				->setCellValue('Q'.$no, $key->D12)
				->setCellValue('R'.$no, $key->D13)
				->setCellValue('S'.$no, $key->D14)
				->setCellValue('T'.$no, $key->D15)
				->setCellValue('U'.$no, $key->D16)
				->setCellValue('V'.$no, $key->D17)
				->setCellValue('W'.$no, $key->D18)
				->setCellValue('X'.$no, $key->D19)
				->setCellValue('Y'.$no, $key->D20)
				->setCellValue('Z'.$no, $key->D21)
				->setCellValue('AA'.$no, $key->D22)
				->setCellValue('AB'.$no, $key->D23)
				->setCellValue('AC'.$no, $key->D24)
				->setCellValue('AD'.$no, $key->D25)
				->setCellValue('AE'.$no, $key->D26)
				->setCellValue('AF'.$no, $key->D27)
				->setCellValue('AG'.$no, $key->D28)
				->setCellValue('AH'.$no, $key->D29)
				->setCellValue('AI'.$no, $key->D30)
				->setCellValue('AJ'.$no, $key->D31)
				->setCellValue('AK'.$no, $key->D32);*/

				// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 75 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
									else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
							else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
				
				$urut++;
				$no++;
    }

			break;
			case '31':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AJ10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A11:AJ38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AJ10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas
foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
				/*->setCellValue('F'.$no, $key->D1)
				->setCellValue('G'.$no, $key->D2)
				->setCellValue('H'.$no, $key->D3)
				->setCellValue('I'.$no, $key->D4)
				->setCellValue('J'.$no, $key->D5)
				->setCellValue('K'.$no, $key->D6)
				->setCellValue('L'.$no, $key->D7)
				->setCellValue('M'.$no, $key->D8)
				->setCellValue('N'.$no, $key->D9)
				->setCellValue('O'.$no, $key->D10)
				->setCellValue('P'.$no, $key->D11)
				->setCellValue('Q'.$no, $key->D12)
				->setCellValue('R'.$no, $key->D13)
				->setCellValue('S'.$no, $key->D14)
				->setCellValue('T'.$no, $key->D15)
				->setCellValue('U'.$no, $key->D16)
				->setCellValue('V'.$no, $key->D17)
				->setCellValue('W'.$no, $key->D18)
				->setCellValue('X'.$no, $key->D19)
				->setCellValue('Y'.$no, $key->D20)
				->setCellValue('Z'.$no, $key->D21)
				->setCellValue('AA'.$no, $key->D22)
				->setCellValue('AB'.$no, $key->D23)
				->setCellValue('AC'.$no, $key->D24)
				->setCellValue('AD'.$no, $key->D25)
				->setCellValue('AE'.$no, $key->D26)
				->setCellValue('AF'.$no, $key->D27)
				->setCellValue('AG'.$no, $key->D28)
				->setCellValue('AH'.$no, $key->D29)
				->setCellValue('AI'.$no, $key->D30)
				->setCellValue('AJ'.$no, $key->D31);*/
				/*for ($i=1; $i <= 2 ; $i++) { 
					$d = "D".$i;*/
					// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 74 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
										else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
								else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
					
			
				$urut++;
				$no++;
    } //end case

			break;
			case '30':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AI10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AI38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AI10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas

			foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
				/*->setCellValue('F'.$no, $key->D1)
				->setCellValue('G'.$no, $key->D2)
				->setCellValue('H'.$no, $key->D3)
				->setCellValue('I'.$no, $key->D4)
				->setCellValue('J'.$no, $key->D5)
				->setCellValue('K'.$no, $key->D6)
				->setCellValue('L'.$no, $key->D7)
				->setCellValue('M'.$no, $key->D8)
				->setCellValue('N'.$no, $key->D9)
				->setCellValue('O'.$no, $key->D10)
				->setCellValue('P'.$no, $key->D11)
				->setCellValue('Q'.$no, $key->D12)
				->setCellValue('R'.$no, $key->D13)
				->setCellValue('S'.$no, $key->D14)
				->setCellValue('T'.$no, $key->D15)
				->setCellValue('U'.$no, $key->D16)
				->setCellValue('V'.$no, $key->D17)
				->setCellValue('W'.$no, $key->D18)
				->setCellValue('X'.$no, $key->D19)
				->setCellValue('Y'.$no, $key->D20)
				->setCellValue('Z'.$no, $key->D21)
				->setCellValue('AA'.$no, $key->D22)
				->setCellValue('AB'.$no, $key->D23)
				->setCellValue('AC'.$no, $key->D24)
				->setCellValue('AD'.$no, $key->D25)
				->setCellValue('AE'.$no, $key->D26)
				->setCellValue('AF'.$no, $key->D27)
				->setCellValue('AG'.$no, $key->D28)
				->setCellValue('AH'.$no, $key->D29)
				->setCellValue('AI'.$no, $key->D30);*/

				// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 73 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
										else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
								else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
					
				$urut++;
				$no++;
    }

			break;
			case '29':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AH10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AH38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AH10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas

foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
				/*->setCellValue('F'.$no, $key->D1)
				->setCellValue('G'.$no, $key->D2)
				->setCellValue('H'.$no, $key->D3)
				->setCellValue('I'.$no, $key->D4)
				->setCellValue('J'.$no, $key->D5)
				->setCellValue('K'.$no, $key->D6)
				->setCellValue('L'.$no, $key->D7)
				->setCellValue('M'.$no, $key->D8)
				->setCellValue('N'.$no, $key->D9)
				->setCellValue('O'.$no, $key->D10)
				->setCellValue('P'.$no, $key->D11)
				->setCellValue('Q'.$no, $key->D12)
				->setCellValue('R'.$no, $key->D13)
				->setCellValue('S'.$no, $key->D14)
				->setCellValue('T'.$no, $key->D15)
				->setCellValue('U'.$no, $key->D16)
				->setCellValue('V'.$no, $key->D17)
				->setCellValue('W'.$no, $key->D18)
				->setCellValue('X'.$no, $key->D19)
				->setCellValue('Y'.$no, $key->D20)
				->setCellValue('Z'.$no, $key->D21)
				->setCellValue('AA'.$no, $key->D22)
				->setCellValue('AB'.$no, $key->D23)
				->setCellValue('AC'.$no, $key->D24)
				->setCellValue('AD'.$no, $key->D25)
				->setCellValue('AE'.$no, $key->D26)
				->setCellValue('AF'.$no, $key->D27)
				->setCellValue('AG'.$no, $key->D28)
				->setCellValue('AH'.$no, $key->D29);*/

				// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 72 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
										else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
								else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
					
				$urut++;
				$no++;
    }

			break;
			case '28':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AG10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AJ10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AJ38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas

				foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
				/*
				->setCellValue('F'.$no, $key->D1)
				->setCellValue('G'.$no, $key->D2)
				->setCellValue('H'.$no, $key->D3)
				->setCellValue('I'.$no, $key->D4)
				->setCellValue('J'.$no, $key->D5)
				->setCellValue('K'.$no, $key->D6)
				->setCellValue('L'.$no, $key->D7)
				->setCellValue('M'.$no, $key->D8)
				->setCellValue('N'.$no, $key->D9)
				->setCellValue('O'.$no, $key->D10)
				->setCellValue('P'.$no, $key->D11)
				->setCellValue('Q'.$no, $key->D12)
				->setCellValue('R'.$no, $key->D13)
				->setCellValue('S'.$no, $key->D14)
				->setCellValue('T'.$no, $key->D15)
				->setCellValue('U'.$no, $key->D16)
				->setCellValue('V'.$no, $key->D17)
				->setCellValue('W'.$no, $key->D18)
				->setCellValue('X'.$no, $key->D19)
				->setCellValue('Y'.$no, $key->D20)
				->setCellValue('Z'.$no, $key->D21)
				->setCellValue('AA'.$no, $key->D22)
				->setCellValue('AB'.$no, $key->D23)
				->setCellValue('AC'.$no, $key->D24)
				->setCellValue('AD'.$no, $key->D25)
				->setCellValue('AE'.$no, $key->D26)
				->setCellValue('AF'.$no, $key->D27)
				->setCellValue('AG'.$no, $key->D28);*/

				// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 71 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
										else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
								else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
					
				$urut++;
				$no++;
    }

			break;
			case '27':
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A10', "NO")
				->setCellValue('B10', "NO Polisi")
				->setCellValue('C10', "Code Unit")
				->setCellValue('D10', "NAP")
				->setCellValue('E10', "User");
				/*->getStyle('A10:AF10')->getFill()
			    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			    ->getStartColor()->setARGB('505254');*/
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AF38')->applyFromArray($styleArray); //membuat all border dengan array yang sudah di definisikan diatas
$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:AF10')->applyFromArray($styleArray_judul); //membuat all border dengan array yang sudah di definisikan diatas

foreach ($data as $key) {
    	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$no, $urut)
				->setCellValue('B'.$no, $key->nomor_plat)
				->setCellValue('C'.$no, $key->code_unit)
				->setCellValue('D'.$no, $key->nap)
				->setCellValue('E'.$no, $key->pic_code);
			/*->setCellValue('F'.$no, $key->D1)
			->setCellValue('G'.$no, $key->D2)
			->setCellValue('H'.$no, $key->D3)
			->setCellValue('I'.$no, $key->D4)
			->setCellValue('J'.$no, $key->D5)
			->setCellValue('K'.$no, $key->D6)
			->setCellValue('L'.$no, $key->D7)
			->setCellValue('M'.$no, $key->D8)
			->setCellValue('N'.$no, $key->D9)
			->setCellValue('O'.$no, $key->D10)
			->setCellValue('P'.$no, $key->D11)
			->setCellValue('Q'.$no, $key->D12)
			->setCellValue('R'.$no, $key->D13)
			->setCellValue('S'.$no, $key->D14)
			->setCellValue('T'.$no, $key->D15)
			->setCellValue('U'.$no, $key->D16)
			->setCellValue('V'.$no, $key->D17)
			->setCellValue('W'.$no, $key->D18)
			->setCellValue('X'.$no, $key->D19)
			->setCellValue('Y'.$no, $key->D20)
			->setCellValue('Z'.$no, $key->D21)
			->setCellValue('AA'.$no, $key->D22)
			->setCellValue('AB'.$no, $key->D23)
			->setCellValue('AC'.$no, $key->D24)
			->setCellValue('AD'.$no, $key->D25)
			->setCellValue('AE'.$no, $key->D26)
			->setCellValue('AF'.$no, $key->D27);*/
			// for untuk alphabet dari F(70)-Z(90)
					for ($alph=70; $alph <= 91 ; $alph++) { 
					$hur = strtoupper(chr($alph)); // menjadi Uppercase
					$par = $alph - 69; // parameter untuk nama field D1, di kurang 69 agar menjadi 1
					$d = "D".$par; // parameter untuk mengambil nama field D1...
					$setval = $hur.$no; // membuat nama cell

							// jika sudah sampai ke huruf Z atau angka 90 maka melakukan peruulangan untuk mendapatkan cell AA AB AC dst
							if ($alph > 90) {
								// dimulai dari perulangan AA - AJ disesuaikan dengan jumlah hari dalam 1 bulan, AJ = 31 Hari
								for ($alph_b=65; $alph_b <= 70 ; $alph_b++) { 
								$hur = strtoupper(chr($alph_b));
								$par = $alph_b - 43;
								$d = "D".$par;
								$setval = "A".$hur.$no;
								$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
								}
								else
									{
										$str = explode(",", $key->$d);
										if ($str[0] == "KM ERROR") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('858e9b');
										}
										else if ($str[0] == "STANDBY") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('757889');
										}
										else if ($str[0] == "BREAKDOWN") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('0e7c55');
										}
										else if ($str[0] == "TROUBLES") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('897a75');
										}
										else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
									} //end else
							} // end for cell double
						} // end if for cell double

						/*menampilkan data dari cell A - Z*/
					$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($setval, $key->$d);
							if ($key->$d == "TIDAK ADA P2H") {
							$spreadsheet->setActiveSheetIndex(0)
							//->setCellValue($setval, $key->$d.$setval.$d)
							->getStyle($setval)->getFill()
						    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						    ->getStartColor()->setARGB('a442f4');
						}
						else
							{
								$str = explode(",", $key->$d);
								if ($str[0] == "KM ERROR") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('858e9b');
								}
								else if ($str[0] == "STANDBY") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('757889');
								}
								else if ($str[0] == "BREAKDOWN") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('0e7c55');
								}
								else if ($str[0] == "TROUBLES") {
									$spreadsheet->setActiveSheetIndex(0)
									->getStyle($setval)->getFill()
							    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							    ->getStartColor()->setARGB('897a75');
								}
								else if ($str[0] == "TIDAK P2H") {
											$spreadsheet->setActiveSheetIndex(0)
											->getStyle($setval)->getFill()
									    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
									    ->getStartColor()->setARGB('a442f4');
										}
							} //end else
					} // end for alphabet


				//} // end foreach
					
				$urut++;
				$no++;
    }

			break;
		}
		

		
	    for ($i=0; $i < $batas ; $i++) { 
		$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
		$date=date("d", $date);
		$field_a[] = "D".$date;
		}
		$data_array = array($field_a);
		$spreadsheet->getActiveSheet()
    ->fromArray(
        $data_array,  // The data to set
        NULL,        // Array values with this value will not be set
        'F10'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="MONTHLY KM BULAN-'.$bulan.'-'.$tahun.'-'.$nama_file.' .xlsx"');
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


/*vehicle monitoting p2h*/
public function vehicle_monitoring_p2h()
	{
	$group = "ga";
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	else{
		 	$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
		 $data = array(
            'title' => 'Vehicle Monitoring P2H',
            'username' => $email,
		);
		 //dropdown untuk vehicle code
		$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
			 if ($this->ion_auth->in_group($group)) {
			$this->load->view('temp/title',$data);
			$this->load->view('template/header_ga');
			$this->load->view('temp/sidebar');
			$this->load->view('f_veh_mon_p2h');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_veh_mon_p2h');
	        }
		    else
		    {
					return show_error('You must be an administrator to view this page.');

	   		 }

		}
	}

	/*list ajax untuk vehicle monitoring*/
	public function veh_mon_p2h_list()
	{
	$list = $this->p2h_mon_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $a->nomor_plat;
			$row[] = $a->nap;
			$row[] = $a->code_unit;
			$row[] = $a->pic;
			$row[] = date_indonesia($a->last_date);
			$row[] = $a->last_km;
			//$row[] = $a->kondisi;
			//$row[] = $a->status;
			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->p2h_mon_model->count_all(), 
			'recordsFiltered' => $this->p2h_mon_model->count_filtered(), 
			'data' => $data,  
		);
		// output to json format
		echo json_encode($output);
	}

	/*vehicle nexxt service*/
	public function vehicle_next_service()
	{
	$group = "ga";
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	else{
		 	$obj_user = $this->ion_auth->user()->row();
				$email = $obj_user->username;
				$data['username'] = $email;
		 $data = array(
            'title' => 'Vehicle Next Services',
            'username' => $email,
		);
		 //dropdown untuk vehicle code
		$data['dd_vehicle_code'] = $this->lov->dd_vehicle();
        $data['vehicle_code'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';
			 if ($this->ion_auth->in_group($group)) {
			$this->load->view('temp/title',$data);
			$this->load->view('template/header_ga');
			$this->load->view('temp/sidebar');
			$this->load->view('f_veh_next_serv');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_veh_next_serv');
	        }
		    else
		    {
					return show_error('You must be an administrator to view this page.');

	   		 }

		}
	}

	/*list ajax untuk vehicle monitoring*/
	public function vehicle_next_service_list()
	{
	$list = $this->veh_next_services->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $a->nap;
			$row[] = $a->code_unit;
			$row[] = $a->max_km;
			$row[] = date_indonesia($a->tanggal);
			$row[] = $a->next_service;
			$row[] = $a->sisa;
			//$row[] = $a->parameter;
			//$row[] = $a->status;
			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->veh_next_services->count_all(), 
			'recordsFiltered' => $this->veh_next_services->count_filtered(), 
			'data' => $data,  
		);
		// output to json format
		echo json_encode($output);
	}

	public function all()
	{
		$start = "2018-08-01"; 
		$end = "2018-08-31";
		$fuck = $this->veh_fuel->rpt_summary_fuel_sarana($start, $end);
		echo "<pre>";
		echo print_r($fuck);
		echo "</pre>";
	}

	public function vehicle_fuel()
	{
		$group = "ga";
		if (!$this->ion_auth->logged_in()) {
			// redirect ke halaman login
			redirect('auth/login','referesh');
		}
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$email = $obj_user->username;
			//$data['username'] = $email;
			$data = array(
				'title' => 'Vehicle Fuel Consumption',
				'username' => $email,
				'dd_vehicle_code' => $this->lov->dd_vehicle(),
				'vehicle_code_selected' => $this->input->post('f_nap') ? $this->input->post('f_nap') :'',
				'dd_empcode' => $this->lov->dd_empcode(),
				'empcode_selected' => $this->input->post('f_empcode') ? $this->input->post('f_empcode') :'',
			);
			if ($this->ion_auth->in_group($group)) {
							$this->load->view('temp/title',$data);
							$this->load->view('template/header_ga');
							$this->load->view('temp/sidebar');
							$this->load->view('f_vehicle_fuel');
							$this->load->view('temp/footer');
							$this->load->view('notif');
							$this->load->view('ajax_f_vehicle_fuel');
						}
						else{
							return show_error('You must be an administrator to view this page.');
						}		
		}

	}

	// start vehicle fuel add
	public function vehicle_fuel_add()
	{
		$date = substr($this->input->post('f_date'),0,-5);
		$nap = $this->input->post('f_nap');
		$this->_validate_veh_fuel();
		$cek = $this->is_exist_vehicle_fuel(date_input($date), $nap);
		if ($cek == 1) {
			$data['inputerror'][] = 'f_date';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
	else {

		$data = array(
			'no_voucher' => $this->input->post('f_no_voucher'),
			'tanggal_pengisian' => date_input_datetime($this->input->post('f_date')),
			'nap' => $this->input->post('f_nap'),
			'qty' => $this->input->post('f_qty'),
			'hmkm' => $this->input->post('f_hmkm'),
			'fuelman' => $this->input->post('f_fuelman'),
			'driver' => $this->input->post('f_driver'),
			'inputby' => $this->input->post('f_input_by'),
			'inputdate' => $this->input->post('f_input_date'),
		);
		$this->veh_fuel->save($data);
		echo json_encode(array("status" => TRUE));
		}
	} // end of vehicle fuel add

	/*start vehicle fuel list ajax*/
	public function veh_fuel_list()
	{
		$list = $this->veh_fuel->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->nap;
			$row[] = $key->no_voucher;
			$row[] = $key->tanggal;
			$row[] = $key->jam;
			$row[] = $key->qty;
			$row[] = $key->hmkm;
			$row[] = $key->nomor_plat;
			$row[] = $key->driver;
			$row[] = $key->fuelman;
			//$row[] = "";

			$row[] = '<a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-primary" onclick="edit_data('."'".$key->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger" onclick="delete_data('."'".$key->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->veh_fuel->count_all(),
			"recordsFiltered" => $this->veh_fuel->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	} /*end of vehicle fuel list*/

	/*start veh fuel edit*/
	public function veh_fuel_edit($id)
	{
		$data = $this->veh_fuel->get_by_id($id);
		$data->tanggal_pengisian = date_indonesia_datetime($data->tanggal_pengisian);
		echo json_encode($data);
	}
	/*end of veh fuel edit*/

	/*start veh fuel deleter*/
	public function veh_fuel_delete($id)
	{
		$this->veh_fuel->delete_by_id($id);
		echo json_encode(array("status"=>TRUE));
	}
	/*end of veh fuel delete*/

	/*start veh fuel update*/
	public function veh_fuel_update()
	{
		$this->_validate_veh_fuel();
		$data = array(
			'updateby' => $this->input->post('f_update_by'),
			'updatedate' => $this->input->post('f_update_date'),
			'no_voucher' => $this->input->post('f_no_voucher'),
			'tanggal_pengisian' => date_input_datetime($this->input->post('f_date')),
			'nap' => $this->input->post('f_nap'),
			'qty' => $this->input->post('f_qty'),
			'hmkm' => $this->input->post('f_hmkm'),
			'fuelman' => $this->input->post('f_fuelman'),
			'driver' => $this->input->post('f_driver'),
		);
		$this->veh_fuel->update(array("id"=> $this->input->post('f_id_vehicle_fuel')), $data);
		echo json_encode(array("status"=>TRUE));
	}
	/*end of veh fuel update*/

	//public function data_fuel_sarana($start, $end)
	public function data_fuel_sarana()
	{
		$start = date_input($this->input->post('filter_start'));
		$end = date_input($this->input->post('filter_end'));
		/*$data = $this->veh_fuel->data_summary_fuel_sarana($start, $end);
		/*$start = "2018-08-01";
		$end = "2018-08-31";*/
		$data = $this->veh_fuel->data_summary_fuel_sarana($start, $end);
		echo json_encode($data);

	}

	public function rpt_vehicle_fuel_graph()
	{
		$group = "ga";
		if (!$this->ion_auth->logged_in())
		{
			// redirect all to login page
			redirect('auth/login','refresh');
		}
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$email = $obj_user->username;
			$data = array(
				'title' => 'Grafik Fuel Consumption',
				'username' => $email,
			);


			if ($this->ion_auth->in_group($group)) {
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_vehicle_fuel_graph',$data);
				$this->load->view('temp/footer');
				$this->load->view('notif');
				$this->load->view('ajax_vehicle_fuel_graph');
			}
			else{
				return show_error('You must be an administrator to view this page.');
			}
		}
	
	}

	public function test_graph()
	{
		$this->load->view('vehicle_graph');
		//$this->load->view('bar_garph');

	}

	public function rpt_fuel_liter_per_km()
	{
		$start 	= date_input($this->input->post('filter_start')); 
		$end 	= date_input($this->input->post('filter_end'));
		$start 	= "2018-08-01";
		$end 	= "2018-08-31";
		$data_fuel = $this->veh_fuel->rpt_summary_fuel_sarana($start, $end);
		$data_fuel_total = $this->veh_fuel->total_fuel_ga($start, $end);
		$data_fuel_per_km = $this->veh_fuel->fuel_per_km($start, $end);
		$spreadsheet = new Spreadsheet(); // inisialisasi new spreadsheet
		$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '1e232b'],
        ],
    ],
]; //array untuk membuat all border

		$spreadsheet->setActiveSheetIndex(0)->setTitle('Detail Data'); // membuat nama sheet
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1','PT. PRIMA INDOJAYA MANDIRI');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A2','LAPORAN KONSUMSI BBM SARANA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A3','DARI TANGGAL '.date_indonesia($start).' SAMPAI '.date_indonesia($end).'');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5','No');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B5','NAP');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C5','Code Unit');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D5','Nomor Plat');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E5','Tanggal Pengisian');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F5','Quantity');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G5','HMKM');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H5','Fuelman');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I5','Driver');
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:I1'); // merge judul sheet detail data
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A2:I2'); // merge judul sheet detail data
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A3:I3'); // merge judul sheet detail data
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah

		$spreadsheet->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah

		$spreadsheet->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah




		$row_excel_out = 6;
		$no_out = 1;
		foreach ($data_fuel as $key) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$row_excel_out, $no_out)
			->setCellValue('B'.$row_excel_out, $key->nap)
			->setCellValue('C'.$row_excel_out, $key->code_unit)
			->setCellValue('D'.$row_excel_out, $key->nomor_plat)
			->setCellValue('E'.$row_excel_out, $key->tanggal_pengisian)
			->setCellValue('F'.$row_excel_out, $key->qty)
			->setCellValue('G'.$row_excel_out, $key->hmkm)
			->setCellValue('H'.$row_excel_out, $key->fuelman)
			->setCellValue('I'.$row_excel_out, $key->driver);
			$no_out++;
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A5:I'.$row_excel_out.'')->applyFromArray($styleArray);
			$row_excel_out++;
		}

		$sheet_total_fuel = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Total Fuel'); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_total_fuel); // add new sheet
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1','TOTAL FUEL');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A2','NO');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('B2','NAP');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('C2','CODE UNIT');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D2','NOMOR PLAT');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('E2','TOTAL FUEL');

		$row = 3;
		$no_total = 1;
		foreach ($data_fuel_total as $key) {
			$spreadsheet->setActiveSheetIndex(1)
			->setCellValue('A'.$row, $no_total)
			->setCellValue('B'.$row, $key->nap)
			->setCellValue('C'.$row, $key->code_unit)
			->setCellValue('D'.$row, $key->nomor_plat)
			->setCellValue('E'.$row, $key->total);
		$spreadsheet->setActiveSheetIndex(1)->getStyle('A2:E'.$row.'')->applyFromArray($styleArray);
			$row++;
			$no_total++;
		}

		$liter_per_km = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Fuel per Liter');
		$spreadsheet->addSheet($liter_per_km);

		$spreadsheet->setActiveSheetIndex(2)->setCellValue('A1','FUEL PER KILOMETER SARANA GA PERIODE '.date_indonesia($start).' s/d '.date_indonesia($end).'');
		$spreadsheet->getActiveSheet()->getStyle('A1:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->setActiveSheetIndex(2)->mergeCells('A1:G1');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('A4','NO');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('B4','NAP');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('C4','KM AWAL');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('D4','KM AKHIR');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('E4','TOTAL KM');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('F4','TOTAL FUEL');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('G4','FUEL PER KM');
		$row_per_km = 5;
		$no_fuel_per_km = 1;
		foreach ($data_fuel_per_km as $key) {
			$spreadsheet->setActiveSheetIndex(2)
			->setCellValue('A'.$row_per_km, $no_fuel_per_km)
			->setCellValue('B'.$row_per_km, $key->nap)
			/*->setCellValue(''$row_per_km, $key->code_unit)
			->setCellValue(''$row_per_km, $key->nomor_plat)*/
			->setCellValue('C'.$row_per_km, $key->awal)
			->setCellValue('D'.$row_per_km, $key->akhir)
			->setCellValue('E'.$row_per_km, $key->total_km)
			->setCellValue('F'.$row_per_km, $key->total_fuel)
			->setCellValue('G'.$row_per_km, $key->fuel_per_km);
		$spreadsheet->setActiveSheetIndex(2)->getStyle('A4:G'.$row_per_km.'')->applyFromArray($styleArray);
			$row_per_km++;
			$no_fuel_per_km++;
		}
		/*$spreadsheet->setActiveSheetIndex(2)->setCellValue('A1','Test Aja Cuy');*/


		/*end of export excel data*/
		$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan Fuel Sarana-'.$nama_file.' .xlsx"');
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

	public function test_jasper($create_by)
	{
		$start_date 	= "'".date_input($this->input->post('filter_start'))."'"; 
		$end_date	 	= "'".date_input($this->input->post('filter_end'))."'";

	$host = "192.168.11.7"; //live production
	//$host = "localhost"; //development
	$user = "gandhi";
	$password = "gandhi13";
	$db_or_dsn_name = "hris";
	$nap = "2018";
	//$start_date = "'2018-08-01'";
	//$end_date = "'2018-08-31'";
	ini_set('display_errors', 0);
    $this->load->library('PHPJasperXML');
    $this->load->library('tcpdf/TCPDF');
    $path = site_url('report/test_empat.jrxml');
   // echo $path;
    $xml = simplexml_load_file($path);
    //var_dump($xml);
    $PHPJasperXML = new PHPJasperXML();
    //$PHPJasperXML->debugsql=true;
    $PHPJasperXML->arrayParameter=array("start_date"=> $start_date, "end_date"=> $end_date, "username"=> $create_by);
    $PHPJasperXML->xml_dismantle($xml);
    //$PHPJasperXML->load_xml_file($xml);
    $PHPJasperXML->transferDBtoArray($host,$user,$password,$db_or_dsn_name);
    ob_start();
    $PHPJasperXML->outpage("I");  
    ob_end_flush();
    /*ob_start();
	ob_end_clean();
    ob_end_flush();*/	
    //page output method I:standard output  D:Download file

	}

	/*begin export button*/
	public function export_fuel_sarana(){
		$pdf = $this->input->post('pdf');
		$xls = $this->input->post('xls');
		$create_by = $this->input->post('f_create_by');
		if (isset($xls)) {
			//echo "ini exccel";
			$this->rpt_fuel_liter_per_km();
		}
	else{
		$this->test_jasper($create_by);
	}
	}

}
/*end of vehicle contorller*/