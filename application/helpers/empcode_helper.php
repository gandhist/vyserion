<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('empcode_helper'))
    {
        function date_input($tanggal)
        {
        //$this->load->helper('date');
        if (!empty($tanggal)) {
            # code...
            $tgl = $tanggal;
        //$tgl = $tanggal;
        $newDate = date("Y-m-d", strtotime($tgl));
        return $newDate;
        }   

    }
?>