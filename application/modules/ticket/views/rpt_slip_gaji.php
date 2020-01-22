<!-- <!DOCTYPE html>
<html>
<head>
	<title>laporan pdf</title>
</head>
<body>
<pre><?php print_r($dataku); ?></pre>

</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
  <title>Report </title>
  <style type="text/css">
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
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
 
    tbody tr:nth-child(even){
      background: #F6F5FA;
    }
 
    tbody tr:hover{
      background: #EAE9F5
    }
  </style>
</head>
<body>
	 <?php

	 foreach ($emp_attrb as $row) {
	  	$id_header = $row['empcode']; 
	  ?>
	  <table align="center">
	 	<tr>
	 		<td colspan="5"><center><b><u>PT. PRIMA INDOJAYA MANDIRI</u></b></center></td>
	 	</tr>
	 	<tr>
	 		<!-- <td colspan="5" align="center"><?php echo $print_date; echo $bulan ; echo $tahun; ?></td> -->
		<td colspan="5" align="center"><?php echo date("d M Y", strtotime($print_date)) ?></td>

	 	</tr>
	 </table>
	 <hr>

	 <table>
	 <tr>
	 	<td>Nama</td>
	 	<td> : </td>
	 	<td width="140"> <?php echo $row['empname'] ?></td>
	 
	 	<td>Upah Pokok</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td><?php echo $row['upah'] ?></td>
	 	<td>/ Bulan</td>
	 </tr>
	 <tr>
	 	<td>Bagian</td>
	 	<td> : </td>
	 	<td> <?php echo $row['position_desc'] ?></td>

	 	<td>Uang Hadir(perhari)</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td><?php echo $row['kehadiran_pagi'] ?></td>
	 	<td>/ Hari Aktif</td>
	 </tr>
	 <tr>
	 	<td>NIK</td>
	 	<td> : </td>
	 	<td> 742/IT-LHT/2018 <?php echo $row['empcode'] ?></td>

	 	<td>Upah Hadir(Sebulan)</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td><?php echo $row['kehadiran_bulanan'] ?></td>
	 	<td></td>
	 </tr>
	 <tr>
	 	<td>Dept</td>
	 	<td> : </td>
	 	<td> <?php echo $row['dept_desc'] ?></td>

	 	<td>Nilai Lembur Perjam</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td><?php echo $row['upah_perjam']; ?></td>
	 	<td></td>
	 </tr>
	 </table>
	 <p>Rincian Gaji :</p>
<div>
	<div class="floatLeft">
	<table>
		<tr>
			<td>1.</td>
			<td width="130">Upah Pokok</td>
			<td width="50"> </td>
			<td> Rp.</td>
	
			<td align="right"> <?php echo $row['upah'] ?></td>
			<td width="20">&nbsp;</td>
			<td>1.</td>
			<td width="130">Jamsostek</td>
			<td>Rp.</td>
			<td align="right"><?php echo $row['jamsostek'] ?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td></td>
			<td> Rp.</td>
			<td align="right"> <?php echo $row['kehadiran_bulanan'] ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>JPK</td>
			<td>Rp.</td>
			<td align="right"><?php echo $row['jpk'] ?></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>
			<td></td>
			<td> Rp.</td>
			<td align="right"> -</td>
			<td>&nbsp;</td>
			<td>3.</td>
			<td>Deduction</td>
			<td>Rp.</td>
			<td><?php echo $row['deduction'] ?></td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>
			<td > <?php echo $row['jam_lembur'] ?> Jam</td>
			<td> Rp.</td>
			<td align="right"> <?php echo $row['uang_lembur'] ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>Potongan Lain</td>
			<td>Rp.</td>
			<td>-</td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Insentive Kopi & Snack</td>
			<td></td>
			<td> Rp.</td>
			<td align="right"> <?php echo $row['insentive_snack'] ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>Potongan Lain</td>
			<td>Rp.</td>
			<td>-</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Allowance</td>
			<td></td>
			<td> Rp.</td>
			<td align="right"> <?php echo $row['allowance']; ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>Potongan Lain</td>
			<td>Rp.</td>
			<td>-</td>
		</tr>
		<tr>
			<td colspan="3"><center><b> Pendapatan </center> </td>
			<td> Rp.</td>
			<td align="right"><b> <?php echo $row['total_pendapatan'] ?></b></td>
			
			

			<td colspan="3"><b><center>Potongan </center></b></td>
			<td>Rp</td>
			<td><b><?php echo $row['total_potongan'] ?></b></td>
			</b>
		</tr>
		<tr>
			<td colspan="3"><center><b> Take Home Pay </center> </td>
			<td> Rp.</td>
			<td align="right"><u><b> <?php echo $row['gaji_bersih'] ?></b></u></td>
			</b>
		</tr>
		
	</table>
	</div>
	<!-- <div class="floatRight">
		<table border="1">
		<tr>
			<th >Nama</th>
			<th width="100" >Paraf</th>
		</tr>
		<tr>
			<td width="100" height="30"> <?php echo $row['empname'] ?></td>
			<td width="100" height="30"></td>
		</tr>
		<tr>
			<td width="100" height="30"> Nugraha Marsosa</td>
			<td width="100" height="30"></td>
		</tr>
		<tr>
			<td width="100" height="30"> Indra Mustari</td>
			<td width="100" height="30"></td>
		</tr>
	</table>
		 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <p> </p>
	</div> -->

<!-- 	<div class="floatRight">
	<table>
		<tr>
			<td>1.</td>
			<td width="130">Upah Pokok</td>
			<td> Rp.</td>
	
			<td align="right"> <?php echo $row['upah'] ?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td> Rp.</td>
	
			<td align="right"> <?php echo $row['kehadiran_bulanan'] ?></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>

			<td> Rp.</td>
	
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['uang_lembur'] ?></td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Jamsostek</td>
			<td> Rp.</td>
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Iuran JPK</td>
			<td> Rp.</td>

			<td align="right"> -</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>Insentive Kopi & Snack</td>
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['insentive_snack'] ?></td>
		</tr>
		<tr>
			<td>8.</td>
			<td>Insentive Uang Makan</td>

			<td> Rp.</td>
			
			<td align="right"> -</td>
		</tr>
		<tr>
			<td colspan="2"><center><b> Total Upah </center> </td>

			
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['gaji_bersih'] ?></td>
			</b>
		</tr>
		
	</table>
	</div> -->

	

	 <!-- hilangkan remarks jika akan menampilkan detail lembur -->
<!-- <p><?php detail($id_header); ?></p> -->


</div>
	 


<?php
} 
	 ?>


</body>
</html>