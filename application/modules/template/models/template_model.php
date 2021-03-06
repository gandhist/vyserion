<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Template_model extends CI_Model
{

    public function get_menu()
    {
        $this->db->select('module_name, id_module, glyphicon');
        $this->db->from('menu_regist');
        $this->db->group_by('id_module');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_dropdown($id_modul, $id_menu)
    {
        $this->db->select('module_name, method, id_menu');
        $this->db->from('menu_regist');
        $this->db->where('id_menu',$id_menu);
        $this->db->where('id_module',$id_modul);
        $query = $this->db->get();
        return $query->result();
    }
    
}
