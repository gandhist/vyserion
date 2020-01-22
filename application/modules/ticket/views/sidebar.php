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
        
        <!-- menu PAYROLL -->
        <li class="treeview" id="payroll">
          <a href="<?php echo base_url('ticket'); ?>">
            <i class="fa fa-cog"></i> <span>IT HELP DESK</span>
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
                <li id="general_act"><a href="<?php echo base_url('payroll/general_act'); ?>"><i class="fa fa-circle-o"></i> Ticket</a></li>    
              </ul>
            </li>



           
          </ul>
        </li>
        <!-- menu vehicle -->
<li class="treeview">
          <a href="<?php echo base_url('ticket'); ?>">
            <i class="fa fa-car"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo base_url(); ?>auth/change_password"><i class="fa fa-circle-o"></i> Change Password</a>
            </li>
          </ul>
        </li>

        <!-- menu user management -->
        <!-- end menu user -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>