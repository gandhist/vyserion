<!-- <!DOCTYPE html>
<html>
<head>
	<title>laporan pdf</title>
</head>
<body>
<pre><?php print_r($dataku); ?></pre>

</body>
<?php echo date("d F Y", strtotime($print_date)); ?>
</html> -->
<!DOCTYPE html>
<html>
<head>
  <title>Report Slip Gaji dan Lembur</title>
 
</head>
<body>

	 <?php

	 foreach ($emp_attrb as $row) {
	  	$id_header = $row->empcode; 
	  ?>
<div id="headerA">
    </div>
	  <table align="center">
	 	<tr>
	 		<td colspan="5"><center><b><u>PT. PRIMA INDOJAYA MANDIRI</u></b></center></td>
	 	</tr>
	 	<tr>
	 		<!-- <td colspan="5" align="center"><?php echo $print_date; echo $bulan ; echo $tahun; ?></td> -->
		<td colspan="5" align="center"><?php echo date("d F Y", strtotime($print_date)) ?></td>

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
	 	<td><?php echo "Rp. ".number_format($row['kehadiran_pagi'],2,",","."); ?></td>
	 	<td>/ Hari Aktif</td>
	 </tr>
	 <tr>
	 	<td>NIK</td>
	 	<td> : </td>
	 	<td><?php echo $row['nik_pim'] ?></td>

	 	<td>Upah Hadir(Sebulan)</td>
	 	<td> : </td>
	 	<td><?php echo "Rp. ".number_format($row['kehadiran_bulanan'],2,",","."); ?></td>
	 	<td></td>
	 </tr>
	 <tr>
	 	<td>Dept</td>
	 	<td> : </td>
	 	<td> <?php echo $row['dept_desc'] ?></td>

	 	<td>Nilai Lembur Perjam</td>
	 	<td> : </td>
	 	<td><?php echo "Rp. ".number_format($row['upah_perjam'],2,",","."); ?></td>
	 	<td></td>
	 </tr>
	 </table>
	 <p>Rincian Gaji :</p>
<div>
	<div class="page">
	<table>
		<tr>
			<td>1.</td>
			<td width="90">Upah Pokok</td>
			<td width="40"></td>		
		 	<td width="70"><?php echo "Rp. ".number_format($row['upah'],2,",","."); ?></td>
			<td width="20">&nbsp;</td>
			<td>1.</td>
			<td width="90">Jamsostek</td>
		 	<td width="70"><?php echo "Rp. ".number_format($row['jamsostek'],2,",","."); ?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Insentive Hadir</td>
			<td></td>
		 	<td><?php echo "Rp. ".number_format($row['kehadiran_bulanan'],2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>2.</td>
			<td>JPK</td>
		 	<td><?php echo "Rp. ".number_format($row['jpk'],2,",","."); ?></td>

		</tr>
		<tr>
			<td>3.</td>
			<td>Insentive HM</td>
			<td></td>
			<td align="right"> -</td>
			<td>&nbsp;</td>
			<td>3.</td>
			<td>Deduction</td>
		 	<td><?php echo "Rp. ".number_format($row['deduction'],2,",","."); ?></td>

		</tr>
		<tr>
			<td>4.</td>
			<td>Overtime</td>
			<td width="40"> <?php echo $row['jam_lembur'] ?> Jam</td>
		 	<td><?php echo "Rp. ".number_format($row['uang_lembur'],2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>4.</td>
			<td>Potongan Lain</td>
			<td>-</td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Insentive Kopi & Snack</td>
			<td></td>
		 	<td><?php echo "Rp. ".number_format($row['insentive_snack'],2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>5.</td>
			<td>Potongan Lain</td>
			<td>-</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Allowance</td>
			<td></td>
		 	<td><?php echo "Rp. ".number_format($row['allowance'],2,",","."); ?></td>
			<td>&nbsp;</td>
			<td>6.</td>
			<td>Potongan Lain</td>
			<td>-</td>
		</tr>
		<tr>
			<td colspan="3"><center><b> Pendapatan </center> </td>
		 	<td><?php echo "Rp. ".number_format($row['total_pendapatan'],2,",","."); ?></td>
			<td colspan="3"><b><center>Potongan </center></b></td>
		 	<td><?php echo "Rp. ".number_format($row['total_potongan'],2,",","."); ?></td>
			</b>
		</tr>
		<tr>
			<td colspan="3"><center><b> Take Home Pay </center> </td>
		 	<td><?php echo "Rp. ".number_format($row['gaji_bersih'],2,",","."); ?></td>
			</b>
		</tr>
		
	</table>
 <p><?php detail_overtime($id_header, $bulan, $tahun); ?></p>
	</div>

</div>
</div>



<?php
}
?>


</body>
</html>