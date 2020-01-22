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
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-filter"></i>Rekap Insentive Kopi</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form action="<?php echo base_url() ?>payroll/rekap_kopi" id="form_copy" name="form_copy" method="POST" class="form-horizontal">
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
              
                        <div class="col-sm-4">
                                  <!-- <button type="button" onclick="ajax_copy()" class="btn btn-primary"><i class="icon fa fa-save"></i> Copy</button> -->
                                  <button type="submit" id="xls" name="xls" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download</button>
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
              <h3 class="box-title" data-widget="collapse"><i class="glyphicon glyphicon-import"></i> Rekap Uang Makan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
            <form action="<?php echo base_url() ?>payroll/rekap_uang_makan" id="form_copy" name="form_copy" method="POST" class="form-horizontal">
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
              
                        <div class="col-sm-4">
                                  <!-- <button type="button" onclick="ajax_copy()" class="btn btn-primary"><i class="icon fa fa-save"></i> Copy</button> -->
                                  <button type="submit" id="xls" name="xls" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download</button>
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
                <h3 class="panel-title" >Report Rekap Sallary : </h3>
            </div>
            <div class="panel-body">
                <form  id="form-filter"  target="_blank" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="filter_empcode" class="col-sm-2 control-label">NIK Staff</label>
                        <div class="col-sm-4">
                            <?php
                                  $attribute = 'class="form-control select2" id="filter_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_empcode', $dd_empcode, $empcode_selected, $attribute);
                                  ?> 
                                 <!--  <input type="text" name="empcode" id="empcode"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_dept" class="col-sm-2 control-label">Departement</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_dept" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_dept', $dd_emp_dept, $dd_emp_dept_select, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_position" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_position" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_position', $dd_emp_pos, $dd_emp_pos_select, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_month" class="col-sm-2 control-label">Month</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="number" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January" value="<?php echo date("m"); ?>"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="number" id="filter_year" name="filter_year" class="form-control" placeholder="2013" value="<?php echo date("Y"); ?>"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="print_date" class="col-sm-2 control-label">Date Create</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" name="print_date" id="print_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?php echo date("d-m-Y"); ?>"> <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="print_date" class="col-sm-2 control-label">Report Format</label>
                        <div class="col-sm-4">
                        <select class="form-control select2" id="f_type" style="width:100%; display:none;">
                        <option value="xls">Spreadsheet</option>
                        <option value="pdf">PDF</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" id="btn-filter" class="btn btn-danger"><i class="icon fa fa-file-pdf-o"></i> Download</button>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
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
  
