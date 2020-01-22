<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Breakdown_model extends CI_Model
{
	
	var $table = 'vehicle_breakdown';
    var $column_order = array('b.code_unit','a.nap', 'a.no_kwitansi', 'a.remarks_machine', 'a.reason_bd', 'c.nama_vendor'); //set column field database for datatable orderable
    var $column_search = array('b.code_unit','a.nap', 'a.no_kwitansi', 'a.remarks_machine', 'a.reason_bd', 'c.nama_vendor'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    /*untuk datatable excel*/
    var $column_order_xls = array('a.code_unit','a.nap', 'a.no_kwitansi', 'a.remarks_machine', 'a.reason_bd', 'c.nama_vendor'); //set column field database for datatable orderable
    var $column_search_xls = array('a.code_unit','a.nap', 'a.no_kwitansi', 'a.remarks_machine', 'a.reason_bd', 'a.nama_vendor'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    /*end of datatable excl parameter*/
    var $order = array('a.no_kwitansi' => 'desc'); // default order 
    function __construct()
    {
        parent::__construct();
        $this->load->helper('parse_helper');
        
    }

    private function _get_datatables_query()
    {

        //add custom filter here
        if(is_numeric($this->input->post('filter_show')))
        {
          if ($this->input->post('filter_show') > 1) {
            $this->db->where('a.status_bd is not null');
          }
          else
          {

              $this->db->where('a.status_bd', $this->input->post('filter_show'));
          }
        }

        if ($this->input->post('filter_code_unit')) {
          $this->db->where('a.nap', $this->input->post('filter_code_unit'));
        }

            if ($this->input->post('f_gang_f')) {
                $this->db->where("`b.empcode` IN (SELECT DISTINCT(`empcode`) AS empcode FROM `gang_master` WHERE id_gang = '".$this->input->post('f_gang_f')."')");
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('DATE(a.date_start) BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }
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
        $this->db->select("
          a.id_rn,
  a.no_kwitansi,
  a.date_start,
  a.date_finish_estimate,
  a.nap,
  b.code_unit,
  CASE 
  WHEN a.task = 0 THEN 'Primary'
  WHEN a.task = 1 THEN 'Secondary'
  END AS task,
  CASE
  WHEN a.SCHEDULE = 0 THEN 'Scheduled' 
  WHEN a.SCHEDULE = 1 THEN 'Un-Scheduled' 
  END AS schedule,
  CASE
  WHEN a.status_damage = 0 THEN 'Normal'
  WHEN a.status_damage = 1 THEN 'Special Case'
  WHEN a.status_damage = 2 THEN 'Abnormal'
  END AS status_damage,
  CASE 
  WHEN a.pm = 0 THEN 'PM'
  WHEN a.pm = 1 THEN 'Non-PM' 
  END AS pm,
  CASE 
  WHEN a.status_level = 0 THEN 'BD1'
  WHEN a.status_level = 1 THEN 'BD2'
  WHEN a.status_level = 2 THEN 'BD3'
  WHEN a.status_level = 3 THEN 'BD4'
  WHEN a.status_level = 4 THEN 'CLOSED'
  END AS status_level,
  CASE 
  WHEN a.status_bd = 0 THEN 'OPEN'
  WHEN a.status_bd = 1 THEN 'CLOSED'
  END AS status_bd,
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  CASE 
  WHEN a.shift = 0 THEN 'Day'
  WHEN a.shift = 1 THEN 'Night'
  END AS shift,
  get_empname(a.operator) AS operator,
  a.remarks_machine,
  a.reason_bd,
  a.date_finished,
  a.no_pr_sr,
  a.no_po,
  a.cost_estimate,
  CASE 
  WHEN a.status_cost = 0 THEN 'Fixed Cost'
  WHEN a.status_cost = 1 THEN 'Estimate Cost'
  WHEN a.status_cost = 2 THEN 'Warranty'
  END AS status_cost,
  a.possible_work,
  a.total_down_time,
  a.ma");
        $this->db->from('vehicle_breakdown a');
        $this->db->join('vehicle_master b','a.nap = b.nap','left');
        $this->db->join('master_vendor c','a.progress_by = c.id_vendor','left');
        //$this->db->where("a.status_bd != 1 or date(a.date_finished) >= date_add(curdate( ), interval -1 day) ");
        $this->db->order_by('a.date_finished, a.date_start','DESC');
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
		$this->db->insert("vehicle_breakdown",$data);
		return $this->db->insert_id();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_rn',$id);
		$this->db->delete($this->table);
	}

	public function get_unit_bd_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_rn', $id);
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

  public function get_hm_update($nap, $period, $year)
  {
    /*model ini akan menampilkan data hm terupdate dari nap dan period dan tahun yang di pilih dari request ajax*/
    /*SELECT nap, YEAR, period, hm_update FROM daily_hmkm WHERE period = 11 AND YEAR = 2018 AND nap = '5-10'*/
    $query = $this->db->query("select nap, year, period, hm_update FROM daily_hmkm WHERE nap = '".$nap."' AND period = '".$period."' AND year = '".$year."' ");
    return $query->row();
  }

  public function cek_kwitansi($no_kwitansi)
  {
    $this->db->select('no_kwitansi, date_start, nap');
    $this->db->from('vehicle_breakdown');
    $this->db->where('no_kwitansi',$no_kwitansi);
    $query = $this->db->get();
    return $query->row();
  }

  public function cek_date_estimate_expierd()
  {
    $this->db->select('nap');
    $this->db->from('vehicle_breakdown');
    $this->db->where('status_bd','0');
    $this->db->where('date_finish_estimate <= NOW()');
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function cek_pr_by_status_level()
  {
    $this->db->select('nap');
    $this->db->from('vehicle_breakdown');
    $this->db->where('status_bd',0);
    $this->db->where('status_level', 1);
    $this->db->where('no_pr_sr','');
    $query = $this->db->get();
    return $query->num_rows();

  }

  public function rpt_downtime_daily_v03($filter_start_date, $filter_end_date, $code_unit, $type, $status_bd, $status_level)
  {
    
    switch ($status_bd) {
      case 0:
      # untuk detail breakdown
      $query = $this->db->query("CALL rpt_bd_summary_report('".$filter_start_date."','".$filter_end_date."', NULL)");
      break;
      
      default:
      # untuk all breakdown
      $query = $this->db->query("CALL rpt_bd_summary_report('".$filter_start_date."','".$filter_end_date."', 'CLOSED')");

        break;
    }
    mysqli_next_result($this->db->conn_id);

    return $query->result();
  }

  public function rpt_downtime_daily_v02($filter_start_date, $filter_end_date, $code_unit, $type, $status_bd, $status_level)
  {
    if ($code_unit) {
      $code_unit = "AND a.nap = '".$code_unit."'";
    }

    if ($type) {
      $type = "AND a.type = '".$type."'";
    }

    if (is_numeric($status_bd)) {
      $status_bd = "AND b.status_bd = 'OPEN'";
      $status_bd_join = "AND a.status_bd = 'OPEN'";
    }

    if (is_numeric($status_level)) {
      $status_level = "AND a.sts_lvl = ".$status_level." ";
    }
    $this->db->query('SET @start_date = "'.$filter_start_date.'";');
    $this->db->query('SET @end_date = "'.$filter_end_date.'";');
    $this->db->query('SET @awal_shift = CONCAT(@start_date, " 05:00");');
    $this->db->query('SET @akhir_shift = CONCAT(@start_date + INTERVAL 1 DAY, " 05:00");');
    $this->db->query('SET @awal_shift_date_finished = CONCAT(@end_date, " 05:00");');
    $query = $this->db->query("
    SELECT
    b.code_unit,
b.serial_number,
b.nap,
b.remarks_machine,
b.status_bd,
b.hm,
b.date_start,
b.status_damage,
b.date_finished,
a.pa_gab,
a.ua_gab,
a.ma_gab,
ROUND(COALESCE(b.jam_bd,0),2) AS jam_bd,
a.hari_bd,
a.wh,
b.status_level,
b.schedule,
b.progress_by,
b.date_finish_estimate,
b.status_parts_job,
b.no_po,
b.no_pr_sr,
a.reason_bd
    FROM
(select a.id_rn,
  a.date,
  b.date_start,
  b.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
  b.schedule,
  b.progress_by,
  b.status_damage,
  b.status_level,
  b.date_finish_estimate,
  b.status_parts_job,
  b.no_po,
  b.no_pr_sr,
  b.remarks_machine,
  b.reason_bd,
  b.hm,
  ROUND(SUM(a.total_hm),1) AS wh,
  a.total_ritase,
  a.total_bcm_ton, 
  COALESCE(b.status_bd, 'OPERATIONS') AS status_bd,
  ROUND(COALESCE(b.tdhr,0),2) AS jam_bd,
  COALESCE(b.tdhy,0) AS hari_bd,
  CASE
  WHEN b.status_bd IS NULL THEN ROUND(19 - ROUND(SUM(a.total_hm),1),1)
  WHEN b.status_bd = 'CLOSED' THEN ROUND(19 - ROUND(SUM(a.total_hm),1) - b.tdhr,1)
  WHEN b.status_bd = 'OPEN' THEN 0
  END AS stand_by,
  b.ma AS ma_ayu,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0.0 THEN 100.00
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + 0) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + b.tdhr) * 100,2),'-') 
  WHEN b.tdhr < 19 THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) =0.00 THEN COALESCE(ROUND(19/ (19 + b.tdhr) * 100,2),'-') 
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + b.tdhr) * 100,2),'-') 
  END
  END AS ma_gab,
  b.ua AS ua_ayu,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0 THEN 0.00
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - 0)) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN 0.00
  WHEN b.tdhr < 19 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr)) * 100,2),'-')  
  END AS ua_gab,
  b.pa AS pa_ayu,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0.00 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - 0)) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - 0) + 0 ) * 100,2),'-')
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - 0)) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - 0) + 0 ) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN 0.00
  WHEN b.tdhr < 19 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr)) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr) + b.tdhr ) * 100,2),'-') 
  END AS pa_gab 
