<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Report History Downtime
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-dashboard"></i> EQ - TS</a></li>
        <li><a href="#">Report</a></li>
        <li class="active">History Downtime</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
<!-- form filter data -->
<div class="col-md-6">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-filter"></i> Filter Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="#" id="form_filters" class="form-horizontal">
                    <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Start Date</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <!-- <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block"> -->
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                           <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<!--  end of form filter data -->
<!-- begin form upload -->
        <div class="col-md-6">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="glyphicon glyphicon-import"></i> Upload Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="#" id="form-import" enctype="multipart" class="form-horizontal">
                    <div class="form-group">
                        <label for="filter_month" class="col-sm-2 control-label">Upload File xls</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <!-- <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block"> -->
                            <input type="file" name="file_import" accept=".xls" id="file_import" class="form-upload"> <span class="help-block"></span>
                        </div>
                    </div>
                  
                    
                    <div class="form-group">
                        <label for="Import" class="col-sm-1 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn_import" class="btn btn-primary"><i class="icon fa fa-upload"></i> Import Data</button>
                           <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                           <!--  <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default">Reset</button> -->
                        </div>
                    </div>
                    <div id="loading_import" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                </form>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->

        </div>
        <!-- end of form upload -->
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Report History Downtime : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input type="text" style="display:none;" name="f_input_by" id="f_input_by" value="">
                    <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
                    <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
                    <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <input type="text" style="display:none;" name="f_id_emp_act_sk" id="f_id_emp_act_sk" value="">
                    <input type="text" style="display:none;" name="status_bd_temp" id="status_bd_temp" >

        <div class="col-xs-3">
                    <div class="form-group">
                        <label for="f_condition" class="col-sm-4 control-label">Start Date</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_start_date" class="form-control" id="f_start_date" placeholder="dd-mm-yyyy" data-inputmask="'alias' : 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>"> <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="country" class="col-sm-4 control-label">End Date</label>
                         <div class="col-sm-8">
                            <input type="text" name="f_end_date" id="f_end_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y'); ?>"> <span class="help-block"></span>
                        </div>
                    </div>
                   
                   <div class="form-group">
                        <label for="f_nap" class="col-sm-4 control-label">Code Unit</label>
                        <div class="col-sm-8">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_code_unit" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_code_unit', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="f_nap" class="col-sm-4 control-label">Type</label>
                        <div class="col-sm-8">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_type" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_type', $dd_type, $type_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_condition" class="col-sm-4 control-label">Status Breakdown</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="f_status_bd" id="f_status_bd" style="width: 100%;">
                                    <option value="0">OPEN</option>
                                    <option value="1">CLOSED</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_condition" class="col-sm-4 control-label">Status Level</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="f_status_level" id="f_status_level" style="width: 100%;">
                                    <option value="0">BD1</option>
                                    <option value="1">BD2</option>
                                    <option value="2">BD3</option>
                                    <option value="3">BD4</option>
                                    <option value="4">CLOSED</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

<!-- ini untuk submit form pdf -->
                     <div class="form-group">
                        <label for="LastName" class="col-sm-4 control-label"></label>
                        <div class="col-sm-12">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <!-- <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-save"></i> Save</button>
                            <button type="button" id="xls" name="xls" class="btn btn-success"><i class="fa fa-file-excel-o"></i> XLS</button> -->
                </form>
                <form action="<?php echo base_url('ts/rpt_downtime_pdf'); ?>" method = "POST" class="form-horizontal" name="downtime_pdf" id="downtime_pdf" target="_blank">
                    <!-- end of form submit -->
                    <input type="text" style="display:none;"  name="tmp_start_date" id="tmp_start_date" value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>">
                    <input type="text" style="display:none;"  name="tmp_end_date" id="tmp_end_date" value="<?php echo date('d-m-Y'); ?>">
                    <input type="text" style="display:none;" name="tmp_code_unit" id="tmp_code_unit">
                    <input type="text" style="display:none;"  name="tmp_type" id="tmp_type">
                    <input type="text" style="display:none;"  name="tmp_status_bd" id="tmp_status_bd">
                    <input type="text" style="display:none;"  name="tmp_status_level" id="tmp_status_level">
                            <button type="submit" id="pdf" name="pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</button>
                            <button type="button" name="btn-filter" onclick="filter_xls()" class="btn btn-primary"><i class="fa fa-filter"> </i> Filter </button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                    <!-- end of form submit -->
                    </form>
                        </div>
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
                    <th>No</th>
                    <th>No.Kwitansi</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Manufacturer</th>
                    <th>group</th>
                    <th>Work Unit</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>Date Start</th>
                    <th>Jam Start</th>
                    <th>Date Finish</th>
                    <th>Jam Finish</th>
                    <th>Task</th>
                    <th>Schedule</th>
                    <th>Status Damage</th>
                    <th>PM</th>
                    <th>Status Level</th>
                    <th>Status BD</th>
                    <th>Progress By</th>
                    <th>Mechanic Name</th>
                    <th>Location</th>
                    <th>HM</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Remarks Machine</th>
                    <th>Reason BD</th>
                    <th>Part Replacment</th>
                    <th>NO PR/SR</th>
                    <th>NO PO</th>
                    <th>Cost Estimate</th>
                    <th>Status Cost</th>
                    <th>PW</th>
                    <th>TDR</th>
                    <th>MA</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>No.Kwitansi</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Manufacturer</th>
                    <th>group</th>
                    <th>Work Unit</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>Date Start</th>
                    <th>Jam Start</th>
                    <th>Date Finish</th>
                    <th>Jam Finish</th>
                    <th>Task</th>
                    <th>Schedule</th>
                    <th>Status Damage</th>
                    <th>PM</th>
                    <th>Status Level</th>
                    <th>Status BD</th>
                    <th>Part Replacment</th>
                    <th>Progress By</th>
                    <th>Mechanic Name</th>
                    <th>Location</th>
                    <th>HM</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Remarks Machine</th>
                    <th>Reason BD</th>
                    <th>NO PR/SR</th>
                    <th>NO PO</th>
                    <th>Cost Estimate</th>
                    <th>Status Cost</th>
                    <th>PW</th>
                    <th>TDR</th>
                    <th>MA</th>
            </tr>
            </tfoot>
        </table>
                 <!--    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button> -->

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