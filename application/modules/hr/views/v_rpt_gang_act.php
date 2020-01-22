<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.dataTables.min.css"></script> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/export_button/buttons.dataTables.min.css">

 

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
</style>
<!-- end change modal size -->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('home'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>HR</b>IS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>HRIS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 1 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 1 Employee almost expired contract
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          <!-- User Account: style can be found in dropdown.less -->
          </li> 
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo $username; ?></span>
              <!-- show session username here -->
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $username; ?> - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $username; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      <!-- search form -->
<!--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Root Menu</li>
        <!-- menu HR -->
        <li class="treeview" id="hr">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-users"></i> <span>HR</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="treeview" id="input">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li  id="biodata" ><a href="<?php echo base_url('hr/hr'); ?>"><i class="fa fa-circle-o"></i> Bio Data</a></li>
                <li  id="grade_status"><a href="<?php echo base_url('hr/grade_status'); ?>"><i class="fa fa-circle-o"></i> Grade Status</a></li>
                <li  id="tax_status"><a href="<?php echo base_url('hr/tax_status'); ?>"><i class="fa fa-circle-o"></i> Tax Status</a></li>
                <li  id="termination"><a href="<?php echo base_url('hr/termination'); ?>"><i class="fa fa-circle-o"></i> Termination</a></li>
                
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
              </ul>
            </li>
            <li class="treeview" id="setup">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="" id="master_dept"><a href="<?php echo base_url('hr/dept') ?>"><i class="fa fa-circle-o"></i> Master Departement</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Position</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Emp Status</a></li>
              </ul>
            </li>
            <li class="treeview" id="report">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="report_parameter_hr"><a href="<?php echo base_url('hr/hr_report'); ?>"><i class="fa fa-circle-o"></i> Report Parameter</a></li>
              </ul>
            </li>
           
          </ul>
        </li>
        <!-- menu PAYROLL -->
        <li class="treeview" id="payroll">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-money"></i> <span>Employee Payroll</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="treeview" id="input_payroll">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li id="general_act"><a href="<?php echo base_url('payroll/general_act'); ?>"><i class="fa fa-circle-o"></i> General Activity</a></li>
                <li id="adhoc"><a href="<?php echo base_url('payroll/adhoc'); ?>"><i class="fa fa-circle-o"></i> Allowance & Deduction</a></li>                
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('hr/dept') ?>"><i class="fa fa-circle-o"></i> Master Departement</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Position</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Emp Status</a></li>
              </ul>
            </li>
            <li class="treeview" id="report_payroll">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="report_gang_activity"><a href="<?php echo base_url('payroll/rpt_gang_activity'); ?>"><i class="fa fa-circle-o"></i> Report General Activity</a></li>
                <li id="report_adhoc"><a href="<?php echo base_url('payroll/report_adhoc'); ?>"><i class="fa fa-circle-o"></i> Report Ad-Hoc</a></li>
                <li id="report_sallary"><a href="<?php echo base_url('payroll/rpt_sallary'); ?>"><i class="fa fa-circle-o"></i> Report Sallary</a></li>
                <li id="report_gang_activity"><a href="<?php echo base_url('payroll/rpt_gang_activity'); ?>"><i class="fa fa-circle-o"></i> Report Slip Overtime</a></li>
                <li id="report_gang_activity"><a href="<?php echo base_url('payroll/rpt_gang_activity'); ?>"><i class="fa fa-circle-o"></i> Report Rekap Gaji</a></li>

              </ul>
            </li>
           
          </ul>
        </li>
        <!-- menu vehicle -->
        <li class="treeview">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-car"></i> <span>Vehicle</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('hr/hr'); ?>"><i class="fa fa-circle-o"></i> BIODATA</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Vehicle</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Position</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Emp Status</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
              </ul>
            </li>
           
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url(); ?>assets/index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="<?php echo base_url(); ?>assets/index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li>
          <a href="../widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li class=""><a href="data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="../calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="../mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="../examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="../examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="../examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="../examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="../examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="../examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="../examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="../examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Report Gang Activity
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Report</a></li>
        <li class="active">Report Gang Activity</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">

            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Filter Data : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
                    <div class="form-group">
                        <label for="filter_empcode" class="col-sm-2 control-label">NIK Staff</label>
                        <div class="col-sm-4">
                            <!-- <?php echo $form_country; ?> -->
                            <?php
                                  $attribute = 'class="form-control select2" id="filter_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_empcode', $dd_empcode, $empcode_selected, $attribute);
                                  ?> 
                                 <!--  <input type="text" name="empcode" id="empcode"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_dept" class="col-sm-2 control-label">Departement</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_dept" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_dept', $dd_emp_dept, $dd_emp_dept_select, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_position" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_position" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_position', $dd_emp_pos, $dd_emp_pos_select, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_emp_status" class="col-sm-2 control-label">Employee Status</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_emp_status" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_emp_status', $dd_emp_status, $empcode_status_selected, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_month" class="col-sm-2 control-label">Month</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
              <!-- <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> -->
              
              <a href="<?php echo base_url(); ?>hr/laporan_pdf" target="_blank" >slip gaji</a>
              <a href="<?php echo base_url(); ?>hr/mpdf" target="_blank" >slip lembur</a>

              <button class="btn btn-default" ><i class="glyphicon glyphicon-refresh"></i> Report DomPDF</button> 
              <!-- <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>    -->      
             
 <!--              <a href="<?php echo base_url(); ?>c_laporan" class="btn btn-primary"> Laporan</a>
              <a href="<?php echo base_url(); ?>c_paklaring" class="btn btn-primary"> Paklaring</a> -->
            </div>

            <!-- /.box-header -->

            <div class="box-body">
