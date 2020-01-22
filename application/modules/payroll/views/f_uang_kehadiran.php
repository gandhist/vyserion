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
<div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Expandable</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              The body of the box
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Setup Parameter UMP/S : </h3>
            </div>

            <div class="panel-body">
                <!-- <form id="form-filter" class="form-horizontal"> -->
                  <form action="#" id="form" class="form-horizontal">
                    <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
        <input type="text" style="display:none;" name="f_id" id="f_id" value="">

                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Effective Date</label>
                         <div class="col-sm-4">
                            <input type="text" name="f_date" id="f_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div>
                  
              
                    <div class="form-group">
                        <label for="f_rate" class="col-sm-2 control-label">Rate</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" name="f_overtime" id="f_overtime" class="form-control" placeholder="hh:mm:ss" data-inputmask="'alias': 'hh:mm:ss'" data-mask > <span class="help-block"></span> -->
                            <input type="text" name="f_rate" id="f_rate" class="form-control" placeholder="Rate"> <span class="help-block"></span>
                        </div>
                        
                     <!--    <div class="col-sm-2">
                            <input type="text" name="f_date_attd" id="f_date_attd" class="form-control" placeholder="hh:mm:ss" data-inputmask="'alias': 'hh:mm:ss'" data-mask > <span class="help-block"></span>
                        </div> -->
                    </div>
                    
                    <div class="form-group">
                        <label for="f_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="f_remarks" name="f_remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <!-- <button type="button" id="save" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default">Reset</button>
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
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Rate</th>
                    <th>Effective Date</th>
                    <th>Remarks</th>
                   <!--  <th>Photo</th> -->
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>id</th>
                    <th>Rate</th>
                    <th>Effective Date</th>
                    <th>Remarks</th>
                   <!--  <th>Photo</th> -->
                    <th style="width:150px;">Action</th>
            </tr>
            </tfoot>
        </table>
                    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>

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
  

