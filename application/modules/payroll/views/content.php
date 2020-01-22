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
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Input Genaral Activity : </h3>
            </div>
            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-4">
                            <!-- <?php
                                  $dd_select2_attribute = 'class="form-control select2" id="f_emp_status" style="width: 100%;" disabled placeholder="Empcode"';
                                  
                                  echo form_dropdown('f_emp_status', $dd_emp_status, $empcode_status_selected, $dd_select2_attribute);
                                  ?><span class="help-block"></span> -->
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_date_attd" id="f_date_attd" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_attd_code" class="col-sm-2 control-label">Attendance Code</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="f_attd_code" id="f_attd_code" style="width: 100%;">
                                    <option>-</option>
                                    <option value="married">Operational Production</option>
                                    <option value="single">Cuti</option>
                                    <option value="widow/er">Off</option>
                                    <option value="widow/er">Cuti Melahirkan</option>
                                    <option value="widow/er">Mangkir</option>
                                    <option value="widow/er">Sakit</option>
                                    <option value="widow/er">Alfa</option>
                                    <option value="widow/er">Izin</option>
                                    <option value="widow/er">Mogok Kerja</option>
                                    <option value="widow/er">Dinas Luar</option>
                                  </select>
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="f_remarks" name="f_remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="save" class="btn btn-primary">Filter</button>
                            <button type="button" id="btnSave" onclick="sav()" class="btn btn-primary">Save</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
              <!-- <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> -->
<!--               <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button> -->         
             
 <!--              <a href="<?php echo base_url(); ?>c_laporan" class="btn btn-primary"> Laporan</a>
              <a href="<?php echo base_url(); ?>c_paklaring" class="btn btn-primary"> Paklaring</a> -->
            </div>


            <!-- /.box-header -->

            <div class="box-body">
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Employee Status</th>
                    <th>Company Begin</th>
                   <!--  <th>Photo</th> -->
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                  <th>NIK</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Employee Status</th>
                  <th>Company Begin</th>
               <!--  <th>Photo</th> -->
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
                    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>

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