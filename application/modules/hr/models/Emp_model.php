<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_model extends CI_Model {

	/*var $table = 'empmaster';
	var $column_order = array('empcode','empname','sex','address','dob',null); //set column field database for datatable orderable
	var $column_search = array('empcode','empname','sex','address','dob'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('empcode' => 'desc'); // default order */


	var $table = 'emp_master';
	var $column_order = array('emp_master.empcode','emp_master.empname','a.position_desc','master_position.position_desc','emp_master.companybegin',null); //set column field database for datatable orderable
	var $column_search = array('emp_master.empcode','emp_master.empname','emp_master.position','master_position.position_desc','emp_master.companybegin'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('emp_master.empcode' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
    //use for datatable with live filtering
    
	private function _get_datatables_query()
	{

		//add custom filter here
        if($this->input->post('f_empcode_f'))
        {
            $this->db->where('emp_master.empcode', $this->input->post('f_empcode_f'));
        }
        if($this->input->post('f_dept_f'))
        {
            $this->db->where('emp_master.departement', $this->input->post('f_dept_f'));
        }
        if($this->input->post('filter_position'))
        {
            $this->db->where('emp_master.position', $this->input->post('filter_position'));
        }
        if($this->input->post('f_emptype_f'))
        {
            $this->db->where('emp_master.employeetype', $this->input->post('f_emptype_f'));
        }
        if($this->input->post('filter_start') != '' && $this->input->post('filter_end') != '' || $this->input->post('filter_start') != null)
        {
        $this->db->where('emp_master.companybegin BETWEEN "'.$this->input->post('filter_start').'" AND "'.$this->input->post('filter_end').'"');
            //$this->db->where('created_at BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
        }
        
        /*if($this->input->post('filter_emp_status'))
        {
            $this->db->like('address', $this->input->post('address'));
        }*/

        $this->db->select('emp_master.*,master_position.position_desc, a.position_desc as position_id');
        $this->db->from($this->table);
        $this->db->join('master_position','emp_master.employeetype = master_position.id_position','left');
        $this->db->join('master_position AS a','emp_master.position = a.id_position','left');
        $this->db->where('emp_master.is_deleted = "0" and empcode not in (SELECT empcode FROM hr_termination) and site_id = 2001');

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
        $this->db->join('master_position AS a','emp_master.position = a.id_position');

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

    public function cek_data($nik)
    {
        $this->db->select('empcode');
        $this->db->from('hr_termination');
        $this->db->where('empcode',$nik);
        $query = $this->db->get();

        return $query->row();

    }

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	/* remarks at 08032018
    public function delete_by_id($id)
	{
		$this->db->where('empcode', $id);
		$this->db->delete($this->table);
	}*/
    public function delete_by_id($id)
    {
        $this->db->update($this->table, $where, $id) ;
        return $this->db->affected_rows();
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

/*fungsi untk mendapatkan nik terakhir di table doc_rn*/
    public function last_rn()
    {
        $this->db->select('rn');
        $this->db->where('parameter','nik');
        $query = $this->db->get('doc_rn');
        return $query->result();
    }

	public function dept()
	{
		$query = $this->db->query("SELECT departement, dept_desc FROM master_dept");
		return $query->result();

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

    // dd departement
    // model untuk dropdown employee code
    function dd_dept()
    {
        // ambil data dari db
        $this->db->order_by('departement', 'asc');
        $result = $this->db->get('master_dept');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd['*'] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->departement] = $row->departement .$a. $row->dept_desc;
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
        //$dd[''] = ''; //untuk placeholder
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

    function slip_gaji()
    {
        $query = $this->db->query('
select a.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, coalesce(f.amount,0) as amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
COALESCE(SUM(a.overtime),0) as jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
COALESCE((e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount,0) as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in("attd001","attd010","attd011")) a
RIGHT join emp_master b 
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f 
on b.empcode = f.empcode
GROUP BY a.empcode
            ');

 /*       select a.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, f.amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
SUM(a.overtime) as jam_lembur, 
ROUND((1/173*e.upah) * SUM(a.overtime)) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
(e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in('attd001','attd010','attd011')) a
RIGHT join emp_master b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
on b.empcode = f.empcode
GROUP BY a.empcode*/
       // $query = $this->db->query('select empcode, empname from emp_master where empcode = "1800001"');
        //return $query->result();
        return $query->result_array();
    }

    function slip_gaji_id()
    {
        $query = $this->db->query('
select b.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, coalesce(f.amount,0) as amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
COALESCE(SUM(a.overtime),0) as jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
COALESCE((e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount,0) as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in("attd001","attd010","attd011")) a
RIGHT join emp_master b 
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f 
on b.empcode = f.empcode
GROUP BY a.empcode
            ');

 /*       select a.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, f.amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
SUM(a.overtime) as jam_lembur, 
ROUND((1/173*e.upah) * SUM(a.overtime)) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
(e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in('attd001','attd010','attd011')) a
RIGHT join emp_master b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
on b.empcode = f.empcode
GROUP BY a.empcode*/
       // $query = $this->db->query('select empcode, empname from emp_master where empcode = "1800001"');
        //return $query->result();
        return $query->result();
    }

    function slip_gaji_get_id($id)
    {
        $query = $this->db->query('
select b.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, coalesce(f.amount,0) as amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
COALESCE(SUM(a.overtime),0) as jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
COALESCE((e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount,0) as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in("attd001","attd010","attd011")) a
RIGHT join emp_master b 
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f 
on b.empcode = f.empcode
where b.empcode = "'.$id.'"
GROUP BY a.empcode
            ');

 /*       select a.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, f.amount, f.remarks,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
SUM(a.overtime) as jam_lembur, 
ROUND((1/173*e.upah) * SUM(a.overtime)) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
(e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount as gaji_bersih
from (SELECT * FROM gang_activity  where attd_code in('attd001','attd010','attd011')) a
RIGHT join emp_master b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
on a.empcode = b.empcode
INNER JOIN master_position c
on b.position = c.id_position
inner join master_dept d
ON b.departement = d.departement
INNER JOIN hr_hist_status e
on b.empcode = e.empcode
LEFT JOIN empallded f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
on b.empcode = f.empcode
GROUP BY a.empcode*/
       // $query = $this->db->query('select empcode, empname from emp_master where empcode = "1800001"');
        //return $query->result();
        return $query->result();
    }

    function slip_lembur($id)
    {
        $query = $this->db->query('select a.empcode, B.empname, a.attd_date,a.attd_code, a.remarks
from gang_activity a
RIGHT JOIN emp_master B
ON a.empcode = b.empcode
where a.attd_date BETWEEN "2018-01-01" AND "2018-01-30"
and a.empcode = "'.$id.'"
GROUP BY a.empcode, b.empname, a.attd_date');
        return $query->result_array();
    }
// can use for filter by id
 function slip_lembur_no()
    {
        $query = $this->db->query('select a.empcode, B.empname, a.attd_date,a.attd_code, a.remarks
from gang_activity a
RIGHT JOIN emp_master B
ON a.empcode = b.empcode
where a.attd_date BETWEEN "2018-01-01" AND "2018-01-30"
GROUP BY a.empcode, b.empname, a.attd_date');
        return $query->result_array();

    }
    // query detail lembur karyawan
    function detail_lembur($id)
    {
        /*select COALESCE(a.empcode,'Grand Total') as empcode, COALESCE(b.empname,'Sub Total') as empname, COALESCE(a.attd_date,'Sub Total') as attd_date,c.upah, a.overtime,
round((a.overtime * 1 / 173 * c.upah)) as lembur
, coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = '1800001'
GROUP BY  a.empcode, b.empname, a.attd_date
WITH ROLLUP*/
       $query = $this->db->query('
select COALESCE(a.empcode,"Grand Total") as empcode, COALESCE(b.empname,"Sub Total") as empname, COALESCE(a.attd_date,"Sub Total") as attd_date,c.upah, a.overtime, a.attd_code,
round((a.overtime * 1 / 173 * c.upah)) as lembur
, coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = "'.$id.'"
and a.attd_date BETWEEN "2018-01-01" AND "2018-01-30" 
GROUP BY  a.attd_date
WITH ROLLUP');
        return $query->result_array();

    }





}

