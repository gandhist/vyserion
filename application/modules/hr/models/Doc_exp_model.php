<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_exp_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'document_status';
	var $column_order = array('a.empcode','a.empname','a.contract_no','a.star_date','a.end_date','a.sign_date','a.day_reminder','a.due_date','a.status',null); //set column field database for datatable orderable
	var $column_search = array('a.empcode','a.empname','a.contract_no','a.status'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('start_date' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		// mysql query
		/*
SELECT contract_no, sign_date, empcode, empname, start_date, end_date, day_reminder, due_date, STATUS FROM 
(SELECT 
  contract_no,
  sign_date,
  empcode,
  get_empname (empcode) AS empname,
  start_date,
  end_date,
  end_date - INTERVAL 30 DAY AS day_reminder,
  -- CURDATE() AS tanggal_sekarang,
  DATEDIFF(end_date, CURDATE()) AS due_date,
  STATUS AS STATUS,
  CASE
  WHEN DATEDIFF(end_date, CURDATE()) <= 30 THEN "1"
  ELSE "0"
  END AS show_notif
FROM
  document_status 
WHERE STATUS != "closed") a
		*/
		//$this->db->from($this->table);
		$this->db->select('a.contract_no, a.contract_id, b.employeetype, a.sign_date, a.empcode, b.nik_pim, a.empname, a.start_date, a.end_date, a.day_reminder, a.due_date, a.status');
		$this->db->from('(SELECT 
						  contract_no,
						  contract_id,
						  sign_date,
						  empcode,
						  get_empname (empcode) AS empname,
						  start_date,
						  end_date,
						  (end_date - INTERVAL 60 DAY) AS day_reminder,
						  DATEDIFF(end_date, CURDATE()) AS due_date,
						  STATUS AS status,
						  CASE
						  WHEN DATEDIFF(end_date, CURDATE()) <= 60 THEN "1"
						  ELSE "0"
						  END AS show_notif
						FROM
						  document_status 
						WHERE STATUS != "closed") a, (SELECT b.nik_pim, a.empcode, MAX(a.start_date) AS start_date, a.employeetype FROM hr_hist_status a LEFT JOIN emp_master b ON a.empcode = b.empcode GROUP BY empcode) b');
$this->db->where('a.empcode = b.empcode');		
		$this->db->where_in('a.show_notif','1');
		/*$this->db->where('a.due_date >= 0');*/
		$this->db->order_by('a.due_date','ASC');

		/*$this->db->select('contract_no,
			contract_id,
  sign_date,
  empcode,
  GET_EMPNAME(empcode) AS empname,
  start_date,
  end_date,
  (end_date - INTERVAL 30 DAY) AS day_reminder,
  DATEDIFF(end_date, CURDATE()) AS due_date,
  status,
  CASE
  WHEN DATEDIFF(end_date, CURDATE()) <= 30 THEN "1"
  ELSE "0"
  END AS show_notif');
		$this->db->from('document_status');
		$this->db->where_not_in('status','closed');*/
		//$this->db->where('status','1');

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
        //$this->db->where('is_deleted != "1" OR is_deleted is null ');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('contract_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert("document_status", $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('contract_id', $id);
		$this->db->delete($this->table);
	}
	public function m_cetak($id)
	{
		$this->db->where('contract_id',$id);
		return $this->db->get($this->table);
	
	}
	public function last_id()
	{
		$this->db->select('departement');
		$this->db->limit(1);
		$this->db->order_by('departement', 'DESC');
		$query = $this->db->get('master_dept');
		return $query->row();
	}

		// model untuk dropdown employee code
	function dd_empcode()
    {
        // ambil data dari db
        //$this->db->order_by('empcode', 'asc');
        //$empcode_inputed = array($this->empcode_in_gs());
        // filter mencari emmcode not in hr_hist_status
       /* $result = $this->db->query("select empcode from hr_hist_status")->result_array();
        $empgs = array();
    foreach($result as $item) {
        $empgs[] = $item['empcode'];         
    }
    $a = implode(',', $empgs);
    // filter mencari emmcode not in hr_hist_status
        $this->db->where_not_in('empcode', $a);
        $result = $this->db->get('emp_master');*/
        //$result = $this->db->query("select * from emp_master");

       $this->db->select('*');
$this->db->from('emp_master');
$this->db->where("`empcode` NOT IN (select distinct(empcode) from hr_hist_status union ALL select distinct(empcode) from hr_termination)");

$result = $this->db->get();
        /*$this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
    else
    {
    	$dd = '*-Data not Found-*';
    }
        return $dd;
    }

    function dd_empcode_hrhist()
    {
    	$this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }

    function empcode_in_gs()
    {
    	$this->db->select('empcode');
    	$query = $this->db->get('hr_hist_status');
    	return $query->result();

    }

    function model_exp_email()
    {
    	$this->db->select('a.contract_no, COALESCE(b.employeetype,"N/A") AS employeetype, a.contract_id, a.sign_date, a.empcode, a.nik_pim, a.empname, a.start_date, a.end_date, a.day_reminder, a.due_date, a.status');
		$this->db->from('(SELECT 
						  a.contract_no,
						  a.contract_id,
						  a.sign_date,
						  a.empcode,
						  b.nik_pim,
						  get_empname (a.empcode) AS empname,
						  a.start_date,
						  a.end_date,
						  (a.end_date - INTERVAL 7 DAY) AS day_reminder,
						  DATEDIFF(a.end_date, CURDATE()) AS due_date,
						  a.status AS STATUS,
						  CASE
						    WHEN DATEDIFF(end_date, CURDATE()) <= 7 
						    THEN "1" 
						    ELSE "0" 
						  END AS show_notif 
						FROM
						  document_status a LEFT JOIN emp_master b ON a.empcode = b.empcode
						WHERE a.status != "closed" ) a');
		$this->db->join('hr_hist_status b','a.empcode = b.empcode');		
		$this->db->where_in('a.show_notif','1');
		/*$this->db->where('a.due_date >= 0');*/
		$this->db->order_by('a.due_date','ASC');
		$query = $this->db->get();
		return $query->result();
    }

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
  end_date - INTERVAL 7 DAY AS day_reminder,
  CURDATE() AS tanggal_sekarang,
  DATEDIFF(end_date, CURDATE()) AS due_date,
  STATUS AS status_asli,
  CASE
  WHEN DATEDIFF(end_date, CURDATE()) <= 7 THEN "1"
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

   


}

