
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

<!-- script untuk menampilkan export button -->
<script src="<?php echo base_url(); ?>assets/datatables/export_button/html5shiv.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/dataTables.buttons.min.js"></script>
<!-- script untuk menampilkan export button -->

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
                $("#vehicle").addClass("treeview active");
                $("#process_vehicle").addClass("treeview active");
                $("#vehicle_monitoring_p2h").addClass("active");
            
        </script>
  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
  
  $('#f_end_date').change(function(){

//get start date value from input form where id = f_start_date 
      var start = $('#f_start_date').val();
      var get_start_year = parseInt(start.substring(6,10));
      var get_start_mount = parseInt(start.substring(3,5));
      var get_start_day = parseInt(start.substring(0,2));
//get end date value from input form where id = f_end_date 
      var end = $('#f_end_date').val();
      var get_end_year = parseInt(end.substring(6,10));
      var get_end_mount = parseInt(end.substring(3,5));
      var get_end_day = parseInt(end.substring(0,2));


    var a = moment([get_end_year, get_end_mount, get_end_day]); // duedate
    //var a = moment([2018, 7, 18]); // duedate
    console.log(a);
    var b = moment([get_start_year, get_start_mount, get_start_day]); // tanggal awal
    //var b = moment([2018, 1, 17]); // tanggal awal
    //console.log(a);
    var years = a.diff(b, 'year');
    b.add(years, 'years');
    var months = a.diff(b, 'months');
    b.add(months, 'months');
    var days = a.diff(b, 'days');
    console.log(years + ' years ' + months + ' months ' + days + ' days');

      $('#f_masa_kerja').val(years + ' Tahun ' + months + ' Bulan ' + days + ' Hari');


});


    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "dom": 'Blfrtip', // untuk menampilkan button filter lelnghtmenu
        // "dom": 'Bfrtip', // tidak menampilkan filter lenghtmenu
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('vehicle/veh_mon_p2h_list')?>",
            "type": "POST"
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



function add()
{
    save_method = 'add';
    $('.select2').select2(); // inisialisasi ulang select2 untk menghilangkan fungsi destroy di bawah
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Document Status'); // Set Title to Bootstrap modal title
    $('#f_input_by').val('<?php echo $username; ?>');
    /*$('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');*/
    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo'); // label photo upload
    $("#f_empcode").val(null).trigger('change'); // to set value as null when button add clicked
    $("#f_emp_status").val(null).trigger('change');
    $("#f_empcode_edit").val(null).trigger('change');
    $("#f_emp_position").val(null).trigger('change');
    //$('[name="f_basic"]').val(null).removeAttr('readonly',true);
    $('#f_empcode').removeAttr('disabled','diasbled');
    $("#f_empcode_edit").select2("destroy"); // destroy select 2 by id
}

