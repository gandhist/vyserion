<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Absen_model extends CI_Model {
 
 var $table = 'absen_finger';
    var $column_order = array('a.pin','b.empname', 'DATE(a.date_time)', 'a.date_time', 'a.ver', 'a.status'); //set column field database for datatable orderable
    var $column_search = array('a.pin','b.empname', 'DATE(a.date_time)', 'a.date_time', 'a.ver', 'a.status'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('a.date_time' => 'desc'); // default order 
    function __construct()
    {
        parent::__construct();
        $this->load->helper('parse_helper');
        
    }

    private function _get_datatables_query()
    {

        //add custom filter here
        if($this->input->post('f_empcode_f'))
            {
                $this->db->where('b.empcode', $this->input->post('f_empcode_f'));
            }
            if ($this->input->post('f_gang_f')) {
                $this->db->where("`b.empcode` IN (SELECT DISTINCT(`empcode`) AS empcode FROM `gang_master` WHERE id_gang = '".$this->input->post('f_gang_f')."')");
            }
        if($this->input->post("f_start_date_f") || $this->input->post("f_end_date_f"))
        {
            $this->db->where('DATE(a.date_time) BETWEEN "'.$this->input->post("f_start_date_f").'" AND "'.$this->input->post("f_end_date_f").'"');
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
        $this->db->select('a.id, a.pin, b.empcode, b.empname, DATE(a.date_time) AS tanggal, a.date_time, a.ver, a.status');
        $this->db->from('absen_finger a');
        $this->db->join('(SELECT 
        empcode,
        empname,
        badgenumber 
      FROM
        emp_master 
      WHERE departement = 8) b','a.pin = b.badgenumber','left');
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
 
    public function get_setting(){
        $data = $this->db->get('absen_pengaturan')->row();
        return $data;
    }
 
    public function if_exist_check($PIN, $DateTime){
        $data = $this->db->get_where('absen_finger', array('pin' => $PIN, 'date_time' => $DateTime))->row();
        return $data;
    }

    public function last_attendance()
    {
        $this->db->select_max('date_time');
        $query = $this->db->get('absen_finger');
        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert("absen_finger", $data);
        return $this->db->insert_id();
    }
    
 
    public function get_data_absen(){
        error_reporting(0);
        $IP = "192.168.11.236";
        $Key = "0";
        if($IP!=""){
        $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
            if($Connect){
                $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                $buffer="";
                while($Response=fgets($Connect, 1024)){
                    $buffer=$buffer.$Response;
                }
                $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                $buffer = explode("\r\n",$buffer);
                for($a=0;$a<count($buffer);$a++){
                    $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                    $PIN = Parse_Data($data,"<PIN>","</PIN>");
                    $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
                    $Verified = Parse_Data($data,"<Verified>","</Verified>");
                    $Status = Parse_Data($data,"<Status>","</Status>");
                    $ins = array(
                            "pin"       =>  $PIN,
                            "date_time" =>  $DateTime,
                            "ver"       =>  $Verified,
                            "status"    =>  $Status
                            );
                    if (!$this->if_exist_check($PIN, $DateTime) && $PIN && $DateTime) {
                        $this->db->insert('absen_finger', $ins);
                    }
                }
                if($buffer){
                    return '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Success !</h4>
                        Anda terhubung dengan mesin.
                    </div>';
                } else {
                    return '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Anda tidak terhubung dengan mesin !
                    </div>';
                }
            }
        } 
    }


    public function download_data_presensi($start_date, $end_date, $dept_id, $empcode, $inputby)
    {
        //$query = $this->db->query(" select '".$data['start_date']."','".$data['end_date']."','".$data['inputby']."', NOW() ");
        $query = $this->db->query('CALL download_presensi_gaji_all_by_dept("'.$start_date.'", "'.$end_date.'","'.$dept_id.'", "'.$inputby.'", NOW());');
        
    }

    public function download_data_presensi_pro($start_date, $end_date, $dept_id, $empcode, $inputby)
    {
        //$query = $this->db->query(" select '".$data['start_date']."','".$data['end_date']."','".$data['inputby']."', NOW() ");
        $query = $this->db->query('CALL download_presensi_gaji_all_by_dept_pro("'.$start_date.'", "'.$end_date.'","'.$dept_id.'",  "'.$inputby.'", NOW());');
        
    }

    public function download_data_presensi_pro_by_empcode($start_date, $end_date, $dept_id, $empcode, $inputby)
    {
        $query = $this->db->query('CALL download_presensi_gaji_all_by_dept_empcode_pro("'.$start_date.'", "'.$end_date.'","'.$dept_id.'", "'.$empcode.'", "'.$inputby.'", NOW());');

    }

    public function download_data_presensi_by_empcode($start_date, $end_date, $dept_id, $empcode, $inputby)
    {
        $query = $this->db->query('CALL download_presensi_gaji_all_by_dept_empcode("'.$start_date.'", "'.$end_date.'","'.$dept_id.'", "'.$empcode.'", "'.$inputby.'", NOW());');
	}
	
	public function delete_duplicate_gang_activity($start_date, $end_date)
	{
		$query = $this->db->query('CALL delete_duplicate_general_activity("'.$start_date.'","'.$end_date.'");');
	}

    public function get_finger()
    {
        $query = $this->db->query("select * from absen_pengaturan");
        return $query->result();
    }

    public function get_empcode_by_dept($period, $year, $dept_id)
    {
        $query = $this->db->query("select a.empcode, b.empname, LEFT(b.nik_pim,3) AS nik , a.remarks FROM emp_rooster a INNER JOIN emp_master b ON a.empcode = b.empcode WHERE a.period = '".$period."' AND a.year = '".$year."' AND b.departement = '".$dept_id."' ORDER BY b.position, b.empname");
        return $query->result();
	}
	
	public function insentive($start_date, $end_date, $dept_id)
	{
		$this->db->query("SET @tanggal_awal = '".$start_date."'");
        $this->db->query("SET @tanggal_akhir = '".$end_date."'");
        $this->db->query("SET @butah =  CONCAT(YEAR(@tanggal_awal), '-',MONTH(@tanggal_awal),'-')");
        $this->db->query("SET @period = MONTH(@tanggal_awal) ");
        $this->db->query("SET @year = YEAR(@tanggal_awal) ");
        
		$this->db->query("SET @dept_id = '".$dept_id."'");
		$this->db->query("
		DELETE a FROM
		  gang_activity a 
		  INNER JOIN gang_activity b 
		WHERE a.id_emp_act_sk > b.id_emp_act_sk 
		  AND a.empcode = b.empcode 
		  AND a.attd_date = b.attd_date 
		  AND a.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND b.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir "
		);
		$query = $this->db->query("
		SELECT a.empname, a.nik, a.remarks,b.item, b.d1, b.d2, b.d3, b.d4, b.d5, b.d6, b.d7, b.d8, b.d9, b.d10, b.d11, b.d12, b.d13, b.d14, b.d15, b.d16, b.d17, b.d18, b.d19, b.d20, b.d21, b.d22, b.d23, b.d24, b.d25, b.d26, b.d27, b.d28, b.d29, b.d30, b.d31, b.d32, b.mtd, b.sakit, b.izin, b.alpa, b.cuti, b.4_jam FROM
(SELECT a.empcode, b.position, b.empname, LEFT(b.nik_pim,3) AS nik , a.remarks FROM emp_rooster a INNER JOIN emp_master b ON a.empcode = b.empcode WHERE a.period = @period AND a.year = @year AND b.departement = @dept_id ORDER BY b.position, b.empname) a
RIGHT JOIN 
(
SELECT a.* FROM
(
SELECT a.id, a.empcode, a.period, a.year,'-' AS remarks, '0' AS code_begin, 'ROOSTER' AS item,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, @tanggal_awal)
END AS d1,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '02'))
END AS d2,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '03'))
END AS d3,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '04'))
END AS d4,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '05'))
END AS d5,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '06'))
END AS d6,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '07'))
END AS d7,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '08'))
END AS d8,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '09'))
END AS d9,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '10'))
END AS d10,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '11'))
END AS d11,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '12'))
END AS d12,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '13'))
END AS d13,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '14'))
END AS d14,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '15'))
END AS d15,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '16'))
END AS d16,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '17'))
END AS d17,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '18'))
END AS d18,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '19'))
END AS d19,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '20'))
END AS d20,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '21'))
END AS d21,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '22'))
END AS d22,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '23'))
END AS d23,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '24'))
END AS d24,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '25'))
END AS d25,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '26'))
END AS d26,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '27'))
END AS d27,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '28'))
END AS d28,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '29'))
END AS d29,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '30'))
END AS d30,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '31'))
END AS d31,
CASE 
WHEN 1=1 THEN get_emp_shift(a.empcode, CONCAT(@butah, '32'))
END AS d32, c.hk_dibayar AS mtd, NULL AS sakit, NULL AS izin, NULL AS alpa, NULL AS cuti, NULL AS 4_jam
FROM absensi_rooster a
INNER JOIN (SELECT empcode, departement FROM emp_master WHERE departement = @dept_id) b  ON a.empcode = b.empcode
INNER JOIN (
SELECT a.empcode,
SUM(CASE WHEN b.paid = 0 THEN 1 ELSE 0 END) AS hk_dibayar,
SUM(CASE WHEN a.attd_code = 'attd007' THEN 1 ELSE 0 END) AS sakit,
SUM(CASE WHEN a.attd_code = 'attd004' THEN 1 ELSE 0 END) AS izin,
SUM(CASE WHEN a.attd_code = 'attd005' THEN 1 ELSE 0 END) AS alpa,
SUM(CASE WHEN a.attd_code = 'attd008' THEN 1 ELSE 0 END) AS cuti,
SUM(CASE WHEN a.work_hour > 0 AND a.work_hour < 4 THEN 1 ELSE 0 END) AS 4_jam
FROM gang_activity a INNER JOIN master_attd_code b ON a.attd_code = b.attd_code WHERE a.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND a.is_deleted = 0 AND a.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY a.empcode
) c  ON b.empcode = c.empcode
WHERE a.tanggal BETWEEN @tanggal_awal AND @tanggal_akhir 
-- AND a.empcode = '1800177' 
GROUP BY a.empcode 
UNION ALL
-- wh
SELECT b.id_emp_act_sk, b.empcode, @period, @year, b.remarks, '1' AS code_begin , 'JAM KERJA' AS item,
	get_emp_work_hour(b.empcode, @tanggal_awal) AS d1,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '02')) AS d2,
 	get_emp_work_hour(b.empcode, CONCAT(@butah, '03')) AS d3,
 	get_emp_work_hour(b.empcode, CONCAT(@butah, '04')) AS d4,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '05')) AS d5,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '06')) AS d6,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '07')) AS d7,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '08')) AS d8,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '09')) AS d9,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '10')) AS d10,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '11')) AS d11,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '12')) AS d12,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '13')) AS d13,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '14')) AS d14,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '15')) AS d15,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '16')) AS d16,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '17')) AS d17,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '18')) AS d18,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '19')) AS d19,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '20')) AS d20,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '21')) AS d21,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '22')) AS d22,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '23')) AS d23,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '24')) AS d24,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '25')) AS d25,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '26')) AS d26,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '27')) AS d27,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '28')) AS d28,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '29')) AS d29,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '30')) AS d30,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '31')) AS d31,
	get_emp_work_hour(b.empcode, CONCAT(@butah, '32')) AS d32,
	 c.work_hour, c.sakit, c.izin, c.alpa, c.cuti, c.4_jam
