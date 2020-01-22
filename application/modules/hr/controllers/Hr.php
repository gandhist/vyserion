<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpspreadsheet/vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Helper\Sample;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Hr extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('lib_log');
		$this->load->helper('form_helper');
		$this->load->helper('tanggal_input_helper');	
		$this->load->helper('detail_lembur_helper');
		/*$this->load->helper('auth_helper');*/
		$this->load->helper('time_stamp_helper');
		$this->load->model('emp_model','emp_attribute');
		$this->load->model('hr_report','m_hr_report');
		$this->load->model('dept_model','mas_dept');
		$this->load->model('gstatus_model','gs');
		$this->load->model('tax_model','tax');
		$this->load->model('termination_model','termin');
		$this->load->model('lov_model','master_lov');
		$this->load->model('doc_status_model','doc');
		$this->load->model('doc_exp_model','doc_exp');
		$this->load->model('graph_model');

		//$this->load->library('fpdf');

		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{


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

		$group = array("hr","HSE");
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		//$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'ADD EMPLOYEE';

		// dd emp code
		$data['dd_empcode'] = $this->master_lov->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode_f') ? $this->input->post('f_empcode_f') : '';

		// dd emp status kbt khl kt
		$data['dd_emp_status'] = $this->master_lov->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        //dd id position
        $data['dd_emp_pos'] = $this->master_lov->dd_emp_position();
        $data['dd_emp_pos_select'] = $this->input->post('f_position') ? $this->input->post('f_position') : '';

        //dd departement
        $data['dd_dept'] = $this->master_lov->dd_dept();
        $data['dd_dept_selected'] = $this->input->post('f_position') ? $this->input->post('f_position') : '';

		
   if ($this->ion_auth->in_group($group)) {
      	$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('content');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('footer_ajax_modal',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }
		}

	}

	// example dompdf
	public function laporan_pdf(){

    $this->load->library('pdf');
    $data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        ),
        "emp_attrb" => $this->emp_attribute->slip_gaji(),
        "emp_slip" => $this->emp_attribute->slip_lembur_no()
    );

	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','potrait');
    $this->pdf->filename = "laporan-petanikode.pdf";
    $this->pdf->load_view('laporan_pdf', $data);
	}



	
	public function mpdf()
	{
		//$this->load->library('pdf');
	$query = $this->emp_attribute->slip_gaji_id();
		//$this->load->library('pdf');
		$id='';
	foreach ($query as $key) {
		$data['id'] = $key->empcode;
		$data['empcode'] = $key->empcode;
		$data['empcoda'] = $key->empcode;
		$data['empname'] = $key->empname;
		$data['query_lembur'] = $this->emp_attribute->slip_lembur($data['id']);
	//$this->pdf->load_view('mypdf',$data);
	
	$html = $this->load->view('mypdf',$data);
	
	}

	}	

	// testing
	public function lap()
	{
		//$this->load->library('pdf');
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Report Gang Activity';
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
	
	$this->load->view('v_rpt_gang_act',$data);
	
	}

	//test
	public function panggil()
	{
		echo "ini adalah controller";
	}

	public function cetak()
	{
		$no = 3;
		for ($i=0; $i < $no ; $i++) { 
			echo $no;
		}
	}


	function hr_report()
	{
		$this->load->helper('url');
		$this->load->helper('form_helper');
		$group = array('hr','prod','HSE');
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
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Report Parameter Data Karyawan';
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

 	if ($this->ion_auth->in_group($group)) {
     	$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_hr_report');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_rpt_hr',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }
		

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
		$this->date_input($this->input->post('filter_end_date'));
		}*/
		$list = $this->emp_attribute->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->nik_pim;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->position_id;
			$row[] = $emp_attribute->position_desc;
			$row[] = $this->date_indonesia($emp_attribute->companybegin); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			//$row[] = $this->date_indonesia($emp_attribute->companybegin); // change data format from database YYYY-MM-DD to DD-MM-YYYY

			/* if wanna add some picture 
			if($emp_attribute->photo)
				$row[] = '<a href="'.base_url('upload/'.$emp_attribute->photo).'" target="_blank"><img src="'.base_url('upload/'.$emp_attribute->photo).'" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';*/

			//add html for action
			/*$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_emp_attribute('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
				  <a class="btn btn-sm btn-success" href="c_laporan/cetak/'.$emp_attribute->empcode.'" target="_blank" title="print" )><i class="glyphicon glyphicon-print"></i> Print</a>';*/
				  $row[] = '
				  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
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

	public function ajax_rpt_list()
	{
		/*if ($this->input->post('filter_start_date')) {
			# code...
		$this->date_input($this->input->post('filter_start_date'));
		$this->date_input($this->input->post('filter_end_date'));
		}*/
		$list = $this->m_hr_report->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $emp_attribute->empcode;
			$row[] = $emp_attribute->nik_pim;
			$row[] = $emp_attribute->badgenumber;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->sex;
			$row[] = $emp_attribute->address;
			$row[] = $emp_attribute->homephoneno;
			$row[] = $emp_attribute->mobilephoneno;
			$row[] = $emp_attribute->email;
			$row[] = $emp_attribute->religion;
			$row[] = $emp_attribute->dept_desc;
			$row[] = $emp_attribute->status_karyawan;
			$row[] = $emp_attribute->npwp;
			$row[] = $emp_attribute->nojamsostek;
			$row[] = $emp_attribute->lifeinsuranceno;
			$row[] = $emp_attribute->no_identitas;
			$row[] = $emp_attribute->hire_date;
			$row[] = $emp_attribute->position_desc;
			$row[] = $emp_attribute->bankname;
			$row[] = $emp_attribute->bankaccountno;
			$row[] = $emp_attribute->sim_type;
			$row[] = $emp_attribute->sim_number;
			$row[] = $emp_attribute->sim_valid;
			//$row[] = $this->date_indonesia($emp_attribute->companybegin); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			//$row[] = $this->date_indonesia($emp_attribute->companybegin); // change data format from database YYYY-MM-DD to DD-MM-YYYY

			/* if wanna add some picture 
			if($emp_attribute->photo)
				$row[] = '<a href="'.base_url('upload/'.$emp_attribute->photo).'" target="_blank"><img src="'.base_url('upload/'.$emp_attribute->photo).'" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';*/

			//add html for action
			/*$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_emp_attribute('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
				  <a class="btn btn-sm btn-success" href="c_laporan/cetak/'.$emp_attribute->empcode.'" target="_blank" title="print" )><i class="glyphicon glyphicon-print"></i> Print</a>';*/
				  /*$row[] = '
				  <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->empcode."'".')"><i class="glyphicon glyphicon-trash"></i></a>';*/
		
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
		$data->dob = $this->date_indonesia($data->dob);
		$data->datemarried = $this->date_indonesia($data->datemarried);
		$data->dateterminate = $this->date_indonesia($data->dateterminate);
		$data->companybegin = $this->date_indonesia($data->companybegin);
		$data->hire_date = $this->date_indonesia($data->hire_date);
		$data->sim_valid = $this->date_indonesia($data->sim_valid);
		echo json_encode($data);

	}

	public function emp_add()
	{
		$this->_validate();
		
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'inputdate' => $this->input->post('f_input_date'),
				'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				'empname' => $this->input->post('f_empname'),
				'dob' => $this->date_input($this->input->post('f_date_of_birth')),
				'birth_place' => $this->input->post('f_pob'),
				'nik_pim' => $this->input->post('f_other_empname'),
				'nationality' => $this->input->post('f_citizen'),
				'sex' => $this->input->post('f_sex'),
				'maritalstatus' => $this->input->post('f_marrital_status'),
				'datemarried' => $this->date_input($this->input->post('f_date_of_married')),
				'religion' => $this->input->post('f_religion'),
				'blood_type' => $this->input->post('f_blood_type'),
				'numberofchild' => $this->input->post('f_number_child'),
				'departement' => $this->input->post('f_departement'),
				'position' => $this->input->post('f_position'),
				'nojamsostek' => $this->input->post('f_jamsostek_no'),
				'lifeinsuranceno' => $this->input->post('f_life_insurance_no'),
				'bankaccountno' => $this->input->post('f_bank_account'),
				'bankname' => $this->input->post('f_bank_name'),
				'bankaccountname' => $this->input->post('f_bank_account_name'),
				'employeetype' => $this->input->post('f_emp_status'),
				'npwp' => $this->input->post('f_npwp'),
				'no_identitas' => $this->input->post('f_id_card'),
				'labour_union' => $this->input->post('f_labour_union'),
				'address' => $this->input->post('f_address'),
				'province' => $this->input->post('f_province'),
				'city' => $this->input->post('f_city'),
				'zipcode' => $this->input->post('f_zipcode'),
				'homephoneno' => $this->input->post('f_phoneno'),
				'mobilephoneno' => $this->input->post('f_mobilephoneno'),
				'emailaddr' => $this->input->post('f_email'),
				'companybegin' => $this->date_input($this->input->post('f_company_begin')),
				'badgenumber' => $this->input->post('f_badgenumber'),
				'hire_date' => $this->date_input($this->input->post('f_hire_date')), #$this->date_input fungsi konversi tanggal
				'sim_type' => $this->input->post('f_sim'),
				'sim_number' => $this->input->post('f_sim_no'),
				'sim_valid' => date_input($this->input->post('f_valid_sim')),
			);

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload($this->input->post('f_empname'));
			$data['photo'] = $upload;
		}
		$insert = $this->emp_attribute->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function emp_update()
	{
		$this->_validate();
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'updateby' => $this->input->post('f_update_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'empname' => $this->input->post('f_empname'),
				'dob' => $this->date_input($this->input->post('f_date_of_birth')),
				'birth_place' => $this->input->post('f_pob'),
				'nik_pim' => $this->input->post('f_other_empname'),
				'nationality' => $this->input->post('f_citizen'),
				'sex' => $this->input->post('f_sex'),
				'maritalstatus' => $this->input->post('f_marrital_status'),
				'datemarried' => $this->date_input($this->input->post('f_date_of_married')),
				'religion' => $this->input->post('f_religion'),
				'blood_type' => $this->input->post('f_blood_type'),
				'numberofchild' => $this->input->post('f_number_child'),
				'departement' => $this->input->post('f_departement'),
				//'position' => $this->input->post('f_position'),
				'nojamsostek' => $this->input->post('f_jamsostek_no'),
				'lifeinsuranceno' => $this->input->post('f_life_insurance_no'),
				'bankaccountno' => $this->input->post('f_bank_account'),
				'bankname' => $this->input->post('f_bank_name'),
				'bankaccountname' => $this->input->post('f_bank_account_name'),
				'employeetype' => $this->input->post('f_emp_status_edit'),// f_emp_status dijadikan dummy untuk view disabled saja
				'npwp' => $this->input->post('f_npwp'),
				'no_identitas' => $this->input->post('f_id_card'),
				'labour_union' => $this->input->post('f_labour_union'),
				'address' => $this->input->post('f_address'),
				'province' => $this->input->post('f_province'),
				'city' => $this->input->post('f_city'),
				'zipcode' => $this->input->post('f_zipcode'),
				'homephoneno' => $this->input->post('f_phoneno'),
				'mobilephoneno' => $this->input->post('f_mobilephoneno'),
				'badgenumber' => $this->input->post('f_badgenumber'),
				'emailaddr' => $this->input->post('f_email'),
				'companybegin' => $this->date_input($this->input->post('f_company_begin')),
				'hire_date' => $this->date_input($this->input->post('f_hire_date')), #$this->date_input fungsi konversi tanggal
				'sim_type' => $this->input->post('f_sim'),
				'sim_number' => $this->input->post('f_sim_no'),
				'sim_valid' => date_input($this->input->post('f_valid_sim')),
			);

			if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('upload/employee_photos'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/employee_photos'.$this->input->post('remove_photo'));
            $data['photo'] = '';
        }

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload($this->input->post('f_empname'));
			
			//delete file
			$emp_attribute = $this->emp_attribute->get_by_id($this->input->post('f_empcode'));
			if(file_exists('upload/employee_photos'.$emp_attribute->photo) && $emp_attribute->photo)
				unlink('upload/employee_photos'.$emp_attribute->photo);

			$data['photo'] = $upload;
		}

		$this->emp_attribute->update(array('empcode' => $this->input->post('f_empcode')), $data);
		echo json_encode(array("status" => TRUE));
	}

	/* remarks at 08032018
	public function emp_delete($id)
	{
		//delete file
		$emp_attribute = $this->emp_attribute->get_by_id($id);
		==== if wanna delete file / photos
		if(file_exists('upload/'.$emp_attribute->photo) && $emp_attribute->photo)
			unlink('upload/'.$emp_attribute->photo);
		
		$this->emp_attribute->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}*/
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
		$this->emp_attribute->update(array('empcode' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload($empname)
	{
		$config['upload_path']          = 'upload/employee_photos';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
        $config['max_width']            = 2000; // set max width image allowed
        $config['max_height']           = 2000; // set max height allowed
        $config['file_name']            = $empname; //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	public function allow_to_add()
	{	
		echo create_auth();
	}
	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_empname') == '')
		{
			$data['inputerror'][] = 'f_empname';
			$data['error_string'][] = 'Employee name is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_badgenumber') == '')
		{
			$data['inputerror'][] = 'f_badgenumber';
			$data['error_string'][] = 'Badge Number is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_hire_date') == '')
		{
			$data['inputerror'][] = 'f_hire_date';
			$data['error_string'][] = 'Hire Date is required';
			$data['status'] = FALSE;
		}

		/*if($this->input->post('f_emp_status') == '')
		{
			$data['inputerror'][] = 'f_emp_status';
			$data['error_string'][] = 'Employee Status is required';
			$data['status'] = FALSE;
		}*/

		/*if($this->input->post('f_labour_union') == '')
		{
			$data['inputerror'][] = 'f_labour_union';
			$data['error_string'][] = 'Labour Union is required';
			$data['status'] = FALSE;
		}*/

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

	// master departement
	function dept()
	{
		$group = "hr";
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
		 if ($this->ion_auth->in_group($group)) {
      $data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Master Departement';
		$data['username'] = $this->usr_session();
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('master_dept');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_dept');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }
		

		}
	}

	// memanggil data di database untuk di kirim ke view
	public function dept_list()
	{
		$this->load->helper('url');

		$list = $this->mas_dept->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $mas_dept) {
			$no++;
			$row = array();
			$row[] = $mas_dept->departement;
			$row[] = $mas_dept->dept_desc;
			$row[] = $this->date_indonesia($mas_dept->effective_date);

			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger"" href="javascript:void(0)" title="Edit" onclick="edit('."'".$mas_dept->departement."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mas_dept->count_all(),
						"recordsFiltered" => $this->mas_dept->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	// meanmpilkan last id dari table master departement 
	public function last_dept_id()
	{
		$last_id =  $this->mas_dept->last_id();
		return $last_id->departement +1;
	}

	// function untuk menambah master departement
	public function dept_add()
	{
		
		$this->_validate_dept();
		$data = array(
				'departement' => $this->input->post('f_dept_id'),
				'dept_desc' => $this->input->post('f_dept_desc'),
				'effective_date' => $this->date_input($this->input->post('f_effective_date')),				
			);
		$insert = $this->mas_dept->save($data);

		echo json_encode(array("status" => TRUE));
	}


	//function untuk menampilkan value edit dari database
	public function dept_edit($id)
	{
		$data = $this->mas_dept->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->effective_date = $this->date_indonesia($data->effective_date);
		echo json_encode($data);
	}

	// function untuk update data master departement
	public function dept_update()
	{
		
		$data = array(
				'departement' => $this->input->post('f_dept_id'),
				'dept_desc' => $this->input->post('f_dept_desc'),
				'effective_date' => $this->date_input($this->input->post('f_effective_date')), #$this->date_input fungsi konversi tanggal
			);
		$this->mas_dept->update(array('departement' => $this->input->post('f_dept_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	

	private function _validate_dept()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('f_dept_desc') == '')
		{
			$data['inputerror'][] = 'f_dept_desc';
			$data['error_string'][] = 'Dept Description is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_effective_date') == '')
		{
			$data['inputerror'][] = 'f_effective_date';
			$data['error_string'][] = 'Effective Date is required';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	// grade status
	function grade_status()
	{
		$group = "hr";
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

		 $data = array(
            'button' => 'Create',
            'dept_id' => $this->last_dept_id(),
            'title' => 'Grade Satus',
            'username' => $this->usr_session(),
            'action' => site_url('provinsi/create_action'),

            'dd_empcode' => $this->master_lov->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->master_lov->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->gs->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk golongan 
            'dd_golongan' => $this->master_lov->dd_golongan(),
            'golongan_selected' => $this->input->post('f_grade') ? $this->input->post('f_grade') : '',
		);
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_grade_status');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_grade_status');

        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}
	}

	// memanggil data di database untuk di kirim ke view
	public function gs_list()
	{
		$this->load->helper('url');

		$list = $this->gs->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $mas_dept) {
			$no++;
			$row = array();
			$row[] = $mas_dept->nik_pim;
			$row[] = $mas_dept->empname;
			$row[] = $this->date_indonesia($mas_dept->start_date);
			$row[] = $mas_dept->emp_type;
			$row[] = $mas_dept->position_desc;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$mas_dept->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$mas_dept->empcode."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->gs->count_all(),
						"recordsFiltered" => $this->gs->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



	function grade_status_add()
	{
		$this->_validate_grade_status();
		
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'inputdate' => $this->input->post('f_input_date'),
				'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				'start_date' => $this->date_input($this->input->post('f_start_date')),
				'id_country' => $this->input->post('f_id_country'),
				'employeetype' => $this->input->post('f_emp_status'),
				'grade' => $this->input->post('f_grade'),
				'basic_sallary' => $this->input->post('f_basic'),
				'allowance' => $this->input->post('f_allow'),
				'payment_method' => $this->input->post('f_payment_method'),
				'upah' => $this->input->post('f_upah'),
				'jamsostek' => $this->input->post('f_jamsostek'),
				'lifeinsurance' => $this->input->post('f_bpjs'),
				'overtime' => $this->input->post('f_ottj'),
				'id_region' => $this->input->post('f_id_region'),
				'kehadiran_pagi' => $this->input->post('pagi'),
				'kehadiran_malam' => $this->input->post('malam'),
				'uang_makan' => $this->input->post('f_uang_makan'),
				// next features
				/*'limit_ot' => $this->input->post('f_emp_status'),
				'category' => $this->input->post('f_npwp'),*/
				'id_position' => $this->input->post('f_emp_position'),
				'spesifikasi' => $this->input->post('f_spesifikasi'),
				'wh' => $this->input->post('f_wh'),
			);
		$insert = $this->gs->save($data);

		echo json_encode(array("status" => TRUE));

	}

	// grade status edit
	public function gs_edit($id)
	{
		$data = $this->gs->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->start_date = $this->date_indonesia($data->start_date);
		echo json_encode($data);
	}

	// function untuk update data master Grade Status
	public function gs_update()
	{
		
		$data = array(
				//'empcode' => $this->input->post('f_empcode'),
				'empcode' => $this->input->post('f_empcode_4_update'),
				/*'inputdate' => $this->date_input($this->input->post('f_input_date')),
				'inputby' => $this->input->post('f_input_by'),*/
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'start_date' => $this->date_input($this->input->post('f_start_date')),
				'id_country' => $this->input->post('f_id_country'),
				'employeetype' => $this->input->post('f_emp_status'),
				'grade' => $this->input->post('f_grade'),
				'basic_sallary' => $this->input->post('f_basic'),
				'allowance' => $this->input->post('f_allow'),
				'payment_method' => $this->input->post('f_payment_method'),
				'upah' => $this->input->post('f_upah'),
				'jamsostek' => $this->input->post('f_jamsostek'),
				'lifeinsurance' => $this->input->post('f_bpjs'),
				'overtime' => $this->input->post('f_ottj'),
				'id_region' => $this->input->post('f_id_region'),
				'kehadiran_pagi' => $this->input->post('pagi'),
				'kehadiran_malam' => $this->input->post('malam'),
				'uang_makan' => $this->input->post('f_uang_makan'),
				// next features
				/*'limit_ot' => $this->input->post('f_emp_status'),
				'category' => $this->input->post('f_npwp'),*/
				'id_position' => $this->input->post('f_emp_position'),
				'wh' => $this->input->post('f_wh'),
				'spesifikasi' => $this->input->post('f_spesifikasi'),
			);
		$this->gs->update(array('empcode' => $this->input->post('f_empcode_4_update')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function gs_delete($id)
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
		$this->gs->update(array('empcode' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	// validate for form grade status
	private function _validate_grade_status()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		if($this->input->post('f_empcode') == '')
		{
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_start_date') == '')
		{
			$data['inputerror'][] = 'f_start_date';
			$data['error_string'][] = 'Start Date is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_basic') == '')
		{
			$data['inputerror'][] = 'f_basic';
			$data['error_string'][] = 'Basic Sallary is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_emp_status') == '')
		{
			$data['inputerror'][] = 'f_emp_status';
			$data['error_string'][] = 'Employee Status is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_payment_method') == '')
		{
			$data['inputerror'][] = 'f_payment_method';
			$data['error_string'][] = 'Payment Method Status is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_id_country') == '')
		{
			$data['inputerror'][] = 'f_id_country';
			$data['error_string'][] = 'ID Country Status is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_id_region') == '')
		{
			$data['inputerror'][] = 'f_id_region';
			$data['error_string'][] = 'ID Region is required';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	// TAX status
	function tax_status()
	{
		$group = "hr";
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

		 $data = array(
            'title' => 'Tax Satus',
            'username' => $this->usr_session(),
            'dd_empcode' => $this->tax->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->gs->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->gs->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
		);
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_tax_status');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_tax_status');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}
	}

	// memanggil data di database untuk di kirim ke view
	public function tax_list()
	{
		$this->load->helper('url');

		$list = $this->tax->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			//$row[] = $a->empcode;
			$row[] = $a->nik_pim;
			/*$row[] = $a->id_tax_sk;*/
			$row[] = $a->empname;
			//$row[] = $a->empname;
			$row[] = $this->date_indonesia($a->start_date);
			$row[] = $a->familystatustax;
			$row[] = $a->familystatusrice;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger"" href="javascript:void(0)" title="Edit" onclick="edit('."'".$a->id_tax_sk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tax->count_all(),
						"recordsFiltered" => $this->tax->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function tax_status_add()
	{
		$this->_validate_tax_status();
		
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'inputdate' => $this->input->post('f_input_date'),
				'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				'start_date' => $this->date_input($this->input->post('f_start_date')),
				'familystatustax' => $this->input->post('f_family_tax_status'),
				'familystatusrice' => $this->input->post('f_rice_tax_status'),


			);
		$insert = $this->tax->save($data);

		echo json_encode(array("status" => TRUE));

	}

	// grade status edit
	public function tax_edit($id)
	{
		$data = $this->tax->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->start_date = $this->date_indonesia($data->start_date);
		echo json_encode($data);
	}

	public function tax_update()
	{
		
		$data = array(
				'id_tax_sk' => $this->input->post('f_empcode_4_update'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'start_date' => $this->date_input($this->input->post('f_start_date')),
				//'inputdate' => $this->date_input($this->input->post('f_input_date')),
				//'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				//'start_date' => $this->date_input($this->input->post('f_start_date')),
				'familystatustax' => $this->input->post('f_family_tax_status'),
				'familystatusrice' => $this->input->post('f_rice_tax_status'),
			);
		$this->tax->update(array('id_tax_sk' => $this->input->post('f_empcode_4_update')), $data);
		echo json_encode(array("status" => TRUE));
	}

	// validate for form grade status
	private function _validate_tax_status()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		if($this->input->post('f_empcode') == '')
		{
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_start_date') == '')
		{
			$data['inputerror'][] = 'f_start_date';
			$data['error_string'][] = 'Start Date is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_family_tax_status') == '')
		{
			$data['inputerror'][] = 'f_family_tax_status';
			$data['error_string'][] = 'Family Tax Status is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_rice_tax_status') == '')
		{
			$data['inputerror'][] = 'f_rice_tax_status';
			$data['error_string'][] = 'Rice Tax Status is required';
			$data['status'] = FALSE;
		}
		


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	// TERMINATION
	function termination()
	{
		 $group = "hr";
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

		 $data = array(
            'title' => 'Termination',
            'username' => $this->usr_session(),
            'dd_empcode' => $this->termin->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->gs->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->gs->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
		);
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_termination');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_termination');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}
	}

	// memanggil data di database untuk di kirim ke view
	public function termination_list()
	{
		$this->load->helper('url');

		$list = $this->termin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $a->nik_pim;
			$row[] = $a->empname;
			$row[] = $this->date_indonesia($a->datejoin);
			$row[] = $this->date_indonesia($a->dateterminate);
			$row[] = $a->terminatetype;
			$row[] = $a->reasonofresign;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger"" href="javascript:void(0)" title="Edit" onclick="edit('."'".$a->empcode."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->termin->count_all(),
						"recordsFiltered" => $this->termin->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function termination_add()
	{
		$nik = $this->input->post('f_empcode');
		$this->_validate_termination_status();
		$cek = $this->_is_exist_termination($nik);
		//left is field name -> form id/name
		if ($cek == 1) {
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data/nik Sudah di Termination';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else
		{
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'inputdate' => $this->input->post('f_input_date'),
				'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				//'datejoin' => $this->date_input($this->input->post('f_date_join')),
				'dateterminate' => $this->date_input($this->input->post('f_terminate_date')),
				'terminatetype' => $this->input->post('f_termination_type'),
				'reasonofresign' => $this->input->post('f_reason'),
				'terminationamount' => $this->input->post('f_termination_amount'),
				'pensionamount' => $this->input->post('f_pension_amount'),
				'approvedby' => $this->input->post('f_apprved_by'),
				'approveddate' => $this->date_input($this->input->post('f_approved_date')),
				'worktime' => $this->input->post('f_worktime'),
				'age' => $this->input->post('f_age'),
			);
		$insert = $this->termin->save($data);
		echo json_encode(array("status" => TRUE));
		}

	}

	// grade status edit
	public function termination_edit($id)
	{
		$data = $this->termin->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->datejoin = $this->date_indonesia($data->datejoin);
		$data->dateterminate = $this->date_indonesia($data->dateterminate);
		$data->approveddate = $this->date_indonesia($data->approveddate);

		echo json_encode($data);
	}

	public function termination_update()
	{
		
		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				//'inputdate' => $this->input->post('f_input_date'),
				//'inputby' => $this->input->post('f_input_by'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				//'datejoin' => $this->date_input($this->input->post('f_date_join')),
				'dateterminate' => $this->date_input($this->input->post('f_terminate_date')),
				'terminatetype' => $this->input->post('f_termination_type'),
				'reasonofresign' => $this->input->post('f_reason'),
				'terminationamount' => $this->input->post('f_termination_amount'),
				'pensionamount' => $this->input->post('f_pension_amount'),
				'approvedby' => $this->input->post('f_apprved_by'),
				'approveddate' => $this->date_input($this->input->post('f_approved_date')),
				'worktime' => $this->input->post('f_worktime'),
				'age' => $this->input->post('f_age'),
			);
		$this->tax->update(array('empcode' => $this->input->post('f_empcode')), $data);
		echo json_encode(array("status" => TRUE));
	}

	// validate for form grade status
	private function _validate_termination_status()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		if($this->input->post('f_empcode') == '')
		{
			$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}
		else{
				
		}
		if($this->input->post('f_terminate_date') == '')
		{
			$data['inputerror'][] = 'f_terminate_date';
			$data['error_string'][] = 'Date Terminate is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('f_reason') == '')
		{
			$data['inputerror'][] = 'f_reason';
			$data['error_string'][] = 'The Reasons is required';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _is_exist_termination($nik)
	{
		$a = $this->emp_attribute->cek_data($nik);
		if (isset($a)) {
			$baris = "1";
			return $baris;
		}
		else{
			$baris = "0";	
			return $baris;
		}

	}

	/*controller unutk document status*/
	public function doc_status()
	{
		 $group = "hr";
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

		 $data = array(
            'button' => 'Create',
            'dept_id' => $this->last_dept_id(),
            'title' => 'Document Satus',
            'username' => $this->usr_session(),

            'dd_empcode' => $this->master_lov->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->master_lov->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->master_lov->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
		);
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/

		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_doc_status');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_doc_status');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}

	}

	public function doc_add()
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'empcode'	=>	$this->input->post('f_empcode'),
			'status'	=>	$this->input->post('f_status'),
			'contract_status'	=>	$this->input->post('f_status_kontrak'),
			'start_date'	=>	date_input($this->input->post('f_start_date')),
			'end_date'	=>	date_input($this->input->post('f_end_date')),
			'contract_no'	=>	$this->input->post('f_contract_no'),
			'masa_kerja'	=>	$this->input->post('f_masa_kerja'),
			'sign_date'	=>	date_input($this->input->post('f_sign_date')),
			'approved_id'	=>	$this->input->post('f_approved_id'),
			'remarks'	=>	$this->input->post('f_remarks'),
			'inputby'	=>	$this->input->post('f_input_by'),
			'inputdate'	=>	time_stamp(),
		);

		$insert = $this->doc->save($data);

		echo json_encode(array("status" => true));

	}

	public function doc_status_list()
	{
		$list = $this->doc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $a->nik_pim;
			$row[] = $a->empname;
			$row[] = $a->contract_no;
			$row[] = $this->date_indonesia($a->start_date);
			$row[] = $this->date_indonesia($a->end_date);
			$row[] = $this->date_indonesia($a->sign_date);
			$row[] = $a->approved_id;
			$row[] = $a->remarks;
			if ($a->status == 'draft') {
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$a->contract_id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$a->contract_id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
			if ($a->status == 'submit') {
				$row[] = '<span class="label label-warning">'.$a->status.'</span>';
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$a->contract_id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$a->contract_id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}
			if ($a->status == 'closed') {
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
			}
			//$row[] = $a->status;
			

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->doc->count_all(), 
			'recordsFiltered' => $this->doc->count_filtered(), 
			'data' => $data,  
		);
		// output to json format
		echo json_encode($output);
	}

	// delete document status
	public function doc_delete($id)
	{
		$this->doc->delete_by_id($id);
		echo json_encode(array("status" => true));

	}

	public function doc_status_edit($id)
	{
		$data  = $this->doc->get_by_id($id);
		$data->start_date = $this->date_indonesia($data->start_date);
		$data->end_date = $this->date_indonesia($data->end_date);
		$data->sign_date = $this->date_indonesia($data->sign_date);

		echo json_encode($data);
	}

	public function doc_update()
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'empcode'	=>	$this->input->post('f_empcode'),
			'status'	=>	$this->input->post('f_status'),
			'contract_status'	=>	$this->input->post('f_status_kontrak'),
			'start_date'	=>	date_input($this->input->post('f_start_date')),
			'end_date'	=>	date_input($this->input->post('f_end_date')),
			'contract_no'	=>	$this->input->post('f_contract_no'),
			'masa_kerja'	=>	$this->input->post('f_masa_kerja'),
			'sign_date'	=>	date_input($this->input->post('f_sign_date')),
			'approved_id'	=>	$this->input->post('f_approved_id'),
			'remarks'	=>	$this->input->post('f_remarks'),
			'updateby'	=>	$this->input->post('f_update_by'),
			'updatedate'	=>	time_stamp(),
		);

		$this->doc->update(array("contract_id" => $this->input->post("f_contract_id")), $data);

		echo json_encode(array("status" => true));

	}

	public function list_expierd()
	{
		 $group = "hr";
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

		 $data = array(
            'dept_id' => $this->last_dept_id(),
            'title' => 'List Expierd',
            'username' => $this->usr_session(),

            'dd_empcode' => $this->master_lov->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->master_lov->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->master_lov->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
		);
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_doc_exp');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_doc_exp');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}

	}

	/*fcontroller untuk close data monitoring*/
	public function close_data($id)
	{
		$data = array(
			//'contract_id'	=>	$this->input->post('');
			'status'	=>	"closed",
		);
		$this->doc_exp->update(array("contract_id" => $id), $data);
		echo json_encode(array("status" => true));
	}

	public function expired_list()
	{

		$list = $this->doc_exp->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $a) {
			$no++;
			$row = array();
			$row[] = $no;
			//$row[] = $a->empcode;
			$row[] = $a->nik_pim;
			$row[] = $a->empname;
			$row[] = $a->employeetype;
			$row[] = $a->contract_no;
			$row[] = $this->date_indonesia($a->start_date);
			$row[] = $this->date_indonesia($a->end_date);
			$row[] = $this->date_indonesia($a->sign_date);
			$row[] = $this->date_indonesia($a->day_reminder);
			$row[] = $a->due_date. ' Hari Lagi';
			if ($a->due_date < 0) {
				$row[] = '<span class="label label-danger">EXPIRED</span>';
			}
		else{
			if ($a->status == 'draft') {
				$row[] = '<span class="label label-danger">'.$a->status.'</span>';
			}
			if ($a->status == 'submit') {
				$row[] = '<span class="label label-warning">'.$a->status.'</span>';
			}
			if ($a->status == 'closed') {
				$row[] = '<span class="label label-success">'.$a->status.'</span>';
			}
		}
			//$row[] = $a->status;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Close It" onclick="close_data('."'".$a->contract_id."'".')"><i class="glyphicon glyphicon-pencil"></i>Click for Close</a>';

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->doc_exp->count_all(), 
			'recordsFiltered' => $this->doc_exp->count_filtered(), 
			'data' => $data,  
		);
		// output to json format
		echo json_encode($output);

	}

		public function nik()
	{
		$this->load->helper('nik_helper');
		$test = 'LHT-GA';
		echo nik_helper($test);
		/*$a = $this->emp_attribute->last_rn();

		foreach ($a as $key) {
			echo $key->rn;
		}*/
	}

	public function cek_notif()
	{
		$cek = $this->cek_kontrak();
		if ($cek > 0) {
			$this->send_mail();
			//echo "proses kirim email";
		}
		else
		{
			echo "tidak kirim email";
		}
	}
	
	public function cek_kontrak()
	{
		$l = $this->doc_exp->notif();
		/*echo('<pre>');
		print_r($l);
		echo('</pre>');*/
		foreach ($l as $key) {
			$total_notif =  $key->notif;
		}

		return $total_notif;
	}


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
		$param = 1; // parameter database untuk tujuan email
		$target_cc = "cc"; // parameter database untuk cc email
		$target_to = "to"; // parameter database untuk cc email
		$alamat_email_to = $this->master_lov->email_notifikasi($param,$target_to);
		$alamat_email_cc = $this->master_lov->email_notifikasi($param,$target_cc);
		$habis_kontrak = '2';
		$config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_port'] = "587";
        $config['smtp_timeout'] = "10";
        $config['smtp_user'] = "gandhitabrani";
        $config['smtp_pass'] = "64ndH1134";
        $config['charset'] = "iso-8859-1";
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $to = array();
        $cc = array();
		foreach ($alamat_email_to as $key) {
			$to[] = $key->email;
		}
		foreach ($alamat_email_cc as $key) {
			$cc[] = $key->email;
		}
        $this->email->initialize($config);
		$data['email'] = $this->doc_exp->model_exp_email();
		$from = 'noreply@prime-pim.com';
		/*$cc = 'supatno@prime-pim.com';*/
		//$to = 'support-hr.lht@prime-pim.com';
		//$to = 'gandhisaputra13@gmail.com';
		$subjek = 'EMPLOYEES CONTRACT NOTIFICATION';
		$isi = $this->load->view('template_email_contract',$data,true);
		$this->load->library('email');
		
		$this->email->from($from,'noreply@prime-pim.com');
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->subject($subjek);
		$this->email->message($isi);
		/*$this->email->send();*/
		
			if ($this->email->send()) {
				echo "email sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
	
	}


	/*untuk test email saja*/
	public function test_send_mail()
	{

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
		$data['email'] = $this->doc_exp->model_exp_email();
		$from = 'gandhi.saputra@prime-pim.com';
		/*$cc = 'supatno@prime-pim.com';*/
		$to = 'gandhi.saputra@prime-pim.com';
		$subjek = 'EMPLOYEES CONTRACT NOTIFICATION';
		$isi = $this->load->view('template_email_contract',$data,true);
		$this->load->library('email');

		$this->email->from($from,'noreply@prime-pim.com');
		$this->email->to($to);
		//$this->email->cc(array('humanresources.lht@prime-pim.com','supatno@prime-pim.com'));
		$this->email->subject($subjek);
		$this->email->message($isi);
		/*$this->email->send();*/
		
			if ($this->email->send()) {
				echo "email sent";
			}
			else
			{
				show_error($this->email->print_debugger());
			}
	
	}

	public function template_email_contract()
	{
		$data['email'] = $this->doc_exp->model_exp_email();		
		$this->load->view('template_email_contract',$data);
	}
	
	/*untuk test grafik saja*/
	public function graph()
	{
		//$data = $this->graph_model->data_emp_in();
		$dat = array();
		$tahun = date('Y');
		$this->load->model('graph_model');
		for ($i=1; $i <= 12 ; $i++) {
			$dat[] = $this->graph_model->daftar_emp_in($i,$tahun);
		}
		$data['emp_in_monthly'] = $dat;
		$data['tahun'] = $tahun;
		//$data['emp_in_monthly'] = $this->graph_model->daftar_emp_in($i=1);
		$this->load->view('graph',$data);
	}
	public function test_data()
	{
		$bulan = 1;
		$this->load->model('graph_model');
		$data = $this->graph_model->data_emp_in();
		echo json_encode($data);
		//echo date('n');
		/* echo "<pre>";
		echo print_r($data);
		echo "</pre>"; */	
	}
	/*untuk test grafik saja*/

	public function data_grafik()
	{
		$bulan = 1;
		$this->load->model('graph_model');
		$data = $this->graph_model->data_emp_in();
		echo json_encode($data);
		//echo date('n');
		/* echo "<pre>";
		echo print_r($data);
		echo "</pre>"; */	
	}

	public function emp_masuk_list()
	{
		$list_emp_in = $this->graph_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list_emp_in as $key) {
			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $key->nik_pim;
			$row[] = $key->empname;
			$row[] = $key->position;
			$row[] = date_indonesia($key->hire_date);
			$row[] = $key->employeetype;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->graph_model->count_all(),
			"recordsFiltered" => $this->graph_model->count_filtered(),
			"data" =>$data
		);
		echo json_encode($output);
	}

	public function emp_keluar_list()
	{
		$list_emp_out = $this->graph_model->get_datatables_out();
		$data = array();
		$no = $_POST['start'];
		foreach ($list_emp_out as $key) {
			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $key->nik_pim;
			$row[] = $key->empname;
			$row[] = $key->position;
			$row[] = date_indonesia($key->dateterminate);
			$row[] = $key->employeetype;
			$data[] = $row;
		}
		$output = array(
			'draw' => $_POST['draw'],
			'recordsFiltered' => $this->graph_model->count_filtered_out(),
			'recordsTotal' => $this->graph_model->count_all_out(),
			'data' =>$data,
		);

		echo json_encode($output);
		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";*/

	}

	public function emp_out()
	{
		$start_date = "2018-03-01";
		$end_date = "2018-08-13";
		$data = $this->graph_model->daftar_emp_out($start_date, $end_date);
		echo "<pre>";
		echo print_r($data);
		echo "</pre>";
	}
	public function emp_in()
	{
		$start_date = "2018-03-01";
		$end_date = "2018-08-13";
		$tahun = "2018";
		$data = $this->graph_model->rekap_emp_in($tahun);
		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";*/
		$data_tampung = array();
		foreach ($data as $key) {
			$data_tampung[] =  $key->jml_emp;
		}
		$begin_year = 2010;
		$current_year = date('Y');
		for ($i=$begin_year; $i <= $current_year ; $i++) { 
		$data = $this->graph_model->rekap_emp_in($i);
		$data_ke_xls = array();
		foreach ($data as $key) {
			$data_ke_xls[] = $key->jml_emp;
		}
		echo "<pre>";
		echo print_r($data_ke_xls);
		echo "</pre>";
		}
		$nama_bulan = array();
		for ($i=1; $i <=12 ; $i++) {
		//$nm_bln = date('F',$i); 
			$nama_bulan[] = date('F',mktime(0,0,0, $i, 10));
		}
		echo "<pre>";
		echo print_r($nama_bulan);
		echo "</pre>";
	}

	public function rpt_grafik_emp_in_out()
	{

		$group = array("hr","HSE");
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

		 $data = array(
            'dept_id' => $this->last_dept_id(),
            'title' => 'Grafik Karyawan Masuk-Keluar',
            'username' => $this->usr_session(),

            'dd_empcode' => $this->master_lov->dd_empcode(),
            'empcode_selected' => $this->input->post('empcode') ? $this->input->post('empcode') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
            //sebagai informasi empcode ketika button edit di click
            'dd_empcode_hrhist' => $this->gs->dd_empcode_hrhist(),
            'empcode_selected_hrhist' => $this->input->post('empcode') ? $this->input->post('empcode') : '',
            //dd untuk status
            'dd_emp_status' => $this->master_lov->dd_emp_status(),
            'empcode_status_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
            //dd untuk id position
            'dd_emp_position' => $this->master_lov->dd_emp_position(),
            'empcode_pos_selected' => $this->input->post('id_position') ? $this->input->post('id_position') : '',
		);
		/* $masuk = array();
		$keluar = array(); */
		$this->load->model('graph_model');
		/* for ($i=1; $i <= 12 ; $i++) { 
			$masuk[] = $this->graph_model->daftar_emp_in($i);
		}
		for ($i=1; $i <= 12 ; $i++) { 
			$keluar[] = $this->graph_model->daftar_emp_out($i);
		} */
		//$bulan = date('n');
		$bulan = $this->input->post('parameter_bulan');
		$tahun = $this->input->post('parameter_tahun');
		$filter = $this->input->post('filter');
		$download = $this->input->post('download');

		


		if (!isset($bulan) and !isset($tahun)) {
			$bulan = date('n');
			$tahun = date('Y');
		}
		else 
		{
		$bulan = $this->input->post('parameter_bulan');
		$tahun = $this->input->post('parameter_tahun');
		}
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$masuk = $this->graph_model->daftar_emp_in($bulan,$tahun);
		$keluar = $this->graph_model->daftar_emp_out($bulan,$tahun);
		$data['emp_in_monthly'] = $masuk;
		$data['emp_out_monthly'] = $keluar;

		if (isset($download)) {
			$this->load->library('pdf');
			$this->load->model('graph_model');
			$emp_in = array();
			$emp_out = array();
			for ($i=1; $i <= 12 ; $i++) { 
				$emp_in[] = $this->graph_model->daftar_emp_in($i,$tahun);
				$emp_out[] = $this->graph_model->daftar_emp_out($i,$tahun);
			}
			$data['emp_in_monthly'] = $emp_in;
			$data['emp_out_monthly'] = $emp_out;
			$this->pdf->setPaper('A4','potrait');
			$this->pdf->filename = "Grafik Karyawan Masuk Keluar Periode tahun ".$tahun;
			$this->pdf->load_view('rpt_grafik_emp_in_out',$data);
		}


		
		/*$data['dept_id'] = $this->last_dept_id();
		$data['title'] = 'Grade Satus';
		$data['username'] = $this->usr_session();*/
		 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('graph_emp_in_out',$data);
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_graph_in_out');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}

	}

	public function rpt_grafik_xls()
	{
		$start_date = date_input($this->input->post('filter_start'));
		$end_date =   date_input($this->input->post('filter_end'));
		$spreadsheet = new Spreadsheet();
		$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '1e232b'],
        ],
    ],
]; //array untuk membuat all border

