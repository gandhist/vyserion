<?php
/* jika ada revisi pada query gaji maka update 1 persatu pada file berikut ini :
1. rpt_slip_gaji_model > header_slip_rev01 = untuk komponen gaji yang ada di header slip.
2. rpt_slip_lembur_model > rpt_detail_lembur = untuk detail tabel kehadiran kehadiran, jika cutoff dimajukan /mundur setting di sini
3. rpt_slip_gaji_model > gt_rekap_gaji = menjumlahkan totoal rekap gaji

*/
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpspreadsheet/vendor/autoload.php');
		use PhpOffice\PhpSpreadsheet\Helper\Sample;
		use PhpOffice\PhpSpreadsheet\IOFactory;
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payroll extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
        //$this->load->library('lib_log');
		$this->load->helper('form_helper');
		$this->load->helper('tanggal_input_helper');	
		$this->load->model('payroll_model','emp_attribute');
		$this->load->model('rpt_gang_model','rpt_gang');
		$this->load->model('adhoc_model','emp_adhoc');
		$this->load->model('rpt_adhoc','rpt_adhoc');
		$this->load->model('rpt_slip_gaji_model','rpt_slip_gaji');
		$this->load->model('rpt_slip_lembur_model','rpt_slip_lembur');
		$this->load->model('ump_model','ump_model');
		$this->load->model('Absen_model','absen');
		$this->load->model('hr/lov_model','lov');
		$this->load->model('Spl_model','spl_model');
		$this->load->model('rekap_inputan_model','rpt_inputan');
		$this->load->model('closing_model','clo_pay');
		$this->load->model('Emp_att_model','attd');
		$this->load->model('production/rooster_model','rooster');

		

