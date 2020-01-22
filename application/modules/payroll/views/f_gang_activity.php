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
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
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
                        <label for="f_attd_code" class="col-sm-3 control-label">Attendance Code</label>
                        <div class="col-sm-6">
                                  <?php
                                  $attribute_attd = 'class="form-control select2" id="f_attd_code_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_attd_code_f', $dd_attd_code, $attd_code_selected, $attribute_attd);?>
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_mass_update" class="col-sm-3 control-label">Shift</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_shift" id="f_shift" style="width: 100%;">
                                    <option value="OFF DAY">OFF DAY</option>
                                    <option value="SHIFT I">SHIFT I</option>
                                    <option value="SHIFT II">SHIFT II</option>
                                    
                                  </select>
                                  
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Work Hour</label>
                        <div class="col-sm-6">
                            <input type="text" id="filter_wh" name="filter_wh" class="form-control" placeholder="0.0"><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_gang" class="col-sm-3 control-label">Gang</label>
                        <div class="col-sm-6">
                                  <?php
                                  $attribute_attd = 'class="form-control select2" id="f_gang_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_gang_f', $dd_gang, $gang_selected, $attribute_attd);?>
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_mass_update" class="col-sm-3 control-label">Update Massal</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_mass_update_f" id="f_mass_update_f" style="width: 100%;">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                    
                                  </select>
                                  
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-4 control-label"></label>
                        <div class="col-sm-12">
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

        <!-- copy one data -->
        <div class="col-md-3">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-copy"></i> Copy Single Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <form action="#" id="form_copy" name="form_copy" class="form-horizontal">
                  <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Period</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <!-- <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block"> -->
                            <input type="text" name="filter_period" id="filter_period" class="form-control" placeholder="periode"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_year" id="filter_year" class="form-control" placeholder="Year"> <span class="help-block"></span>
                        </div>
                    </div>
                <div class="form-group">
                        <label for="f_empcode_copy" class="col-sm-3 control-label">Copy Name</label>
                       
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode_copy" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_copy', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                        <div class="col-sm-4">
                                  <button type="button" onclick="ajax_copy()" class="btn btn-primary"><i class="icon fa fa-save"></i> Copy</button>
                          
                        </div>
                    </div>

                   <!--  <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btnSave" onclick="ajax_copy()" class="btn btn-primary"><i class="icon fa fa-save"></i> Save</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div> -->
              </form>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->

        </div>
        <!-- end of copy one data -->
        <!-- copy data last month -->
        <div class="col-md-3">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-copy"></i> Copy Data Last Month</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <form action="#" id="form_copy_all" name="form_copy_all" class="form-horizontal">

                  <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Period</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <!-- <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block"> -->
                            <input type="text" name="filter_period" id="filter_period" class="form-control" placeholder="periode"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_year" id="filter_year" class="form-control" placeholder="Year"> <span class="help-block"></span>
                        </div>
                    </div>
                <div class="form-group">
                        <div class="col-sm-4">
                                  <button type="button" onclick="ajax_copy_all()" class="btn btn-primary"><i class="icon fa fa-save"></i> Copy</button>
                          
                        </div>
                    </div>

              </form>
            </div>
          </div>
        </div>
        <!-- copy data last month -->

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
        <input type="text" style="display:none;" name="f_id_emp_act_sk" id="f_id_emp_act_sk" value="">
        <div class="col-xs-3">
            <div class="form-group">
                        <label for="country" class="col-sm-4 control-label">Date</label>
                         <div class="col-sm-8">
                            <input type="text" name="f_date_attd" id="f_date_attd" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
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
                    <div class="form-group">
                        <label for="f_attd_code" class="col-sm-4 control-label">Attendance Code</label>
                        <div class="col-sm-8">
                                  <?php
                                  $attribute_attd = 'class="form-control select2" id="f_attd_code" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_attd_code', $dd_attd_code, $attd_code_selected, $attribute_attd);?>
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_mass_update" class="col-sm-4 control-label">Shift</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="f_work_shift" id="f_work_shift" style="width: 100%;">
                                    <option value="OFF DAY">OFF DAY</option>
                                    <option value="SHIFT I">SHIFT I</option>
                                    <option value="SHIFT II">SHIFT II</option>
                                    
                                  </select>
                                  
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_mass_update" class="col-sm-4 control-label">Update Massal</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="f_mass_update" id="f_mass_update" style="width: 100%;">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                    
                                  </select>
                                  
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_gang" class="col-sm-4 control-label">Gang</label>
                        <div class="col-sm-8">
                                  <?php
                                  $attribute_attd = 'class="form-control select2" id="f_gang" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_gang', $dd_gang, $gang_selected, $attribute_attd);?>
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Work_hours" class="col-sm-4 control-label">Work Hours</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_wh" id="f_wh" class="form-control" placeholder="Work Hours"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="callout callout-info" id="data_updated">
                <h4>Notification</h4>
                <p id="saved_message">Data Saved</p>
              </div>
                    <!-- 
                    <div class="form-group">
                        <label for="f_overtime" class="col-sm-4 control-label">Overtime</label>
                        <div class="col-sm-8">
                            <input type="text" name="f_overtime" id="f_overtime" class="form-control" placeholder="Overtime"> <span class="help-block"></span>
                        </div>
                    </div> -->
                                              <input type="text" name="f_shw" id="f_shw" readonly style="display:none;" > <span class="help-block"></span>
                          <input type="text" name="f_whtl" id="f_whtl" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_off_day" id="f_off_day" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_first_ot" id="f_first_ot" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_bantu_dua_satu" id="f_bantu_dua_satu" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_bantu22" id="f_bantu22" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_second_ot" id="f_second_ot" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_third_ot" id="f_third_ot" readonly style="display:none;"> <span class="help-block"></span>
                          <input type="text" name="f_fourth_ot" id="f_fourth_ot" readonly style="display:none;"> <span class="help-block"></span>
                    
                   
        </div>
        <div class="col-xs-8">


            <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Loss time</label>
                        <div class="col-sm-8">
                          <input type="checkbox" name="f_psk" value="1" id="f_psk"> <span class="help-block"></span>
                        </div>
          </div>

          

          <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">waktu loss time</label>
                        <div class="col-sm-8">
                          <input type="text" name="f_losstime" id="f_losstime"> <span class="help-block"></span>
                        </div>
          </div>

          <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label"> Reguler Hour</label>
                        <div class="col-sm-8">
                          <input type="text" name="f_reguler_hour" id="f_reguler_hour" readonly> <span class="help-block"></span>
                        </div>
          </div>



          <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label"> Total Jam Lembur</label>
                        <div class="col-sm-8">
                          <input type="text" name="f_total_lembur" id="f_total_lembur" readonly> <span class="help-block"></span>
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
              <table id="table" class="table table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <th>Attendance</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Work Hour</th>
                    <th>Overtime</th>
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
                  <th>Dept</th>
                  <th>Attendance</th>
                  <th>Date</th>
                  <th>Shift</th>
                  <th>Work Hour</th>
                  <th>Overtime</th>
               <!--  <th>Photo</th> -->
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
  

