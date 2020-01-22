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
                        <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_nap_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap_f', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                           <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                            <button type="button" id="btn-reset" onclick="reset_filter()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
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
                <h3 class="panel-title" >Daily Input P2H : </h3>
                <h3 id="last_km" class="panel-title" ></h3>
              <span class="label label-warning" id="notif_count"></span>

            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
        <input type="text" style="display:none;" name="f_id_vehicle_doc" id="f_id_vehicle_doc" value="">

        <div class="col-xs-6">
          <div class="form-group">
                        <label for="f_condition" class="col-sm-2 control-label">Condition</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_condition" id="f_condition" style="width: 100%;">
                                    <option value="0">READY</option>
                                    <option value="1">KM ERROR</option>
                                    <option value="2">STANDBY</option>
                                    <option value="3">BREAKDOWN</option>
                                    <option value="4">TROUBLES</option>
                                    <option value="5">TIDAK P2H</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
          <!-- <p>Shift 1</p> -->
          <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label">Date</label>
                         <div class="col-sm-10">
                    <input type="text" id="f_date" name="f_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label">NAP</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_nap" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Shift 1</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_shift_satu" id="f_shift_satu" readonly class="form-control" value="1" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Start</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_start_satu" id="f_start_satu" class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Stop</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_stop_satu" id="f_stop_satu"  class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">KM Total</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_km_total_satu" id="f_km_total_satu" readonly class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_remarks_satu" name="f_remarks_satu"></textarea>
                        </div>
                    </div>
</div>
<div class="col-xs-6">
          <!-- <p>Shift 2</p> -->

          <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label"></label>
                         <div class="col-sm-10">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label"></label>
                         <div class="col-sm-10">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label"></label>
                         <div class="col-sm-10">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label"></label>
                         <div class="col-sm-10">
                    
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                        
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                        
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                        
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                        
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Shift 2</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_shift_dua" id="f_shift_dua" readonly class="form-control" value="2" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Start</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_start_dua" id="f_start_dua" class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Stop</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_stop_dua" id="f_stop_dua"  class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">KM Total</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_km_total_dua" id="f_km_total_dua" readonly class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_remarks_dua" name="f_remarks_dua"></textarea>
                        </div>
                    </div>
</div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-save"></i> Save</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
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
                    <th>No</th>
                    <th>Date</th>
                    <th>NAP</th>
                    <th>Condition</th>
                    <th>Shift1</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Total</th>
                    <th>Remarks</th>
                    <th>Shift2</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Total</th>
                    <th>Remarks</th>
                    
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>NAP</th>
                    <th>Condition</th>
                    <th>Shift1</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Total</th>
                    <th>Remarks</th>
                    <th>Shift2</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Total</th>
                    <th>Remarks</th>
                <th>Action</th>
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
  
