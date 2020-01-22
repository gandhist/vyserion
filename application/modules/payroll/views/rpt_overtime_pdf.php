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
  <title>Slip Overtime</title>
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

body {
	font-size: 50%;
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
	  	$empcode = $row['empcode']; 
	  	// ambil tahun
	  	$year = substr($row['attd_date'], 0,4);
	  	$bulan = substr($row['attd_date'], 5,2);
	  	$month = "";
	  	if ($bulan == '') {
	  		$month = 'tidak ada data';
	  	}
	  	if ($bulan == '01') {
	  		$month = '1';
	  	}
	  	if ($bulan == '02') {
	  		$month = '2';
	  	}
	  	if ($bulan == '03') {
	  		$month = '3';
	  	}
	  	if ($bulan == '04') {
	  		$month = '4';
	  	}
	  	if ($bulan == '05') {
	  		$month = '5';
	  	}
	  	if ($bulan == '06') {
	  		$month = '6';
	  	}
	  	if ($bulan == '07') {
	  		$month = '7';
	  	}
	  	if ($bulan == '08') {
	  		$month = '8';
	  	}
	  	if ($bulan == '09') {
	  		$month = '9';
	  	}
	  ?>
	  <table align="center" >
	 	<tr>
	 		<td colspan="5"><center><b><u>PT. PRIMA INDOJAYA MANDIRI</u></b></center></td>
	 		
	 	</tr>
	 	<tr>
	 		
	 		<td colspan="5" align="center"><?php echo "19 February 2018"; ?></td>
	 		
	 	</tr>
	 </table>
	 <hr>
	 <table>
	 <tr>
	 	<td>Nama</td>
	 	<td> : </td>
	 	<td width="140"> <?php echo $row['empname'] ?></td>
	 </tr>
	 <tr>
	 	<td>Bagian</td>
	 	<td> : </td>
	 	<td> <?php echo $row['position_desc'] ?></td>
	 </tr>
	 <tr>
	 	<td>NIK</td>
	 	<td> : </td>
	 	<td> 742/IT-LHT/2018 <?php echo $row['empcode'] ?></td>
	 </tr>
	 <tr>
	 	<td>Dept</td>
	 	<td> : </td>
	 	<td> <?php echo $row['dept_desc'] ?></td>
	 </tr>
	 <tr>
	 	<td>Upah Lembur Perjam</td>
	 	<td> : </td>
	 	<td>Rp.<?php echo substr($row['attd_date'], 5,2); ?></td>
	 </tr>
	 <tr>
	 	<td>Upah Lembur Perjam</td>
	 	<td> : </td>
	 	<td>Rp.<?php echo $month; ?></td>
	 </tr>
	 </table>
<div>
<p><?php detail_overtime($empcode, $month, $year); ?></p>
<?php echo $month; ?>
	 <hr>

</div>

<?php
} 
	 ?>


</body>
</html>