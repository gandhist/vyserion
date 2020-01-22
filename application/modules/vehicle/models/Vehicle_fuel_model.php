<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_fuel_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */
    
	var $table = 'vehicle_fuel_consumption';
	var $column_order = array('a.tanggal_pengisian', 'a.qty'); //set column field database for datatable orderable
	var $column_search = array('a.tanggal_pengisian', 'a.nap', 'a.no_voucher'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.inputdate' => 'desc'); // default order 

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
            $this->db->where('date(a.tanggal_pengisian) BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
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
  a.nap,
  a.no_voucher,
  DATE(a.tanggal_pengisian) AS tanggal,
  TIME(a.tanggal_pengisian) AS jam,
  a.qty,
  a.hmkm,
  b.nomor_plat,
  get_empname(a.driver) driver,
  get_empname(a.fuelman) fuelman
FROM
  vehicle_fuel_consumption a LEFT JOIN vehicle_master b
  ON a.nap = b.nap */
        $this->db->select("a.id, a.nap,
  a.no_voucher,
  DATE(a.tanggal_pengisian) AS tanggal,
  TIME(a.tanggal_pengisian) AS jam,
  a.qty,
  a.hmkm,
  b.nomor_plat,
  get_empname(a.driver) driver,
  get_empname(a.fuelman) fuelman");
        $this->db->from('vehicle_fuel_consumption a');
        $this->db->join('vehicle_master b','a.nap = b.nap','left');
        /*$this->db->join('((select empcode, empname, departement from emp_master where is_deleted != "1" OR is_deleted is null) as emp_master)','gang_activity.empcode = emp_master.empcode');
        $this->db->join('master_dept','emp_master.departement = master_dept.departement');
        $this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');*/
        //$this->db->order_by('a.id','desc');
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
        $this->db->where('nap ="'.$nap.'" AND DATE(tanggal_pengisian) ="'.$date.'"');
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


	/*data untuk grafik*/
    public function data_summary_fuel_sarana($start, $end)
    {
    	$this->db->query('SET @start = "'.$start.'"');
$this->db->query('SET @end = "'.$end.'"');
        /*SET @start = "2018-07-01";
SET @end = "2018-08-31";
SELECT a.nap, b.qty FROM vehicle_master a LEFT JOIN 
(SELECT nap, SUM(qty) qty FROM vehicle_fuel_consumption WHERE DATE(tanggal_pengisian) BETWEEN @start AND @end  GROUP BY nap) b
ON a.nap = b.nap*/


/* work for without ajax
$this->db->query('SET @start = "'.$start.'"');
$this->db->query('SET @end = "'.$end.'"');
$query = $this->db->query('select a.nap, b.qty FROM vehicle_master a LEFT JOIN 
(SELECT nap, SUM(qty) qty FROM vehicle_fuel_consumption WHERE DATE(tanggal_pengisian) BETWEEN @start AND @end  GROUP BY nap) b
ON a.nap = b.nap');
return $query->result();
*/

/*if($this->input->post('filter_start') AND $this->input->post('filter_end'))
            {
$this->db->join('(SELECT nap, SUM(qty) qty FROM vehicle_fuel_consumption WHERE DATE(tanggal_pengisian) BETWEEN "'.$this->input->post('filter_start').'" AND "'.$this->input->post('filter_end').'" GROUP BY nap) b','a.nap = b.nap','LEFT');
            }*/
$this->db->select('a.nap, b.qty');
$this->db->from('vehicle_master a');
$this->db->join('(SELECT nap, SUM(qty) qty FROM vehicle_fuel_consumption WHERE DATE(tanggal_pengisian) BETWEEN "'.$start.'" AND "'.$end.'" GROUP BY nap) b','a.nap = b.nap','LEFT');
/*$query = $this->db->query('select a.nap, b.qty FROM vehicle_master a LEFT JOIN 
(SELECT nap, SUM(qty) qty FROM vehicle_fuel_consumption WHERE DATE(tanggal_pengisian) BETWEEN @start AND @end  GROUP BY nap) b
ON a.nap = b.nap');
return $query->result();*/
$query = $this->db->get();
		return $query->result();
    }

    public function rpt_summary_fuel_sarana($start, $end)
    {
    	/*
			SELECT 
  a.nap,
  b.code_unit,
  b.nomor_plat,
  a.tanggal_pengisian,
  a.qty,
  a.hmkm,
  get_empname (a.fuelman) fuelman,
  get_empname (a.fuelman) driver 
FROM
  vehicle_fuel_consumption a LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE DATE(a.tanggal_pengisian) BETWEEN "2018-08-01" 
  AND "2018-08-31"
    	*/
    	$query = $this->db->query('select 
 a.nap,
  b.code_unit,
  b.nomor_plat,
  a.tanggal_pengisian,
  a.qty,
  a.hmkm,
  get_empname (a.fuelman) fuelman,
  get_empname (a.fuelman) driver 
FROM
  vehicle_fuel_consumption a LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE DATE(a.tanggal_pengisian) BETWEEN "'.$start.'" 
  AND "'.$end.'" ORDER BY a.nap, a.tanggal_pengisian ');
    	return $query->result();
    }

    public function total_fuel_ga($start, $end)
    {
    	/*SELECT 
  a.nap,
  b.code_unit,
  b.nomor_plat,
  a.tanggal_pengisian,
  SUM(a.qty) total
  FROM
  vehicle_fuel_consumption a LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE DATE(a.tanggal_pengisian) BETWEEN "2018-08-01" 
  AND "2018-08-31" GROUP BY a.nap*/
    	$query = $this->db->query('select 
  a.nap,
  b.code_unit,
  b.nomor_plat,
  a.tanggal_pengisian,
  SUM(a.qty) total
  FROM
  vehicle_fuel_consumption a LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE DATE(a.tanggal_pengisian) BETWEEN  "'.$start.'" 
  AND "'.$end.'" GROUP BY a.nap');
    	return $query->result();
    }

    public function fuel_per_km($start, $end)
    {
    	/*SELECT 
  a.nap,
  CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)) AS awal,
  CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) AS akhir,
  a.total_km,
  ROUND(CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) - CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)),1) AS total_km_baru,
  b.total AS total_fuel,
  COALESCE(FORMAT(b.total / ROUND(CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) - CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)),1),2),0) AS fuel_per_km
FROM
  (SELECT 
    a.nap,
    MIN(a.hmkm) AS awal,
    MAX(a.hmkm) AS akhir,
    MAX(a.hmkm) - MIN(a.hmkm) AS total_km 
  FROM
    vehicle_fuel_consumption a 
  WHERE DATE(a.tanggal_pengisian) BETWEEN "2018-08-01" 
    AND "2018-08-31" 
  GROUP BY a.nap) a 
  LEFT JOIN 
    (SELECT 
      a.nap,
      SUM(a.qty) total 
    FROM
      vehicle_fuel_consumption a 
      LEFT JOIN vehicle_master b 
        ON a.nap = b.nap 
    WHERE DATE(a.tanggal_pengisian) BETWEEN "2018-08-01" 
      AND "2018-08-31" 
    GROUP BY a.nap) b 
    ON a.nap = b.nap  */
    $this->db->query('SET @start = "'.$start.'"');
	$this->db->query('SET @end = "'.$end.'"');
    $query = $this->db->query("select 
  a.nap,
  CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)) AS awal,
  CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) AS akhir,
  -- a.total_km,
  ROUND(CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) - CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)),1) AS total_km,
  b.total AS total_fuel,
  COALESCE(FORMAT(b.total / ROUND(CONCAT(LEFT(a.akhir,CHARACTER_LENGTH(a.akhir)-1), '.', SUBSTR(a.akhir,-1)) - CONCAT(LEFT(a.awal,CHARACTER_LENGTH(a.awal)-1), '.', SUBSTR(a.awal,-1)),1),2),0) AS fuel_per_km
FROM
  (SELECT 
    a.nap,
    MIN(a.hmkm) AS awal,
    MAX(a.hmkm) AS akhir,
    MAX(a.hmkm) - MIN(a.hmkm) AS total_km 
  FROM
    vehicle_fuel_consumption a
  WHERE DATE(a.tanggal_pengisian) BETWEEN @start 
    AND @end 
  GROUP BY a.nap) a 
  LEFT JOIN 
    (SELECT 
      a.nap,
      SUM(a.qty) total 
    FROM
      vehicle_fuel_consumption a 
      LEFT JOIN vehicle_master b 
        ON a.nap = b.nap 
    WHERE DATE(a.tanggal_pengisian) BETWEEN @start 
      AND @end 
    GROUP BY a.nap) b 
    ON a.nap = b.nap ");
    return $query->result();
    }







}

