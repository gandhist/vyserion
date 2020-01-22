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
             
              <!-- <button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add Document</button> -->
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
<!-- example -->

        </form>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
<!-- data akan tampil jika field yang ditampilkan sebagai datatables sudah di isi, baik secara form atau databse -->
              <table id="table" class="table table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th> No</th>
                    <th> NIK</th>
                    <th> Name</th>
                    <th> Contract Status</th>
                    <th> No Contract</th>
                    <th> Start Date</th>
                    <th> End Date</th>
                    <th> Sign Date</th>
                    <th> Day Reminder</th>
                    <th> Due Date</th>
                    <th> Status</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                    <th> No</th>
                    <th> NIK</th>
                    <th> Name</th>
                    <th> Contract Status</th>
                    <th> No Contract</th>
                    <th> Start Date</th>
                    <th> End Date</th>
                    <th> Sign Date</th>
                    <th> Day Reminder</th>
                    <th> Due Date</th>
                    <th> Status</th>
                <th>Action</th>
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
  

