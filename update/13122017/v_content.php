  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Title</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>

        <div class="box-body">
          <form id="form_empmaster" action="#">
          <div class="col-md-6">
              <div class="form-group">
                    <!-- membuat button sebagai submit -->
                    <button type="submit" onclick="btn_add_employee()" class="btn btn-app">
                    <i class="fa fa-plus"></i> Add Data
                    </button><p>double click for adding employee</p>
              <!-- membuat button sebagai submit --></br>
                <label>Nama Karyawan</label>
                <select class="form-control select2" placeholder = "Select Employee" id="select_empname" onchange ="get_data(this.value)" name="select_empname" style="width: auto;">
                  <option selected="selected">-- Select Employee --</option>
                  <!-- looping dropdown from database -->
                    <?php 
                    foreach ($data_empmaster->result() as $dt_empmaster) {
                      echo $dt_empmaster->empname;
                      echo "<option value =".$dt_empmaster->empcode.">".$dt_empmaster->empname."</option>";
                    }
                    ?>
                    <!-- looping dropdown from database -->
                </select>

              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
              <input type="text" name="empcode" >
              </div>
            </div>
<div class="col-md-2">
              <div class="form-group">
              <label>NIK</label>
                  <input type="text" size="" class="form-control" name="fi_empcode" readonly="" placeholder="NIK">
              </div>
              <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="fi_empname" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Other Name</label>
                  <input type="text" class="form-control" name="fi_othername" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Place Of Birth</label>
                  <input type="text" class="form-control" name="fi_birth_place"  placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Date Of Birth</label>
                  <input type="text" class="form-control" name="fi_dob" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Citizen</label>
                  <input type="text" class="form-control" name="fi_nationality" placeholder="Enter ...">
              </div>
          </div>
            <div class="col-md-2">
              <div class="form-group">
              <label>Sex</label>
                  <input type="text" size="" name="fi_sex" class="form-control" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Marrital Status</label>
                  <input type="text" class="form-control" name="fi_marrital_status" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Date Of Married</label>
                  <input type="text" class="form-control" name="fi_datemarried" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Religion</label>
                  <input type="text" class="form-control" name="fi_religion" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Blood type</label>
                  <input type="text" class="form-control" name="fi_bloodtype" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Number of Child</label>
                  <input type="text" class="form-control" name="fi_numberchild" placeholder="Enter ...">
              </div>
          </div>
            <div class="col-md-2">
              <div class="form-group">
              <label>Address</label>
                  <input type="text" size="" class="form-control" name="fi_address" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Province</label>
                  <input type="text" class="form-control" name="fi_province" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>City</label>
                  <input type="text" class="form-control" name="fi_city" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" name="fi_phonenumber" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="fi_email" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Site Id</label>
                  <input type="text" class="form-control" name="fi_site_id" placeholder="Enter ...">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
              <label>Company Begin</label>
                  <input type="text" size="" class="form-control" name="fi_company_begin" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Hire Date</label>
                  <input type="text" class="form-control" name="fi_hire_date" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Terminate Date</label>
                  <input type="text" class="form-control" name="fi_date_terminate" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Tax Status</label>
                  <input type="text" class="form-control" name="fi_tax_status" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>NPWP</label>
                  <input type="text" class="form-control" name="fi_npwp" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Jenis ID</label>
                  <input type="text" class="form-control" name="fi_no_id" placeholder="Enter ...">
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
              <label>Employee Status</label>
                  <input type="text" size="" class="form-control" name="fi_empstatus" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Payment Method</label>
                  <input type="text" class="form-control" name="fi_payment_method" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Bank Name</label>
                  <input type="text" class="form-control" name="fi_bank_name" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Bank Cabang</label>
                  <input type="text" class="form-control" name="fi_bank" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Bank Account No</label>
                  <input type="text" class="form-control" name="fi_bank_account" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Bank A/N</label>
                  <input type="text" class="form-control" name="fi_bank_an" placeholder="Enter ...">
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
              <label>No Jamsostek</label>
                  <input type="text" size="" class="form-control" name="fi_no_jamsostek" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Life Insurance No</label>
                  <input type="text" class="form-control" name="fi_life_insurance" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Labour Union</label>
                  <input type="text" class="form-control" name="fi_labour_union" placeholder="Enter ...">
              </div>
              <div class="form-group">
                  <label>Level Access</label>
                  <input type="text" class="form-control" name="fi_level_access" placeholder="Enter ...">
              </div>

              <div class="box-footer">
                 
                  <input type="submit" class="btn btn-info pull-right" name="SAVE" value="Save">
              </div>
          </div>
            <div class="col-md-12">
              <div class="form-group">
                                  <!-- membuat button sebagai submit -->
                    <button type="submit"  onclick="save()" class="btn btn-app">
                    <i class="fa fa-save"></i> Save
                    </button> 
                     <button type="submit"  onclick="save()" class="btn btn-primary">Save</button>
              <!-- membuat button sebagai submit -->                    <!-- membuat button sebagai submit -->
                    <button type="submit" class="btn btn-app">
                    <i class="fa fa-edit"></i> Edit
                    </button>
              <!-- membuat button sebagai submit -->
              </div>
            </div>

        <div>


            </div>
        </div>
<!-- <script type="text/javascript">
$("#select_empname").select2({
  placeholder:"Select Empname",
  ajax:{
    url:"<?php echo base_url(); ?>home/get_empname",
    dataType: 'json',
    data: function (params) {

            var queryParameters = {
                text: params.term
            }
            return queryParameters;
        } 
  },
  cache: true,
  minimumInputLength: 2,
  formatResult: format,
  formatSelection: format,
  escapeMarkup: function(m) { return m; }
});
function format(x)
{
  return x.text;
}
function get_data(v_id)
{
  alert('test');
  $.ajax({
    url :"<?php echo base_url();?>home/get_info",
    data:{id : v_id},
    success: function(data)
    {
      var dt = JSON.parse(data);
       $("input[name=nama_kota]").val(dt.name);
/*      $("input[name=nama]").val(dt.n_barang);
      $("input[name=type]").val(dt.tipe);
      $("input[name=merk]").val(dt.merk);
      $("input[name=h_jual]").val(dt.h_barang);
      $("input[name=h_beli]").val(dt.h_beli);
      $("input[name=stock]").val(dt.h_beli);*/
      
    }
  });
  
}
</script> -->
        </form>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
      </div>
  <!-- /.content-wrapper -->