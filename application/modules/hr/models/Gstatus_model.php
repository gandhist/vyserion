<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gstatus_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'hr_hist_status';
	var $column_order = array('hr_hist_status.empcode','emp_master.empname','hr_hist_status.start_date','master_position.position_desc',null); //set column field database for datatable orderable
	var $column_search = array('hr_hist_status.empcode','emp_master.empname','master_position.position_desc'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('hr_hist_status.empcode' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		// mysql query
		/*select hr_hist_status.empcode, emp_master.empname, hr_hist_status.start_date, hr_hist_status.id_position, master_position.position_desc,
hr_hist_status.employeetype, a.position_desc
from hr_hist_status
LEFT JOIN emp_master
ON hr_hist_status.empcode = emp_master.empcode
JOIN master_position
ON hr_hist_status.id_position = master_position.id_position
JOIN master_position as A
on hr_hist_status.employeetype = A.id_position*/
		//$this->db->from($this->table);
		$this->db->select('hr_hist_status.empcode, emp_master.nik_pim , emp_master.empname, hr_hist_status.start_date, hr_hist_status.id_position, master_position.position_desc,
hr_hist_status.employeetype, a.position_desc as emp_type');
		$this->db->from($this->table);
		$this->db->join('emp_master', 'hr_hist_status.empcode = emp_master.empcode','left');
		$this->db->join('master_position', 'hr_hist_status.id_position = master_position.id_position');
		$this->db->join('master_position as a', 'hr_hist_status.employeetype = a.id_position','left');
		//diremarks dikarenakan employee type di grade status belum di update, diantisipasi menggunakan left join
		// $this->db->join('master_position as a', 'hr_hist_status.employeetype = A.id_position');
        $this->db->where('hr_hist_status.is_deleted != "1" OR hr_hist_status.is_deleted is NULL');
        //$this->db->where('hr_hist_status.is_deleted != "1" OR hr_hist_status.is_deleted is null');
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
        $this->db->where('is_deleted != "1" OR is_deleted is null ');
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
		$this->db->insert("hr_hist_status", $data);
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

    // model untuk dropdown employee status
    function dd_emp_status()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('position_desc','karyawan');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'id_position'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }

    // model untuk dropdown employee id position
    function dd_emp_position()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('id_position','pos');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'id_position'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }


}

