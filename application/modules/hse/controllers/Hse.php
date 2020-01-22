<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpspreadsheet/vendor/autoload.php');
	use PhpOffice\PhpSpreadsheet\Helper\Sample;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Hse extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form_helper');
		$this->load->helper('tanggal_input_helper');	
		$this->load->helper('time_stamp_helper');
		$this->load->model('hr/lov_model','lov');
		$this->load->model('inspection_model','ins');

		//$this->load->model('lov_model','master_lov');

		//$this->load->library('fpdf');

		date_default_timezone_set('Asia/Jakarta');
	}

	public function data_karyawan_hse()
	{
		$dept = "";
		$position = "";
		$tipe_sim = "";
		$start_date = "";
		$end_date = "";

	$host = "localhost"; // alamat database
	//$host = "192.168.11.7"; // alamat database
	$user = "gandhi"; // username
	$password = "gandhi13"; // password
	$db_or_dsn_name = "hris"; // database name

	ini_set('display_errors', 0);

	// panggil library php jasper dan tcpdf
	$this->load->library('PHPJasperXML');
	$this->load->library('tcpdf/TCPDF');

	//$path = site_url('report/karyawan_produksi.jrxml');
	$path = site_url('report/hse.jrxml');
	//$path = site_url('report/dakar_finance.jrxml');
	$xml = simplexml_load_file($path);
	$PHPJasperXML = new PHPJasperXML();
    //$PHPJasperXML->arrayParameter=array("nik"=> $nik, "end_date"=> $end_date, "username"=> $create_by);
	//$PHPJasperXML->arrayParameter=array("id_dept"=> $dept);
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $user, $password, $db_or_dsn_name);
	ob_start();
	$PHPJasperXML->outpage("I"); // I untuk preview dan D untuk force download
	ob_end_flush();
	}

	public function inspection()
	{
		/*setting hak akses user, setting hanya dept ga yang dapat mengakses*/
		$group = array("HSE");
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
				$data['title'] = 'Safety Inspection';
				
				
				// dropdown
				$data['dd_empcode'] = $this->lov->dd_empcode_by_dept(6);
				$data['empcode_selected'] = $this->input->post('f_reportby') ? $this->input->post('f_reportby') : '';

				$data['dd_vehicle'] = $this->lov->dd_vehicle();
				$data['vehicle_selected'] = $this->input->post('f_nap') ? $this->input->post('f_nap') : '';

				$data['dd_dept'] = $this->lov->dd_dept();
				$data['dept_selected'] = $this->input->post('f_dept') ? $this->input->post('f_dept') : '';
				
		        if ($this->ion_auth->in_group($group)) {
		        	# code...
				$this->load->view('temp/title',$data);
				$this->load->view('template/header_ga');
				$this->load->view('temp/sidebar');
				$this->load->view('f_inspection');
				$this->load->view('temp/footer');
				$this->load->view('ajax_inspection',$data);
				//$this->load->view('notif');
		        }
			    else
			    {
						return show_error('You must be an administrator to view this page.');

			    }
		}
	}

	public function inspection_list()
	{
		$list = $this->ins->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = date_indonesia($key->date);
			$row[] = $key->desc;
			$row[] = $key->code_unit;
			$row[] = $key->category;
			$row[] = $key->empname;
			$row[] = $key->dept_desc;
			$row[] = $key->action;
			$row[] = $key->company;
			if ($key->status == "0") {
				$row[] = "<span class='label label-danger'>Open</span>";
			}
			else if($key->status == "1")
			{
				$row[] = "<span class='label label-warning'>On Progress</span>";
			}
			else if($key->status == "2")
			{
				$row[] = "<span class='label label-success'>Closed</span>";
			}
			//$row[] = $key->status;
			$row[] = $key->priority;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$key->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$key->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ins->count_all(),
			"recordsFiltered" => $this->ins->count_filtered(),
			"data" => $data,
	);

	echo json_encode($output);

	}

	public function add_inspection()
	{
		$data = array(
			"date" => date_input($this->input->post('f_date')),
			"desc" => $this->input->post('f_desc'),
			"nap" => $this->input->post('f_nap'),
			"category" => $this->input->post('f_category'),
			"report_by" => $this->input->post('f_reportby'),
			"dic" => $this->input->post('f_dept'),
			"action" => $this->input->post('f_act'),
			"company" => $this->input->post('f_comp'),
			"status" => $this->input->post('f_status'),
			"priority" => $this->input->post('f_prior'),
			"inputby" => $this->input->post('f_input_by'),
			"inputdate" => $this->input->post('f_input_date')
		);
		$this->ins->save($data);
		echo json_encode(array("status"=>TRUE));
	}

	public function edit_inspection($id)
	{
		$data = $this->ins->get_by_id($id);
		$data->date = date_indonesia($data->date);
		echo json_encode($data);
	}

	public function update_inspection()
	{
		$data = array(
			"id" => $this->input->post('f_id'),
			"date" => date_input($this->input->post('f_date')),
			"desc" => $this->input->post('f_desc'),
			"nap" => $this->input->post('f_nap'),
			"category" => $this->input->post('f_category'),
			"report_by" => $this->input->post('f_reportby'),
			"dic" => $this->input->post('f_dept'),
			"action" => $this->input->post('f_act'),
			"company" => $this->input->post('f_comp'),
			"status" => $this->input->post('f_status'),
			"priority" => $this->input->post('f_prior'),
			"inputby" => $this->input->post('f_input_by'),
			"inputdate" => $this->input->post('f_input_date')
		);
		$this->ins->update(array("id"=> $this->input->post('f_id')), $data);
		echo json_encode(array("status"=>TRUE));
	}

	public function inspection_delete($id)
	{
		$this->ins->delete_by_id($id);
		echo json_encode(array("status"=>TRUE));
	}











} // end of controller

?>
