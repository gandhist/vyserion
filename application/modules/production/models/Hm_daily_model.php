<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Hm_daily_model extends CI_Model
{

	var $table = 'vehicle_daily_activity';
	var $column_order = array('a.date', 'a.nap'); //set column field database for datatable orderable
	var $column_search = array('a.date', 'a.nap', 'a.shift', 'a.hm_start', 'a.hm_start','b.code_unit'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('b.code_unit, a.shift' => 'asc'); // default order 
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		//add custom filter here
        if($this->input->post('f_nap_f'))
            {
                $this->db->where('a.nap', $this->input->post('f_nap_f'));
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('a.date BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
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
        /*
        SELECT 
  a.id_rn,
  a.date,
  a.nap,
  b.code_unit,
  LEFT(c.nik_pim, 4) AS nik,
  c.empname,
  a.hm_start,
  a.hm_end,
  a.total_hm, a.distance, a.material, a.nap_unit_loading, a.jam_07, a.jam_08, a.jam_09, a.jam_10, a.jam_11, a.jam_12, a.jam_01, a.jam_02, a.jam_03, a.jam_04, a.jam_05, a.total_ritase, a.total_bcm_ton
FROM
  vehicle_daily_activity a 
  LEFT JOIN vehicle_master b 
  ON a.nap = b.nap
  LEFT JOIN (SELECT empcode, nik_pim, empname FROM emp_master WHERE departement = 8 AND empcode NOT IN (SELECT empcode FROM hr_termination)) c
  ON a.operator_code = c.empcode*/
        $this->db->select('a.id_rn,
  a.date,
  a.nap,
  b.code_unit,
  LEFT(c.nik_pim, 4) AS nik,
  c.empname,
  a.shift,
  a.remarks,
  a.hm_start,
  a.hm_end,
  a.total_hm, a.distance, a.material, a.nap_unit_loading, a.jam_07, a.jam_08, a.jam_09, a.jam_10, a.jam_11, a.jam_12, a.jam_01, a.jam_02, a.jam_03, a.jam_04, a.jam_05, a.total_ritase, a.total_bcm_ton');
        $this->db->from('vehicle_daily_activity a');
        $this->db->join('vehicle_master b','a.nap = b.nap','left');
        $this->db->join('(select empcode, nik_pim, empname FROM emp_master WHERE departement = 8 AND empcode NOT IN (SELECT empcode FROM hr_termination) ) c','a.operator_code = c.empcode','left');
        //$this->db->order_by('b.code_unit','ASC');
        $this->db->limit('500');



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

    public function cek_data($nap, $date, $shift)
    {
        $this->db->from($this->table);
        $this->db->where('nap ="'.$nap.'" AND tanggal ="'.$date.'" AND shift = "'.$shift.'" ');
        $query = $this->db->get();
        //$row = $query->row();
        return $query->row();
    }

    public function cek_data_import($tanggal)
    {
      $this->db->from('vehicle_daily_activity');
      $this->db->where('date',$tanggal);
      $query = $this->db->get();
      return $query->row();
    }

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_rn',$id);
		$query = $this->db->get();

		return $query->row();
	}

    public function get_last_km($nap)
    {
        //$this->db->query('SET @nap = "'.$id.'";');
        $query = $this->db->query("select code_unit, type, model, nap FROM vehicle_master WHERE nap = '".$nap."' AND active = 1 AND work_unit != 1");
        return $query->row();
    }

    public function get_pw($nap, $date)
    {
        //$this->db->query('SET @nap = "'.$id.'";');
        $query = $this->db->query("select nap, date, ROUND(SUM(total_hm),1) AS total FROM vehicle_daily_activity where nap = '".$nap."' and date = '".$date."' GROUP BY nap, date");
        return $query->row();
    }

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_rn', $id);
		$this->db->delete($this->table);
	}

  public function delete_masal($date)
  {
    $this->db->where('date', $date);
    $this->db->delete('vehicle_daily_activity');

  }

  public function monthly_absensi_production()
  {

    $this->db->query("SET @tanggal_awal = '2019-01-26'");
    $this->db->query("SET @tanggal_akhir = '2019-02-25'");
      $query = $this->db->query("
select 
  work_hour,
  
  total_jam_lembur AS overtime
FROM
  gang_activity a
WHERE empcode = '1800182' 
  AND attd_date BETWEEN @tanggal_awal 
  AND @tanggal_akhir 
ORDER BY attd_date 
      ");
      return $query->result_array();
  }




}