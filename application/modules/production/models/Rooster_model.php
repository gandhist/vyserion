<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rooster_model extends CI_Model {

    var $table = 'emp_rooster';
    var $column_order = array(null,'b.nik_pim','b.empname','a.period','a.year','c.gang_name','a.code_begin','a.remarks',null); //set column field database for datatable orderable
    var $column_search = array('b.nik_pim','b.empname','a.period','a.year','c.gang_name','a.code_begin','a.remarks'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('b.nik_pim' => 'desc'); // default order 
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        //add custom filter here
        if($this->input->post('f_empcode_f'))
            {
                $this->db->where('a.empcode', $this->input->post('f_empcode_f'));
            }
        if($this->input->post('f_gang_f'))
        {
            $this->db->where('c.id_gang', $this->input->post('f_gang_f'));
        }
        if($this->input->post('f_period_f'))
        {
            $this->db->where('a.period', $this->input->post('f_period_f'));
        }
        if($this->input->post('f_year_f'))
        {
            $this->db->where('a.year', $this->input->post('f_year_f'));
        }
        
        /*
        unremarks this for additional form filter data
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

        $this->db->select('a.id_rooster_sk, b.empname,
  b.nik_pim,
  a.empcode,
  a.period,
  a.year,
  a.remarks,
  a.code_begin,
  c.gang_name');
        $this->db->from('emp_rooster a');
        $this->db->join('emp_master b','a.empcode = b.empcode');
        $this->db->join('(select 
  a.empcode,
  b.id_gang,
  b.gang_name,
  MAX(a.start_date) start_date 
FROM
  gang_master a 
  RIGHT JOIN (SELECT id_gang, gang_name FROM gang WHERE active > 0) b 
    ON a.id_gang = b.id_gang
GROUP BY a.empcode) c','a.empcode = c.empcode','left');
        $this->db->where('a.is_deleted = 0');
        //$this->db->join('master_position','gang_activity.attd_code = master_position.id_position','left');
        //$this->db->where('a.active = 1 AND a.empcode = b.empcode AND a.id_gang = c.id_gang');
        //$this->db->order_by('a.empcode','desc');


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
        //$this->db->from($this->table);
        $this->_get_datatables_query();

        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_rooster_sk',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function cek_data($id, $date)
    {
        $this->db->from($this->table);
        $this->db->where('empcode ="'.$id.'" AND attd_date ="'.$date.'"');
        $query = $this->db->get();
        //$row = $query->row();
        
        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert("emp_rooster", $data);
        return $this->db->insert_id();
    }

    public function before_insert_rooster($empcode, $period, $year)
    {
      /*SELECT empcode, period, YEAR FROM emp_rooster*/
        $this->db->from('emp_rooster');
        $this->db->where('empcode ="'.$empcode.'" AND period ="'.$period.'" AND year = "'.$year.'" and is_deleted = "0" ');
        $query = $this->db->get();
        return $query->row();
    }

    public function last_row_rooster()
    {
      $query = $this->db->query('select MAX(id_rooster_sk) AS last_id FROM emp_rooster');
        return $query->row();
    }
    public function insert_rooster_absensi($data)
    {
        $this->db->insert("absensi_rooster", $data);
        return $this->db->insert_id();
    }


    public function coba($data)
    {
        $this->db->insert("emp_rooster", $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function update_rooster($where, $data)
    {
        $this->db->update("absensi_rooster", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_absensi_rooster($id, $empcode)
    {
        $this->db->where('id', $id);
        $this->db->where('empcode', $empcode);
        /*$this->db->where('period', $period);
        $this->db->where('year', $year);*/
        $this->db->delete('absensi_rooster');
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_gang', $id);
        $this->db->delete($this->table);
    }
    public function m_cetak($id)
    {
        $this->db->where('id_vehicle',$id);
        return $this->db->get($this->table);
    
    }
    public function last_id()
    {
        $this->db->select('empcode');
        $this->db->limit(1);
        $this->db->order_by('empcode', 'DESC');
        $query = $this->db->get('emp_master');
        return $query->row();
    }

    /*public function rpt_absensi_finger()
    { 
      $this->db->query("SET @awal_tugas = '07:00:00'");
      $this->db->query("SET @akhir_tugas = '17:00:00'");
        $query = $this->db->query("select 
  a.pin,
  b.empname,
  b.nik_pim,
  DATE(a.date_time) AS tanggal,
  @awal_tugas AS awal_tugas,
  @akhir_tugas AS akhir_tugas,
  -- Min(a.date_time),
  MIN(DATE_FORMAT(a.date_time,'%H:%i:%s')) AS masuk,
  MAX(DATE_FORMAT(a.date_time,'%H:%i:%s')) AS keluar, 
  CASE
  WHEN MIN(DATE_FORMAT(a.date_time,'%H:%i:%s')) > @awal_tugas THEN TIMEDIFF(MIN(DATE_FORMAT(a.date_time,'%H:%i:%s')),'07:00')
  WHEN MIN(DATE_FORMAT(a.date_time,'%H:%i:%s')) < @awal_tugas THEN 'teladan'
  END AS telat
FROM
  absen_finger a LEFT JOIN emp_master b ON a.pin = b.badgenumber
  WHERE DATE(a.date_time) BETWEEN '2018-04-26' AND '2018-05-25'
GROUP BY  a.pin, tanggal 
ORDER BY a.pin, a.date_time ASC");
        return $query->result();

    }*/


/*SET @tanggal_awal = "2018-04-26";
SET @tanggal_akhir = "2018-05-25";
SET @jam_awal_pagi = "07:00:00";
SET @jam_awal_malam = "19:00:00";
SELECT 
  a.pin,
  a.empcode,
  a.empname,
  a.date_time tgl_mesin,
  CASE
    WHEN b.shift = 1 
    THEN "SHIFT I" 
    WHEN b.shift = 2 
    THEN "SHIFT II" 
    ELSE "OFF DAY" 
  END AS jam_kerja,
  DATE(a.date_time) AS tanggal,
  CASE
    WHEN b.shift = 2 
    THEN DATE_ADD(DATE(a.date_time), INTERVAL 1 DAY) 
    WHEN b.shift = 1 
    THEN DATE(a.date_time) 
    ELSE "SHIFT OFF" 
  END AS tgl_akhir_shift_malam,
  -- Min(a.date_time),
  CASE
    WHEN b.shift = 2 
    THEN shift_dua_in(a.pin, DATE(a.date_time))
    WHEN b.shift = 1
    THEN shift_satu_in(a.pin, DATE(a.date_time))
    ELSE "-" 
  END AS masuk,
  CASE
    WHEN b.shift = 2 
    THEN shift_dua_out (a.pin, DATE(a.date_time)) 
    WHEN b.shift = 1
    THEN shift_satu_out(a.pin, DATE(a.date_time))
    ELSE "-" 
  END AS keluar_shift_malam,
  CASE
    WHEN b.shift = 1 AND DATE_FORMAT(shift_satu_in(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_pagi THEN TIMEDIFF(DATE_FORMAT(shift_satu_in(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_pagi ) 
    WHEN b.shift = 2 AND DATE_FORMAT(shift_dua_in(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_malam THEN TIMEDIFF(DATE_FORMAT(shift_dua_in(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_malam) 
  END AS telat 
FROM
  (SELECT 
    a.pin,
    b.empcode,
    b.empname,
    b.nik_pim,
    a.date_time,
    DATE(a.date_time) AS tanggal,
    a.ver,
    a.status 
  FROM
    absen_finger a 
    LEFT JOIN emp_master b 
      ON a.pin = b.badgenumber) a 
  LEFT JOIN absensi_rooster b 
    ON a.empcode = b.empcode 
WHERE DATE(a.date_time) BETWEEN @tanggal_awal 
  AND @tanggal_akhir 
  AND DATE(a.date_time) = b.tanggal 
GROUP BY a.pin,
  tanggal 
ORDER BY a.pin,
  a.date_time ASC */
    public function rpt_absensi_finger($tgl_awal, $tgl_akhir)
    { 
      $this->db->query("SET @jam_awal_pagi = '07:00:00'");
      $this->db->query("SET @jam_awal_malam = '19:30:00'");
      /*$this->db->query("SET @tanggal_awal = '2018-04-26'");
      $this->db->query("SET @tanggal_akhir = '2018-05-25'");*/
      $this->db->query("SET @tanggal_awal = '".$tgl_awal."'");
      $this->db->query("SET @tanggal_akhir = '".$tgl_akhir."'");
        $query = $this->db->query("select a.empcode, a.nik_pim AS nik_pim, a.nama AS empname, a.tgl AS tanggal, a.jam_kerja, b.tgl_akhir_shift_malam, b.masuk, b.keluar_shift_malam, b.telat FROM 
(SELECT 
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
  b.badgenumber 
FROM
  absensi_rooster a 
  INNER JOIN emp_master b 
    ON a.empcode = b.empcode 
    WHERE a.tanggal BETWEEN @tanggal_awal AND @tanggal_akhir) a 
    LEFT JOIN (SELECT 
  a.pin,
  a.empcode,
  a.empname,
  a.date_time tgl_mesin,
  b.tanggal AS tgl_b,
  CASE
    WHEN b.shift = 1 
    THEN 'SHIFT I' 
    WHEN b.shift = 2 
    THEN 'SHIFT II' 
    ELSE 'OFF DAY' 
  END AS jam_kerja,
  DATE(a.date_time) AS tanggal,
  CASE
    WHEN b.shift = 2 
    THEN DATE_ADD(DATE(a.date_time), INTERVAL 1 DAY) 
    WHEN b.shift = 1 
    THEN DATE(a.date_time) 
    ELSE 'SHIFT OFF' 
  END AS tgl_akhir_shift_malam,
  -- Min(a.date_time),
  CASE
    WHEN b.shift = 2 
    THEN shift_dua_in(a.pin, DATE(a.date_time))
    WHEN b.shift = 1
    THEN shift_satu_in(a.pin, DATE(a.date_time))
    ELSE '-' 
  END AS masuk,
  CASE
    WHEN b.shift = 2 
    THEN shift_dua_out (a.pin, DATE(a.date_time)) 
    WHEN b.shift = 1
    THEN shift_satu_out(a.pin, DATE(a.date_time))
    ELSE '-' 
  END AS keluar_shift_malam,
  CASE
    WHEN b.shift = 1 AND DATE_FORMAT(shift_satu_in(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_pagi THEN TIMEDIFF(DATE_FORMAT(shift_satu_in(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_pagi ) 
    WHEN b.shift = 2 AND DATE_FORMAT(shift_dua_in(a.pin, DATE(a.date_time)), '%H:%i:%s') > @jam_awal_malam THEN TIMEDIFF(DATE_FORMAT(shift_dua_in(a.pin, DATE(a.date_time)), '%H:%i:%s'),@jam_awal_malam) 
  END AS telat 
FROM
  (SELECT 
    a.pin,
    b.empcode,
    b.empname,
    b.nik_pim,
    a.date_time,
    DATE(a.date_time) AS tanggal,
    a.ver,
    a.status 
  FROM
    absen_finger a 
    LEFT JOIN emp_master b 
      ON a.pin = b.badgenumber) a 
  RIGHT JOIN absensi_rooster b 
    ON a.empcode = b.empcode 
WHERE DATE(a.date_time) BETWEEN @tanggal_awal 
  AND @tanggal_akhir 
  AND DATE(a.date_time) = b.tanggal 
GROUP BY a.pin,
  tanggal 
ORDER BY a.pin,
  a.date_time ASC) b
    ON a.tgl = b.tgl_b AND a.empcode = b.empcode
  GROUP BY a.empcode, a.tgl
     ORDER BY nama, tgl ");
        return $query->result();
    }

    public function rpt_absensi_except_pro_rev01($tgl_awal, $tgl_akhir)
    {
      $this->db->query("SET @dept_id  = '8'");
      $this->db->query("SET @tanggal_awal = '".$tgl_awal."'");
      $this->db->query("SET @tanggal_akhir = '".$tgl_akhir."'");
      $query = $this->db->query("select empcode, dept_id, nik_pim, empname, tanggal, shift, check_in, check_out, late, overtime, work_hour, attd_code FROM presensi where dept_id != @dept_id and tanggal between @tanggal_awal and @tanggal_akhir order by empname, tanggal");
      return $query->result();
    }

    public function rpt_absensi_pro_rev01($tgl_awal, $tgl_akhir)
    {
      $this->db->query("SET @dept_id  = '8'");
      $this->db->query("SET @tanggal_awal = '".$tgl_awal."'");
      $this->db->query("SET @tanggal_akhir = '".$tgl_akhir."'");
      //$query = $this->db->query("select empcode, dept_id, nik_pim, empname, tanggal, shift, check_in, check_out, late, overtime, work_hour, attd_code FROM presensi where dept_id = @dept_id and tanggal between @tanggal_awal and @tanggal_akhir order by empname, tanggal");
      $query = $this->db->query("select 
      a.empcode,
      a.dept_id,
      a.nik_pim,
      a.empname,
      b.remarks,
      a.tanggal,
      a.shift,
      a.check_in,
      a.check_out,
      a.late,
      a.overtime,
      a.work_hour,
      a.attd_code 
    FROM
      presensi a INNER JOIN (SELECT empcode, MAX(start_date) AS tanggal, remarks FROM gang_master GROUP BY start_date, empcode) b ON a.empcode = b.empcode
    WHERE a.dept_id = @dept_id 
      AND a.tanggal BETWEEN @tanggal_awal 
      AND @tanggal_akhir 
    ORDER BY a.empname,
      a.tanggal ");
      return $query->result();
    }


    public function rpt_absensi_except_pro($tgl_awal, $tgl_akhir)
    {
      $this->db->query("SET @jam_awal_pagi = '07:00:00'");
      $this->db->query("SET @jam_awal_malam = '19:30:00'");
      $this->db->query("SET @dept_id  = '8'");
      $this->db->query("SET @tanggal_awal = '".$tgl_awal."'");
      $this->db->query("SET @tanggal_akhir = '".$tgl_akhir."'");
      $query = $this->db->query("
        select b.id_absensi,
        a.empcode,
        a.nik_pim AS nik_pim,
        a.nama AS empname,
        a.tgl AS tanggal,
        a.jam_kerja,
        b.masuk,
        b.keluar_shift_malam,
        b.telat 
      FROM
        (SELECT 
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
        b.badgenumber 
      FROM
        (SELECT empcode, tanggal, shift FROM absensi_rooster WHERE tanggal BETWEEN @tanggal_awal AND @tanggal_akhir ) a 
        INNER JOIN (SELECT empcode, nik_pim, badgenumber FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement != @dept_id ) b 
          ON a.empcode = b.empcode ) a 
        LEFT JOIN (SELECT 
        b.id_absensi,
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
          (SELECT pin, date_time FROM absen_finger_x601 WHERE pin IN (SELECT badgenumber FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement != @dept_id) ) a 
          LEFT JOIN (SELECT empcode, badgenumber FROM emp_master WHERE empcode NOT IN (SELECT empcode FROM hr_termination) AND is_deleted = 0 AND departement != @dept_id) b 
            ON a.pin = b.badgenumber) a 
        RIGHT JOIN (SELECT id_absensi, empcode, tanggal, shift FROM absensi_rooster WHERE tanggal BETWEEN @tanggal_awal AND @tanggal_akhir ) b 
          ON a.empcode = b.empcode 
      WHERE DATE(a.date_time) BETWEEN @tanggal_awal 
        AND @tanggal_akhir 
        AND DATE(a.date_time) = b.tanggal 
      GROUP BY a.pin,
        b.tanggal 
      ORDER BY a.pin,
        a.date_time ASC) b 
          ON a.tgl = b.tgl_b 
          AND a.empcode = b.empcode 
      GROUP BY a.empcode,
        a.tgl 
      ORDER BY a.nama,
        a.tgl 
      ");
      return $query->result();
    }

    public function rpt_rooster_excel($period, $tahun, $id_gang)
    {
        $query = $this->db->query('select 
  a.id_rooster_sk,
  b.empname,
  b.nik_pim,
  a.empcode,
  a.period,
  a.year,
  c.remarks,
  a.code_begin,
  c.gang_name,
  a.a1,
  a.a2,
  a.a3,
  a.a4,
  a.a5,
  a.a6,
  a.a7,
  a.a8,
  a.a9,
  a.a10,
  a.a11,
  a.a12,
  a.a13,
  a.a14,
  a.a15,
  a.a16,
  a.a17,
  a.a18,
  a.a19,
  a.a20,
  a.a21,
  a.a22,
  a.a23,
  a.a24,
  a.a25,
  a.a26,
  a.a27,
  a.a28,
  a.a29,
  a.a30,
  a.a31,
  a.a32 
FROM
  emp_rooster a 
  JOIN emp_master b 
    ON a.empcode = b.empcode 
  LEFT JOIN 
    (SELECT 
      a.empcode,
      a.remarks,
      b.id_gang,
      b.gang_name,
      MAX(a.start_date) start_date 
    FROM
      gang_master a 
      RIGHT JOIN 
        (SELECT 
          id_gang,
          gang_name 
        FROM
          gang 
        WHERE active > 0) b 
        ON a.id_gang = b.id_gang 
    GROUP BY a.empcode) c 
    ON a.empcode = c.empcode
    WHERE a.is_deleted = 0 and c.id_gang = "'.$id_gang.'"  AND a.period = "'.$period.'" AND a.year = "'.$tahun.'"');
        return $query->result();

    }

    public function total_pagi_malam($periode, $tahun, $id_gang)
    {
        $this->db->query('SET @off := 0');
        $this->db->query('SET @pagi := 1');
        $this->db->query('SET @malam = 2');
        $this->db->query('SET @periode = "'.$periode.'"');
        $this->db->query('SET @tahun = "'.$tahun.'"');
        $this->db->query('SET @id_gang = "'.$id_gang.'"');
        $query = $this->db->query('
select
  SUM(
    CASE
      WHEN a.a1 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a1,
    SUM(
    CASE
      WHEN a.a2 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a2,
    SUM(
    CASE
      WHEN a.a3 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a3,
    SUM(
    CASE
      WHEN a.a4 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a4,
    SUM(
    CASE
      WHEN a.a5 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a5,
    SUM(
    CASE
      WHEN a.a6 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a6,
    SUM(
    CASE
      WHEN a.a7 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a7,
    SUM(
    CASE
      WHEN a.a8 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a8,
    SUM(
    CASE
      WHEN a.a9 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a9,
    SUM(
    CASE
      WHEN a.a10 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a10,
    SUM(
    CASE
      WHEN a.a11 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a11,
    SUM(
    CASE
      WHEN a.a12 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a12,
    SUM(
    CASE
      WHEN a.a13 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a13,
    SUM(
    CASE
      WHEN a.a14 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a14,
    SUM(
    CASE
      WHEN a.a15 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a15,
    SUM(
    CASE
      WHEN a.a16 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a16,
    SUM(
    CASE
      WHEN a.a17 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a17,
    SUM(
    CASE
      WHEN a.a18 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a18,
    SUM(
    CASE
      WHEN a.a19 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a19,
    SUM(
    CASE
      WHEN a.a20 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a20,
    SUM(
    CASE
      WHEN a.a21 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a21,
    SUM(
    CASE
      WHEN a.a22 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a22,
    SUM(
    CASE
      WHEN a.a23 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a23,
    SUM(
    CASE
      WHEN a.a24 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a24,
    SUM(
    CASE
      WHEN a.a25 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a25,
    SUM(
    CASE
      WHEN a.a26 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a26,
    SUM(
    CASE
      WHEN a.a27 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a27,
    SUM(
    CASE
      WHEN a.a28 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a28,
    SUM(
    CASE
      WHEN a.a29 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a29,
    SUM(
    CASE
      WHEN a.a30 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a30,
    SUM(
    CASE
      WHEN a.a31 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a31,
    SUM(
    CASE
      WHEN a.a32 = @pagi
      THEN 1 
      ELSE 0 
    END) AS a32            
FROM
  emp_rooster a WHERE a.empcode IN (SELECT 
  a.empcode
FROM
  emp_rooster a 
  LEFT JOIN gang_master b 
    ON a.empcode = b.empcode 
  LEFT JOIN gang c 
    ON b.id_gang = c.id_gang WHERE b.id_gang = @id_gang)AND a.is_deleted = 0 
  AND a.period = @periode AND a.year= @tahun 
  UNION ALL
  SELECT 
  SUM(
    CASE
      WHEN a.a1 = @malam
      THEN 1 
      ELSE 0 
    END) AS a1,
    SUM(
    CASE
      WHEN a.a2 = @malam
      THEN 1 
      ELSE 0 
    END) AS a2,
    SUM(
    CASE
      WHEN a.a3 = @malam
      THEN 1 
      ELSE 0 
    END) AS a3,
    SUM(
    CASE
      WHEN a.a4 = @malam
      THEN 1 
      ELSE 0 
    END) AS a4,
    SUM(
    CASE
      WHEN a.a5 = @malam
      THEN 1 
      ELSE 0 
    END) AS a5,
    SUM(
    CASE
      WHEN a.a6 = @malam
      THEN 1 
      ELSE 0 
    END) AS a6,
    SUM(
    CASE
      WHEN a.a7 = @malam
      THEN 1 
      ELSE 0 
    END) AS a7,
    SUM(
    CASE
      WHEN a.a8 = @malam
      THEN 1 
      ELSE 0 
    END) AS a8,
    SUM(
    CASE
      WHEN a.a9 = @malam
      THEN 1 
      ELSE 0 
    END) AS a9,
    SUM(
    CASE
      WHEN a.a10 = @malam
      THEN 1 
      ELSE 0 
    END) AS a10,
    SUM(
    CASE
      WHEN a.a11 = @malam
      THEN 1 
      ELSE 0 
    END) AS a11,
    SUM(
    CASE
      WHEN a.a12 = @malam
      THEN 1 
      ELSE 0 
    END) AS a12,
    SUM(
    CASE
      WHEN a.a13 = @malam
      THEN 1 
      ELSE 0 
    END) AS a13,
    SUM(
    CASE
      WHEN a.a14 = @malam
      THEN 1 
      ELSE 0 
    END) AS a14,
    SUM(
    CASE
      WHEN a.a15 = @malam
      THEN 1 
      ELSE 0 
    END) AS a15,
    SUM(
    CASE
      WHEN a.a16 = @malam
      THEN 1 
      ELSE 0 
    END) AS a16,
    SUM(
    CASE
      WHEN a.a17 = @malam
      THEN 1 
      ELSE 0 
    END) AS a17,
    SUM(
    CASE
      WHEN a.a18 = @malam
      THEN 1 
      ELSE 0 
    END) AS a18,
    SUM(
    CASE
      WHEN a.a19 = @malam
      THEN 1 
      ELSE 0 
    END) AS a19,
    SUM(
    CASE
      WHEN a.a20 = @malam
      THEN 1 
      ELSE 0 
    END) AS a20,
    SUM(
    CASE
      WHEN a.a21 = @malam
      THEN 1 
      ELSE 0 
    END) AS a21,
    SUM(
    CASE
      WHEN a.a22 = @malam
      THEN 1 
      ELSE 0 
    END) AS a22,
    SUM(
    CASE
      WHEN a.a23 = @malam
      THEN 1 
      ELSE 0 
    END) AS a23,
    SUM(
    CASE
      WHEN a.a24 = @malam
      THEN 1 
      ELSE 0 
    END) AS a24,
    SUM(
    CASE
      WHEN a.a25 = @malam
      THEN 1 
      ELSE 0 
    END) AS a25,
    SUM(
    CASE
      WHEN a.a26 = @malam
      THEN 1 
      ELSE 0 
    END) AS a26,
    SUM(
    CASE
      WHEN a.a27 = @malam
      THEN 1 
      ELSE 0 
    END) AS a27,
    SUM(
    CASE
      WHEN a.a28 = @malam
      THEN 1 
      ELSE 0 
    END) AS a28,
    SUM(
    CASE
      WHEN a.a29 = @malam
      THEN 1 
      ELSE 0 
    END) AS a29,
    SUM(
    CASE
      WHEN a.a30 = @malam
      THEN 1 
      ELSE 0 
    END) AS a30,
    SUM(
    CASE
      WHEN a.a31 = @malam
      THEN 1 
      ELSE 0 
    END) AS a31,
    SUM(
    CASE
      WHEN a.a32 = @malam
      THEN 1 
      ELSE 0 
    END) AS a32    
FROM
  emp_rooster a WHERE a.empcode IN (SELECT 
  a.empcode
FROM
  emp_rooster a 
  LEFT JOIN gang_master b 
    ON a.empcode = b.empcode 
  LEFT JOIN gang c 
    ON b.id_gang = c.id_gang WHERE b.id_gang = @id_gang)AND a.is_deleted = 0 
  AND a.period = @periode AND a.year= @tahun 
    UNION ALL
  SELECT SUM(
    CASE
      WHEN a.a1 = @off
      THEN 1 
      ELSE 0 
    END) AS a1,
    SUM(
    CASE
      WHEN a.a2 = @off
      THEN 1 
      ELSE 0 
    END) AS a2,
    SUM(
    CASE
      WHEN a.a3 = @off
      THEN 1 
      ELSE 0 
    END) AS a3,
    SUM(
    CASE
      WHEN a.a4 = @off
      THEN 1 
      ELSE 0 
    END) AS a4,
    SUM(
    CASE
      WHEN a.a5 = @off
      THEN 1 
      ELSE 0 
    END) AS a5,
    SUM(
    CASE
      WHEN a.a6 = @off
      THEN 1 
      ELSE 0 
    END) AS a6,
    SUM(
    CASE
      WHEN a.a7 = @off
      THEN 1 
      ELSE 0 
    END) AS a7,
    SUM(
    CASE
      WHEN a.a8 = @off
      THEN 1 
      ELSE 0 
    END) AS a8,
    SUM(
    CASE
      WHEN a.a9 = @off
      THEN 1 
      ELSE 0 
    END) AS a9,
    SUM(
    CASE
      WHEN a.a10 = @off
      THEN 1 
      ELSE 0 
    END) AS a10,
    SUM(
    CASE
      WHEN a.a11 = @off
      THEN 1 
      ELSE 0 
    END) AS a11,
    SUM(
    CASE
      WHEN a.a12 = @off
      THEN 1 
      ELSE 0 
    END) AS a12,
    SUM(
    CASE
      WHEN a.a13 = @off
      THEN 1 
      ELSE 0 
    END) AS a13,
    SUM(
    CASE
      WHEN a.a14 = @off
      THEN 1 
      ELSE 0 
    END) AS a14,
    SUM(
    CASE
      WHEN a.a15 = @off
      THEN 1 
      ELSE 0 
    END) AS a15,
    SUM(
    CASE
      WHEN a.a16 = @off
      THEN 1 
      ELSE 0 
    END) AS a16,
    SUM(
    CASE
      WHEN a.a17 = @off
      THEN 1 
      ELSE 0 
    END) AS a17,
    SUM(
    CASE
      WHEN a.a18 = @off
      THEN 1 
      ELSE 0 
    END) AS a18,
    SUM(
    CASE
      WHEN a.a19 = @off
      THEN 1 
      ELSE 0 
    END) AS a19,
    SUM(
    CASE
      WHEN a.a20 = @off
      THEN 1 
      ELSE 0 
    END) AS a20,
    SUM(
    CASE
      WHEN a.a21 = @off
      THEN 1 
      ELSE 0 
    END) AS a21,
    SUM(
    CASE
      WHEN a.a22 = @off
      THEN 1 
      ELSE 0 
    END) AS a22,
    SUM(
    CASE
      WHEN a.a23 = @off
      THEN 1 
      ELSE 0 
    END) AS a23,
    SUM(
    CASE
      WHEN a.a24 = @off
      THEN 1 
      ELSE 0 
    END) AS a24,
    SUM(
    CASE
      WHEN a.a25 = @off
      THEN 1 
      ELSE 0 
    END) AS a25,
    SUM(
    CASE
      WHEN a.a26 = @off
      THEN 1 
      ELSE 0 
    END) AS a26,
    SUM(
    CASE
      WHEN a.a27 = @off
      THEN 1 
      ELSE 0 
    END) AS a27,
    SUM(
    CASE
      WHEN a.a28 = @off
      THEN 1 
      ELSE 0 
    END) AS a28,
    SUM(
    CASE
      WHEN a.a29 = @off
      THEN 1 
      ELSE 0 
    END) AS a29,
    SUM(
    CASE
      WHEN a.a30 = @off
      THEN 1 
      ELSE 0 
    END) AS a30,
    SUM(
    CASE
      WHEN a.a31 = @off
      THEN 1 
      ELSE 0 
    END) AS a31,
    SUM(
    CASE
      WHEN a.a32 = @off
      THEN 1 
      ELSE 0 
    END) AS a32 
  FROM
  emp_rooster a WHERE a.empcode IN (SELECT 
  a.empcode
FROM
  emp_rooster a 
  LEFT JOIN gang_master b 
    ON a.empcode = b.empcode 
  LEFT JOIN gang c 
    ON b.id_gang = c.id_gang WHERE b.id_gang = @id_gang)AND a.is_deleted = 0 
  AND a.period = @periode AND a.year= @tahun');
        return $query->result();
    }




    // model untuk dropdown employee code
/*  function dd_empcode()
    {
        // ambil data dari db
        $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd['*'] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }*/




}
