<?php
defined('BASEPATH') OR exit('No direct script access allowed');




/**
* 
*/
class Emp_att_model extends CI_Model
{
	/*inisialisasi variable*/
var $table = 'presensi';
var $column_order = array('nik_pim','empcode','tanggal','shift', 'check_in', 'check_out', 'late','overtime','work_hour','attd_code');
var $column_search = array('nik_pim','empname','tanggal','shift', 'check_in', 'check_out', 'late','overtime','work_hour','attd_code');
var $order = array('check_in' => 'desc');
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function _get_datatables_query()
	{
		/*
		SELECT 
  a.empcode, b.nik_pim, b.empname, b.departement, d.dept_desc, b.position, c.position_desc, a.date, a.overtime, a.remarks, a.inputby, a.inputdate
  FROM
  spl a INNER JOIN emp_master b
  ON a.empcode = b.empcode
  LEFT JOIN master_position c
  ON b.position = c.id_position
  LEFT JOIN master_dept d
  ON b.departement = d.departement
		*/
 		if($this->input->post('f_empcode_f'))
            {
                $this->db->where('empcode', $this->input->post('f_empcode_f'));
            }
            if ($this->input->post('f_dept')) {
                $this->db->where(" dept_id = '".$this->input->post('f_dept')."'");
                
            }
            if ($this->input->post('f_hadir') == "1" ) {
                $this->db->where('check_in is null');
            }
            if ($this->input->post('f_hadir') == "2" ) {
                $this->db->where('check_in is not null');
            }
            if ($this->input->post('f_late') == "1" ) {
                $this->db->where('late is not null');
            }
            if ($this->input->post('f_late') == "2" ) {
                $this->db->where('late is null');
            }
            if ($this->input->post('f_shift') == "1" ) {
              $this->db->where('shift = "SHIFT I"  ');
            }
            if ($this->input->post('f_shift') == "2" ) {
              $this->db->where('shift ="SHIFT II"  ');
            }
            if ($this->input->post('f_shift') == "3" ) {
              $this->db->where('shift = "OFF DAY"  ');
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where("tanggal between '".$this->input->post("filter_start")."' and '".$this->input->post("filter_end")."'  ");
        }
        /* SET @tanggal_awal = "2018-12-21";
SET @tanggal_akhir = "2019-01-25";
SET @jam_awal_pagi = "07:00:00";
SET @jam_awal_malam = "19:00:00";
SET @dept_id = "7"; */


/* $this->db->query("SET @jam_awal_pagi = '07:00:00';");
$this->db->query("SET @jam_awal_malam = '19:00:00';");

$this->db->select("b.id_absensi,
  a.empcode,
  a.departement,
  a.nik_pim AS nik_pim,
  a.nama AS empname,
  a.tgl AS tanggal,
  a.jam_kerja,
  b.masuk,
  b.keluar_shift_malam,
  b.telat,
  CASE 
WHEN a.jam_kerja = 'OFF DAY' THEN 0.0
WHEN b.id_absensi = c.id_absensi AND a.jam_kerja = 'SHIFT I' AND b.masuk IS NOT NULL THEN
		CASE
			WHEN b.telat IS NULL THEN 5.5
			WHEN b.telat < '00:10:00' THEN 5.5
			WHEN b.telat > '00:10:00' THEN 4.5
			WHEN b.telat > '00:40:00' THEN 3.5 
		END
WHEN b.id_absensi = c.id_absensi AND a.jam_kerja = 'SHIFT II' AND b.masuk IS NOT NULL THEN
		CASE
			WHEN b.telat IS NULL THEN 9.5
			WHEN b.telat < '00:10:00' THEN 9.5
			WHEN b.telat > '00:10:00' THEN 8.5
			WHEN b.telat > '00:40:00' THEN 7.5
			
		END
WHEN a.jam_kerja = 'SHIFT II' AND b.masuk IS NOT NULL THEN 
		CASE
			WHEN b.telat IS NULL THEN 5.5
			WHEN b.telat < '00:10:00' THEN 5.5
			WHEN b.telat > '00:10:00' THEN 4.5
			WHEN b.telat > '00:40:00' THEN 3.5 
			
		END
WHEN a.jam_kerja = 'SHIFT I' AND b.masuk IS NOT NULL OR b.keluar_shift_malam IS NOT NULL THEN
		CASE
			WHEN b.telat IS NULL THEN 3.5
			WHEN b.telat < '00:10:00' THEN 3.5
			WHEN b.telat > '00:10:00' THEN 2.5
			WHEN b.telat > '00:40:00' THEN 1.5 
			
		END

ELSE 0.0
END AS overtime,
CASE
	WHEN a.jam_kerja = 'SHIFT I' AND b.masuk IS NOT NULL  THEN '9.0'
	WHEN a.jam_kerja = 'SHIFT II' AND b.masuk IS NOT NULL  THEN '10.0'
	ELSE '0.0'
END AS work_hour,
CASE 
	WHEN a.jam_kerja = 'OFF DAY' THEN 'attd006'
	WHEN b.id_absensi = c.id_absensi AND a.jam_kerja = 'SHIFT I' AND b.masuk IS NOT NULL THEN 'attd002'
	WHEN b.id_absensi = c.id_absensi AND a.jam_kerja = 'SHIFT II' AND b.masuk IS NOT NULL THEN 'attd002'
	WHEN a.jam_kerja = 'SHIFT I' AND b.masuk IS NOT NULL THEN 'attd001'
	WHEN a.jam_kerja = 'SHIFT II' AND b.masuk IS NOT NULL THEN 'attd001'
END AS attd_code");
        $this->db->from("(select
        a.empcode,
        b.nik_pim,
        get_empname (a.empcode) nama,
        a.tanggal AS tgl,
        CASE
          WHEN a.shift = 1 
          THEN 'SHIFT I' 
          WHEN a.shift = 2 
          THEN 'SHIFT II' 
          ELSE 'OFF DAY' 
        END AS jam_kerja,
        b.badgenumber,
        b.departement
      FROM
        (SELECT empcode, tanggal, shift FROM absensi_rooster WHERE tanggal BETWEEN @tanggal_awal AND @tanggal_akhir ) a 
        INNER JOIN (SELECT empcode, nik_pim, badgenumber, departement FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement = @dept_id ) b 
          ON a.empcode = b.empcode ) a");
        $this->db->join("(select b.id_absensi,
        a.empcode,
        b.tanggal AS tgl_b,
        CASE
          WHEN b.shift = 2 
          THEN shift_dua_in_x601(a.pin, DATE(a.date_time))
          WHEN b.shift = 1
          THEN shift_satu_in_x601(a.pin, DATE(a.date_time))
          ELSE '-' 
        END AS masuk,
        CASE
          WHEN b.shift = 2 
          THEN shift_dua_out_x601 (a.pin, DATE(a.date_time)) 
          WHEN b.shift = 1
          THEN shift_satu_out_x601(a.pin, DATE(a.date_time))
          ELSE '-' 
        END AS keluar_shift_malam,
        CASE
          WHEN b.shift = 1 AND DATE_FORMAT(shift_satu_in_x601(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_pagi THEN TIMEDIFF(DATE_FORMAT(shift_satu_in_x601(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_pagi ) 
          WHEN b.shift = 2 AND DATE_FORMAT(shift_dua_in_x601(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_malam THEN TIMEDIFF(DATE_FORMAT(shift_dua_in_x601(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_malam) 
        END AS telat 
      FROM
        (SELECT 
          a.pin,
          b.empcode,
          a.date_time,
          DATE(a.date_time) AS tanggal
        FROM
          (SELECT pin, date_time FROM absen_finger_x601 WHERE pin IN (SELECT badgenumber FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement = @dept_id) ) a 
          LEFT JOIN (SELECT empcode, badgenumber FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement = @dept_id) b 
            ON a.pin = b.badgenumber) a 
        RIGHT JOIN (SELECT id_absensi, empcode, tanggal, shift FROM absensi_rooster WHERE tanggal BETWEEN @tanggal_awal AND @tanggal_akhir ) b 
          ON a.empcode = b.empcode 
      WHERE DATE(a.date_time) BETWEEN @tanggal_awal 
        AND @tanggal_akhir 
        AND DATE(a.date_time) = b.tanggal 
      GROUP BY a.pin,
        b.tanggal 
      ORDER BY a.pin,
        a.date_time ASC) b",'a.tgl = b.tgl_b AND a.empcode = b.empcode','left');
        $this->db->join("(select DISTINCT(a.id_absensi_hp) AS id_absensi FROM
        (SELECT 
          a.id_absensi, a.empcode, a.period, a.year,  a.tanggal, a.shift,
          CASE 
          WHEN a.shift = 0 THEN 'off' 
          END AS ket,
          CASE 
          WHEN a.shift = 0 THEN (SELECT id_absensi FROM absensi_rooster WHERE id_absensi = a.id_absensi-1 AND empcode = a.empcode AND tanggal BETWEEN @tanggal_awal AND @tanggal_akhir)
          END AS id_absensi_hp
        FROM
          absensi_rooster a LEFT JOIN (SELECT id_absensi, tanggal, empcode, shift FROM absensi_rooster) b ON a.id_absensi = b.id_absensi
        WHERE a.tanggal BETWEEN @tanggal_awal AND @tanggal_akhir) a) c",'b.id_absensi = c.id_absensi','left');
        $this->db->group_by('a.empcode, a.tgl'); */

        $this->db->select("empcode, dept_id, nik_pim, empname, tanggal, shift, check_in, check_out, late, overtime, work_hour, attd_code");
        $this->db->from("presensi");
        $this->db->order_by("empname, tanggal","desc");
        $this->db->order_by("empname, check_in","desc");
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

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
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
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert("spl", $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}


    public function cek_data($date, $empcode)
    {
        $this->db->from($this->table);
        $this->db->where('empcode ="'.$empcode.'" AND date ="'.$date.'"');
        $query = $this->db->get();
        //$row = $query->row();
        
        return $query->row();
    }



}
/*end of spl model*/