FROM
  vehicle_daily_activity a RIGHT JOIN (
  SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start > @awal_shift AND a.date_finished < @akhir_shift OR @date_finished > @awal_shift_date_finished
UNION ALL
SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start < @awal_shift 
AND a.date_finished < @akhir_shift AND a.date_finished > @awal_shift OR a.date_finished > @awal_shift_date_finished 
UNION ALL
SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) AS tdhr,
  0 AS stand_by,
  0 AS ma,
  0 AS ua,
  0 AS pa,
  FLOOR(ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE a.status_bd = 0
GROUP BY a.nap
  ) b ON a.nap = b.nap
WHERE a.date = @start_date ".$status_bd."
AND a.nap != 0 AND a.nap IS NOT NULL GROUP BY a.nap, a.date, b.status_bd ORDER BY b.status_bd, get_code_unit(a.nap) ) a
RIGHT JOIN  
(
SELECT 
a.code_unit,
a.serial_number,
a.nap,
a.remarks_machine,
a.status_bd,
a.hm,
a.date_start,
a.status_damage,
a.date_finished,
a.tdhr AS jam_bd,
a.status_level,
a.schedule,
a.progress_by,
a.date_finish_estimate,
a.status_parts_job,
a.no_po,
a.no_pr_sr
FROM
(SELECT a.* FROM (
SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap,a.date_start
) a WHERE a.date_start > @awal_shift AND a.date_finished < @akhir_shift OR @date_finished > @awal_shift_date_finished
UNION ALL
SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start < @awal_shift 
AND a.date_finished < @akhir_shift AND a.date_finished > @awal_shift OR a.date_finished > @awal_shift_date_finished 
UNION ALL
SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
  get_code_unit(a.nap) AS code_unit,
  get_sn_vehicle(a.nap) AS serial_number,
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
  get_vendor(a.progress_by) AS progress_by,
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) AS tdhr,
  0 AS stand_by,
  0 AS ma,
  0 AS ua,
  0 AS pa,
  FLOOR(ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE a.status_bd = 0
GROUP BY a.nap ) a
) b ON a.nap = b.nap where 1=1  ".$status_bd." ");
    /*DATE(a.date_start) BETWEEN @start_date AND @end_date OR DATE(a.date_finished) BETWEEN @start_date AND @end_date  */
    return $query->result();
  }

  public function rpt_pauama($start_date,$end_date)
  {
    $this->db->query("SET @start_date = '".$start_date."';");
    $this->db->query("SET @end_date = '".$end_date."';");
    $this->db->query("SET @awal_shift = CONCAT(@start_date, ' 05:00');");
    $this->db->query("SET @akhir_shift = CONCAT(@start_date + INTERVAL 1 DAY, ' 05:00');");
    $this->db->query("SET @awal_shift_date_finished = CONCAT(@end_date, ' 05:00');");
    $query = $this->db->query("
select 
get_code_unit(a.nap) AS code_unit,
  a.nap,
  c.year,
  ROUND(SUM(a.total_hm),1) AS wh,
  CASE
  WHEN b.tdhr IS NULL THEN 0.00
  WHEN b.tdhr > 19 THEN ROUND(c.pwh,2)
  WHEN b.tdhr < 19 THEN ROUND(b.tdhr,2)
  END AS jam_bd_daily,  
  CASE
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0 THEN c.pwh
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(c.pwh - ROUND(SUM(a.total_hm),1) - 0,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN  0.00
  WHEN b.tdhr < 19 THEN  COALESCE(ROUND(c.pwh - ROUND(SUM(a.total_hm),1) - b.tdhr,2),'-')
  END AS stand_by,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0.0 THEN 100.00
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + 0) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + b.tdhr) * 100,2),'-') 
  WHEN b.tdhr < 19 THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) =0.00 THEN COALESCE(ROUND(c.pwh/ (c.pwh + b.tdhr) * 100,2),'-') 
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + b.tdhr) * 100,2),'-') 
  END
  END AS ma_gab,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0 THEN 0.00
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - 0)) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN 0.00
  WHEN b.tdhr < 19 THEN COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - b.tdhr)) * 100,2),'-')  
  END AS ua_gab,
  CASE 
  WHEN b.tdhr IS NULL THEN 
  CASE 
  WHEN ROUND(SUM(a.total_hm),1) = 0.00 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - 0)) / (ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - 0) + 0 ) * 100,2),'-')
  WHEN ROUND(SUM(a.total_hm),1) > 0 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - 0)) / (ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - 0) + 0 ) * 100,2),'-')
  ELSE 0.00
  END
  WHEN b.tdhr > 19 THEN 0.00
  WHEN b.tdhr < 19 THEN COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - b.tdhr)) / (ROUND(SUM(a.total_hm),1) + (c.pwh - ROUND(SUM(a.total_hm),1) - b.tdhr) + b.tdhr ) * 100,2),'-') 
  END AS pa_gab,
  MAX(hm_end) AS hmkm,
  COALESCE(b.date_start,'-') AS date_start,
  COALESCE(b.date_finished,'-') AS date_finished,
  COALESCE(b.tdhr,0.00) AS thr,
  COALESCE(b.tdhy,0) AS hari_bd,
  CASE 
  WHEN b.status_bd IS NULL THEN 'Running'
  WHEN b.status_bd = 'CLOSED' THEN 'Running'
  WHEN b.status_bd = 'OPEN' THEN 'Breakdown'
  END AS sts_bd,
  COALESCE(b.remarks_machine,'-') AS remarks_machine,
  COALESCE(get_vendor(b.progress_by),'-') AS progress_by,
  COALESCE(b.reason_bd,'-') AS reason_bd