/*SHEET DETAIL DATA*/
		$spreadsheet->setActiveSheetIndex(0)->setTitle('Detail Data'); // membuat nama sheet
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:R2'); // merge judul sheet detail data
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('A4:H4'); // merge judul detail karyawan masuk
		$spreadsheet->setActiveSheetIndex(0)->mergeCells('K4:R4'); // merge judul detail karyawan Keluar
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(24);
		$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(24);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1','Data dari tanggal '.date_indonesia($start_date).' sampai dengan '.date_indonesia($end_date).' ');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4','KARYAWAN MASUK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5','NO');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B5','BULAN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C5','TAHUN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D5','DOJ');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E5','NIK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F5','NAMA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G5','POSISI');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H5','STATUS');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('K4','KARYAWAN KELUAR');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('K5','NO');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('L5','BULAN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('M5','TAHUN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('N5','Date Terminate');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('O5','NIK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('P5','NAMA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('Q5','POSISI');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('R5','STATUS');
		$spreadsheet->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah

		$spreadsheet->setActiveSheetIndex(0)->getStyle('A4:H400')->applyFromArray($styleArray); //membuat all border table karyawan masuk dengan array yang sudah di definisikan diatas
		$spreadsheet->setActiveSheetIndex(0)->getStyle('K4:R400')->applyFromArray($styleArray); //membuat all border table karyawan keluar dengan array yang sudah di definisikan diatas

		/*foreach data masuk dan keluar*/
		$emp_in = $this->graph_model->daftar_emp_in($start_date, $end_date);
		$row_excel_in = 6;
		$no_in = 1;
		foreach ($emp_in as $key) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$row_excel_in, $no_in)
			->setCellValue('B'.$row_excel_in, $key->bulan)
			->setCellValue('C'.$row_excel_in, $key->tahun)
			->setCellValue('D'.$row_excel_in, $key->hire_date)
			->setCellValue('E'.$row_excel_in, $key->nik_pim)
			->setCellValue('F'.$row_excel_in, $key->empname)
			->setCellValue('G'.$row_excel_in, $key->position)
			->setCellValue('H'.$row_excel_in, $key->employeetype);
			$no_in++;
			$row_excel_in++;
		}

		$emp_out = $this->graph_model->daftar_emp_out($start_date, $end_date);
		$row_excel_out = 6;
		$no_out = 1;
		foreach ($emp_out as $key) {
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('K'.$row_excel_out, $no_out)
			->setCellValue('L'.$row_excel_out, $key->bulan)
			->setCellValue('M'.$row_excel_out, $key->tahun)
			->setCellValue('N'.$row_excel_out, $key->dateterminate)
			->setCellValue('O'.$row_excel_out, $key->nik_pim)
			->setCellValue('P'.$row_excel_out, $key->empname)
			->setCellValue('Q'.$row_excel_out, $key->position)
			->setCellValue('R'.$row_excel_out, $key->employeetype);
			$no_out++;
			$row_excel_out++;
		}

