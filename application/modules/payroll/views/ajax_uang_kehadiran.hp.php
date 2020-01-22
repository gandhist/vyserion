
<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.min.js"></script>
<!-- SlimScroll -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- datepicker -->
<!-- <script src="<?php echo base_url(); ?>assets/dt/bootstrap-datepicker.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
<!-- page script -->
<!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 -->

<script src="<?php echo base_url(); ?>assets/datatables/export_button/html5shiv.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.flash.min.js"></script>


<script>
$(document).ajaxStart(function () {
    Pace.restart()
  })
            $(document).ready(function () {
                $(".select2").select2({
                    placeholder: "Please Select"
                });
            });
                // untuk setting sidebar active
                $("#payroll").addClass("treeview active");
                $("#input_payroll").addClass("treeview active");
                $("#general_act").addClass("active");
                
                
        </script>

  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
/*
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var nik_awal = parseInt( $('#nik_awal').val(), 10 );
        var nik_akhir = parseInt( $('#nik_akhir').val(), 10 );
        var col_nik = parseFloat( data[0] ) || 0; // use data for the age column
 
        if ( ( isNaN( nik_awal ) && isNaN( nik_akhir ) ) ||
             ( isNaN( nik_awal ) && col_nik <= nik_akhir ) ||
             ( nik_awal <= col_nik   && isNaN( nik_akhir ) ) ||
             ( nik_awal <= col_nik   && col_nik <= nik_akhir ) )
        {
            return true;
        }
        return false;
    }
);*/



$(document).ready(function() {
  

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // buttonfile export 
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "dom": 'Blfrtip', // untuk menampilkan button filter lelnghtmenu
        // "dom": 'Bfrtip', // tidak menampilkan filter lenghtmenu
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        //"scrollX": "200px",

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('payroll/ajax_list')?>",
            "type": "POST",
            "data": function (data) {
                data.empcode = $('#f_empcod').val();
               /* data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -1 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],

    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});


function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Input Employee'); // Set Title to Bootstrap modal title
    $('#f_input_by').val('<?php echo $username; ?>');
    $('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo'); // label photo upload
    $("#f_departement").val(null).trigger('change');
    $("#f_emp_status").val(null).trigger('change');
}

function add()
{
    save_method = 'add';
    $('#f_input_by').val('<?php echo $username; ?>');
    $('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    //alert(save_method);
    sav();
}

function edit_emp_attribute(id)
{
    
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $("#f_empcode").val(null).trigger('change').focus();
    $("#f_attd_code").val(null).trigger('change');
    $("#btnSave").attr("onclick","edit()");
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('payroll/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_empcode"]').val(data.empcode).trigger("change");
            $('[name="f_date_attd"]').val(data.attd_date);
            $('[name="f_id_emp_act_sk"]').val(data.id_emp_act_sk);
            $('[name="f_overtime"]').val(data.overtime);
            $('[name="f_attd_code"]').val(data.attd_code).trigger("change");
            $('[name="f_remarks"]').val(data.remarks);
            //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            //$('.modal-title').text('Edit Employee Bio Data'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function edit()
{
    save_method = 'update';
    $('#f_update_by').val('<?php echo $username; ?>');
    $('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    //alert('onclick has changed when click edit button');
    sav();
}

function delete_data(id)
{
  if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
    
        $.ajax({
            url : "<?php echo site_url('payroll/emp_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function sav()
{
    
    //save_method = 'add';
    //alert(save_method);
        var formData = new FormData($('#form')[0]);
    if (save_method == 'add') {
        url = "<?php echo site_url('payroll/emp_add') ?>";
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
        processData: false,
        dataType: "JSON",
            success: function (data) {
              
               if(data.status) //if success close modal and reload ajax table
            {
              alert('data berhasil disimpan');
                reload_table();
                $('#form')[0].reset();
                $("#f_date_attd").focus();
                $("#f_empcode").val(null).trigger('change');
                $("#f_attd_code").val(null).trigger('change');
                //$("#f_date_attd").focus();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
            
            },
            error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }

          });
    }
    else 
    {
        url = "<?php echo site_url('payroll/emp_update')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                /*jika setelah edit data maka form akan direset dan attribute button save akan diarakkan ke add() agar dapat menginput data lagi
                */
                alert('data update berhasil disimpan');
                //alert(save_method);
                reload_table();
                $('#form')[0].reset();
                $("#f_date_attd").focus();
                $("#f_empcode").val(null).trigger('change').focus();
                $("#f_attd_code").val(null).trigger('change');
                $("#btnSave").attr("onclick","add()");


            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
            save_method = 'add';


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
    }

}

// reset form
function reset_form()
{
    //alert('fuckyou');
        $('#form')[0].reset();
        $("#f_empcode").val(null).trigger('change');
        $("#f_attd_code").val(null).trigger('change');
         $("#btnSave").attr("onclick","add()");
        table.ajax.reload();  //just reload table

}

// function save data
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    save_method = 'add'; 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('hr/hr/emp_add')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
    } else {
        url = "<?php echo site_url('hr/hr/emp_update')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                //location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
    }

    // ajax adding data to database

    /*var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                location.reload();
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });*/
}

