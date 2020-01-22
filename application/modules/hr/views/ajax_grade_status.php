
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
                $("#hr").addClass("treeview active");
                $("#input").addClass("treeview active");
                $("#grade_status").addClass("active");
            
        </script>
  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
  
    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('hr/hr/gs_list')?>",
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

function time_stamp_input()
{
    /**/
    var time_stamp = $('#f_input_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
        
    /* panggil fungsinya dengan time_stamp_input(); */
}
function time_stamp_update()
{
    /**/
    var time_stamp = $('#f_update_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
    /* panggil fungsinya dengan time_stamp_update(); */
}

function add()
{
    save_method = 'add';
    $('.select2').select2(); // inisialisasi ulang select2 untk menghilangkan fungsi destroy di bawah
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Grade Status'); // Set Title to Bootstrap modal title
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
            url : "<?php echo site_url('hr/hr/gs_delete')?>/"+id,
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
    /*$('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');*/
    $('#f_empcode_edit').attr('disabled','diasbled'); // untuk mendisable empcode, karena tidak boleh ganti nama/nk karyawan. lalu remove ketika add data
    $("#f_empcode").select2("destroy"); // destroy select 2 by id

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('hr/hr/gs_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_empcode"]').val(data.empcode).trigger("change");
            $('#f_empcode_edit').val(data.empcode).trigger("change");
            $('#f_empcode_4_update').val(data.empcode);
            $('[name="f_start_date"]').val(data.start_date);
            $("#f_emp_status").val(data.employeetype).trigger('change');
            $('[name="f_grade"]').val(data.grade);
            $('[name="f_basic"]').val(data.basic_sallary);
            $('[name="f_allow"]').val(data.allowance);
            $('[name="f_payment_method"]').val(data.payment_method);
            $('[name="f_upah"]').val(data.upah);
            $('[name="f_id_country"]').val(data.id_country).trigger('change');
            $('[name="f_id_region"]').val(data.id_region).trigger('change');
            $('[name="pagi"]').val(data.kehadiran_pagi);
            $('[name="malam"]').val(data.kehadiran_malam);
            $('[name="f_uang_makan"]').val(data.uang_makan);
            $('[name="f_spesifikasi"]').val(data.spesifikasi);
            $('[name="f_grade"]').val(data.grade).trigger('change');
            $('[name="f_emp_position"]').val(data.id_position).trigger('change');
            $('[name="f_wh"]').val(data.wh).trigger('change');
            // setting value radion button using jquery
            $('input[name=f_jamsostek][value="' + data.jamsostek + '"]').prop('checked', true).trigger('change');
            $('input[name=f_bpjs][value="' + data.lifeinsurance + '"]').prop('checked', true).trigger('change');
            $('input[name=f_ottj][value="' + data.overtime + '"]').prop('checked', true).trigger('change');
            
            
    
             $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Grade Status'); // Set title to Bootstrap modal title
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
      time_stamp_input(); // memanggil fungsi timestamp
        url = "<?php echo site_url('hr/hr/grade_status_add')?>";
    } else {
      time_stamp_update(); // memanggil fungsi timestamp
        url = "<?php echo site_url('hr/hr/gs_update')?>";
    }

    // ajax adding data to database

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
                <h3 class="modal-title">Grade Status</h3>
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
        <input type="text" style="display:none;" name="f_empcode_4_update" id="f_empcode_4_update" value="">
                              <tr>
                                <td>Empcode </td>
                                <td id="td_empcode">
                                 <?php
                                  $dd_emp = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode', $dd_empcode, $empcode_selected, $dd_emp);

                                  $empcode_selected_edit = 'class="form-control select2" id="f_empcode_edit" style="width: 100%; display:none;"';
                                  echo form_dropdown('f_empcode_edit', $dd_empcode_hrhist, $empcode_selected_hrhist, $empcode_selected_edit);
                                  ?><span class="help-block"></span>
                                </td>
                              </tr>
                            
                              <tr>
                                <td>Start Date</td>
                                <td><input type="text" id="f_start_date" name="f_start_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Employee Status </td>
                                <td>
                                  <?php
                                  $dd_select2_attribute = 'class="form-control select2" id="f_emp_status" style="width: 100%;" placeholder="Empcode"';
                                  
                                  echo form_dropdown('f_emp_status', $dd_emp_status, $empcode_status_selected, $dd_select2_attribute);
                                  ?><span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Grade </td>
                                <td>
                                  <?php
                                  $dd_select2_attribute = 'class="form-control select2" id="f_grade" style="width: 100%;" placeholder="Grade"';
                                  
                                  echo form_dropdown('f_grade', $dd_golongan, $golongan_selected, $dd_select2_attribute);
                                  ?><span class="help-block"></span>
                                </td>
                              </tr>
                             <!--  <tr>
                                <td>Grade </td>
                                <td><input type="text" name="f_grade" class="form-control"><span class="help-block"></span></td>
                              </tr> -->
                              <tr>
                                <td>Basic Sallary </td>
                                <td><input type="text" name="f_basic" class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Allow. </td>
                                <td><input type="text" name="f_allow" class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Payment Method </td>
                                <td>
                                  <select class="form-control" name="f_payment_method">
                                    <option value="0">Cash</option>
                                    <option value="1">Transfer</option>
                                  </select><span class="help-block"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>Upah </td>
                                <td><input type="text" name="f_upah" class="form-control"><span class="help-block"></span></td>
                              </tr>
                           
                              
                            </table>
                          
      </td>
      <td>
        <table>
          <tr>
            <td>Id Country</td>
            <td>
          <select class="form-control select2" style="width: 100%;" name="f_id_country">
            <option value="ID">Indonesia</option>
          </select><span class="help-block"></span>
          </td>
          </tr>
          <tr>
            <td>Id Region</td>
            <td>
          <select class="form-control select2" style="width: 100%;" name="f_id_region">
            <option value="13">Lahat - Sumatera-Selatan</option>
          </select><span class="help-block"></span>
          </td>
          </tr>
          <tr>
            <td>Uang Kehadiran</td>
            <td>
                <div class="col-xs-4">
                  <input type="text" name="pagi" class="form-control" placeholder="Pagi"><span class="help-block"></span>
                </div>
                
                <div class="col-xs-4">
                  <input type="text" name="malam" class="form-control" placeholder="Malam"><span class="help-block"></span>
                </div>
            </td>
          </tr>
          <tr>
            <td>Uang kopi & snack</td>
            <td><input type="text" name="f_uang_makan" class="form-control"><span class="help-block"></span></td>
          </tr>
          <tr>
            <td>Id Position</td>
            <td>
                                  <?php
                                  $dd_select2_attribute = 'class="form-control select2" id="f_emp_position" style="width: 100%;"';
                                 
                                  echo form_dropdown('f_emp_position', $dd_emp_position, $empcode_pos_selected, $dd_select2_attribute);
                                  ?>
                   <span class="help-block"></span>             
            </td>
          </tr>
          <tr>
            <td>Spesifikasi</td>
            <td><input type="text" name="f_spesifikasi" id="f_spesifikasi" class="form-control"><span class="help-block"></span></td>
          </tr>

          <tr>
            <td>Work Hour</td>
            <td>
          <select class="form-control select2" style="width: 100%;" name="f_wh">
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="99">9 Admin</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select><span class="help-block"></span>
          </td>
          </tr>
          <tr>

          <tr>
                                <td>Jamsostek</td>
                                <td><input type="radio" name="f_jamsostek" id="f_jamsostek" value="1"> Yes <input type="radio" name="f_jamsostek" id="f_jamsostek" value="0">No</td>
                                
                              </tr>
                              <tr>
                                <td>BPJS</td>
                                <td><input type="radio" name="f_bpjs" id="f_bpjs" value="1"> Yes <input type="radio" name="f_bpjs" id="f_bpjs" value="0">No</td>
                                
                              </tr>
                              <tr>
                                <td>Have OT/TJ</td>
                                <td><input type="radio" name="f_ottj" id="f_ottj" value="1"> Yes <input type="radio" name="f_ottj" id="f_ottj" value="0">No</td>
                                
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
<!-- InputMask -->
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

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