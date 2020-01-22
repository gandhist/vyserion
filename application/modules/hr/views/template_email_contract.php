<!DOCTYPE html>
<html>
<head>
    <style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: auto;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 5px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>

</head>
<body>

<h4>Dear Team HRD PT. Prima Indojaya Mandiri</h4>

<p>Berikut ini adalah daftar nama karyawan yang habis kontrak dalam <b>7 Hari kedepan</b></p>

<table id="customers">
<tr>
	<td>No</td>
    <td>Nik</td>
    <td>Nama</td>
    <td>Status Kotrak</td>
    <td>Tanggal Awal</td>
    <td>Tanggal Akhir</td>
    <td>Due Date</td>
</tr>

<?php 
$no = 1;
    foreach ($email as $key) {
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $key->nik_pim; ?></td>
    <td><?php echo $key->empname; ?></td>
    <td><?php echo $key->employeetype; ?></td>
    <td><?php echo date_indonesia($key->start_date); ?></td>
    <td><?php echo date_indonesia($key->end_date); ?></td>
    <td><?php echo $key->due_date; ?></td>
</tr>
<?php
    $no++;
/*$awal = $key->start_date;
$ahir = $key->end_date;
$diff = date_diff($awal, $ahir);
echo $diff;
*/

}
$date1=date_create("2013-03-15");
$date2=date_create("2013-12-12");
$diff=date_diff($date1,$date2);

?>

</table>
<br><br><br><br>
<b>Kontrak Notifikasi Ini dikirim pada <?php echo date("Y-m-d H:i:s"); ?></b>
<p>Note : </p>
<i>Jika duedate nya minus (-) berarti kontrak sudah expierd dan belum di closed dari system</i>
<br>
<i>Email Ini Terkirim Otomatis, harap tidak untuk membalas email ini.</i>
</body>
</html>