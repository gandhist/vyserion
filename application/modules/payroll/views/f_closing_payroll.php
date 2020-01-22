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
                        <label for="fiter_period" class="col-sm-3 control-label">Period Closing</label>
                        <div class="col-sm-4">
                            <input type="number" name="filter_period" id="filter_period" class="form-control" placeholder="Period"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-4">
                            <input type="number" name="filter_year" id="filter_year" class="form-control" placeholder="Year"> <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_dept" class="col-sm-3 control-label">Departement</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="filter_dept" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_dept', $dd_emp_dept, $dd_emp_dept_select, $attribute);?><span class="help-block"></span>
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

        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" ><?php echo $title; ?> : </h3>
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
                        <label for="f_period" class="col-sm-4 control-label">Period Closing</label>
                        <div class="col-sm-8">
                            <input type="number" name="f_period" id="f_period" class="form-control" placeholder="Period"> <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_year" class="col-sm-4 control-label">Year</label>
                        <div class="col-sm-8">
                            <input type="number" name="f_year" id="f_year" class="form-control" placeholder="Year"> <span class="help-block"></span>
                        </div>
                    </div>

                    

                    

                     <div class="form-group">
                        <label for="LastName" class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-check"></i> Closing</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>

 
        </div>
                    
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
                    <th>Period</th>
                    <th>Year</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Grade</th>
                    <th>Basic</th>
                    <th>Absent</th>
                    <th>Basic Proporsional</th>
                    <th>Basic SIA</th>
                    <th>Deduction</th>
                    <th>insentive attendance</th>
                    <th>Departement</th>
                    <th>Allowance</th>
                    <th>Jamsostek</th>
                    <th>JPK</th>
                    <th>Work Day</th>
                    <th>Monthly</th>
                    <th>Pay/Hour</th>
                    <th>Overtime</th>
                    <th>Paid Overtime</th>
                    <th>Insentive Snack</th>
                    <th>Income</th>
                    <th>All Deduction</th>
                    <th>THP</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
            <th>No</th>
                    <th>Period</th>
                    <th>Year</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Grade</th>
                    <th>Basic</th>
                    <th>Absent</th>
                    <th>Basic Proporsional</th>
                    <th>Basic SIA</th>
                    <th>Deduction</th>
                    <th>insentive attendance</th>
                    <th>Departement</th>
                    <th>Allowance</th>
                    <th>Jamsostek</th>
                    <th>JPK</th>
                    <th>Work Day</th>
                    <th>Monthly</th>
                    <th>Pay/Hour</th>
                    <th>Overtime</th>
                    <th>Paid Overtime</th>
                    <th>Insentive Snack</th>
                    <th>Income</th>
                    <th>All Deduction</th>
                    <th>THP</th>
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
  

