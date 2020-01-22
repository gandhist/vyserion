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
                        <label for="filter_desc" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_desc" id="filter_desc" class="form-control" placeholder="Keyword Description"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="filter_act" class="col-sm-3 control-label">Action</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_act" id="filter_act" class="form-control" placeholder="Keyword Action"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Report By</label>
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="filter_status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="filter_status" id="filter_status" style="width: 100%;">
                                    <option value="open">Open</option>
                                    <option value="1">On Progress</option>
                                    <option value="2">Closed</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                           <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                            <button type="button" id="btn-reset" onclick="reset_form_filter()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
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
                <h3 class="panel-title" >Input Inspection Finding : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
        <input type="text" style="display:none;" name="f_id" id="f_id" value="">

        <div class="col-xs-6">

                    <div class="form-group">
                        <label for="f_tanggal_terima" id="label_inactive_date" class="col-sm-2 control-label">Date</label>
                         <div class="col-sm-10">
                    <input type="text" id="f_date" name="f_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_desc" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_desc" name="f_desc"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label">Unit (optional)</label>
                        <div class="col-sm-10">
                        <?php
                                  $attribute = 'class="form-control select2" id="f_nap" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap', $dd_vehicle, $vehicle_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Category</label>
                         <div class="col-sm-10">
                            <select class="form-option select2" name="f_category" id="f_category" style="width:100%;">
                                <option value="0"> TTA</option>
                                <option value="1"> KTA</option>
                            </select> <span class="help-block"></span>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label for="f_empcode" class="col-sm-2 control-label">Report By</label>
                        <div class="col-sm-10">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_reportby" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_reportby', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    

                   
</div>
        <div class="col-xs-6">

        <div class="form-group">
                        <label for="f_overtime" class="col-sm-2 control-label">Dept In Charge</label>
                        <div class="col-sm-10">
                        <?php
                                  $attribute = 'class="form-control select2" id="f_dept" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_dept', $dd_dept, $dept_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_act" class="col-sm-2 control-label">Action</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="f_act" name="f_act"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_comp" class="col-sm-2 control-label">Company</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_comp" id="f_comp" class="form-control" placeholder="Company Name" value="PT. Prima Indojaya Mandiri"> <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_ownership" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="f_status" id="f_status" style="width: 100%;">
                                    <option value="0">Open</option>
                                    <option value="1">On Progress</option>
                                    <option value="2">Closed</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_prior" class="col-sm-2 control-label">Priority</label>
                         <div class="col-sm-10">
                            <input type="text" name="f_prior" id="f_prior" class="form-control" placeholder="Priority" > <span class="help-block"></span>
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
                    <th>No</th>
                    <th>Date</th>
                    <th>Desc</th>
                    <th>Code Unit</th>
                    <th>Category</th>
                    <th>Report By</th>
                    <th>DIC</th>
                    <th>Action</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Priority</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Desc</th>
                    <th>Code Unit</th>
                    <th>Category</th>
                    <th>Report By</th>
                    <th>DIC</th>
                    <th>Action</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Priority</th>
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
  



