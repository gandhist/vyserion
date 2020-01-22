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
              <form  id="form_filters" action="#"  class="form-horizontal">
                    <!-- <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Start Date</label>
                        <div class="col-sm-4">
                           <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-4">
                           <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                       
                        <div class="col-sm-4">
                                  
                                  <span class="help-block"></span>
                        </div>
                    </div> -->

                     <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Tanggal Awal</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Tanggal Akhir</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                            
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                            <!-- <button type="button" id="download" onclick="download_xls()" class="btn btn-primary">Download</button> -->
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

          <!-- form export data -->
<div class="col-md-6">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="glyphicon glyphicon-export"></i> Export Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- <form  id="form_export" method="POST" target="_blank" action="<?php echo base_url(); ?>hr/rpt_grafik_xls" class="form-horizontal"> -->
              <!-- <form  id="form_export"  action="<?php echo base_url(); ?>vehicle/test_jasper" target="_blank" method="POST" class="form-horizontal"> -->
              <form  id="form_export"  action="<?php echo base_url(); ?>vehicle/export_fuel_sarana" target="_blank" method="POST" class="form-horizontal">
                     <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Tanggal Awal</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_start" id="filter_start"  class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">Tanggal Akhir</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <!-- <input type="text" id="filter_year" name="filter_year" class="form-control" placeholder="2013"><span class="help-block"> -->
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_create_by" class="col-sm-3 control-label">Create By</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="f_create_by" name="f_create_by" class="form-control" placeholder="Name"><span class="help-block">
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="submit" id="xls" name="xls" class="btn btn-success"><i class="fa fa-file-excel-o"></i> XLS</button>
                            <button type="submit" id="pdf" name="pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</button>
                          
                                                     <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                            <button type="button" id="btn-reset_export" onclick="reset_export()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<!--  end of form export data -->
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
            <div id="divcanvas" style="width:100%;">
    <canvas id="mycanvas"></canvas>
    </div>

    <!-- <div class="col-xs-6">
      <h4 id="karyawan_masuk">
       Daftar Karyawan Masuk
      </h4>
      <table class="table table-striped table-bordered" id="dt_emp_in">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Date of Join</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Date of Join</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-xs-6">
      <h4 id="karyawan_keluar">
       Daftar Karyawan Keluar
      </h4>
      <table class="table table-striped table-bordered" id="dt_emp_out">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Date Termination</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Date Termination</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div> -->
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
  