FROM gang_activity b INNER JOIN (
SELECT a.empcode,
SUM(CASE WHEN b.paid = 0 THEN 1 ELSE 0 END) AS hk_dibayar,
SUM(CASE WHEN b.paid = 0 THEN work_hour ELSE 0 END) AS work_hour,
SUM(CASE WHEN a.attd_code = 'attd007' THEN 1 ELSE 0 END) AS sakit,
SUM(CASE WHEN a.attd_code = 'attd004' THEN 1 ELSE 0 END) AS izin,
SUM(CASE WHEN a.attd_code = 'attd005' THEN 1 ELSE 0 END) AS alpa,
SUM(CASE WHEN a.attd_code = 'attd008' THEN 1 ELSE 0 END) AS cuti,
SUM(CASE WHEN a.work_hour > 0 AND a.work_hour < 4 THEN 1 ELSE 0 END) AS 4_jam
FROM gang_activity a INNER JOIN master_attd_code b ON a.attd_code = b.attd_code WHERE a.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND a.is_deleted = 0 AND a.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY a.empcode
) c  ON b.empcode = c.empcode WHERE b.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id)  AND b.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir GROUP BY b.empcode
UNION ALL
-- ot
SELECT b.id_emp_act_sk, b.empcode, @period, @year, b.remarks, '2' AS code_begin, 'LEMBUR' AS item,
	get_emp_overtime(b.empcode, @tanggal_awal) AS d1,
	get_emp_overtime(b.empcode, CONCAT(@butah, '02')) AS d2,
 	get_emp_overtime(b.empcode, CONCAT(@butah, '03')) AS d3,
 	get_emp_overtime(b.empcode, CONCAT(@butah, '04')) AS d4,
	get_emp_overtime(b.empcode, CONCAT(@butah, '05')) AS d5,
	get_emp_overtime(b.empcode, CONCAT(@butah, '06')) AS d6,
	get_emp_overtime(b.empcode, CONCAT(@butah, '07')) AS d7,
	get_emp_overtime(b.empcode, CONCAT(@butah, '08')) AS d8,
	get_emp_overtime(b.empcode, CONCAT(@butah, '09')) AS d9,
	get_emp_overtime(b.empcode, CONCAT(@butah, '10')) AS d10,
	get_emp_overtime(b.empcode, CONCAT(@butah, '11')) AS d11,
	get_emp_overtime(b.empcode, CONCAT(@butah, '12')) AS d12,
	get_emp_overtime(b.empcode, CONCAT(@butah, '13')) AS d13,
	get_emp_overtime(b.empcode, CONCAT(@butah, '14')) AS d14,
	get_emp_overtime(b.empcode, CONCAT(@butah, '15')) AS d15,
	get_emp_overtime(b.empcode, CONCAT(@butah, '16')) AS d16,
	get_emp_overtime(b.empcode, CONCAT(@butah, '17')) AS d17,
	get_emp_overtime(b.empcode, CONCAT(@butah, '18')) AS d18,
	get_emp_overtime(b.empcode, CONCAT(@butah, '19')) AS d19,
	get_emp_overtime(b.empcode, CONCAT(@butah, '20')) AS d20,
	get_emp_overtime(b.empcode, CONCAT(@butah, '21')) AS d21,
	get_emp_overtime(b.empcode, CONCAT(@butah, '22')) AS d22,
	get_emp_overtime(b.empcode, CONCAT(@butah, '23')) AS d23,
	get_emp_overtime(b.empcode, CONCAT(@butah, '24')) AS d24,
	get_emp_overtime(b.empcode, CONCAT(@butah, '25')) AS d25,
	get_emp_overtime(b.empcode, CONCAT(@butah, '26')) AS d26,
	get_emp_overtime(b.empcode, CONCAT(@butah, '27')) AS d27,
	get_emp_overtime(b.empcode, CONCAT(@butah, '28')) AS d28,
	get_emp_overtime(b.empcode, CONCAT(@butah, '29')) AS d29,
	get_emp_overtime(b.empcode, CONCAT(@butah, '30')) AS d30,
	get_emp_overtime(b.empcode, CONCAT(@butah, '31')) AS d31,
	get_emp_overtime(b.empcode, CONCAT(@butah, '32')) AS d32,
	c.mtd_overtime, NULL, NULL, NULL, NULL, NULL
