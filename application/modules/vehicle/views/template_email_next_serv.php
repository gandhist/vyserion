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
<title>Template Email Next Service</title>
</head>
<body>

<h4>Dear General Affairs Departement PT. Prima Indojaya Mandiri site Lahat</h4>

<p>Berikut ini adalah daftar Unit Kendaraan / Sarana yang <b>Mendekati Next Services</b></p>

<table id="customers">
<tr>
    <td>No</td>
    <td>NAP</td>
    <td>Nomor Plat</td>
    <td>Code Unit</td>
    <td>KM Terakhir</td>
    <td>Tanggal</td>
    <td>Next Service</td>
    <td>Sisa KM</td>
</tr>

<?php 
$no = 1;
    foreach ($email as $key) {
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $key->nap; ?></td>
    <td><?php echo $key->nomor_plat; ?></td>
    <td><?php echo $key->code_unit; ?></td>
    <td><?php echo $key->max_km." KM"; ?></td>
    <td><?php echo date_indonesia($key->tanggal); ?></td>
    <td><?php echo $key->next_service." KM"; ?></td>
    <td><?php echo $key->sisa; ?></td>
</tr>
<?php
    $no++;
/*$awal = $key->start_date;
$ahir = $key->end_date;
$diff = date_diff($awal, $ahir);
echo $diff;
*/

}
/*$date1=date_create("2013-03-15");
$date2=date_create("2013-12-12");
$diff=date_diff($date1,$date2);
echo $diff->format("%R%a days");*/

?>

</table>
<br><br><br><br>
<b>Email Ini dikirim pada <?php echo date("d-m-Y H:i:s"); ?></b>
<p>Note : </p>
<i>Email Ini Terkirim Otomatis, harap tidak untuk membalas email ini.</i>
</body>
</html>