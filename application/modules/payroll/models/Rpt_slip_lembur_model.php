<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpt_slip_lembur_model extends CI_Model {


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

    function slip_gaji($empcode, $dept_id, $position_id, $year, $month)
    {
        /*jika cutoff di majukan maka setting parameter tanggal cut off di sini*/

        if ($empcode) {
        $this->db->where('b.empcode',$empcode);
        }
        if ($dept_id) {
        $this->db->where('b.departement',$dept_id);
        }
        if ($position_id) {
        $this->db->where('b.position',$position_id);
        }
        if($month)
        {
            $this->db->where('MONTH(a.attd_date)', $month);
        }
        if($year)
        {
            $this->db->where('YEAR(a.attd_date)', $year);
        }
       
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
        $this->db->select('a.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, coalesce(f.amount,0) as amount, f.remarks,
COUNT(a.attd_date) as hk, a.attd_date,
COUNT(a.attd_date) * e.kehadiran_pagi as kehadiran_bulanan, 
ROUND(1/173*e.upah) as upah_perjam, 
COALESCE(SUM(a.overtime),0) as jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
COALESCE((e.upah + (COUNT(a.attd_date) *5000) + ROUND((1/173*e.upah) * SUM(a.overtime)) + (COUNT(a.attd_date) * e.kehadiran_pagi) ) - f.amount,0) as gaji_bersih');
        $this->db->from('(SELECT * FROM gang_activity  where attd_code in("attd001","attd010","attd011")) a');
        $this->db->join('emp_master as b','a.empcode = b.empcode','right');
        $this->db->join('master_position as c','b.position = c.id_position');
        $this->db->join('master_dept as d','b.departement = d.departement');
        $this->db->join('hr_hist_status as e','b.empcode = e.empcode');
        $this->db->join('empallded as f','b.empcode = f.empcode','left');
        $this->db->group_by('a.empcode');

        $query = $this->db->get();

        //$this->db->where('b.empcode', '1800001');
        return $query->result_array();
    }

    function detail_lembur($empcode)
    {
       $query = $this->db->query('
select COALESCE(a.empcode,"Grand Total") as empcode, 
COALESCE(b.empname,"Sub Total") as empname, 
COALESCE(a.attd_date,"Sub Total") as attd_date,
c.upah, 
a.overtime, 
a.attd_code,
round((a.overtime * 1 / 173 * c.upah)) as lembur, 
coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,
a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = "'.$empcode.'"
GROUP BY  a.attd_date
WITH ROLLUP');


        return $query->result_array();

    }

    // slip overtime untuk rpt overtime
    function rpt_detail_lembur($empcode, $month, $year)
    {
        /*jika cutoff di majukan maka setting parameter tanggal cut off di sini*/

        $get_period = get_date_period($month, $year);
        $filter_start_date  = $get_period->start_date;
        $filter_end_date    = $get_period->end_date;

        // if($month || $year)
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

       /*$query = $this->db->query('
select
COALESCE(a.empcode,"Grand Total") as empcode,
COALESCE(b.empname,"Sub Total") as empname,
COALESCE(a.attd_date,"Sub Total") as attd_date,
c.upah, 
SUM(a.overtime) AS overtime,
a.attd_code,
round((a.overtime * 1 / 173 * c.upah)) as lembur, 
coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,
a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = "'.$empcode.'"
and a.attd_date BETWEEN "'.$filter_start_date.'" and "'.$filter_end_date.'"
GROUP BY  a.attd_date
WITH ROLLUP');*/


/* select yang lama
a.id_emp_act_sk,
  COALESCE(a.empcode, "Grand Total") AS empcode,
  COALESCE(b.empname, "Sub Total") AS empname,
  COALESCE(a.attd_date, "Sub Total") AS attd_date,
  c.upah,
  SUM(d.kehadiran_pagi) AS kehadiran_pagi,
  SUM(a.total_jam_lembur) AS total_jam_lembur,
  a.attd_code,
  ROUND((a.total_jam_lembur * 1 / 173 * c.upah)) AS lembur,
  COALESCE(
    ROUND((c.upah / 173) * SUM(a.total_jam_lembur)),
    0
  ) AS total,
  CASE
    WHEN a.work_hour > 0 THEN SUM(d.kehadiran_pagi)
  END AS kehadiran,
  a.remarks */


$this->db->query("SET @start_date = '".$filter_start_date."'");
$this->db->query("SET @end_date = '".$filter_end_date."'");
$this->db->query("SET @empcode = '".$empcode."'");
$query = $this->db->query('select 
COALESCE(a.attd_date, "Sub Total") AS attd_date,
SUM(d.kehadiran_pagi) AS kehadiran_pagi,
SUM(a.total_jam_lembur) AS total_jam_lembur,
a.attd_code,
COALESCE(
  ROUND((c.upah / 173) * SUM(a.total_jam_lembur)),
  0
) AS total
FROM
  gang_activity a LEFT JOIN (SELECT 
a.id_emp_act_sk,
  a.empcode,
  a.attd_date,
  a.work_hour, b.kehadiran_pagi
FROM
  gang_activity a LEFT JOIN hr_hist_status b ON a.empcode = b.empcode
WHERE a.empcode = @empcode 
  AND a.work_hour > 0 
  AND a.attd_date BETWEEN @start_date
  AND @end_date) d ON a.id_emp_act_sk = d.id_emp_act_sk,
  emp_master b,
  hr_hist_status c 
WHERE a.empcode = b.empcode 
  AND a.empcode = c.empcode 
  AND a.empcode = @empcode
  AND a.attd_date BETWEEN @start_date
  AND @end_date
GROUP BY a.attd_date WITH ROLLUP ');
        return $query->result_array();

    }

    function slip_lembur()
    {
        /*select COALESCE(a.empcode,'Grand Total') as empcode, COALESCE(b.empname,'Sub Total') as empname, COALESCE(a.attd_date,'Sub Total') as attd_date, MONTH(a.attd_date) as mont, YEAR(a.attd_date) as year, a.attd_code, c.upah, a.overtime,
round((a.overtime * 1 / 173 * c.upah)) as lembur,
-- coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,
a.remarks, b.departement,b.position, b.employeetype
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and MONTH(a.attd_date) = '1'*/
        $this->db->select('a.empcode, b.empname, a.attd_date, MONTH(a.attd_date) as mont, YEAR(a.attd_date) as year, a.attd_code, c.upah, a.overtime,
round((a.overtime * 1 / 173 * c.upah)) as lembur,
round(1 / 173 * c.upah) as perjam,
a.remarks, b.departement,b.position, b.employeetype');
        $this->db->from('gang_activity a, emp_master b, hr_hist_status c');
        $this->db->where('a.empcode = b.empcode and a.empcode = c.empcode');
        $this->db->order_by('empcode','desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function header_slip_rev01($empcode, $dept_id, $position_id, $month, $year)
    {
        /*jika cutoff di majukan maka setting parameter tanggal cut off di sini*/
         if ($empcode) {
        $this->db->where('b.empcode',$empcode);
        }
        if ($dept_id) {
        $this->db->where('b.departement',$dept_id);
        }
        if ($position_id) {
        $this->db->where('b.position',$position_id);
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

        $query = $this->db->query('SET @start_date = "'.$filter_start_date.'" ;
SET @end_date = "'.$filter_end_date.'";
SET @insentive_snack := 5000;
SELECT b.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi,
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
i.hk_dibayar,
i.hk_dibayar * e.kehadiran_pagi AS kehadiran_bulanan, 
ROUND(1/173*e.upah) AS upah_perjam, 
COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
e.uang_makan AS insentive_snack,
COALESCE(e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0),0) AS total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) AS total_potongan,
CASE
    WHEN e.overtime = 0 THEN 
CASE
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * @insentive_snack) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
END                 
    WHEN e.overtime = 1 THEN
CASE
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - COALESCE(f.deduction,0)
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (i.hk_dibayar * e.kehadiran_pagi) + (COALESCE(ROUND((1/173*e.upah) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE(e.uang_makan,0) - (e.jamsostek + COALESCE(f.deduction,0))
END                     
END AS gaji_bersih
FROM (SELECT * FROM gang_activity  WHERE attd_code IN("attd001","attd002","attd003") AND attd_date BETWEEN @start_date AND @end_date) a
LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
ON a.empcode = i.empcode
RIGHT JOIN emp_master b 
ON a.empcode = b.empcode
INNER JOIN master_position c
ON b.position = c.id_position
INNER JOIN master_dept d
ON b.departement = d.departement
INNER JOIN (SELECT a.empcode, a.upah, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
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
FROM hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) b) e
ON b.empcode = e.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%D%"
GROUP BY empcode
)f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = f.empcode
LEFT JOIN (
                        SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE "%A%""
GROUP BY empcode)g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
ON b.empcode = g.empcode,
(SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) h
WHERE a.attd_date BETWEEN @start_date AND @end_date
GROUP BY a.empcode');
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
FROM hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) b) e
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
(SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) h
WHERE a.attd_date BETWEEN @start_date AND @end_date
GROUP BY a.empcode
        */
    }


    



}