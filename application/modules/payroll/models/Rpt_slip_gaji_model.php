<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpt_slip_gaji_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
    //use for datatable with live filtering
    
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

    function rekap_total_gaji($year, $month)
    {
        // if($month || $year)
        // {
        //     $back_year = $year-1;
        //     switch ($month) {
        //             case 1:
        //     $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-26" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $back_year.'-12-26';
        //     $filter_end_date    = $year.'-01-25';
        //             break;
        //             case 2:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
        //     $filter_start_date  = $year.'-01-26';
        //     $filter_end_date    = $year.'-02-25';     
        //             break;
        //             case 3:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
        //     $filter_start_date  = $year.'-02-26';
        //     $filter_end_date    = $year.'-03-25';       
        //             break;
        //             case 4:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
        //     $filter_start_date  = $year.'-03-26';
        //     $filter_end_date    = $year.'-04-25';       
        //             break;
        //             case 5:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
        //     $filter_start_date  = $year.'-04-26';
        //     $filter_end_date    = $year.'-05-25';       
        //             break;
        //             case 6:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
        //     $filter_start_date  = $year.'-05-26';
        //     $filter_end_date    = $year.'-06-25';       
        //             break;
        //             case 7:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
        //     $filter_start_date  = $year.'-06-26';
        //     $filter_end_date    = $year.'-07-25';       
        //             break;
        //             case 8:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
        //     $filter_start_date  = $year.'-07-26';
        //     $filter_end_date    = $year.'-08-25';       
        //             break;
        //             case 9:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
        //     $filter_start_date  = $year.'-08-26';
        //     $filter_end_date    = $year.'-09-25';       
        //             break;
        //             case 10:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
        //     $filter_start_date  = $year.'-09-26';
        //     $filter_end_date    = $year.'-10-25';       
        //             break;
        //             case 11;
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-25"');
        //     $filter_start_date  = $year.'-10-26';
        //     $filter_end_date    = $year.'-11-25';       
        //             break;
        //             case 12:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-12-26" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $year.'-11-26';
        //     $filter_end_date    = $year.'-12-25';       
        //             break;
        //     }
        //     //$this->db->where('a.attd_date BETWEEN "2018-01-25" AND "2018-01-25"');
        // }
        $get_period = get_date_period($month, $year);
        $filter_start_date  = $get_period->start_date;
        $filter_end_date    = $get_period->end_date;
        $query = $this->db->query('CALL grand_total_sallary_05102018("'.$filter_start_date.'","'.$filter_end_date.'");');
        return $query->result_array();
    }

    function slip_gaji($empcode, $dept_id, $position_id, $year, $month)
    {
        
    //use for datatable with live filtering
        if ($empcode) {
        $this->db->where('b.empcode',$empcode);
        }
        if ($dept_id) {
        $this->db->where('b.departement',$dept_id);
        }
        if ($position_id) {
        $this->db->where('b.position',$position_id);
        }
        /*if($month)
        {
            $this->db->where('MONTH(a.attd_date)', $month);
        }
        if($year)
        {
            $this->db->where('YEAR(a.attd_date)', $year);
        }*/
        // if($month || $year)
        // {
        //     $back_year = $year-1;
        //     switch ($month) {
        //             case 1:
        //     $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-26" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $back_year.'-12-26';
        //     $filter_end_date    = $year.'-01-25';
        //             break;
        //             case 2:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
        //     $filter_start_date  = $year.'-01-26';
        //     $filter_end_date    = $year.'-02-25';     
        //             break;
        //             case 3:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
        //     $filter_start_date  = $year.'-02-26';
        //     $filter_end_date    = $year.'-03-25';       
        //             break;
        //             case 4:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
        //     $filter_start_date  = $year.'-03-26';
        //     $filter_end_date    = $year.'-04-25';       
        //             break;
        //             case 5:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
        //     $filter_start_date  = $year.'-04-26';
        //     $filter_end_date    = $year.'-05-25';       
        //             break;
        //             case 6:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
        //     $filter_start_date  = $year.'-05-26';
        //     $filter_end_date    = $year.'-06-25';       
        //             break;
        //             case 7:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
        //     $filter_start_date  = $year.'-06-26';
        //     $filter_end_date    = $year.'-07-25';       
        //             break;
        //             case 8:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
        //     $filter_start_date  = $year.'-07-26';
        //     $filter_end_date    = $year.'-08-25';       
        //             break;
        //             case 9:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
        //     $filter_start_date  = $year.'-08-26';
        //     $filter_end_date    = $year.'-09-25';       
        //             break;
        //             case 10:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
        //     $filter_start_date  = $year.'-09-26';
        //     $filter_end_date    = $year.'-10-25';       
        //             break;
        //             case 11;
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-25"');
        //     $filter_start_date  = $year.'-10-26';
        //     $filter_end_date    = $year.'-11-25';       
        //             break;
        //             case 12:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-12-26" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $year.'-11-26';
        //     $filter_end_date    = $year.'-12-25';       
        //             break;
        //     }
        //     //$this->db->where('a.attd_date BETWEEN "2018-01-25" AND "2018-01-25"');
        // }

        $get_period = get_date_period($month, $year);
        $filter_start_date  = $get_period->start_date;
        $filter_end_date    = $get_period->end_date;

 /*       $query = $this->db->query('    
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
on b.empcode = f.empcode'.$nik.'
GROUP BY a.empcode
            ');*/
        $this->db->select('b.empcode, b.nik_pim, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, 
COALESCE(f.deduction,0) as deduction,
COALESCE(g.allowance,0) as allowance,
CASE
WHEN e.status_jamsostek = 0 then 0 
WHEN e.status_jamsostek = 1 then ROUND(3/100 * e.upah)
END
as jamsostek,
CASE
WHEN e.lifeinsurance = 0 then 0
when e.lifeinsurance = 1 then ROUND(1/100 * h.rate)
END 
as jpk,
COUNT(a.attd_date) as hk,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(e.upah/173) as upah_perjam, 
coalesce(SUM(a.overtime),0) as jam_lembur, 
coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
coalesce(e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0),0) as total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) as total_potongan,
CASE
    when e.overtime = 0 THEN 
CASE
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
end 
    when e.overtime = 1 THEN
