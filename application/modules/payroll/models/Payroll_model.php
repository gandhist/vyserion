<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'gang_activity';
	var $column_order = array('emp_master.nik_pim', 'emp_master.empname', 'master_dept.dept_desc', 'gang_activity.attd_date', 'gang_activity.attd_code', 'gang_activity.overtime', 'gang_activity.remarks',null); //set column field database for datatable orderable
	var $column_search = array('emp_master.nik_pim', 'emp_master.empname', 'master_dept.dept_desc', 'gang_activity.attd_date', 'gang_activity.attd_code'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('gang_activity.inputdate' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		//add custom filter here
        if($this->input->post('f_empcode_f'))
            {
                $this->db->where('gang_activity.empcode', $this->input->post('f_empcode_f'));
			}
		if (is_numeric($this->input->post('f_mass_update_f'))) {
				$this->db->where('gang_activity.is_mass_update', $this->input->post('f_mass_update_f'));
        }
        if ($this->input->post('filter_wh')) {
                $this->db->where('gang_activity.work_hour', $this->input->post('filter_wh'));
        }
        if ($this->input->post('f_attd_code_f')) {
                $this->db->where('gang_activity.attd_code',$this->input->post('f_attd_code_f'));
        }
        if ($this->input->post('f_gang_f')) {
                $this->db->where('c.id_gang',$this->input->post('f_gang_f'));
		}
		if ($this->input->post('f_shift')) {
			$this->db->where('gang_activity.shift',$this->input->post('f_shift'));
	}
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('gang_activity.attd_date BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }
      

        $this->db->select('gang_activity.empcode, gang_activity.shift, emp_master.nik_pim, c.id_gang, gang_activity.total_jam_lembur, gang_activity.work_hour, emp_master.empname, master_dept.dept_desc, gang_activity.attd_date, master_attd_code.attd_desc, gang_activity.overtime, gang_activity.remarks, gang_activity.id_emp_act_sk,gang_activity.attd_code');
        $this->db->from($this->table);
        $this->db->join('((select empcode, nik_pim, empname, departement from emp_master where is_deleted != "1" OR is_deleted is null) as emp_master)','gang_activity.empcode = emp_master.empcode');
        $this->db->join('master_dept','emp_master.departement = master_dept.departement');
        $this->db->join('master_attd_code','gang_activity.attd_code = master_attd_code.attd_code','left');
        $this->db->join('gang_master c','c.empcode = emp_master.empcode','left');
        $this->db->order_by('gang_activity.attd_date','desc');
        $this->db->where('gang_activity.is_deleted != "1"');
        $this->db->limit('13000');


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

	private function _rpt_get_datatables_query()
	{

		 //add custom filter here
        if($this->input->post('country'))
        {
            $this->db->where('country', $this->input->post('country'));
        }
        if($this->input->post('FirstName'))
        {
            $this->db->like('FirstName', $this->input->post('FirstName'));
        }
        if($this->input->post('LastName'))
        {
            $this->db->like('LastName', $this->input->post('LastName'));
        }
        if($this->input->post('address'))
        {
            $this->db->like('address', $this->input->post('address'));
        }

		$this->db->select('emp_master.*,master_position.position_desc');
		$this->db->from($this->table);
		$this->db->join('master_position','emp_master.employeetype = master_position.id_position');
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
		$this->db->where('id_emp_act_sk',$id);
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
		$this->db->insert("gang_activity", $data);
		return $this->db->insert_id();
	}

    public function cek_data_master_copy($start_date, $end_date)
    {
        $query = $this->db->query("select empcode, attd_date, 'attd001' AS  attd_code FROM gang_activity WHERE empcode = '1800250' AND attd_date BETWEEN '".$start_date."' AND '".$end_date."';");
        $this->db->cache_on();
        return $query->row();
    }

    public function cek_data_current($period, $year)
    {
        $query = $this->db->query("select MONTH(attd_date) AS bulan FROM gang_activity WHERE MONTH(attd_date) = ".$period." and YEAR(attd_date) = ".$year." GROUP BY empcode; ");
        return $query->row();
    }

    public function copy_data($empcode, $start_date, $end_date)
    {
        $this->db->query("insert INTO gang_activity (empcode, attd_date, attd_code, inputby)
select '".$empcode."' AS empcode, attd_date, 'attd001' AS  attd_code, 'copied' FROM gang_activity WHERE empcode = '1800250' and attd_date BETWEEN '".$start_date."' AND '".$end_date."';");
        $this->db->cache_on();
        return $this->db->insert_id();
    }

    public function get_empcode_by_period_gang_activity($start_date, $end_date)
    {
       $query = $this->db->query("select DISTINCT(empcode) AS empcode FROM gang_activity WHERE  empcode != '1800250' AND attd_date BETWEEN '".$start_date."' AND '".$end_date."'");
        return $query->result_array();
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

	public function dept()
	{
		$query = $this->db->query("SELECT departement, dept_desc FROM master_dept");
		return $query->result();

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


	// model untuk dropdown employee code
	function dd_empcode()
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
    }

   function get_member_gang($id_gang)
   {
       $query = $this->db->query(" select empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND active = 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY)");
       return $query->result_array();
   }

   function get_gang_by_empcode($empcode)
   {
	   $query = $this->db->query("select id_gang FROM gang_master WHERE empcode = '".$empcode."' and active = 1 ");
	   return $query->result_array();
   }

   function get_member_gang_is_mass_update($id_gang, $date)
   {
       $query = $this->db->query("select empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND empcode IN (SELECT empcode FROM gang_activity WHERE attd_date = '".$date."' AND is_mass_update = 1 AND empcode IN (SELECT empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND active = 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY))
       )");
       return $query->result_array();
   }

   // mendapatkan member gang yang sudah terinput namun tidak dengan kondisi sia pada tanggal tersebut
   function get_member_gang_is_working($id_gang, $date)
   {
       $query = $this->db->query("select empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND empcode NOT IN (SELECT empcode FROM gang_activity WHERE attd_date = '".$date."' AND is_mass_update = 0 AND empcode IN (SELECT empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND active = 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY))
       )");
       return $query->result_array();
   }

   function cek_data_by_gang_date($id_gang, $date)
   {
	   $this->db->from($this->table);
	   $this->db->where('id_gang ="'.$id_gang.'" AND attd_date ="'.$date.'" AND attd_code NOT IN (SELECT attd_code FROM master_attd_code WHERE paid = 1)  ');
	   $query = $this->db->get();
	   //$row = $query->row();
	   
	   return $query->num_rows();
   }

   function delete_data_mass($id_gang, $date)
   {
    $query = $this->db->query("delete from gang_activity WHERE attd_date = '".$date."' AND is_mass_update = 1 AND empcode IN (SELECT empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND active = 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY)) ");
        return $this->db->affected_rows();
   }

   // query delete data yang sudah terinput dan is_update_massal = 0 dan tidak SIA OFF LIBUR sebelum insert pada tanggal yang sama
   function delete_not_update_massal_by_date($id_gang, $date)
   {
	 $query = $this->db->query("delete from gang_activity WHERE attd_date = '".$date."' AND is_mass_update = 0 AND attd_code NOT IN (SELECT attd_code FROM master_attd_code WHERE paid = 1) and empcode IN (SELECT empcode FROM gang_master WHERE id_gang = '".$id_gang."' AND active = 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY)) ");
		 return $this->db->affected_rows();
   }

  




}

