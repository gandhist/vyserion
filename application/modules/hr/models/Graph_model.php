<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'master_dept';
	var $column_order = array('a.empcode','a.nik_pim','a.hire_date',null); //set column field database for datatable orderable
	var $column_search = array('b.position_desc','a.empname','a.nik_pim'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.hire_date' => 'asc'); // default order 

	/* karyawan keluar*/
	var $column_order_out = array('a.empcode','a.nik_pim','a.hire_date',null); //set column field database for datatable orderable
	var $column_search_out = array('b.position_desc','a.empname','a.nik_pim'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order_out = array('a.dateterminate' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		/*select 
            a.empcode,
            a.empname,
            a.nik_pim,
            a.hire_date,
            a.employeetype,
            b.position_desc as position
          FROM
            emp_master a LEFT JOIN (SELECT * FROM master_position WHERE id_position LIKE "pos%") b ON a.position = b.id_position
          WHERE MONTH(a.hire_date) = '.$bulan.'
            AND YEAR(a.hire_date) = '.$tahun.' 
            AND a.empcode NOT IN 
            (SELECT 
              empcode 
            FROM
              hr_termination)*/
              /*if ($this->input->post('parameter_bulan') || $this->input->post('parameter_tahun')) {
              	$this->db->where('MONTH(a.hire_date)',$this->input->post('parameter_bulan'));
              	$this->db->where('YEAR(a.hire_date)',$this->input->post('parameter_tahun'));
              }*/
              if ($this->input->post('filter_start') || $this->input->post('filter_end')) {
                $this->db->where('DATE(a.hire_date) BETWEEN "'.$this->input->post('filter_start').'" AND "'.$this->input->post('filter_end').'" ');
                //$this->db->where('YEAR(a.dateterminate)',$this->input->post('parameter_tahun'));
              }
          else
          {
          	$this->db->where('MONTH(a.hire_date) = MONTH(CURDATE()) AND YEAR(a.hire_date) = YEAR(CURDATE())');	
          }

              $this->db->select('a.empcode,
            a.empname,
            a.nik_pim,
            a.hire_date,
            a.employeetype,
            b.position_desc as position');
              $this->db->from('emp_master a');
              $this->db->join('(select * FROM master_position WHERE id_position LIKE "pos%") b','a.position = b.id_position','left');
              $this->db->where('a.empcode NOT IN 
            (SELECT 
              empcode 
            FROM
              hr_termination)');

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
		$this->db->select('a.empcode,
            a.empname,
            a.nik_pim,
            a.hire_date,
            a.employeetype,
            b.position_desc as position');
              $this->db->from('emp_master a');
              $this->db->join('(select * FROM master_position WHERE id_position LIKE "pos%") b','a.position = b.id_position','left');
              $this->db->where('a.empcode NOT IN 
            (SELECT 
              empcode 
            FROM
              hr_termination)');
		return $this->db->count_all_results();
	}

	/* karyawan out*/
	private function _get_datatables_query_out()
	{
		
		/*select 
            a.empcode,
            a.dateterminate,
            b.empname,
            b.nik_pim,
            b.hire_date,
            b.employeetype,
            c.position_desc as position
          FROM
            hr_termination a LEFT JOIN emp_master b ON a.empcode = b.empcode
            LEFT JOIN (SELECT * FROM master_position WHERE id_position LIKE "pos%") c ON b.position = c.id_position
          WHERE MONTH(a.dateterminate) = '.$bulan.'
            AND YEAR(a.dateterminate) = '.$tahun.'*/
              if ($this->input->post('filter_start') || $this->input->post('filter_end')) {
              	$this->db->where('DATE(a.dateterminate) BETWEEN "'.$this->input->post('filter_start').'" AND "'.$this->input->post('filter_end').'" ');
              	//$this->db->where('YEAR(a.dateterminate)',$this->input->post('parameter_tahun'));
              }
          else
          {
          	$this->db->where('MONTH(a.dateterminate) = MONTH(CURDATE()) AND YEAR(a.dateterminate) = YEAR(CURDATE())');	
          }

              $this->db->select('a.empcode,
            a.dateterminate,
            b.empname,
            b.nik_pim,
            b.hire_date,
            b.employeetype,
            c.position_desc as position');
              $this->db->from('hr_termination a');
              $this->db->join('emp_master b','a.empcode = b.empcode','left');
              $this->db->join('(select * FROM master_position WHERE id_position LIKE "pos%") c','b.position = c.id_position','left');
              /*$this->db->where('a.empcode NOT IN 
            (SELECT 
              empcode 
            FROM
              hr_termination)');*/

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
		else if(isset($this->order_out))
		{
			$order = $this->order_out;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_out()
	{
		$this->_get_datatables_query_out();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_out()
	{
		$this->_get_datatables_query_out();
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_out()
	{
		$this->db->select('a.empcode,
            a.dateterminate,
            b.empname,
            b.nik_pim,
            b.hire_date,
            b.employeetype,
            c.position_desc as position');
              $this->db->from('hr_termination a');
              $this->db->join('emp_master b','a.empcode = b.empcode','left');
              $this->db->join('(select * FROM master_position WHERE id_position LIKE "pos%") c','b.position = c.id_position','left');
		return $this->db->count_all_results();
	}
	/*end of karyawan out*/

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('departement',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert("master_dept", $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('departement', $id);
		$this->db->delete($this->table);
	}
	public function m_cetak($id)
	{
		$this->db->where('departement',$id);
		return $this->db->get($this->table);
	
	}
	public function last_id()
	{
		$this->db->select_max('departement');
/*		$this->db->limit(1);
		$this->db->order_by('departement', 'DESC');*/
		$query = $this->db->get('master_dept');
		return $query->row();
    }
    
    public function data_emp_in()
        {
            $query = $this->db->query('select a.jml_emp emp_in , b.jml_emp emp_out
            FROM
            (SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),1) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE()))tahun FROM emp_master WHERE MONTH(hire_date) = 1 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),2) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE()))tahun FROM emp_master WHERE MONTH(hire_date) = 2 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),3) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 3 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),4) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 4 AND YEAR(hire_date) = YEAR(CURDATE())AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),5) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 5 AND YEAR(hire_date) = YEAR(CURDATE())AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),6) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 6 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),7) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 7 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),8) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 8 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),9) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 9 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),10) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 10 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),11) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 11 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),12) bulan, COALESCE(YEAR(hire_date),YEAR(CURDATE())) tahun FROM emp_master WHERE MONTH(hire_date) = 12 AND YEAR(hire_date) = YEAR(CURDATE()) AND empcode NOT IN(SELECT empcode FROM hr_termination)
            ) a,
            (SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),1) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 1 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),2) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 2 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),3) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 3 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),4) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 4 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),5) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 5 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),6) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 6 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),7) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 7 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),8) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 8 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),9) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 9 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),10) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 10 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),11) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 11 AND YEAR(dateterminate) = YEAR(CURDATE())
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),12) bulan, COALESCE(YEAR(dateterminate),YEAR(CURDATE())) tahun FROM hr_termination WHERE MONTH(dateterminate) = 12 AND YEAR(dateterminate) = YEAR(CURDATE())) b
            WHERE a.bulan = b.bulan AND a.tahun = b.tahun');
            return $query->result();
        }

        public function daftar_emp_in($start_date, $end_date)
        {
          $this->db->query('SET @start_date = "'.$start_date.'" ');
          $this->db->query('SET @end_date = "'.$end_date.'" ');
            $query = $this->db->query('select
            a.empcode,
            a.empname,
            a.nik_pim,
            a.hire_date,
            MONTH(a.hire_date) bulan,
            YEAR(a.hire_date) tahun,
            a.employeetype,
            b.position_desc AS position
          FROM
            emp_master a LEFT JOIN (SELECT * FROM master_position WHERE id_position LIKE "pos%") b ON a.position = b.id_position
          WHERE a.hire_date BETWEEN @start_date AND @end_date
            AND a.empcode NOT IN 
            (SELECT 
              empcode 
            FROM
              hr_termination) ORDER BY a.hire_date DESC');
            return $query->result();
        }

        public function daftar_emp_out($start_date, $end_date)
        {
           $this->db->query('SET @start_date = "'.$start_date.'" ');
          $this->db->query('SET @end_date = "'.$end_date.'" ');
            $query = $this->db->query('select 
            a.empcode,
            a.dateterminate,
            b.empname,
            b.nik_pim,
            MONTH(a.dateterminate) bulan,
            YEAR(a.dateterminate) tahun,
            b.employeetype,
            c.position_desc AS position
          FROM
            hr_termination a LEFT JOIN emp_master b ON a.empcode = b.empcode
            LEFT JOIN (SELECT * FROM master_position WHERE id_position LIKE "pos%") c ON b.position = c.id_position
          WHERE a.dateterminate BETWEEN @start_date AND @end_date ORDER BY a.dateterminate DESC');
            return $query->result();
        }

        public function rekap_emp_in($tahun)
        {
          $this->db->query('SET @tahun = "'.$tahun.'"');
          $query = $this->db->query('
select a.tahun, a.bulan, a.jml_emp FROM 
(SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),1) bulan, COALESCE(YEAR(hire_date),@tahun)tahun FROM emp_master WHERE MONTH(hire_date) = 1 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),2) bulan, COALESCE(YEAR(hire_date),@tahun)tahun FROM emp_master WHERE MONTH(hire_date) = 2 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),3) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 3 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),4) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 4 AND YEAR(hire_date) = @tahun
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),5) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 5 AND YEAR(hire_date) = @tahun
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),6) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 6 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),7) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 7 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),8) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 8 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),9) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 9 AND YEAR(hire_date) = @tahun 
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),10) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 10 AND YEAR(hire_date) = @tahun
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),11) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 11 AND YEAR(hire_date) = @tahun
                        UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(hire_date),12) bulan, COALESCE(YEAR(hire_date),@tahun) tahun FROM emp_master WHERE MONTH(hire_date) = 12 AND YEAR(hire_date) = @tahun) a');
          return $query->result();
        }

        public function rekap_emp_out($tahun)
        {
          $this->db->query('SET @tahun = "'.$tahun.'"');
          $query = $this->db->query('
select COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),1) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 1 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),2) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 2 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),3) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 3 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),4) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 4 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),5) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 5 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),6) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 6 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),7) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 7 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),8) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 8 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),9) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 9 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),10) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 10 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),11) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 11 AND YEAR(dateterminate) = @tahun
            UNION
            SELECT COUNT(empcode) jml_emp, COALESCE(MONTH(dateterminate),12) bulan, COALESCE(YEAR(dateterminate),@tahun) tahun FROM hr_termination WHERE MONTH(dateterminate) = 12 AND YEAR(dateterminate) = @tahun');
          return $query->result();
        }



    


}