CASE
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jamsostek + COALESCE(f.deduction,0))
end
END as gaji_bersih');
        $this->db->from('(SELECT * FROM gang_activity where attd_code in("attd001","attd010","attd011") and is_deleted != 1 and attd_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'") a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) h');
        $this->db->join('emp_master as b','a.empcode = b.empcode','right');
        $this->db->join('master_position as c','b.position = c.id_position');
        $this->db->join('master_dept as d','b.departement = d.departement');
        $this->db->join('(select a.empcode, a.upah, a.kehadiran_pagi, a.jamsostek as status_jamsostek, a.lifeinsurance, a.overtime,
CASE
-- jika jamsostek tidak di bayarkan
WHEN a.jamsostek = 0 then 0 
WHEN a.jamsostek = 1 then ROUND(3/100 * a.upah)
END
as jamsostek,
CASE
-- jika bpjs tidak di bayarkan
WHEN a.lifeinsurance = 0 then 0
-- jika bpjs dibayarkan
when a.lifeinsurance = 1 then ROUND(1/100 * b.rate)
END 
as jpk
from hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) b) as e','b.empcode = e.empcode');
        //$this->db->join('empallded as f','b.empcode = f.empcode','left');
        $this->db->join('(select empcode, adhoc_date,sum(amount) as deduction from empallded where adhoc_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'" and allowded_code like "%D%"
GROUP BY empcode) as f','b.empcode = f.empcode','left');
        $this->db->join('(select empcode, adhoc_date, allowded_code, sum(amount) as allowance from empallded where adhoc_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'" and allowded_code like "%A%"
GROUP BY empcode) as g','b.empcode = g.empcode','left');
        /*$this->db->join('(select * from empallded where MONTH(adhoc_date) = "'.$month.'" AND YEAR(adhoc_date) = "'.$year.'" ) as f','b.empcode = f.empcode','left');*/
        $this->db->group_by('a.empcode');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // fungsi ini dipanggi di helper detail_lembur_helper untuk digunakan pemanggilan komponen gaji di laporan slip gaji karyawan
    function detail_lembur($id)
    {
       /*$query = $this->db->query('
select COALESCE(a.empcode,"Grand Total") as empcode, COALESCE(b.empname,"Sub Total") as empname, COALESCE(a.attd_date,"Sub Total") as attd_date,c.upah, a.overtime, a.attd_code,
round((a.overtime * 1 / 173 * c.upah)) as lembur
, coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = "'.$id.'"
and a.attd_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'" 
GROUP BY  a.attd_date
WITH ROLLUP');*/

$query = $this->db->query('select 
  COALESCE(a.empcode, "Grand Total") AS empcode,
  COALESCE(b.empname, "Sub Total") AS empname,
  COALESCE(a.attd_date, "Sub Total") AS attd_date,
  c.upah,
  a.total_jam_lembur,
  a.attd_code,
  ROUND((a.total_jam_lembur * 1 / 173 * c.upah)) AS lembur,
  COALESCE(
    ROUND((1 / 173 * c.upah) * SUM(a.total_jam_lembur)),
    0
  ) AS total,
  CASE
    WHEN a.work_hour > 0 THEN c.kehadiran_pagi
  END AS kehadiran,
  a.remarks 
FROM
  gang_activity a,
  emp_master b,
  hr_hist_status c 
WHERE a.empcode = b.empcode 
  AND a.empcode = c.empcode 
  AND a.empcode = "'.$id.'" 
  AND a.attd_date BETWEEN "2018-08-26" 
  AND "2018-09-25" 
GROUP BY a.attd_date WITH ROLLUP');
        return $query->result_array();

    }

    public function header_slip_after_closed($empcode, $dept_id, $position_id, $month, $year)
    {

        if ($empcode) {
                $this->db->where('empcode', $empcode);
        }
        if ($dept_id) {
                $this->db->where('departement', $dept_id);
        }
        if ($position_id) {
                $this->db->where('position', $position_id);
        }
        $this->db->from("closing_payroll");
        $this->db->where('period', $month);
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->result();
    }

    public function gt_rekap_gaji_after_closing($empcode, $dept_id, $position_id, $month, $year)
    {
        if ($empcode) {
                $this->db->where('a.empcode', $empcode);
        }
        if ($dept_id) {
                $this->db->where('a.departement', $dept_id);
        }
        if ($position_id) {
                $this->db->where('a.position', $position_id);
        }
            $this->db->select("SUM(a.upah) AS total_basic,
            SUM(a.pot_prop) AS pot_prop,
            SUM(a.gaji_setelah_sia) AS total_basic_pot_prop,
            SUM(a.kehadiran_bulanan) AS insentive_hadir,
            SUM(a.hk_dibayar) AS jumlah_hadir,
            SUM(a.insentive_snack) AS insentive_kopi_snack,
            SUM(a.upah_perjam) AS lembur_per_jam,
            SUM(a.jam_lembur) AS jam_lembur,
            SUM(a.uang_lembur) AS overtime,
            SUM(a.jamsostek) AS jamsos,
            SUM(a.jpk) AS jpk,
            SUM(a.gaji_bersih) AS total_gaji_bersih ");
            $this->db->from("closing_payroll a");
            $this->db->where('a.period',$month);
            $this->db->where('a.year',$year);
            $query = $this->db->get();
            return $query->result();
            /* SELECT 
  SUM(a.upah) AS total_basic,
  SUM(a.pot_prop) AS pot_prop,
  SUM(a.gaji_setelah_sia) AS total_basic_pot_prop,
  SUM(a.kehadiran_bulanan) AS insentive_hadir,
  SUM(a.hk_dibayar) AS jumlah_hadir,
  SUM(a.insentive_snack) AS insentive_kopi_snack,
  SUM(a.upah_perjam) AS lembur_per_jam,
  SUM(a.jam_lembur) AS jam_lembur,
  SUM(a.uang_lembur) AS overtime,
  SUM(a.jamsostek) AS jamsos,
  SUM(a.jpk) AS jpk,
  SUM(a.gaji_bersih) AS total_gaji_bersih 
FROM
  closing_payroll a 
WHERE a.period = 9 
  AND a.year = 2018 
 */
    }

    public function header_slip_rev01($empcode, $dept_id, $position_id, $month, $year)
    {
        /*jika cutoff di majukan maka setting parameter tanggal cut off di sini*/

        if ($empcode) {
        $empcode = "AND a.empcode = '".$empcode."' ";
        }
        if ($dept_id) {
        $dept_id = "AND b.departement = '".$dept_id."'";
        }
        if ($position_id) {
        $position_id = "AND b.position = '".$position_id."'";
        }
        if($month)
        {
            $this->db->where('MONTH(a.attd_date)', $month);
        }
        if($year)
        {
            $this->db->where('YEAR(a.attd_date)', $year);
        }
        //  if($month || $year)
        // {
        //     $back_year = $year-1;
        //     switch ($month) {
        //             case 1:
        //     $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-21" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $back_year.'-12-21';
        //     $filter_end_date    = $year.'-01-25';
        //             break;
        //             case 2:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
        //     $filter_start_date  = $year.'-01-26';
        //     $filter_end_date    = $year.'-02-25';     
        //             break;
        //             case 3:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
        //     $filter_start_date  = $year.'-02-26';
        //     $filter_end_date    = $year.'-03-25';       
        //             break;
        //             case 4:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
        //     $filter_start_date  = $year.'-03-26';
        //     $filter_end_date    = $year.'-04-25';       
        //             break;
        //             case 5:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
        //     $filter_start_date  = $year.'-04-26';
        //     $filter_end_date    = $year.'-05-25';       
        //             break;
        //             case 6:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
        //     $filter_start_date  = $year.'-05-26';
        //     $filter_end_date    = $year.'-06-25';       
        //             break;
        //             case 7:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
        //     $filter_start_date  = $year.'-06-26';
        //     $filter_end_date    = $year.'-07-25';       
        //             break;
        //             case 8:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-07-26" AND "'.$year.'-08-25"');
        //     $filter_start_date  = $year.'-07-26';
        //     $filter_end_date    = $year.'-08-25';       
        //             break;
        //             case 9:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
        //     $filter_start_date  = $year.'-08-26';
        //     $filter_end_date    = $year.'-09-25';       
        //             break;
        //             case 10:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
        //     $filter_start_date  = $year.'-09-26';
        //     $filter_end_date    = $year.'-10-25';       
        //             break;
        //             case 11;
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
        //     $filter_start_date  = $year.'-10-26';
        //     $filter_end_date    = $year.'-11-25';       
        //             break;
        //             case 12:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-20"');
        //     $filter_start_date  = $year.'-11-26';
        //     $filter_end_date    = $year.'-12-20';       
        //             break;
        //     }
        // }

        $get_period = get_date_period($month, $year);
        $filter_start_date  = $get_period->start_date;
        $filter_end_date    = $get_period->end_date;

        $this->db->query('SET @start_date = "'.$filter_start_date.'";');
        $this->db->query('SET @end_date = "'.$filter_end_date.'";');
        $this->db->query('SET @insentive_snack = 5000');

        $query = $this->db->query('
select b.empcode, b.empname, b.nik_pim, b.position, c.position_desc, e.grade, i.golongan, e.upah,  e.kehadiran_pagi,
 b.departement,  d.dept_desc, 
 COALESCE(j.total_sia,0) AS total_sia,
 ROUND(j.total_sia * ABS(e.upah/26)) AS pot_prop,
 CASE
 WHEN COALESCE(j.total_sia,0) > 0 THEN e.upah - ROUND(j.total_sia * ABS(e.upah/26))
 ELSE e.upah
 END AS gaji_setelah_sia,
COALESCE(f.deduction,0) AS deduction,
COALESCE(g.allowance,0) AS allowance,
CASE
-- jika jamsostek tidak di bayarkan
WHEN e.status_jamsostek = 0 THEN 0 
WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
END
AS jamsostek,
CASE
-- jika bpjs tidak di bayarkan
WHEN e.lifeinsurance = 0 THEN 0
-- jika bpjs dibayarkan
WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
END 
AS jpk,
-- ROUND(3/100 * e.upah) as jamsostek,
-- ROUND(1/100 * e.upah) as jpk,
-- f.remarks,
-- COUNT(a.attd_date) AS hk,
COALESCE(i.hk_dibayar,0) as hk_dibayar,
COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi AS kehadiran_bulanan, 
ROUND(e.upah/173) AS upah_perjam, 
COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
-- (i.hk_dibayar * @insentive_snack) AS insentive_snack,
CASE
    WHEN e.uang_makan = 0 THEN 0
    WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
END AS insentive_snack,
-- COALESCE(e.upah + ((COUNT(i.hk_dibayar) * @insentive_snack) + (COUNT(i.hk_dibayar) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0),0) AS total_pendapatan,
-- e.uang_makan AS insentive_snack,
COALESCE(e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0),0) AS total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS total_potongan,
CASE
    WHEN e.overtime = 0 THEN 
CASE
-- 1 = ikut jamsostek, 0 = tidak ikut jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
-- WHEN e.jamsostek = 0 AND e.lifeinsurance = 0 then "tidak jamsostek dan bpjs"
-- WHEN e.jamsostek = 1 AND e.lifeinsurance = 0 then "ikut jamsostek dan tidak bpjs"
-- WHEN e.jamsostek = 0 AND e.lifeinsurance = 1 then "ikut bpjs dan tidak jamsostek"
-- WHEN e.jamsostek = 1 AND e.lifeinsurance = 1 then "ikut jamsostek dan ikut bpjs"
END                 -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0))
    WHEN e.overtime = 1 THEN
CASE
-- jika dia mendapatkan overtime dan jika bpjs dan jamsostek di bayarkan 
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
-- jika dia mendapatkan overtime dan jika bpjs dan jamsostek tidak bayarkan 
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
-- jika dia mendapatkan overtime dan jika bpjs dibayarkan tapi jamsostek tidak di bayarkan 
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
-- jika dia mendapatkan overtime dan jika bpjs tidak dibayarkan tapi jamsostek di bayarkan 
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
END                     -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((e.upah/173) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
END AS gaji_bersih
FROM (
SELECT 
  a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
  CASE 
    WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
    ELSE a.total_jam_lembur
  END AS total_jam_lembur
FROM
  gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
  ON a.empcode = b.empcode 
WHERE a.attd_date BETWEEN @start_date AND @end_date
) a
LEFT JOIN (SELECT 
  empcode,
  COUNT(empcode) total_sia
FROM
  gang_activity 
WHERE attd_date BETWEEN @start_date 
  AND @end_date 
  AND attd_code IN ("attd004", "attd005")
  GROUP BY empcode) j ON a.empcode = j.empcode
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
RIGHT JOIN (select * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
-- diremarks untuk menampilkan field yang digunakan saja dan untuk perhitungaan potongan
-- INNER JOIN hr_hist_status e
INNER JOIN (SELECT a.empcode, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
CASE
-- jika jamsostek tidak di bayarkan
WHEN a.jamsostek = 0 THEN 0 
WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
END
AS jamsostek,
CASE
-- jika bpjs tidak di bayarkan
WHEN a.lifeinsurance = 0 THEN 0
-- jika bpjs dibayarkan
WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
END 
AS jpk
FROM hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) b) e
ON b.empcode = e.empcode
LEFT JOIN master_golongan i ON e.grade = i.id_golongan
LEFT JOIN (
                        SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%D%"
GROUP BY empcode
)f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = f.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%A%"
GROUP BY empcode)g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = g.empcode,
(SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) h
WHERE a.attd_date BETWEEN @start_date AND @end_date '.$empcode.' '.$dept_id.' '.$position_id.' 
GROUP BY a.empcode order by b.departement, c.position_desc, b.empname  asc');

 return $query->result();
        /*
            SET @start_date = '2018-08-26' ;
SET @end_date = '2018-09-25';
SET @insentive_snack := 5000;
SELECT b.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi,
COALESCE(f.deduction,0) AS deduction,
COALESCE(g.allowance,0) AS allowance,
CASE
-- jika jamsostek tidak di bayarkan
WHEN e.status_jamsostek = 0 THEN 0 
WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
END
AS jamsostek,
CASE
-- jika bpjs tidak di bayarkan
WHEN e.lifeinsurance = 0 THEN 0
-- jika bpjs dibayarkan
WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
END 
AS jpk,
-- ROUND(3/100 * e.upah) as jamsostek,
-- ROUND(1/100 * e.upah) as jpk,
-- f.remarks,
-- COUNT(a.attd_date) AS hk,
i.hk_dibayar,
i.hk_dibayar * e.kehadiran_pagi AS kehadiran_bulanan, 
ROUND(1/173*e.upah) AS upah_perjam, 
COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
-- (COUNT(i.hk_dibayar) * @insentive_snack) AS insentive_snack,
-- COALESCE(e.upah + ((COUNT(i.hk_dibayar) * @insentive_snack) + (COUNT(i.hk_dibayar) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0),0) AS total_pendapatan,
e.uang_makan AS insentive_snack,
COALESCE(e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0),0) AS total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) AS total_potongan,
CASE
    WHEN e.overtime = 0 THEN 
CASE
-- 1 = ikut jamsostek, 0 = tidak ikut jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
-- WHEN e.jamsostek = 0 AND e.lifeinsurance = 0 then "tidak jamsostek dan bpjs"
-- WHEN e.jamsostek = 1 AND e.lifeinsurance = 0 then "ikut jamsostek dan tidak bpjs"
-- WHEN e.jamsostek = 0 AND e.lifeinsurance = 1 then "ikut bpjs dan tidak jamsostek"
-- WHEN e.jamsostek = 1 AND e.lifeinsurance = 1 then "ikut jamsostek dan ikut bpjs"
END                 -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
    WHEN e.overtime = 1 THEN
CASE
-- jika dia mendapatkan overtime dan jika bpjs dan jamsostek di bayarkan 
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0))
-- jika dia mendapatkan overtime dan jika bpjs dan jamsostek tidak bayarkan 
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - COALESCE(f.deduction,0)
-- jika dia mendapatkan overtime dan jika bpjs dibayarkan tapi jamsostek tidak di bayarkan 
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jpk + COALESCE(f.deduction,0))
-- jika dia mendapatkan overtime dan jika bpjs tidak dibayarkan tapi jamsostek di bayarkan 
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jamsostek + COALESCE(f.deduction,0))
END                     -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
END AS gaji_bersih
FROM (SELECT * FROM gang_activity  WHERE attd_code IN('attd001','attd002','attd003') AND attd_date BETWEEN @start_date AND @end_date) a
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
RIGHT JOIN emp_master b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
-- diremarks untuk menampilkan field yang digunakan saja dan untuk perhitungaan potongan
-- INNER JOIN hr_hist_status e
INNER JOIN (SELECT a.empcode, a.upah, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
CASE
-- jika jamsostek tidak di bayarkan
WHEN a.jamsostek = 0 THEN 0 
WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
END
AS jamsostek,
CASE
-- jika bpjs tidak di bayarkan
WHEN a.lifeinsurance = 0 THEN 0
-- jika bpjs dibayarkan
WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
END 
AS jpk
FROM hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) b) e
ON b.empcode = e.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
GROUP BY empcode
)f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = f.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
GROUP BY empcode)g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = g.empcode,
(SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) h
WHERE a.attd_date BETWEEN @start_date AND @end_date
GROUP BY a.empcode
        */
    }

    public function gt_rekap_gaji($empcode, $dept_id, $position_id, $month, $year)
    {
        /*jika cutoff di majukan maka setting parameter tanggal cut off di sini*/

        if ($empcode) {
        $empcode = "AND a.empcode = '".$empcode."'";
        }
        if ($dept_id) {
        $dept_id = "AND b.departement = '".$dept_id."'";
        }
        if ($position_id) {
        $position_id = "AND b.position = '".$position_id."'";
        }
        if($month)
        {
            $this->db->where('MONTH(a.attd_date)', $month);
        }
        if($year)
        {
            $this->db->where('YEAR(a.attd_date)', $year);
        }
        //  if($month || $year)
        // {
        //     $back_year = $year-1;
        //     switch ($month) {
        //             case 1:
        //     $this->db->where('a.attd_date BETWEEN "'.$back_year.'-12-21" AND "'.$year.'-01-25"');
        //     $filter_start_date  = $back_year.'-12-21';
        //     $filter_end_date    = $year.'-01-25';
        //             break;
        //             case 2:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-02-25"');
        //     $filter_start_date  = $year.'-01-26';
        //     $filter_end_date    = $year.'-02-25';     
        //             break;
        //             case 3:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-02-26" AND "'.$year.'-03-25"');
        //     $filter_start_date  = $year.'-02-26';
        //     $filter_end_date    = $year.'-03-25';       
        //             break;
        //             case 4:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-03-26" AND "'.$year.'-04-25"');
        //     $filter_start_date  = $year.'-03-26';
        //     $filter_end_date    = $year.'-04-25';       
        //             break;
        //             case 5:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-04-26" AND "'.$year.'-05-25"');
        //     $filter_start_date  = $year.'-04-26';
        //     $filter_end_date    = $year.'-05-25';       
        //             break;
        //             case 6:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-05-26" AND "'.$year.'-06-25"');
        //     $filter_start_date  = $year.'-05-26';
        //     $filter_end_date    = $year.'-06-25';       
        //             break;
        //             case 7:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-06-26" AND "'.$year.'-07-25"');
        //     $filter_start_date  = $year.'-06-26';
        //     $filter_end_date    = $year.'-07-25';       
        //             break;
        //             case 8:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-07-26" AND "'.$year.'-08-25"');
        //     $filter_start_date  = $year.'-07-26';
        //     $filter_end_date    = $year.'-08-25';       
        //             break;
        //             case 9:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-08-26" AND "'.$year.'-09-25"');
        //     $filter_start_date  = $year.'-08-26';
        //     $filter_end_date    = $year.'-09-25';       
        //             break;
        //             case 10:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-09-26" AND "'.$year.'-10-25"');
        //     $filter_start_date  = $year.'-09-26';
        //     $filter_end_date    = $year.'-10-25';       
        //             break;
        //             case 11;
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-10-26" AND "'.$year.'-11-25"');
        //     $filter_start_date  = $year.'-10-26';
        //     $filter_end_date    = $year.'-11-25';       
        //             break;
        //             case 12:
        //     $this->db->where('a.attd_date BETWEEN "'.$year.'-11-26" AND "'.$year.'-12-20"');
        //     $filter_start_date  = $year.'-11-26';
        //     $filter_end_date    = $year.'-12-20';       
        //             break;
        //     }
        // }

        $get_period = get_date_period($month, $year);
        $filter_start_date  = $get_period->start_date;
        $filter_end_date    = $get_period->end_date;
        
        $this->db->query("SET @start_date = '".$filter_start_date."';");
        $this->db->query("SET @end_date = '".$filter_end_date."';");
        $query = $this->db->query('
            select 
  SUM(a.upah) AS total_basic,
  SUM(a.pot_prop) AS pot_prop,
  SUM(a.gaji_setelah_sia) AS total_basic_pot_prop,
  SUM(a.kehadiran_bulanan) AS insentive_hadir,
  SUM(a.hk_dibayar) AS jumlah_hadir,
  SUM(a.insentive_snack) AS insentive_kopi_snack,
  SUM(a.upah_perjam) AS lembur_per_jam,
  SUM(a.jam_lembur) AS jam_lembur,
  SUM(a.uang_lembur) AS overtime,
  SUM(a.jamsostek) AS jamsos,
  SUM(a.jpk) AS jpk,
  SUM(a.gaji_bersih) AS total_gaji_bersih
FROM
  (
SELECT b.empcode, b.empname, b.nik_pim, b.position, c.position_desc, e.grade, i.golongan, e.upah,  e.kehadiran_pagi,
 b.departement,  d.dept_desc, 
 COALESCE(j.total_sia,0) AS total_sia,
 ROUND(j.total_sia * ABS(e.upah/26)) AS pot_prop,
 CASE
 WHEN COALESCE(j.total_sia,0) > 0 THEN e.upah - ROUND(j.total_sia * ABS(e.upah/26))
 ELSE e.upah
 END AS gaji_setelah_sia,
COALESCE(f.deduction,0) AS deduction,
COALESCE(g.allowance,0) AS allowance,
CASE
WHEN e.status_jamsostek = 0 THEN 0 
WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
END
AS jamsostek,
CASE
WHEN e.lifeinsurance = 0 THEN 0
WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
END 
AS jpk,
COALESCE(i.hk_dibayar,0) as hk_dibayar,
COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi AS kehadiran_bulanan, 
ROUND(e.upah/173) AS upah_perjam, 
COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
-- (COALESCE(i.hk_dibayar,0) * @insentive_snack) AS insentive_snack,
CASE
    WHEN e.uang_makan = 0 THEN 0
    WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
END AS insentive_snack,
COALESCE(e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0),0) AS total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS total_potongan,
CASE
    WHEN e.overtime = 0 THEN 
CASE
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
END                
    WHEN e.overtime = 1 THEN
CASE
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
END                   
END AS gaji_bersih
FROM (
SELECT 
  a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
  CASE 
    WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
    ELSE a.total_jam_lembur
  END AS total_jam_lembur
FROM
  gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
  ON a.empcode = b.empcode 
WHERE a.attd_date BETWEEN @start_date AND @end_date
) a
LEFT JOIN (SELECT 
  empcode,
  COUNT(empcode) total_sia
FROM
  gang_activity 
WHERE attd_date BETWEEN @start_date 
  AND @end_date 
  AND attd_code IN ("attd004", "attd005")
  GROUP BY empcode) j ON a.empcode = j.empcode
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
RIGHT JOIN (select * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b 
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
INNER JOIN (SELECT a.empcode, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
CASE
WHEN a.jamsostek = 0 THEN 0 
WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
END
AS jamsostek,
CASE
WHEN a.lifeinsurance = 0 THEN 0
WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
END 
AS jpk
FROM hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) b) e
ON b.empcode = e.empcode
LEFT JOIN master_golongan i ON e.grade = i.id_golongan
LEFT JOIN (
                        SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%D%"
GROUP BY empcode
)f 
ON b.empcode = f.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%A%"
GROUP BY empcode)g 
ON b.empcode = g.empcode,
(SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM master_ump) h
WHERE a.attd_date BETWEEN @start_date AND @end_date  '.$empcode.' '.$dept_id.' '.$position_id.'
GROUP BY a.empcode order by b.departement, c.position_desc, b.empname) a');

 return $query->result();
    }

    public function rekap_kopi($start_date, $end_date)
    {
        $this->db->query("SET @start_date = '".$start_date."';");
        $this->db->query("SET @end_date = '".$end_date."';");
        $this->db->query("SET @insentive_snack := 5000");
        $query = $this->db->query("
        select 
b.empname, 
b.nik_pim, 
d.dept_desc,
c.position_desc, 
e.start_date,
i.golongan, 
COALESCE(i.hk_dibayar,0) AS hk_dibayar,
@insentive_snack AS uang_kopi,
CASE
	WHEN e.uang_makan = 0 THEN 0
	WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
END AS insentive_snack
FROM (
SELECT 
  a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
  CASE 
	WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
	ELSE a.total_jam_lembur
  END AS total_jam_lembur
FROM
  gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
  ON a.empcode = b.empcode 
WHERE a.attd_date BETWEEN @start_date AND @end_date
) a
LEFT JOIN (SELECT 
  empcode,
  COUNT(empcode) total_sia
FROM
  gang_activity 
WHERE attd_date BETWEEN @start_date 
  AND @end_date 
  AND attd_code IN ('attd004', 'attd005')
  GROUP BY empcode) j ON a.empcode = j.empcode
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
LEFT JOIN (SELECT a.empcode, COUNT(a.shift) AS shift_satu FROM (SELECT * FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date) a WHERE a.attd_date BETWEEN @start_date_shaum AND @end_date_shaum  AND a.work_hour > 0 AND a.shift = 'SHIFT I' GROUP BY a.empcode) k
ON a.empcode = k.empcode
RIGHT JOIN (SELECT * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
INNER JOIN (SELECT a.empcode, a.start_date, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
CASE
WHEN a.jamsostek = 0 THEN 0 
WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
END
AS jamsostek,
CASE
WHEN a.lifeinsurance = 0 THEN 0
WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
END 
AS jpk
FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) b WHERE a.overtime = 1) e
ON b.empcode = e.empcode
LEFT JOIN master_golongan i ON e.grade = i.id_golongan
LEFT JOIN (
						SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
GROUP BY empcode
)f 
ON b.empcode = f.empcode
LEFT JOIN (
						SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
GROUP BY empcode)g 
ON b.empcode = g.empcode,
(SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) h 
WHERE a.attd_date BETWEEN @start_date AND @end_date AND e.uang_makan > 0

GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname
        ");
        return $query->result_array();
    }

    public function rekap_uang_makan($start_date, $end_date)
    {
        $this->db->query("SET @start_date = '".$start_date."';");
        $this->db->query("SET @end_date = '".$end_date."';");
        $this->db->query("SET @start_date_shaum := '2019-05-06' ");
        $this->db->query("SET @end_date_shaum := '2019-06-04'");
        $this->db->query("SET @insentive_snack := 5000");
        $this->db->query("SET @uang_makan := 14000");
        $query = $this->db->query("
        select 
b.empname, 
b.nik_pim, 
d.dept_desc,
c.position_desc, 
e.start_date,
i.golongan, 
COALESCE(k.shift_satu,0) AS uang_makan,
@uang_makan as variance,
COALESCE(k.shift_satu,0) * @uang_makan AS total_uang_makan
FROM (
SELECT 
  a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
  CASE 
	WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
	ELSE a.total_jam_lembur
  END AS total_jam_lembur
FROM
  gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
  ON a.empcode = b.empcode 
WHERE a.attd_date BETWEEN @start_date AND @end_date
) a
LEFT JOIN (SELECT 
  empcode,
  COUNT(empcode) total_sia
FROM
  gang_activity 
WHERE attd_date BETWEEN @start_date 
  AND @end_date 
  AND attd_code IN ('attd004', 'attd005')
  GROUP BY empcode) j ON a.empcode = j.empcode
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
LEFT JOIN (SELECT a.empcode, COUNT(a.shift) AS shift_satu FROM (SELECT * FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date) a WHERE a.attd_date BETWEEN @start_date_shaum AND @end_date_shaum  AND a.work_hour > 0 AND a.shift = 'SHIFT I' GROUP BY a.empcode) k
ON a.empcode = k.empcode
RIGHT JOIN (SELECT * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
INNER JOIN (SELECT a.empcode, a.start_date, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
CASE
WHEN a.jamsostek = 0 THEN 0 
WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
END
AS jamsostek,
CASE
WHEN a.lifeinsurance = 0 THEN 0
WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
END 
AS jpk
FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) b WHERE a.overtime = 1) e
ON b.empcode = e.empcode
LEFT JOIN master_golongan i ON e.grade = i.id_golongan
LEFT JOIN (
						SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
GROUP BY empcode
)f 
ON b.empcode = f.empcode
LEFT JOIN (
						SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
GROUP BY empcode)g 
ON b.empcode = g.empcode,
(SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) h 
WHERE a.attd_date BETWEEN @start_date AND @end_date
GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname
        ");
        return $query->result_array();
    }

    public function slip_gaji_excel($start_date, $end_date)
    {
            $this->db->query("SET @start_date = '".$start_date."';");
            $this->db->query("SET @end_date = '".$end_date."';");
            $this->db->query("SET @start_date_shaum := '2019-05-06' ");
            $this->db->query("SET @end_date_shaum := '2019-06-04'");
            $this->db->query("SET @insentive_snack := 5000");
            $this->db->query("SET @uang_makan := 14000 ");
        //     $query = $this->db->query(
        //             "select MONTH(@end_date) AS period, YEAR(@end_date) AS YEAR, b.empcode, b.empname, b.nik_pim, b.position, c.position_desc, e.grade, i.golongan, e.upah,  e.kehadiran_pagi,
        //             b.departement,  d.dept_desc, 
        //             COALESCE(j.total_sia,0) AS total_sia,
        //             ROUND(j.total_sia * ABS(e.upah/26)) AS pot_prop,
        //             CASE
        //             WHEN COALESCE(j.total_sia,0) > 0 THEN e.upah - ROUND(j.total_sia * ABS(e.upah/26))
        //             ELSE e.upah
        //             END AS gaji_setelah_sia,
        //            COALESCE(f.deduction,0) AS deduction,
        //            COALESCE(g.allowance,0) AS allowance,
        //            CASE
        //            -- jika jamsostek tidak di bayarkan
        //            WHEN e.status_jamsostek = 0 THEN 0 
        //            WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
        //            END
        //            AS jamsostek,
        //            CASE
        //            -- jika bpjs tidak di bayarkan
        //            WHEN e.lifeinsurance = 0 THEN 0
        //            -- jika bpjs dibayarkan
        //            WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
        //            END 
        //            AS jpk,
        //            -- ROUND(3/100 * e.upah) as jamsostek,
        //            -- ROUND(1/100 * e.upah) as jpk,
        //            -- f.remarks,
        //            -- COUNT(a.attd_date) AS hk,
        //            COALESCE(i.hk_dibayar,0) as hk_dibayar,
        //            COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi AS kehadiran_bulanan, 
        //            ROUND(e.upah/173) AS upah_perjam, 
        //            COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
        //            COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
        //            -- diremarks karena uang insentive di setting di grade status jika 0 berarti dapat snack jika 1 berarti tidak (COALESCE(i.hk_dibayar,0) * @insentive_snack) AS insentive_snack,
        //            CASE
        //                    WHEN e.uang_makan = 0 THEN 0
        //                    WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
        //            END AS insentive_snack,
        //            -- COALESCE(e.upah + ((COUNT(COALESCE(i.hk_dibayar,0)) * @insentive_snack) + (COUNT(COALESCE(i.hk_dibayar,0)) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0),0) AS total_pendapatan,
        //            -- e.uang_makan AS insentive_snack,
        //            COALESCE(e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0),0) AS total_pendapatan,
        //            COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS total_potongan,
        //            CASE
        //                    WHEN e.overtime = 0 THEN 
        //            CASE
        //            -- 1 = ikut jamsostek, 0 = tidak ikut jamsostek
        //            WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0))
        //            WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
        //            WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
        //            WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
        //            -- WHEN e.jamsostek = 0 AND e.lifeinsurance = 0 then 'tidak jamsostek dan bpjs'
        //            -- WHEN e.jamsostek = 1 AND e.lifeinsurance = 0 then 'ikut jamsostek dan tidak bpjs'
        //            -- WHEN e.jamsostek = 0 AND e.lifeinsurance = 1 then 'ikut bpjs dan tidak jamsostek'
        //            -- WHEN e.jamsostek = 1 AND e.lifeinsurance = 1 then 'ikut jamsostek dan ikut bpjs'
        //            END					-- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
        //                    WHEN e.overtime = 1 THEN
        //            CASE
        //            -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek di bayarkan 
        //            WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
        //            -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek tidak bayarkan 
        //            WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
        //            -- jika dia mendapatkan overtime dan jika bpjs dibayarkan tapi jamsostek tidak di bayarkan 
        //            WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
        //            -- jika dia mendapatkan overtime dan jika bpjs tidak dibayarkan tapi jamsostek di bayarkan 
        //            WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
        //            END						-- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
        //            END AS gaji_bersih
        //            FROM (
        //            SELECT 
        //              a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
        //              CASE 
        //                    WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
        //                    ELSE a.total_jam_lembur
        //              END AS total_jam_lembur
        //            FROM
        //              gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
        //              ON a.empcode = b.empcode 
        //            WHERE a.attd_date BETWEEN @start_date AND @end_date
        //            ) a
        //            LEFT JOIN (SELECT 
        //              empcode,
        //              COUNT(empcode) total_sia
        //            FROM
        //              gang_activity 
        //            WHERE attd_date BETWEEN @start_date 
        //              AND @end_date 
        //              AND attd_code IN ('attd004', 'attd005')
        //              GROUP BY empcode) j ON a.empcode = j.empcode
        //            LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
        //            ON a.empcode = i.empcode
        //            RIGHT JOIN (SELECT * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
        //            ON a.empcode = b.empcode
        //            INNER JOIN master_position c
        //            ON b.position = c.id_position
        //            INNER JOIN master_dept d
        //            ON b.departement = d.departement
        //            -- diremarks untuk menampilkan field yang digunakan saja dan untuk perhitungaan potongan
        //            -- INNER JOIN hr_hist_status e
        //            INNER JOIN (SELECT a.empcode, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
        //            CASE
        //            -- jika jamsostek tidak di bayarkan
        //            WHEN a.jamsostek = 0 THEN 0 
        //            WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
        //            END
        //            AS jamsostek,
        //            CASE
        //            -- jika bpjs tidak di bayarkan
        //            WHEN a.lifeinsurance = 0 THEN 0
        //            -- jika bpjs dibayarkan
        //            WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
        //            END 
        //            AS jpk
        //            FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) b WHERE a.overtime = 1) e
        //            ON b.empcode = e.empcode
        //            LEFT JOIN master_golongan i ON e.grade = i.id_golongan
        //            LEFT JOIN (
        //                                                            SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
        //            GROUP BY empcode
        //            )f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
        //            ON b.empcode = f.empcode
        //            LEFT JOIN (
        //                                                            SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
        //            GROUP BY empcode)g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
        //            ON b.empcode = g.empcode,
        //            (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) h 
        //            WHERE a.attd_date BETWEEN @start_date AND @end_date
        //            -- AND b.empcode = '1900397'
        //            -- AND b.departement = '1' AND b.position = 'pos03'
        //            GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname
        //            "
        //     );
            $query = $this->db->query("
            SELECT a.period, a.year, a.start_date, a.bankname, a.bankaccountname, a.bankaccountno, a.empcode, a.empname, a.nik_pim,  a.position_desc, a.golongan, a.upah, a.kehadiran_pagi, a.dept_desc, a.total_sia, a.pot_prop, a.gaji_setelah_sia, a.deduction, a.allowance, a.jamsostek, a.jpk, a.hk_dibayar, a.uang_makan_ramadhan, a.total_uang_makan_ramadhan, a.kehadiran_bulanan, a.upah_perjam, a.jam_lembur, a.uang_lembur, a.insentive_snack, a.total_pendapatan, a.total_potongan, a.gaji_bersih FROM (
                SELECT MONTH(@end_date) AS period, YEAR(@end_date) AS YEAR, e.start_date, b.bankname, b.bankaccountname, b.bankaccountno, b.empcode, b.empname, b.nik_pim, b.position, c.position_desc, e.grade, i.golongan, e.upah,  e.kehadiran_pagi,
                 b.departement,  d.dept_desc, 
                 COALESCE(j.total_sia,0) AS total_sia,
                 COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS pot_prop,
                 CASE
                 WHEN COALESCE(j.total_sia,0) > 0 THEN e.upah - ROUND(j.total_sia * ABS(e.upah/26))
                 ELSE e.upah
                 END AS gaji_setelah_sia,
                COALESCE(f.deduction,0) AS deduction,
                COALESCE(g.allowance,0) AS allowance,
                CASE
                -- jika jamsostek tidak di bayarkan
                WHEN e.status_jamsostek = 0 THEN 0 
                WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
                END
                AS jamsostek,
                CASE
                -- jika bpjs tidak di bayarkan
                WHEN e.lifeinsurance = 0 THEN 0
                -- jika bpjs dibayarkan
                WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
                END 
                AS jpk,
                -- ROUND(3/100 * e.upah) as jamsostek,
                -- ROUND(1/100 * e.upah) as jpk,
                -- f.remarks,
                -- COUNT(a.attd_date) AS hk,
                COALESCE(i.hk_dibayar,0) AS hk_dibayar,
                COALESCE(k.shift_satu,0) AS uang_makan_ramadhan,
                COALESCE(k.shift_satu,0) * @uang_makan AS total_uang_makan_ramadhan,
                COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi AS kehadiran_bulanan, 
                ROUND(e.upah/173) AS upah_perjam, 
                COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
                COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
                -- diremarks karena uang insentive di setting di grade status jika 0 berarti dapat snack jika 1 berarti tidak (i.hk_dibayar * @insentive_snack) AS insentive_snack,
                CASE
                        WHEN e.uang_makan = 0 THEN 0
                        WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
                END AS insentive_snack,
                -- COALESCE(e.upah + ((COUNT(i.hk_dibayar) * @insentive_snack) + (COUNT(i.hk_dibayar) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0),0) AS total_pendapatan,
                -- e.uang_makan AS insentive_snack,
                COALESCE(e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((i.hk_dibayar * e.uang_makan),0) + (COALESCE(k.shift_satu,0) * @uang_makan),0) AS total_pendapatan,
                COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS total_potongan,
                CASE
                        WHEN e.overtime = 0 THEN -- all in
                CASE
                        -- 1 = ikut jamsostek, 0 = tidak ikut jamsostek
                        WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COALESCE(k.shift_satu,0) * @uang_makan) + (COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0))
                        WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COALESCE(k.shift_satu,0) * @uang_makan) + (COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
                        WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COALESCE(k.shift_satu,0) * @uang_makan) + (COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
                        WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COALESCE(k.shift_satu,0) * @uang_makan) + (COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
                        -- WHEN e.jamsostek = 0 AND e.lifeinsurance = 0 then 'tidak jamsostek dan bpjs'
                        -- WHEN e.jamsostek = 1 AND e.lifeinsurance = 0 then 'ikut jamsostek dan tidak bpjs'
                        -- WHEN e.jamsostek = 0 AND e.lifeinsurance = 1 then 'ikut bpjs dan tidak jamsostek'
                        -- WHEN e.jamsostek = 1 AND e.lifeinsurance = 1 then 'ikut jamsostek dan ikut bpjs'
                END					-- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
                        WHEN e.overtime = 1 THEN -- oveertime
                CASE
                        -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek di bayarkan 
                        WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(k.shift_satu,0) * @uang_makan) + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((i.hk_dibayar * e.uang_makan),0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
                        -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek tidak bayarkan 
                        WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(k.shift_satu,0) * @uang_makan) + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((i.hk_dibayar * e.uang_makan),0) - (COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
                        -- jika dia mendapatkan overtime dan jika bpjs dibayarkan tapi jamsostek tidak di bayarkan 
                        WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(k.shift_satu,0) * @uang_makan) + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((i.hk_dibayar * e.uang_makan),0) - (e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
                        -- jika dia mendapatkan overtime dan jika bpjs tidak dibayarkan tapi jamsostek di bayarkan 
                        WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(k.shift_satu,0) * @uang_makan) + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((i.hk_dibayar * e.uang_makan),0) - (e.jamsostek + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
                END						-- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
                END AS gaji_bersih
                FROM (
                SELECT 
                  a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
                  CASE 
                        WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
                        ELSE a.total_jam_lembur
                  END AS total_jam_lembur
                FROM
                  gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
                  ON a.empcode = b.empcode 
                WHERE a.attd_date BETWEEN @start_date AND @end_date
                ) a
                LEFT JOIN (SELECT 
                  empcode,
                  COUNT(empcode) total_sia
                FROM
                  gang_activity 
                WHERE attd_date BETWEEN @start_date 
                  AND @end_date 
                  AND attd_code IN ('attd004', 'attd005')
                  GROUP BY empcode) j ON a.empcode = j.empcode
                LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
                ON a.empcode = i.empcode
                LEFT JOIN (SELECT a.empcode, COUNT(a.shift) AS shift_satu FROM (SELECT * FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date) a WHERE a.attd_date BETWEEN @start_date_shaum AND @end_date_shaum  AND a.work_hour > 0 AND a.shift = 'SHIFT I' GROUP BY a.empcode) k
                ON a.empcode = k.empcode
                RIGHT JOIN (SELECT * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
                ON a.empcode = b.empcode
                INNER JOIN master_position c
                ON b.position = c.id_position
                INNER JOIN master_dept d
                ON b.departement = d.departement
                -- diremarks untuk menampilkan field yang digunakan saja dan untuk perhitungaan potongan
                -- INNER JOIN hr_hist_status e
                INNER JOIN (SELECT a.empcode, a.start_date, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
                CASE
                -- jika jamsostek tidak di bayarkan
                WHEN a.jamsostek = 0 THEN 0 
                WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
                END
                AS jamsostek,
                CASE
                -- jika bpjs tidak di bayarkan
                WHEN a.lifeinsurance = 0 THEN 0
                -- jika bpjs dibayarkan
                WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
                END 
                AS jpk
                FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) b WHERE a.overtime = 1) e
                ON b.empcode = e.empcode
                LEFT JOIN master_golongan i ON e.grade = i.id_golongan
                LEFT JOIN (
                                                                SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
                GROUP BY empcode
                )f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
                ON b.empcode = f.empcode
                LEFT JOIN (
                                                                SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
                GROUP BY empcode)g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
                ON b.empcode = g.empcode,
                (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM master_ump ORDER BY id DESC LIMIT 1) h 
                WHERE a.attd_date BETWEEN @start_date AND @end_date
                -- AND b.empcode = '1800326'
                -- AND b.departement = '1' AND b.position = 'pos03'
                GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname) a
            ");
            return $query->result_array();
    }





}