FROM gang_activity b INNER JOIN (
SELECT empcode, SUM(total_jam_lembur) AS mtd_overtime FROM gang_activity WHERE attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND is_deleted = 0 AND empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY empcode
) c ON b.empcode = c.empcode WHERE b.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND b.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY b.empcode 
UNION ALL
-- hm rooster
SELECT b.id_emp_act_sk, b.empcode, @period, @year, b.remarks, '3' AS code_begin, 'HM' AS item,
	get_hm_roster(b.empcode, @tanggal_awal) AS d1,
	get_hm_roster(b.empcode, CONCAT(@butah, '02')) AS d2,
 	get_hm_roster(b.empcode, CONCAT(@butah, '03')) AS d3,
 	get_hm_roster(b.empcode, CONCAT(@butah, '04')) AS d4,
	get_hm_roster(b.empcode, CONCAT(@butah, '05')) AS d5,
	get_hm_roster(b.empcode, CONCAT(@butah, '06')) AS d6,
	get_hm_roster(b.empcode, CONCAT(@butah, '07')) AS d7,
	get_hm_roster(b.empcode, CONCAT(@butah, '08')) AS d8,
	get_hm_roster(b.empcode, CONCAT(@butah, '09')) AS d9,
	get_hm_roster(b.empcode, CONCAT(@butah, '10')) AS d10,
	get_hm_roster(b.empcode, CONCAT(@butah, '11')) AS d11,
	get_hm_roster(b.empcode, CONCAT(@butah, '12')) AS d12,
	get_hm_roster(b.empcode, CONCAT(@butah, '13')) AS d13,
	get_hm_roster(b.empcode, CONCAT(@butah, '14')) AS d14,
	get_hm_roster(b.empcode, CONCAT(@butah, '15')) AS d15,
	get_hm_roster(b.empcode, CONCAT(@butah, '16')) AS d16,
	get_hm_roster(b.empcode, CONCAT(@butah, '17')) AS d17,
	get_hm_roster(b.empcode, CONCAT(@butah, '18')) AS d18,
	get_hm_roster(b.empcode, CONCAT(@butah, '19')) AS d19,
	get_hm_roster(b.empcode, CONCAT(@butah, '20')) AS d20,
	get_hm_roster(b.empcode, CONCAT(@butah, '21')) AS d21,
	get_hm_roster(b.empcode, CONCAT(@butah, '22')) AS d22,
	get_hm_roster(b.empcode, CONCAT(@butah, '23')) AS d23,
	get_hm_roster(b.empcode, CONCAT(@butah, '24')) AS d24,
	get_hm_roster(b.empcode, CONCAT(@butah, '25')) AS d25,
	get_hm_roster(b.empcode, CONCAT(@butah, '26')) AS d26,
	get_hm_roster(b.empcode, CONCAT(@butah, '27')) AS d27,
	get_hm_roster(b.empcode, CONCAT(@butah, '28')) AS d28,
	get_hm_roster(b.empcode, CONCAT(@butah, '29')) AS d29,
	get_hm_roster(b.empcode, CONCAT(@butah, '30')) AS d30,
	get_hm_roster(b.empcode, CONCAT(@butah, '31')) AS d31,
	get_hm_roster(b.empcode, CONCAT(@butah, '32')) AS d32,
	c.mtd_hm, '0', NULL, NULL, NULL, NULL