/*		$this->load->model('dept_model','mas_dept');
		$this->load->model('gstatus_model','gs');
		$this->load->model('tax_model','tax');
		$this->load->model('termination_model','termin');*/
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
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
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'ADD EMPLOYEE';
		$data['dd_emp_status'] = $this->emp_attribute->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('template/title',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('content');
		$this->load->view('footer_ajax_modal',$data);
		$this->load->view('notif');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}


	}

	public function time_diff()
	{
		$start_date =  date_create("2018-12-03 07:00:00");
		$end_date =  date_create("2018-12-04 07:00:00");
		//echo round(abs($start_date - $end_date)/60,2). " Minutes"; 	
		//echo $interval = $start_date - $end_date;
		//echo $interval/60;
		$diff = date_diff($start_date, $end_date);
		$jam = $diff->format("%h");	
		$menit = $diff->format("%i");
		echo $jam. ",". $menit;
		echo "<br>diff. in minutes is : ".($jam * 60 + $menit);	
	}

	public function selisih($start_date, $end_date)
	{
		/*for testing
		http://localhost/hris/payroll/selisih/2018-03-22/2018-04-22 
		*/
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		echo "tanggal awal adalah ".$start_date." sampai dengan tanggal ".$end_date." akan berakhir, selisinya adalah ";
		$a = date_create($start_date);
		$b = date_create($end_date);
		//$t = date_diff("2018-01-01","2018-01-15");
		$t = date_diff($a, $b);
		echo "<br>";
		echo $t->format("%a Days again "). $data['username']. " contract expired";
		$a = $t->format("%a");
		echo $a;
		echo "<br>";
		if ($a <= 30) {
			echo "akan ada notifikasi karena duedate nya ".$a." hari lagi ";
		}
	else
	{
			echo "tidak akan ada notifikasi karena duedate nya ".$a." hari lagi ";

	}
	}

	public function general_act()
	{ 
		/*buat parameter group accessrights di sini untuk di jadikan kondisi saat userlogin sudah di periksa maka di cek apakah dia termasuk dalam group hr yang di izinkan, jika tidak maka tidak akan bisa tampil halaman ini*/
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
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'General Activity';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->lov->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->lov->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        // dropdown untuk attd code
		$data['dd_attd_code'] = $this->lov->dd_attd_code();
		$data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';
		
		$data['dd_gang'] = $this->lov->dd_gang();
		$data['gang_selected'] = $this->input->post('f_gang_f') ? $this->input->post('f_gang_f') : '';
		

		/*$this->load->view('title',$data);
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('f_gang_activity');
		$this->load->view('ajax_gang_activity',$data);
		$this->load->view('notif');*/
        
		
        if ($this->ion_auth->in_group($group)) {
        	# code...
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_gang_activity');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_gang_activity',$data);
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
		}*/
		$list = $this->emp_attribute->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->nik_pim;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->dept_desc;
			$row[] = $emp_attribute->attd_desc;
			$row[] = $this->date_indonesia($emp_attribute->attd_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->shift;
			$row[] = $emp_attribute->work_hour;
			$row[] = '<td class="table_data" data-row_id="" data-column_name="FirstName" contenteditable>'.$emp_attribute->total_jam_lembur.'</td>';
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
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

	public function closing_list()
	{
		$list = $this->clo_pay->get_datatables_query();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) 
		{
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->period;
			$row[] = $key->year;
			$row[] = $key->nik_pim;
			$row[] = $key->empname;
			$row[] = $key->position_desc;
			$row[] = $key->golongan;
			$row[] = "Rp ".number_format($key->upah,2,",",".");
			$row[] = "Rp ".number_format($key->total_sia,2,",",".");;
			$row[] = "Rp ".number_format($key->pot_prop,2,",",".");
			$row[] = "Rp ".number_format($key->gaji_setelah_sia,2,",",".");
			$row[] = "Rp ".number_format($key->deduction,2,",",".");
			$row[] = "Rp ".number_format($key->kehadiran_pagi,2,",",".");
			$row[] = $key->dept_desc;
			$row[] = "Rp ".number_format($key->allowance,2,",",".");
			$row[] = "Rp ".number_format($key->jamsostek,2,",",".");
			$row[] = "Rp ".number_format($key->jpk,2,",",".");
			$row[] = $key->hk_dibayar;
			$row[] = "Rp ".number_format($key->kehadiran_bulanan,2,",",".");
			$row[] = "Rp ".number_format($key->upah_perjam,2,",",".");
			$row[] = $key->jam_lembur;
			$row[] = "Rp ".number_format($key->uang_lembur,2,",",".");
			$row[] = "Rp ".number_format($key->insentive_snack,2,",",".");
			$row[] = "Rp ".number_format($key->total_pendapatan,2,",",".");
			$row[] = "Rp ".number_format($key->total_potongan,2,",",".");
			$row[] = "Rp ".number_format($key->gaji_bersih,2,",",".");
			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'], 
			'recordsTotal' => $this->clo_pay->count_all(), 
			'recordsFiltered' => $this->clo_pay->count_filtered() , 
			'data' => $data, 
		);

		echo json_encode($output);

	}


	public function ajax_edit($id)
	{
		$data = $this->emp_attribute->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//====where edit button clicked convert date from yyyy-mm-dd to dd-mm-yyyy
		$data->attd_date = $this->date_indonesia($data->attd_date);
		echo json_encode($data);
	}

	public function test_copy_data()
	{
		$period = $this->input->post('filter_period');
		$year = $this->input->post('filter_year');
		$start_date = get_from_date_period($period,$year);
		$end_date =  get_to_date_period($period,$year);
		$start_date_input =  date_input($start_date);
		$end_date_input =  date_input($end_date);
		
		$empcode = $this->input->post('f_empcode_copy');
		$cek = $this->cek_master($start_date_input, $end_date_input);
		if ($cek == 0) {
		
		return json_encode(array("status"=> false));	

		}
		else
		{
		/*jika 1 berarti data master sudah ada*/
		$this->emp_attribute->copy_data($empcode, $start_date_input, $end_date_input);
		echo json_encode(array("status"=> true));
		}
		//echo json_encode($empcode);
	}

	public function jink()
	{
		$period = 1;
		$year = 2019;
		if ($period == 1) {
			$get_period = get_date_period($period = 12, $year-1);
			}
			else{
				$get_period = get_date_period($period, $year);
			}
		echo $get_period->start_date;
		echo $get_period->end_date;

		$empcode = $this->emp_attribute->get_empcode_by_period_gang_activity($get_period->start_date, $get_period->end_date);
		print_r($empcode);
	}

	public function get_empcode_last_period()
	{
		/*$period = 10;
		$year = 2018;*/
		$period = $this->input->post('filter_period');
		$year = $this->input->post('filter_year');
		$start_date = get_from_date_period($period,$year);
		$end_date =  get_to_date_period($period,$year);
		/*untuk mendapatkan periode bulan sebelumnya*/
		if ($period == 1) {
			$get_period = get_date_period($period = 12, $year-1); // untuk awal bulan maka di buat khuusus
		}
		else{
			$get_period = get_date_period($period, $year);
		}
		/*untuk mendapatkan periode bulan sebelumnya*/

		$start_date_model_emp = $get_period->start_date;
		$end_date_model_emp = $get_period->end_date;

		$start_date_input =  date_input($start_date);
		$end_date_input =  date_input($end_date);

		$empcode = $this->emp_attribute->get_empcode_by_period_gang_activity($start_date_model_emp, $end_date_model_emp);
		/*validasi cek data master romzil*/
		$cek = $this->cek_master($start_date_input, $end_date_input);
		if ($cek == 0) {
			/*jika tidak ada data master*/
			$data['inputerror'][] = 'filter_period';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Master data not yet inputed, Call IT!!';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else
		{
			// cek jika data sudah ada
			$cek_current = $this->cek_data_current_period($period, $year);
			if ($cek_current == 0) {
					/*jika tidak ada data master*/
					foreach ($empcode as $key) {
						//echo "insert into ". $key['empcode']. "where date between". $start_date_input ."and ".$end_date_input."<br>";
						$this->emp_attribute->copy_data($key['empcode'], $start_date_input, $end_date_input);
						echo json_encode(array("status" => TRUE));
					}
				echo json_encode(array("status"=> true));
			}
			else{
					/*jika ada data master*/
				$data['inputerror'][] = 'filter_period';
				//$data['inputerror'][] = 'f_empcode';
				$data['error_string'][] = 'Data Last Month has been inputed.';
				$data['status'] = FALSE;
				echo json_encode($data);
				exit();
			}
			
		}
		//print_r($empcode);
	}

	public function cek_master($start_date, $end_date)
	{
		/*fungsi ini akan menlakkukan cek data master romzil pada periode berjalan*/
		$data = $this->emp_attribute->cek_data_master_copy($start_date, $end_date);
		if ($data) {	
			$baris = 1;
			return $baris;
			/*echo "data ada <br>";
			print_r($data);*/
		}
		else
		{
			$baris = 0;
			return $baris;
			//echo "data tidak ada";
		}
	}

	public function cek_data_current_period($period, $year)
	{
		/*fungsi ini akan menlakkukan cek data master romzil pada periode berjalan*/
		$data = $this->emp_attribute->cek_data_current($period, $year);
		if ($data->bulan > 1) {	
			$baris = 1;
			return $baris;
			// tidak boleh inpuut karena jumlah baris lebih dari 1 alias lebih dari romzil
		}
		else
		{
			$baris = 0;
			return $baris;
			//cuma ada romzil, maka bisa input;
		}
	}

	public function emp_add()
	{
		// fungsi validasi ini adalaah untuk memvaldasi data yang tidak terisi, agar tersi
		//$this->_validate();
		/* jika data sudah terisi maka akan di cek ke database apakah nik dengan tanggal yang di input sudah ada di database maka akan menampilkan pesan error, nik dant tanggal tidak ada di database makan akan di jalakan query add gang activity */
			$empcode = $this->input->post('f_empcode');
			$date = $this->date_input($this->input->post('f_date_attd'));
			$cek = $this->cek_gang($empcode,$date);
			if ($cek == 1) {
			$data['inputerror'][] = 'f_date_attd';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
			}

		

		$data = array(
				'empcode' => $this->input->post('f_empcode'),
				'id_gang' => $this->input->post('f_gang'),
				'is_mass_update' =>  $this->input->post('f_mass_update'),
				'inputdate' => $this->input->post('f_input_date'),
				'overtime' => $this->input->post('f_overtime'),
				'inputby' => $this->input->post('f_input_by'),
				/*'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),*/
				'attd_date' => $this->date_input($this->input->post('f_date_attd')),
				'attd_code' => $this->input->post('f_attd_code'),
				'shift' => $this->input->post('f_work_shift'),
				'work_hour' => $this->input->post('f_wh'),
				'psk' => $this->input->post('f_psk'),
				'losstime' => $this->input->post('f_losstime'),
				'reg_hour' => $this->input->post('f_reguler_hour'),
				'short_work_hour' => $this->input->post('f_shw'),
				'whtl' => $this->input->post('f_whtl'),
				'off_day' => $this->input->post('f_off_day'),
				'first_ot' => $this->input->post('f_first_ot'),
				'bantu_satu_ot' => $this->input->post('f_bantu_dua_satu'),
				'bantu_dua_ot' => $this->input->post('f_bantu22'),
				'second_ot' => $this->input->post('f_second_ot'),
				'third_ot' => $this->input->post('f_third_ot'),
				'fourth_ot' => $this->input->post('f_fourth_ot'),
				'total_jam_lembur' => $this->input->post('f_total_lembur'),
				'remarks' => $this->input->post('f_remarks'),
			);
		$insert = $this->emp_attribute->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function get_gang($empcode)
	{
		$data = $this->emp_attribute->get_gang_by_empcode($empcode);
		echo json_encode($data);
	}

	public function mass_add()
	{
		// parameter input massal di input ke table sebagai pengecualian ketika update data, data pada tanggal tersebut yang tidak ada parameter mass_update tidak akan terupdate
		$id_gang = $this->input->post('f_gang');
		$date = date_input($this->input->post('f_date_attd'));
		
		// mendapatkan 
		$get_empcode = $this->emp_attribute->get_member_gang_is_working($id_gang, $date);
		// cek apakah data sudah terinput
		// cek dan filter data yang sudah terinput agar di hapus..
		$cek = $this->emp_attribute->cek_data_by_gang_date($id_gang = "1", $date = "2019-04-02");
		
		if ($cek > 0) {
			// hapus data lama berdasarkan id_gang dan tanggal
			$this->emp_attribute->delete_not_update_massal_by_date($id_gang, $date);

			// insert massal data
			foreach ($get_empcode as $key) {
				$data = array(
					'empcode' =>  $key['empcode'],
					'id_gang' => $this->input->post('f_gang'),
					'is_mass_update' =>  $this->input->post('f_mass_update'),
					'inputdate' => $this->input->post('f_input_date'),
					'overtime' => $this->input->post('f_overtime'),
					'inputby' => $this->input->post('f_input_by'),
					/*'updatedate' => $this->input->post('f_update_date'),
					'updateby' => $this->input->post('f_update_by'),*/
					'attd_date' => $this->date_input($this->input->post('f_date_attd')),
					'shift' => $this->input->post('f_work_shift'),
					'attd_code' => $this->input->post('f_attd_code'),
					'work_hour' => $this->input->post('f_wh'),
					'psk' => $this->input->post('f_psk'),
					'losstime' => $this->input->post('f_losstime'),
					'reg_hour' => $this->input->post('f_reguler_hour'),
					'short_work_hour' => $this->input->post('f_shw'),
					'whtl' => $this->input->post('f_whtl'),
					'off_day' => $this->input->post('f_off_day'),
					'first_ot' => $this->input->post('f_first_ot'),
					'bantu_satu_ot' => $this->input->post('f_bantu_dua_satu'),
					'bantu_dua_ot' => $this->input->post('f_bantu22'),
					'second_ot' => $this->input->post('f_second_ot'),
					'third_ot' => $this->input->post('f_third_ot'),
					'fourth_ot' => $this->input->post('f_fourth_ot'),
					'total_jam_lembur' => $this->input->post('f_total_lembur'),
					'remarks' => $this->input->post('f_remarks'),
				);
				$jml_data = array();
				$jml_data[] = $key['empcode'];
				$this->emp_attribute->save($data);
			}
			$jml_array = count($jml_data)+1;
			$kirbal = array(
				"status" => TRUE,
				"inserted" => $jml_array
			);
			//print_r($cek);
			echo json_encode($kirbal);
		}
		else {
			// jika tidak ada data lama maka insert massal data
			
			foreach ($get_empcode as $key) {
				$jml_data = array();
				$jml_data[] = $key['empcode'];
				$data = array(
					'empcode' =>  $key['empcode'],
					'id_gang' => $this->input->post('f_gang'),
					'is_mass_update' =>  $this->input->post('f_mass_update'),
					'inputdate' => $this->input->post('f_input_date'),
					'overtime' => $this->input->post('f_overtime'),
					'inputby' => $this->input->post('f_input_by'),
					'attd_date' => $this->date_input($this->input->post('f_date_attd')),
				'shift' => $this->input->post('f_work_shift'),
				'attd_code' => $this->input->post('f_attd_code'),
					'work_hour' => $this->input->post('f_wh'),
					'psk' => $this->input->post('f_psk'),
					'losstime' => $this->input->post('f_losstime'),
					'reg_hour' => $this->input->post('f_reguler_hour'),
					'short_work_hour' => $this->input->post('f_shw'),
					'whtl' => $this->input->post('f_whtl'),
					'off_day' => $this->input->post('f_off_day'),
					'first_ot' => $this->input->post('f_first_ot'),
					'bantu_satu_ot' => $this->input->post('f_bantu_dua_satu'),
					'bantu_dua_ot' => $this->input->post('f_bantu22'),
					'second_ot' => $this->input->post('f_second_ot'),
					'third_ot' => $this->input->post('f_third_ot'),
					'fourth_ot' => $this->input->post('f_fourth_ot'),
					'total_jam_lembur' => $this->input->post('f_total_lembur'),
					'remarks' => $this->input->post('f_remarks'),
				);
				$this->emp_attribute->save($data);
			}
			$jml_array = count($jml_data)+1;
			$kirbal = array(
				"status" => TRUE,
				"inserted" => $jml_array
			);
			echo json_encode($kirbal);
		}
	}

	// update massal
	public function mass_update()
	{
		// delete general activity pada tanggal yang ditentukan
		// lalu input data array
		//$this->_validate();
		$data = array(
			'id_emp_act_sk' => $this->input->post('f_id_emp_act_sk'),
			'id_gang' => $this->input->post('f_gang'),
			'is_mass_update' =>  $this->input->post('f_mass_update'),
		);

		$this->emp_attribute->update(array('id_emp_act_sk' => $this->input->post('f_id_emp_act_sk')), $data);
		//
		$id_gang = $this->input->post('f_gang');
		$date = date_input($this->input->post('f_date_attd'));
		// delete data gang pada tanggal tertentu
		$get_empcode = $this->emp_attribute->get_member_gang_is_mass_update($id_gang, $date);
		$del = $this->emp_attribute->delete_data_mass($id_gang, $date);
		if ($del) {			
			foreach ($get_empcode as $key) {
				$jml_data = array();
				$jml_data[] = $key['empcode'];
				$data = array(
					'empcode' =>  $key['empcode'],
					'id_gang' => $this->input->post('f_gang'),
					'is_mass_update' =>  $this->input->post('f_mass_update'),
					'inputdate' => $this->input->post('f_input_date'),
					'overtime' => $this->input->post('f_overtime'),
					'inputby' => $this->input->post('f_input_by'),
					/*'updatedate' => $this->input->post('f_update_date'),
					'updateby' => $this->input->post('f_update_by'),*/
					'attd_date' => $this->date_input($this->input->post('f_date_attd')),
					'attd_code' => $this->input->post('f_attd_code'),
				'shift' => $this->input->post('f_work_shift'),

					'work_hour' => $this->input->post('f_wh'),
					'psk' => $this->input->post('f_psk'),
					'losstime' => $this->input->post('f_losstime'),
					'reg_hour' => $this->input->post('f_reguler_hour'),
					'short_work_hour' => $this->input->post('f_shw'),
					'whtl' => $this->input->post('f_whtl'),
					'off_day' => $this->input->post('f_off_day'),
					'first_ot' => $this->input->post('f_first_ot'),
					'bantu_satu_ot' => $this->input->post('f_bantu_dua_satu'),
					'bantu_dua_ot' => $this->input->post('f_bantu22'),
					'second_ot' => $this->input->post('f_second_ot'),
					'third_ot' => $this->input->post('f_third_ot'),
					'fourth_ot' => $this->input->post('f_fourth_ot'),
					'total_jam_lembur' => $this->input->post('f_total_lembur'),
					'remarks' => $this->input->post('f_remarks'),
				);
				
				$this->emp_attribute->save($data);
				
				}
				
				$jml_array = count($jml_data)+1;
				$kirbal = array(
					"status" => TRUE,
					"inserted" => $jml_array
				);
				echo json_encode($kirbal);
		}
		else{
			echo json_encode(array("status"=>FALSE) );
			//print_r($id_gang);
		}
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
				'id_emp_act_sk' => $this->input->post('f_id_emp_act_sk'),
				'updatedate' => $this->input->post('f_update_date'),
				'updateby' => $this->input->post('f_update_by'),
				'inputby' => $this->input->post('f_update_by'),
				//'inputdate' => $this->input->post('f_input_date'),
				//'inputby' => $this->input->post('f_input_by'),
				
				'attd_date' => $this->date_input($this->input->post('f_date_attd')),
				'empcode' => $this->input->post('f_empcode'),
				'id_gang' => $this->input->post('f_gang'),
				'is_mass_update' =>  $this->input->post('f_mass_update'),
				'attd_code' => $this->input->post('f_attd_code'),
				'shift' => $this->input->post('f_work_shift'),
				'work_hour' => $this->input->post('f_wh'),
				'psk' => $this->input->post('f_psk'),
				'losstime' => $this->input->post('f_losstime'),
				'reg_hour' => $this->input->post('f_reguler_hour'),
				'short_work_hour' => $this->input->post('f_shw'),
				'whtl' => $this->input->post('f_whtl'),
				'off_day' => $this->input->post('f_off_day'),
				'first_ot' => $this->input->post('f_first_ot'),
				'bantu_satu_ot' => $this->input->post('f_bantu_dua_satu'),
				'bantu_dua_ot' => $this->input->post('f_bantu22'),
				'second_ot' => $this->input->post('f_second_ot'),
				'third_ot' => $this->input->post('f_third_ot'),
				'fourth_ot' => $this->input->post('f_fourth_ot'),
				'total_jam_lembur' => $this->input->post('f_total_lembur'),
				'remarks' => $this->input->post('f_remarks'),

			);

		$this->emp_attribute->update(array('id_emp_act_sk' => $this->input->post('f_id_emp_act_sk')), $data);
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
		$this->emp_attribute->update(array('id_emp_act_sk' => $id), $data);
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

         if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_adhoc');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_adhoc',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

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
			//$row[] = $emp_attribute->allowded_code;
			$row[] = '<span id="span_allowded_code" class= "label label-warning" >'.$emp_attribute->allowded_code.'</span>';
			$row[] = $emp_attribute->description;
			$row[] = "Rp.".number_format($emp_attribute->amount,2,",","."); // menhasilkan output berupa Rp.80.000,00
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

 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('rpt_gang_activity');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_rpt_gang_activity',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

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

 if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('rpt_adhoc');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_rpt_adhoc',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

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
		 $group = "hr";
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

 if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('temp/header');
			$this->load->view('temp/sidebar');
			$this->load->view('rpt_sallary');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_rpt_gaji',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}
	}


	// report slip gaji pdf
	public function slip_gaji(){
		/*jika cut off di majukan atau di mundurkan ubah settingan tanggal awal dan akhir di 
file rpt_slip_gaji_model class header_slip_rev01
file rpt_slip_lembur_model class rpt_detail_lembur
		*/
		
		$this->load->helper('detail_lembur_helper');
		$this->load->helper('qrcode_helper');
		$this->load->library('pdf');
		$empcode = $this->input->post('filter_empcode');
		$dept_id = $this->input->post('filter_dept');
		$position_id = $this->input->post('filter_position');
		$month = $this->input->post('filter_month');
		$year = $this->input->post('filter_year');
		$print_date = $this->input->post('print_date');
		$hrd = $this->input->post('f_hrd');
		$pm = $this->input->post('f_pm');
		//$this->_validatee();
    $data = array(
        // disable per tanggal 02102018 karena ada revisi penyesuaian utk integrasi payrol pt pim "emp_attrb" => $this->rpt_slip_gaji->slip_gaji($empcode, $dept_id, $position_id, $year, $month),
        //"emp_attrb" => $this->rpt_slip_gaji->header_slip_rev01($empcode, $dept_id, $position_id, $month, $year),
        "emp_attrb" => $this->rpt_slip_gaji->header_slip_after_closed($empcode, $dept_id, $position_id, $month, $year),
        "bulan" => $month,
        "hrd" => $hrd,
		"pm" => $pm,
		"qr_hr" => "025-0103-0811",
		"qr_pm" => "889/PM-LHT/X/2018",
        "print_date" => $print_date,
        "tahun" => $year
	);

	// execute qrcode
	qrcode_by_params($data["qr_hr"], "hr");
	qrcode_by_params($data["qr_pm"], "pm");


	
    //echo print_r($data);
	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','potrait');
    $timestamp = date("d-m-Y");
    $this->pdf->filename = "Slip Gaji.pdf".$timestamp.".pdf";
	//$this->pdf->load_view('rpt_slip_gaji', $data);
    $this->pdf->load_view('rpt_slip_gaji_rev01', $data);
	$this->pdf->stream("Slip_Gaji_".$empcode."_".$dept_id."_".$month."_".$year.".pdf", array('Attachment'=>0));
	exit;
    //file_put_contents('upload', $this->pdf->load_view('rpt_slip_gaji_rev01', $data));
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



	// report slip Lembur
	function rpt_slip_lembur()
	{
		 $group = "hr";
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


 if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('temp/header');
			$this->load->view('temp/sidebar');
			$this->load->view('rpt_overtime');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_slip_overtime',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

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
    );

    $this->pdf->setPaper('A4','potrait');
    $timestamp = date("Y-m-d");
    $this->pdf->filename = "Slip Lembur.pdf".$timestamp.".pdf";
    $this->pdf->load_view('rpt_overtime_pdf', $data);
	}


	/*master ump sebagai parameter unutk perhitungan saat di slip gaji*/

	public function ump()
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

         if ($this->ion_auth->in_group($group)) {
      
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_uang_kehadiran');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_uang_kehadiran',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }


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

	/*controller report rekap gaji bulanan*/
	// report slip gaji
	function rpt_rekap_sallary()
	{
		$group = "hr";
		
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
			$data['dept'] = $this->emp_attribute->dept();
			$data['empcode'] = $this->emp_rn();
			$data['title'] = 'Report Rekap Sallary';
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
			$this->load->view('rekap_sallary');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_rpt_gaji',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}
	}

	

	// report slip gaji pdf
	public function rekap_sallary(){
		/*jika cut off di majukan atau di mundurkan ubah settingan tanggal awal dan akhi di 
file rpt_slip_lembur_model class header_slip_rev01
file rpt_slip_lembur_model class gt_rekap_gaji
		*/
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
        // unremarks this for check direct user input "emp_attrb" => $this->rpt_slip_gaji->header_slip_rev01($empcode, $dept_id, $position_id, $month, $year),
        //"total" => $this->rpt_slip_gaji->gt_rekap_gaji($empcode, $dept_id, $position_id, $month, $year),
        "emp_attrb" => $this->rpt_slip_gaji->header_slip_after_closed($empcode, $dept_id, $position_id, $month, $year),
        "total" => $this->rpt_slip_gaji->gt_rekap_gaji_after_closing($empcode, $dept_id, $position_id, $month, $year),
        /* disable not used "total" => $this->rpt_slip_gaji->rekap_total_gaji($year, $month),*/
        "bulan" => $month,
        "print_date" => $print_date,
        "tahun" => $year
    );
	//$customPaper = array(0,0,842,595);   
    //$this->pdf->setPaper($customPaper);
    $this->pdf->setPaper('A4','landscape');
    $timestamp = date("d-m-Y");
    $this->pdf->filename = "Rekap Gaji.pdf".$timestamp.".pdf";
    $this->pdf->load_view('rpt_rekap_gaji', $data);
    $this->pdf->stream("Rekap Gaji_".$timestamp.".pdf", array('Attachment'=>0));

	}

	public function total()
	{
		$year = 2018;
		$month = 3;
		$data = $this->rpt_slip_gaji->rekap_total_gaji($year, $month);
		foreach ($data as $key) {
			echo $key['total_upah'];
		}
		echo('<pre>');
		print_r($data);
		echo('</pre>');
	}

	// report slip gaji
	function download_slip()
	{
		$group = "hr";
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

if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('template/title',$data);
			$this->load->view('template/header');
			$this->load->view('template/sidebar');
			$this->load->view('rpt_download_sallary');
			$this->load->view('ajax_rpt_gaji',$data);
			$this->load->view('notif');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}
	}

	// report slip gaji pdf
	public function download_slip_gaji(){
	$this->load->helper('detail_lembur_helper');
    $this->load->library('pdf');
    // parameter saat user isi form 
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


		$loop_nik = $data['emp_attrb'];

		foreach ($loop_nik as $key) {
$nik =  $key['empcode'];
$data_slip = array(
			/*"empcode" => $nik,*/
			"emp_attrb" => $this->rpt_slip_gaji->slip_gaji($nik, $dept_id, $position_id, $year, $month),
			"bulan" => $month,
	        "print_date" => $print_date,
	        "tahun" => $year
	    );
	$this->pdf->setPaper('A4','potrait');
    $this->pdf->load_view('rpt_slip_gaji', $data_slip);

	     /*echo('<pre>');
		print_r($data_slip);
		echo('</pre>');*/
			}	
		//echo $nik;
		
	   


   /* $this->pdf->setPaper('A4','potrait');
    $this->pdf->load_view('rpt_slip_gaji', $data);*/

	}

	public function cek_koneksi_mesin()
	{
		error_reporting(0);
		$this->load->helper('parse_helper');
		$mesin = $this->absen->get_finger();
		foreach ($mesin as $key) {		
			$com_key = "0";
		$ip = $key->ip;
		$key = "0";
		$id = "1";
		$fn = "0";
		$connect = fsockopen($ip, "80", $errno, $errstr, 1);
		//$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
			if ($connect) {
				//echo "terkoneksi!";
				echo json_encode($ip);
				
			}
			else {
				//echo json_encode('shit');				
				//echo "$errstr ($errno)<br />\n";
				//echo json_encode($mesin);

			}
		}
		

		
		//echo $buffer;

	}

	/*download absensi dari mesin absen*/
	public function download_persensi()
	{
		$group = "hr";
		$prod = "prod";
		$this->load->helper('url');
		$this->load->helper('form_helper');
		$this->load->helper('parse_helper');
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
			$data['dept'] = $this->emp_attribute->dept();
			$data['empcode'] = $this->emp_rn();
			$data['title'] = 'Download Persensi';
			//dd empcode
			$data['dd_empcode'] = $this->lov->dd_empcode();
	        $data['empcode_selected'] = $this->input->post('f_empcode_f') ? $this->input->post('f_empcode_f') : '';
	        //dd grade status
	        $data['dd_gang'] = $this->lov->dd_gang();
	        $data['gang_selected'] = $this->input->post('f_gang_f') ? $this->input->post('f_gang_f') : '';
	        //
	        $data['dd_emp_pos'] = $this->emp_attribute->dd_rpt_emp_position();
	        $data['dd_emp_pos_select'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
	        //dd empoyee status
			$data['dd_emp_status'] = $this->emp_attribute->dd_rpt_emp_status();
	        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

	        //dd lov ip address
			$data['dd_mesin'] = $this->lov->dd_mesin_finger();
	        $data['mesin_selected'] = $this->input->post('ip_address') ? $this->input->post('ip_address') : '';

if ($this->ion_auth->in_group($group) or $this->ion_auth->in_group($prod) ) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('temp/header');
			$this->load->view('temp/sidebar');
			$this->load->view('f_download_persensi');
			$this->load->view('temp/footer');
			$this->load->view('notif');
			$this->load->view('ajax_download_persensi',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}
	}

	public function absen_list()
	{
		/*if ($this->input->post('filter_start_date')) {
			# code...
		$this->date_input($this->input->post('filter_start_date'));
		}*/
		$list = $this->absen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $emp_attribute->pin;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->tanggal;
			$row[] = $emp_attribute->date_time;
			$row[] = $emp_attribute->ver;
			$row[] = $emp_attribute->status;
			/*$row[] = $emp_attribute->remarks;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-trash"></i></a>';*/
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->absen->count_all(),
						"recordsFiltered" => $this->absen->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function absensi_add()
	{
		$ip_addr = $this->input->post('ip_address');
		$comm_key = $this->input->post('com_key');

		error_reporting(0);
        /*$IP = "192.168.11.236";
        $Key = "0";*/
        $IP = $ip_addr;
        $Key = $comm_key;
        if($IP!=""){
        $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
            if($Connect){
                $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                $buffer="";
                while($Response=fgets($Connect, 1024)){
                    $buffer=$buffer.$Response;
                }
                $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                $buffer = explode("\r\n",$buffer);
                for($a=0;$a<count($buffer);$a++){
                    $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                    $PIN = Parse_Data($data,"<PIN>","</PIN>");
                    $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
                    $Verified = Parse_Data($data,"<Verified>","</Verified>");
                    $Status = Parse_Data($data,"<Status>","</Status>");
                    $ins = array(
                            "pin"       =>  $PIN,
                            "date_time" =>  $DateTime,
                            "ver"       =>  $Verified,
                            "status"    =>  $Status
                            );
                    // menglakukan komparasi/ mencocokan data terakhir di table agar tidak terinput dua kali
                    if (!$this->absen->if_exist_check($PIN, $DateTime) && $PIN && $DateTime) {
                        //$this->db->insert('absen_finger', $ins);
                        $insert = $this->absen->save($ins);
                    }
                }
						echo json_encode(array("status" => TRUE));
            }
        } 
		
	}

	public function absensi_add_batch_cmd()
	{
		/*$ip_addr = $this->input->post('ip_address');
		$comm_key = $this->input->post('com_key');*/

		error_reporting(0);
        $IP = "192.168.11.236";
        $Key = "0";
        /*$IP = $ip_addr;
        $Key = $comm_key;*/
        if($IP!=""){
        $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
            if($Connect){
                $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                $buffer="";
                while($Response=fgets($Connect, 1024)){
                    $buffer=$buffer.$Response;
                }
                $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                $buffer = explode("\r\n",$buffer);
                for($a=0;$a<count($buffer);$a++){
                    $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                    $PIN = Parse_Data($data,"<PIN>","</PIN>");
                    $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
                    $Verified = Parse_Data($data,"<Verified>","</Verified>");
                    $Status = Parse_Data($data,"<Status>","</Status>");
                    $ins = array(
                            "pin"       =>  $PIN,
                            "date_time" =>  $DateTime,
                            "ver"       =>  $Verified,
                            "status"    =>  $Status
                            );
                    // menglakukan komparasi/ mencocokan data terakhir di table agar tidak terinput dua kali
                    if (!$this->absen->if_exist_check($PIN, $DateTime) && $PIN && $DateTime) {
                        //$this->db->insert('absen_finger', $ins);
                        $insert = $this->absen->save($ins);
                    }
                }
						echo json_encode(array("status" => TRUE));
            }
        } 
		
	}

	public function clear_data_absen()
	{
		$ip_addr = $this->input->post('ip_address_clearlogs');
		$com_key = $this->input->post('com_key_clearlogs');

		if($ip_addr != ""){
	$Connect = fsockopen($ip_addr, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<ClearData><ArgComKey xsi:type=\"xsd:integer\">".$com_key."</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024)){
			$buffer=$buffer.$Response;
		}
						echo json_encode(array("status" => TRUE));
	}
	else
		{
						echo json_encode(array("status" => false));
			/*echo "Koneksi Gagal";*/
		}
	//include("parse.php");	
	$buffer=Parse_Data($buffer,"<Information>","</Information>");
	echo "<B>Result:</B><BR>";
	echo $buffer;
}	
	}



	public function beda()
	{
		$current_month =1;
		for ($i=1; $i <= 12 ; $i++) { 
			if ($i % 2 != 0) {
				if ($i >= $current_month) {
					# code...
				echo "fire @ ".$i;
				echo "<br>";
				}
				
			}
		}
	}

	public function sync_times()
	{
		$ip_addr = $this->input->post('ip_address_synctime');
		$key = $this->input->post('com_key_synctime');
		if($ip_addr!=""){
	$Connect = fsockopen($ip_addr, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<SetDate><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><Date xsi:type=\"xsd:string\">".date("Y-m-d")."</Date><Time xsi:type=\"xsd:string\">".date("H:i:s")."</Time></Arg></SetDate>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024)){
			$buffer=$buffer.$Response;
		}
	}
	else 
	{
		echo "Koneksi Gagal";
	}
	//include("parse.php");	
	$buffer=Parse_Data($buffer,"<Information>","</Information>");
	echo "<B>Result:</B><BR>";
	echo $buffer;
	}
}

	public function lihat_data()
	{
		$pin = "724";
		$date_time = "2018-09-18 07:06:51";
		$data = $this->absen->if_exist_check($pin, $date_time);
			/*if (!$this->absen->if_exist_check($pin, $date_time) && $pin && $date_time) {
			echo "jika tidak ada data, maka akan input absen";
			}
			else
			{
			echo "ada data nya cuy!!!!";
			print_r($data);
			}*/
		$last_data = $this->absen->last_attendance();
			if (strtotime($date_time) > strtotime($last_data->date_time)) {
				echo "jika data dari mesin lebih besar dari data terakhir di dalam database, maka input data akan di prosess";
			}
		else
		{
			echo "data dari mesin lebih kecil dari di dalam database";
			echo "<br>";
			echo "data terakhir di db : ".$last_data->date_time;
			echo "<br>";
			echo "data mesin : ".$date_time;
			echo "<br>";
		}
		print_r($last_data);

	}

	public function cek_ip()
	{
		$this->load->model('Absen_model');
        $data = $this->Absen_model->get_setting();
        echo('<pre>');
		print_r($data);
		echo('</pre>');
	}

	public function test_insert()
	{
        $this->absen->get_data_absen();

                //Config Halaman
        if (!$this->Absen_model->get_data_absen()) {
            $output = '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        Anda tidak terhubung dengan mesin !
                    </div>';
        } elseif($this->Absen_model->get_data_absen()) {
            $output = '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Success !</h4>
                        Anda terhubung dengan mesin.
                    </div>';
        }

        echo $output;
	}

	public function insert_persensi()
	{
		$this->load->helper('parse_helper');	
		$start_date = date_input($this->input->get('start_date'));
		$end_date = date_input($this->input->get('end_date'));
		$ip_address = $this->input->get('ip_address');
		$com_key = $this->input->get('com_key');
		$start_date = $start_date.' 00:00:00';
		echo $start_date.' 00:00:00';
		echo "<br>";
		$end_date = $end_date.' 23:59:59';
		echo $end_date.' 23:59:59';
		echo "<br>";
		echo $ip_address;
		echo "<br>";
		echo $com_key;
		echo "<br>";
		echo "<table cellspacing='2' cellpadding='2' border='1'>
	<tr align='center'>
	    <td><B>No</B></td><td><B>UserID</B></td>
	    <td width='200'><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
	</tr>";

		$Connect = fsockopen($ip_address, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$com_key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024)){
			$buffer=$buffer.$Response;
		}
	}else echo "Koneksi Gagal";
	
	//include("parse.php");
	$buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
	$buffer=explode("\r\n",$buffer);
	/* RAW DATA*/
	echo('<pre>');
		print_r($buffer);
		echo('</pre>');
		// $tanggal = $buffer[3];
		$no = 1;
	for($a=0;$a<count($buffer);$a++){
		$data=Parse_Data($buffer[$a],"<Row>","</Row>");
		$PIN=Parse_Data($data,"<PIN>","</PIN>");
		$DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		$Verified=Parse_Data($data,"<Verified>","</Verified>");
		$Status=Parse_Data($data,"<Status>","</Status>");

		if ($DateTime >= $start_date || $DateTime <= $end_date) {
			# code...

		echo "<tr align='center'>";
		echo "<td>".$no."</td>";
		echo "<td>".$PIN."</td>";
		echo "<td>".$DateTime."</td>";
		echo "<td>".$Verified."</td>";
		echo "<td>".$Status."</td>";
		echo "<tr>";
			}
			$no++;
		}
	}

	public function test_arr()
	{
		$test = array('12018-05-07 13:41:26000','12018-05-07 13:41:37000','12018-05-07 13:42:24000','12018-05-07 13:43:56020');
		echo('<pre>');
		print_r($test);
		echo('</pre>');

		$cars = array
  (
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
  );

  echo('<pre>');
		print_r($cars);
		echo('</pre>');


		foreach ($test as $key) {
			echo $key[0];
			echo $key[1];
			echo $key[2];
			echo "<br>";
		}
	}

	/*master setup untuk rooster*/

	public function setup_rooster()
	{

		$group = "hr";
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
			$data['dept'] = $this->emp_attribute->dept();
			$data['empcode'] = $this->emp_rn();
			$data['title'] = 'Report Rekap Sallary';
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
      
			$this->load->view('template/title',$data);
			$this->load->view('template/header');
			$this->load->view('template/sidebar');
			$this->load->view('f_download_persensi');
			$this->load->view('ajax_rpt_gaji',$data);
			$this->load->view('notif');
        }
    else
    {
			return show_error('You must be an administrator to view this page.');
    }

		}

	}


	/*controller Surat Perintah Lembur SPL*/
	public function spl()
	{

		/*buat parameter group accessrights di sini untuk di jadikan kondisi saat userlogin sudah di periksa maka di cek apakah dia termasuk dalam group hr yang di izinkan, jika tidak maka tidak akan bisa tampil halaman ini*/
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
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Surat Perintah Lembur';
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
		$this->load->view('f_spl');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_spl',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}

	}
	/*end of spl*/

	public function spl_list()
	{

		$list = $this->spl_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->nik_pim;
			$row[] = $key->empname;
			$row[] = $key->dept_desc;
			$row[] = $key->position_desc;
			$row[] = $key->date;
			$row[] = $key->overtime;
			$row[] = $key->remarks;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$key->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$key->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->spl_model->count_all(),
			"recordsFiltered" => $this->spl_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function spl_add()
	{
		$empcode = $this->input->post('f_empcode'); 
		$date = date_input($this->input->post('f_date_attd')); 
		$overtime = $this->input->post('f_wh'); 
		$remarks = $this->input->post('f_remarks'); 
		$inputby = $this->input->post('f_input_by'); 
		$inputdate = $this->input->post('f_input_date'); 
		$this->_validate_spl();
		$a = $this->cek_data_spl($date, $empcode);
		if ($a == 1) {

			$data['inputerror'][] = 'f_date_attd';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		else
		{
			$data = array(
				'empcode' => $empcode,
				'date' => $date,
				'overtime' => $overtime,
				'remarks' => $remarks,
				'inputby' => $inputby,
				'inputdate' => date_input($inputdate),
				);	
				$this->spl_model->save($data);
				echo json_encode(array("status"=> TRUE));
		}
	}

	public function spl_edit($id)
	{
		$data = $this->spl_model->get_by_id($id);
		$data->date = date_indonesia($data->date);
		echo json_encode($data);

	}

	public function spl_update()
	{
		$this->_validate_spl();
		$data = array(
			"date" => date_input($this->input->post('f_date_attd')),
			"empcode" => $this->input->post('f_empcode'),
			"overtime" => $this->input->post('f_wh'),
			"remarks" => $this->input->post('f_remarks'),
			"updateby" => $this->input->post('f_update_by'),
			"updatedate" => date_input($this->input->post('f_update_date')),
		);
		$this->spl_model->update(array("id"=>$this->input->post('f_id_emp_act_sk')),$data);
		echo json_encode(array("status"=>true));

	}

	public function spl_delete($id)
	{
		$this->spl_model->delete_by_id($id);
		echo json_encode(array("status" => true));
	}

	public function cek_data_spl($date, $empcode)
	{
		$a = $this->spl_model->cek_data($date, $empcode);
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

	private function _validate_spl()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		/*field yang harus di isi*/
		$date = $this->input->post('f_date_attd');
		$empcode = $this->input->post('f_empcode');
		$wh = $this->input->post('f_wh');
		$remarks = $this->input->post('f_remarks');
		if ($date == '') {
			$data['error_string'][] = 'Date is required';
			$data['inputerror'][] = 'f_date_attd';
			$data['status'] = FALSE;
		}
		/*if ($empcode == '') {
			$data['error_string'][] = 'Nama is required';
			$data['inputerror'][] = 'f_empcode';
			$data['status'] = FALSE;# code...
		}*/
		if ($wh == '') {
			$data['error_string'][] = 'Work Hour is required';
			$data['inputerror'][] = 'f_wh';
			$data['status'] = FALSE;
		}
		if ($remarks == '') {
			$data['error_string'][] = 'Remarks is required';
			$data['inputerror'][] = 'f_remarks';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	public function tes_header($month, $year)
	{
		$empcode = "";
		$dept_id = "1";		
		$position_id = "";		
		$month = "9";
		$year = "2018";
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year, 1);
		/*foreach ($data as $key) {
			echo $key->nik_pim;
			echo $key->nik_pim;
		}*/
		/*echo "<pre>";
		echo print_r($data);
		echo "<pre>";

		for ($i= 65; $i <= 91 ; $i++) { 
			echo chr($i);
			if ($i == 91) {
				echo "A double";
			}
		}*/
		echo "\n";
		$no = 1;
		for ($i= 'A'; $i <= 'Z' ; $i++) { 
			echo $i."\n";
			$no++;
		}

           
		/*$test = $this->tanggal($month, $year);
		echo "<pre>";
		echo print_r($test);
		echo "<pre>";*/

	}

	public function detail($month, $year)
	{
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year);
		foreach ($data as $key) {
			$empcode = $key->empcode;
			$departement = $key->departement;
		$dat = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement);
		/*echo "<pre>";
		echo print_r($dat);
		echo "<pre>";*/
		}

		foreach ($data as $key) {
			$empcode = $key->empcode;
		$dat = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode);
		/*echo "<pre>";
		echo print_r($dat);
		echo "<pre>";*/
		echo "<table border='1'>";
				foreach ($dat as $kow) {
		echo "<tr>";
				echo "<td>".$kow->empcode."</td>";
				echo "<td>".date_indonesia($kow->attd_date)."</td>";
				echo "<td>".$kow->attd_desc."</td>";
				echo "<td>".$kow->work_hour."</td>";
				echo "<td>".$kow->total_jam_lembur."</td>";
		echo "</tr>";
			}
		echo "</table>";
		echo "</br>";
		}

	}

	public function tanggal($month, $year)
	{
		$tgl = array();
		 $back_year = $year-1;
            switch ($month) {
                    case 1:
            $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-21" AND "'.$year.'-01-25"');
            $filter_start_date  = $back_year.'-12-21';
            $filter_end_date    = $year.'-01-25';
                    break;
                    case 2:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
            $filter_start_date  = $year.'-01-26';
            $filter_end_date    = $year.'-02-25';     
                    break;
                    case 3:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
            $filter_start_date  = $year.'-02-26';
            $filter_end_date    = $year.'-03-25';       
                    break;
                    case 4:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
            $filter_start_date  = $year.'-03-26';
            $filter_end_date    = $year.'-04-25';       
                    break;
                    case 5:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
            $filter_start_date  = $year.'-04-26';
            $filter_end_date    = $year.'-05-25';       
                    break;
                    case 6:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
            $filter_start_date  = $year.'-05-26';
            $filter_end_date    = $year.'-06-25';       
                    break;
                    case 7:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
            $filter_start_date  = $year.'-06-26';
            $filter_end_date    = $year.'-07-25';       
                    break;
                    case 8:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
            $filter_start_date  = $year.'-07-26';
            $filter_end_date    = $year.'-08-25';       
                    break;
                    case 9:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
            $filter_start_date  = $year.'-08-26';
            $filter_end_date    = $year.'-09-25';       
                    break;
                    case 10:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
            $filter_start_date  = $year.'-09-26';
            $filter_end_date    = $year.'-10-25';       
                    break;
                    case 11;
            $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-25"');
            $filter_start_date  = $year.'-10-26';
            $filter_end_date    = $year.'-11-25';       
                    break;
                    case 12:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-12-26" AND "'.$year.'-01-25"');
            $filter_start_date  = $year.'-11-26';
            $filter_end_date    = $year.'-12-25';       
                    break;
            }

            while (strtotime($filter_start_date) <= strtotime($filter_end_date)) {
$nama = date("l", strtotime($filter_start_date));
$tgl[] = "$filter_start_date,$nama";
$filter_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($filter_start_date)));//looping tambah 1 date
}
return $tgl;
	}

	public function rpt_inputan($month, $year)
	{
		$spreadsheet = new Spreadsheet();
		$nama_sheet = $this->rpt_inputan->nama_sheet();
		$a = 0;

		foreach ($nama_sheet as $key) {
			$baris_tgl = 10;

		$departement_header = $key->departement;
		$sheet_new = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_new);
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue('A1',$key->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setTitle($key->dept_desc); // membuat nama sheet berdasarkan kode unit
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year, $departement_header);
		// keterangan header
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A1','NIK');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A2','Nama');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A3','Departement');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A4','Posisi');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A5','Basic Sallary');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A6','Uang Kehadiran');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A7','Insentive Kopi & Snack');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A8','Grade');

		// kode warna 
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A50', 'IZIN/ALPA/MANGKIR')
			->getStyle('A50')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A51', 'OFF')
			->getStyle('A51')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A52', 'SAKIT')
			->getStyle('A52')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A53', 'HARI PENDEK')
			->getStyle('A53')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A54', 'KERJA HARI LIBUR')
			->getStyle('A54')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A55', 'CUTI')
			->getStyle('A55')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('7155ed');

		$data_array = $this->tanggal($month, $year);
			$no_tgl = 10;
			foreach ($data_array as $daray) {
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A'.$no_tgl,$daray);
			$no_tgl++;
			}
			

			$i = 1;
			$abj_awl = 66; // akan menjadi nama cell B - Z dilakukan perulangan di foreach data header
			$abj_awl_aa = 65;
			$abj_awl_ba = 65;
			$abj_awl_ca = 65;
			$abj_awl_da = 65;
			$abj_awl_ea = 65;
			$abj_awl_fa = 65;
			$abj_awl_ga = 65;
			
			//for ($i= 'B'; $i <= 'K' ; $i++) { 


