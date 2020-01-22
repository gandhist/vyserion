<!DOCTYPE html>
<html>
<head>
  <title>Rekap Sallary </title>
  <style type="text/css">
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
    }
    #header {
        position: fixed;
        left: 0px; right: 0px; top: 0px;
        text-align: center;
        height: 90px;
      }
      #headerB {
        position: absolute;
        left: -20px; right: -20px; top: -20px;
        text-align: center;
        background-color: orange;
        height: 10px;
      }
      #footer {
        position: fixed;
        left: 0px; right: 0px; bottom: 40px;
        text-align: center;
        background-color: orange;
        height: 40px;
      }
      .page {
page-break-after:always;
position: relative;
}
 
    .short{
      width: 50px;
    }
 
    .normal{
      width: 150px;
    }
    .floatLeft { width: 50%; float: left; }
.floatRight {width: 40%; float: right; }
.container { overflow: hidden; }
.slip_kehadiran {
	font-size: 50%;
}
.header { 
      position: fixed; 
      left: 0px; 
      top: 0px; 
      right: 0px; 
      height: 50px; 
     
       }
     .footer { 
      position: fixed; 
      align-content: center;
      vertical-align: right;
      
      bottom: 40px; 
      right: 100px; 
      height: 20px; 
      /*background-color: powderblue;*/ }
body {
	font-size: 50%;
}
.imgFloatLeft{
	float : left;
	margin-left: 0cm;
}
 
 /*   table{
      border-collapse: collapse;
      font-family: arial;
      color:#5E5B5C;
    }
 
    thead th{
      text-align: left;
      padding: 10px;
    }
 
    tbody td{
      border-top: 1px solid #e3e3e3;
      padding: 10px;
    }*/
 
    /*tbody tr:nth-child(even){
      background: #F6F5FA;
    }
 
    tbody tr:hover{
      background: #EAE9F5
    }*/
  </style>
</head>
<body>
	  <!-- <table align="center" border="0">
	 	<tr>
	 		<td colspan="5"></td>
	 	</tr>
	 	<tr>
	 		<td colspan="5" align="center"><?php echo $print_date; echo $bulan ; echo $tahun; ?></td>
		<td colspan="5" align="center"></td>

	 	</tr>
	 </table> -->
<img height="40" width="40" class="imgFloatLeft" src="<?php echo base_url(); '/assets/company.jpg';?>"/>
	 <center><b><u><?php echo get_app_conf('owner')->owner; ?></u></b></center>
	 <center><?php echo date("d F Y", strtotime($print_date))." Period : ".$bulan."-".$tahun; ?></center>
	 <br>
	 <br>
	 <hr>
	 <div class="page">
	 <table border="1" width="100%">
	 	<tr>
	 		<td width="20">No</td>
	 		<td width="70">NIK</td>
	 		<td width="70">Nama</td>
	 		<td width="50">Departement</td>
	 		<td width="70">Posisi</td>
	 		<td align="right">Upah Pokok</td>
	 		<td>Insentive Kehadiran</td>
	 		<td> Jumlah Hadir</td>
	 		<td> Insentive Kopi & Snack</td>
	 		<td> Insentive HM</td>
	 		<td> Lembur /Jam</td>
	 		<td> Jam Lembur</td>
	 		<td> Overtime</td>
	 		<td> Jamsostek 3%</td>
	 		<td> JPK 1%</td>
	 		<td> Take Home Pay</td>
	 	</tr>
	 	<?php
	 	$no = 1;
	 	foreach ($emp_attrb as $key) {
	 	?>
<tr>
	<td><?php echo $no.'.'; ?></td>
	<td><?php echo $key->nik_pim; ?></td>
	<td><?php echo $key->empname; ?></td>
	<td><?php echo $key->dept_desc; ?></td>
	<td><?php echo $key->position_desc; ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->gaji_setelah_sia,2,",","."); ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->kehadiran_bulanan,2,",","."); ?></td>
	<td align="right"><?php echo $key->hk_dibayar; ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->insentive_snack,2,",","."); ?></td>
	<td align="right">-</td>
	<td align="right"><?php echo "Rp. ".number_format($key->upah_perjam,2,",","."); ?></td>
	<td align="right"><?php echo $key->jam_lembur; ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->uang_lembur,2,",","."); ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->jamsostek,2,",","."); ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->jpk,2,",","."); ?></td>
	<td align="right"><?php echo "Rp. ".number_format($key->gaji_bersih,2,",","."); ?></td>
</tr>
	 	<?php $no++;	
	 	}
	 	?>
	 	<tr>
	 		<?php
foreach ($total as $key) {
	?>
<td colspan="5"><center><b>Total</b></center></td>
	 	
	 		 <td align="right"><?php echo "Rp. ".number_format($key->total_basic_pot_prop,2,",","."); ?></td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->insentive_hadir,2,",","."); ?></td>
	 		<td align="right"><?php echo $key->jumlah_hadir; ?></td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->insentive_kopi_snack,2,",","."); ?></td>
			<td align="right">-</td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->lembur_per_jam,2,",","."); ?></td>
	 		<td align="right"><?php echo $key->jam_lembur; ?></td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->overtime,2,",","."); ?></td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->jamsos,2,",","."); ?></td>
	 		<td align="right"><?php echo "Rp. ".number_format($key->jpk,2,",","."); ?></td>
	 		<td align="right"><i><b><u><?php echo "Rp. ".number_format($key->total_gaji_bersih,2,",","."); ?></u></b></i></td>
	 		<!-- <td align="right">Rp.618.535.000,00</td>
	 		<td align="right">Rp.66.940.000,00</td>
	 		<td align="right">5503</td>
	 		<td align="right">Rp.27.515.000,00</td>
			<td align="right">-</td>
	 		<td align="right">Rp.3.575.260,00</td>
	 		<td align="right">27499.5</td>
	 		<td align="right">Rp.425.630.218,00</td>
	 		<td align="right">Rp.18.556.050,00</td>
	 		<td align="right">Rp.5.996.760,00</td>
	 		<td align="right"><i><b><u>Rp.1.110.464.329,00</u></b></i></td> -->
	<?php
}
	 		 ?>
	 		<!-- <td colspan="6"><center><b>Total</b></center></td>
	 		<td>Basic Sallary</td>
	 		<td>Uang Kehadiran</td>
	 		<td>Potongan</td>
	 		<td>Allowance</td>
	 		<td>Jamsostek</td>
	 		<td>Uang Kehadiran Bulanan</td>
	 		<td>Uang Lembur</td>
	 		<td>Insentive Snack & Kopi</td>
	 		<td>Total Pendapatan</td>
	 		<td>Gaji Bulan Ini</td> -->
	 	</tr>
	 </table>
	 <br>
	 <table>
	 		<tr>
	 			<td width="40">Prepared By,</td>
	 			<td width="40">Verivied By,</td>
	 			<td width="40">Approve by,</td>
	 		</tr>
	 		<tr>
	 			<td height="30"></td>
	 			<td height="30"></td>
	 			<td height="30"></td>
	 		
	 		</tr>
	 		<tr>
	 			<td>Widya Wilyawati</td>
	 			<td>Indra Mustari</td>
	 			<td>Ricky Virman Lee</td>
	 		</tr>
	 		
	 	</table>
	 </div>
	 	
	 


</body>
</html>