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
                        <label for="filter_month" class="col-sm-3 control-label">Period</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January" value="<?php echo date('m'); ?>"><span class="help-block">
                            <!-- <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > --> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013" value="<?php echo date('Y') ?>" ><span class="help-block">
                            <!-- <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > --> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group has-error">
                        <label for="f_nap" class="col-sm-3 control-label">Code Unit</label>
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="filter_code_unit" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_code_unit', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
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
        <div class="col-xs-12" >
         <div class="box">
            <div class="box-header" id="box_input">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Input Daily HMKM Unit : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                  <!-- <form action="<?php echo base_url(); ?>ts/get_biggest_hm" method='POST' id="form" class="form-horizontal"> -->
                    <input type="text" style="display:none;" name="f_input_by" id="f_input_by" value="">
                    <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
                    <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
                    <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                    <input type="text" style="display:none;" name="f_id_hm" id="f_id_hm" value="">
                    <input type="text" style="display:none;" name="status_bd_temp" id="status_bd_temp" >

        <div class="col-xs-3">

          <div class="form-group">
                        <label for="f_nap" class="col-sm-2 control-label">Code Unit</label>
                        <div class="col-sm-6">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_code_unit" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_code_unit', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-6">
                            <input type="text" name="f_year" class="form-control" id="f_year" placeholder="2018"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_period" class="col-sm-2 control-label">Period</label>
                        <div class="col-sm-6">
                            <input type="text" name="f_period" class="form-control" id="f_period" placeholder="8"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>


        </div>
        <!-- sisi seblah -->
        <div class="col-xs-3">
                    <div class="form-group">
                        <label for="f_d1" class="col-sm-1 control-label">D1</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d1" class="form-control" id="f_d1"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d2" class="col-sm-1 control-label">D2</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d2" class="form-control" id="f_d2"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d3" class="col-sm-1 control-label">D3</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d3" class="form-control" id="f_d3"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d4" class="col-sm-1 control-label">D4</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d4" class="form-control" id="f_d4"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d5" class="col-sm-1 control-label">D5</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d5" class="form-control" id="f_d5"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d6" class="col-sm-1 control-label">D6</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d6" class="form-control" id="f_d6"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d7" class="col-sm-1 control-label">D7</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d7" class="form-control" id="f_d7"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d8" class="col-sm-1 control-label">D8</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d8" class="form-control" id="f_d8"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d9" class="col-sm-1 control-label">D9</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d9" class="form-control" id="f_d9"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d10" class="col-sm-1 control-label">D10</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d10" class="form-control" id="f_d10"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    


                     
        </div>
        <!-- end of sisi sebelah -->

        <!-- sisi sebelah kanan -->
        <!-- sisi seblah -->
        <div class="col-xs-3">

          <div class="form-group">
                        <label for="f_d1" class="col-sm-1 control-label">D11</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d11" class="form-control" id="f_d11"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d12" class="col-sm-1 control-label">D12</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d12" class="form-control" id="f_d12"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d13" class="col-sm-1 control-label">D13</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d13" class="form-control" id="f_d13"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d14" class="col-sm-1 control-label">D14</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d14" class="form-control" id="f_d14"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d15" class="col-sm-1 control-label">D15</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d15" class="form-control" id="f_d15"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d16" class="col-sm-1 control-label">D16</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d16" class="form-control" id="f_d16"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d17" class="col-sm-1 control-label">D17</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d17" class="form-control" id="f_d17"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d18" class="col-sm-1 control-label">D18</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d18" class="form-control" id="f_d18"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d19" class="col-sm-1 control-label">D19</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d19" class="form-control" id="f_d19"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d20" class="col-sm-1 control-label">D20</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d20" class="form-control" id="f_d20"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
          
                 
        </div>
        <!-- end of sisi sebelah kanan -->

        <!-- sisi kanan -->
         <div class="col-xs-3">

          <div class="form-group">
                        <label for="f_d21" class="col-sm-1 control-label">D21</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d21" class="form-control" id="f_d21"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d22" class="col-sm-1 control-label">D22</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d22" class="form-control" id="f_d22"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d23" class="col-sm-1 control-label">D23</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d23" class="form-control" id="f_d23"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d24" class="col-sm-1 control-label">D24</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d24" class="form-control" id="f_d24"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d25" class="col-sm-1 control-label">D25</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d25" class="form-control" id="f_d25"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d26" class="col-sm-1 control-label">D26</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d26" class="form-control" id="f_d26"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d27" class="col-sm-1 control-label">D27</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d27" class="form-control" id="f_d27"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d28" class="col-sm-1 control-label">D28</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d28" class="form-control" id="f_d28"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d29" class="col-sm-1 control-label">D29</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d29" class="form-control" id="f_d29"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d30" class="col-sm-1 control-label">D30</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d30" class="form-control" id="f_d30"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_d31" class="col-sm-1 control-label">D31</label>
                        <div class="col-sm-4">
                            <input type="text" name="f_d31" class="form-control" id="f_d31"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-8">
                          <!-- <input type="submit" name="submit" id="submit" value="submitform"> -->
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-save"></i> Save</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
        </div>
        <!-- sisi kanan -->
                    
                </form>
            </div>
        </div>
    

            </div>


            <!-- /.box-header -->

            <div class="box-body">
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th style="width:60px;">Action</th>
                    <th>NAP</th>
                    <th>Code Unit</th>
                    <th>Year</th>
                    <th>Period</th>
                    <?php 
                    for ($i=1; $i <=31 ; $i++) { 
                      ?>
                    <th><?php echo "D".$i; ?></th>
                      <?php 
                    }

                    ?>
                    
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>No</th>
                    <th>Action</th>
                    <th>NAP</th>
                    <th>Code Unit</th>
                    <th>Year</th>
                    <th>Period</th>
                    <?php 
                    for ($i=1; $i <=31 ; $i++) { 
                      ?>
                    <th><?php echo "D".$i; ?></th>
                      <?php 
                    }

                    ?>
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
  

