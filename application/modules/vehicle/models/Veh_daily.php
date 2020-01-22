<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Veh_daily extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */
    
	var $table = 'vehicle_daily_op';
	var $column_order = array('a.tanggal', 'a.nap'); //set column field database for datatable orderable
	var $column_search = array('a.tanggal', 'a.nap', 'a.shift1', 'a.start_satu', 'a.stop_satu', 'a.total_satu', 'a.remarks_satu', 'a.shift2','a.start_dua','a.stop_dua','a.total_dua','a.remarks_dua'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		//add custom filter here
        if($this->input->post('f_nap_f'))
            {
                $this->db->where('a.nap', $this->input->post('f_nap_f'));
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('a.tanggal BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }
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
/*SELECT 
  a.tanggal,
  a.nap,
    CASE
  WHEN  a.kondisi = 0 THEN 'READY'
  WHEN  a.kondisi = 1 THEN 'KM ERROR'
  WHEN  a.kondisi = 2 THEN 'STANDBY'
  WHEN  a.kondisi = 3 THEN 'BREAKDOWN'
  WHEN  a.kondisi = 4 THEN 'TROUBLES'
  END AS kondisi,
  b.code_unit,
  b.nomor_plat,
  a.shift1,
  a.start_satu,
  a.stop_satu,
  a.total_satu,
  a.remarks_satu,
  a.shift2,
  a.start_dua,
  a.stop_dua,
  a.total_dua,
  a.remarks_dua 
FROM
  vehicle_daily_op a 
  LEFT JOIN vehicle_master b 
    ON a.nap = b.nap */
        $this->db->select("a.id,a.tanggal,
  a.nap,
    CASE
  WHEN  a.kondisi = 0 THEN 'READY'
  WHEN  a.kondisi = 1 THEN 'KM ERROR'
  WHEN  a.kondisi = 2 THEN 'STANDBY'
  WHEN  a.kondisi = 3 THEN 'BREAKDOWN'
  WHEN  a.kondisi = 4 THEN 'TROUBLES'
  WHEN  a.kondisi = 5 THEN 'TIDAK P2H'
  END AS kondisi,
  b.code_unit,
  b.nomor_plat,
  a.shift1,
  a.start_satu,
  a.stop_satu,
  a.total_satu,
  a.remarks_satu,
  a.shift2,
  a.start_dua,
  a.stop_dua,
  a.total_dua,
  a.remarks_dua");
        $this->db->from('vehicle_daily_op a');
        $this->db->join('vehicle_master b','a.nap = b.nap','left');
        /*$this->db->join('((select empcode, empname, departement from emp_master where is_deleted != "1" OR is_deleted is null) as emp_master)','gang_activity.empcode = emp_master.empcode');
        $this->db->join('master_dept','emp_master.departement = master_dept.departement');
        $this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');*/
        $this->db->order_by('a.id','desc');
        $this->db->limit('500');
        //$this->db->where('gang_activity.is_deleted != "1" OR gang_activity.is_deleted is null ');


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

    public function cek_data($nap, $date)
    {
        $this->db->from($this->table);
        $this->db->where('nap ="'.$nap.'" AND tanggal ="'.$date.'"');
        $query = $this->db->get();
        //$row = $query->row();
        return $query->row();
    }

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

    public function get_last_km($id)
    {
        $this->db->query('SET @nap = "'.$id.'";');
        $query = $this->db->query("select 
a.tanggal, a.nap,
    CASE
    WHEN a.stop_satu > a.stop_dua THEN a.stop_satu
    WHEN a.stop_dua > a.stop_satu THEN a.stop_dua   
    WHEN a.stop_dua = a.stop_dua THEN a.stop_dua
    WHEN a.stop_satu = a.stop_satu THEN a.stop_satu
END AS last_km,
CASE
    WHEN a.stop_satu > 0 THEN 1
    WHEN a.stop_dua > 0 THEN 2
    WHEN a.stop_dua = 0 THEN 1
END AS shift
FROM
(SELECT MAX(tanggal) tanggal, nap, MAX(stop_satu) stop_satu, MAX(stop_dua) stop_dua FROM vehicle_daily_op WHERE  kondisi = 0 GROUP BY nap) a WHERE a.nap = @nap
");
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
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	public function m_cetak($id)
	{
		$this->db->where('id_document',$id);
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

    /*model menampilkan report Monthly KM*/
    function rpt_monthly_km($bulan, $tahun)
    {
        /*SET @bulan = "6";
SET @tahun = "2018";
SELECT 
  a.nomor_plat,
  a.code_unit,
  a.nap,
  a.pic_code,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 1
  ) D1,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 2
  ) D2,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 3
  ) D3,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 4
  ) D4,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 5
  ) D5,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 6
  ) D6,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 7
  ) D7,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 8
  ) D8,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 9
  ) D9,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 10
  ) D10,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 11
  ) D11,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 12
  ) D12,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 13
  ) D13,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 14
  ) D14,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 15
  ) D15,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 16
  ) D16,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 17
  ) D17,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 18
  ) D18,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 19
  ) D19,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 20
  ) D20,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 21
  ) D21,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 22
  ) D22,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 23
  ) D23,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 24
  ) D24,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 25
  ) D25,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 26
  ) D26,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 27
  ) D27,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 28
  ) D28,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 29
  ) D29,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 30
  ) D30,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 31
  ) D31,
  (SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT("KM ERROR, ",remarks_satu)
    WHEN kondisi = 2 THEN CONCAT("STANDBY, ",remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT("BREAKDOWN, ",remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT("TROUBLES, ",remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 32
  ) D32
FROM
  (SELECT id, nap, nomor_plat,code_unit, pic_code, bulan, tahun, last_service, next_service FROM service_setup WHERE id IN (SELECT id FROM
(SELECT DISTINCT(MAX(nap)) nap, MAX(bulan) bulan, MAX(tahun) tahun, MAX(id) id FROM service_setup GROUP BY nap ORDER BY nap) a)
) a
  LEFT JOIN 
  vehicle_daily_op b
  ON a.nap = b.nap
-- WHERE a.tahun = @tahun AND a.bulan = @bulan  
  GROUP BY a.nap
  ORDER BY a.code_unit*/
  $this->db->query("SET @bulan = '".$bulan."'");
    $this->db->query("SET @tahun = '".$tahun."'");
        $query =  $this->db->query("select
  a.nomor_plat,
  a.code_unit,
  a.nap,
  get_empname(a.pic_code) pic_code,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 1
  ), '-') D1,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 2
  ), '-') D2,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 3
  ), '-') D3,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 4
  ), '-') D4,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 5
  ), '-') D5,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 6
  ), '-') D6,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 7
  ), '-') D7,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 8
  ), '-') D8,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 9
  ), '-') D9,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 10
  ), '-') D10,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 11
  ), '-') D11,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 12
  ), '-') D12,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 13
  ), '-') D13,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 14
  ), '-') D14,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 15
  ), '-') D15,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 16
  ), '-') D16,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 17
  ), '-') D17,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 18
  ), '-') D18,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 19
  ), '-') D19,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 20
  ), '-') D20,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 21
  ), '-') D21,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 22
  ), '-') D22,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 23
  ), '-') D23,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 24
  ), '-') D24,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 25
  ), '-') D25,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 26
  ), '-') D26,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 27
  ), '-') D27,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 28
  ), '-') D28,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 29
  ), '-') D29,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 30
  ), '-') D30,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 31
  ), '-') D31,
  COALESCE((SELECT 
    CASE 
    WHEN kondisi = 0 THEN
        CASE
            WHEN stop_dua > 0 THEN stop_dua 
            WHEN stop_dua = 0 THEN stop_satu
            WHEN stop_satu > 0 THEN stop_satu
         END 
    WHEN kondisi = 1 THEN CONCAT('KM ERROR, ',remarks_satu)
    WHEN kondisi = 2 THEN CONCAT('STANDBY, ',remarks_satu)
    WHEN kondisi = 3 THEN   CONCAT('BREAKDOWN, ',remarks_satu)
    WHEN kondisi = 4 THEN   CONCAT('TROUBLES, ',remarks_satu)
    WHEN kondisi = 5 THEN   CONCAT('TIDAK P2H, ',remarks_satu)
    END AS last_km
FROM vehicle_daily_op WHERE nap = a.nap AND YEAR(tanggal) = @tahun AND MONTH(tanggal) = @bulan AND DAY(tanggal) = 32
  ), '-') D32
