<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('date_input'))
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
    }

    if ( ! function_exists('date_input_datetime'))
    {
        function date_input_datetime($tanggal)
        {
        //$this->load->helper('date');
        if (!empty($tanggal)) {
            # code...
            $tgl = $tanggal;
        //$tgl = $tanggal;
        $newDate = date("Y-m-d H:i", strtotime($tgl)); // akan menghasilkan 2018-08-06 14:18
        return $newDate;
        }   
        }
    }

    if ( ! function_exists('date_indonesia_datetime'))
    {
        function date_indonesia_datetime($tanggal)
        {
        if ($tanggal) {
            $tgl = $tanggal;
        $newDate = date("d-m-Y H:i", strtotime($tgl));
        // Should Produce: 2001-09-11
        $better_date = nice_date($newDate, 'd-m-Y H:i');
        }
        else {
        
            $better_date = "";  
        }
        return $better_date;
        }   
        
    }

    if ( ! function_exists('date_indonesia'))
    {
        function date_indonesia($tanggal)
        {
        //$this->load->helper('date');
        if ($tanggal) {
            $tgl = $tanggal;
        $newDate = date("d-M-Y", strtotime($tgl));
        // Should Produce: 2001-09-11
        $better_date = nice_date($newDate, 'd-m-Y');
        }
        else {
        
            $better_date = "";  
        }
        return $better_date;
          
        }
    }

    /* fungsi ini akan menampilkan tanggal awal dan akhir periode dari database hris pada table period_control */
    if ( ! function_exists('get_date_period')) {
        function get_date_period($period, $year)
        {
            $CI = get_instance();
            $CI->load->database();

            $CI->db->select('start_date, end_date');
            $CI->db->from('period_control');
            $CI->db->where('period', $period);
            $CI->db->where('tahun', $year);

            $query = $CI->db->get();
            return $query->row();

        }
    }

    if (! function_exists('beda_tanggal'))
    {
        function beda_tanggal($tanggal_awal, $tanggal_akhir)
        {
            $awal = date_create(date("Y-m-d", strtotime($tanggal_awal)));
            $akhir = date_create(date("Y-m-d", strtotime($tanggal_akhir)));
            $beda = date_diff($awal, $akhir);
            $tot = $beda->format('%a')+1;
            return $tot; 
        }
    }

    /*fungsi untuk menampilkan total hari dalam 1 periode*/
    if ( ! function_exists('total_hari'))
    {
        function total_hari($period, $year)
        {
            $periode = $period;
            $back_year = $year-1;
        switch ($periode) {
            case 1:
                $from = "26-12-". $back_year;
                $to = "25-01-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;
                /* ditambah 1 karena di PHP 26 di anggap sebagai tgl awal alias tidak di hitung*/
                break;
            case 2:
                $from = "26-01-".$year;
                $to = "25-02-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;
                break;

            case 3:
                $from = "26-02-".$year;
                $to = "25-03-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 4:
                $from = "26-03-".$year;
                $to = "25-04-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 5:
                $from = "26-04-".$year;
                $to = "25-05-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 6:
                $from = "26-05-".$year;
                $to = "25-06-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 7:
                $from = "26-06-".$year;
                $to = "25-07-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;
            case 8:
                $from = "26-07-".$year;
                $to = "25-08-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 9:
                $from = "26-08-".$year;
                $to = "25-09-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 10:
                $from = "26-09-".$year;
                $to = "25-10-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 11:
                $from = "26-10-".$year;
                $to = "25-11-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;

            case 12:
                $from = "26-11-".$year;
                $to = "25-12-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $batas+1;

                break;
        }
          
        }


/*mendapatkan tanggal awal cutoff dari periode dan tahun inputan*/
        if ( ! function_exists('get_from_date_period'))
    {
        function get_from_date_period($period, $year)
        {
            $periode = $period;
            $back_year = $year-1;
        switch ($periode) {
            case 1:
                $from = "26-12-". $back_year;
                $to = "25-01-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;
                /* ditambah 1 karena di PHP 26 di anggap sebagai tgl awal alias tidak di hitung*/
                break;
            case 2:
                $from = "26-01-".$year;
                $to = "25-02-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;
                break;

            case 3:
                $from = "26-02-".$year;
                $to = "25-03-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 4:
                $from = "26-03-".$year;
                $to = "25-04-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 5:
                $from = "26-04-".$year;
                $to = "25-05-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 6:
                $from = "26-05-".$year;
                $to = "25-06-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 7:
                $from = "26-06-".$year;
                $to = "25-07-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;
            case 8:
                $from = "26-07-".$year;
                $to = "25-08-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 9:
                $from = "26-08-".$year;
                $to = "25-09-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 10:
                $from = "26-09-".$year;
                $to = "25-10-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 11:
                $from = "26-10-".$year;
                $to = "25-11-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;

            case 12:
                $from = "26-11-".$year;
                $to = "25-12-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $from;

                break;
        }
          
        }
    }


/*mendapatkan tanggal akhir cutoff dari periode dan tahun inputan*/

     if ( ! function_exists('get_to_date_period'))
    {
        function get_to_date_period($period, $year)
        {
            $periode = $period;
            $back_year = $year-1;
        switch ($periode) {
            case 1:
                $from = "26-12-". $back_year;
                $to = "25-01-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;
                /* ditambah 1 karena di PHP 26 di anggap sebagai tgl awal alias tidak di hitung*/
                break;
            case 2:
                $from = "26-01-".$year;
                $to = "25-02-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;
                break;

            case 3:
                $from = "26-02-".$year;
                $to = "25-03-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 4:
                $from = "26-03-".$year;
                $to = "25-04-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 5:
                $from = "26-04-".$year;
                $to = "25-05-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 6:
                $from = "26-05-".$year;
                $to = "25-06-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 7:
                $from = "26-06-".$year;
                $to = "25-07-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;
            case 8:
                $from = "26-07-".$year;
                $to = "25-08-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 9:
                $from = "26-08-".$year;
                $to = "25-09-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 10:
                $from = "26-09-".$year;
                $to = "25-10-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 11:
                $from = "26-10-".$year;
                $to = "25-11-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;

            case 12:
                $from = "26-11-".$year;
                $to = "25-12-".$year;
                $a = date_create(date("Y-m-d",strtotime($from)));
                $b = date_create(date("Y-m-d",strtotime($to)));
                $c = date_diff($a,$b);
                $batas = $c->format('%a');
                return $to;;

                break;
        }
          
        }
    }
}
    /*end fungsi untuk menampilkan total hari dalam 1 periode*/

   