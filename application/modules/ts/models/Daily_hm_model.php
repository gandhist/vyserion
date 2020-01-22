<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Daily_hm_model extends CI_Model
{
	
	var $table = 'daily_hmkm';
    var $column_order = array('b.code_unit','a.nap'); //set column field database for datatable orderable
    var $column_search = array('b.code_unit','a.nap'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    /*untuk datatable excel*/
    var $column_order_xls = array('a.code_unit','a.nap'); //set column field database for datatable orderable
    var $column_search_xls = array('a.code_unit','a.nap', 'a.no_kwitansi', 'a.remarks_machine', 'a.reason_bd', 'a.nama_vendor'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    /*end of datatable excl parameter*/
    var $order = array('b.code_unit' => 'desc'); // default order 
    function __construct()
    {
        parent::__construct();
        //$this->load->helper('parse_helper');
        
    }

    private function _get_datatables_query()
    {

        //add custom filter here
        if ($this->input->post('filter_code_unit')) {
          $this->db->where('a.nap', $this->input->post('filter_code_unit'));
        }

        if ($this->input->post('filter_month')) {
          $this->db->where('a.period', $this->input->post('filter_month'));
        }

        if ($this->input->post('filter_year')) {
          $this->db->where('a.year', $this->input->post('filter_year'));
        }
        /*if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('DATE(a.date_start) BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }*/
        /*  unremarks this for additional form filter data
        if($this->input->post('filter_empcode'))
            {
                $this->db->where('emp_master.empcode', $this->input->post('filter_empcode'));
            }
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
        /*SELECT a.id, a.pin, b.empname, DATE(a.date_time) AS tanggal, a.date_time, a.ver, a.status FROM absen_finger a LEFT JOIN emp_master b
ON a.pin = b.badgenumber*/
/*SELECT a.id, a.pin,b.empcode, b.empname, DATE(a.date_time) AS tanggal, a.date_time, a.ver, a.status FROM absen_finger a LEFT JOIN emp_master b
ON a.pin = b.badgenumber WHERE b.empcode = 1800001 AND a.date_time BETWEEN "2018-05-07" AND "2018-05-21" AND b.empcode IN (SELECT DISTINCT(empcode) AS empcode FROM gang_master WHERE id_gang = 11)*/
        $this->db->select("a.*,b.code_unit");
        $this->db->from('daily_hmkm a');
        $this->db->join('vehicle_master b','a.nap = b.nap','left');
        //$this->db->where("a.status_bd != 1 or date(a.date_finished) >= date_add(curdate( ), interval -1 day) ");
        $this->db->order_by('a.id_hm','DESC');
        $this->db->limit('5000');

        /*$this->db->where('a.empcode = b.empcode');
        $this->db->where('a.allowded_code = c.allowded_code');*/
        //$this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');

        /*select a.empcode, b.empname, a.adhoc_date, a.allowded_code, c.description, a.amount
from empallded a, emp_master b, master_adhoc c
where a.empcode = b.empcode
and a.allowded_code = c.allowded_code*/

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

	public function save($data)
	{
		$this->db->insert("daily_hmkm",$data);
		return $this->db->insert_id();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_hm',$id);
		$this->db->delete($this->table);
	}

	public function get_unit_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_hm', $id);
		$query = $this->db->get();

		return $query->row();
	}


	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_status_unit($id)
	{
		$query = $this->db->query("select no_kwitansi, date_start, nap, status_bd FROM vehicle_breakdown WHERE nap = '".$id."' ORDER BY date_start DESC LIMIT 1");
		return $query->result();
	}

  public function cek_kwitansi($no_kwitansi)
  {
    $this->db->select('no_kwitansi, date_start, nap');
    $this->db->from('vehicle_breakdown');
    $this->db->where('no_kwitansi',$no_kwitansi);
    $query = $this->db->get();
    return $query->row();
  }

  public function cek_data($nap, $period, $year)
  {
    $this->db->select('nap, period, year');
    $this->db->from($this->table);
    $this->db->where('nap', $nap);
    $this->db->where('period', $period);
    $this->db->where('year', $year);
    $query = $this->db->get();
    return $query->row();
  }

  public function cek_before_closing($month, $year)
  {
    $query = $this->db->query("select period, year FROM daily_hmkm where period = ".$month." and year = ".$year."");
    return $query->num_rows();
  }

  public function closing_hm_daily($month, $year, $inputby, $inputdate)
  {
    $this->db->query("CALL closing_hm_daily('".$month."', '".$year."', '".$inputby."', '".$inputdate."');");
    return $this->db->affected_rows();
  }

  public function delete_data_by_period($month, $year)
  {
    $this->db->where('period',$month);
    $this->db->where('year',$year);
    $this->db->delete($this->table);
  }

	public function rpt_downtime_daily($filter_start_date, $filter_end_date, $code_unit, $type, $status_bd, $status_level)
	{
		/*
		SELECT 
  a.no_kwitansi,
  a.date_start,
  a.nap,
  b.code_unit,
  CASE
    WHEN a.task = 0 
    THEN "Primary" 
    WHEN a.task = 1 
    THEN "Secondary" 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN "Scheduled" 
    WHEN a.SCHEDULE = 1 
    THEN "Un-Scheduled" 
  END AS SCHEDULE,
  CASE
    WHEN a.status_damage = 0 
    THEN "Normal" 
    WHEN a.status_damage = 1 
    THEN "Special Case" 
    WHEN a.status_damage = 2 
    THEN "Abnormal" 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN "PM" 
    WHEN a.pm = 1 
    THEN "Non-PM" 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN "BD1" 
    WHEN a.status_level = 1 
    THEN "BD2" 
    WHEN a.status_level = 2 
    THEN "BD3" 
    WHEN a.status_level = 3 
    THEN "BD4" 
    WHEN a.status_level = 4 
    THEN "CLOSED" 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN "OPEN" 
    WHEN a.status_bd = 1 
    THEN "CLOSED" 
  END AS status_bd,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN "Day" 
    WHEN a.shift = 1 
    THEN "Night" 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN "Fixed Cost" 
    WHEN a.status_cost = 1 
    THEN "Estimate Cost" 
    WHEN a.status_cost = 2 
    THEN "Warranty" 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 1 
    AND DATE(a.date_finished) BETWEEN DATE_ADD(CURDATE( ),INTERVAL - 1 DAY) AND CURDATE()
    UNION ALL
    SELECT 
  a.no_kwitansi,
  a.date_start,
  a.nap,
  b.code_unit,
  CASE
    WHEN a.task = 0 
    THEN "Primary" 
    WHEN a.task = 1 
    THEN "Secondary" 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN "Scheduled" 
    WHEN a.SCHEDULE = 1 
    THEN "Un-Scheduled" 
  END AS SCHEDULE,
  CASE
    WHEN a.status_damage = 0 
    THEN "Normal" 
    WHEN a.status_damage = 1 
    THEN "Special Case" 
    WHEN a.status_damage = 2 
    THEN "Abnormal" 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN "PM" 
    WHEN a.pm = 1 
    THEN "Non-PM" 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN "BD1" 
    WHEN a.status_level = 1 
    THEN "BD2" 
    WHEN a.status_level = 2 
    THEN "BD3" 
    WHEN a.status_level = 3 
    THEN "BD4" 
    WHEN a.status_level = 4 
    THEN "CLOSED" 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN "OPEN" 
    WHEN a.status_bd = 1 
    THEN "CLOSED" 
  END AS status_bd,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN "Day" 
    WHEN a.shift = 1 
    THEN "Night" 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN "Fixed Cost" 
    WHEN a.status_cost = 1 
    THEN "Estimate Cost" 
    WHEN a.status_cost = 2 
    THEN "Warranty" 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
		*/
    if ($code_unit) {
      $code_unit = "AND a.nap = '".$code_unit."'";
    }

    if ($type) {
      $type = "AND a.type = '".$type."' ";
    }

    if (is_numeric($status_bd)) {
      $status_bd = "AND a.sts_bd = ".$status_bd."";
    }

    if (is_numeric($status_level)) {
      $status_level = "AND a.sts_lvl = ".$status_level." ";
    }



    $this->db->query('SET @start_date = "'.$filter_start_date.'";');
    $this->db->query('SET @end_date = "'.$filter_end_date.'";');
		$query = $this->db->query("select a.* FROM
(SELECT 
  a.no_kwitansi,
  a.date_finish_estimate,
  CASE
  WHEN a.status_parts_job = 0 THEN 'Waiting Part'
  WHEN a.status_parts_job = 1 THEN 'Part(s) Completed'
  WHEN a.status_parts_job = 2 THEN 'Job On Progress'
  END AS status_parts_job,
  a.date_start,
  a.nap,
  b.groups,
  b.code_unit,
  b.serial_number,
  b.type,
  a.status_level AS sts_lvl,
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS schedule,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 1 
    AND DATE(a.date_finished) BETWEEN @start_date AND @end_date
    UNION ALL
    SELECT 
  a.no_kwitansi,
  a.date_finish_estimate,
  CASE
  WHEN a.status_parts_job = 0 THEN 'Waiting Part'
  WHEN a.status_parts_job = 1 THEN 'Part(s) Completed'
  WHEN a.status_parts_job = 2 THEN 'Job On Progress'
  END AS status_parts_job,
  a.date_start,
  a.nap,
  b.groups,
  b.code_unit,
  b.serial_number,
  b.type,
  a.status_level AS sts_lvl,
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS schedule,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a
    WHERE a.status_bd is not null ".$code_unit." ".$type." ".$status_bd." ".$status_level." ");
    /*DATE(a.date_start) BETWEEN @start_date AND @end_date OR DATE(a.date_finished) BETWEEN @start_date AND @end_date  */
		return $query->result();
	}

  private function _get_datatables_query_xls()
    {
        //add custom filter here
        if($this->input->post('f_code_unit'))
            {
                $this->db->where('a.nap', $this->input->post('f_code_unit'));
            }
        if($this->input->post('f_type'))
            {
                $this->db->where('a.type', $this->input->post('f_type'));
            }
        if(is_numeric($this->input->post('f_status_bd')))
            {
                $this->db->where('a.sts_bd', $this->input->post('f_status_bd'));
            }
        if(is_numeric($this->input->post('f_status_level')))
            {
                $this->db->where('a.sts_lvl', $this->input->post('f_status_level'));
            }
        /*if($this->input->post("f_start_date") || $this->input->post("f_end_date"))
            {
                $this->db->where('DATE(a.tanggal_start) BETWEEN "'.$this->input->post("f_start_date").'" AND "'.$this->input->post("f_end_date").'" OR DATE(a.tanggal_finish) BETWEEN "'.$this->input->post("f_start_date").'" AND "'.$this->input->post("f_end_date").' "');
            }*/
        /*  unremarks this for additional form filter data
        if($this->input->post('filter_empcode'))
            {
                $this->db->where('emp_master.empcode', $this->input->post('filter_empcode'));
            }
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
        /*SELECT a.id, a.pin, b.empname, DATE(a.date_time) AS tanggal, a.date_time, a.ver, a.status FROM absen_finger a LEFT JOIN emp_master b
ON a.pin = b.badgenumber*/
/*SELECT a.id, a.pin,b.empcode, b.empname, DATE(a.date_time) AS tanggal, a.date_time, a.ver, a.status FROM absen_finger a LEFT JOIN emp_master b
ON a.pin = b.badgenumber WHERE b.empcode = 1800001 AND a.date_time BETWEEN "2018-05-07" AND "2018-05-21" AND b.empcode IN (SELECT DISTINCT(empcode) AS empcode FROM gang_master WHERE id_gang = 11)*/
       $this->db->select('a.*, b.group_name');
      $this->db->from("
        (SELECT 
  a.no_kwitansi,
  a.part_replacment,
  b.type,
  b.model,
  b.serial_number,
  b.manufacturer,
  b.groups,
  b.work_unit,
  LEFT(a.date_start,10) tanggal_start,
  RIGHT(a.date_start,8) jam_start,
  LEFT(a.date_finished,10) tanggal_finish,
  RIGHT(a.date_finished,8) jam_finish,
  a.nap, 
  b.code_unit,
  a.status_level AS sts_lvl, 
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS schedule,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  CASE
    WHEN a.status_bd = 0 
    THEN 'BREAKDOWN' 
    WHEN a.status_bd = 1 
    THEN 'OPERASI' 
  END AS status_work,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  get_empname(a.operator) AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 1 
    AND DATE(a.date_finished) BETWEEN '".$this->input->post("f_start_date")."' AND '".$this->input->post("f_end_date")."'
    UNION ALL
    SELECT 
  a.no_kwitansi,
  a.part_replacment,
  b.type,
  b.model,
  b.serial_number,
  b.manufacturer,
  b.groups,
  b.work_unit,
  LEFT(a.date_start,10) tanggal_start,
  RIGHT(a.date_start,8) jam_start,
  LEFT(a.date_finished,10) tanggal_finish,
  RIGHT(a.date_finished,8) jam_finish,
  a.nap, 
  b.code_unit,
  a.status_level AS sts_lvl, 
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS schedule,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  CASE
    WHEN a.status_bd = 0 
    THEN 'BREAKDOWN' 
    WHEN a.status_bd = 1 
    THEN 'OPERASI' 
  END AS status_work,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  get_empname(a.operator) AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a");
        $this->db->join('master_group b','a.groups = b.group_code','left');
        $this->db->order_by('a.status_bd','asc');
        //$this->db->join('master_vendor c','a.progress_by = c.id_vendor','left');
        $this->db->limit('5000');
        /*$this->db->where('a.empcode = b.empcode');
        $this->db->where('a.allowded_code = c.allowded_code');*/
        //$this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');

        /*select a.empcode, b.empname, a.adhoc_date, a.allowded_code, c.description, a.amount
from empallded a, emp_master b, master_adhoc c
where a.empcode = b.empcode
and a.allowded_code = c.allowded_code*/

        //$this->db->where_in('site_id','2102','2202');

        $i = 0;
    
        foreach ($this->column_search_xls as $item) // loop column 
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

                if(count($this->column_search_xls) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_xls[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_xls()
    {
        $this->_get_datatables_query_xls();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_xls()
    {
        $this->_get_datatables_query();
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_xls()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function test()
    {
      $this->db->select('a.*');
      $this->db->from("
        (SELECT 
  a.no_kwitansi,
  b.type,
  b.model,
  b.serial_number,
  b.manufacturer,
  b.groups,
  b.work_unit,
  LEFT(a.date_start,10) tanggal_start,
  RIGHT(a.date_start,8) jam_start,
  LEFT(a.date_finished,10) tanggal_finish,
  RIGHT(a.date_finished,8) jam_finish,
  a.nap, 
  b.code_unit,
  a.status_level AS sts_lvl, 
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS SCHEDULE,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  CASE
    WHEN a.status_bd = 0 
    THEN 'BREAKDOWN' 
    WHEN a.status_bd = 1 
    THEN 'OPERASI' 
  END AS status_work,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 1 
    AND DATE(a.date_finished) BETWEEN DATE_ADD(CURDATE( ),INTERVAL - 1 DAY) AND CURDATE()
    UNION ALL
    SELECT 
  a.no_kwitansi,
  b.type,
  b.model,
  b.serial_number,
  b.manufacturer,
  b.groups,
  b.work_unit,
  LEFT(a.date_start,10) tanggal_start,
  RIGHT(a.date_start,8) jam_start,
  LEFT(a.date_finished,10) tanggal_finish,
  RIGHT(a.date_finished,8) jam_finish,
  a.nap, 
  b.code_unit,
  a.status_level AS sts_lvl, 
  a.status_bd AS sts_bd,
  CASE
    WHEN a.task = 0 
    THEN 'Primary' 
    WHEN a.task = 1 
    THEN 'Secondary' 
  END AS task,
  CASE
    WHEN a.SCHEDULE = 0 
    THEN 'Scheduled' 
    WHEN a.SCHEDULE = 1 
    THEN 'Un-Scheduled' 
  END AS SCHEDULE,
  CASE
    WHEN a.status_damage = 0 
    THEN 'Normal' 
    WHEN a.status_damage = 1 
    THEN 'Special Case' 
    WHEN a.status_damage = 2 
    THEN 'Abnormal' 
  END AS status_damage,
  CASE
    WHEN a.pm = 0 
    THEN 'PM' 
    WHEN a.pm = 1 
    THEN 'Non-PM' 
  END AS pm,
  CASE
    WHEN a.status_level = 0 
    THEN 'BD1' 
    WHEN a.status_level = 1 
    THEN 'BD2' 
    WHEN a.status_level = 2 
    THEN 'BD3' 
    WHEN a.status_level = 3 
    THEN 'BD4' 
    WHEN a.status_level = 4 
    THEN 'CLOSED' 
  END AS status_level,
  CASE
    WHEN a.status_bd = 0 
    THEN 'OPEN' 
    WHEN a.status_bd = 1 
    THEN 'CLOSED' 
  END AS status_bd,
  CASE
    WHEN a.status_bd = 0 
    THEN 'BREAKDOWN' 
    WHEN a.status_bd = 1 
    THEN 'OPERASI' 
  END AS status_work,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE
    WHEN a.shift = 0 
    THEN 'Day' 
    WHEN a.shift = 1 
    THEN 'Night' 
  END AS shift,
  a.operator AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE
    WHEN a.status_cost = 0 
    THEN 'Fixed Cost' 
    WHEN a.status_cost = 1 
    THEN 'Estimate Cost' 
    WHEN a.status_cost = 2 
    THEN 'Warranty' 
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma 
FROM
  vehicle_breakdown a 
  INNER JOIN vehicle_master b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a");
$query = $this->db->get();
        return $query->result();
    }

    public function rpt_progress_unit()
    {
      $query = $this->db->query("select 
  a.model,
  a.code_unit,
  a.year,
  a.date_receive,
  b.hm,
  DATE(b.date_start) AS date_start,
  CASE
  WHEN b.date_start IS NOT NULL THEN  CURDATE()
  END AS date_now,
  DATEDIFF(CURDATE(),DATE(b.date_start)) AS hari,
  CASE
  WHEN b.date_start IS NOT NULL THEN 'BREAKDOWN'
  ELSE 'RUNNING'
  END AS status_unit,
  b.remarks_machine,
  b.status_parts_job
  
FROM
  (SELECT 
    model,
    nap,
    code_unit,
    TYPE,
    YEAR,
    date_receive
  FROM
    vehicle_master 
  WHERE groups != 1 
    AND active = 1 AND model LIKE '%EXCAVATOR%' OR MODEL LIKE '%DUMP%' OR MODEL LIKE '%GRADER%' OR MODEL LIKE '%HIGHWAY%'
  ORDER BY model,
    code_unit) a 
  LEFT JOIN 
  (
  SELECT 
  a.nap,
  a.no_kwitansi,
  a.date_finish_estimate,
  CASE
  WHEN a.status_parts_job = 0 THEN 'Waiting Part'
  WHEN a.status_parts_job = 1 THEN 'Part(s) Completed'
  WHEN a.status_parts_job = 2 THEN 'Job On Progress'
  END AS status_parts_job,
  a.date_start,
  a.hm,
  a.remarks_machine,
  a.reason_bd
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT nap FROM vehicle_master WHERE active = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
  ) b ON a.nap = b.nap ORDER BY a.model, a.code_unit");

      return $query->result_array();
    }

    public function model_unit()
    {
      /*SELECT DISTINCT(a.model), COUNT(a.code_unit) FROM(SELECT 
  a.model,
  a.nap,
  a.code_unit,
  a.type,
  a.year,
  a.date_receive,
  b.hm,
  DATE(b.date_start) AS date_start,
  CASE
  WHEN b.date_start IS NOT NULL THEN "BREAKDOWN"
  ELSE "RUNNING"
  END AS status_unit,
  CASE
  WHEN b.date_start IS NOT NULL THEN  CURDATE()
  END AS date_now,
  DATEDIFF(CURDATE(),DATE(b.date_start)) AS hari,
  b.remarks_machine,
  b.status_parts_job
  
FROM
  (SELECT 
    model,
    nap,
    code_unit,
    TYPE,
    YEAR,
    date_receive
  FROM
    vehicle_master 
  WHERE groups != 1 
    AND active = 1 AND model LIKE '%EXCAVATOR%' OR MODEL LIKE '%DUMP%' OR MODEL LIKE '%GRADER%' OR MODEL LIKE '%HIGHWAY%'
  ORDER BY model,
    code_unit) a 
  LEFT JOIN 
  (
  SELECT 
  a.nap,
  a.no_kwitansi,
  a.date_finish_estimate,
  CASE
  WHEN a.status_parts_job = 0 THEN "Waiting Part"
  WHEN a.status_parts_job = 1 THEN "Part(s) Completed"
  WHEN a.status_parts_job = 2 THEN "Job On Progress"
  END AS status_parts_job,
  a.date_start,
  a.hm,
  a.remarks_machine,
  a.reason_bd
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT nap FROM vehicle_master WHERE active = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
  ) b ON a.nap = b.nap ORDER BY a.model) a GROUP BY a.model ORDER BY a.model*/

  $query = $this->db->query("select DISTINCT(a.model), COUNT(a.code_unit) as jml_row FROM(SELECT 
  a.model,
  a.nap,
  a.code_unit,
  a.type,
  a.year,
  a.date_receive,
  b.hm,
  DATE(b.date_start) AS date_start,
  CASE
  WHEN b.date_start IS NOT NULL THEN 'BREAKDOWN'
  ELSE 'RUNNING'
  END AS status_unit,
  CASE
  WHEN b.date_start IS NOT NULL THEN  CURDATE()
  END AS date_now,
  DATEDIFF(CURDATE(),DATE(b.date_start)) AS hari,
  b.remarks_machine,
  b.status_parts_job
  
FROM
  (SELECT 
    model,
    nap,
    code_unit,
    TYPE,
    YEAR,
    date_receive
  FROM
    vehicle_master 
  WHERE groups != 1 
    AND active = 1 AND model LIKE '%EXCAVATOR%' OR MODEL LIKE '%DUMP%' OR MODEL LIKE '%GRADER%' OR MODEL LIKE '%HIGHWAY%'
  ORDER BY model,
    code_unit) a 
  LEFT JOIN 
  (
  SELECT 
  a.nap,
  a.no_kwitansi,
  a.date_finish_estimate,
  CASE
  WHEN a.status_parts_job = 0 THEN 'Waiting Part'
  WHEN a.status_parts_job = 1 THEN 'Part(s) Completed'
  WHEN a.status_parts_job = 2 THEN 'Job On Progress'
  END AS status_parts_job,
  a.date_start,
  a.hm,
  a.remarks_machine,
  a.reason_bd
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT nap FROM vehicle_master WHERE active = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
  ) b ON a.nap = b.nap ORDER BY a.model) a GROUP BY a.model ORDER BY a.model");

  return $query->result_array();
    }




}


/*end of breakdown unit model*/