FROM
  vehicle_daily_activity a LEFT JOIN (SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start > @awal_shift AND a.date_finished < @akhir_shift OR @date_finished > @awal_shift_date_finished
UNION ALL
SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start < @awal_shift 
AND a.date_finished < @akhir_shift AND a.date_finished > @awal_shift OR a.date_finished > @awal_shift_date_finished 
UNION ALL
SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) AS tdhr,
  0 AS stand_by,
  0 AS ma,
  0 AS ua,
  0 AS pa,
  FLOOR(ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE a.status_bd = 0
GROUP BY a.nap
  ) b ON a.nap = b.nap
  LEFT JOIN (SELECT nap, YEAR,  model, capacity, pwh FROM vehicle_master) c ON a.nap = c.nap
WHERE a.date = @start_date
AND a.nap != 0 AND a.nap IS NOT NULL GROUP BY a.nap, a.date ORDER BY LEFT(a.nap, INSTR(c.nap,'-')-1) DESC, c.capacity DESC
      ");
return $query->result_array();
  }

  public function rpt_downtime_daily_v01($filter_start_date, $filter_end_date, $code_unit, $type, $status_bd, $status_level)
  {
    /*
    SET @start_date = "2018-11-26" ;
SET @end_date = "2018-11-27";
SELECT a.* FROM
(SELECT 
  b.no_kwitansi,
  b.date_finish_estimate,
  b.status_parts_job,
  b.date_start,
  a.nap,
  a.groups,
  COALESCE(a.code_unit,0) AS code_unit,
  a.serial_number,
  a.type,
  COALESCE(b.sts_lvl,'4') AS sts_lvl,
  COALESCE(b.sts_bd,'1') AS sts_bd,
  b.task,
  b.schedule,
  b.status_damage,
  b.pm,
  b.status_level,
  b.status_bd,
  b.progress_by,
  b.nama_vendor,
  b.mechanic_name,
  b.location,
  CASE
  WHEN no_kwitansi IS NULL THEN a.hm_start
  WHEN no_kwitansi IS NOT NULL THEN b.hm
  END AS hm,
  b.hm_finish,
  b.shift,
  b.operator,
  b.remarks_machine,
  b.reason_bd,
  b.date_finished,
  b.no_pr_sr,
  b.no_po,
  b.cost_estimate,
  b.status_cost,
  a.total AS possible_work,
  b.total_down_time,
  COALESCE(b.ma, "100") AS ma,
  b.downtime,
  b.tdy,
  b.stand_by,
      b.pa,
      b.ua
FROM
  (SELECT 
    a.nap,
    a.date,
    a.hm_start,
    b.code_unit,
    b.serial_number,
    b.groups,
    b.type,
    ROUND(SUM(a.total_hm), 1) AS total 
  FROM
    vehicle_daily_activity a 
    LEFT JOIN (SELECT nap, code_unit, serial_number, groups, TYPE FROM vehicle_master WHERE active = 1) b
    ON a.nap = b.nap
    WHERE a.date = @start_date AND a.nap NOT IN (SELECT nap FROM vehicle_breakdown WHERE status_bd = 0)
  GROUP BY a.nap,
    a.date) a 
  LEFT JOIN 
    (SELECT 
      a.no_kwitansi,
      a.date_finish_estimate,
      CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
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
      a.progress_by,
      c.nama_vendor,
      a.mechanic_name,
      a.location,
      a.hm,
      a.hm_finish,
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
      a.ma,
      a.stand_by,
      a.pa,
      a.ua,
      CASE
        WHEN a.status_bd = 0 
        THEN ROUND(
          TIMESTAMPDIFF(
            SECOND,
            a.date_start,
            CURRENT_TIMESTAMP()
          ) / 3600,
          1
        ) 
        ELSE a.total_down_time 
      END AS downtime,
      CASE
        WHEN a.status_bd = 0 
        THEN DATEDIFF(CURDATE(), a.date_start) 
        ELSE DATEDIFF(a.date_finished, a.date_start) 
      END AS tdy 
    FROM
      vehicle_breakdown a 
      INNER JOIN 
        (SELECT 
          * 
        FROM
          vehicle_master 
        WHERE active = 1 
          AND to_rpt_bd = 1) b 
        ON a.nap = b.nap 
      INNER JOIN master_vendor c 
        ON a.progress_by = c.id_vendor 
    WHERE a.status_bd = 1 -- and a.nap = '2-01'
      AND DATE(a.date_finished) BETWEEN @start_date 
      AND @end_date 
    ORDER BY b.code_unit ASC) b 
    ON a.nap = b.nap
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
  a.progress_by,
  c.nama_vendor,
  a.mechanic_name,
  a.location,
  a.hm,
  a.hm_finish,
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
  a.ma,
  CASE 
  WHEN a.status_bd = 0 THEN ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1)
  ELSE a.ma
  END AS downtime,
  CASE
  WHEN a.status_bd = 0 THEN DATEDIFF(CURDATE(), a.date_start)
  ELSE DATEDIFF(a.date_finished, a.date_start)
  END AS tdy, 
  a.stand_by,
      a.pa,
      a.ua
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT * FROM vehicle_master WHERE active = 1 AND to_rpt_bd = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a
     ORDER BY a.status_bd, a.code_unit
    -- and a.nap = '2-01'
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
  a.hm_finish,
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
  a.ma,
  CASE 
  WHEN a.status_bd = 0 THEN ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600,1)
  ELSE a.total_down_time
  END AS downtime,
  CASE
  WHEN a.status_bd = 0 THEN DATEDIFF(CURDATE(), a.date_start)
  ELSE DATEDIFF(a.date_finished, a.date_start)
  END AS tdy,
  a.stand_by,
    a.pa,
    a.ua 
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT * FROM vehicle_master WHERE active = 1 AND to_rpt_bd = 1) b 
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
  a.hm_finish,
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
  a.ma,
  CASE 
  WHEN a.status_bd = 0 THEN ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1)
  ELSE a.ma
  END AS downtime,
  CASE
  WHEN a.status_bd = 0 THEN DATEDIFF(CURDATE(), a.date_start)
  ELSE DATEDIFF(a.date_finished, a.date_start)
  END AS tdy,
  a.stand_by,
      a.pa,
      a.ua
FROM
  vehicle_breakdown a 
  INNER JOIN  (SELECT * FROM vehicle_master WHERE active = 1 AND to_rpt_bd = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a
    WHERE a.nap is not null ".$code_unit." ".$type." ".$status_bd." ".$status_level." order by a.status_bd, a.code_unit ");
    /*DATE(a.date_start) BETWEEN @start_date AND @end_date OR DATE(a.date_finished) BETWEEN @start_date AND @end_date  */
    return $query->result();
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
  a.hm_finish,
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
  a.ma,
  CASE 
  WHEN a.status_bd = 0 THEN ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600,1)
  ELSE a.total_down_time
  END AS downtime,
  CASE
  WHEN a.status_bd = 0 THEN DATEDIFF(CURDATE(), a.date_start)
  ELSE DATEDIFF(a.date_finished, a.date_start)
  END AS tdy,
  a.stand_by,
  a.pa,
  a.ua
