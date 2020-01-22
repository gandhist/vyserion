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
                    <!-- <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Start Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div> -->
                   <!--  <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Gang</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_gang_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_gang_f', $dd_gang, $gang_selected, $attribute);?><span class="help-block"></span>
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
                <h3 class="panel-title" >Input Gang Master : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
                    <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
                    <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
                    <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <!-- parameter untuk update dan delete -->
                    <input type="text" style="display:none;" name="f_id_gang_master" id="f_id_gang_master" value="">

        <div class="col-xs-6">

                   <div class="form-group">
                        <label for="f_date_attd" class="col-sm-2 control-label">Name</label>
                       
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_start_date" class="col-sm-2 control-label">Start Date</label>
                         <div class="col-sm-6">
                    <input type="text" id="f_start_date" name="f_start_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-2 control-label">Gang</label>
                       
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_gang" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_gang', $dd_gang, $gang_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="f_remarks" name="f_remarks"></textarea>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="f_active" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10">
                            <input type="radio" name="f_active" id="f_active" value="1"> Yes
                            <input type="radio"  name="f_active" id="f_active" value="0"> No
                        </div>
                    </div> -->

                  
</div>
        <div class="col-xs-6">
                  

                   

                    

                <!--     <div class="form-group">
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
              <table id="table" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th>No</th>
                    <th>Empcode</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Gang</th>
                    <th>Remarks</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>Empcode</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Gang</th>
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
  


