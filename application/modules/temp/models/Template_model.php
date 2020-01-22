<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Template_model extends CI_Model
{

    public function get_menu()
    {
        $this->db->select('module_name, id_module, glyphicon, method');
        $this->db->from('menu_regist');
        $this->db->group_by('id_module');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_dropdown($id_modul, $id_menu)
    {
        $this->db->select('module_name,menu_name, method, id_menu');
        $this->db->from('menu_regist');
        $this->db->where('id_menu',$id_menu);
        $this->db->where('id_module',$id_modul);
        $query = $this->db->get();
        return $query->result();
    }

    public function cek_method($method)
    {
        $this->db->select('method, id_menu, id_module, module_name, glyphicon, menu_name');
        $this->db->from('menu_regist');
        $this->db->where('method', $method);
        $query = $this->db->get();
        return $query->row();

    }
    
}
