<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if ( ! function_exists('view_p_satu'))
    {
        function view_p_satu($periode) // variable periode adalah total jumlah hari dalam 1 periode, sudah ada helper untuk menghitunggnya nama helpernya total_hari($period, $year)
        {
        //$this->load->helper('date');
        if (!empty($periode)) {
                $p = "";
                $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 1) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=4) {
        $p .= "<td>M</td>";
            }
        elseif ($i==5) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=8) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=11) {
        $p .= "<td>M</td>";
            }
        elseif ($i==12) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=15) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=18) {
        $p .= "<td>M</td>";
            }
        elseif ($i==19) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=22) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=25) {
        $p .= "<td>M</td>";
            }
        elseif ($i==26) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=29) {
        $p .= "<td>P</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>M</td>";
            }
        }
        return $p;
        }   
        }
    }

    if ( ! function_exists('view_p_dua'))
    {
        function view_p_dua($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 2) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=5) {
        $p .= "<td>M</td>";
            }
        elseif ($i==6) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=9) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=12) {
        $p .= "<td>M</td>";
            }
        elseif ($i==13) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=16) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=19) {
        $p .= "<td>M</td>";
            }
        elseif ($i==20) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=23) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=26) {
        $p .= "<td>M</td>";
            }
        elseif ($i==27) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>P</td>";
            }
        }
        return $p;
        }
    }

    if ( ! function_exists('view_p_tiga'))
    {
        function view_p_tiga($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 3) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=6) {
        $p .= "<td>M</td>";
            }
        elseif ($i==7) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=10) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=13) {
        $p .= "<td>M</td>";
            }
        elseif ($i==14) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=17) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=20) {
        $p .= "<td>M</td>";
            }
        elseif ($i==21) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=24) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=27) {
        $p .= "<td>M</td>";
            }
        elseif ($i==28) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=31) {
        $p .= "<td>P</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>M</td>";
            }
        }
        return $p;
        }
    }


    if ( ! function_exists('view_m_satu'))
    {
        function view_m_satu($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 1) {
        $p .= "<td>M</td>";
            }
        elseif ($i==2) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=5) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=8) {
        $p .= "<td>M</td>";
            }
            elseif ($i==9) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=12) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=15) {
        $p .= "<td>M</td>";
            }
            elseif ($i==16) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=19) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=22) {
        $p .= "<td>M</td>";
            }
            elseif ($i==23) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=26) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=29) {
        $p .= "<td>M</td>";
            }
            elseif ($i==30) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>P</td>";
            }
        }
        return $p;
        }
    }

    if ( ! function_exists('view_m_dua'))
    {
        function view_m_dua($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 2) {
        $p .= "<td>M</td>";
            }
        elseif ($i==3) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=6) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=9) {
        $p .= "<td>M</td>";
            }
            elseif ($i==10) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=13) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=16) {
        $p .= "<td>M</td>";
            }
            elseif ($i==17) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=20) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=23) {
        $p .= "<td>M</td>";
            }
            elseif ($i==24) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=27) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=30) {
        $p .= "<td>M</td>";
            }
        elseif ($i==31) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>P</td>";
            }
        }
        return $p;
        }
    }

    if ( ! function_exists('view_m_tiga'))
    {
        function view_m_tiga($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
                if ($i <= 3) {
            $p .= "<td>M</td>";
                }
            elseif ($i==4) {
            $p .= "<td style='color:white; background-color:red;' >OFF</td>";
                }
            elseif ($i<=7) {
            $p .= "<td>P</td>";
                }
            elseif ($i<=10) {
            $p .= "<td>M</td>";
                }
                elseif ($i==11) {
            $p .= "<td style='color:white; background-color:red;' >OFF</td>";
                }
            elseif ($i<=14) {
            $p .= "<td>P</td>";
                }
            elseif ($i<=17) {
            $p .= "<td>M</td>";
                }
                elseif ($i==18) {
            $p .= "<td style='color:white; background-color:red;' >OFF</td>";
                }
            elseif ($i<=21) {
            $p .= "<td>P</td>";
                }
            elseif ($i<=24) {
            $p .= "<td>M</td>";
                }
                elseif ($i==25) {
            $p .= "<td style='color:white; background-color:red;' >OFF</td>";
                }
            elseif ($i<=28) {
            $p .= "<td>P</td>";
                }
            elseif ($i<=31) {
            $p .= "<td>M</td>";
                }
            elseif ($i==32) {
            $p .= "<td style='color:white; background-color:red;' >OFF</td>";
                }
            elseif ($i<= $i) {
            $p .= "<td>P</td>";
                }
            }
            return $p;
        }
    }

    if ( ! function_exists('view_off'))
    {
        function view_off($periode)
        {
            $p = "";
        $jml_hari = $periode;
        for ($i=1; $i < $jml_hari ; $i++) { 
            if ($i <= 1) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<=4) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=7) {
        $p .= "<td>M</td>";
            }
        elseif ($i==8) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
            elseif ($i<=11) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=14) {
        $p .= "<td>M</td>";
            }
        elseif ($i==15) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
            elseif ($i<=18) {
        $p .= "<td>P</td>";
            }
            elseif ($i<=21) {
        $p .= "<td>M</td>";
            }
        elseif ($i==22) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
            elseif ($i<=25) {
        $p .= "<td>P</td>";
            }
        elseif ($i<=28) {
        $p .= "<td>M</td>";
            }
        elseif ($i==29) {
        $p .= "<td style='color:white; background-color:red;' >OFF</td>";
            }
        elseif ($i<= $i) {
        $p .= "<td>P</td>";
            }
        }
        return $p;
        }
    }
