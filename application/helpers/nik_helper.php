<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('nik_helper'))
    {
        function nik_helper($dept)
        {
        	/*fungsi ini untuk mendapatkan fungsi turunan yang ada di controller hr*/
        date_default_timezone_set('Asia/Jakarta');
        $CI = get_instance();
        $a = $CI->emp_attribute->last_rn();
        foreach ($a as $key) {
        $last = $key->rn+1;
        }
        $nik = $last."/".$dept."/".date("Y");
        return $nik;
        }
    }

   