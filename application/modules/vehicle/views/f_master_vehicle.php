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
                                  $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
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
                <h3 class="panel-title" >Input Master Vehicle : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
        <input type="text" style="display:none;" name="f_id_vehicle" id="f_id_vehicle" value="">

        <div class="col-xs-6">
                    
                    <div class="form-group">
                        <label for="f_overtime" class="col-sm-2 control-label">Code Unit</label>
                        <div class="col-sm-10">
                            <!-- <input type="text" name="f_overtime" id="f_overtime" class="form-control" placeholder="hh:mm:ss" data-inputmask="'alias': 'hh:mm:ss'" data-mask > <span class="help-block"></span> -->
                            <input type="text" name="f_code_unit" id="f_code_unit" class="form-control" placeholder="Code Unit"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Nomor Polisi</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_nopol" id="f_nopol" class="form-control" placeholder="No Polisi"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">NAP</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_nap" id="f_nap" class="form-control" placeholder="NAP" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_empcode" class="col-sm-2 control-label">User</label>
                        <div class="col-sm-10">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Tahun</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_tahun" id="f_tahun" class="form-control" placeholder="yyyy" data-inputmask="'alias': 'yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_ownership" class="col-sm-2 control-label">Ownership</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_ownership" id="f_ownership" style="width: 100%;">
                                    <option value="ASSET PIM">ASSET PIM</option>
                                    <option value="TERJUAL">TERJUAL</option>
                                    <option value="RENTAL">RENTAL</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_status_unit" class="col-sm-2 control-label">Status Unit</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_status_unit" id="f_status_unit" style="width: 100%;">
                                    <option value="rfu">Ready</option>
                                    <option value="bd">Breakdown</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="f_group" class="col-sm-2 control-label">Group</label>
                      <div class="col-sm-10">
                          <?php $attribute = 'class="form-control select2" id="f_group" style="width:100%; display:none;"';
                          echo form_dropdown('f_group', $dd_vehicle_group, $vehicle_group_selected, $attribute);
                          ?><span class="help-block" ></span>
                      </div>
                    </div>

                    <div class="form-group">
                        <label for="f_work_unit" class="col-sm-2 control-label">Work Unit</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_work_unit" id="f_work_unit" style="width: 100%;">
                                    <option value="OP">OP</option>
                                    <option value="SP">SP</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_jenis_type" class="col-sm-2 control-label">Jenis</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_jenis_type" id="f_jenis_type" class="form-control" placeholder="Jenis/Type" > <span class="help-block"></span>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="f_jenis_type" class="col-sm-2 control-label">Model</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_model" id="f_model" class="form-control" placeholder="Model Unit" > <span class="help-block"></span>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="f_work_unit" class="col-sm-2 control-label">Type Unit</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_model" id="f_model" style="width: 100%;">
                                    <option value="EXCAVATOR">EXCAVATOR</option>
                                    <option value="DUMP TRUCK">DUMP TRUCK</option>
                                    <option value="GRADER">GRADER</option>
                                    <option value="OFF-HIGHWAY TRUCK">OFF-HIGHWAY TRUCK</option>
                                    <option value="POMPA">POMPA</option>
                                    <option value="WATER TRUCK">WATER TRUCK</option>
                                    <option value="FUEL TRUCK">FUEL TRUCK</option>
                                    <option value="LUBE TRUCK">LUBE TRUCK</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_no_mesin" class="col-sm-2 control-label">Manufacturer</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_manufacturer" id="f_manufacturer" class="form-control" placeholder="No Mesin" > <span class="help-block"></span>
                        </div>
                    </div>
</div>
        <div class="col-xs-6">
                    

                    

                    <div class="form-group">
                        <label for="f_no_rangka" class="col-sm-2 control-label">No Rangka</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_no_rangka" id="f_no_rangka" class="form-control" placeholder="No Rangka" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_no_mesin" class="col-sm-2 control-label">No Mesin</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_no_mesin" id="f_no_mesin" class="form-control" placeholder="No Mesin" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_no_mesin" class="col-sm-2 control-label">Serial Number Unit</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_sn" id="f_sn" class="form-control" placeholder="Serial Number Unit" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_engine_mmodel" class="col-sm-2 control-label">Engine Model</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_engine_model" id="f_engine_model" class="form-control" placeholder="Engine Model" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_engine_mmodel" class="col-sm-2 control-label">Engine SN</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_engine_sn" id="f_engine_sn" class="form-control" placeholder="Engine Serial Number" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_silinder" class="col-sm-2 control-label">Isi Silinder</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_silinder" id="f_silinder" class="form-control" placeholder="Isi Silinder" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_tanggal_terima" class="col-sm-2 control-label">Tanggal di Terima</label>
                         <div class="col-sm-10">
                    <input type="text" id="f_tanggal_terima" name="f_tanggal_terima" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_pm_service" class="col-sm-2 control-label">PM Service</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_pm_service" id="f_pm_service" class="form-control" placeholder="PM Service" > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_remarks" name="f_remarks"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_active" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10">
                            <input type="radio" name="f_active" id="f_active" value="1"> Yes
                            <input type="radio"  name="f_active" id="f_active" value="0"> No
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_active" class="col-sm-2 control-label">Report BD?</label>
                        <div class="col-sm-10">
                            <input type="radio" name="f_to_rpt_bd" id="f_to_rpt_bd" value="1"> Yes
                            <input type="radio"  name="f_to_rpt_bd" id="f_to_rpt_bd" value="0"> No
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_active" class="col-sm-2 control-label">Report HM?</label>
                        <div class="col-sm-10">
                            <input type="radio" name="f_to_rpt_hm" id="f_to_rpt_hm" value="1"> Yes
                            <input type="radio"  name="f_to_rpt_hm" id="f_to_rpt_hm" value="0"> No
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

                    <!-- <div class="form-group">
                        <label for="f_active" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10">
                            <input type="radio" name="f_active" id="f_active" value="1"> Yes
                            <input type="radio"  name="f_inactive" id="f_inactive" value="0"> No
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_tanggal_terima" id="label_inactive_date" class="col-sm-2 control-label">Inactive date</label>
                         <div class="col-sm-10">
                    <input type="text" id="f_inactive_date" name="f_inactive_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                        </div>
                    </div> -->
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
                    <th>No Polisi</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>User</th>
                    <th>Jenis/Type</th>
                    <th>Tahun</th>
                    <th>Status Asset</th>
                    <th>Status Unit</th>
                    <th>Keterangan</th>
                    <th>Tanggal Terima</th>
                    <th>No Rangka</th>
                    <th>No Mesin</th>
                    <th>Isi Cyllinder</th>
                    <th>Remarks</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    
                    <th>No</th>
                    <th>No Polisi</th>
                    <th>Code Unit</th>
                    <th>NAP</th>
                    <th>User</th>
                    <th>Jenis/Type</th>
                    <th>Tahun</th>
                    <th>Status Asset</th>
                    <th>Status Unit</th>
                    <th>Keterangan</th>
                    <th>Tanggal Terima</th>
                    <th>No Rangka</th>
                    <th>No Mesin</th>
                    <th>Isi Cyllinder</th>
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
  


