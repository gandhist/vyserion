<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpt_vehicle_sarana_model extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
		$this->load->database();
	}

	public function report_asset_sarana($order_by)
	{
		$query = $this->db->query('select 
  a.nomor_plat,
  a.code_unit,
  a.nap,
  get_empname (a.pic_code) AS pic_code,
  a.type,
  a.year,
  a.ownership,
  a.status_unit,
  get_vehicle_pajak(a.nap) AS pajak,
  get_vehicle_stnk(a.nap) AS stnk,
  get_vehicle_keur(a.nap) AS keur,
  get_vehicle_iu(a.nap) AS ijin_usaha,
  a.remarks,
  a.date_receive,
  a.no_frame,
  a.no_machine,
  a.cylinder
FROM
  vehicle_master a
  order by a.'.$order_by.' asc
');
		return $query->result();
	}
}