/*header A1 - A8 adalah header dan kommponen gaji beserta golongan karyawan
yang akan menghasilkan ID empcode untuk menampilkan detail di bawahnya berdasarkan ID di header
*/
			foreach ($data as $dt) {
			$empcode = $dt->empcode;
			$b = chr($abj_awl); // mengconvert bilangan ascii menjadi alphabet batas 90 = Z
			$c = chr($abj_awl+1); // mengconvert bilangan ascii menjadi alphabet batas 90 = Z

			//echo $i."\n";
		if ($abj_awl < 90) {
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		


		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);

		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}
		
		} // end of if A


		/*jika abj_awl == 91 atau sudah angka Z*/
		 else if ($abj_awl < 115) {
			$b = "A".chr($abj_awl_aa);
			$c = "A".chr($abj_awl_aa+1);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}

		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);


			$baris_dtl++;	
		}
				$abj_awl_aa++;
		} // end of else if aa


		elseif ($abj_awl < 140) {
			$b = "B".chr($abj_awl_ba);
			$c = "B".chr($abj_awl_ba+1);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}
			$abj_awl_ba++;	
		} // end of else if ba
		elseif ($abj_awl < 165) {
			$b = "C".chr($abj_awl_ca);
			$c = "C".chr($abj_awl_ca+1);

			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}

			$abj_awl_ca++;

		} // end of elseif ca
		elseif ($abj_awl < 190) {
			$b = "D".chr($abj_awl_da);
			$c = "D".chr($abj_awl_da+1);

			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}

			$abj_awl_da++;
		} // end of elseif da
		elseif ($abj_awl < 215) {
			$b = "E".chr($abj_awl_ea);
			$c = "E".chr($abj_awl_ea+1);

			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}

		
			$abj_awl_ea++;

		} // end of elseif ea 
		elseif ($abj_awl < 240) {
			$b = "F".chr($abj_awl_fa);
			$c = "F".chr($abj_awl_fa+1);

			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}

			$abj_awl_fa++;

		} // end of elseif 

		elseif ($abj_awl < 270) {
			$b = "G".chr($abj_awl_ga);
			$c = "G".chr($abj_awl_ga+1);

			$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'1', $dt->nik_pim);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'2', $dt->empname);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'3', $dt->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'4', $dt->position_desc);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'5', $dt->upah);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'6', $dt->kehadiran_pagi);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'7', $dt->uang_makan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $dt->golongan);
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'9', $c);
		//$no++;
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue($b.'8', $b);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);	
		$baris_dtl = 10; // detail di mulai di baris ke 10 atau tepat di bawah header
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour)
			->getStyle($b.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
			elseif ($ke->attd_code == 'attd008') {
				// jika cuti maka hijau
					$spreadsheet->setActiveSheetIndex($a)
				->setCellValue($b.$baris_dtl, $ke->work_hour)
				->getStyle($b.$baris_dtl)->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('7155ed');
				}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($b.$baris_dtl, $ke->work_hour);
		}
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.'8', 'OVERTIME');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue($c.$baris_dtl, $ke->total_jam_lembur);

			$baris_dtl++;	
		}

			$abj_awl_ga++;

		} // end of elseif ga

			$abj_awl++;
			
			}
	//} // end for abjad

			$a++;
		}

		


		/*$sheet_new = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'nama_dept'); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_new);
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1','fucking shit');*/


			$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rpt_inputan_general_activity.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0


