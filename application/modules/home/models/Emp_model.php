<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'emp_master';
	var $column_order = array('empcode','empname','position','employeetype','companybegin',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','position','employeetype','companybegin'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		//$this->db->where_in('site_id','2102','2202');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('empcode',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert("emp_master", $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('empcode', $id);
		$this->db->delete($this->table);
	}
	public function m_cetak($id)
	{
		$this->db->where('empcode',$id);
		return $this->db->get($this->table);
	
	}
	public function last_id()
	{
		$this->db->select('empcode');
		$this->db->limit(1);
		$this->db->order_by('empcode', 'DESC');
		$query = $this->db->get('emp_master');
		return $query->row();
	}

	public function karyawan_baru()
	{
		$query = $this->db->query('select COUNT(empcode) AS jumlah FROM emp_master WHERE DATE_FORMAT(companybegin,"%Y-%m") = DATE_FORMAT(CURDATE(), "%Y-%m")');
		return $query->result();
	}


	/*fungsi model ini akan menampilkan jumlah karyawan yang akan habis kontrak pada notifikasi di header*/
	public function notif()
	{
		//SELECT COUNT(*) AS total FROM document_status
		/* query akan menampilkan kontrak karyawan selain status closed, dan hanya akan menampilkan status show_notif 1 jika due datenya <= 30 hari dari end_date contract
 untuk yang due date nya minus (-) diharuskan di closed statusnya agar tidak tampil di notifikasi*/ 
		$query = $this->db->query('
select COUNT(show_notif) AS notif FROM 
(SELECT 
  contract_no,
  sign_date,
  empcode,
  get_empname (empcode) AS empname,
  start_date,
  end_date,
  end_date - INTERVAL 60 DAY AS day_reminder,
  CURDATE() AS tanggal_sekarang,
  DATEDIFF(end_date, CURDATE()) AS due_date,
  STATUS AS status_asli,
  CASE
  WHEN DATEDIFF(end_date, CURDATE()) <= 60 THEN "1"
  ELSE "0"
  END AS show_notif
FROM
  document_status 
WHERE STATUS != "closed"
AND DATEDIFF(end_date, CURDATE()) >= 0) a
WHERE show_notif = 1
			');
		return $query->result();
	}

	public function list_notif_exp()
	{
		$query = $this->db->query('
select a.empcode, empname, end_date, due_date FROM 
(SELECT 
  contract_no,
  sign_date,
  empcode,
  get_empname (empcode) AS empname,
  start_date,
  end_date,
  end_date - INTERVAL 60 DAY AS day_reminder,
  CURDATE() AS tanggal_sekarang,
  DATEDIFF(end_date, CURDATE()) AS due_date,
  STATUS AS status_asli,
  CASE
  WHEN DATEDIFF(end_date, CURDATE()) <= 60 THEN "1"
  ELSE "0"
  END AS show_notif
FROM
  document_status 
WHERE STATUS != "closed"
AND DATEDIFF(end_date, CURDATE()) >= 0) a
where show_notif = "1"
ORDER BY due_date ASC
-- query akan menampilkan kontrak karyawan selain status closed, dan hanya akan menampilkan status show_notif 1 jika due datenya <= 30 hari dari end_date contract
-- untuk yang due date nya minus (-) diharuskan di closed statusnya agar tidak tampil di notifikasi 
			');
		//$query = $this->db->get();
		return $query->result();

	}


}

