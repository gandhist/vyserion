<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('detail_lembur_helper'))
    {
        function detail($empcode)
        {   
            // get a reference to the controller object
            $CI = get_instance();

            //if model has been loaded by controller, you have no to call model anymore
            //$CI->load->model('emp_model');

            //call a fucntion of the model
            // mengacu kepada model yang di load saat controller di akses
            $a = $CI->rpt_slip_lembur->detail_lembur($empcode);
                echo "<table border='1'>
                <tr>
            <th >NIK</th>
            <th >Nama</th>
            <th >Tanggal</th>
            <th width='100' >Kehadiran</th>
            <th width='100' align='right' >Overtime</th>
        </tr>
                ";
            foreach ($a as $key) {
                echo "<tr>";
                echo "<td>".$key['empcode']."</td>";
                echo "<td>".$key['empname']."</td>";
                echo "<td>".$key['attd_date']."</td>";
                echo "<td>".$key['attd_code']."</td>";
                echo "<td align='right'>".$key['total']."</td>";
                echo "</tr>";

            }
            echo "</table>";
        }

    }

    if ( ! function_exists('detail_lembur_helper'))
    {
        function detail_overtime($empcode, $month, $year)
        {   
            // get a reference to the controller object
            $CI = get_instance();

            //if model has been loaded by controller, you have no to call model anymore
            //$CI->load->model('emp_model');

            //call a fucntion of the model
            // mengacu kepada model yang di load saat controller di akses
            $a = $CI->rpt_slip_lembur->rpt_detail_lembur($empcode, $month, $year);
                echo "<table border='1'>
                <tr>
            <th >No</th>
            <th width='60' >Tanggal</th>
            <th >Jam Lembur</th>
            <th >Kehadiran</th>
            <th width='100' >Overtime</th>
        </tr>
                ";
                $last = count($a);
                $no = 1;
            foreach ($a as $key) {
                echo "<tr>";
                //echo "<td>".$key['empcode']."</td>";
                //echo "<td>".$key['empname']."</td>";
                if ($no === $last) {
                echo "<td colspan='2' align='right'><b><i>Grand Total</b></i></td>";
                }
                else
                {
                    echo "<td align='right'>".$no."</td>";
                    if ($key['attd_code'] == "attd006" ) {
                        // jika off warna biru
                    echo "<td align='right' bgcolor='#b7cff4'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    else if($key['attd_code'] == "attd004")
                    {
                        //jika mangkir izin maka merah maroon
                        echo "<td align='right' bgcolor='#bd179f'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    else if($key['attd_code'] == "attd005")
                    {
                        //jika mangkir alpa maka merah
                        echo "<td align='right' bgcolor='#f44245'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    else if($key['attd_code'] == "attd007")
                    {
                        //jika sakit maka kuning
                        echo "<td align='right' bgcolor='#ceb04e'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    else if($key['attd_code'] == "attd008")
                    {
                        //jika cuti maka warna hijau
                        echo "<td align='right' bgcolor='#89ce2f'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    else if($key['attd_code'] == "attd009")
                    {
                        //jika libur maka warna biru
                        echo "<td align='right' bgcolor='#4286f4'>".date_indonesia($key['attd_date'])."</td>";
                    }
                    

                    else
                    {
                    echo "<td align='right'>".date_indonesia($key['attd_date'])."</td>";
                    }
                }
                echo "<td align='right'>".$key['total_jam_lembur']."</td>";
                echo "<td align='right'> Rp. ".number_format($key['kehadiran_pagi'],2,",",".")."</td>";
                echo "<td align='right'> Rp. ".number_format($key['total'],2,",",".")."</td>";
                echo "</tr>";
                $no++;
            }
            echo "</table>";

        }

    }

    if ( ! function_exists('detail_deduction'))
    {
        function detail_deduction($empcode)
        {   
            // get a reference to the controller object
            $CI = get_instance();

            //if model has been loaded by controller, you have no to call model anymore
            //$CI->load->model('emp_model');

            //call a fucntion of the model
            // mengacu kepada model yang di load saat controller di akses
            $a = $CI->rpt_slip_lembur->detail_lembur($empcode);
                echo "<table border='1'>
                <tr>
            <th >NIK</th>
            <th >Nama</th>
            <th >Tanggal</th>
            <th width='100' >Kehadiran</th>
            <th width='100' >Overtime</th>
        </tr>
                ";
            foreach ($a as $key) {
                echo "<tr>";
                echo "<td>".$key['empcode']."</td>";
                echo "<td>".$key['empname']."</td>";
                echo "<td>".$key['attd_date']."</td>";
                echo "<td>".$key['attd_code']."</td>";
                echo "<td>".$key['total']."</td>";
                echo "</tr>";

            }
            echo "</table>";
        }

    }
?>