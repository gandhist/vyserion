<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('slip_kehadiran_helper'))
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
            <th width='100' >Overtime</th>
        </tr>";
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
                echo "<table border='1' class='slip_kehadiran'>
                <tr>
            <th >No</th>
            <th >NIK</th>
            <th width='200' >Nama</th>
            <th width='60' >Tanggal</th>
            <th >Kehadiran</th>
            <th >Overtime</th>
            <th width='100' >Upah</th>
        </tr>
                ";
                $no = 1;
            foreach ($a as $key) {
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$key['empcode']."</td>";
                echo "<td>".$key['empname']."</td>";
                echo "<td>".$key['attd_date']."</td>";
                echo "<td>".$key['attd_code']."</td>";
                echo "<td>".$key['overtime']."</td>";
                echo "<td>".$key['total']."</td>";
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