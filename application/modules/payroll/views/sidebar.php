<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
       <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $username; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> 
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
                <li  id="doc_status"><a href="<?php echo base_url('hr/doc_status'); ?>"><i class="fa fa-circle-o"></i> Document Status</a></li>
                
              </ul>
            </li>

            <li class="treeview" id="process">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id= "list_exp"><a href="<?php echo base_url('hr/list_expierd'); ?>"><i class="fa fa-circle-o"></i> List Expierd</a></li>
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
                <li id="report_overtime"><a href="<?php echo base_url('payroll/rpt_slip_lembur'); ?>"><i class="fa fa-circle-o"></i> Report Slip Overtime</a></li>
                <li id="report_gang_activity"><a href="<?php echo base_url('payroll/rpt_gang_activity'); ?>"><i class="fa fa-circle-o"></i> Report Rekap Gaji</a></li>

              </ul>
            </li>
           
          </ul>
        </li>
         <!-- menu vehicle -->
        <li class="treeview" id="vehicle">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-car"></i> <span>Vehicle</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview" id="input_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li id="vehicle_document"><a href="<?php echo base_url('vehicle/vehicle_document'); ?>"><i class="fa fa-circle-o"></i> Vehicle Document</a></li>
              </ul>
            </li>
            <li class="treeview" id="process_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="vehicle_monitoring"><a href="<?php echo base_url('vehicle/vehicle_monitoring'); ?>"><i class="fa fa-circle-o"></i> Vehicle Monitoring</a></li>
              </ul>
            </li>
            <li class="treeview" id="setup_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="master_vehicle"><a href="<?php echo base_url('vehicle/master_vehicle'); ?>"><i class="fa fa-circle-o"></i> Master Vehicle</a></li>
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

        <!-- menu user management -->
        <li class="treeview">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-car"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo base_url(); ?>auth"><i class="fa fa-circle-o"></i> Add User</a>
            </li>
          </ul>
        </li>
        <!-- end menu user -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>