<!-- <input type="text" name="nik_awal" id="nik_awal">
<input type="text" name="nik_akhir" id="nik_akhir"> -->
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Tanggal</th>
                    <th>Overtime</th>
                    <th>Lembur</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                  <th>NIK</th>
                  <th>Name</th>
                  <th>Tanggal</th>
                  <th>Overtime</th>
                  <th>Lembur</th>
            </tr>
            </tfoot>
        </table>
              </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
   <!-- /.content-wrapper -->
  



  <!-- footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 18.0.0
    </div>
    <strong><a href="https://adminlte.io">IT TEAM</a> &copy; 2018-Now .</strong> All rights
    reserved.
  </footer>


    <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.min.js"></script>
<!-- SlimScroll -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- datepicker -->
<!-- <script src="<?php echo base_url(); ?>assets/dt/bootstrap-datepicker.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
<!-- page script -->
<!-- button export datatable -->
<!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/datatables/export_button/html5shiv.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/dataTables.buttons.min.js"></script>


<script>
            $(document).ready(function () {
                $(".select2").select2({
                    placeholder: "Please Select"
                });
            });
                // untuk setting sidebar active
                $("#payroll").addClass("treeview active");
                $("#report_payroll").addClass("treeview active");
                $("#report_gang_activity").addClass("active");
                
                
        </script>

  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
/*  start_date = $('#filter_start_date').val();
                end_date = $('#filter_end_date').val();
                var get_year = start_date.substring(6,10);
                var get_mount = start_date.substring(3,5);
                var get_day = start_date.substring(0,2);
                var start_date = get_year+"-"+get_mount+"-"+get_day;
                //alert(start_date);
                // pecah end date
                var get_year_x = end_date.substring(6,10);
                var get_mount_x = end_date.substring(3,5);
                var get_day_x = end_date.substring(0,2);
                var end_date = get_year_x+"-"+get_mount_x+"-"+get_day_x;*/
   table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        // buttonfile export 
        "dom": 'Blfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('payroll/ajax_rpt_gang_activity')?>",
            "type": "POST",
            "data": function (data) {
                
                data.filter_empcode = $('#filter_empcode').val();
                data.filter_dept = $('#filter_dept').val();
                data.filter_position = $('#filter_position').val();
                data.filter_emp_status = $('#filter_emp_status').val();
                data.filter_month = $('#filter_month').val();
                data.filter_year = $('#filter_year').val();
                

               /* data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -1 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],

    });
    

    $('#btn-filter').click(function(){ //button filter event click
        /*empcode = $('#filter_start_date').val();
        start_date = $('#filter_start_date').val();
        end_date = $('#filter_end_date').val();*/
        //pecah start date
      /*var get_year = start_date.substring(6,10);
      var get_mount = start_date.substring(3,5);
      var get_day = start_date.substring(0,2);
      var start_date = get_year+"-"+get_mount+"-"+get_day;
      alert(start_date);
      // pecah end date
      var get_year_x = end_date.substring(6,10);
      var get_mount_x = end_date.substring(3,5);
      var get_day_x = end_date.substring(0,2);
      var end_date = get_year_x+"-"+get_mount_x+"-"+get_day_x;
        alert(end_date);*/
//datatables
 
        table.ajax.reload();  //just reload table

    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        $('#filter_empcode').val(null).trigger('change');
        $('#filter_dept').val(null).trigger('change');
        $('#filter_position').val(null).trigger('change');
        $('#filter_emp_status').val(null).trigger('change');
        
        table.ajax.reload();  //just reload table

    });
/*$(document).ready(function() {
    //var table = $('#table').DataTable();
     
    // Event listener to the two range filtering inputs to redraw on input
    $('#nik_awal, #nik_akhir').keyup( function() {
        /*var nik_akhir = nik_akhir.value;
        var nik_awal = nik_awal.value;

        //alert(nik_akhir.value);
        table.draw();

    } );
    } );*/

/*$('#nik_awal').keyup(function () {
            if (!!nik_awal.value) {
                table.column(0).search(nik_awal.value).draw();
            } else {
                table.column(0).search(nik_awal.value).draw();
            }
        } );*/


    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});