function delete_emp_attribute(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('hr/hr/emp_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>
  <!-- end of crud employee datatable -->
<!-- Bootstrap modal -->
<!-- disable keyboard dan onclick outside
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
 -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                  
                  <div class="table-responsive">
                  <table class="table table-hover">
  <thead>

  </thead>
  <tbody>
    <tr>
      <td>
      <table cellpadding="50" cellspacing="50">

        <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
                              <tr>
                                <td>NIK </td>
                                <td>
                                  <!-- <input type="text" name="f_empcode" class="form-control"                                 value="<?php echo $empcode; ?>" readonly> -->
                                  <input type="text" name="f_empcode" class="form-control"                                 value="<?php echo $empcode; ?>" readonly>
                                  <span class="help-block">
                                   </td>
                              </tr>
                              <tr>
                                <td>Name </td>
                                <td><input type="text" name="f_empname" class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Other Name</td>
                                <td><input type="text" name="f_other_empname" class="form-control"><span class="help-block"></td>
                              </tr>
                              <tr>
                                <td>Place Of Birth</td>
                                <td><input type="text" name="f_pob" class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Date Of Birth</td>
                                <td><input type="text" id="f_date_of_birth" name="f_date_of_birth" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                                <td><div id="age"></div></td>
                              </tr>
                              <tr>
                                <td>Citizen</td>
                                <td><input type="text" name="f_citizen" class="form-control" value="Indonesia"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>SEX</td>
                                <td>
                                  <select class="form-control" name="f_sex" class="form-control">
                                    <option>-</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                  </select>
                                  <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Marital Status</td>
                                <td>
                                  <select class="form-control" name="f_marrital_status" class="form-control">
                                    <option>-</option>
                                    <option value="married">Married</option>
                                    <option value="single">Single</option>
                                    <option value="widow/er">Widow/er</option>
                                  </select>
                                  <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Date Of Married</td>
                                <td><input type="text" name="f_date_of_married" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Religion</td>
                                <td>
                                  <select class="form-control" name="f_religion">
                                    <option>-</option>
                                    <option value="islam">Islam</option>
                                    <option value="katholik">Katholik</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="konghucu">Konghucu</option>
                                    <option value="budha">Budha</option>
                                    <option value="Lainnya">Lainnya</option>
                                  </select>
                                  <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Blood Type</td>
                                <td>
                                  <select class="form-control" name="f_blood_type">
                                    <option>-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="undefined">Undefined</option>
                                    
                                  </select>
                                  <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Number Of Child</td>
                                <td><input type="text" name="f_number_child" class="form-control"> <span class="help-block"></span></td>
                              </tr>
      </table>
      </td>
      <td>
        <table border="0">
                              <tr>
                                <td>Departement</td>
                                <!-- <td><input type="text" name="f_departement" class="form-control"> <span class="help-block"></span></td> -->
                                <td>
                                <select class="form-control select2" name="f_departement" id="f_departement" style="width: 100%;">
                                <option>-- Select Departement --</option>
                                <?php foreach ($dept as $sel_dept) {
                                    echo "<option value='$sel_dept->departement'>".$sel_dept->dept_desc."</option>"; 
                                }
                                ?>
                                </select>
                                <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Position</td>
                                <td><input type="text" name="f_position" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>No Jamsostek</td>
                                <td><input type="text" name="f_jamsostek_no" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>No Life Insurance</td>
                                <td><input type="text" name="f_life_insurance_no" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Bank Account No</td>
                                <td><input type="text" name="f_bank_account" class="form-control"> <span class="help-block"></span></td>
                                
                              </tr>
                              <tr>
                                <td>Bank Name</td>
                                <td><input type="text" name="f_bank_name" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Account Name</td>
                                <td><input type="text" name="f_bank_account_name" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Termination Date</td>
                                <td><input type="text" name="f_termination_date" class="form-control" readonly data-inputmask="'alias': 'dd-mm-yyyy'" data-mask> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Employee Status</td>
                                <td><!-- <input type="text" name="f_emp_status" class="form-control"> <span class="help-block"></span> -->
                                    <?php
                                  $dd_select2_attribute = 'class="form-control select2" id="f_emp_status" style="width: 100%;" disabled placeholder="Empcode"';
                                  
                                  echo form_dropdown('f_emp_status', $dd_emp_status, $empcode_status_selected, $dd_select2_attribute);
                                  ?><span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>NPWP</td>
                                <td><input type="text" name="f_npwp" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>ID CARD(KTP)</td>
                                <td><input type="text" name="f_id_card" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Labour Union</td>
                                <td><input type="text" name="f_labour_union" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                            </table>
      </td>
      <td>
         <table border="0">
                              <tr>
                                <td>Address</td>
                                <td><textarea name="f_address" class="form-control"></textarea> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Province</td>
                                <td><input type="text" name="f_province" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>City</td>
                                <td><input type="text" name="f_city" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Zip Code</td>
                                <td><input type="text" name="f_zipcode" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Phone No</td>
                                <td><input type="text" name="f_phoneno" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Mobile Phone</td>
                                <td><input type="text" name="f_mobilephoneno" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Email</td>
                                <td><input type="text" name="f_email" class="form-control"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Company Begin</td>
                                <td><input type="text" name="f_company_begin" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Hire Date</td>
                                <td><input type="text" name="f_hire_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > <span class="help-block"></span></td>
                            </tr>
                            </table>
      </td>
    </tr>                            
  </tbody>
</table>
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<!-- InputMask -->

<!-- Bootstrap 3.3.7 -->

<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    // menghitung umur
    $("#f_date_of_birth").change(function(){
      //alert('heyho');
      var today = new Date();
      // mount count from 0 = january
      var month = new Array();
          month[0] = "January";
          month[1] = "February";
          month[2] = "March";
          month[3] = "April";
          month[4] = "May";
          month[5] = "June";
          month[6] = "July";
          month[7] = "August";
          month[8] = "September";
          month[9] = "October";
          month[10] = "November";
          month[11] = "December";
      // end of mounth
      var mounth = new Date();
      //get date value from input form
      var birthDate = $('#f_date_of_birth').val();
      var get_year = birthDate.substring(6,10);
      var get_mount = birthDate.substring(3,5);
      var get_day = birthDate.substring(0,2);
      //get date value from input form
      // get date value current
      var get_curr_year = today.getFullYear();
      var get_curr_mount = today.getMonth() + 1;
      var get_curr_day = today.getDate();

      var get_age = get_curr_year - get_year;
      var m =  get_curr_mount;
      //$('#age').text(get_age+" Years Old "+get_curr_mount);
      if (get_curr_mount >= get_mount) {
        var age = get_curr_year - get_year;
        var sisa_bulan_thn_lalu = 12 - get_mount;
        $('#age').text(age+" Years Old ");
      }
      else if(get_curr_mount <= get_mount)
      {
        var age = (get_curr_year - 1) - get_year;
        var sisa_bulan_thn_lalu = 12 - get_mount;
        $('#age').text(age+" Years Old ");
        //$('#age').text(age+" Years "+sisa_bulan_thn_lalu+ " Months ebih ecil ");
      }
      /*$('#age').text($('#f_date_of_birth').val());*/
    /*var today = new Date();
    var birthDate = new Date($('#dob').val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return $('#age').html(age+' years old');*/
    });
    // END OF MENGHITUNG UMUR

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm-dd-yyyy', { 'placeholder': 'mm-dd-yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()


    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
/*    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })*/
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>