FROM
  vehicle_breakdown a 
  INNER JOIN (SELECT * FROM vehicle_master WHERE active = 1 AND to_rpt_bd = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 1 
    -- and a.nap = '2-01'
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
  a.hm_finish,
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
  a.ma,
  CASE 
  WHEN a.status_bd = 0 THEN ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1)
  ELSE a.ma
  END AS downtime,
  CASE
  WHEN a.status_bd = 0 THEN DATEDIFF(CURDATE(), a.date_start)
  ELSE DATEDIFF(a.date_finished, a.date_start)
  END AS tdy,
  a.stand_by,
      a.pa,
      a.ua
FROM
  vehicle_breakdown a 
  INNER JOIN  (SELECT * FROM vehicle_master WHERE active = 1 AND to_rpt_bd = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0) a
    WHERE a.nap is not null ".$code_unit." ".$type." ".$status_bd." ".$status_level." order by a.status_bd, a.code_unit ");
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
  CASE
  WHEN c.hm_update IS NOT NULL THEN c.hm_update
  WHEN b.hm IS NOT NULL THEN b.hm
  WHEN b.hm IS NULL THEN c.hm_update
  END AS hm,
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
    AND active = 1 AND to_rpt_hm = 1 AND model LIKE '%EXCAVATOR%' OR MODEL LIKE '%DUMP%' OR MODEL LIKE '%GRADER%' OR MODEL LIKE '%HIGHWAY%' OR MODEL LIKE '%PM%'OR MODEL LIKE '%POMPA%' OR MODEL LIKE '%WATER TRUCK%' OR MODEL LIKE '%LUBE TRUCK%' OR MODEL LIKE '%FUEL TRUCK%'
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
  INNER JOIN (SELECT nap FROM vehicle_master WHERE active = 1 AND to_rpt_hm = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
  ) b ON a.nap = b.nap LEFT JOIN (SELECT nap, MAX(hm_update) AS hm_update FROM daily_hmkm GROUP BY nap) c ON a.nap = c.nap ORDER BY a.model, a.code_unit");

      return $query->result_array();
    }

    public function model_unit_v1($filter_start_date,$filter_end_date)
    {
      $this->db->query('SET @start_date = "'.$filter_start_date.'";');
    $this->db->query('SET @end_date = "'.$filter_end_date.'";');
    $this->db->query('SET @awal_shift = CONCAT(@start_date, " 05:00");');
    $this->db->query('SET @akhir_shift = CONCAT(@start_date + INTERVAL 1 DAY, " 05:00");');
    $this->db->query('SET @awal_shift_date_finished = CONCAT(@end_date, " 05:00");');
      $query = $this->db->query("
        select DISTINCT(a.model), COUNT(a.code_unit) AS jml_row FROM
(SELECT 
get_code_unit(a.nap) AS code_unit,
  a.nap,
  c.year,
  c.model,
  c.capacity,
  ROUND(SUM(a.total_hm),1) AS wh,
  CASE
  WHEN b.tdhr IS NULL THEN '-'
  WHEN b.tdhr > 19 THEN 19
  WHEN b.tdhr < 19 THEN b.tdhr
  END AS jam_bd_daily,  
  COALESCE(ROUND(19 - ROUND(SUM(a.total_hm),1) - b.tdhr,2),'-') AS stand_by,
  COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + b.tdhr) * 100,2),'-') AS ma_gab,
  COALESCE(ROUND(ROUND(SUM(a.total_hm),1) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr)) * 100,2),'-')  AS ua_gab,
  COALESCE(ROUND((ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr)) / (ROUND(SUM(a.total_hm),1) + (19 - ROUND(SUM(a.total_hm),1) - b.tdhr) + b.tdhr ) * 100,2),'-') AS pa_gab,
  MAX(hm_end) AS hmkm,
  COALESCE(b.date_start,'-') AS date_start,
  COALESCE(b.date_finished,'-') AS date_finished,
  COALESCE(b.tdhr,'-') AS thr,
  COALESCE(b.tdhy,'-') AS hari_bd,
  CASE 
  WHEN b.status_bd IS NULL THEN 'Running'
  WHEN b.status_bd = 'CLOSED' THEN 'Running'
  WHEN b.status_bd = 'OPEN' THEN 'Breakdown'
  END AS sts_bd,
  COALESCE(b.remarks_machine,'-') AS remarks_machine,
  COALESCE(get_vendor(b.progress_by),'-') AS progress_by,
  COALESCE(b.reason_bd,'-') AS reason_bd
