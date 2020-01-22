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
                        <label for="filter_month" class="col-sm-3 control-label">Bulan</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="text" id="filter_bulan" name="filter_bulan" class="form-control" placeholder="1 = January"><span class="help-block">
                            <!-- <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Tahun</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block">
                            <!-- <input type="text" name="filter_tahun" id="filter_tahun" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">NAP</label>
                       
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
                <h3 class="panel-title" >Vehicle Service Setup : </h3>
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
                        <label for="f_nap" class="col-sm-2 control-label">NAP</label>
                        <div class="col-sm-10">
                        
                                  <?php
                                  $attribute = 'class="form-control select2" onclick="nap_click()" id="f_nap" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">No Polisi</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_nopol" id="f_nopol" readonly class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Tahun</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_year" id="f_year" readonly class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Code Unit</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_code_unit" id="f_code_unit" readonly  class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Status</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_status" id="f_status" readonly  class="form-control" placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">User</label>
                           <div class="col-sm-10">
                            <input type="text" name="f_users" id="f_users"  class="form-control" style="width: 100%; display:none;" placeholder=""> <span class="help-block"></span>
                        
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_user" disabled style="width: 100%; display:none;"';
                                  echo form_dropdown('f_user', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                   
</div>
<div class="col-xs-6">
           <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Bulan</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_month" id="f_month" class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Tahun</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_tahun" id="f_tahun" class="form-control"  placeholder=""> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Last Service</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_last_service" id="f_last_service" class="form-control"  placeholder=""> KM <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_service_at"  class="col-sm-2 control-label">Service At : </label>
                    <div class="col-sm-10">
                            <input type="radio" name="f_service_at" id="f_service_at" value="0"> Own
                            <input type="radio" name="f_service_at" id="f_service_at" value="1"> Vendor <span class="help-block"></span>
                        </div>
                        </div>

                    <div class="form-group">
                        <label for="f_masa_berlaku"  class="col-sm-2 control-label">Next Service</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_next_service" id="f_next_service" class="form-control"  placeholder=""> KM <span class="help-block"></span>
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
                    <th>NAP</th>
                    <th>No Polisi</th>
                    <th>Code Unit</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Last Service</th>
                    <th>Next Service</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>NAP</th>
                    <th>No Polisi</th>
                    <th>Code Unit</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Last Service</th>
                    <th>Next Service</th>
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
  


