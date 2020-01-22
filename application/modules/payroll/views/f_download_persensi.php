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
                    <!-- <div class="form-group">
                        <label for="filter_month" class="col-sm-3 control-label">Start Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_start" id="filter_start" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div> -->
                   <!--  <div class="form-group">
                        <label for="filter_year" class="col-sm-3 control-label">End Date</label>
                        <div class="col-sm-4">
                            <input type="text" name="filter_end" id="filter_end" class="form-control" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Name</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_empcode_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_f', $dd_empcode, $empcode_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_date_attd" class="col-sm-3 control-label">Gang</label>
                       
                        <div class="col-sm-4">
                                  <?php
                                  $attribute = 'class="form-control select2" id="f_gang_f" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_gang_f', $dd_gang, $gang_selected, $attribute);?><span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_period" class="col-sm-3 control-label">Start Date</label>
                         <div class="col-sm-4">
                          <input type="text" id="f_start_date_f" name="f_start_date_f" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>
                  
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f_year" class="col-sm-3 control-label">End Date</label>
                         <div class="col-sm-4">
                    <input type="text"  id="f_end_date_f" name="f_end_date_f" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="LastName" class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="icon fa fa-filter"></i> Filter</button>
                           <!--  <button type="button" id="btnSave" onclick="add()" class="btn btn-primary">Save</button> -->
                            <button type="button" id="btn-reset_f" onclick="reset_form_filter()" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- clear log -->
        <div class="col-md-3">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-eraser"></i> Clear Log Data Persensi</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="#" id="form_clear_logs" class="form-horizontal">
                    <div class="form-group">
                        <label for="IP" class="col-sm-4 control-label">IP Address</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" id="ip_address" name="ip_address" class="form-control" value="192.168.11.236" placeholder="127.0.0.1"> -->
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="ip_address_clearlogs" style="width: 100%; display:none;"';
                                  echo form_dropdown('ip_address_clearlogs', $dd_mesin, $mesin_selected, $dept_attribute);
                                  ?><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="IP" class="col-sm-4 control-label">Com Key</label>
                        <div class="col-sm-6">
                            <input type="text" id="com_key_clearlogs" name="com_key_clearlogs" class="form-control" value="0" ><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4">
                            <button type="button" id="clear_logs" class="btn btn-primary"><i class="icon fa fa-eraser"></i> Clear Logs</button>
                            <!-- <div id="clear_indicator" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div> -->
                        </div>
                        <div class="col-sm-4">
                            <button type="button" id="btn-reset_clearlogs" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                          
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- end of clear log -->


        <!-- syncronize time -->
        <div class="col-md-3">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title" data-widget="collapse"><i class="fa fa-clock-o"></i> Synchronize Time Attendance</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="#" id="form_clear_logs" class="form-horizontal">
                    <div class="form-group">
                        <label for="IP" class="col-sm-4 control-label">IP Address</label>
                        <div class="col-sm-6">
                            <!-- <input type="text" id="ip_address" name="ip_address" class="form-control" value="192.168.11.236" placeholder="127.0.0.1"> -->
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="ip_address_synctime" style="width: 100%; display:none;"';
                                  echo form_dropdown('ip_address_synctime', $dd_mesin, $mesin_selected, $dept_attribute);
                                  ?><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="IP" class="col-sm-4 control-label">Com Key</label>
                        <div class="col-sm-6">
                            <input type="text" id="com_key_synctime" name="com_key_synctime" class="form-control" value="0" ><span class="help-block">
                        </div>
                    </div>
                   
                   <div class="progress">
                <div id="sync_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  <span class="sr-only">0% Complete</span>
                </div>
              </div>

                    <div class="form-group">
                        <div class="col-sm-4">
                            <button type="button" id="synctime" class="btn btn-primary"><i class="icon fa fa-clock-o"></i> Synchronize</button>
                           <!--  <div id="sync_indicator" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div> -->
                        </div>
                        <div class="col-sm-4">
                            <button type="button" id="btn-reset_synctime" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                          
                        </div>
                    </div>
                </form>
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
        </div>
        <!-- end of syncronize time -->
<!--  end of form filter data -->
        <div class="col-xs-12">
         <div class="box">

            <div class="box-header">
             <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Download Data : </h3>
            </div>
            <div class="panel-body">
                <form action="#" id="form" class="form-horizontal">
                <div class="col-sm-12">
                        <div class="col-sm-4" id="236_connect">
                            <div class="callout callout-success" >
                            <h4>Fingerprint X100C</h4>
                            <p>Connected to Fingerprint Produksi 01.</p>
                            </div>
                        </div>
                        <div class="col-sm-4" id="236_disconnect">
                            <div class="callout callout-danger" >
                            <h4>Fingerprint X100C</h4>
                            <p>Unable to Connect to Fingerprint Produksi 01.</p>
                            </div>
                        </div>
                        <div class="col-sm-4" id="223_connect">
                            <div class="callout callout-success" >
                            <h4>Fingerprint X100C</h4>
                            <p>Connected to Fingerprint Produksi 02.</p>
                            </div>
                        </div>
                        <div class="col-sm-4"  id="223_disconnect">
                            <div class="callout callout-danger">
                            <h4>Fingerprint X100C</h4>
                            <p>Unable to Connect to Fingerprint Produksi 02.</p>
                            </div>
                        </div>
                </div>                    
                    <div class="form-group">
                        <label for="IP" class="col-sm-2 control-label">IP Address</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" id="ip_address" name="ip_address" class="form-control" value="192.168.11.236" placeholder="127.0.0.1"> -->
                            <?php
                                  $dept_attribute = 'class="form-control select2" id="ip_address" style="width: 100%; display:none;"';
                                  echo form_dropdown('ip_address', $dd_mesin, $mesin_selected, $dept_attribute);
                                  ?><span class="help-block">
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="IP" class="col-sm-2 control-label">Com Key</label>
                        <div class="col-sm-4">
                            <input type="text" id="com_key" name="com_key" class="form-control" value="0" ><span class="help-block">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="<!-- LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="download" class="btn btn-primary"><i class="icon fa fa-download"></i> Download</button>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="icon fa fa-history"></i> Reset</button>
                            <div id="download_indicator" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    
                        </div>
                    </div>
                </form>
            


                </div>
            </div>
        </div>
         <div class="box-body">
              <table id="table" class="table table-striped table-bordered" cellspacing="0">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Nama</th>
                    <th>Tanggal & Jam</th>
                    <th>Verifikasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th>User ID</th>
                    <th>Nama</th>
                    <th>Tanggal & Jam</th>
                    <th>Verifikasi</th>
                    <th>Status</th>
            </tr>
            </tfoot>
        </table>


              </div>
            <!-- /.box-body -->
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
  


