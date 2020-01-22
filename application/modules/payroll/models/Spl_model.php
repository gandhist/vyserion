<?php
defined('BASEPATH') OR exit('No direct script access allowed');




/**
* 
*/
class Spl_model extends CI_Model
{
	/*inisialisasi variable*/
var $table = 'spl';
var $column_order = array('a.inputdate','b.nik_pim','b.empname','b.departement', 'b.position', null, null);
var $column_search = array('b.nik_pim','b.empname','d.dept_desc','c.position_desc', 'a.date', 'a.overtime', 'a.remarks');
var $order = array('a.inputdate' => 'desc');
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
 		if($this->input->post('f_empcode'))
            {
                $this->db->where('a.empcode', $this->input->post('f_empcode'));
            }
        if($this->input->post("filter_start") || $this->input->post("filter_end"))
        {
            $this->db->where('a.date BETWEEN "'.$this->input->post("filter_start").'" AND "'.$this->input->post("filter_end").'"');
        }


        $this->db->select('a.id, a.empcode, b.nik_pim, b.empname, b.departement, d.dept_desc, b.position, c.position_desc, a.date, a.overtime, a.remarks');
        $this->db->from('spl a');
        $this->db->join('emp_master b','a.empcode = b.empcode');
        $this->db->join('master_position c','b.position = c.id_position','left');
        $this->db->join('master_dept d','b.departement = d.departement','left');


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