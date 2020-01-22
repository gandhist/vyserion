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
  <title>Report Table</title>
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
	<!-- <?php echo $no; ?> -->
	<!-- <div id="outtable">
	  <table>
	  	<thead>
	  		<tr>
	  			<th class="short">#</th>
	  			<th class="normal">First Name</th>
	  			<th class="normal">Last Name</th>
	  			<th class="normal">Username</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php $no_=10;
	  		$users = 'gandhi';
	  		 ?>
	  		<?php for ($no=0; $no < $no_ ; $no++) { 
	  			# code...
	  		  ?>
	  		  <tr>
	  			<td><?php echo $no; ?></td>
	  			<td><?php echo 'a'; ?></td>
	  			<td><?php echo 'b'; ?></td>
	  			<td><?php echo 'b'; ?></td>
	  		  </tr>
	  		<?php } ?>
	  		
	  	</tbody>
	  </table>
	 </div> -->
	 <?php

	 foreach ($emp_attrb as $row) {
	  	$id_header = $row['empcode']; 
	  ?>
	  <table align="center">
	 	<tr>
	 		<td colspan="5"><center><b><u>PT. PRIMA INDOJAYA MANDIRI</u></b></center></td>
	 		<td></td>
	 		<td></td>
	 		<td></td>
	 		<td></td>
	 	</tr>
	 	<tr>
	 		<td></td>
	 		<td></td>
	 		<td><?php echo "19 February 2018"; ?></td>
	 		<td></td>
	 		<td></td>
	 	</tr>
	 </table>
	 <hr>
	 <br>
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
	 <hr>
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
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td></td>
			<td> Rp.</td>
	
			<td align="right"> <?php echo $row['kehadiran_bulanan'] ?></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>

			<td></td>
			<td> Rp.</td>
	
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>

			<td > <?php echo $row['jam_lembur'] ?> Jam</td>
			
			
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['uang_lembur'] ?></td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Jamsostek</td>

			<td> 3%</td>
			<td> Rp.</td>
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Iuran JPK</td>

			<td> 1.0%</td>
			<td> Rp.</td>

			<td align="right"> -</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>Insentive Kopi & Snack</td>
			<td></td>
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['insentive_snack'] ?></td>
		</tr>
		<tr>
			<td>8.</td>
			<td>Insentive Uang Makan</td>

			<td></td>
			<td> Rp.</td>
			
			<td align="right"> -</td>
		</tr>
		<tr>
			<td colspan="3"><center><b> Total Upah </center> </td>

			
			<td> Rp.</td>
			
			<td align="right"> <?php echo $row['gaji_bersih'] ?></td>
			</b>
		</tr>
		
	</table>
	</div>

	<div class="floatRight">
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
	</div>
<div>

 <p>	 <?php 
/*foreach ($emp_slip as $key) {
	echo $key['empcode'];
	echo $key['empname'];



}*/

	 ?></p></div>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 <br>
	 
<p><?php detail($id_header); ?></p>

</div>

<?php
} 
	 ?>


	 <!-- last known good -->
	<!--  <table align="center">
	 	<tr>
	 		<td colspan="5"><center><b><u>PT. PRIMA INDOJAYA MANDIRI</u></b></center></td>
	 		<td></td>
	 		<td></td>
	 		<td></td>
	 		<td></td>
	 	</tr>
	 	<tr>
	 		<td></td>
	 		<td></td>
	 		<td><?php echo "19 February 2018"; ?></td>
	 		<td></td>
	 		<td></td>
	 	</tr>
	 </table>
	 <hr>
	 <br>
	 <table>
	 <tr>
	 	<td>Nama</td>
	 	<td> : </td>
	 	<td width="140"> Gandhi Saputra Tabrani</td>
	 
	 	<td>Upah Pokok</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td>4.000.000</td>
	 	<td>/ Bulan</td>
	 </tr>
	 <tr>
	 	<td>Bagian</td>
	 	<td> : </td>
	 	<td> Staff IT</td>

	 	<td>Uang Hadir(perhari)</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td>15.000</td>
	 	<td>/ Hari Aktif</td>
	 </tr>
	 <tr>
	 	<td>NIK</td>
	 	<td> : </td>
	 	<td> 742/IT-LHT/2018</td>

	 	<td>Upah Hadir(Sebulan)</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td>105.000</td>
	 	<td></td>
	 </tr>
	 <tr>
	 	<td>Dept</td>
	 	<td> : </td>
	 	<td> IT</td>

	 	<td>Nilai Lembur Perjam</td>
	 	<td> : </td>
	 	<td>Rp.</td>
	 	<td>14.480</td>
	 	<td></td>
	 </tr>
	 </table>
	 <hr>
	 <p>Rincian Gaji :</p>
<div>
	<div class="floatLeft">
	<table>
		<tr>
			<td>1.</td>
			<td width="130">Upah Pokok</td>
			<td width="50"> </td>
			<td> Rp.</td>
	
			<td align="right"> 475.423</td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td></td>
			<td> Rp.</td>
	
			<td align="right"> 105.000</td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>

			<td></td>
			<td> Rp.</td>
	
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>

			<td > 28.5 Jam</td>
			
			
			<td> Rp.</td>
			
			<td align="right"> 412.673</td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Jamsostek</td>

			<td> 3%</td>
			<td> Rp.</td>
			<td align="right"> -</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Iuran JPK</td>

			<td> 1.0%</td>
			<td> Rp.</td>

			<td align="right"> -</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>Insentive Kopi & Snack</td>
			<td></td>
			<td> Rp.</td>
			
			<td align="right"> 35.000</td>
		</tr>
		<tr>
			<td>8.</td>
			<td>Insentive Uang Makan</td>

			<td></td>
			<td> Rp.</td>
			
			<td align="right"> -</td>
		</tr>
		<tr>
			<td colspan="3"><center><b> Total Upah </center> </td>

			
			<td> Rp.</td>
			
			<td align="right"> 1.227.096</td>
			</b>
		</tr>
		
	</table>
	</div>

	<div class="floatRight">
	<table border="1">
		<tr>
			<th >Nama</th>
			<th width="100" >Paraf</th>
		</tr>
		<tr>
			<td width="100" height="30"> Gandhi Saputra Tabrani</td>
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
	</div>
</div> -->




</body>
</html>