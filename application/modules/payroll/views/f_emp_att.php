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
<!-- form filter data -->
<div class="col-md-3">
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
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <!-- <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block"> -->
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y'); ?>" > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y'); ?>" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Departement</label>
                       
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_dept" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_dept', $dd_emp_dept, $dd_emp_dept_select, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_condition" class="col-sm-3 control-label">Shift</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_shift" id="f_shift" style="width: 100%;">
                                    <option value="1">SHIFT I</option>
                                    <option value="2">SHIFT II</option>
                                    <option value="3">OFF DAY</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_condition" class="col-sm-3 control-label">Absent</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_hadir" id="f_hadir" style="width: 100%;">
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_condition" class="col-sm-3 control-label">Late</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_late" id="f_late" style="width: 100%;">
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                       
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
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
        <div class="col-md-3">
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
             <!-- download absensi -->
             <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#import-data" data-toggle="tab">Import Data</a></li>
              <li><a href="#process-presensi" data-toggle="tab">Process Presensi</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Download Presensi</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="import-data" style="position: relative; height: 300px;">
              <div class="panel-body">
              <form action="#" id="form_import" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
                    <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
                    <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
                    <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <input type="text" style="display:none;" name="f_id_emp_act_sk" id="f_id_emp_act_sk" value="">
             <div class="col-xs-12">
                <div class="col-xs-6">
                <div class="box-body">
              <dl>
                <dt>Keterangan : </dt>
                <dd>klik tombol "Process to Import Database" artinya adalah akan menjalankan process import database dari mesin ke database HRIS</dd>
                <div id="download_indicator" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
              </dl>
            </div>
              
              </div>
              <div class="col-xs-6">
                <div id="alert_import" class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil Import Database!</h4>
                    <div id="success_message" > </div>
                </div>
              
              </div>

                     <div class="form-group">
                        <label for="LastName" class="col-sm-12 control-label"></label>
                        <div class="col-sm-12">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="import_absen()" class="btn btn-primary"><i class="icon fa fa-download"></i> Process to Import Database</button>
                        </div>
                    </div>

                </form>
        </div>
            </div>
                
              </div>

              <!-- batas -->
              <div class="chart tab-pane" id="process-presensi" style="position: relative; height: 300px;">
              <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
                    <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
                    <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
                    <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <input type="text" style="display:none;" name="f_id_emp_act_sk" id="f_id_emp_act_sk" value="">
             <div class="col-xs-3">
                    <div class="form-group">
                        <label for="country" class="col-sm-4 control-label">Start Date</label>
                         <div class="col-sm-8">
                            <input type="text" name="f_start_date" id="f_start_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country" class="col-sm-4 control-label">End Date</label>
                         <div class="col-sm-8">
                            <input type="text" name="f_end_date" id="f_end_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y'); ?>" > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-4 control-label">Departement</label>
                       
                        <div class="col-sm-8">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_dept_download" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_dept_download', $dd_emp_dept, $dd_emp_dept_select, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-4 control-label">Name</label>
                       
                        <div class="col-sm-8">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div id="download_indicator_presensi" class="overlay">

                    
                    

              <i class="fa fa-refresh fa-spin"></i>
            </div>
                     <div class="form-group">
                        <label for="LastName" class="col-sm-12 control-label"></label>
                        <div class="col-sm-12">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-download"></i> Download Data</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>

                </form>
        </div>
                    
            </div>
              </div>
            </div>
          </div>
             <!-- download absensi -->



            <div class="panel-body">

           
                    
            </div>
        </div>

 

            </div>


            <!-- /.box-header -->

            <div class="box-body">
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Check In</th>
                    <th>Cehck Out</th>
                    <th>Late</th>
                    <th>Overtime</th>
                    <th>Work Hour</th>
                    <th>Attd Code</th>
                   <!--  <th>Photo</th> -->
                  
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
            <th>No</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Check In</th>
                    <th>Cehck Out</th>
                    <th>Late</th>
                    <th>Overtime</th>
                    <th>Work Hour</th>
                    <th>Attd Code</th>
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
  