FROM(
 SELECT 
  a.id,
  a.nap,
  b.nomor_plat,
  b.code_unit,
  b.pic_code,
  a.bulan,
  a.tahun,
  a.last_service,
  a.next_service 
FROM
  service_setup a
  LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE a.id IN 
  (SELECT 
    id 
  FROM
    (SELECT DISTINCT 
      (MAX(nap)) nap,
      MAX(bulan) bulan,
      MAX(tahun) tahun,
      MAX(id) id 
    FROM
      service_setup 
    GROUP BY nap 
    ORDER BY nap) a)
) a
  LEFT JOIN 
  vehicle_daily_op b
  ON a.nap = b.nap
  GROUP BY a.nap
  ORDER BY a.code_unit");
    return $query->result();
    }

    function notif_tidak_p2h()
    {
        /*SET @param = "2018-05-08" - INTERVAL 4 DAY;
SELECT b.*,d.nomor_plat, get_empname(d.pic_code) pic,
CASE
    WHEN c.stop_dua > 0 THEN stop_dua   
    WHEN c.stop_dua = 0 THEN stop_satu
    WHEN c.stop_satu > 0 THEN stop_satu
END AS last_km,
CASE 
    WHEN c.kondisi = 0 THEN "READY"
    WHEN c.kondisi = 1 THEN "KM ERROR"
    WHEN c.kondisi = 2 THEN "STAND BY"
    WHEN c.kondisi = 3 THEN "BREAKDOWN"
    WHEN c.kondisi = 4 THEN "TROUBLE"
END kondisi FROM (
SELECT 
CASE
    WHEN MAX(tanggal) > @param THEN "1"
    WHEN MAX(tanggal) <= @param THEN "0"
END notif, nap, MAX(tanggal) last_date
FROM
  (SELECT id, MAX(tanggal) tanggal, nap, start_satu, stop_satu, total_satu, start_dua, stop_dua, total_dua, kondisi FROM vehicle_daily_op GROUP BY nap) a
  GROUP BY nap
 ) b INNER JOIN vehicle_daily_op c ON b.nap = c.nap AND b.last_date = c.tanggal AND b.notif = 0
 INNER JOIN vehicle_master d ON b.nap = d.nap*/ // remarks 07072018

    /*query baru per tanggal 07072018
    SET @hari_ini = "2018-07-04";
SET @h_min_satu = "2018-07-04" - INTERVAL 1 DAY;
SET @h_min_empat = "2018-07-04" - INTERVAL 4 DAY;
SELECT COUNT(a.nap) total_tidakp2h, a.nap, c.nomor_plat, get_empname(c.pic_code) pic, c.code_unit, b.last_km, b.tanggal AS last_date FROM 
(SELECT nap,kondisi, tanggal FROM vehicle_daily_op WHERE tanggal BETWEEN @h_min_empat AND @h_min_satu) a
RIGHT JOIN 
(SELECT b.tanggal, b.nap,
    CASE
    WHEN b.stop_satu > b.stop_dua THEN b.stop_satu
    WHEN b.stop_dua > b.stop_satu THEN b.stop_dua   
    WHEN b.stop_dua = b.stop_dua THEN b.stop_dua
    WHEN b.stop_satu = b.stop_satu THEN b.stop_satu
END AS last_km FROM
(SELECT MAX(tanggal) tanggal, nap, MAX(stop_satu) stop_satu, MAX(stop_dua) stop_dua FROM vehicle_daily_op WHERE  kondisi = 0 GROUP BY nap) b
) b
ON a.nap = b.nap
LEFT JOIN vehicle_master c ON a.nap = c.nap
WHERE a.kondisi = 5 GROUP BY a.nap*/
    $this->db->query("SET @h_min_satu = CURDATE() - INTERVAL 1 DAY;");
    $this->db->query("SET @h_min_empat = CURDATE() - INTERVAL 4 DAY;");
    /*$this->db->query("SET @h_min_satu = '2018-07-04' - INTERVAL 1 DAY;");
    $this->db->query("SET @h_min_empat = '2018-07-04' - INTERVAL 4 DAY;");*/
    $query = $this->db->query("select f.* FROM
(SELECT COUNT(a.nap) total_tidakp2h, a.nap, c.nomor_plat, get_empname(c.pic_code) pic, c.code_unit, b.last_km, b.tanggal AS last_date FROM 
(SELECT nap,kondisi, tanggal FROM vehicle_daily_op WHERE tanggal BETWEEN @h_min_empat AND @h_min_satu) a
RIGHT JOIN 
(SELECT b.tanggal, b.nap,
    CASE
    WHEN b.stop_satu > b.stop_dua THEN b.stop_satu
    WHEN b.stop_dua > b.stop_satu THEN b.stop_dua   
    WHEN b.stop_dua = b.stop_dua THEN b.stop_dua
    WHEN b.stop_satu = b.stop_satu THEN b.stop_satu
END AS last_km FROM
(SELECT MAX(tanggal) tanggal, nap, MAX(stop_satu) stop_satu, MAX(stop_dua) stop_dua FROM vehicle_daily_op WHERE  kondisi = 0 GROUP BY nap) b
) b
ON a.nap = b.nap
LEFT JOIN vehicle_master c ON a.nap = c.nap
WHERE a.kondisi = 5 GROUP BY a.nap) f WHERE total_tidakp2h >= 3 AND f.nap NOT IN ('97-68','97-43')");
    return $query->result();
    }

    function list_notif_next_service()
    {
        $this->db->query("SET @param_service = 900;");
        $query = $this->db->query("select * FROM (SELECT 
  a.nap,
  b.nomor_plat,
  a.max_km,
  a.tanggal,
  b.code_unit,
  b.next_service,
  b.next_service - @param_service AS parameter,
  b.next_service - a.max_km AS sisa,
  CASE
    WHEN a.max_km >= b.next_service - @param_service THEN 1
    ELSE 0
  END AS notif_service
FROM
  (SELECT 
    MAX(tanggal) AS tanggal,
    nap,
    MAX(
      CASE
        WHEN stop_dua > 0 
        THEN stop_dua 
        WHEN stop_dua = 0 
        THEN stop_satu 
        WHEN stop_satu > 0 
        THEN stop_satu 
      END
    ) max_km 
  FROM
    vehicle_daily_op 
  WHERE kondisi = 0 
  GROUP BY nap) a INNER JOIN
  (SELECT 
    a.id,
    a.nap,
    b.nomor_plat,
    a.code_unit,
    MAX(a.bulan) bulan,
    MAX(a.tahun) tahun,
    MAX(a.next_service) next_service 
  FROM
    service_setup a LEFT JOIN vehicle_master b ON a.nap = b.nap
  GROUP BY a.nap) b ON a.nap = b.nap) c WHERE c.notif_service = 1");
        return $query->result();
    }





}

