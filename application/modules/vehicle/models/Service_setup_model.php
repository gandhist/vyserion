<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_setup_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */
    
	var $table = 'service_setup';
	var $column_order = array('id', 'nap'); //set column field database for datatable orderable
	var $column_search = array('nap', 'nomor_plat', 'code_unit', 'bulan', 'tahun', 'last_service', 'next_service'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

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
                $this->db->where('nap', $this->input->post('f_nap_f'));
            }
        if($this->input->post('filter_bulan'))
            {
                $this->db->where('bulan', $this->input->post('filter_bulan'));
            }
        if($this->input->post('filter_tahun'))
            {
                $this->db->where('tahun', $this->input->post('filter_tahun'));
            }
        /*if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('a.tanggal BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
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
/*SELECT 
  a.tanggal,
  a.nap,
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
        $this->db->select('id, nap, year, pic_code, code_unit, nomor_plat, ownership, bulan, tahun, last_service, next_service');
        $this->db->from('service_setup');
        //$this->db->join('vehicle_master b','a.nap = b.nap','left');
        /*$this->db->join('((select empcode, empname, departement from emp_master where is_deleted != "1" OR is_deleted is null) as emp_master)','gang_activity.empcode = emp_master.empcode');
        $this->db->join('master_dept','emp_master.departement = master_dept.departement');
        $this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');*/
        //$this->db->order_by('a.tanggal','asc');
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

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

    public function get_vehicle_by_id($id)
    {
        /*$this->db->from("vehicle_master");
        $this->db->where('nap',$id);*/
        $query = $this->db->query('select 
  a.nomor_plat,
  a.year,
  a.code_unit,
  a.ownership,
  a.pic_code, 
  COALESCE(b.next_service,0) last_service,
  COALESCE(b.nap,0) AS nap_b
FROM
  vehicle_master a
  LEFT JOIN 
  (SELECT nap, next_service, MAX(bulan), MAX(tahun) FROM service_setup GROUP BY nap) b 
  ON a.nap = b.nap
WHERE a.nap = "'.$id.'" ');

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

    function get_sheet_name()
    {
        /*SELECT 
  a.id,
  a.nap,
  a.year,
  get_empname (b.pic_code) AS pic_code,
  b.code_unit,
  b.nomor_plat,
  b.ownership,
  a.bulan,
  a.tahun,
  a.last_service,
  a.next_service 
FROM
  service_setup a
  LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE id IN 
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
*/
      
        //$this->db->query("SET @bulan = '".$bulan."'");
        //$this->db->query("SET @tahun = '".$tahun."'");
        $query = $this->db->query("select a.id,
  a.nap,
  a.year,
  get_empname (b.pic_code) AS pic_code,
  b.code_unit,
  b.nomor_plat,
  b.ownership,
  a.bulan,
  a.tahun,
  a.last_service,
  a.next_service 
FROM
  service_setup a
  LEFT JOIN vehicle_master b ON a.nap = b.nap
WHERE id IN 
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
    ORDER BY nap) a)");
        return $query->result();

    }

    function get_data_daily_report($bulan, $tahun, $nap)
    {
        /*SET @bulan = "5";
SET @tahun = "2018";
SET @nap = "97-68";
SELECT tanggal, nap, shift1, start_satu, stop_satu, total_satu, remarks_satu, shift2, start_dua, stop_dua, total_dua, remarks_dua FROM vehicle_daily_op
WHERE MONTH(tanggal) = @bulan
AND YEAR(tanggal) = @tahun
AND nap = @nap*/

$this->db->query("SET @bulan = '".$bulan."'");
        $this->db->query("SET @tahun = '".$tahun."'");
        $this->db->query("SET @nap = '".$nap."'");
        $query = $this->db->query("select tanggal, nap, shift1, start_satu, stop_satu, total_satu, remarks_satu, shift2, start_dua, stop_dua, total_dua, remarks_dua FROM vehicle_daily_op
WHERE MONTH(tanggal) = @bulan
AND YEAR(tanggal) = @tahun
AND nap = @nap
ORDER BY tanggal asc");
        return $query->result();
    }

    function grand_total_daily($bulan, $tahun, $nap)
    {
        /*SET @nap = "97-68";
SET @bulan = "5";
SET @tahun = "2018";
SELECT SUM(total_satu) AS gt_shift_satu, SUM(total_dua) AS gt_shift_dua FROM vehicle_daily_op WHERE nap = @nap AND MONTH(tanggal) = @bulan AND YEAR(tanggal) = @tahun
*/
        $this->db->query("SET @bulan = '".$bulan."'");
        $this->db->query("SET @tahun = '".$tahun."'");
        $this->db->query("SET @nap = '".$nap."'");
        $query = $this->db->query('select SUM(total_satu) AS gt_shift_satu, SUM(total_dua) AS gt_shift_dua FROM vehicle_daily_op WHERE nap = @nap AND MONTH(tanggal) = @bulan AND YEAR(tanggal) = @tahun');
        return $query->result();
    }





}



