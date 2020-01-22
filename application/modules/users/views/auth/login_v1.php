<!DOCTYPE html>
<!-- code by webdevtrick ( https://webdevtrick.com ) -->

<html>
<head>
  <meta charset="UTF-8">
  <!-- <title>ERROR 404</title> -->
  <title id="title"><?php echo $title; ?></title>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/login_v1/particles.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
  
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login_v1/style.css">
      <link rel="icon" href="<?php echo base_url(); ?>assets/icon/cocoon.png" />
      <script src="<?php echo base_url(); ?>assets/moment/moment.js"></script>
  
</head>

<body >
  <div id="particles-js">
  <canvas class="particles-js-canvas-el"  style="width: 100%; height: 100%;">
  </canvas>
</div>
<div class="container">

<div class="shit"></div>
  <div class="notif" id="notifikasi">

  </div> <!-- .notif-->

 <marquee behavior="alternate"><b style="color: white;">Welcome to HRIS PT. PRIMA INDOJAYA MANDIRI Site LAHAT</b></marquee>

<div class="left">
      <!-- <center><img src="img/logo.png" alt="kemangi 41" style="border-radius: 5px; width:200px; height:auto;"/><br></center> -->
      <!-- <h3>DUMBASS!!</h3> -->
      <!-- <div class="tab">
        <button class="tablinks" onclick="openLogin(event, 'KV')" id="kodevoucher">Login</button>
        <button class="tablinks" onclick="openLogin(event, 'UP')" id="userpass">Member</button>
      </div> -->
      <center><img src="<?php echo base_url(); ?>assets/company.jpg" alt="HRIS" style="border-radius: 5px; width:180px; height:auto;"/></center>
		  <h5 style = "color: green;">Construction - Earth Moving - Mining </h5>
  </div>

<div class="middle">
<h3><?php echo $title; ?></h3>
      <center>
      <table id="paketwifi" align="center" class="tpaketwifi"></table>
      <p class="login-box-msg">Sign in to start your session</p>
      <div id="infoMessage"><?php echo $message;?></div>
      <!-- Login 1 kolom-->
          <div>
            <center>
              <br>
            <form name="login" action="<?php echo base_url('auth/login'); ?>" method="post">
              <input id="user" name="identity" type="text" placeholder="Username" onchange="" value=""/>
              <input id="pass" name="password" placeholder="Password" type="password" onchange="" value=""/>
              <input type="checkbox" name="remember" value="1"  id="remember"> Remember Me
              <input type="submit" class="buttona" name="submit" value=" Login " />
              </form>
  
              </center>
          
          </div>
      </center>
    </div> <!-- .middle -->

    <div class="right">
    <h3 id="title2">Date Today</h3>
      <input type="text" name="time_stamp" id="time_stamp" value="" style="width: 100%; display:none;" >
		  <span class="hidden-xs" id="divLocal"></span>
		  <h3 id="title3">Site BAU- Lahat</h3>
		  <p style="color:black;" id="alamat">Perumnas Kavling Block A, No. 22 Kelurahan Bandar Jaya, Kab. Lahat (31414)  Tlp: (0731) 323428</p>
		  <h3 id="title4">Head Office- Surabaya</h3>
		  <p id="phone">PT PRIMA INDOJAYA MANDIRI
Jl. Raya dukuh kupang No. 093
SURABAYA – JAWA TIMUR (60225)
Tlp : (031) 5683891</p>
      
    </div>

    <div class="footer">
    <i>Copyright &copy; <i id="copyright"></i>Gandhi</i><br>
  </div>


</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
   /*fungsi untuk membuat tanggal dan jam*/

  $(document).ready(function() {
/*fungsi untuk mendapatkan timestamp intuk input dan update*/

/*fungsi untuk mendapatkan timestamp intuk input dan update*/


               /*real time now*/
  //$('#real_time').moment().format('D M YYYY, h:mm:ss a');
setInterval(function(){


var divLocal = $('#divLocal');
local = moment().format('ddd, DD MMMM YYYY, H:mm:ss A');
divLocal.text(local);

},1000);
          });
/* end of fungsi untuk membuat tanggal dan jam*/
      </script>

    <script  src="<?php echo base_url(); ?>assets/login_v1/function.js"></script>
</body>
</html>