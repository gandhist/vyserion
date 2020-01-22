<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_model extends CI_Model
{

        var $table = "hse_inspections";
        var $column_order = array('a.date','a.desc','b.code_unit','a.category','d.empname','c.dept_desc','a.action','a.company','a.status','a.action');
        var $column_search = array('a.date','a.desc','b.code_unit','a.category','d.empname','c.dept_desc','a.action','a.company','a.status','a.action');
        var $order = array('a.id' => 'desc');

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        private function _get_datatables_query()
        {

            if($this->input->post('filter_start') != '' && $this->input->post('filter_end') != '' || $this->input->post('filter_start') != null)
            {
                $this->db->where('a.date BETWEEN "'.$this->input->post('filter_start').'" AND "'.$this->input->post('filter_end').'"');
            }
            if ($this->input->post('filter_desc')) {
                $this->db->like('a.desc',$this->input->post('filter_desc'),'both');
            }
            if ($this->input->post('filter_act')) {
                $this->db->like('a.action',$this->input->post('filter_act'),'both');
            }
            if ($this->input->post('f_empcode_f')) {
                $this->db->where('a.report_by',$this->input->post('f_empcode_f'));
            }
            if ($this->input->post('filter_status')) {
                if ($this->input->post('filter_status') == "open") {
                $this->db->where('a.status', "0");                    
                }
                else
                {
                    $this->db->where('a.status',$this->input->post('filter_status'));
                }
            }



            $this->db->select('a.id,a.date, 
            a.desc,
            a.nap,
            a.category,
            a.report_by,
            a.dic,
            a.action,
            a.company,
            a.status,
            a.priority,
            b.code_unit,
            c.dept_desc,
            d.empname');
            $this->db->from('hse_inspections a');
            $this->db->join('vehicle_master b','a.nap = b.nap', 'left');
            $this->db->join('master_dept c','a.dic = c.departement','left');
            $this->db->join('(select empcode, empname FROM emp_master WHERE empcode NOT IN (select empcode FROM hr_termination) AND is_deleted = 0 AND departement = 6) d','a.report_by = d.empcode');

            $i = 0;

            foreach ($this->column_search as $item) {
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
        
        public function save($data)
        {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        public function get_by_id($id)
        {
            $this->db->from($this->table);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
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
 
}