FROM
  vehicle_daily_activity a LEFT JOIN (SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start > @awal_shift AND a.date_finished < @akhir_shift OR @date_finished > @awal_shift_date_finished
UNION ALL
SELECT a.* FROM (SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  SUM(a.total_down_time) AS tdhr,
  a.stand_by,
  a.ma,
  a.ua,
  a.pa,
  FLOOR(a.total_down_time / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE DATE(a.date_finished) BETWEEN @start_date 
  AND @end_date 
GROUP BY a.nap) a WHERE a.date_start < @awal_shift 
AND a.date_finished < @akhir_shift AND a.date_finished > @awal_shift OR a.date_finished > @awal_shift_date_finished 
UNION ALL
SELECT 
  a.id_rn,
  a.date_start,
  a.date_finished,
  a.nap,
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
  a.hm,
  a.shift,
  a.remarks_machine,
  a.reason_bd,
  a.date_finish_estimate,
  CASE
        WHEN a.status_parts_job = 0 
        THEN 'Waiting Part' 
        WHEN a.status_parts_job = 1 
        THEN 'Part(s) Completed' 
        WHEN a.status_parts_job = 2 
        THEN 'Job On Progress' 
      END AS status_parts_job,
  a.no_po,
  a.no_pr_sr,
  a.possible_work,
  ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) AS tdhr,
  0 AS stand_by,
  0 AS ma,
  0 AS ua,
  0 AS pa,
  FLOOR(ROUND(TIMESTAMPDIFF(SECOND, a.date_start, CURRENT_TIMESTAMP()) / 3600, 1) / 24) AS tdhy
FROM
  vehicle_breakdown a 
WHERE a.status_bd = 0
GROUP BY a.nap
  ) b ON a.nap = b.nap
  LEFT JOIN (SELECT nap, YEAR, model, capacity FROM vehicle_master) c ON a.nap = c.nap
