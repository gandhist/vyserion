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
        <div class="col-xs-12">
         <div class="box">

            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Filter Data : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
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
                        <label for="filter_emp_status" class="col-sm-2 control-label">Employee Status</label>
                        <div class="col-sm-4">
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="filter_emp_status" style="width: 100%; display:none;"';
                                  echo form_dropdown('filter_emp_status', $dd_emp_status, $empcode_status_selected, $dept_attribute);
                                  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_start_date" class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="text" id="filter_start_date" name="filter_start_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_end_date" class="col-sm-2 control-label">End Date</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_end_date" name="filter_end_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
              <!-- <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> -->
              
             <!--  <a href="<?php echo base_url(); ?>hr/laporan_pdf" target="_blank" >slip gaji</a>
              <a href="<?php echo base_url(); ?>hr/mpdf" target="_blank" >slip lembur</a>

              <button class="btn btn-default" ><i class="glyphicon glyphicon-refresh"></i> Report DomPDF</button>  -->
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
                    <th>No</th>
                    <th>RN</th>
                    <th>NIK</th>
                    <th>Badgenumber</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Home Phone</th>
                    <th>Mobile Phone</th>
                    <th>Email</th>
                    <th>Religion</th>
                    <th>Departement</th>
                    <th>Contract Status</th>
                    <th>NPWP</th>
                    <th>No Jamsostek</th>
                    <th>No BPJS</th>
                    <th>ID Number(KTP)</th>
                    <th>DOJ</th>
                    <th>Position</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>Sim Type</th>
                    <th>Sim Number</th>
                    <th>Sim Valid</th>
                   <!--  <th>Photo</th> -->
                    <!-- <th style="width:150px;">Action</th> -->
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                  <th>No</th>
                    <th>RN</th>
                    <th>NIK</th>
                    <th>Badgenumber</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Home Phone</th>
                    <th>Mobile Phone</th>
                    <th>Email</th>
                    <th>Religion</th>
                    <th>Departement</th>
                    <th>Contract Status</th>
                    <th>NPWP</th>
                    <th>No Jamsostek</th>
                    <th>No BPJS</th>
                    <th>ID Number(KTP)</th>
                    <th>DOJ</th>
                    <th>Position</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>Sim Type</th>
                    <th>Sim Number</th>
                    <th>Sim Valid</th>
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
  

