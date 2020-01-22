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
                                <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                              
                                <div class="col-sm-4">
                                          <?php
                                          $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                          echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="f_date_attd" class="col-sm-3 control-label">Employee Type</label>
                              
                                <div class="col-sm-4">
                                          <?php
                                          $attribute = 'class="form-control select2" id="f_emptype_f" style="width: 100%; display:none;"';
                                          echo form_dropdown('f_emptype_f', $dd_emp_status, $empcode_status_selected, $attribute);?><span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="f_date_attd" class="col-sm-3 control-label">Departement</label>
                              
                                <div class="col-sm-4">
                                          <?php
                                          $attribute = 'class="form-control select2" id="f_dept_f" style="width: 100%; display:none;"';
                                          echo form_dropdown('f_dept_f', $dd_dept, $dd_dept_selected, $attribute);?><span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="f_period" class="col-sm-3 control-label">Start Date</label>
                                <div class="col-sm-4">
                                  <input type="text" id="filter_start" name="filter_start" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="f_period" class="col-sm-3 control-label">End Date</label>
                                <div class="col-sm-4">
                                  <input type="text" id="filter_end" name="filter_end" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                                </div>
                            </div>                    
                            <div class="form-group">
                                <label for="LastName" class="col-sm-3 control-label"></label>
                                <div class="col-sm-4">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                                  <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                                    <button type="button" id="btn-reset_filter" onclick="reset_filter()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
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
              <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>         
            </div>

            <!-- /.box-header -->
<div class="table responsive">
            <div class="box-body">
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Employee Status</th>
                            <th>Company Begin</th>
                            <th style="width:150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                          <th>NIK</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Employee Status</th>
                          <th>Company Begin</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
              </div>
            <!-- /.box-body -->
            </div>
            <!-- table responsive -->
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
  