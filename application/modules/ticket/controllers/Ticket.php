<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form_helper');
		$this->load->helper('tanggal_input_helper');	
		$this->load->model('payroll_model','emp_attribute');
	/*	$this->load->model('rpt_gang_model','rpt_gang');
		$this->load->model('adhoc_model','emp_adhoc');
		$this->load->model('rpt_adhoc','rpt_adhoc');
		$this->load->model('rpt_slip_gaji_model','rpt_slip_gaji');
		$this->load->model('rpt_slip_lembur_model','rpt_slip_lembur');
		$this->load->model('ump_model','ump_model');*/

/*		$this->load->model('dept_model','mas_dept');
		$this->load->model('gstatus_model','gs');
		$this->load->model('tax_model','tax');
		$this->load->model('termination_model','termin');*/
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['title'] = 'IT Help Desk';
		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('f_gang_activity');
		$this->load->view('ajax_gang_activity',$data);
		}

	}

	public function general_act()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'IT Help Desk';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->emp_attribute->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->emp_attribute->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        // dropdown untuk attd code
		$data['dd_attd_code'] = $this->emp_attribute->dd_attd_code();
        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';

        

		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('f_gang_activity');
		$this->load->view('ajax_gang_activity',$data);

		}


	}
	

	public function usr_session()
	{
		$obj_user = $this->ion_auth->user()->row();
		$usr_session = $obj_user->username;
		return $usr_session;
	}


	public function ajax_list()
	{
		/*if ($this->input->post('filter_start_date')) {
			# code...
		$this->date_input($this->input->post('filter_start_date'));
		}*/
		$list = $this->emp_attribute->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->id;
			$row[] = $emp_attribute->request_by;
			$row[] = $this->date_indonesia($emp_attribute->request_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			if ($emp_attribute->status == "submitted") {
			$row[] = " <span class='pull-right badge bg-green'>".$emp_attribute->status. "</span>";
			}
		else if ($emp_attribute->status == "closed") {
			$row[] = " <span class='pull-right badge bg-red'>".$emp_attribute->status. "</span>";
			}
			$row[] = $emp_attribute->problem;
			$row[] = $this->date_indonesia($emp_attribute->solve_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->remarks;
			if ($emp_attribute->status == "submitted") {
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
		else if ($emp_attribute->status == "closed") {
			$row[] = " <span class='pull-right badge bg-red'>".$emp_attribute->status. "</span>";
			}
			
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->emp_attribute->count_all(),
						"recordsFiltered" => $this->emp_attribute->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	public function ajax_edit($id)
	{
		$data = $this->emp_attribute->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->request_date = $this->date_indonesia($data->request_date);
		echo json_encode($data);
	}

	public function emp_add()
	{
		// fungsi validasi ini adalaah untuk memvaldasi data yang tidak terisi, agar tersi
		//$this->_validate();
		/* jika data sudah terisi maka akan di cek ke database apakah nik dengan tanggal yang di input sudah ada di database maka akan menampilkan pesan error, nik dant tanggal tidak ada di database makan akan di jalakan query add gang activity */
			//$empcode = $this->input->post('f_empcode');
			//$date = $this->date_input($this->input->post('f_date_attd'));
			//$cek = $this->cek_gang($empcode,$date);

		$data = array(
				'request_by' => $this->input->post('f_request_by'),
				'request_date' => $this->date_input($this->input->post('f_request_date')),
				'problem' => $this->input->post('f_problem'),
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
				'status' => $this->input->post('f_status'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
			);
		$insert = $this->emp_attribute->save($data);
		echo json_encode(array("status" => TRUE));
	}


	// function upload data xls to mysql using ajax and validation
	public function import_adhoc()
	{
		if (!empty($_FILES['file_import']['name'])) {
			# code...
		$upload = $this->_do_upload_adhoc();
		//$data['file_import_excel_to_db'] = $upload;
		}
		if(empty($_FILES['file_import']['name'])) //upload and validate
        {
            $data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'No File Selected'; //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}		
		//$insert = $this->emp_attribute->save($data);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload_adhoc()
	{
		$config['upload_path']          = 'upload/excel/adhoc';
        $config['allowed_types']        = 'xls';
       /* $config['max_size']             = 100; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed*/
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('file_import')) //upload and validate
        {
            $data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
	else
	{
		$this->upload->do_upload('file_import');
		$data = $this->upload->data();

		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->helper('time_stamp_helper'); // load helper for input date and update date
		$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
		//$file = $config['file_name'];
		$this->spreadsheet_excel_reader->read($data['full_path']);
		$sheets = $this->spreadsheet_excel_reader->sheets[0]; 
		error_reporting(0);
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;

		$data_excel = array();
		for ($i = 2; $i <= $sheets['numRows']; $i++) {
			if ($sheets['cells'][$i][1] == '') break;
			$data_excel[$i -1]['empcode'] = $sheets['cells'][$i][1];
			$data_excel[$i -1]['adhoc_date'] = $this->date_import_excel($sheets['cells'][$i][2]);
			$data_excel[$i -1]['amount'] = $sheets['cells'][$i][3];
			$data_excel[$i -1]['allowded_code'] = $sheets['cells'][$i][4];
			$data_excel[$i -1]['remarks'] = $sheets['cells'][$i][5];
			$data_excel[$i -1]['inputby'] = $data['username'];
			$data_excel[$i -1]['inputdate'] = time_stamp();
		}
		return $this->db->insert_batch('empallded',$data_excel);
		/*di bawah ini adalah akan menampilkan data dari array data excel*/
		/*echo('<pre>');
		print_r($data_excel);
		echo('</pre>');*/
	}
	}

	// function upload data xls to mysql using ajax and validation
	public function import_gang_activity()
	{
		if (!empty($_FILES['file_import']['name'])) {
			# code...
		$upload = $this->_do_upload();
		//$data['file_import_excel_to_db'] = $upload;
		}
		if(empty($_FILES['file_import']['name'])) //upload and validate
        {
            $data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'No File Selected'; //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}		
		//$insert = $this->emp_attribute->save($data);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']          = 'upload/excel/';
        $config['allowed_types']        = 'xlsx|xls|csv';
       /* $config['max_size']             = 100; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed*/
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('file_import')) //upload and validate
        {
            $data['inputerror'][] = 'file_import';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
	else
	{
		$this->upload->do_upload('file_import');
		$data = $this->upload->data();

		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->helper('time_stamp_helper'); // load helper for input date and update date
		$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
		//$file = $config['file_name'];
		$this->spreadsheet_excel_reader->read($data['full_path']);
		$sheets = $this->spreadsheet_excel_reader->sheets[0]; 
		error_reporting(0);
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;

		$data_excel = array();
		for ($i = 2; $i <= $sheets['numRows']; $i++) {
			if ($sheets['cells'][$i][1] == '') break;
			$data_excel[$i -1]['empcode'] = $sheets['cells'][$i][1];
			$data_excel[$i -1]['inputby'] = $data['username'];
			$data_excel[$i -1]['inputdate'] = time_stamp();
			$data_excel[$i -1]['attd_date'] = $this->date_import_excel($sheets['cells'][$i][6]);
			$data_excel[$i -1]['attd_code'] = $sheets['cells'][$i][7];
			$data_excel[$i -1]['remarks'] = $sheets['cells'][$i][8];
			$data_excel[$i -1]['overtime'] = $sheets['cells'][$i][9];
		}
		return $this->db->insert_batch('gang_activity',$data_excel);
		/*di bawah ini adalah akan menampilkan data dari array data excel*/
		/*echo('<pre>');
		print_r($data_excel);
		echo('</pre>');*/
	}

		
//$this->db->insert_batch('import',$data_excel);
		//return $this->upload->data('file_name');
	}



	public function emp_update()
	{
		//$this->_validate();
		

		$data = array(
				'request_by' => $this->input->post('f_request_by'),
				'request_date' => $this->date_input($this->input->post('f_request_date')),
				'problem' => $this->input->post('f_problem'),
				'id' => $this->input->post('f_id'),
				/*'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),*/
				'status' => $this->input->post('f_status'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
			);

		$this->emp_attribute->update(array('id' => $this->input->post('f_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function emp_delete($id)
	{
		//delete file
		//$emp_attribute = $this->emp_attribute->get_by_id($id);
		$obj_user = $this->ion_auth->user()->row();
		$username = $obj_user->username;
		$data = array (
			'is_deleted' => "1",
			'updateby' => $username,
			'updatedate' => date("Y-m-d h:i:s"),
		);		
		$this->emp_attribute->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	

	public function cek_gang($id, $date)
	{
		$a = $this->emp_attribute->cek_data($id, $date);
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


	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		/*if($this->date_input($this->input->post('f_date_attd')) || $this->input->post('f_empcode'))
		{
			$empcode = $this->input->post('f_empcode');
			$date = $this->date_input($this->input->post('f_date_attd'));
			$cek = $this->cek_gang($empcode,$date);
			if ($cek = 1) {
			$data['inputerror'][] = 'f_date_attd';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data sudah ada';
			$data['status'] = FALSE;
			}
			//$this->cek_gang($this->input->post('f_empcode'), $this->date_input($this->input->post('f_date_attd')))
			else
				{
			$data['status'] = TRUE;

				}
		}*/
		
		if($this->input->post('f_date_attd') == '')
		{
			$data['inputerror'][] = 'f_date_attd';
			$data['error_string'][] = 'Date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_remarks') == '')
		{
			$data['inputerror'][] = 'f_remarks';
			$data['error_string'][] = 'Remarks is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function bln()
	{
		$tanggal= mktime(date("m"),date("d"),date("Y"));
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("d-m-Y", $tanggal);
        $mou = substr($tgl,3,2);
     	return $mou;
	}

	function date_input($tanggal)
	{
		//$this->load->helper('date');
		if (!empty($tanggal)) {
			# code...
			$tgl = $tanggal;
		//$tgl = $tanggal;
		$newDate = date("Y-m-d", strtotime($tgl));
		return $newDate;
		}		
		// Should Produce: 2001-09-11
		//$tanggal =  $better_date = nice_date($newDate, 'Y/m/d');
		//$tanggal;
	}

	function date_indonesia($tanggal)
	{
		$this->load->helper('date');
		if ($tanggal) {
			$tgl = $tanggal;
		$newDate = date("d-M-Y", strtotime($tgl));
		// Should Produce: 2001-09-11
		$better_date = nice_date($newDate, 'd-m-Y');
		}
		else {
		
			$better_date = "";	
		}
		return $better_date;
	}

	/*fungsi untuk memformat hasil import dari excel 01/03/2018 yang berupa integer 43160 ketika di database
	maka di buat nya fungsi ini untuk merubah format tersebut dan di gunakan ketika akan di import ke mysql*/
	function date_import_excel($tanggal)
	{
		$unix_date = ($tanggal - 25569) * 86400;
		return gmdate("Y-m-d", $unix_date);
		//return $newDate;
	}

	function emp_rn()
	{
		$tanggal= mktime(date("m"),date("d"),date("Y"));
		$tgl = date("d-m-Y", $tanggal);
        $year = substr($tgl,8,2);
		$emp = $this->emp_attribute->last_id();
		$empcode = substr($emp->empcode,2,6);
		//echo $empcode;
		if ($empcode > "0") {
			$empcode++;
			if ($empcode < 10) {
				
				$running_number = $year."0000".$empcode;
				//echo $running_number;
			}
			elseif ($empcode < 100) {
				//$emp_code = substr($empcode, 5,2);
				$running_number = $year."000".substr($empcode, 0,2);
				
			}
			elseif ($empcode < 1000) {
				$running_number = $year."00".$empcode;
				//echo $running_number;
			}
			elseif ($empcode < 10000) {
				$running_number = $year."0".$empcode;
				//echo $running_number; 1812345
			}
		}
		else {
				$running_number = $year."00001";
				//echo $running_number;
				// jika tidak ada data maka running number akan mulai dari 00001
		}
		return $running_number;
	}

	// adhoc begin here

	//adhoc
	function adhoc()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_adhoc->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Allowance & Deduction';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->emp_adhoc->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->emp_adhoc->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        // dropdown untuk attd code
		$data['dd_adhoc'] = $this->emp_adhoc->dd_adhoc();
        $data['dd_adhoc_selected'] = $this->input->post('f_adhoc_code') ? $this->input->post('f_adhoc_code') : '';
		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('f_adhoc');
		$this->load->view('ajax_adhoc',$data);

		}
	}
	// ajax list
	public function adhoc_list()
	{
		$list = $this->emp_adhoc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->empcode;
			$row[] = $emp_attribute->empname;
			$row[] = $this->date_indonesia($emp_attribute->adhoc_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->allowded_code;
			//$row[] = '<span id="span_allowded_code" class= "label label-warning" >'.$emp_attribute->allowded_code.'</span>';
			$row[] = $emp_attribute->description;
			$row[] = $emp_attribute->amount;
			$row[] = $emp_attribute->remarks;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_adhoc."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id_adhoc."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->emp_adhoc->count_all(),
						"recordsFiltered" => $this->emp_adhoc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	// add emp allded
	public function adhoc_add()
	{
		//$this->_validate();
		
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'inputby' => $this->input->post('f_input_by'),
				'inputdate' => $this->input->post('f_input_date'),
				'adhoc_date' => $this->date_input($this->input->post('f_adhoc_date')),
				'allowded_code' => $this->input->post('f_adhoc_code'),
				'remarks' => $this->input->post('f_remarks'),
				'amount' => $this->input->post('f_amount'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				//'attd_code' => $this->input->post('f_attd_code'),
			);
		$insert = $this->emp_adhoc->save($data);

		echo json_encode(array("status" => TRUE));
	}

	// adhoc edit
	public function adhoc_edit($id)
	{
		$data = $this->emp_adhoc->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->adhoc_date = $this->date_indonesia($data->adhoc_date);
		echo json_encode($data);
	}

	// adhoc update 
	public function adhoc_update()
	{
		//$this->_validate();
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'id_adhoc' => $this->input->post('f_id_adhoc'),
				//'inputdate' => $this->input->post('f_input_date'),
				//'inputby' => $this->input->post('f_input_by'),
				'amount' => $this->input->post('f_amount'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'adhoc_date' => $this->date_input($this->input->post('f_adhoc_date')),
				'allowded_code' => $this->input->post('f_adhoc_code'),
				'remarks' => $this->input->post('f_remarks'),
			);

		$this->emp_adhoc->update(array('id_adhoc' => $this->input->post('f_id_adhoc')), $data);
		echo json_encode(array("status" => TRUE));
	}

	// adhoc delete
	public function adhoc_delete($id)
	{
		//delete file
		$emp_attribute = $this->emp_attribute->get_by_id($id);
		/*==== if wanna delete file / photos
		if(file_exists('upload/'.$emp_attribute->photo) && $emp_attribute->photo)
			unlink('upload/'.$emp_attribute->photo);*/
		
		$this->emp_adhoc->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	// controller report gang activtiy
	function rpt_gang_activity()
	{
		$this->load->helper('url');
		$this->load->helper('form_helper');

	if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
	else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->rpt_gang->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Report Gang Activity';
		//dd empcode
		$data['dd_empcode'] = $this->rpt_gang->dd_rpt_empcode();
        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
        //dd grade status
        $data['dd_emp_dept'] = $this->rpt_gang->dd_rpt_dept();
        $data['dd_emp_dept_select'] = $this->input->post('departement') ? $this->input->post('departement') : '';
        //
        $data['dd_emp_pos'] = $this->rpt_gang->dd_rpt_emp_position();
        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
        //dd empoyee status
		$data['dd_emp_status'] = $this->rpt_gang->dd_rpt_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('rpt_gang_activity');
		$this->load->view('ajax_rpt_gang_activity',$data);

		}
	}

	// ajax report gang activity
	public function ajax_rpt_gang_activity()
	{
		/*if ($this->input->post('filter_start_date')) {
			# code...
		$this->date_input($this->input->post('filter_start_date'));
		}*/
		$this->date_input($this->input->post('filter_year'));
		$list = $this->rpt_gang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->empcode;
			$row[] = $emp_attribute->empname;
			$row[] = $this->date_indonesia($emp_attribute->attd_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->overtime;
			$row[] = $emp_attribute->lembur;
			//$row[] = $emp_attribute->total;
			/*$row[] = '<a class="btn btn-sm btn-danger"" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';*/
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rpt_gang->count_all(),
						"recordsFiltered" => $this->rpt_gang->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	// report adhoc
	function report_adhoc()
	{
		$this->load->helper('url');
		$this->load->helper('form_helper');

	if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
	else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Report Allowance - Deduction';
		//dd empcode
		$data['dd_empcode'] = $this->emp_attribute->dd_rpt_empcode();
        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
        //dd grade status
        $data['dd_emp_dept'] = $this->emp_attribute->dd_rpt_dept();
        $data['dd_emp_dept_select'] = $this->input->post('departement') ? $this->input->post('departement') : '';
        //
        $data['dd_emp_pos'] = $this->emp_attribute->dd_rpt_emp_position();
        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
        //dd empoyee status
		$data['dd_emp_status'] = $this->emp_attribute->dd_rpt_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('rpt_adhoc');
		$this->load->view('ajax_rpt_adhoc',$data);

		}
	}

	// ajax list rpt adhoc
	// ajax report gang activity
	public function ajax_rpt_adhoc()
	{
		$list = $this->rpt_adhoc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->empcode;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->dept_desc;
			$row[] = $emp_attribute->position_desc;
			$row[] = $this->date_indonesia($emp_attribute->adhoc_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->amount;
			$row[] = $emp_attribute->allowded_code;
			$row[] = $emp_attribute->description;
			$row[] = $emp_attribute->remarks;
			/*$row[] = '<a class="btn btn-sm btn-danger"" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';*/
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rpt_adhoc->count_all(),
						"recordsFiltered" => $this->rpt_adhoc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	// report slip gaji
	function rpt_sallary()
	{
		$this->load->helper('url');
		$this->load->helper('form_helper');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$email = $obj_user->username;
			$data['username'] = $email;
			$data['dept'] = $this->emp_attribute->dept();
			$data['empcode'] = $this->emp_rn();
			$data['title'] = 'Report Sallary';
			//dd empcode
			$data['dd_empcode'] = $this->emp_attribute->dd_rpt_empcode();
	        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
	        //dd grade status
	        $data['dd_emp_dept'] = $this->emp_attribute->dd_rpt_dept();
	        $data['dd_emp_dept_select'] = $this->input->post('departement') ? $this->input->post('departement') : '';
	        //
	        $data['dd_emp_pos'] = $this->emp_attribute->dd_rpt_emp_position();
	        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
	        //dd empoyee status
			$data['dd_emp_status'] = $this->emp_attribute->dd_rpt_emp_status();
	        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

			$this->load->view('title',$data);
			$this->load->view('header');
			$this->load->view('sidebar');
			$this->load->view('rpt_Sallary');
			$this->load->view('ajax_rpt_gaji',$data);
		}
	}

	// report slip gaji pdf
	public function slip_gaji(){
	$this->load->helper('detail_lembur_helper');
    $this->load->library('pdf');
    $empcode = $this->input->post('filter_empcode');
    $dept_id = $this->input->post('filter_dept');
    $position_id = $this->input->post('filter_position');
    $month = $this->input->post('filter_month');
    $year = $this->input->post('filter_year');
    $print_date = $this->input->post('print_date');
    //$this->_validatee();
    $data = array(
        "emp_attrb" => $this->rpt_slip_gaji->slip_gaji($empcode, $dept_id, $position_id, $year, $month),
        "bulan" => $month,
        "print_date" => $print_date,
        "tahun" => $year
    );

	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','potrait');
    $timestamp = date("Y-m-d");
    $this->pdf->filename = "Slip Gaji.pdf".$timestamp.".pdf";
    $this->pdf->load_view('rpt_slip_gaji', $data);
	}

	private function _validatee()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('filter_month') == '')
		{
			$data['inputerror'][] = 'f_date_attd';
			$data['error_string'][] = 'Date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('filter_year') == '')
		{
			$data['inputerror'][] = 'f_remarks';
			$data['error_string'][] = 'Remarks is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	// ajax report sallary
	public function ajax_rpt_sallary()
	{
		$id = '1800006';
		$data = $this->rpt_gang->get_by_i();
		echo json_encode($data);
	}

	public function latihan_ajax()
	{
    $this->load->library('pdf');

		//$this->load->view('latihan_ajax');
		$this->pdf->setPaper('A4','potrait');
    $this->pdf->filename = "laporan-petanikode.pdf";
    $this->pdf->load_view('latihan_ajax');
	}

	// report slip Lembur
	function rpt_slip_lembur()
	{
		$this->load->helper('url');
		$this->load->helper('form_helper');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login','refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$obj_user = $this->ion_auth->user()->row();
			$email = $obj_user->username;
			$data['username'] = $email;
			$data['dept'] = $this->emp_attribute->dept();
			$data['empcode'] = $this->emp_rn();
			$data['title'] = 'Report Overtime';
			//dd empcode
			$data['dd_empcode'] = $this->emp_attribute->dd_rpt_empcode();
	        $data['empcode_selected'] = $this->input->post('empcode') ? $this->input->post('empcode') : '';
	        //dd grade status
	        $data['dd_emp_dept'] = $this->emp_attribute->dd_rpt_dept();
	        $data['dd_emp_dept_select'] = $this->input->post('departement') ? $this->input->post('departement') : '';
	        //
	        $data['dd_emp_pos'] = $this->emp_attribute->dd_rpt_emp_position();
	        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
	        //dd empoyee status
			$data['dd_emp_status'] = $this->emp_attribute->dd_rpt_emp_status();
	        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

			$this->load->view('title',$data);
			$this->load->view('header');
			$this->load->view('sidebar');
			$this->load->view('rpt_overtime');
			$this->load->view('ajax_slip_overtime',$data);
		}
	}

	// report slip Lembur Pdf
	public function slip_overtime(){
	$this->load->helper('detail_lembur_helper');
    $this->load->library('pdf');
    $empcode = $this->input->post('filter_empcode');
    $dept_id = $this->input->post('filter_dept');
    $position_id = $this->input->post('filter_position');
    $month = $this->input->post('filter_month');
    $year = $this->input->post('filter_year');
    $data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        ),
        "emp_attrb" => $this->rpt_slip_lembur->slip_gaji($empcode, $dept_id, $position_id, $year, $month),
        //"emp_slip" => $this->rpt_slip_lembur->slip_lembur()
    );

	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','potrait');
    $timestamp = date("Y-m-d");
    $this->pdf->filename = "Slip Lembur.pdf".$timestamp.".pdf";
    $this->pdf->load_view('rpt_overtime_pdf', $data);
	}


	/*master ump sebagai parameter unutk perhitungan saat di slip gaji*/

	public function ump()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'General Activity';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->emp_attribute->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->emp_attribute->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        // dropdown untuk attd code
		$data['dd_attd_code'] = $this->emp_attribute->dd_attd_code();
        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';
		$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('f_uang_kehadiran');
		$this->load->view('ajax_uang_kehadiran',$data);

		}
	}

	public function add_ump()
	{
				// fungsi validasi ini adalaah untuk memvaldasi data yang tidak terisi, agar tersi
		//$this->_validate();
		/* jika data sudah terisi maka akan di cek ke database apakah nik dengan tanggal yang di input sudah ada di database maka akan menampilkan pesan error, nik dant tanggal tidak ada di database makan akan di jalakan query add gang activity */
			/*$empcode = $this->input->post('f_empcode');
			$date = $this->date_input($this->input->post('f_date_attd'));
			$cek = $this->cek_gang($empcode,$date);
			if ($cek == 1) {
			$data['inputerror'][] = 'f_date_attd';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
			}*/
		$data = array(
				'rate' => $this->input->post('f_rate'),
				'effective_date' => $this->date_input($this->input->post('f_date')),
				'remarks' => $this->input->post('f_remarks'),
			);
		$insert = $this->ump_model->save($data);

		echo json_encode(array("status" => TRUE));

	}

	public function ump_edit($id)
	{
		$data = $this->ump_model->get_by_id($id);
		$data->effective_date = $this->date_indonesia($data->effective_date);
		echo json_encode($data);
	}

	public function ump_update()
	{
		$data = array(
				'id' => $this->input->post('f_id'),
				'remarks' => $this->input->post('f_remarks'),
				//'inputdate' => $this->input->post('f_input_date'),
				//'inputby' => $this->input->post('f_input_by'),
				'rate' => $this->input->post('f_rate'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'effective_date' => $this->date_input($this->input->post('f_date')),
			);

		$this->ump_model->update(array('id' => $this->input->post('f_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ump_list()
	{
		$list = $this->ump_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->id;
			$row[] = $emp_attribute->rate;
			$row[] = $this->date_indonesia($emp_attribute->effective_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->remarks;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->emp_adhoc->count_all(),
						"recordsFiltered" => $this->emp_adhoc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}





}
