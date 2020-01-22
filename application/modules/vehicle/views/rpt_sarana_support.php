<!DOCTYPE html>
<html>
<head>
	<title>Daftar Asset Sarana Support</title>

<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

table { table-layout: auto;  width: 100%; }
#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 1px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}
#customers td {
	text-align: : auto;
	size: auto;
	width:100%;
}
#customers tr {
	text-align: : auto;
	size: auto;
	width: auto;
}
body {
	font-size: 6px;
}

#customers th {
    padding-top: 2px;
    padding-bottom: 2px;
    width: auto;
    text-align: center;
    background-color: #4CAF50;
    color: white;
}
</style>
</head>
<body>
<!-- 
	<h1>Test</h1>
ini adalah body

<?php echo $bulan; ?>
<br>
<?php echo $tahun; ?>
<br>
<?php echo $print_date; ?>
<br> -->
<center><b><h2>DAFTAR ASSET SARANA SUPPORT</h2></b></center>
<center><b><h4>Period <?php echo date("F",mktime(0,0,0, $bulan, 10)) .' '.$tahun; ?></h4></b></center>

<table id="customers">
	<tr>
		<td rowspan="2">No</td>
		<td rowspan="2">No Polisi</td>
		<td rowspan="2">Code Unit</td>
		<td rowspan="2">NAP</td>
		<td rowspan="2">User</td>
		<td rowspan="2">Departement</td>
		<td rowspan="2">Jenis</td>
		<td rowspan="2">Tahun</td>
		<td rowspan="2">Kepemilikan</td>
		<td rowspan="2">Status Unit</td>
		<td colspan="4">Masa Berlaku</td>
		<td rowspan="2">Keterangan</td>
		<td rowspan="2">Tanggal Penerimaan Unit</td>
		<td rowspan="2">No Rangka</td>
		<td rowspan="2">No Mesin</td>
		<td rowspan="2">Isi Silinder</td>
	</tr>
	<tr>
		<!-- <td>No</td>
		<td>No Polisi</td>
		<td>Code Unit</td>
		<td>NAP</td>
		<td>User</td>
		<td>Departement</td>
		<td>Jenis</td>
		<td>Tahun</td>
		<td>Kepemilikan</td>
		<td>Status Unit</td> -->
		<td>Pajak</td>
		<td>STNK</td>
		<td>KEUR</td>
		<td>Ijin Usaha</td>
		<!-- <td>Keterangan</td>
		<td>Tanggal Penerimaan Unit</td>
		<td>No Rangka</td>
		<td>No Mesin</td>
		<td>Isi Silinder</td> -->
	</tr>
	<?php 
	$no = 1;
	foreach ($list_asset as $key) {
		?>
<tr>
	<td><?php echo $no; ?></td>
	<td><?php echo $key->nomor_plat; ?></td>
	<td><?php echo $key->code_unit; ?></td>
	<td><?php echo $key->nap; ?></td>
	<td><?php echo $key->pic_code; ?></td>
	<td><?php echo $key->pic_code; ?></td>
	<td><?php echo $key->type; ?></td>
	<td><?php echo $key->year; ?></td>
	<td><?php echo $key->ownership; ?></td>
	<td><?php 
	$status_unit = $key->status_unit; 
	if ($status_unit == "rfu") {
		echo "Ready";
	}
	else
	{
		echo "Breakdown";
	}
	 ?></td>
	<td><?php echo date_indonesia($key->pajak); ?></td>
	<td><?php echo date_indonesia($key->stnk); ?></td>
	<td><?php echo date_indonesia($key->keur); ?></td>
	<td><?php echo date_indonesia($key->ijin_usaha); ?></td>
	<td><?php echo $key->remarks; ?></td>
	<td><?php echo date_indonesia($key->date_receive); ?></td>
	<td><?php echo $key->no_frame; ?></td>
	<td><?php echo $key->no_machine; ?></td>
	<td><?php echo $key->cylinder; ?></td>
</tr>
		<?php
		$no++;
	}
	?>

</table>

<table>
	<tr>
		<td width="50">Prepared By</td>
		<td width="50"></td>
		<td width="50">Verificated By</td>
		<td width="50"></td>
		<td width="50">Approved By</td>
	</tr>
	<tr>
		<td height="12"></td>
		<td height="12"></td>
		<td height="12"></td>
		<td height="12"></td>
		<td height="12"></td>
	</tr>

	<tr>
		<td><u><?php echo $prepared_by; ?></u></td>
		<td></td>
		<td><u>SUPATNO</u></td>
		<td></td>
		<td><u>INDRA MUSTARI</u></td>
	</tr>
	<tr>
		<td>GA Dept</td>
		<td></td>
		<td>DEPT HEAD HR-GA</td>
		<td></td>
		<td>SITE MANAGER</td>
	</tr>
</table>

</body>
</html>