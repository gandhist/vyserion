<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo get_modul_name(); ?>
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <!-- <li><a href="#"><i class="fa fa-dashboard"></i> HR</a></li>
        <li><a href="#">Input</a></li>
        <li class="active">Bio Data</li> -->
        <?php echo get_navbar_menu(); ?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             
              <!-- <button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add Document</button> -->
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
<!-- example -->
 <!--              <a href="<?php echo base_url(); ?>c_laporan" class="btn btn-primary"> Laporan</a>
              <a href="<?php echo base_url(); ?>c_paklaring" class="btn btn-primary"> Paklaring</a> -->
<!--               <?php echo form_open($action); ?>
            <div class="form-group">
                <label for="foto">Empcode</label>
                <?php
                $dd_provinsi_attribute = 'class="form-control select2" id="f_empname" onchange="emp()"';
                $js = 'onchange="emp()"';
                echo form_dropdown('empname', $dd_empcode, $empcode_selected, $dd_provinsi_attribute,$js);
                ?>
                <select id="test" onchange="em()" class="form-control select2">
                  <option>test</option>
                  <option>te</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>  -->
        </form>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
<!-- data akan tampil jika field yang ditampilkan sebagai datatables sudah di isi, baik secara form atau databse -->
              <table id="table" class="table table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th> No</th>
                    <th> NIK</th>
                    <th> Name</th>
                    <th> No Contract</th>
                    <th> Start Date</th>
                    <th> End Date</th>
                    <th> Sign Date</th>
                    <th> Day Reminder</th>
                    <th> Due Date</th>
                    <th> Status</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th> No</th>
                    <th> NIK</th>
                    <th> Name</th>
                    <th> No Contract</th>
                    <th> Start Date</th>
                    <th> End Date</th>
                    <th> Sign Date</th>
                    <th> Day Reminder</th>
                    <th> Due Date</th>
                    <th> Status</th>
                <th>Action</th>
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
    <strong><a href="https://adminlte.io">Cacoon-Dev</a> &copy; 2018-Now .</strong> All rights
    reserved.
  </footer>


    <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
