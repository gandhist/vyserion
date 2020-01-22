<!-- template login bootstrap -->
<!DOCTYPE html>
<html lang="en">
<head>
<title id="title"><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="-1" />
<link rel="icon" href="<?php echo base_url().get_app_conf('favicon')->favicon; ?>" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/login_assets/style.css">
<script src="<?php echo base_url(); ?>assets/login_assets/d3.v3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/moment/moment.js"></script>

</head>
<body class="bg">

<div class="container">
    <marquee behavior="alternate"><b>Welcome to <?php echo get_app_conf('app_name')->app_name; ?> | <?php echo get_app_conf('owner')->owner; ?> </b></marquee>

  <div class="notif" id="notifikasi">

  </div> <!-- .notif-->

		<div class="left">
		  <center>
      <img src="<?php echo base_url().get_app_conf('logo')->logo; ?>" alt="Viserion" style="border-radius: 5px; width:180px; height:auto;"/>
      </center>
		  <!-- <h5 style = "color: green;">Construction - Earth Moving - Mining </h5> -->
		 
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
    
      </script>
		</div> <!-- .middle -->

		<div class="right">
      <h3 id="title2">Date Today</h3>
      <input type="text" name="time_stamp" id="time_stamp" value="" style="width: 100%; display:none;" >
		  <span class="hidden-xs" id="divLocal"></span>
		  <h3 id="title3">Website</h3>
		  <p id="alamat"><a href="https://niowcode.id/">niowcode.id</a></p>
		  <!-- <h3 id="title4">Head Office- Surabaya</h3>
		  <p id="phone">PT PRIMA INDOJAYA MANDIRI
Jl. Raya dukuh kupang No. 093
SURABAYA – JAWA TIMUR (60225)
Tlp : (031) 5683891</p> -->
		  
		</div>

	<div class="footer">
	  <i>Copyright &copy; <i id="copyright"></i><?php echo get_app_conf('creator')->creator; ?></i><br>
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
      
</body>
</html>