$writer = IOFactory::createWriter($spreadsheet, 'Xls');
ob_end_clean();
$writer->save('php://output');
exit;
	}

	public function test_data()
	{
		$month = 10;
		$year = 2018;
		$empcode = "";
		$departement_header = "";
		$nama_sheet = $this->rpt_inputan->nama_sheet();
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year, $departement_header);
		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		echo base_url();
		echo "ini nama sheet";
		echo "<pre>";
		echo print_r($nama_sheet);
		echo "</pre>";
		echo "ini header";
		echo "<pre>";
		echo print_r($data);
		echo "</pre>";
		echo "ini detail";
		echo "<pre>";
		echo print_r($detail);
		echo "</pre>";



	}

	public function test_expoort_02()
	{
		$month = 9;
		$year =  2018;
		$spreadsheet = new Spreadsheet();
		$nama_sheet = $this->rpt_inputan->nama_sheet();
		$a = 0;

		foreach ($nama_sheet as $key) {
			$baris_tgl = 10;

		$departement_header = $key->departement;
		$sheet_new = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_new);
		//$spreadsheet->setActiveSheetIndex($a)->setCellValue('A1',$key->dept_desc);
		$spreadsheet->setActiveSheetIndex($a)->setTitle($key->dept_desc); // membuat nama sheet berdasarkan kode unit
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year, $departement_header);
		// keterangan header
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A1','NIK');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A2','Nama');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A3','Departement');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A4','Posisi');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A5','Basic Sallary');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A6','Uang Kehadiran');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A7','Insentive Kopi & Snack');
		$spreadsheet->setActiveSheetIndex($a)->setCellValue('A8','Grade');

		$data_array = $this->tanggal($month, $year);
			$no_tgl = 10;
			foreach ($data_array as $daray) {
				$spreadsheet->setActiveSheetIndex($a)->setCellValue('A10',$daray);
			$no_tgl++;
			}

			$i = 1;
			$abj_awl = 66;
			foreach ($data as $dt) {
			//$empcode = $dt->empcode;
			//$abj = strtoupper(chr($abj_awl));

			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A1", $dt->nik_pim);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A2", $dt->empname);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A3", $dt->dept_desc);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A4", $dt->position_desc);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A5", $dt->upah);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A6", $dt->kehadiran_pagi);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A7", $dt->uang_makan);
			$spreadsheet->setActiveSheetIndex($a)->setCellValue("A8", $dt->golongan);

			// kode warna 
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A50', 'IZIN/ALPA/MANGKIR')
			->getStyle('A50')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A51', 'OFF')
			->getStyle('A51')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A52', 'SAKIT')
			->getStyle('A52')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A53', 'HARI PENDEK')
			->getStyle('A53')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');

			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue('A54', 'KERJA HARI LIBUR')
			->getStyle('A54')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');



		$detail = $this->rpt_inputan->rpt_inputan_detail($month, $year, $empcode, $departement_header);
		$baris_dtl = 10;
		foreach ($detail as $ke) {
			// jika izin atau alfa mangkir maka warna merah
			if ($ke->attd_code == 'attd004' || $ke->attd_code == 'attd005') {
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour)
			->getStyle($abj.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('f44245');
			}
		elseif ($ke->attd_code == 'attd006') {
			// jika off warna biru
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour)
			->getStyle($abj.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('b7cff4');
			}
		elseif ($ke->attd_code == 'attd007') {
			// jika sakit maka kuning
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour)
			->getStyle($abj.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('ceb04e');
			}
			elseif ($ke->attd_code == 'attd002') {
			// jika hari pendek maka hijau
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour)
			->getStyle($abj.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('63bc2b');
			}
		elseif ($ke->attd_code == 'attd003') {
			// jika Kerja hari libur maka coklat
				$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour)
			->getStyle($abj.$baris_dtl)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('a57057');
			}
		else
		{
			$spreadsheet->setActiveSheetIndex($a)
			->setCellValue($abj.$baris_dtl, $ke->work_hour);
		}


			$baris_dtl++;	
		}


			$i++;
			$abj_awl++;
			}

			$a++;
		}


		/*$sheet_new = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'nama_dept'); // definisikan sheet baru
		$spreadsheet->addSheet($sheet_new);
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1','fucking shit');*/


			$nama_file = date("Y-m-d");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="MONTHLY KM BULAN.xlsx"');
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




	public function test_export()
	{
		$spreadsheet = new spreadsheet();
		
		$spreadsheet->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,5,'NIK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,5,'shit');
		$no_v = 3;
					$i=1; //parameter awal untuk perulangan nama table a1 a2 a3
					$v = $no_v; // perulangan unutk nomor cell baris selanjutnya karena baris selanjutnya juga mulai dari a1 a2 a3
					$hrf_a = chr(65); // menampilkan huruf a kecil

	for ($c=69; $c <= 90 ; $c++) { 
										$hrf_v = chr($c); // menampilkan A
										$cell = $hrf_a.$i; // menampilkan A1
										$setval = $hrf_v.$v; // menampilkan E3
												$spreadsheet->setActiveSheetIndex(0)->setCellValue($hrf_v.$i, "Holycrab ".$hrf_v.$i." ");

										$i++;
									}



			$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rpt_inputan_general_activity.xlsx"');
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

	public function test_last_array()
	{
		$month = 9;
		$year = 2018;
		$departement_header = 3;
		$data = $this->rpt_inputan->rpt_inputan_header($month, $year, $departement_header);
		// keterangan header
		/*echo "<pre>";
		echo print_r($data);
		echo "</pre>";*/
		$akhir = end($data);
		$cell = 65;
		$cell_a = 65;
		$row = 1;
		foreach ($data as $key) {
			$a = chr($cell);
			echo $key->empcode;
			echo $key->empname;
			echo "<br>";
			echo "huruf- ".$a.$row;
			echo "<br>";
	/*		if ($key == $akhir) {
				echo "this is last element of array";
			}*/

			if ($cell >= 67) {
				$setval = "A".chr($cell_a);
				echo "huru dbl- ".$setval;
				echo "<br>";
			$cell_a++;
			}
			$cell++;
		}
		
		//var_dump($key);
	}

	/*controller Closing*/
	public function closing_payroll()
	{

		/*buat parameter group accessrights di sini untuk di jadikan kondisi saat userlogin sudah di periksa maka di cek apakah dia termasuk dalam group hr yang di izinkan, jika tidak maka tidak akan bisa tampil halaman ini*/
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
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		$data['dept'] = $this->emp_attribute->dept();
		$data['empcode'] = $this->emp_rn();
		$data['title'] = 'Closing Payroll';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->emp_attribute->dd_empcode();
		$data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';
		
		//dd grade status
		$data['dd_emp_dept'] = $this->emp_attribute->dd_rpt_dept();
		$data['dd_emp_dept_select'] = $this->input->post('filter_dept') ? $this->input->post('filter_dept') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->emp_attribute->dd_emp_status();
		$data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';
		
		
			
        // dropdown untuk attd code
		$data['dd_attd_code'] = $this->emp_attribute->dd_attd_code();
        $data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';
		
        if ($this->ion_auth->in_group($group)) {
        	# code...
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_closing_payroll');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_closing_payroll',$data);
        }
    else
    {
			return show_error('You must be an administrator to view this page.');

    }

		}

	}
	/*end of closing*/

	public function do_closing()
	{
		$period = $this->input->post('f_period');
		$year = $this->input->post('f_year'); 
		$close_by = $this->input->post('f_input_by'); 
		//$dat = get_date_period(12, 2018);
		//print_r($dat);
		
		$cek = $this->cek_before_closing($period, $year);

		if ($cek == 1) {
			$data['inputerror'][] = 'f_period';
			$data['inputerror'][] = 'f_year';
			//$data['inputerror'][] = 'f_empcode';
			$data['error_string'][] = 'Data Sudah Terinput';
			$data['status'] = TRUE;

			// delete old file
			//$this->delete_all_before_closing($period, $year);
			//$this->add_closing($start_date, $end_date, $close_by);
			echo json_encode($data);
			exit();
			}
		else{
				// closing do here
				$this->add_closing($period, $year);
			}
			
		}
		
	public function add_closing($period, $year){
		$dat = get_date_period($period, $year);
		$start_date = $dat->start_date;
		$end_date = $dat->end_date;
		// get user session
		$obj_user = $this->ion_auth->user()->row();
		$close_by = $obj_user->username;

		$this->clo_pay->closing($start_date, $end_date, $close_by);	
		echo json_encode(array("status" => TRUE));
	}

	public function test()
	{
		//Stuff here

		$this->benchmark->mark('start');

		//Stuff suspected to be slow
	
		$this->benchmark->mark('end');
	
		echo $this->benchmark->elapsed_time('start', 'end');
	}

	public function cek_before_closing($period, $year)
	{
		$data = $this->clo_pay->cek_data($period, $year);
		if ($data == 0) {
			return $cek = 0;
			//echo "do stuff here!";
			//print_r($data);
		}
		else{
			return $cek = 1;
			//echo "you must delete all data first, and closing it!";
			//print_r($data);
		}
	}

	public function delete_all_before_closing($period, $year)
	{
		$this->clo_pay->delete_all($period, $year);
		echo json_encode(array("status" => TRUE));
	}

	/*controller Surat Perintah Lembur SPL*/
	public function emp_att()
	{

		/*buat parameter group accessrights di sini untuk di jadikan kondisi saat userlogin sudah di periksa maka di cek apakah dia termasuk dalam group hr yang di izinkan, jika tidak maka tidak akan bisa tampil halaman ini*/
		$group = array("hr","prod");
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
		$data['title'] = 'Employee Attendance';
		// dropdown untuk empcode
		$data['dd_empcode'] = $this->lov->dd_empcode();
        $data['empcode_selected'] = $this->input->post('f_empcode') ? $this->input->post('f_empcode') : '';

		// dropdown untuk emp status
		$data['dd_emp_status'] = $this->lov->dd_emp_status();
        $data['empcode_status_selected'] = $this->input->post('id_position') ? $this->input->post('id_position') : '';

        // dropdown untuk attd code
		$data['dd_attd_code'] = $this->lov->dd_attd_code();
		$data['attd_code_selected'] = $this->input->post('f_attd_code') ? $this->input->post('f_attd_code') : '';
		
		$data['dd_emp_dept'] = $this->rpt_gang->dd_rpt_dept();
        $data['dd_emp_dept_select'] = $this->input->post('f_dept') ? $this->input->post('f_dept') : '';
		
        if ($this->ion_auth->in_group($group)) { 
        	# code...
		$this->load->view('temp/title',$data);
		$this->load->view('temp/header');
		$this->load->view('temp/sidebar');
		$this->load->view('f_emp_att');
		$this->load->view('temp/footer');
		$this->load->view('notif');
		$this->load->view('ajax_emp_att',$data);
        }
		else
		{
				return show_error('You must be an administrator to view this page.');

		}

		}

	}
	/*end of spl*/

	public function emp_attd_list()
	{
		/*if ($this->input->post('filter_start_date')) {
			# code...
		$this->date_input($this->input->post('filter_start_date'));
		}*/
		$list = $this->attd->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $emp_attribute) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $emp_attribute->nik_pim;
			//$row[] = $emp_attribute->departement;
			$row[] = $emp_attribute->empname;
			$row[] = $emp_attribute->tanggal;
			$row[] = $emp_attribute->shift;
			$row[] = $emp_attribute->check_in;
			$row[] = $emp_attribute->check_out;
			$row[] = $emp_attribute->late;
			$row[] = $emp_attribute->overtime;
			$row[] = $emp_attribute->work_hour;
			$row[] = $emp_attribute->attd_code;
			/* $row[] = $this->date_indonesia($emp_attribute->attd_date); // change data format from database YYYY-MM-DD to DD-MM-YYYY
			$row[] = $emp_attribute->work_hour;
			$row[] = '<td class="table_data" data-row_id="" data-column_name="FirstName" contenteditable>'.$emp_attribute->total_jam_lembur.'</td>';
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_emp_attribute('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('."'".$emp_attribute->id_emp_act_sk."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		 */
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->attd->count_all(),
						"recordsFiltered" => $this->attd->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function download_data_presensi()
	{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		
		$start_date = date_input($this->input->post('f_start_date'));
		$end_date = date_input($this->input->post('f_end_date'));
		$dept_id = $this->input->post('f_dept_download');
		$inputby = $email;
		$empcode = $this->input->post('f_empcode');



		$data = array(
			"start_date" => $start_date,
			"end_date" => $end_date,
			"inputby" => $inputby
		);

		// conditional statment here
		if (isset($empcode)) {
			//echo "by empcode";
			$this->absen->download_data_presensi_by_empcode($start_date, $end_date, $dept_id, $empcode, $inputby);
			echo json_encode(array("status"=> TRUE));
		}
		else
		{
			//echo "flat";
			$this->absen->download_data_presensi($start_date, $end_date, $dept_id, $empcode, $inputby);
			echo json_encode(array("status"=> TRUE));
		}

		//echo json_encode(array("status"=> TRUE));
	}

	public function download_data_presensi_pro()
	{

		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;

		$start_date = date_input($this->input->post('f_start_date'));
		$end_date = date_input($this->input->post('f_end_date'));
		$dept_id = $this->input->post('f_dept_download');

		$inputby = $email;
		$empcode = $this->input->post('f_empcode');

		$data = array(
			"start_date" => $start_date,
			"end_date" => $end_date,
			"inputby" => $inputby
		);

		// conditional statment here
		if (isset($empcode)) {
			//echo "by empcode";
			$this->absen->download_data_presensi_pro_by_empcode($start_date, $end_date, $dept_id, $empcode, $inputby);
			echo json_encode(array("status"=> TRUE));
		}
		else
		{
			//echo "flat";
			$this->absen->download_data_presensi_pro($start_date, $end_date, $dept_id, $empcode, $inputby);
			echo json_encode(array("status"=> TRUE));
		}

	}

	public function import_from_faceprint_server()
	{
		$data = array(
			//"cd_c" => exec('copy_absen.bat'),
			//"cd" => exec('cd C:\Program Files(x86)\Att'),
			"copy_file" => exec('copy_absen.bat', $output),
			//"go_to_path" => exec('cd "C:\Program Files (x86)\SQLyog" '),
			//"import_db" => exec('sja.exe "C:\xampp\htdocs\hris\import_db_absensi.xml"   -l"C:\Users\server02\AppData\Roaming\SQLyog\sja.log" -s"C:\Users\server02\AppData\Roaming\SQLyog\sjasession.xml" '),
			"import_db" => exec('import_absen.bat', $hasil_import),
			"hasil" => $output,
			"hasil_copy" => $hasil_import,
			"status" => true
		);
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		echo json_encode($data);
	}

	public function import_from_faceprint_dev()
	{
		$data = array(
			
			"copy_file" => exec('copy_absen.bat', $output),
			//"go_to_path" => exec('cd "C:\Program Files (x86)\SQLyog" '),
			//"import_db" => exec('sja.exe "C:\xampp\htdocs\hris\scheduled_import_data_face_to_hris.xml"   -l"C:\Users\Gandhist\AppData\Roaming\SQLyog\sja.log" -s"C:\Users\Gandhist\AppData\Roaming\SQLyog\sjasession.xml" ', $hasil),
			"hasil_copy" => $output,
			"status" => true
		);
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		echo json_encode($data);
	}

	public function rpt_rooster()
	{
		$group = array("hr","prod");

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
				
				$data['dd_emp_dept'] = $this->rpt_gang->dd_rpt_dept();
				$data['dd_emp_dept_select'] = $this->input->post('departement') ? $this->input->post('departement') : '';

if ($this->ion_auth->in_group($group)) {
      
			$this->load->view('temp/title',$data);
			$this->load->view('temp/header');
			$this->load->view('temp/sidebar');
			$this->load->view('f_rpt_rooster_not_produksi', $data);
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

	public function tests()
	{
		$this->load->view('export_excel_monthly_absensi');
	}


	public function export_monthly_absensi()
	{
		$period = $this->input->post("periode");
		$year = $this->input->post("tahun");
		$dept_id = $this->input->post("f_dept");
		$print_date = $this->input->post("print_date");
		$dept_name = $this->_get_dept_name($dept_id);
		//$dept_id = 8;
		$start_date =get_date_period($period, $year)->start_date;
		$end_date = get_date_period($period, $year)->end_date;
		// simpan data tanggal dan nama hari dalam array

		// delete data duplicate 
		$this->absen->delete_duplicate_gang_activity($start_date, $end_date);


		// menampilkan nama hari
		$from = get_from_date_period($period, $year);
		$to = get_to_date_period($period, $year);
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$total = total_hari($period, $year);
		$batas = $c->format('%a');
		

			for ($i=0; $i <= $batas ; $i++) { 
			$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
			$dat=date("D", $date);
			$day[] = $dat;
			}

			for ($i=0; $i <= $batas ; $i++) { 
			$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
			$date=date("d", $date);
			$datee[] = $date;
			
			}
			
			$datee[] = array_push($datee, "-","MTD","S","I","A","C","<4JAM");
			$data_array = array($day, $datee);

			
		// end simpan data dalam array
		$spreadsheet = new spreadsheet();
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border

		$outlineArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A5:AP6')->applyFromArray($styleArray);

		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4','PRESENSI BULANAN MANPOWER DEPARTEMEN '.$dept_name.' ');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5','PERIODE : '.$start_date.' s/d '.$end_date);
		
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A6','NO');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B6','NAMA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C6','NIK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D6','JABATAN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E6','ITEM');
		
		
		// deret tanggal dan nama hari
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data_array,  // The data to set
			NULL,        // Array values with this value will not be set
			'F5'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		$shit = $spreadsheet->setActiveSheetIndex(0)->getCell('AH489');
		if ($shit = "S") {
			$spreadsheet->setActiveSheetIndex(0)->getStyle("AH489")->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
		}



		$data = $this->absen->get_empcode_by_dept($period,$year,$dept_id);
		//$data_mo = $this->absen->test_date($start_date, $end_date, $period, $year, $dept_id);

	
		$no = 1;
		$baris = 7;

				
		//$data_monthly = $this->absen->get_data_montly_absensi($start_date, $end_date, $period, $year, "1900403");
		$data_monthly = $this->absen->test_date($start_date, $end_date, $period, $year, $dept_id);
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data_monthly,  // The data to set
			NULL,        // Array values with this value will not be set
			'B7'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		


			$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rpt_monthly_absensi_'.$dept_name.'_'.$period.'_'.$year.'.xlsx"');
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

	public function export_monthly_absensi_insentive()
	{
		$start_date = date_input($this->input->post("f_start_date"));
		$end_date = date_input($this->input->post("f_end_date"));
		$dept_id = $this->input->post("f_dept");
		$dept_name = $this->_get_dept_name($dept_id);
		//$dept_id = 8;
		
		// delete data duplicate 
		$this->absen->delete_duplicate_gang_activity($start_date, $end_date);

		// menampilkan nama hari
		$from =  date_input($this->input->post("f_start_date"));
		$to =  date_input($this->input->post("f_end_date"));
		$a = date_create(date("Y-m-d",strtotime($from)));
		$b = date_create(date("Y-m-d",strtotime($to)));
		$c = date_diff($a,$b);
		$total = total_hari($period, $year);
		$batas = $c->format('%a');
		

			for ($i=0; $i <= $batas ; $i++) { 
			$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
			$dat=date("D", $date);
			$day[] = $dat;
			}

			for ($i=0; $i <= $batas ; $i++) { 
			$date = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+$i,date("Y",strtotime($from)));
			$date=date("d", $date);
			$datee[] = $date;
			
			}
			
			$tot_day = $batas +1;
			switch ($tot_day) {
				case 32:
				$datee[] = array_push($datee, "MTD","S","I","A","C","<4JAM");
				break;
				case 31:
				$datee[] = array_push($datee, "-","MTD","S","I","A","C","<4JAM");
				break;
				case 30:
				$datee[] = array_push($datee, "-","-","MTD","S","I","A","C","<4JAM");
				break;
				case 29:
				$datee[] = array_push($datee, "-","-","-","MTD","S","I","A","C","<4JAM");
				break;
				case 28:
				$datee[] = array_push($datee, "-","-","-","-","MTD","S","I","A","C","<4JAM");
				break;
			}
			// jika 32 hari tidak ada strip
			// jika 31 hari maka - 1
			// jika 30 hari maka - 2
			// jika 29 hari maka - 3
			// jika 28 hari maka - 4
			$data_array = array($day, $datee);

			
		// end simpan data dalam array
		$spreadsheet = new spreadsheet();
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border

		$outlineArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A5:AQ6')->applyFromArray($styleArray);

		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4','PRESENSI BULANAN MANPOWER DEPARTEMEN '.$dept_name.' ');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5','PERIODE : '.$start_date.' s/d '.$end_date);
		
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A6','NO');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B6','NAMA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C6','NIK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D6','JABATAN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E6','ITEM');
		
		
		// deret tanggal dan nama hari
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data_array,  // The data to set
			NULL,        // Array values with this value will not be set
			'F5'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		$shit = $spreadsheet->setActiveSheetIndex(0)->getCell('AH489');
		if ($shit = "S") {
			$spreadsheet->setActiveSheetIndex(0)->getStyle("AH489")->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
		}



		//$data = $this->absen->get_empcode_by_dept($period,$year,$dept_id);
		//$data_mo = $this->absen->test_date($start_date, $end_date, $period, $year, $dept_id);

	
		$no = 1;
		$baris = 7;

				
		//$data_monthly = $this->absen->get_data_montly_absensi($start_date, $end_date, $period, $year, "1900403");
		$data_monthly = $this->absen->insentive($start_date, $end_date, $dept_id);
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data_monthly,  // The data to set
			NULL,        // Array values with this value will not be set
			'B7'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		


			$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rpt_monthly_absensi_insentive'.$dept_name.'_'.$period.'_'.$year.'.xlsx"');
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

	private function _get_dept_name($dept_id)
	{
		$data = $this->lov->get_dept_name($dept_id);
		$departement =  $data[0]['dept_desc'];
		return $departement;
	}

	public function rekap_kopi()
	{
		$empcode = $this->input->post('filter_empcode');
		$dept_id = $this->input->post('filter_dept');
		$position_id = $this->input->post('filter_position');
		$month = $this->input->post('filter_period');
		$year = $this->input->post('filter_year');
		$print_date = $this->input->post('print_date');

		$start_date =get_date_period($month, $year)->start_date;
		$end_date = get_date_period($month, $year)->end_date;
		$data = $this->rpt_slip_gaji->rekap_kopi($start_date, $end_date);
		//var_dump($data);
		$spreadsheet = new spreadsheet();

		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border
		$total_baris = count($data)+10;

		$bold = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'FFA0A0A0',
				],
				'endColor' => [
					'argb' => 'FFFFFFFF',
				],
			],
		];
		$bold_font = [
			'font' => [
				'bold' => true,
			],
		];
		// nomor 
		$baris = 11;
		for ($i=1; $i <= $total_baris-10 ; $i++) { 
			$spreadsheet->getActiveSheet()->setCellValue('A'.$baris.'',''.$i.'');
			$baris++;
		}
		
		$spreadsheet->getActiveSheet()->getStyle('A10:J10')->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->setCellValue('A6','REKAPAN INSENTIF KOPI & SNACK');
		$spreadsheet->getActiveSheet()->setCellValue('A7','PERIODE '.$month.' '.$year.' ');

		// bold title
		$spreadsheet->getActiveSheet()->getStyle('A6:A7')->applyFromArray($bold_font);

		// center 
		$spreadsheet->getActiveSheet()->getStyle('A6:A7')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A6:A7');

		// autowidth
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

		$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:J'.$total_baris.'')->applyFromArray($styleArray);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A10','No');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B10','Nama');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C10','Register');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D10','Departement');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E10','Jabatan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F10','Date Join');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G10','Golongan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H10','Hari Kerja');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I10','Variance');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('J10','Total');

		// merge judul
		$spreadsheet->getActiveSheet()->mergeCells('A6:K6');
		$spreadsheet->getActiveSheet()->mergeCells('A7:K7');

		
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$logo =  base_url('assets/logo.png');
		$drawing->setPath('./assets/logo.png'); // set images path here
		$drawing->setCoordinates('A1');
		$drawing->setWorksheet($spreadsheet->getActiveSheet());

		// deret tanggal dan nama hari
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data,  // The data to set
			NULL,        // Array values with this value will not be set
			'B11'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rekap_uang_kopi'.$nama_file.'.xlsx"');
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

	public function rekap_uang_makan()
	{
		$empcode = $this->input->post('filter_empcode');
		$dept_id = $this->input->post('filter_dept');
		$position_id = $this->input->post('filter_position');
		$month = $this->input->post('filter_period');
		$year = $this->input->post('filter_year');
		$print_date = $this->input->post('print_date');

		$start_date =get_date_period($month, $year)->start_date;
		$end_date = get_date_period($month, $year)->end_date;
		$data = $this->rpt_slip_gaji->rekap_uang_makan($start_date, $end_date);
		// JUMLAH DATA
		$total_baris = count($data)+10;
		//var_dump($data);
		$spreadsheet = new spreadsheet();
		// ARRAY ALL BORDER
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '1e232b'],
				],
			],
		]; //array untuk membuat all border
		$spreadsheet->setActiveSheetIndex(0)->getStyle('A10:J'.$total_baris.'')->applyFromArray($styleArray);

		// AUTOWIDHT
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

		// GAMBAR
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$logo =  base_url('assets/logo.png');
		$drawing->setPath('./assets/logo.png'); // set images path here
		$drawing->setCoordinates('A1');
		$drawing->setWorksheet($spreadsheet->getActiveSheet());
		

		// JUDUL 
		$spreadsheet->getActiveSheet()->setCellValue('A6','REKAPAN UANG MAKAN');
		$spreadsheet->getActiveSheet()->setCellValue('A7','PERIODE '.$month.' '.$year.' ');
		// JUDUL CENTER 
		// center 
		$spreadsheet->getActiveSheet()->getStyle('A6:A7')
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A6:A7');
		// MERGE JUDUL
		$spreadsheet->getActiveSheet()->mergeCells('A6:K6');
		$spreadsheet->getActiveSheet()->mergeCells('A7:K7');

		// ARRAY BOLD
		$bold_font = [
			'font' => [
				'bold' => true,
			],
		];
		// BOLD JUDUL
		$spreadsheet->getActiveSheet()->getStyle('A6:A7')->applyFromArray($bold_font);

		// ARRAY BOLD JUDUL KOLOM
		$bold = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'FFA0A0A0',
				],
				'endColor' => [
					'argb' => 'FFFFFFFF',
				],
			],
		];

		// BOLD JUDUL KOLOM
		$spreadsheet->getActiveSheet()->getStyle('A10:J10')->applyFromArray($bold);

		// nomor 
		$baris = 11;
		for ($i=1; $i <= $total_baris-10 ; $i++) { 
			$spreadsheet->getActiveSheet()->setCellValue('A'.$baris.'',''.$i.'');
			$baris++;
		}





		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A10','No');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B10','Nama');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C10','Register');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D10','Departement');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E10','Jabatan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F10','Date Join');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G10','Golongan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H10','Hari Kerja');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I10','Variance');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('J10','Total');

		
		

		// deret tanggal dan nama hari
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data,  // The data to set
			NULL,        // Array values with this value will not be set
			'B11'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rekap_uang_makan'.$nama_file.'.xlsx"');
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

	public function rekap_sallary_xls()
	{
		$empcode = $this->input->post('filter_empcode');
		$dept_id = $this->input->post('filter_dept');
		$position_id = $this->input->post('filter_position');
		$month = $this->input->post('filter_month');
		$year = $this->input->post('filter_year');
		$print_date = $this->input->post('print_date');

		$start_date =get_date_period($month, $year)->start_date;
		$end_date = get_date_period($month, $year)->end_date;
		$data = $this->rpt_slip_gaji->slip_gaji_excel($start_date, $end_date);
		//var_dump($data);
		$spreadsheet = new spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1','Period');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1','Year');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1','Date Join');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D1','Bank Name');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E1','Account Name');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F1','Account No');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G1','Empcode');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H1','Empname');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I1','Nik_pim');
		//$spreadsheet->setActiveSheetIndex(0)->setCellValue('J1','position');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('J1','position_desc');
		//$spreadsheet->setActiveSheetIndex(0)->setCellValue('L1','grade');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('K1','golongan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('L1','upah');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('M1','kehadiran_pagi');
		//$spreadsheet->setActiveSheetIndex(0)->setCellValue('P1','dept_id');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('N1','dept_desc');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('O1','Total SIA');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('P1','pot_prop');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('Q1','gaji_setelah_sia');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('R1','deduction');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('S1','allowance');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('T1','jamsostek');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('U1','jpk');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('V1','hk_dibayar');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('W1','hk_uang_makan_ramadhan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('X1','total_uang_makan_ramadhan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('Y1','kehadiran_bulanan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('Z1','upah_perjam');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AA1','jam_lembur');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AB1','uang_lembur');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AC1','insentive_snack');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AD1','total_pendapatan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AE1','total_potongan');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('AF1','gaji_bersih');


		// deret tanggal dan nama hari
		$spreadsheet->getActiveSheet()
		->fromArray(
			$data,  // The data to set
			NULL,        // Array values with this value will not be set
			'A2'         // Top left coordinate of the worksheet range where
						//    we want to set these values (default is A1)
		);

		$nama_file = date("Y-m-d");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rekap_gaji'.$nama_file.'.xlsx"');
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


	
	
	

	








}
/*end of controller*/