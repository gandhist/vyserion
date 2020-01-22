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
                <form id="form_roster"  target="_blank" method="POST" class="form-horizontal">

                     <div class="form-group">
                        <label for="f_condition" class="col-sm-2 control-label">Roster</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="f_rpt" id="f_rpt" style="width: 100%;">
                                    <option value="roster">ROSTER</option>
                                    <option value="monthly">MONTHLY ATTENDANCE</option>
                                    <option value="insentive">MONTHLY ATTENDANCE INSENTIVE</option>
                                  </select> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_condition" class="col-sm-2 control-label">Departement</label>
                        <div class="col-sm-6">
                            <?php
                            $attribute = 'class="form-control select2" id="f_dept" style="width: 100%; display: none;" ';
                            echo form_dropdown('f_dept',$dd_emp_dept, $dd_emp_dept_select, $attribute) 
                            ?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group" id="period" >
                        <label for="filter_month" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_start_date"> -->
                            <input type="number" id="periode" name="periode" class="form-control" placeholder="1 = January"><span class="help-block"> </span>
                        </div>
                    </div>

                    <div class="form-group" id="start_date" style="display:none;">
                        <label for="print_date" class="col-sm-2 control-label">Date Start</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" name="f_start_date" id="f_start_date" class="form-control" value="<?php echo date("01-m-Y"); ?>" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group" id="year">
                        <label for="filter_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="number" id="tahun" name="tahun" class="form-control" placeholder="2013" value="<?php echo date("Y"); ?>"><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group" id="end_date" style="display:none;">
                        <label for="print_date" class="col-sm-2 control-label">Date Finish</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" name="f_end_date" id="f_end_date" class="form-control" value="<?php echo date("d-m-Y"); ?>" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="print_date" class="col-sm-2 control-label">Date Create</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="filter_end_date"> -->
                            <input type="text" name="print_date" id="print_date" class="form-control" value="<?php echo date("d-m-Y"); ?>" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" id="btn-filter" class="btn btn-success"><i class="icon fa fa-file-excel-o"></i> Download</button>
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
  


