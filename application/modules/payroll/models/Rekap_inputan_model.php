<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_inputan_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function rpt_inputan_header($month, $year, $departement)
	{
		if($month || $year)
        {
            $back_year = $year-1;
            switch ($month) {
                    case 1:
            $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-26" AND "'.$year.'-01-25"');
            $filter_start_date  = $back_year.'-12-26';
            $filter_end_date    = $year.'-01-25';
                    break;
                    case 2:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
            $filter_start_date  = $year.'-01-26';
            $filter_end_date    = $year.'-02-25';     
                    break;
                    case 3:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
            $filter_start_date  = $year.'-02-26';
            $filter_end_date    = $year.'-03-25';       
                    break;
                    case 4:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
            $filter_start_date  = $year.'-03-26';
            $filter_end_date    = $year.'-04-25';       
                    break;
                    case 5:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
            $filter_start_date  = $year.'-04-26';
            $filter_end_date    = $year.'-05-25';       
                    break;
                    case 6:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
            $filter_start_date  = $year.'-05-26';
            $filter_end_date    = $year.'-06-25';       
                    break;
                    case 7:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
            $filter_start_date  = $year.'-06-26';
            $filter_end_date    = $year.'-07-25';       
                    break;
                    case 8:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
            $filter_start_date  = $year.'-07-26';
            $filter_end_date    = $year.'-08-25';       
                    break;
                    case 9:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
            $filter_start_date  = $year.'-08-26';
            $filter_end_date    = $year.'-09-25';       
                    break;
                    case 10:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
            $filter_start_date  = $year.'-09-26';
            $filter_end_date    = $year.'-10-25';       
                    break;
                    case 11;
            $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-25"');
            $filter_start_date  = $year.'-10-26';
            $filter_end_date    = $year.'-11-25';       
                    break;
                    case 12:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-12-26" AND "'.$year.'-01-25"');
            $filter_start_date  = $year.'-11-26';
            $filter_end_date    = $year.'-12-25';       
                    break;
            }
		$this->db->query("SET @start_date = '".$filter_start_date."'");
		$this->db->query("SET @end_date = '".$filter_end_date."'");
		$query = $this->db->query("
			select DISTINCT(a.empcode), b.nik_pim, b.empname, 
  b.dept_desc,
  b.position_desc,
  b.upah,
  b.departement,
  b.kehadiran_pagi,
  b.uang_makan,
  b.golongan
FROM
  gang_activity a LEFT JOIN (
SELECT 
  a.empcode,
  a.nik_pim,
  a.empname,
  a.departement,
  d.dept_desc,
  c.position_desc,
  b.upah,
  b.kehadiran_pagi,
  b.uang_makan,
  e.golongan
FROM
  emp_master a LEFT JOIN hr_hist_status b ON a.empcode = b.empcode
  LEFT JOIN master_position c ON a.position = c.id_position
  LEFT JOIN master_dept d ON a.departement = d.departement
  LEFT JOIN master_golongan e ON b.grade = e.id_golongan
WHERE dateterminate IS NULL 
  AND a.empcode NOT IN 
  (SELECT 
    empcode 
  FROM
    hr_termination)) b ON a.empcode = b.empcode
WHERE a.attd_date BETWEEN @start_date 
  AND @end_date and b.departement = '".$departement."'
			");
		return $query->result();

	}


}

	 function rpt_inputan_detail($month, $year, $empcode, $departement)
	{
		if($month || $year)
        {
            $back_year = $year-1;
            switch ($month) {
                    case 1:
            $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-21" AND "'.$year.'-01-25"');
            $filter_start_date  = $back_year.'-12-21';
            $filter_end_date    = $year.'-01-25';
                    break;
                    case 2:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
            $filter_start_date  = $year.'-01-26';
            $filter_end_date    = $year.'-02-25';     
                    break;
                    case 3:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
            $filter_start_date  = $year.'-02-26';
            $filter_end_date    = $year.'-03-25';       
                    break;
                    case 4:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
            $filter_start_date  = $year.'-03-26';
            $filter_end_date    = $year.'-04-25';       
                    break;
                    case 5:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
            $filter_start_date  = $year.'-04-26';
            $filter_end_date    = $year.'-05-25';       
                    break;
                    case 6:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
            $filter_start_date  = $year.'-05-26';
            $filter_end_date    = $year.'-06-25';       
                    break;
                    case 7:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
            $filter_start_date  = $year.'-06-26';
            $filter_end_date    = $year.'-07-25';       
                    break;
                    case 8:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
            $filter_start_date  = $year.'-07-26';
            $filter_end_date    = $year.'-08-25';       
                    break;
                    case 9:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
            $filter_start_date  = $year.'-08-26';
            $filter_end_date    = $year.'-09-25';       
                    break;
                    case 10:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
            $filter_start_date  = $year.'-09-26';
            $filter_end_date    = $year.'-10-25';       
                    break;
                    case 11;
            $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-25"');
            $filter_start_date  = $year.'-10-26';
            $filter_end_date    = $year.'-11-25';       
                    break;
                    case 12:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-12-26" AND "'.$year.'-01-25"');
            $filter_start_date  = $year.'-11-26';
            $filter_end_date    = $year.'-12-25';       
                    break;
            }
		$this->db->query("SET @start_date = '".$filter_start_date."'");
		$this->db->query("SET @end_date = '".$filter_end_date."'");
		$query = $this->db->query("
								select 
  a.empcode,
  c.departement,
  a.attd_date,
  a.attd_code,
  b.attd_desc,
  a.work_hour,
  coalesce(a.total_jam_lembur,'0') as total_jam_lembur,
  a.remarks 
FROM
  gang_activity a 
  LEFT JOIN master_attd_code b 
    ON a.attd_code = b.attd_code 
    LEFT JOIN emp_master c ON a.empcode = c.empcode
WHERE attd_date BETWEEN @start_date 
  AND @end_date AND a.empcode = '".$empcode."' AND c.departement = '".$departement."' AND a.is_deleted = 0 order by a.attd_date 
								");
		return $query->result();
	}

		}

	public function nama_sheet()
	{
		$query = $this->db->query("select departement, dept_desc FROM master_dept");
		return $query->result();
	}





}