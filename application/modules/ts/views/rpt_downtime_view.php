<!DOCTYPE html>

<html>
<head>
	<title>REPORT HISTORY DOWNTIME TANGGAL <?php echo $start_date. ' s/d '. $end_date ?></title>
	<link rel="icon" href="<?php echo base_url('assets/icon/cocoon.png'); ?>">

	<style>
	@media print {
  #spacer {height: 2em;} /* height of footer + a little extra */
  #footer {
    position: fixed;
    bottom: 0;
  }
}
	@page {
		margin: 0cm 0cm;
	}
	header {
		position: fixed;
		top: 1.5cm;
		left: 0cm;
		right: 0cm;
		height: 20cm;
	}
	footer {

position: fixed;
bottom: 2cm;
left: 1cm;
right: 1cm;
margin-right: 1cm;
margin-top: 0cm;
height: 0.9cm;
	}
#bawah{
float: right;
margin-left: 2cm;
bottom: 0cm;
left: 10cm;
right: 0cm;
/*height: 15cm;*/

	}
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

/*table { table-layout: auto;  width: 100%; }*/
#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 2px;

	word-break:break-all;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}
/*#customers td {
	text-align: : auto;
	size: auto;
	width:100%;*/
}
#customers tr {
	text-align: : auto;
	size: auto;
	width: auto;
}
body {
	font-size: 9px;
	margin-top: 1.5cm;
	margin-left: 1cm;
	margin-right: 1cm;
	margin-bottom: 4cm;
}
.page {
	page-break-after: always;
	position: relative;
}

