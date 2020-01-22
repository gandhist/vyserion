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
                <form action="<?php echo base_url(); ?>vehicle/process_rpt_services" id="form-filter"  target="_blank" method="GET" class="form-horizontal">
                     <div class="form-group">
                        <label for="f_rpt_type" class="col-sm-2 control-label">Document Type</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="f_rpt_type" id="f_rpt_type" style="width: 100%;">
                                    <option value="daily">DAILY</option>
                                    <option value="monthly">MONTHLY</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_month" class="col-sm-2 control-label">Month</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="text" id="filter_month" name="filter_month" class="form-control" placeholder="1 = January"><span class="help-block">
                           <!--  <select class="form-control select2" name="filter_month" id="filter_month" style="width: 100%;">
                                    <?php 
                                    for ($i=1; $i <= 12 ; $i++) { 
                                      ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                      <?php
                                    }
                                    ?> 
                                    
                                  </select>  -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="filter_year" name="filter_year" class="form-control" value="<?php echo date("Y"); ?>" placeholder="2013"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="print_date" class="col-sm-2 control-label">Date Create</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" name="print_date" id="print_date" class="form-control" value="<?php echo date("d-m-Y"); ?>" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_create_by" class="col-sm-2 control-label">Create By</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" id="f_create_by" name="f_create_by" class="form-control" placeholder="Name"><span class="help-block">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" id="btn-filter" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download</button>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
              <!-- <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button> -->
              
<!--               <a href="<?php echo base_url(); ?>hr/laporan_pdf" target="_blank" >slip gaji</a>
              <a href="<?php echo base_url(); ?>hr/mpdf" target="_blank" >slip lembur</a>

              <button class="btn btn-default" ><i class="glyphicon glyphicon-refresh"></i> Report DomPDF</button>  -->
              <!-- <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>    -->      
             
 <!--              <a href="<?php echo base_url(); ?>c_laporan" class="btn btn-primary"> Laporan</a>
              <a href="<?php echo base_url(); ?>c_paklaring" class="btn btn-primary"> Paklaring</a> -->
            </div>

            <!-- /.box-header -->

    <!--         <div class="box-body">
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
              </div> -->
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
  