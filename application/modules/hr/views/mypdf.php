<!DOCTYPE html>

<html>

<head>

	<title>Codeigniter 3 - Generate PDF from view using dompdf library with example</title>

</head>

<body>

<!-- 
<h1>Codeigniter 3 - Generate PDF from view using dompdf library with example</h1> -->

<table style="border:1px solid red;width:100%;">

	<tr>

		<th style="border:1px solid red">Id</th>

		<th style="border:1px solid red">Name</th>

		<th style="border:1px solid red">Email</th>

	</tr>

	<tr>

		<td style="border:1px solid red"><?php echo $empcode ?></td>

		<td style="border:1px solid red"><?php echo $empname ?></td>

		<td style="border:1px solid red"><?php echo $empcoda ?></td>

	</tr>

	<tr>

		<td style="border:1px solid red">2</td>

		<td style="border:1px solid red">Paresh</td>

		<td style="border:1px solid red">paresh@gmail.com</td>

	</tr>

</table>

<?php 
	foreach ($query_lembur as $detail) {
			echo $detail['empcode'];
			echo $detail['empname'];
			echo $detail['attd_date'];
		}

?>
</body>

</html>