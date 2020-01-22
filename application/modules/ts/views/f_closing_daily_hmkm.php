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

        <div class="col-sm-12">
         <div class="box">
            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Closing Daily HMKM Unit : </h3>
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

        <div class="col-xs-6">
                    <div class="form-group">
                        <label for="f_year" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-6">
                            <input type="text" name="f_year" class="form-control" id="f_year" value="<?php echo date('Y'); ?>"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_period" class="col-sm-2 control-label">Period</label>
                        <div class="col-sm-6">
                            <input type="text" name="f_period" class="form-control" id="f_period" placeholder="8" value="<?php echo date('m'); ?>"> 
                                  <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-6 control-label"></label>
                        <div class="col-sm-12">
                          <!-- <input type="submit" name="submit" id="submit" value="submitform"> -->
                            <!-- <button type="button" id="btn-filter" class="btn btn-primary">Filter</button> -->
                            <button type="button" id="btnSave" onclick="add()" class="btn btn-primary"><i class="icon fa fa-save"></i> Closing</button>
                            <button type="button" id="btnSave" onclick="delete_all_data()" class="btn btn-warning"><i class="icon fa fa-trash"></i> Delete Data</button>
                            <button type="button" id="btn-reset" onclick="reset_form()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                    <div id="loading_closing" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
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
                 <!--    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button> -->

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
  

