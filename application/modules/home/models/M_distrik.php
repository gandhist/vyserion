<?php

/**
* 
*/
class M_distrik extends CI_Model
{
	var $table = 'empmaster';
	function __construct()
	{
		parent::__construct();

	}
	function get_all_item()
	{
/*		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();*/
		//
		//$this->db->select('id_paklaring');
		//$this->db->limit(10);
		//$this->db->order_by('id_paklaring', 'DESC');
		return $this->db->get($this->table);
	}
}