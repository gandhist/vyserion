<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_employee extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_distrik');
	}
	public function index()
	{
		$data['data_empmaster'] = $this->m_distrik->get_all_item();
		$this->load->view('v_header');
		$this->load->view('v_sidebar');
		$this->load->view('v_content', $data);
		$this->load->view('v_footer');
	}

	function get_empname()
	{

		$return_arr = array();
		$row_array = array();
		$text = $this->input->get('text');
		$barang = $this->db->select("*")
											/* ->from("tb_barang")
											 ->like("n_barang", $text)
											 ->or_like("k_barang",$text)
											 ->get();*/
											 ->from("empmaster")
											 ->like("empname", $text)
											 ->or_like("empcode",$text)
											 ->get();
		if($barang->num_rows() > 0)
		{

			foreach($barang->result_array() as $row)
			{
				$row_array['id'] = $row['empcode'];
				$row_array['text'] = utf8_encode("<strong>[".$row['empcode'] ."]</strong> $row[empname]");
				array_push($return_arr,$row_array);
			}

		}
		
		echo json_encode(array("results" => $return_arr ));
	}

	function get_info()
	{
		$id = $this->input->get('id');
		
		$info = $this->db->select("*")
										 ->from("empmaster")
										 ->where("empcode",$id)
										 ->get()
										 ->row();
		echo json_encode($info);
										 
	}

	function add_employee()
	{
		$this->input->post('empcode');
		$nama = $this->input->post('empcode');
		echo $nama;
	}
}