function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Input Employee'); // Set Title to Bootstrap modal title
    $('#f_input_by').val('<?php echo $username; ?>');
    $('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo'); // label photo upload
    $("#f_departement").val(null).trigger('change');
    $("#f_emp_status").val(null).trigger('change');
}

function edit_emp_attribute(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#f_update_by').val('<?php echo $username; ?>');
    $('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('hr/hr/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_empcode"]').val(data.empcode);
            $('[name="f_empname"]').val(data.empname);
            $('[name="f_other_empname"]').val(data.other_name);
            $('[name="f_pob"]').val(data.birth_place);
            $('[name="f_date_of_birth"]').val(data.dob);
            $('[name="f_citizen"]').val(data.nationality);
            $('[name="f_sex"]').val(data.sex);
            $('[name="f_marrital_status"]').val(data.maritalstatus);
            $('[name="f_date_of_married"]').val(data.datemarried);
            $('[name="f_religion"]').val(data.religion);
            $('[name="f_blood_type"]').val(data.blood_type);
            $('[name="f_number_child"]').val(data.numberofchild);
            $('[name="f_departement"]').val(data.departement).trigger("change");
            /*$("#f_departement").addClass("selected");$("#e1").val("UT").trigger("change");*/
            $('[name="f_termination_date"]').val(data.dateterminate);
            $('[name="f_position"]').val(data.position);
            $('[name="f_jamsostek_no"]').val(data.nojamsostek);
            $('[name="f_life_insurance_no"]').val(data.lifeinsuranceno);
            $('[name="f_bank_account"]').val(data.bankaccountno);
            $('[name="f_bank_name"]').val(data.bankname);
            $('[name="f_bank_account_name"]').val(data.bankaccountname);
            $('[name="f_emp_status"]').val(data.employeetype).trigger("change");
            $('[name="f_npwp"]').val(data.npwp);
            $('[name="f_id_card"]').val(data.no_identitas);
            $('[name="f_labour_union"]').val(data.labour_union);
            $('[name="f_address"]').val(data.address);
            $('[name="f_province"]').val(data.province);
            $('[name="f_city"]').val(data.city);
            $('[name="f_zipcode"]').val(data.zipcode);
            $('[name="f_phoneno"]').val(data.homephoneno);
            $('[name="f_mobilephoneno"]').val(data.mobilephoneno);
            $('[name="f_email"]').val(data.emailaddr);
            $('[name="f_company_begin"]').val(data.companybegin);
            $('[name="f_hire_date"]').val(data.hire_date);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Employee Bio Data'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.photo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove photo when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('hr/hr/emp_add')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
    } else {
        url = "<?php echo site_url('hr/hr/emp_update')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                //location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
    }

    // ajax adding data to database

    /*var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });*/
}

function delete_emp_attribute(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('hr/hr/emp_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>
  <!-- end of crud employee datatable -->
<!-- Bootstrap modal -->
<!-- disable keyboard dan onclick outside
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
 -->
<!-- End Bootstrap modal -->
<!-- InputMask -->

<!-- Bootstrap 3.3.7 -->

<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    // menghitung umur
    $("#f_date_of_birth").change(function(){
      //alert('heyho');
      var today = new Date();
      // mount count from 0 = january
      var month = new Array();
          month[0] = "January";
          month[1] = "February";
          month[2] = "March";
          month[3] = "April";
          month[4] = "May";
          month[5] = "June";
          month[6] = "July";
          month[7] = "August";
          month[8] = "September";
          month[9] = "October";
          month[10] = "November";
          month[11] = "December";
      // end of mounth
      var mounth = new Date();
      //get date value from input form
      var birthDate = $('#f_date_of_birth').val();
      var get_year = birthDate.substring(6,10);
      var get_mount = birthDate.substring(3,5);
      var get_day = birthDate.substring(0,2);
      //get date value from input form
      // get date value current
      var get_curr_year = today.getFullYear();
      var get_curr_mount = today.getMonth() + 1;
      var get_curr_day = today.getDate();

      var get_age = get_curr_year - get_year;
      var m =  get_curr_mount;
      //$('#age').text(get_age+" Years Old "+get_curr_mount);
      if (get_curr_mount >= get_mount) {
        var age = get_curr_year - get_year;
        var sisa_bulan_thn_lalu = 12 - get_mount;
        $('#age').text(age+" Years Old ");
      }
      else if(get_curr_mount <= get_mount)
      {
        var age = (get_curr_year - 1) - get_year;
        var sisa_bulan_thn_lalu = 12 - get_mount;
        $('#age').text(age+" Years Old ");
        //$('#age').text(age+" Years "+sisa_bulan_thn_lalu+ " Months ebih ecil ");
      }
      /*$('#age').text($('#f_date_of_birth').val());*/
    /*var today = new Date();
    var birthDate = new Date($('#dob').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return $('#age').html(age+' years old');*/
    });
    // END OF MENGHITUNG UMUR

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm-dd-yyyy', { 'placeholder': 'mm-dd-yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
/*    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })*/
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>