<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vm_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */
    
	var $table = 'vehicle_master';
	var $column_order = array('vehicle_code', 'nap', 'nomor_plat', 'code_unit', 'pic_code', 'year', 'date_receive',null); //set column field database for datatable orderable
	var $column_search = array('vehicle_code', 'nap', 'nomor_plat', 'code_unit', 'pic_code', 'type', 'year', 'date_receive'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('date_receive' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		//add custom filter here
        /*if($this->input->post('f_empcode_f'))
            {
                $this->db->where('gang_activity.empcode', $this->input->post('f_empcode_f'));
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('gang_activity.attd_date BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }*/
        /*
        unremarks this for additional form filter data
        if($this->input->post('filter_dept'))
        {
            $this->db->like('emp_master.departement', $this->input->post('filter_dept'));
        }
        if($this->input->post('filter_position'))
        {
            $this->db->like('emp_master.employeetype', $this->input->post('filter_position'));
        }
        if($this->input->post('filter_emp_status'))
        {
            $this->db->like('emp_master.employeetype', $this->input->post('filter_emp_status'));
        }
        if($this->input->post('filter_start_date'))
        {
            $this->db->like('emp_master.companybegin', $this->input->post('filter_start_date'));
        }*/
        
        /*if($this->input->post('filter_emp_status'))
        {
            $this->db->like('address', $this->input->post('address'));
        }*/

        $this->db->select('id_vehicle, vehicle_code, nap, nomor_plat, code_unit, get_empname(pic_code) as pic_code, type, year, ownership, status_unit, date_receive, no_frame, no_machine, cylinder, remarks');
        $this->db->from($this->table);
        /*$this->db->join('((select empcode, empname, departement from emp_master where is_deleted != "1" OR is_deleted is null) as emp_master)','gang_activity.empcode = emp_master.empcode');
        $this->db->join('master_dept','emp_master.departement = master_dept.departement');
        $this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');*/
        $this->db->where('active','1');
        $this->db->order_by('date_receive','desc');


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
		//$this->db->from($this->table);
        $this->_get_datatables_query();

		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_vehicle',$id);
		$query = $this->db->get();

		return $query->row();
	}

    public function cek_data($id, $date)
    {
        $this->db->from($this->table);
        $this->db->where('empcode ="'.$id.'" AND attd_date ="'.$date.'"');
        $query = $this->db->get();
        //$row = $query->row();
        
        return $query->row();
    }

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_vehicle', $id);
		$this->db->delete($this->table);
	}
	public function m_cetak($id)
	{
		$this->db->where('id_vehicle',$id);
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

	public function dept()
	{
		$query = $this->db->query("SELECT departement, dept_desc FROM MASTER_DEPT");
		return $query->result();

	}


	// model untuk dropdown employee code
/*	function dd_empcode()
    {
        // ambil data dari db
        $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd['*'] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }*/

        // model untuk dropdown employee code
    function dd_empcode()
    {
        // ambil data dari db
       /* $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('*');
        $this->db->from('emp_master');
        $this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");
        $result = $this->db->get();
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }



    // model untuk dropdown employee status
    function dd_emp_status()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->not_like('id_position','pos');
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

    // report

     // model untuk dropdown employee code
	function dd_rpt_empcode()
    {
        // ambil data dari db
        $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        $dd[''] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }


    // model untuk dropdown employee status
    function dd_rpt_emp_status()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->not_like('id_position','pos');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        $dd[''] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }

    // dropdown attd code
    function dd_attd_code()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('id_position','attd');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Attendace Code'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }

    // dropdown Allowance Deduction Code
    function dd_adhoc()
    {
        // ambil data dari db
        $this->db->order_by('allowded_Code', 'asc');
        $result = $this->db->get('master_adhoc');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Attendace Code'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->allowded_code] = $row->allowded_code .$a. $row->description;
            }
        }
        return $dd;
    }

    //dd departement
    function dd_rpt_dept()
    {
        // ambil data dari db
        $this->db->order_by('departement', 'asc');
        $result = $this->db->get('master_dept');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        $dd[''] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->departement] = $row->departement .$a. $row->dept_desc;
            }
        }
        return $dd;
    }

    // model untuk dropdown employee id position
    function dd_rpt_emp_position()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('id_position','pos');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        $dd[''] = 'ALL'; //untuk placeholder
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

