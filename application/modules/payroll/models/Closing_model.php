<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Closing_model extends CI_Model
{


    var $table = "closing_payroll";
    var $colum_order = array('period','year');
    var $column_search = array('period','year','dept_desc','position_desc', 'empname');
    var $order = array('period','year','dept_desc','position_desc', 'empname');
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }    

    private function _get_datatables_query()
    {
        if ($this->input->post('filter_period')) {
            $this->db->where('period',$this->input->post('filter_period'));
        }
        if ($this->input->post('filter_year')) {
            $this->db->where('year',$this->input->post('filter_year'));            
        }
        if ($this->input->post('f_empcode_f')) {
            $this->db->where('empcode',$this->input->post('f_empcode_f'));
        }
        if ($this->input->post('filter_dept')) {
            $this->db->where('departement',$this->input->post('filter_dept'));
        }

        $this->db->select('*');
        $this->db->from($this->table);
        

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

    public function get_datatables_query()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    public function closing($start_date, $end_date, $close_by)
    {
        $this->db->query("SET @start_date = '".$start_date."'");
        $this->db->query("SET @end_date = '".$end_date."'");
        $this->db->query("SET @start_date_shaum := '2019-05-06' ");
        $this->db->query("SET @end_date_shaum := '2019-06-04'");
        $this->db->query("SET @insentive_snack := 5000");
        $this->db->query("SET @uang_makan := 14000 ");
//         $query = $this->db->query("
//         INSERT INTO closing_payroll (period, YEAR, empcode, empname, nik_pim, POSITION, position_desc, grade, golongan, upah, kehadiran_pagi, departement, dept_desc, total_sia, pot_prop, gaji_setelah_sia, deduction, allowance, jamsostek, jpk, hk_dibayar, kehadiran_bulanan, upah_perjam, jam_lembur, uang_lembur, insentive_snack, total_pendapatan, total_potongan, gaji_bersih, inputby, inputdate)
// SELECT a.period, a.year, a.empcode, a.empname, a.nik_pim, a.position, a.position_desc, a.grade, a.golongan, a.upah, a.kehadiran_pagi, a.departement, a.dept_desc, a.total_sia, a.pot_prop, a.gaji_setelah_sia, a.deduction, a.allowance, a.jamsostek, a.jpk, a.hk_dibayar, a.kehadiran_bulanan, a.upah_perjam, a.jam_lembur, a.uang_lembur, a.insentive_snack, a.total_pendapatan, a.total_potongan, a.gaji_bersih,'".$close_by."', NOW() FROM (
// SELECT MONTH(@end_date) AS period, YEAR(@end_date) AS YEAR, b.empcode, b.empname, b.nik_pim, b.position, c.position_desc, e.grade, i.golongan, e.upah,  e.kehadiran_pagi,
//  b.departement,  d.dept_desc, 
//  COALESCE(j.total_sia,0) AS total_sia,
//  ROUND(j.total_sia * ABS(e.upah/26)) AS pot_prop,
//  CASE
//  WHEN COALESCE(j.total_sia,0) > 0 THEN e.upah - ROUND(j.total_sia * ABS(e.upah/26))
//  ELSE e.upah
//  END AS gaji_setelah_sia,
// COALESCE(f.deduction,0) AS deduction,
// COALESCE(g.allowance,0) AS allowance,
// CASE
// WHEN e.status_jamsostek = 0 THEN 0 
// WHEN e.status_jamsostek = 1 THEN ROUND(3/100 * e.upah)
// END
// AS jamsostek,
// CASE
// WHEN e.lifeinsurance = 0 THEN 0
// WHEN e.lifeinsurance = 1 THEN ROUND(1/100 * h.rate)
// END 
// AS jpk,
// COALESCE(i.hk_dibayar,0) as hk_dibayar,
// COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi AS kehadiran_bulanan, 
// ROUND(e.upah/173) AS upah_perjam, 
// COALESCE(SUM(a.total_jam_lembur),0) AS jam_lembur, 
// COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0) AS uang_lembur, 
// CASE
// 	WHEN e.uang_makan = 0 THEN 0
// 	WHEN e.uang_makan > 0 THEN (COALESCE(i.hk_dibayar,0) * e.uang_makan)
// END AS insentive_snack,
// COALESCE(e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0),0) AS total_pendapatan,
// COALESCE(e.jamsostek + e.jpk,0) + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0) AS total_potongan,
// CASE
// 	WHEN e.overtime = 0 THEN 
// CASE
// WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0))
// WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jamsostek
// WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - e.jpk
// WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + ((COUNT(a.attd_date) * e.uang_makan) + (COUNT(a.attd_date) * e.kehadiran_pagi) + COALESCE(ROUND((e.upah/173) * SUM(a.overtime)),0)) - (e.jamsostek + e.jpk)
// END					-- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
// 	WHEN e.overtime = 1 THEN
// CASE
// WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
// WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
// WHEN e.status_jamsostek = 0 AND e.lifeinsurance = 1 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jpk + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
// WHEN e.status_jamsostek = 1 AND e.lifeinsurance = 0 THEN e.upah + (COALESCE(i.hk_dibayar,0) * e.kehadiran_pagi) + (COALESCE(ROUND((e.upah/173) * SUM(a.total_jam_lembur)),0)) + COALESCE(g.allowance,0) + COALESCE((COALESCE(i.hk_dibayar,0) * e.uang_makan),0) - (e.jamsostek + COALESCE(f.deduction,0) + COALESCE(ROUND(j.total_sia * ABS(e.upah/26)),0))
// END						
// END AS gaji_bersih
// FROM (
// SELECT 
//   a.empcode, a.attd_date, a.attd_code, a.overtime, a.remarks, a.psk, a.reg_hour, a.short_work_hour, a.whtl, a.off_day, a.bantu_satu_ot, a.bantu_dua_ot, a.first_ot, a.second_ot, a.third_ot, a.fourth_ot, a.total_jam_lembur AS tot_jam_lembur, a.losstime, a.work_hour, b.date, 
//   CASE 
// 	WHEN a.empcode = b.empcode AND a.attd_date = b.date THEN a.total_jam_lembur + b.overtime
// 	ELSE a.total_jam_lembur
//   END AS total_jam_lembur
// FROM
//   gang_activity a LEFT JOIN (SELECT empcode, DATE, overtime FROM spl WHERE DATE BETWEEN @start_date AND @end_date) b
//   ON a.empcode = b.empcode 
// WHERE a.attd_date BETWEEN @start_date AND @end_date
// ) a
// LEFT JOIN (SELECT 
//   empcode,
//   COUNT(empcode) total_sia
// FROM
//   gang_activity 
// WHERE attd_date BETWEEN @start_date 
//   AND @end_date 
//   AND attd_code IN ('attd004', 'attd005')
//   GROUP BY empcode) j ON a.empcode = j.empcode
// LEFT JOIN (SELECT empcode, COUNT(attd_date) AS hk_dibayar FROM gang_activity WHERE attd_date BETWEEN @start_date AND @end_date AND work_hour > 0 GROUP BY empcode) i
// ON a.empcode = i.empcode
// RIGHT JOIN (SELECT * FROM emp_master WHERE is_deleted != 1 AND empcode NOT IN (SELECT empcode FROM hr_termination WHERE dateterminate < @start_date)) b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
// ON a.empcode = b.empcode
// INNER JOIN master_position c
// ON b.position = c.id_position
// INNER JOIN master_dept d
// ON b.departement = d.departement
// INNER JOIN (SELECT a.empcode, a.upah, a.grade, a.kehadiran_pagi, a.uang_makan, a.jamsostek AS status_jamsostek, a.lifeinsurance, a.overtime,
// CASE
// WHEN a.jamsostek = 0 THEN 0 
// WHEN a.jamsostek = 1 THEN ROUND(3/100 * a.upah)
// END
// AS jamsostek,
// CASE
// WHEN a.lifeinsurance = 0 THEN 0
// WHEN a.lifeinsurance = 1 THEN ROUND(1/100 * b.rate)
// END 
// AS jpk
// FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM MASTER_UMP ORDER BY id DESC LIMIT 1) b) e
// ON b.empcode = e.empcode
// LEFT JOIN master_golongan i ON e.grade = i.id_golongan
// LEFT JOIN (
// 						SELECT empcode, adhoc_date,SUM(amount) AS deduction FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%D%'
// GROUP BY empcode
// )f 
// ON b.empcode = f.empcode
// LEFT JOIN (
// 						SELECT empcode, adhoc_date, allowded_code, SUM(amount) AS allowance FROM empallded WHERE adhoc_date BETWEEN @start_date AND @end_date AND allowded_code LIKE '%A%'
// GROUP BY empcode)g
// ON b.empcode = g.empcode,
// (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM MASTER_UMP ORDER BY id DESC LIMIT 1) h
// WHERE a.attd_date BETWEEN @start_date AND @end_date 
// GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname) a
//         ");
// aktifkan lagi jika sudah 

$query = $this->db->query("
INSERT INTO closing_payroll (period, YEAR, doj, bank_name, bankaccountname, bankaccountno, empcode, empname, nik_pim, POSITION, position_desc, grade, golongan, upah, kehadiran_pagi, departement, dept_desc, total_sia, pot_prop, gaji_setelah_sia, deduction, allowance, jamsostek, jpk, hk_dibayar, uang_makan_ramadhan, total_uang_makan_ramadhan, kehadiran_bulanan, upah_perjam, jam_lembur, uang_lembur, insentive_snack, total_pendapatan, total_potongan, gaji_bersih, inputby, inputdate)
SELECT a.period, a.year, a.start_date, a.bankname, a.bankaccountname, a.bankaccountno, a.empcode, a.empname, a.nik_pim, a.position, a.position_desc, a.grade, a.golongan, a.upah, a.kehadiran_pagi, a.departement, a.dept_desc, a.total_sia, a.pot_prop, a.gaji_setelah_sia, a.deduction, a.allowance, a.jamsostek, a.jpk, a.hk_dibayar, a.uang_makan_ramadhan, a.total_uang_makan_ramadhan, a.kehadiran_bulanan, a.upah_perjam, a.jam_lembur, a.uang_lembur, a.insentive_snack, a.total_pendapatan, a.total_potongan, a.gaji_bersih, CURRENT_USER(), NOW() FROM (
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
FROM hr_hist_status a, (SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM MASTER_UMP ORDER BY id DESC LIMIT 1) b WHERE a.overtime = 1) e
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
(SELECT ID, EFFECTIVE_DATE AS EFFE, REMARKS, RATE FROM MASTER_UMP ORDER BY id DESC LIMIT 1) h 
WHERE a.attd_date BETWEEN @start_date AND @end_date
-- AND b.empcode = '1800326'
-- AND b.departement = '1' AND b.position = 'pos03'
GROUP BY a.empcode ORDER BY b.departement, b.position, b.empname) a
");
		return $this->db->affected_rows();

    }

    public function cek_data($period, $year)
    {
        $this->db->from($this->table);
        $this->db->where('period',$period);
        $this->db->where('year',$year);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function delete_all($period, $year)
    {
        $this->db->where('period',$period);
        $this->db->where('year',$year);
        $this->db->delete($this->table);
    }



} // end of model