WHERE a.date = @start_date
AND a.nap != 0 AND a.nap IS NOT NULL GROUP BY a.nap, a.date ORDER BY LEFT(a.nap, INSTR(c.nap,'-')-1) DESC, c.capacity DESC) a GROUP BY a.model ORDER BY LEFT(a.nap, INSTR(a.nap,'-')-1) DESC, a.capacity DESC");
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
    AND active = 1 AND to_rpt_hm = 1 AND model LIKE '%EXCAVATOR%' OR MODEL LIKE '%DUMP%' OR MODEL LIKE '%GRADER%' OR MODEL LIKE '%HIGHWAY%' OR MODEL LIKE '%PM%' OR MODEL LIKE '%POMPA%' OR MODEL LIKE '%WATER TRUCK%' OR MODEL LIKE '%LUBE TRUCK%' OR MODEL LIKE '%FUEL TRUCK%'
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
  INNER JOIN (SELECT nap FROM vehicle_master WHERE active = 1 AND to_rpt_hm = 1) b 
    ON a.nap = b.nap 
    INNER JOIN master_vendor c ON a.progress_by = c.id_vendor
    WHERE a.status_bd = 0
  ) b ON a.nap = b.nap ORDER BY a.model) a GROUP BY a.model ORDER BY a.model");

  return $query->result_array();
    }




}


/*end of breakdown unit model*/