FROM gang_activity b INNER JOIN (
SELECT operator_code, ROUND(SUM(total_hm),1) AS mtd_hm FROM vehicle_daily_activity WHERE DATE BETWEEN @tanggal_awal AND @tanggal_akhir AND operator_code IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY operator_code
) c ON b.empcode = c.operator_code WHERE b.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir GROUP BY b.empcode
UNION ALL
-- code_unit
SELECT b.id_emp_act_sk, b.empcode, @period, @year, '-' AS remarks, '4' AS code_begin, 'UNIT' AS item,
	get_code_unit_roster(b.empcode, @tanggal_awal) AS d1,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '02')) AS d2,
 	get_code_unit_roster(b.empcode, CONCAT(@butah, '03')) AS d3,
 	get_code_unit_roster(b.empcode, CONCAT(@butah, '04')) AS d4,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '05')) AS d5,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '06')) AS d6,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '07')) AS d7,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '08')) AS d8,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '09')) AS d9,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '10')) AS d10,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '11')) AS d11,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '12')) AS d12,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '13')) AS d13,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '14')) AS d14,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '15')) AS d15,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '16')) AS d16,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '17')) AS d17,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '18')) AS d18,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '19')) AS d19,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '20')) AS d20,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '21')) AS d21,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '22')) AS d22,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '23')) AS d23,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '24')) AS d24,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '25')) AS d25,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '26')) AS d26,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '27')) AS d27,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '28')) AS d28,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '29')) AS d29,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '30')) AS d30,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '31')) AS d31,
	get_code_unit_roster(b.empcode, CONCAT(@butah, '32')) AS d32,
	'0', NULL, NULL, NULL, NULL, NULL
