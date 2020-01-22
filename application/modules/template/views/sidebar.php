<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
       <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
          <img src="<?php echo base_url(); ?>assets/dist/img/octocat_rs.jpg" class="img-circle" alt="User Image">
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
                <li id="rpt_grafik_emp_in_out"><a href="<?php echo base_url('hr/rpt_grafik_emp_in_out'); ?>"><i class="fa fa-circle-o"></i> Report Grafik</a></li>
                <li id="rpt_grafik_emp_in_out"><a href="<?php echo base_url('hr/data_karyawan_finance'); ?>" target="_blank"><i class="fa fa-download"></i> Report Data Karyawan Finance</a></li>
              </ul>
            </li>
           
          </ul>
        </li>
        <!-- menu HR -->
        <li class="treeview" id="prod">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-industry"></i> <span>Production</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="treeview" id="input_prod">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li  id="rooster" ><a href="<?php echo base_url('production/rooster'); ?>"><i class="fa fa-circle-o"></i> Rooster</a></li>
                <li  id="hm_unit" ><a href="<?php echo base_url('production/hm_unit'); ?>"><i class="fa fa-circle-o"></i> Daily Poduction</a></li>
                <!-- <li  id="grade_status"><a href="<?php echo base_url('hr/grade_status'); ?>"><i class="fa fa-circle-o"></i> Grade Status</a></li>
                <li  id="tax_status"><a href="<?php echo base_url('hr/tax_status'); ?>"><i class="fa fa-circle-o"></i> Tax Status</a></li>
                <li  id="termination"><a href="<?php echo base_url('hr/termination'); ?>"><i class="fa fa-circle-o"></i> Termination</a></li>
                <li  id="doc_status"><a href="<?php echo base_url('hr/doc_status'); ?>"><i class="fa fa-circle-o"></i> Document Status</a></li> -->
                
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
            <li class="treeview" id="setup_prod">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="" id="gang"><a href="<?php echo base_url('production/gang') ?>"><i class="fa fa-circle-o"></i> Gang</a></li>
                <li class="" id="gang_master"><a href="<?php echo base_url('production/gang_master') ?>"><i class="fa fa-circle-o"></i> Gang Master</a></li>
                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Master Position</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Emp Status</a></li> -->
              </ul>
            </li>
            <li class="treeview" id="report_prod">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="rpt_rooster"><a href="<?php echo base_url('production/rpt_rooster'); ?>"><i class="fa fa-circle-o"></i> Report Rooster</a></li>
                <li id="rpt_rooster"><a href="<?php echo base_url('production/data_karyawan_produksi'); ?>" target="_blank"><i class="fa fa-download"></i> Report Data Karyawan</a></li>
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
                <li id="spl"><a href="<?php echo base_url('payroll/spl'); ?>"><i class="fa fa-circle-o"></i> SPL</a></li>
                <li id="adhoc"><a href="<?php echo base_url('payroll/adhoc'); ?>"><i class="fa fa-circle-o"></i> Allowance & Deduction</a></li>                
                <li id="emp_att"><a href="<?php echo base_url('payroll/emp_att'); ?>"><i class="fa fa-circle-o"></i> Employee Attendance</a></li>
                <li id="download_absensi"><a href="<?php echo base_url('payroll/download_persensi'); ?>"><i class="fa fa-circle-o"></i> Download Presensi</a></li>

              </ul>
            </li>

            <li id="process_payroll" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="closing_payroll"><a href="<?php echo base_url('payroll/closing_payroll'); ?>"><i class="fa fa-circle-o"></i> Closing Payroll</a></li>
              </ul>
            </li>
            <li class="treeview" id="setup_payroll">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="ump"><a href="<?php echo base_url('payroll/ump') ?>"><i class="fa fa-circle-o"></i> Master UMP</a></li>
                <li id="ump"><a href="<?php echo base_url('payroll/setup_rooster') ?>"><i class="fa fa-circle-o"></i> Master Rooster</a></li>
                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Master Position</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Master Emp Status</a></li> -->
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
                <li id="report_rekap_gaji"><a href="<?php echo base_url('payroll/rpt_rekap_sallary'); ?>"><i class="fa fa-circle-o"></i> Report Rekap Gaji</a></li>
                <li id="rpt_rooster"><a href="<?php echo base_url('payroll/rpt_rooster'); ?>"><i class="fa fa-circle-o"></i> Report Rooster</a></li>

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
                <li id="vehicle_service"><a href="<?php echo base_url('vehicle/vehicle_service'); ?>"><i class="fa fa-circle-o"></i> Vehicle Services</a></li>
                <li id="vehicle_fuel"><a href="<?php echo base_url('vehicle/vehicle_fuel'); ?>"><i class="fa fa-circle-o"></i> Vehicle Fuel</a></li>
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
                <li id="vehicle_monitoring_p2h"><a href="<?php echo base_url('vehicle/vehicle_monitoring_p2h'); ?>"><i class="fa fa-circle-o"></i> Vehicle Monitoring P2H</a></li>
                <li id="vehicle_monitoring_next_service"><a href="<?php echo base_url('vehicle/vehicle_next_service'); ?>"><i class="fa fa-circle-o"></i> Vehicle Next Services</a></li>
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
                <li id="service_setup"><a href="<?php echo base_url('vehicle/service_setup'); ?>"><i class="fa fa-circle-o"></i>  Service Setup</a></li>
              </ul>
            </li>
            <li class="treeview" id="rpt_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="rpt_sarana"><a href="<?php echo base_url('vehicle/rpt_sarana'); ?>"><i class="fa fa-circle-o"></i>Report Sarana Support</a></li>
                <li id="rpt_veh_services"><a href="<?php echo base_url('vehicle/rpt_services'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Services</a></li>
                <li id="rpt_veh_fuel_graph"><a href="<?php echo base_url('vehicle/rpt_vehicle_fuel_graph'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Fuel</a></li>
                <li id="rpt_veh_services"><a target="_blank" href="<?php echo base_url('vehicle/template_email_vehicle'); ?>" ><i class="fa fa-circle-o"></i>Email vehicle document</a></li>
              </ul>
            </li>
          </ul>
        </li>

         <!-- menu Human Safety Enviro -->
        <li class="treeview" id="hse">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-recycle"></i> <span>HSE</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview" id="input_hse">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li id="hse_insepction"><a href="<?php echo base_url('hse/inspection'); ?>"><i class="fa fa-circle-o"></i> Inspeciton </a></li>
                <li id="vehicle_document"><a href="<?php echo base_url('vehicle/vehicle_document'); ?>"><i class="fa fa-circle-o"></i> Data APD </a></li>
                <li id="vehicle_service"><a href="<?php echo base_url('vehicle/vehicle_service'); ?>"><i class="fa fa-circle-o"></i> Induksi</a></li>
                <li id="vehicle_fuel"><a href="<?php echo base_url('vehicle/vehicle_fuel'); ?>"><i class="fa fa-circle-o"></i> Accident</a></li>
              </ul>
            </li>
            <li class="treeview" id="process_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="vehicle_monitoring"><a href="<?php echo base_url('vehicle/vehicle_monitoring'); ?>"><i class="fa fa-circle-o"></i> Data APD</a></li>
                <li id="vehicle_monitoring_p2h"><a href="<?php echo base_url('vehicle/vehicle_monitoring_p2h'); ?>"><i class="fa fa-circle-o"></i> Induksi</a></li>
                <li id="vehicle_monitoring_next_service"><a href="<?php echo base_url('vehicle/vehicle_next_service'); ?>"><i class="fa fa-circle-o"></i> Accident</a></li>
              </ul>
            </li>
            <li class="treeview" id="setup_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="master_vehicle"><a href="<?php echo base_url('vehicle/master_vehicle'); ?>"><i class="fa fa-circle-o"></i> Master Accident</a></li>
                <li id="service_setup"><a href="<?php echo base_url('vehicle/service_setup'); ?>"><i class="fa fa-circle-o"></i>  Service</a></li>
              </ul>
            </li>
            <li class="treeview" id="rpt_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="rpt_sarana"><a href="<?php echo base_url('hse/data_karyawan_hse'); ?>" target="_blank"><i class="fa fa-download"></i>Report Data Karyawan HSE</a></li>
                <!-- <li id="rpt_veh_services"><a href="<?php echo base_url('vehicle/rpt_services'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Services</a></li>
                <li id="rpt_veh_fuel_graph"><a href="<?php echo base_url('vehicle/rpt_vehicle_fuel_graph'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Fuel Graph</a></li>
                <li id="rpt_veh_services"><a target="_blank" href="<?php echo base_url('vehicle/template_email_vehicle'); ?>" ><i class="fa fa-circle-o"></i>Email vehicle document</a></li> -->
              </ul>
            </li>
           
          </ul>
        </li>


         <!-- menu EQ-TS -->
        <li class="treeview" id="ts">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-wrench"></i> <span>EQ - TS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview" id="input_ts">
              <a href="#"><i class="fa fa-circle-o"></i> INPUT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <li id="ts_bd"><a href="<?php echo base_url('ts/breakdown'); ?>"><i class="fa fa-circle-o"></i> Breakdown</a></li>
                <li id="ts_bd_v01"><a href="<?php echo base_url('ts/breakdown_v01'); ?>"><i class="fa fa-circle-o"></i> #Breakdown V01</a></li>
                <li id="ts_daily_hm"><a href="<?php echo base_url('ts/daily_hmkm'); ?>"><i class="fa fa-circle-o"></i> Daily HMKM</a></li>
                <!-- <li id="vehicle_service"><a href="<?php echo base_url('vehicle/vehicle_service'); ?>"><i class="fa fa-circle-o"></i> Induksi</a></li>
                <li id="vehicle_fuel"><a href="<?php echo base_url('vehicle/vehicle_fuel'); ?>"><i class="fa fa-circle-o"></i> Accident</a></li> -->
              </ul>
            </li>
            <li class="treeview" id="process_ts">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="closing_hm"><a href="<?php echo base_url('ts/closing_hm'); ?>"><i class="fa fa-circle-o"></i> Closing HM</a></li>
                <!-- <li id="vehicle_monitoring_p2h"><a href="<?php echo base_url('vehicle/vehicle_monitoring_p2h'); ?>"><i class="fa fa-circle-o"></i> Induksi</a></li>
                <li id="vehicle_monitoring_next_service"><a href="<?php echo base_url('vehicle/vehicle_next_service'); ?>"><i class="fa fa-circle-o"></i> Accident</a></li> -->
              </ul>
            </li>
            <li class="treeview" id="setup_vehicle">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="master_vehicle"><a href="<?php echo base_url('vehicle/master_vehicle'); ?>"><i class="fa fa-circle-o"></i> Master Heavy Equipment</a></li>
                <li id="service_setup"><a href="<?php echo base_url('vehicle/service_setup'); ?>"><i class="fa fa-circle-o"></i>  Master Vendor</a></li>
              </ul>
            </li>
            <li class="treeview" id="rpt_ts">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="rpt_downtime"><a href="<?php echo base_url('ts/rpt_downtime'); ?>" target="_blank"><i class="fa fa-download"></i>Report Downtime Unit</a></li>
                <li id="rpt_progress"><a href="<?php echo base_url('ts/rpt_update_prog_unit'); ?>" target="_blank"><i class="fa fa-download"></i>Report Progress Unit</a></li>
                <li id="rpt_mttr"><a href="<?php echo base_url('ts/mttr_vs_mtbf'); ?>" ><i class="fa fa-download"></i>Report MTTR-MTBF</a></li>
                <!-- <li id="rpt_veh_services"><a href="<?php echo base_url('vehicle/rpt_services'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Services</a></li>
                <li id="rpt_veh_fuel_graph"><a href="<?php echo base_url('vehicle/rpt_vehicle_fuel_graph'); ?>"><i class="fa fa-circle-o"></i>Report Vehicle Fuel Graph</a></li>
                <li id="rpt_veh_services"><a target="_blank" href="<?php echo base_url('vehicle/template_email_vehicle'); ?>" ><i class="fa fa-circle-o"></i>Email vehicle document</a></li> -->
              </ul>
            </li>
           
          </ul>
        </li>


        <li class="treeview" id-"help_desk">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-laptop"></i> <span>IT Help Desk</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="ticket">
              <a href="<?php echo base_url('ticket'); ?>"><i class="fa fa-circle-o"></i> Ticket</a>
            </li>
            <!-- <li>
              <a href="<?php echo base_url(); ?>auth/change_password"><i class="fa fa-circle-o"></i> Change Password</a>
            </li> -->
          </ul>
        </li>


        <!-- menu user management -->
        <li class="treeview">
          <a href="<?php echo base_url('home'); ?>">
            <i class="fa fa-user-secret"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo base_url(); ?>auth"><i class="fa fa-circle-o"></i> Add User</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>auth/change_password"><i class="fa fa-circle-o"></i> Change Password</a>
            </li>
          </ul>
        </li>
        <!-- end menu user -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- paces -->
<script src="<?php echo base_url(); ?>assets/bower_components/PACE/pace.min.js"></script>
<!-- <script>
  $(document).ajaxStart(function () {
    Pace.restart()
  })
  
</script> -->