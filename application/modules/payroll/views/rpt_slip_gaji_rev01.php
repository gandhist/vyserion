<!DOCTYPE html>
<html>
<style type="text/css">
    #outtable{
      padding: 10px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 0px;
}
    }
    #headerA {
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
    .floatLeft {float: left;}
.floatRight {width: 50%; height: 20%; float: right; }
.container { overflow: hidden; }
.slip_kehadiran {
	font-size: 30%;
}
.signature{ width: 40px ; height: 40px }
.header { 
      position: fixed; 
      left: 0px; 
      top: 0px; 
      right: 0px; 
      height: 50px; 
     
       }
     .footer { 
      position: fixed; 
      left: 0px; 
      bottom: 40px; 
      right: 0px; 
      height: 20px; 
      background-color: powderblue; }
body {
	font-size: 60%;
}
    tbody tr:nth-child(even){
      background: #F6F5FA;
    }
 
    tbody tr:hover{
      background: #F6F5FA;
    }
  </style>
<head>
  <title>Report Slip Gaji dan Lembur</title>
  <link rel="icon" href="<?php echo base_url('assets/icon/cocoon.png'); ?>">
</head>
<body>
	 <?php

	 foreach ($emp_attrb as $row) {
	  	$id_header = $row->empcode; 
	  ?>
<div id="headerA">
    </div>
	  <table align="center" border="0">
	 	<tr>
	 		<td colspan="5"><center><b><u><?php echo get_app_conf('owner')->owner; ?></u></b></center></td>
	 	</tr>
	 	<tr>
	 	<!-- <td colspan="5" align="center"><?php echo $print_date; echo $bulan ; echo $tahun; ?></td> -->
		<td colspan="5" align="center"><?php echo date("d F Y", strtotime($print_date))." Period : ".$bulan."-".$tahun; ?></td>
	 	</tr>
	 </table>
	 <hr>

	 <table>
	 <tr>
	 	<td>Nama</td>
	 	<td> : </td>
	 	<td width="140"> <?php echo $row->empname ?></td>
	 
	 	<td>Upah Pokok</td>
	 	<td> : </td>
	 	<td align ="right"><?php echo "Rp. ".number_format($row->upah,2,",","."); ?></td>
	 	<td>/ Bulan</td>
	 </tr>
	 <tr>
	 	<td>Bagian</td>
	 	<td> : </td>
	 	<td> <?php echo $row->position_desc ?></td>

	 	<td>Uang Hadir(perhari)</td>
	 	<td> : </td>
	 	<td align ="right"><?php echo "Rp. ".number_format($row->kehadiran_pagi,2,",","."); ?></td>
	 	<td>/ Hari Aktif</td>
	 </tr>
	 <tr>
	 	<td>NIK</td>
	 	<td> : </td>
	 	<td><?php echo $row->nik_pim ?></td>

	 	<td>Upah Hadir(Sebulan)</td>
	 	<td> : </td>
	 	<td align ="right"><?php echo "Rp. ".number_format($row->kehadiran_bulanan,2,",","."); ?></td>
	 	<td></td>
	 </tr>
	 <tr>
	 	<td>Dept</td>
	 	<td> : </td>
	 	<td> <?php echo $row->dept_desc ?></td>

	 	<td>Nilai Lembur Perjam</td>
	 	<td> : </td>
	 	<td align ="right"><?php echo "Rp. ".number_format($row->upah_perjam,2,",","."); ?></td>
	 	<td></td>
	 </tr>
	 <tr>
	 	<td>Grade</td>
	 	<td> : </td>
	 	<td> <?php echo $row->golongan; ?> </td>
	 </tr>
	 </table>
	 <p>Rincian Gaji :</p>
<div>
	<div class="page" >
	<table>
		<tr>
			<td>1.</td>
			<td width="90">Upah Pokok</td>
			<td width="40"></td>		
		 	<td width="70" align ="right"><?php echo "Rp. ".number_format($row->upah,2,",","."); ?></td>
			<td width="20">&nbsp;</td>
			<td>1.</td>
			<td width="90">Jamsostek</td>
		 	<td width="70" align ="right"><?php echo "Rp. ".number_format($row->jamsostek,2,",","."); ?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td></td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->kehadiran_bulanan,2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>JPK</td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->jpk,2,",","."); ?></td>

		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>
			<td></td>
			<td align="right"> -</td>
			<td>&nbsp;</td>
			<td>3.</td>
			<td>Deduction</td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->deduction,2,",","."); ?></td>

		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>
			<td width="40"> <?php echo $row->jam_lembur; ?> Jam</td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->uang_lembur,2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>4.</td>
			<td>Pot. Proporsional </td>
			<td align ="right"><?php echo "Rp. ".number_format($row->pot_prop,2,",","."); ?></td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Insentive Kopi & Snack</td>
			<td></td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->insentive_snack,2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>5.</td>
			<td>Potongan Lain</td>
			<td align ="right">-</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Allowance</td>
			<td></td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->allowance,2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>6.</td>
			<td>Potongan Lain</td>
			<td align ="right">-</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>Uang Makan Puasa</td>
			<td width="40"> <?php echo $row->uang_makan_ramadhan; ?> Hari</td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->total_uang_makan_ramadhan,2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>7.</td>
			<td>Potongan Lain2x</td>
			<td align ="right">-</td>
		</tr>
		<tr>
			<td colspan="3"><center><b> Pendapatan </center> </td>
		 	<td align ="right"><?php echo "Rp. ".number_format($row->total_pendapatan,2,",","."); ?></td>
			<td colspan="3"><b><center>Potongan </center></b></td>
		 	<td align ="right"> <?php echo "Rp. ".number_format($row->total_potongan,2,",","."); ?></td>
			</b>
		</tr>
		<tr>
			<td colspan="3"><center><b> Take Home Pay </center> </td>
		 	<td align ="right"><b><i><u><?php echo "Rp. ".number_format($row->gaji_bersih,2,",","."); ?></b></i></u></td>
			</b>
		</tr>
		
	</table>
	<div class="floatLeft">
	<p><?php detail_overtime($id_header, $bulan, $tahun); ?></p>
	</div>
		 <div class="floatRight">
		 	<table border="1" align="center">
		 		<tr>
		 			<td height="80" align="center"  style="table-layout: fixed; word-wrap:break-word; white-space: normal" width="60" width="60">
		 				<?php echo $row->empname; ?>
		 			</td>
		 			<td width="60"> </td>
		 			<!-- echo substr($row->empname, 0,15); -->
		 		</tr>
		 		<tr>
		 			<td height="60" align="center"><?php echo $hrd; ?></td>
		 			<td> <img height="60" width="60" src="<?php echo base_url().'/upload/qrcode/hr.png';?>"/></td>
		 		</tr>
		 		<tr>
		 			<td height="60" align="center"><?php echo $pm; ?></td>
		 			<td> <img height="60" width="60" src="<?php echo base_url().'/upload/qrcode/pm.png';?>"/></td>
		 		</tr>
		 		<tr>
		 			<td bgcolor='#b7cff4'>OFF</td>
		 		</tr>
		 		<tr>
		 			<td bgcolor='#f44245'>Alpa/Mangkir</td>
		 		</tr>
				 <tr>
				 	<td bgcolor='#bd179f'>Izin</td>
				 </tr>
		 		<tr>
		 			<td bgcolor='#ceb04e'>Sakit</td>
				 </tr>
				 <tr>
					 <td bgcolor='#89ce2f'>Cuti</td>
					 <!-- <strong><?php echo $elapsed_time; ?><strong> Second. -->
				 </tr>
				 <tr>
					 <td bgcolor='#4286f4'>Libur</td>
					 
				 </tr>
				
		 	</table>
		 </div>
		 

	</div>
</div>


</div>



<?php
}
?>


</body>
</html>