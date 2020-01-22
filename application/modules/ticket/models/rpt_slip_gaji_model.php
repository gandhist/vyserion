 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rpt_slip_gaji_model extends CI_Model {


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
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 5:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 6:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 7:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 8:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 9:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 10:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 11;
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
                    case 12:
            $this->db->where('a.attd_date BETWEEN "'.$year.'-01-26" AND "'.$year.'-01-25"');     
                    break;
            }
            //$this->db->where('a.attd_date BETWEEN "2018-01-25" AND "2018-01-25"');
        }

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
        $this->db->select('b.empcode, b.empname, b.position, c.position_desc, b.departement, d.dept_desc, e.upah, e.kehadiran_pagi, 
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
ROUND(1/173*e.upah) as upah_perjam, 
coalesce(SUM(a.overtime),0) as jam_lembur, 
coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0) as uang_lembur, 
(COUNT(a.attd_date) *5000) as insentive_snack,
coalesce(e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0),0) as total_pendapatan,
COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) as total_potongan,
CASE
    when e.overtime = 1 THEN 
CASE
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jamsostek
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - e.jpk
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
end 
    when e.overtime = 0 THEN
CASE
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jpk + COALESCE(f.deduction,0))
WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 then e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - (e.jamsostek + COALESCE(f.deduction,0))
end
END as gaji_bersih');
        $this->db->from('(SELECT * FROM gang_activity where attd_code in("attd001","attd010","attd011") and attd_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'") a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) h');
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
from hr_hist_status a, (SELECT ID, MAX(EFFECTIVE_DATE) AS EFFE, REMARKS, RATE FROM MASTER_UMP) b) as e','b.empcode = e.empcode');
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
       $query = $this->db->query('
select COALESCE(a.empcode,"Grand Total") as empcode, COALESCE(b.empname,"Sub Total") as empname, COALESCE(a.attd_date,"Sub Total") as attd_date,c.upah, a.overtime, a.attd_code,
round((a.overtime * 1 / 173 * c.upah)) as lembur
, coalesce(ROUND((1/173*c.upah) * SUM(a.overtime)),0) as total,a.remarks
from gang_activity a, emp_master b, hr_hist_status c
where a.empcode = b.empcode
and a.empcode = c.empcode
and a.empcode = "'.$id.'"
and a.attd_date BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'" 
GROUP BY  a.attd_date
WITH ROLLUP');
        return $query->result_array();

    }

    function detail_deduction($id)
    {
        $query = $this->db->query('');
    }

}