FROM (SELECT id_emp_act_sk, empcode, attd_date FROM gang_activity) b
INNER JOIN (
SELECT operator_code, ROUND(SUM(total_hm),1) AS mtd_hm FROM vehicle_daily_activity WHERE DATE BETWEEN @tanggal_awal AND @tanggal_akhir AND operator_code IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY operator_code
) c ON b.empcode = c.operator_code
WHERE b.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir GROUP BY b.empcode
) a ORDER BY a.empcode, a.code_begin
) b ON a.empcode = b.empcode ORDER BY a.position, b.empcode, b.code_begin
		");
		return $query->result_array();
	}

    public function test_date($start_date, $end_date, $period, $year, $dept_id)
    {
        $this->db->query("SET @tanggal_awal = '".$start_date."'");
        $this->db->query("SET @tanggal_akhir = '".$end_date."'");
        $this->db->query("SET @period = '".$period."'");
        $this->db->query("SET @year = '".$year."'");
        //$this->db->query("SET @butah = CONCAT(@tahun, '-',@bulan,'-''");
        $this->db->query("SET @dept_id = '".$dept_id."'");
        $query = $this->db->query("
        SELECT a.empname, a.nik, a.remarks,b.item, b.a1, b.a2, b.a3, b.a4, b.a5, b.a6, b.a7, b.a8, b.a9, b.a10, b.a11, b.a12, b.a13, b.a14, b.a15, b.a16, b.a17, b.a18, b.a19, b.a20, b.a21, b.a22, b.a23, b.a24, b.a25, b.a26, b.a27, b.a28, b.a29, b.a30, b.a31, b.a32, b.mtd, b.sakit, b.izin, b.alpa, b.cuti, b.4jam FROM
(SELECT a.empcode, b.position, b.empname, LEFT(b.nik_pim,3) AS nik , a.remarks FROM emp_rooster a INNER JOIN emp_master b ON a.empcode = b.empcode WHERE a.period = @period AND a.year = @year AND b.departement = @dept_id ORDER BY b.position, b.empname) a
RIGHT JOIN 
(
SELECT a.* FROM
(SELECT
id_rooster_sk, empcode, period, YEAR, remarks, '0' AS code_begin, 'ROOSTER' AS item,
			CASE
				WHEN a1 = 1 THEN 'P'
				WHEN a1 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a1,
			CASE
				WHEN a2 = 1 THEN 'P'
				WHEN a2 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a2,
			CASE
				WHEN a3 = 1 THEN 'P'
				WHEN a3 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a3,
			CASE
				WHEN a4 = 1 THEN 'P'
				WHEN a4 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a4,
			CASE
				WHEN a5 = 1 THEN 'P'
				WHEN a5 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a5,
			CASE
				WHEN a6 = 1 THEN 'P'
				WHEN a6 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a6,
			CASE
				WHEN a7 = 1 THEN 'P'
				WHEN a7 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a7,
			CASE
				WHEN a8 = 1 THEN 'P'
				WHEN a8 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a8,
			CASE
				WHEN a9 = 1 THEN 'P'
				WHEN a9 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a9,
			CASE
				WHEN a10 = 1 THEN 'P'
				WHEN a10 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a10,
			CASE
				WHEN a11 = 1 THEN 'P'
				WHEN a11 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a11,
			CASE
				WHEN a12 = 1 THEN 'P'
				WHEN a12 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a12,
			CASE
				WHEN a13 = 1 THEN 'P'
				WHEN a13 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a13,
			CASE
				WHEN a14 = 1 THEN 'P'
				WHEN a14 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a14,
			CASE
				WHEN a15 = 1 THEN 'P'
				WHEN a15 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a15,
			CASE
				WHEN a16 = 1 THEN 'P'
				WHEN a16 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a16,
			CASE
				WHEN a17 = 1 THEN 'P'
				WHEN a17 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a17,
			CASE
				WHEN a18 = 1 THEN 'P'
				WHEN a18 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a18,
			CASE
				WHEN a19 = 1 THEN 'P'
				WHEN a19 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a19,
			CASE
				WHEN a20 = 1 THEN 'P'
				WHEN a20 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a20,
			CASE
				WHEN a21 = 1 THEN 'P'
				WHEN a21 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a21,
			CASE
				WHEN a22 = 1 THEN 'P'
				WHEN a22 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a22,
			CASE
				WHEN a23 = 1 THEN 'P'
				WHEN a23 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a23,
			CASE
				WHEN a24 = 1 THEN 'P'
				WHEN a24 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a24,
			CASE
				WHEN a25 = 1 THEN 'P'
				WHEN a25 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a25,
			CASE
				WHEN a26 = 1 THEN 'P'
				WHEN a26 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a26,
			CASE
				WHEN a27 = 1 THEN 'P'
				WHEN a27 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a27,
			CASE
				WHEN a28 = 1 THEN 'P'
				WHEN a28 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a28,
			CASE
				WHEN a29 = 1 THEN 'P'
				WHEN a29 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a29,
			CASE
				WHEN a30 = 1 THEN 'P'
				WHEN a30 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a30,
			CASE
				WHEN a31 = 1 THEN 'P'
				WHEN a31 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a31,
			CASE
				WHEN a32 = 1 THEN 'P'
				WHEN a32 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a32, NULL AS mtd, NULL AS sakit, NULL AS izin, NULL AS alpa, NULL AS cuti, NULL AS 4jam
FROM emp_rooster WHERE period = @period AND YEAR = @year AND empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) 
UNION ALL
-- wh
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, '1', 'JAM KERJA' AS item,
	get_emp_work_hour(b.empcode, a.d1) AS d1,
	get_emp_work_hour(b.empcode, a.d2) AS d2,
 	get_emp_work_hour(b.empcode, a.d3) AS d3,
 	get_emp_work_hour(b.empcode, a.d4) AS d4,
	get_emp_work_hour(b.empcode, a.d5) AS d5,
	get_emp_work_hour(b.empcode, a.d6) AS d6,
	get_emp_work_hour(b.empcode, a.d7) AS d7,
	get_emp_work_hour(b.empcode, a.d8) AS d8,
	get_emp_work_hour(b.empcode, a.d9) AS d9,
	get_emp_work_hour(b.empcode, a.d10) AS d10,
	get_emp_work_hour(b.empcode, a.d11) AS d11,
	get_emp_work_hour(b.empcode, a.d12) AS d12,
	get_emp_work_hour(b.empcode, a.d13) AS d13,
	get_emp_work_hour(b.empcode, a.d14) AS d14,
	get_emp_work_hour(b.empcode, a.d15) AS d15,
	get_emp_work_hour(b.empcode, a.d16) AS d16,
	get_emp_work_hour(b.empcode, a.d17) AS d17,
	get_emp_work_hour(b.empcode, a.d18) AS d18,
	get_emp_work_hour(b.empcode, a.d19) AS d19,
	get_emp_work_hour(b.empcode, a.d20) AS d20,
	get_emp_work_hour(b.empcode, a.d21) AS d21,
	get_emp_work_hour(b.empcode, a.d22) AS d22,
	get_emp_work_hour(b.empcode, a.d23) AS d23,
	get_emp_work_hour(b.empcode, a.d24) AS d24,
	get_emp_work_hour(b.empcode, a.d25) AS d25,
	get_emp_work_hour(b.empcode, a.d26) AS d26,
	get_emp_work_hour(b.empcode, a.d27) AS d27,
	get_emp_work_hour(b.empcode, a.d28) AS d28,
	get_emp_work_hour(b.empcode, a.d29) AS d29,
	get_emp_work_hour(b.empcode, a.d30) AS d30,
	get_emp_work_hour(b.empcode, a.d31) AS d31,
	'0' AS d32, c.hk_dibayar, c.sakit, c.izin, c.alpa, c.cuti, c.4_jam
FROM period_control a, gang_activity b INNER JOIN (
SELECT a.empcode,
SUM(CASE WHEN b.paid = 0 THEN 1 ELSE 0 END) AS hk_dibayar,
SUM(CASE WHEN a.attd_code = 'attd007' THEN 1 ELSE 0 END) AS sakit,
SUM(CASE WHEN a.attd_code = 'attd004' THEN 1 ELSE 0 END) AS izin,
SUM(CASE WHEN a.attd_code = 'attd005' THEN 1 ELSE 0 END) AS alpa,
SUM(CASE WHEN a.attd_code = 'attd008' THEN 1 ELSE 0 END) AS cuti,
SUM(CASE WHEN a.work_hour > 0 AND a.work_hour < 4 THEN 1 ELSE 0 END) AS 4_jam
FROM gang_activity a INNER JOIN master_attd_code b ON a.attd_code = b.attd_code WHERE a.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND a.is_deleted = 0 AND a.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY a.empcode
) c  ON b.empcode = c.empcode WHERE b.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) AND a.period = @period AND a.tahun = @year AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY b.empcode
UNION ALL
-- ot
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, '2', 'LEMBUR' AS item,
	get_emp_overtime(b.empcode, a.d1) AS d1,
	get_emp_overtime(b.empcode, a.d2) AS d2,
	get_emp_overtime(b.empcode, a.d3) AS d3,
	get_emp_overtime(b.empcode, a.d4) AS d4,
	get_emp_overtime(b.empcode, a.d5) AS d5,
	get_emp_overtime(b.empcode, a.d6) AS d6,
	get_emp_overtime(b.empcode, a.d7) AS d7,
	get_emp_overtime(b.empcode, a.d8) AS d8,
	get_emp_overtime(b.empcode, a.d9) AS d9,
	get_emp_overtime(b.empcode, a.d10) AS d10,
	get_emp_overtime(b.empcode, a.d11) AS d11,
	get_emp_overtime(b.empcode, a.d12) AS d12,
	get_emp_overtime(b.empcode, a.d13) AS d13,
	get_emp_overtime(b.empcode, a.d14) AS d14,
	get_emp_overtime(b.empcode, a.d15) AS d15,
	get_emp_overtime(b.empcode, a.d16) AS d16,
	get_emp_overtime(b.empcode, a.d17) AS d17,
	get_emp_overtime(b.empcode, a.d18) AS d18,
	get_emp_overtime(b.empcode, a.d19) AS d19,
	get_emp_overtime(b.empcode, a.d20) AS d20,
	get_emp_overtime(b.empcode, a.d21) AS d21,
	get_emp_overtime(b.empcode, a.d22) AS d22,
	get_emp_overtime(b.empcode, a.d23) AS d23,
	get_emp_overtime(b.empcode, a.d24) AS d24,
	get_emp_overtime(b.empcode, a.d25) AS d25,
	get_emp_overtime(b.empcode, a.d26) AS d26,
	get_emp_overtime(b.empcode, a.d27) AS d27,
	get_emp_overtime(b.empcode, a.d28) AS d28,
	get_emp_overtime(b.empcode, a.d29) AS d29,
	get_emp_overtime(b.empcode, a.d30) AS d30,
	get_emp_overtime(b.empcode, a.d31) AS d31,
	'0' AS d32, c.mtd_overtime, NULL, NULL, NULL, NULL, NULL
FROM period_control a, gang_activity b INNER JOIN (
SELECT empcode, SUM(total_jam_lembur) AS mtd_overtime FROM gang_activity WHERE attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND is_deleted = 0 AND empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY empcode
) c ON b.empcode = c.empcode WHERE a.period = @period AND a.tahun = @year AND b.attd_date BETWEEN a.start_date AND a.end_date AND b.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY b.empcode 
UNION ALL
-- hm
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, '3', 'HM' AS item,
	get_hm_roster(b.empcode, a.d1) AS d1,
	get_hm_roster(b.empcode, a.d2) AS d2,
	get_hm_roster(b.empcode, a.d3) AS d3,
	get_hm_roster(b.empcode, a.d4) AS d4,
	get_hm_roster(b.empcode, a.d5) AS d5,
	get_hm_roster(b.empcode, a.d6) AS d6,
	get_hm_roster(b.empcode, a.d7) AS d7,
	get_hm_roster(b.empcode, a.d8) AS d8,
	get_hm_roster(b.empcode, a.d9) AS d9,
	get_hm_roster(b.empcode, a.d10) AS d10,
	get_hm_roster(b.empcode, a.d11) AS d11,
	get_hm_roster(b.empcode, a.d12) AS d12,
	get_hm_roster(b.empcode, a.d13) AS d13,
	get_hm_roster(b.empcode, a.d14) AS d14,
	get_hm_roster(b.empcode, a.d15) AS d15,
	get_hm_roster(b.empcode, a.d16) AS d16,
	get_hm_roster(b.empcode, a.d17) AS d17,
	get_hm_roster(b.empcode, a.d18) AS d18,
	get_hm_roster(b.empcode, a.d19) AS d19,
	get_hm_roster(b.empcode, a.d20) AS d20,
	get_hm_roster(b.empcode, a.d21) AS d21,
	get_hm_roster(b.empcode, a.d22) AS d22,
	get_hm_roster(b.empcode, a.d23) AS d23,
	get_hm_roster(b.empcode, a.d24) AS d24,
	get_hm_roster(b.empcode, a.d25) AS d25,
	get_hm_roster(b.empcode, a.d26) AS d26,
	get_hm_roster(b.empcode, a.d27) AS d27,
	get_hm_roster(b.empcode, a.d28) AS d28,
	get_hm_roster(b.empcode, a.d29) AS d29,
	get_hm_roster(b.empcode, a.d30) AS d30,
	get_hm_roster(b.empcode, a.d31) AS d31,
	'0' AS d32, c.mtd_hm, '0', NULL, NULL, NULL, NULL
FROM period_control a, gang_activity b INNER JOIN (
SELECT operator_code, ROUND(SUM(total_hm),1) AS mtd_hm FROM vehicle_daily_activity WHERE DATE BETWEEN @tanggal_awal AND @tanggal_akhir AND operator_code IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY operator_code
) c ON b.empcode = c.operator_code WHERE a.period = @period AND a.tahun = @year AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY b.empcode
UNION ALL
-- unit
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, '4', 'UNIT' AS item,
	get_code_unit_roster(b.empcode, a.d1) AS d1,
	get_code_unit_roster(b.empcode, a.d2) AS d2,
	get_code_unit_roster(b.empcode, a.d3) AS d3,
	get_code_unit_roster(b.empcode, a.d4) AS d4,
	get_code_unit_roster(b.empcode, a.d5) AS d5,
	get_code_unit_roster(b.empcode, a.d6) AS d6,
	get_code_unit_roster(b.empcode, a.d7) AS d7,
	get_code_unit_roster(b.empcode, a.d8) AS d8,
	get_code_unit_roster(b.empcode, a.d9) AS d9,
	get_code_unit_roster(b.empcode, a.d10) AS d10,
	get_code_unit_roster(b.empcode, a.d11) AS d11,
	get_code_unit_roster(b.empcode, a.d12) AS d12,
	get_code_unit_roster(b.empcode, a.d13) AS d13,
	get_code_unit_roster(b.empcode, a.d14) AS d14,
	get_code_unit_roster(b.empcode, a.d15) AS d15,
	get_code_unit_roster(b.empcode, a.d16) AS d16,
	get_code_unit_roster(b.empcode, a.d17) AS d17,
	get_code_unit_roster(b.empcode, a.d18) AS d18,
	get_code_unit_roster(b.empcode, a.d19) AS d19,
	get_code_unit_roster(b.empcode, a.d20) AS d20,
	get_code_unit_roster(b.empcode, a.d21) AS d21,
	get_code_unit_roster(b.empcode, a.d22) AS d22,
	get_code_unit_roster(b.empcode, a.d23) AS d23,
	get_code_unit_roster(b.empcode, a.d24) AS d24,
	get_code_unit_roster(b.empcode, a.d25) AS d25,
	get_code_unit_roster(b.empcode, a.d26) AS d26,
	get_code_unit_roster(b.empcode, a.d27) AS d27,
	get_code_unit_roster(b.empcode, a.d28) AS d28,
	get_code_unit_roster(b.empcode, a.d29) AS d29,
	get_code_unit_roster(b.empcode, a.d30) AS d30,
	get_code_unit_roster(b.empcode, a.d31) AS d31,
	'0' AS d32, '0', NULL, NULL, NULL, NULL, NULL
FROM period_control a, (SELECT empcode, attd_date FROM gang_activity) b WHERE a.period = @period AND a.tahun = @year AND b.attd_date BETWEEN a.start_date AND a.end_date AND b.empcode IN (SELECT empcode FROM emp_master WHERE departement = @dept_id) GROUP BY b.empcode
) a ORDER BY a.empcode, a.code_begin
) b ON a.empcode = b.empcode ORDER BY a.position, b.empcode, b.code_begin
        ");
        return $query->result_array();
    }

    public function get_data_montly_absensi($start_date, $end_date, $period, $year, $empcode)
    {
        $this->db->query("SET @tanggal_awal = '".$start_date."'");
        $this->db->query("SET @tanggal_akhir = '".$end_date."'");
        $this->db->query("SET @period = '".$period."'");
        $this->db->query("SET @year = '".$year."'");
        //$this->db->query("SET @butah = CONCAT(@tahun, '-',@bulan,'-''");
        $this->db->query("SET @empcode = '".$empcode."'");
        $query = $this->db->query("
select
id_rooster_sk, empcode, period, YEAR, remarks, code_begin,
			CASE
				WHEN a1 = 1 THEN 'P'
				WHEN a1 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a1,
			CASE
				WHEN a2 = 1 THEN 'P'
				WHEN a2 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a2,
			CASE
				WHEN a3 = 1 THEN 'P'
				WHEN a3 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a3,
			CASE
				WHEN a4 = 1 THEN 'P'
				WHEN a4 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a4,
			CASE
				WHEN a5 = 1 THEN 'P'
				WHEN a5 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a5,
			CASE
				WHEN a6 = 1 THEN 'P'
				WHEN a6 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a6,
			CASE
				WHEN a7 = 1 THEN 'P'
				WHEN a7 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a7,
			CASE
				WHEN a8 = 1 THEN 'P'
				WHEN a8 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a8,
			CASE
				WHEN a9 = 1 THEN 'P'
				WHEN a9 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a9,
			CASE
				WHEN a10 = 1 THEN 'P'
				WHEN a10 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a10,
			CASE
				WHEN a11 = 1 THEN 'P'
				WHEN a11 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a11,
			CASE
				WHEN a12 = 1 THEN 'P'
				WHEN a12 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a12,
			CASE
				WHEN a13 = 1 THEN 'P'
				WHEN a13 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a13,
			CASE
				WHEN a14 = 1 THEN 'P'
				WHEN a14 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a14,
			CASE
				WHEN a15 = 1 THEN 'P'
				WHEN a15 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a15,
			CASE
				WHEN a16 = 1 THEN 'P'
				WHEN a16 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a16,
			CASE
				WHEN a17 = 1 THEN 'P'
				WHEN a17 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a17,
			CASE
				WHEN a18 = 1 THEN 'P'
				WHEN a18 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a18,
			CASE
				WHEN a19 = 1 THEN 'P'
				WHEN a19 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a19,
			CASE
				WHEN a20 = 1 THEN 'P'
				WHEN a20 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a10,
			CASE
				WHEN a21 = 1 THEN 'P'
				WHEN a21 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a21,
			CASE
				WHEN a22 = 1 THEN 'P'
				WHEN a22 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a22,
			CASE
				WHEN a23 = 1 THEN 'P'
				WHEN a23 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a23,
			CASE
				WHEN a24 = 1 THEN 'P'
				WHEN a24 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a24,
			CASE
				WHEN a25 = 1 THEN 'P'
				WHEN a25 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a25,
			CASE
				WHEN a26 = 1 THEN 'P'
				WHEN a26 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a26,
			CASE
				WHEN a27 = 1 THEN 'P'
				WHEN a27 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a27,
			CASE
				WHEN a28 = 1 THEN 'P'
				WHEN a28 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a28,
			CASE
				WHEN a29 = 1 THEN 'P'
				WHEN a29 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a29,
			CASE
				WHEN a30 = 1 THEN 'P'
				WHEN a30 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a30,
			CASE
				WHEN a31 = 1 THEN 'P'
				WHEN a31 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a31,
			CASE
				WHEN a32 = 1 THEN 'P'
				WHEN a32 = 2 THEN 'M'
				ELSE 'OFF'
			END AS a32, NULL AS mtd, NULL AS sakit, NULL AS izin, NULL AS alpa, NULL AS cuti, NULL AS 4jam
FROM emp_rooster WHERE empcode = @empcode AND period = @period AND YEAR = @year

-- data tanggal di dapat dari period control, keep period control update until 2020

-- untuk work hour
UNION ALL
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, 'N/A', 
	get_emp_work_hour(b.empcode, a.d1) AS d1,
	get_emp_work_hour(b.empcode, a.d2) AS d2,
	get_emp_work_hour(b.empcode, a.d3) AS d3,
	get_emp_work_hour(b.empcode, a.d4) AS d4,
	get_emp_work_hour(b.empcode, a.d5) AS d5,
	get_emp_work_hour(b.empcode, a.d6) AS d6,
	get_emp_work_hour(b.empcode, a.d7) AS d7,
	get_emp_work_hour(b.empcode, a.d8) AS d8,
	get_emp_work_hour(b.empcode, a.d9) AS d9,
	get_emp_work_hour(b.empcode, a.d10) AS d10,
	get_emp_work_hour(b.empcode, a.d11) AS d11,
	get_emp_work_hour(b.empcode, a.d12) AS d12,
	get_emp_work_hour(b.empcode, a.d13) AS d13,
	get_emp_work_hour(b.empcode, a.d14) AS d14,
	get_emp_work_hour(b.empcode, a.d15) AS d15,
	get_emp_work_hour(b.empcode, a.d16) AS d16,
	get_emp_work_hour(b.empcode, a.d17) AS d17,
	get_emp_work_hour(b.empcode, a.d18) AS d18,
	get_emp_work_hour(b.empcode, a.d19) AS d19,
	get_emp_work_hour(b.empcode, a.d20) AS d20,
	get_emp_work_hour(b.empcode, a.d21) AS d21,
	get_emp_work_hour(b.empcode, a.d22) AS d22,
	get_emp_work_hour(b.empcode, a.d23) AS d23,
	get_emp_work_hour(b.empcode, a.d24) AS d24,
	get_emp_work_hour(b.empcode, a.d25) AS d25,
	get_emp_work_hour(b.empcode, a.d26) AS d26,
	get_emp_work_hour(b.empcode, a.d27) AS d27,
	get_emp_work_hour(b.empcode, a.d28) AS d28,
	get_emp_work_hour(b.empcode, a.d29) AS d29,
	get_emp_work_hour(b.empcode, a.d30) AS d30,
	get_emp_work_hour(b.empcode, a.d31) AS d31,
	'0' AS d32, c.hk_dibayar, c.sakit, c.izin, c.alpa, c.cuti, c.4_jam
FROM period_control a, gang_activity b, (
SELECT 
SUM(CASE WHEN b.paid = 0 THEN 1 ELSE 0 END) AS hk_dibayar,
SUM(CASE WHEN a.attd_code = 'attd007' THEN 1 ELSE 0 END) AS sakit,
SUM(CASE WHEN a.attd_code = 'attd004' THEN 1 ELSE 0 END) AS izin,
SUM(CASE WHEN a.attd_code = 'attd005' THEN 1 ELSE 0 END) AS alpa,
SUM(CASE WHEN a.attd_code = 'attd008' THEN 1 ELSE 0 END) AS cuti,
SUM(CASE WHEN a.work_hour > 0 AND a.work_hour < 4 THEN 1 ELSE 0 END) AS 4_jam
FROM gang_activity a INNER JOIN master_attd_code b ON a.attd_code = b.attd_code WHERE a.empcode = @empcode AND a.attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND a.is_deleted = 0
) c WHERE a.period = @period AND a.tahun = @year AND b.empcode = @empcode AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY a.period

-- untuk overtime
UNION ALL
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, 'N/A', 
	get_emp_overtime(b.empcode, a.d1) AS d1,
	get_emp_overtime(b.empcode, a.d2) AS d2,
	get_emp_overtime(b.empcode, a.d3) AS d3,
	get_emp_overtime(b.empcode, a.d4) AS d4,
	get_emp_overtime(b.empcode, a.d5) AS d5,
	get_emp_overtime(b.empcode, a.d6) AS d6,
	get_emp_overtime(b.empcode, a.d7) AS d7,
	get_emp_overtime(b.empcode, a.d8) AS d8,
	get_emp_overtime(b.empcode, a.d9) AS d9,
	get_emp_overtime(b.empcode, a.d10) AS d10,
	get_emp_overtime(b.empcode, a.d11) AS d11,
	get_emp_overtime(b.empcode, a.d12) AS d12,
	get_emp_overtime(b.empcode, a.d13) AS d13,
	get_emp_overtime(b.empcode, a.d14) AS d14,
	get_emp_overtime(b.empcode, a.d15) AS d15,
	get_emp_overtime(b.empcode, a.d16) AS d16,
	get_emp_overtime(b.empcode, a.d17) AS d17,
	get_emp_overtime(b.empcode, a.d18) AS d18,
	get_emp_overtime(b.empcode, a.d19) AS d19,
	get_emp_overtime(b.empcode, a.d20) AS d20,
	get_emp_overtime(b.empcode, a.d21) AS d21,
	get_emp_overtime(b.empcode, a.d22) AS d22,
	get_emp_overtime(b.empcode, a.d23) AS d23,
	get_emp_overtime(b.empcode, a.d24) AS d24,
	get_emp_overtime(b.empcode, a.d25) AS d25,
	get_emp_overtime(b.empcode, a.d26) AS d26,
	get_emp_overtime(b.empcode, a.d27) AS d27,
	get_emp_overtime(b.empcode, a.d28) AS d28,
	get_emp_overtime(b.empcode, a.d29) AS d29,
	get_emp_overtime(b.empcode, a.d30) AS d30,
	get_emp_overtime(b.empcode, a.d31) AS d31,
	'0' AS d32, c.mtd_overtime, NULL, NULL, NULL, NULL, NULL
FROM period_control a, gang_activity b, (
SELECT SUM(total_jam_lembur) AS mtd_overtime FROM gang_activity WHERE empcode = @empcode AND attd_date BETWEEN @tanggal_awal AND @tanggal_akhir AND is_deleted = 0
) c WHERE a.period = @period AND a.tahun = @year AND b.empcode = @empcode AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY a.period

-- untuk hm
UNION ALL
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, 'N/A', 
	get_hm_roster(b.empcode, a.d1) AS d1,
	get_hm_roster(b.empcode, a.d2) AS d2,
	get_hm_roster(b.empcode, a.d3) AS d3,
	get_hm_roster(b.empcode, a.d4) AS d4,
	get_hm_roster(b.empcode, a.d5) AS d5,
	get_hm_roster(b.empcode, a.d6) AS d6,
	get_hm_roster(b.empcode, a.d7) AS d7,
	get_hm_roster(b.empcode, a.d8) AS d8,
	get_hm_roster(b.empcode, a.d9) AS d9,
	get_hm_roster(b.empcode, a.d10) AS d10,
	get_hm_roster(b.empcode, a.d11) AS d11,
	get_hm_roster(b.empcode, a.d12) AS d12,
	get_hm_roster(b.empcode, a.d13) AS d13,
	get_hm_roster(b.empcode, a.d14) AS d14,
	get_hm_roster(b.empcode, a.d15) AS d15,
	get_hm_roster(b.empcode, a.d16) AS d16,
	get_hm_roster(b.empcode, a.d17) AS d17,
	get_hm_roster(b.empcode, a.d18) AS d18,
	get_hm_roster(b.empcode, a.d19) AS d19,
	get_hm_roster(b.empcode, a.d20) AS d20,
	get_hm_roster(b.empcode, a.d21) AS d21,
	get_hm_roster(b.empcode, a.d22) AS d22,
	get_hm_roster(b.empcode, a.d23) AS d23,
	get_hm_roster(b.empcode, a.d24) AS d24,
	get_hm_roster(b.empcode, a.d25) AS d25,
	get_hm_roster(b.empcode, a.d26) AS d26,
	get_hm_roster(b.empcode, a.d27) AS d27,
	get_hm_roster(b.empcode, a.d28) AS d28,
	get_hm_roster(b.empcode, a.d29) AS d29,
	get_hm_roster(b.empcode, a.d30) AS d30,
	get_hm_roster(b.empcode, a.d31) AS d31,
	'0' AS d32, c.mtd_hm, NULL, NULL, NULL, NULL, NULL
FROM period_control a, gang_activity b, (
SELECT SUM(total_hm) AS mtd_hm FROM vehicle_daily_activity WHERE DATE BETWEEN @tanggal_awal AND @tanggal_akhir AND operator_code = @empcode
) c WHERE a.period = @period AND a.tahun = @year AND b.empcode = @empcode AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY a.period

-- untuk code unit
UNION ALL
SELECT a.id, b.empcode, a.period, a.tahun, a.remarks, 'N/A', 
	get_code_unit_roster(b.empcode, a.d1) AS d1,
	get_code_unit_roster(b.empcode, a.d2) AS d2,
	get_code_unit_roster(b.empcode, a.d3) AS d3,
	get_code_unit_roster(b.empcode, a.d4) AS d4,
	get_code_unit_roster(b.empcode, a.d5) AS d5,
	get_code_unit_roster(b.empcode, a.d6) AS d6,
	get_code_unit_roster(b.empcode, a.d7) AS d7,
	get_code_unit_roster(b.empcode, a.d8) AS d8,
	get_code_unit_roster(b.empcode, a.d9) AS d9,
	get_code_unit_roster(b.empcode, a.d10) AS d10,
	get_code_unit_roster(b.empcode, a.d11) AS d11,
	get_code_unit_roster(b.empcode, a.d12) AS d12,
	get_code_unit_roster(b.empcode, a.d13) AS d13,
	get_code_unit_roster(b.empcode, a.d14) AS d14,
	get_code_unit_roster(b.empcode, a.d15) AS d15,
	get_code_unit_roster(b.empcode, a.d16) AS d16,
	get_code_unit_roster(b.empcode, a.d17) AS d17,
	get_code_unit_roster(b.empcode, a.d18) AS d18,
	get_code_unit_roster(b.empcode, a.d19) AS d19,
	get_code_unit_roster(b.empcode, a.d20) AS d20,
	get_code_unit_roster(b.empcode, a.d21) AS d21,
	get_code_unit_roster(b.empcode, a.d22) AS d22,
	get_code_unit_roster(b.empcode, a.d23) AS d23,
	get_code_unit_roster(b.empcode, a.d24) AS d24,
	get_code_unit_roster(b.empcode, a.d25) AS d25,
	get_code_unit_roster(b.empcode, a.d26) AS d26,
	get_code_unit_roster(b.empcode, a.d27) AS d27,
	get_code_unit_roster(b.empcode, a.d28) AS d28,
	get_code_unit_roster(b.empcode, a.d29) AS d29,
	get_code_unit_roster(b.empcode, a.d30) AS d30,
	get_code_unit_roster(b.empcode, a.d31) AS d31,
	'0' AS d32, NULL, NULL, NULL, NULL, NULL, NULL
FROM period_control a, gang_activity b WHERE a.period = @period AND a.tahun = @year AND b.empcode = @empcode AND b.attd_date BETWEEN a.start_date AND a.end_date GROUP BY a.period

        ");
        return $query->result_array();
    }
 
}
 
/* End of file Absen_model.php */
/* Location: ./application/models/Absen_model.php */