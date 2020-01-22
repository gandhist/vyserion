<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Report Overtime
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Report</a></li>
        <li class="active">Report Overtime</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">

            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Filter Data : </h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo base_url(); ?>payroll/slip_overtime"  id="form-filter" target="_blank" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="filter_empcode" class="col-sm-2 control-label">NIK Staff</label>
                        <div class="col-sm-4">
                            <!-- <?php echo $form_country; ?> -->
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
                            <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
              <!-- <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> -->
              
              <a href="<?php echo base_url(); ?>hr/laporan_pdf" target="_blank" >slip gaji</a>
              <a href="<?php echo base_url(); ?>hr/mpdf" target="_blank" >slip lembur</a>

              <button class="btn btn-default" ><i class="glyphicon glyphicon-refresh"></i> Report DomPDF</button> 
              <!-- <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>    -->      
             
 <!--              <a href="<?php echo base_url(); ?>c_laporan" class="btn btn-primary"> Laporan</a>
              <a href="<?php echo base_url(); ?>c_paklaring" class="btn btn-primary"> Paklaring</a> -->
            </div>

            <!-- /.box-header -->

            <div class="box-body">
<!-- <input type="text" name="nik_awal" id="nik_awal">
<input type="text" name="nik_akhir" id="nik_akhir"> -->
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Departement</th>
                    <th>Position</th>
                    <th>Tanggal</th>
                    <th>Amount</th>
                    <th>Allowded Code</th>
                    <th>Description</th>
                    <th>Remarks</th>

                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Departement</th>
                    <th>Position</th>
                    <th>Tanggal</th>
                    <th>Amount</th>
                    <th>Allowded Code</th>
                    <th>Description</th>
                    <th>Remarks</th>
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
  



  <!-- footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 18.0.0
    </div>
    <strong><a href="https://adminlte.io">IT TEAM</a> &copy; 2018-Now .</strong> All rights
    reserved.
  </footer>


    <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->