/* END OF SHEET DETAIL DATA*/

/* REKAPITULASI */
		$sheet_rekap = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'REKAPITULASI'); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_rekap); // add new sheet
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('A1:AA2'); // merge cell judul rekapitulasi
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1','Data Rekapitulasi dari tanggal '.date_indonesia($start_date).' sampai dengan '.date_indonesia($end_date).'');
		$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('O6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('O7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('P7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // membuat judul menjadi di posisi tengah
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(24);
		$spreadsheet->setActiveSheetIndex(1)->getStyle('A6:M25')->applyFromArray($styleArray); //membuat all border table karyawan masuk dengan array yang sudah di definisikan diatas

		$spreadsheet->setActiveSheetIndex(1)->getStyle('O6:AA25')->applyFromArray($styleArray); //membuat all border table karyawan masuk dengan array yang sudah di definisikan diatas




		/*table rekap masuk*/
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('A6:M6');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A6','KARYAWAN MASUK');
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('A7:A8'); // tahun di table
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A7','TAHUN'); // nama field tahun
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('B7:M7'); // Bulan di table
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('B7','BULAN'); // nama field tahun

		/*foreach data karyawan masuk*/
		$begin_year = 2010; // awal tahun yang akan di tampilkan
		$mulai_row = 9; // menjadi acuan pada field di kolum exccel
		$current_year = date('Y'); // tahun berjalan saat ini
		/*melakukan perulangan tahun agar di dapat tahun 2010 - tahun sekarang
		untuk 
		*/
		for ($i=$begin_year; $i <= $current_year ; $i++) { 
		$data = $this->graph_model->rekap_emp_in($i); //model data karyawan masuk
		$data_out = $this->graph_model->rekap_emp_out($i); // model data karyawan keluar
		$data_ke_xls_emp_out = array(); // membuat data array dari array bersarang dari model agar bisa di tampilakn dengan array saat di excel
		foreach ($data_out as $key) {
			$data_ke_xls_emp_out[] = $key->jml_emp;
		}
		$spreadsheet->setActiveSheetIndex(1)
    ->fromArray(
        $data_ke_xls_emp_out,  // The data to set
        NULL,        // Array values with this value will not be set
        'P'.$mulai_row         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );

		$data_ke_xls = array(); // membuat data array dari array bersarang dari model agar bisa di tampilakn dengan array saat di excel
		foreach ($data as $key) {
			$data_ke_xls[] = $key->jml_emp; // perulangan penyimpanan data di array
		}
		/*echo "<pre>";
		echo print_r($data_ke_xls);
		echo "</pre>";*/
		$spreadsheet->setActiveSheetIndex(1)
    ->fromArray(
        $data_ke_xls,  // The data to set
        NULL,        // Array values with this value will not be set
        'B'.$mulai_row         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    $spreadsheet->setActiveSheetIndex(1)->setCellValue('A'.$mulai_row,$i);
    $spreadsheet->setActiveSheetIndex(1)->setCellValue('O'.$mulai_row,$i);
		$mulai_row++;
		} //end for
		$nama_bulan = array();
		for ($i=1; $i <=12 ; $i++) {
		//$nm_bln = date('F',$i); 
			$nama_bulan[] = date('F',mktime(0,0,0, $i, 10));
		}
		/*membuat nama bulan jan - des*/
		$spreadsheet->setActiveSheetIndex(1)->fromArray($nama_bulan, NULL, 'B8');
		$spreadsheet->setActiveSheetIndex(1)->fromArray($nama_bulan, NULL, 'P8');


		/*end of foreach data karyawan masuk*/

		
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('O6:AA6');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('O6','KARYAWAN KELUAR');
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('O7:O8');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('O7','TAHUN'); // nama field tahun
		$spreadsheet->setActiveSheetIndex(1)->mergeCells('P7:AA7');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('P7','BULAN'); // nama field tahun


		/*end table rekap masuk*/


/* ENF OF REKAPITULASI */



			$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan Karyawan Masuk-Keluar HR-'.$nama_file.' .xlsx"');
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

	public function data_karyawan_finance()
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

	//$path = site_url('report/karyawan_produksi.jrxml');
	//$path = site_url('report/hse.jrxml');
	$path = site_url('report/dakar_finance.jrxml');
	$xml = simplexml_load_file($path);
	$PHPJasperXML = new PHPJasperXML();
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $user, $password, $db_or_dsn_name);
	ob_start();
	$PHPJasperXML->outpage("I"); // I untuk preview dan D untuk force download
	ob_end_flush();
}

public function tes()
{
	echo sidebar_list(1, 1);
}

public function test_temp()
	{


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

		$group = array("hr","HSE");
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		//$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'ADD EMPLOYEE';

		// dd emp code
		$data['dd_empcode'] = $this->master_lov->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode_f') ? $this->input->post('f_empcode_f') : '';

		// dd emp status kbt khl kt
		$data['dd_emp_status'] = $this->master_lov->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        //dd id position
        $data['dd_emp_pos'] = $this->master_lov->dd_emp_position();
        $data['dd_emp_pos_select'] = $this->input->post('f_position') ? $this->input->post('f_position') : '';

        //dd departement
        $data['dd_dept'] = $this->master_lov->dd_dept();
        $data['dd_dept_selected'] = $this->input->post('f_position') ? $this->input->post('f_position') : '';

		
   if ($this->ion_auth->in_group($group)) {
      	//$this->load->view('temp/header',$data);
      	$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('content');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('footer_ajax_modal',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }
		}

	}












}
