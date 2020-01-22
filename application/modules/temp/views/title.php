<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo  get_app_conf('app_name')->app_name.' - '.get_modul_name(); ?></title>
  <link rel="icon" href="<?php echo base_url('assets/icon/cocoon.png'); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.css">
  <!-- DataTables -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dt/dataTables.bootstrap.min.css">
  <!-- date picker 3 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dt/bootstrap-datepicker3.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->

       <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/pace/pace.min.css">

       <!-- moment js -->
  <script src="<?php echo base_url(); ?>assets/moment/moment.js"></script>
  
  <script src="<?php echo base_url(); ?>assets/moment/moment.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.dataTables.min.css"></script> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/export_button/buttons.dataTables.min.css">

 
<script src="<?php echo base_url() ?>assets/bower_components/chart.js/Chart.bundle.js"></script>
  <script src="<?php echo base_url() ?>assets/bower_components/chart.js/utils.js"></script>

  <!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- jquery hotkeys -->
  <!-- <script src="<?php echo base_url() ?>assets/hotkey/jquery.hotkeys.js"></script> -->
  <style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<!-- change modal size -->
<style type="text/css">
    @media screen and (min-width: 768px) {
        .modal-dialog {
          width: 1300px; /* New width for default modal */
        }
        .modal-sm {
          width: 350px; /* New width for small modal */
        }
    }
    @media screen and (min-width: 992px) {
        .modal-lg {
          width: 950px; /* New width for large modal */
        }
    }
    
    td.highlight{
      font-weight:bold;
      color:blue;
    }
</style>
<!-- end change modal size -->

<style type="text/css">
    #scroll {
    position:fixed;
    right:10px;
    bottom:10px;
    cursor:pointer;
    width:50px;
    height:50px;
    background-color:#3498db;
    text-indent:-9999px;
    display:none;
    -webkit-border-radius:60px;
    -moz-border-radius:60px;
    border-radius:60px
}
#scroll span {
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-8px;
    margin-top:-12px;
    height:0;
    width:0;
    border:8px solid transparent;
    border-bottom-color:#ffffff;
}
#scroll:hover {
    background-color:#e74c3c;
    opacity:1;filter:"alpha(opacity=100)";
    -ms-filter:"alpha(opacity=100)";
}
.wrapper{height:100%;position:relative;overflow-x:hidden;overflow-y:hidden}
  </style>
<!-- <script type="text/javascript">

$(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroll').fadeIn(); 
        } else { 
            $('#scroll').fadeOut(); 
        } 
    }); 
    $('#scroll').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});

</script> -->
</head>