function delete_data(id)
{
  if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
    
        $.ajax({
            url : "<?php echo site_url('hr/hr/doc_delete')?>/"+id,
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

function time_stamp_input()
{
    /**/
    var time_stamp = $('#f_input_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
        
    /* panggil fungsinya dengan time_stamp_input(); // fungsi timestamp */
}
function time_stamp_update()
{
    /**/
    var time_stamp = $('#f_update_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
    /* panggil fungsinya dengan time_stamp_input(); // fungsi timestamp */
}

function time_stamp_input()
{
    /**/
    var time_stamp = $('#f_input_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
        
    /* panggil fungsinya dengan time_stamp_input(); // fungsi timestamp */
}
function time_stamp_update()
{
    /**/
    var time_stamp = $('#f_update_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
    /* panggil fungsinya dengan time_stamp_input(); // fungsi timestamp */
}

function close_data(id)
{
  if(confirm('Are you sure to close this data?'))
    {
        // ajax delete data to database
    time_stamp_update(); // fungsi timestamp
        $.ajax({
            url : "<?php echo site_url('vehicle/close_data')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error closing data');
            }
        });

    }
}

function approve_data(id)
{
  if(confirm('Are you sure to approve this data?'))
    {
        // ajax delete data to database
    time_stamp_update(); // fungsi timestamp
        $.ajax({
            url : "<?php echo site_url('vehicle/approve_data')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error approving data');
            }
        });

    }
}

function edit(id)
{
    save_method = 'update';
    $('.select2').select2(); // inisialisasi ulang select2 untk menghilangkan fungsi destroy di bawah
    $('#form')[0].reset(); // reset form on modals
    //$('#td_input_1').append('<select class="form-control select2" style="width: 100%;" name="f_id_"><option value="13">Lahat - Sumatera-Selatan</option></select>');
    //$('#f_id_').attr('form-control select2');
    //$('#tesx').prop('form-control select2');
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#f_update_by').val('<?php echo $username; ?>');
    //$('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    //$('#f_empcode_edit').attr('disabled','diasbled'); // untuk mendisable empcode, karena tidak boleh ganti nama/nk karyawan. lalu remove ketika add data
    //$("#f_empcode").select2("destroy"); // destroy select 2 by id

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('vehicle/vehdoc_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_id_vehicle_doc"]').val(data.id_document);
            $('[name="f_doc_no"]').val(data.doc_no);
            $('[name="f_nap"]').val(data.nap).trigger("change");
            $('[name="f_nap_v"]').val(data.nap);
            $('[name="f_doc_type_v"]').val(data.doc_type);
            $('[name="f_doc_type"]').val(data.doc_type).trigger("change");
            $('[name="f_valid_until"]').val(data.valid_until);
            $('[name="f_masa_berlaku"]').val(data.masa_berlaku);
            $('[name="f_remarks"]').val(data.remarks);
            $('[name="f_sr"]').val(data.no_ref_sr);
            $('[name="f_ppd"]').val(data.no_ref_ppd);
            $('[name="f_status"]').val(data.status).trigger("change");

             $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Document Status'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('hr/hr/doc_add')?>";
    } else {
        
        url = "<?php echo site_url('vehicle/vehdoc_update')?>";
    }

    // ajax adding data to database

        time_stamp_update(); // fungsi timestamp
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
                alert("Hey you, your data has ben updated!!");
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
                <h3 class="modal-title">Document Status</h3>
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
        <input name="param_edit" type="text" style="display:none;" id="param_edit" value="">
        <input name="f_input_by" type="text" style="display:none;" id="f_input_by" value="">
        <input type="text" style="display:none;" name="f_input_date" id="f_input_date" value="">
        <input type="text" style="display:none;" name="f_update_by" id="f_update_by" value="">
        <input type="text" style="display:none;" name="f_update_date" id="f_update_date" value="">
        <input type="text" style="display:none;" name="f_id_vehicle_doc" id="f_id_vehicle_doc" value="">
        <input type="text" style="display:none;" name="f_nap" id="f_nap" value="">
        <input type="text" style="display:none;" name="f_doc_type" id="f_doc_type" value="">
        <input type="text" style="display:none;" name="f_status" id="f_doc_type" value="">

                              <tr>
                                <td>Document Number </td>
                                <td id="td_empcode">
                            <input type="text" name="f_doc_no" id="f_doc_no" readonly class="form-control" placeholder=""> <span class="help-block"></span>
                                <span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>NAP</td>
                                <td>
                                  <?php
                                  $attribute = 'class="form-control select2" disabled id="f_nap_v" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_nap_v', $dd_vehicle_code, $vehicle_code, $attribute);?><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Document Type</td>
                                <td><select class="form-control select2" disabled readonly name="f_doc_type_v" id="f_doc_type_v" style="width: 100%;">
                                    <option value="PAJAK">PAJAK</option>
                                    <option value="STNK">STNK</option>
                                    <option value="KEUR">KEUR</option>
                                    <option value="IJIN USAHA">IJIN USAHA</option>
                                  </select> 
                                  <span class="help-block"></span></td>
                              </tr>
                              
                              <tr>
                                <td>Valid Until</td>
                                <td><input type="text" id="f_valid_until" name="f_valid_until" readonly class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Validity Period </td>
                                <td><input type="text" name="f_masa_berlaku" id="f_masa_berlaku" readonly class="form-control" placeholder=""> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Remarks</td>
                                <td> <textarea class="form-control" id="f_remarks" readonly name="f_remarks"></textarea></td>
                              </tr>
                              <tr>
                                <td>NO Reference SR </td>
                                <td><input type="text" name="f_sr" id="f_sr" class="form-control" placeholder="Nomor Service Request"> <span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>NO Reference PPD </td>
                                <td><input type="text" name="f_ppd" id="f_ppd" class="form-control" placeholder="Nomor PPD"> <span class="help-block"></span></td>
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

<!-- Select2 -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script> -->
<!-- InputMask -->
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<!-- bootstrap datepicker -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
<!-- bootstrap color picker -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
<!-- bootstrap time picker -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
<!-- SlimScroll -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- iCheck 1.0.1 -->
<!-- <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
AdminLTE for demo purposes
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
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