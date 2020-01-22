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
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>" > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>" > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Code Unit</label>
                       
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
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Tanggal</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_date_upload" id="f_date_upload" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask> <span class="help-block"></span>
                        </div>
                    </div>
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
            <div class="box-header" id="border_input">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Daily Input HMKM : </h3>
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
         <!--  <div class="form-group">
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
                    </div> -->
          <!-- <p>Shift 1</p> -->
          <div class="form-group">
                        <label for="f_valid_until" class="col-sm-2 control-label">Date</label>
                         <div class="col-sm-10">
                    <input type="text" id="f_date" name="f_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date('d-m-Y', strtotime('yesterday')); ?>" ><span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label">Code Unit</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_nap" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                       <!--  <input type="text" name="f_dummy_code_unit"> -->
                        </div>
                                  <!-- <input type="text" name="f_code_unit" id="f_code_unit"> -->
                        
                    </div>

                    <div class="form-group">
                        <label for="f_shift" class="col-sm-2 control-label">Shift</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_shift" id="f_shift" style="width: 100%;">
                                    <option value="1">Day</option>
                                    <option value="2">Night</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_operator" class="col-sm-2 control-label">Operator</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_operator" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_operator', $dd_operator, $operator_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">HM Start</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_start" id="f_start" class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">HM Finish</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_stop" id="f_stop"  class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">KM Total</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_total_hm" id="f_total_hm" class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_distance"  class="col-sm-2 control-label">Distance</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_distance" id="f_distance" class="form-control"  placeholder="Distance"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label">Material</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_material" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_material', $dd_material_code, $material_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_loader" class="col-sm-2 control-label">Unit Loading</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_loader" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_loader', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    
</div>
<div class="col-xs-6">
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">07:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_7" id="f_7" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">08:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_8" id="f_8"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">09:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_9" id="f_9" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">10:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_10" id="f_10"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">11:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_11" id="f_11" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">12:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_12" id="f_12"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">01:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_1" id="f_1" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">02:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_2" id="f_2"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">03:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_3" id="f_3" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">04:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_4" id="f_4"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">05:00</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_5" id="f_5" class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Total Ritase</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_total_ritase" id="f_total_ritase"  class="form-control" placeholder="" value="0"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Total BCM /Ton</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_total_bcm_ton" id="f_total_bcm_ton" class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_remarks" name="f_remarks"></textarea>
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
                <th>Action</th>
                    <th>No</th>
                    <th>Date</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>NIK</th>
                    <th>HM Start</th>
                    <th>HM End</th>
                    <th>Total HM</th>
                    <th>Distance</th>
                    <th>Material</th>
                    <th>Unit Loading</th>
                    <th>Jam 07</th>
                    <th>Jam 08</th>
                    <th>Jam 09</th>
                    <th>Jam 10</th>
                    <th>Jam 11</th>
                    <th>Jam 12</th>
                    <th>Jam 01</th>
                    <th>Jam 02</th>
                    <th>Jam 03</th>
                    <th>Jam 04</th>
                    <th>Jam 05</th>
                    <th>Total Ritase</th>
                    <th>Total BCM</th>
                    <th>Remarks</th>
                    
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>Action</th>
                    <th>No</th>
                    <th>Date</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>NIK</th>
                    <th>HM Start</th>
                    <th>HM End</th>
                    <th>Total HM</th>
                    <th>Distance</th>
                    <th>Material</th>
                    <th>Unit Loading</th>
                    <th>Jam 07</th>
                    <th>Jam 08</th>
                    <th>Jam 09</th>
                    <th>Jam 10</th>
                    <th>Jam 11</th>
                    <th>Jam 12</th>
                    <th>Jam 01</th>
                    <th>Jam 02</th>
                    <th>Jam 03</th>
                    <th>Jam 04</th>
                    <th>Jam 05</th>
                    <th>Total Ritase</th>
                    <th>Total BCM</th>
                    <th>Remarks</th>
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
  


