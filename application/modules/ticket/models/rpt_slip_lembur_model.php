 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rpt_slip_lembur_model extends CI_Model {


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
        if($month)
        {
            $this->db->where('MONTH(a.attd_date)', $month);
        }
        if($year)
        {
            $this->db->where('YEAR(a.attd_date)', $year);
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
       $query = $this->db->query('
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
and MONTH(a.attd_date) = "'.$month.'"
and YEAR(a.attd_date) = "'.$year.'"
GROUP BY  a.attd_date
WITH ROLLUP');
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

}