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

        <?php
        //echo print_r(menu_list()); //menu_list()[0]['module_name'];
        foreach (menu_list() as $key) {
          
        ?>
        <li class="<?php echo active_menu($key->method); ?>" >
          <a href="#">
            <i class="<?php echo $key->glyphicon; ?>"></i> <span><?php echo $key->module_name; ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="<?php echo active_submenu(1); ?>" >
              <a href="#"><i class="fa fa-circle-o"></i> INPUT 
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" >
                <?php sidebar_list($key->id_module, 1); ?>
              </ul>
            </li>

            <li class="<?php echo active_submenu(2); ?>">
              <a href="#"><i class="fa fa-circle-o"></i> PROCESS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              <?php sidebar_list($key->id_module, 2); ?>
              </ul>
            </li>

            <li class="<?php echo active_submenu(3); ?>">
              <a href="#"><i class="fa fa-circle-o"></i> SETUP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              <?php sidebar_list($key->id_module, 3); ?>
              </ul>
            </li>

            <li class="<?php echo active_submenu(4); ?>">
              <a href="#"><i class="fa fa-circle-o"></i> REPORT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              <?php sidebar_list($key->id_module, 4); ?>
              </ul>
            </li>

           
          </ul>
        </li>
        <?php
        } // end of loop module name
        ?>

        <li class="treeview" id="help_desk">
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