#customers th {
    padding-top: 1px;
    padding-bottom: 1px;
    width: auto;
    text-align: center;
    background-color: #4CAF50;
    color: white;
}
.floatLeft{
	float: left;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
.floatRightTtd{


	float: right;
	margin-bottom: 0cm;
	margin-left: 0cm;
	margin-right: 3cm;
	margin-top: 12cm;
}
.imgFloatLeft{
	float : left;
	margin-left: 2cm;
}


.floatRight { float: right; margin-bottom: 2cm; }
a:link{
    background-color: #ffaf10;
    color: white;
    padding: 8px 8px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}
</style>
</head>
<body>


<img height="55" width="48" class="imgFloatLeft" src="<?php echo base_url(); '/assets/company.jpg';?>"/>
<center> 
	<!-- <h2>PT PRIMA INDOJAYA MANDIRI</h2> --> 
<h2>SUMMARY DATA REPORT</h2>
<?php date_default_timezone_set('asia/jakarta'); echo date("l,d F Y h:i:s"); ?>
</center>
</header>
<br>
<br>
<footer>
	<!-- <table align="left">
		 		<tr >
		 			<td >Keterangan :</td>
		 			
		 		</tr>
		 			<tr>
		 			<td >BD1 : Dalam proses analisa technical support</td>
		 			</tr>
		 			<tr>
		 			<td >BD2 : Dalam proses tunggu sparepart/order parts</td>
		 			</tr>
		 			<tr>
		 			<td >BD3 : Dalam proses pengerjaan workshop</td>
		 			</tr>
		 			<tr>
		 			<td >BD4 : Dalam proses menunggu alat bantu lain dalam pengerjaan</td>
		 			</tr>
		 		
		 	</table> -->
		 	
	<table width="25%" align="right">
		 		<tr >
		 			<td width="1cm" align="center" >Issued By</td>
		 			<td width="1cm" align="center" >Verivication By</td>
		 			<td width="1cm" align="center" >Approved By</td>
		 		</tr>
		 		<tr>
		 			<td height="1.5cm"><img height="60" width="60" src="<?php echo base_url(); '/upload/qrcode/'.$qr_name.'.png';?>"/></td>
		 			<td height="1.5cm"></td>
		 			<td height="1.5cm"></td>
		 		</tr>
		 		<tr>
		 			<td align="left" >Nama : </td>
		 			<td align="left" >Nama : </td>
		 			<td align="left">Nama : </td>
		 		</tr>
		 		<tr>
		 			<td align="left" >Tanggal : </td>
		 			<td align="left" >Tanggal : </td>
		 			<td align="left">Tanggal : </td>
		 		</tr>
		 	</table>
		 	<!-- Date Range : <?php echo $start_date. " Between ". $end_date ; ?>
		 	Code Unit : <?php echo $code_unit; ?>
		 	Type : <?php echo $type; ?>
		 	Status BD : <?php echo $status_bd; ?>
		 	Status Level : <?php echo $status_level; ?>
		 	Rpt Type : <?php echo $rpt_type; ?> -->

</footer>



<main>
<div class="page">

<table id="customers" style="table-layout: 100%">
	<tr style="color: #333; font-weight:bold; font-size: 8px; text-align: center">
		<td bgcolor='#ffaf10' width="1.1%">No </td>
		<td bgcolor='#ffaf10' width="3.1%">Unit </td>
		<td bgcolor='#ffaf10' width="4.2%" style="word-break:break-all; word-wrap:break-word;">SN Unit </td>
		<td bgcolor='#ffaf10' width="1.7%">NAP </td>
		<td bgcolor='#ffaf10' width="10%">Problem Occured/Remarks </td>
		<td bgcolor='#ffaf10' width="3.2%">Status </td>
		<td bgcolor='#ffaf10' width="2%">HM/KM </td>
		<td bgcolor='#ffaf10' width="4%">Time Breakdown </td>
		<td bgcolor='#ffaf10' width="2.5%">Status Damage </td>
		<td bgcolor='#ffaf10' width="4%">Time RFU </td>
		<td bgcolor='#ffaf10' width="1.6%">PA % </td>
		<td bgcolor='#ffaf10' width="1.6%">UA % </td>
		<td bgcolor='#ffaf10' width="1.6%">MA % </td>
		<td bgcolor='#ffaf10' width="1.8%">THR </td>
		<td bgcolor='#ffaf10' width="1.3%">TDY </td>
		<td bgcolor='#ffaf10' width="1.3%">WH </td>
		<!-- <td width="2.5%">PW </td>
		<td width="3%">Status Level </td> -->
		<td bgcolor='#ffaf10' width="3.2%">Schedule </td>
		<td bgcolor='#ffaf10' width="6%">Progress By </td>
		<!-- <td width="4%">Date Est Finish </td>
		<td width="4%">Status Parts </td>
		<td width="4%">No PO </td>
		<td width="4%">No PR/SR </td> -->
		<!-- <td style="word-wrap: break-word;">Reason </td> -->
	</tr>
	<?php 

	?>
	 <?php $no =1; foreach ($data_bd as $key) {
		?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $key->code_unit; ?></td>
		<td style="word-break:break-all; word-wrap:break-word;"><?php echo $key->serial_number; ?></td>
		<td><?php echo $key->nap; ?></td>
		<td><?php echo $key->remarks_machine; ?></td>
		<?php if ($key->status_bd == "CLOSED" || is_null($key->status_bd)) {
			echo "<td><font color='black'>OPERASI</font>";
		}
		else{
			echo "<td bgcolor='#d60e1e'><font color='white'> BREAKDOWN</font>";
		} ?></td>
		<td align="right"><?php echo number_format($key->hm,0, ", " ,"."); ?></td>
		<td><?php echo date_indonesia_datetime($key->date_start); ?></td>
		<td><?php echo $key->status_damage; ?></td>
		<td><?php echo date_indonesia_datetime($key->date_finished); ?></td>
		<td><?php echo $key->pa_gab; ?></td>
		<td><?php echo $key->ua_gab; ?></td>
		<td><?php echo $key->ma_gab; ?></td>
		<td><?php echo $key->jam_bd; ?></td>
		<!-- <td><?php echo $key->downtime; ?></td> -->
		<td><?php echo $key->hari_bd; ?></td>
		<td><?php echo $key->wh; ?></td>
		<!-- <td><?php echo $key->status_level; ?></td> -->
		<td><?php echo $key->schedule; ?></td>
		<td><?php echo $key->progress_by; ?></td>
		<!-- <td><?php echo $key->date_finish_estimate; ?></td>
		<td><?php echo $key->status_parts_job; ?></td>
		<td><?php echo $key->no_po; ?></td>
		<td><?php echo $key->no_pr_sr; ?></td> -->
		<!-- <td style="word-wrap: break-word;"><?php echo $key->reason_bd; ?></td> -->
	</tr>
	<?php
	$no++;
	} 
	?> 
</table>
</div>
</main>

<div class="page" style="page-break-after: never;">
	<h1> Details Unit Breakdown </h1>
	
	<table id="customers" style="table-layout: 100%">
		<tr style="color: #333; font-weight:bold; font-size: 8px; text-align: center">
			<td bgcolor='#ffaf10' width="1%">No </td>
			<td bgcolor='#ffaf10' width="4%">Code Unit </td>
			<td bgcolor='#ffaf10' width="3.4%" style="word-break:break-all; word-wrap:break-word;">SN Unit</td>
			<td bgcolor='#ffaf10' width="1.5%">NAP </td>
			<td bgcolor='#ffaf10' width="3.2%">Time BD</td>
			<td bgcolor='#ffaf10' width="2%">HM/KM</td>
			<td bgcolor='#ffaf10' width="1.8%">THR </td>
			<td bgcolor='#ffaf10' width="1.8%">TDY </td>
			<td bgcolor='#ffaf10' width="2%">Status Level</td>
			<td bgcolor='#ffaf10' width="3.2%">Date Est Finish </td>
			<td bgcolor='#ffaf10' width="6%">Progress By </td>
			<td bgcolor='#ffaf10' width="3%">Status Parts </td>
			<td bgcolor='#ffaf10' width="5.5%">No PO </td>
			<td bgcolor='#ffaf10' width="7%">No PR/SR </td>
			<td bgcolor='#ffaf10' width="14%">Reason Of Breakdown </td>
		</tr>
		<?php 
		$no = 1;
		foreach ($data_bd_det as $key) {
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $key->code_unit; ?></td>
				<td style="word-break:break-all; word-wrap:break-word;"><?php echo $key->serial_number; ?></td>
				<td><?php echo $key->nap; ?></td>
				<td><?php echo date_indonesia($key->date_start); ?></td>
				<td align="right"><?php echo number_format($key->hm,0, ", " ,"."); ?></td>
				<td><?php echo $key->jam_bd; ?></td>
				<td><?php echo $key->hari_bd; ?></td>
				<td><?php echo $key->status_level; ?></td>
				<td><?php echo date_indonesia($key->date_finish_estimate); ?></td>
				<td><?php echo $key->progress_by; ?></td>
				<td><?php echo $key->status_parts_job; ?></td>
				<td style="word-break:break-all; word-wrap:break-word;" ><?php echo $key->no_po; ?></td>
				<td style="word-break:break-all; word-wrap:break-word;" ><?php echo $key->no_pr_sr; ?></td>
				<td style="word-break:break-all; word-wrap:break-word;" > <?php echo $key->reason_bd; ?></td>
			</tr>

			<?php
			$no++;
		}

		?>
	</table>
	<br>


<!-- table gagal produk hHAHAHAHAHAH	 <table width="25%" align="right">
		 		<tr >
		 			<td width="1cm" align="center" >Issued By</td>
		 			<td width="1cm" align="center" >Verivication By</td>
		 			<td width="1cm" align="center" >Approved By</td>
		 		</tr>
		 		<tr>
		 			<td height="1.5cm"></td>
		 			<td height="1.5cm"></td>
		 			<td height="1.5cm"></td>
		 		</tr>
		 		<tr>
		 			<td align="left" >Nama : Masayu</td>
		 			<td align="left" >Nama : Sugiono</td>
		 			<td align="left">Nama : Ricky Virman Lee</td>
		 		</tr>
		 		<tr>
		 			<td align="left" >Tanggal : </td>
		 			<td align="left" >Tanggal : </td>
		 			<td align="left">Tanggal : </td>
		 		</tr>
		 	</table> -->
</div>
<div id="footer">
<a href="https://sis.cat.com/sisweb" target="_top" style="color: #333; font-weight:bold; font-size: 10px; text-align: center">Link to SIS</a>
<a href="https://trakindo.cat.com/DSFUnbundled/login.do" target="_self" style="color: #333; font-weight:bold; font-size: 10px; text-align: center">Link to PartStore</a>
<a href="http://sos.trakindo.co.id/equipcom/login.aspx" target="_blank" style="color: #333; font-weight:bold; font-size: 10px; text-align: center">Link to SOS</a>
<a href="https://identity.trimble.com/authenticationendpoint/login.do?client_id=OgGSo9vcAkaqldhizQJKcUDbtmwa&commonAuthCallerPath=%2Foauth2%2Fauthorize&forceAuth=false&lang=undefined&passiveAuth=false&redirect_uri=https%3A%2F%2Fwww.myvisionlink.com%2F&response_type=token&scope=openid&tenantDomain=trimble.com&sessionDataKey=3ba31a28-4be7-4800-b72f-c0ef5a18ddc3&relyingParty=OgGSo9vcAkaqldhizQJKcUDbtmwa&type=oidc&sp=Prod-VisionLink-NGWelcome&isSaaSApp=true&authenticators=ExtendedOIDCAuthenticator:HitachiIDP;DomainAwareSubjectAuthenticator:Kiewit:Caterpillar;ExtendedBasicAuthenticator:LOCAL:LOCAL" target="_blank" style="color: #333; font-weight:bold; font-size: 10px; text-align: center">Link to VisionLink</a>
</div>
<div id="footer" style="float:left;">
<table align="left" style="float:left; font-size: 8px;">
		 		<tr >
		 			<td >Keterangan :</td>
		 			
		 		</tr>
		 			<tr>
		 			<td >BD1 : Dalam proses analisa technical support</td>
		 			</tr>
		 			<tr>
		 			<td >BD2 : Dalam proses tunggu sparepart/order parts</td>
		 			</tr>
		 			<tr>
		 			<td >BD3 : Dalam proses pengerjaan workshop</td>
		 			</tr>
		 			<tr>
		 			<td >BD4 : Dalam proses menunggu alat bantu lain dalam pengerjaan</td>
		 			</tr>
		 		
		 	</table>
</div>
<!-- <br>
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




<table class="floatRightTtd" style="float: right;" border="1" width="20%" align="center">
		 		<tr>
		 			<td >Issued By</td>
		 			<td >Verivication By</td>
		 			<td >Approved By</td>
		 		</tr>
		 		<tr>
		 			<td>Masayu</td>
		 			<td>Sugiono</td>
		 			<td>Ricky Virman Lee</td>
		 		</tr>
		 	</table> -->

</body>
</html>