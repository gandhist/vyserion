<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('home'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo get_app_conf('app_name')->app_name; ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo get_app_conf('app_name')->app_name; ?></b></span>
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
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs" id="divLocal"></span>
              <!-- show session username here -->
            </a>
          </li>
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <!-- show session username here -->
            </a>
          </li>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="notif_count"></span>
            </a>
            <ul class="dropdown-menu" style="width: 500px;">
              <li class="header" id="v_notif"></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li id="list_notif">
<!--                     <a href="#" id="list1">
                      <i class="fa fa-users text-aqua"></i> 
                    </a>
                    <a href="#" id="list2">
                      <i class="fa fa-users text-aqua"></i> 
                    </a> -->
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url('hr/list_expierd'); ?>">View all</a></li>
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
                <img src="<?php echo base_url(); ?>assets/dist/img/octocat_rs.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $username; ?>
                  <small><?php echo get_app_conf('owner')->owner; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
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
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('auth/change_password'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
            <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          </li>
        </ul>
      </div>
    </nav>
  </header>

