
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
<script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.css"></script>
<!-- datepicker -->
<!-- <script src="<?php echo base_url(); ?>assets/dt/bootstrap-datepicker.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
<!-- page script -->
<!-- button export datatable -->
<!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/datatables/export_button/html5shiv.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/export_button/dataTables.buttons.min.js"></script>

<!-- progress -->
<script src="<?php echo base_url(); ?>assets/progress/jquery.ajax-progress.js"></script>
<script src="<?php echo base_url(); ?>assets/progress/jquery.ajax-progress.min.js"></script>
<!-- progress -->


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
                $("#download_absensi").addClass("active");
                $("#download_indicator").hide();
                $("#clear_indicator").hide();
                $("#sync_indicator").hide();
                $("#236_connect").hide();
                $("#236_disconnect").hide();
                $("#223_connect").hide();
                $("#223_disconnect").hide();
                
        </script>

  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';





$(document).ready(function() {
    $(document).ready(function () {
     $("#f_empcode_f").val(null).trigger('change');
      $("#f_gang_f").val(null).trigger('change');
            });


$.ajax({
            url : "<?php echo site_url('payroll/cek_koneksi_mesin')?>",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              console.log(data);
            if (data == "192.168.11.223") {
                $("#223_connect").show();
                $("#236_disconnect").show();
            }
            else if(data == "192.168.11.236") {
                $("#223_disconnect").show();
                $("#236_connect").show();
            }
            else{
                /* $("#236_disconnect").show();
                $("#223_disconnect").show(); */
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //alert('Error Showing data');
                $("#236_disconnect").show();
                $("#223_disconnect").show();
            }
        });


    //datatables
    table = $('#table').DataTable({ 
        //"responsive": true, //Feature responsive view
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
        /* this function is allow to add some html/css into selected data from ajax to modify
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            console.log(aData[3]);
            if (aData[3] == "D01") {
                $(nRow).find('td:eq(3)').append('<span class="label label-warning">'+aData[3]).append('</span>');
            }

        },*/
        //"scrollX": "200px",
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('payroll/absen_list')?>",
            "type": "POST",
            "data": function (data) {
                var start = $('#f_start_date_f').val();
                var end = $('#f_end_date_f').val();
                if (!start || !end) {
                data.f_start_date_f = $('#f_start_date_f').val();
                data.f_end_date_f = $('#f_end_date_f').val();

                }
                else
                {
                    var date_s = start.split('-');
                    var date_st = date_s[2] + '-' + date_s[1] + '-' + date_s[0].slice(-2);
                    var date_e = end.split('-');
                    var date_en = date_e[2] + '-' + date_e[1] + '-' + date_e[0].slice(-2);
                    data.f_start_date_f = date_st;
                    data.f_end_date_f = date_en;
                }
                /* end of fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
                
                data.f_empcode_f = $('#f_empcode_f').val();
                data.f_gang_f = $('#f_gang_f').val();
               
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
//alert("goddamit");
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form')[0].reset();
        $('#filter_empcode').val(null).trigger('change');
        $('#filter_dept').val(null).trigger('change');
        $('#filter_position').val(null).trigger('change');
        $('#filter_emp_status').val(null).trigger('change');
        table.ajax.reload();  //just reload table

    });
    $('#btn-reset_f').click(function(){ //button reset event click
        $('#form_filters')[0].reset();
        $("#f_empcode_f").val(null).trigger('change');
          $("#f_gang_f").val(null).trigger('change');
        table.ajax.reload();  //just reload table
    });

    $('#btn-reset_synctime').click(function(){
        $('#ip_address_synctime').val(null).trigger('change');
        $('#sync_progress').hide();
        $('#sync_progress').html('<span>'+0+'</span>');
        function setProgress(precis) {
        var progress = $('#sync_progress');

        //progress.toggleClass('active', precis < 100);

        progress.css({
            width: precis = precis.toPrecision(3)+'%'
        }).html('<span>'+0+'</span>');
    }
        
    });


    $('#download').click(function(){
    simpan_persensi();
    });

    $('#synctime').click(function(){
        synctime();
    });

    $('#clear_logs').click(function(){
        clear_logs();
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

function test()
{
    alert("goddamit");
}

function simpan_persensi()
{
    $('#download').text('Downloading...'); //change button text
    //$('#download').attr('disabled',true); //set button disable 
    $('#btn-reset').attr('disabled',true); //set button disable 
    $("#download_indicator").show();

    var url;

    
        url = "<?php echo site_url('payroll/absensi_add')?>";
        var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        async: true,
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
                $("#download_indicator").hide();
            if(data.status) //if success close modal and reload ajax table
            {
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
            $('#download').text('Download'); //change button text
            $('#btn-reset').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Too many data in machine, be patient and Please Try Again!');
            /*$('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable */
            $('#download').text('Download'); //change button text
            $('#btn-reset').attr('disabled',false); //set button disable 
            $('#download').attr('disabled',false); //set button disable 
            $("#download_indicator").hide();

        }
    });


    
}
// reload and call simpan persensi function every 30000 = 30 detik
 /*setInterval(simpan_persensi,30000);*/

 function clear_logs()
 {
    $("#clear_indicator").show();

    var url;
    url = "<?php echo site_url('payroll/clear_data_absen')?>";
    var formData = new FormData($('#form_clear_logs')[0]);
    $.ajax({
        url : url,
        type : "POST",
        async : true,
        data : formData,
        contentType : false,
        processData : false,
        dataType : "JSON",
        success : function(data)
        {
            if (data.status) {
                
        $("#clear_indicator").hide();
        alert('data sudah di bersihkan');
            }
        },
        error : function(jqXHR, textStatus, errorThrown)
        {
            alert('error cuys');
        }
    });
 }

 function synctime()
 {
    var url;
    function setProgress(precis) {
        var progress = $('#sync_progress');

        progress.toggleClass('active', precis < 100);

        progress.css({
            width: precis = precis.toPrecision(3)+'%'
        }).html('<span>'+precis+'</span>');
    }
    $('#sync_indicator').show();
    url = "<?php echo site_url('payroll/test_progress') ?>";
    var formData = new FormData($('#form_clear_logs')[0]);
    $.ajax({
        url : url,
        type : "POST",
        async : true,
        data : formData,
        contentType: false,
        processData: false,
        dataType : "JSON",
        success: function (data)
        {
            $('#sync_indicator').hide();
            //alert('syncronizing time success!!');
        },
        error : function (jqXHR, textStatus, errorThrown)
        {
            $('#sync_indicator').hide();
            alert('error cuy');
        },
        progress: function(e) {
            if(e.lengthComputable) {
                setProgress(e.loaded / e.total * 100);
                $('#content').html(e.srcElement.responseText);
            }
            else {
                console.warn('Content Length not reported!');
            }
        },
    });
    /*url = "<?php echo site_url('payroll/sync_times') ?>";
    var formData = new FormData($('#form_clear_logs')[0]);
    $.ajax({
        url : url,
        type : "POST",
        async : true,
        data : formData,
        contentType: false,
        processData: false,
        dataType : "JSON",
        success: function (data)
        {
            $('#sync_indicator').hide();
            alert('syncronizing time success!!');
        },
        error : function (jqXHR, textStatus, errorThrown)
        {
            $('#sync_indicator').hide();
            alert('error cuy');
        }
    });*/
 }
 

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


function edit_emp_attribute(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#f_update_by').val('<?php echo $username; ?>');
    $('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('hr/hr/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_empcode"]').val(data.empcode);
            $('[name="f_empname"]').val(data.empname);
            $('[name="f_other_empname"]').val(data.other_name);
            $('[name="f_pob"]').val(data.birth_place);
            $('[name="f_date_of_birth"]').val(data.dob);
            $('[name="f_citizen"]').val(data.nationality);
            $('[name="f_sex"]').val(data.sex);
            $('[name="f_marrital_status"]').val(data.maritalstatus);
            $('[name="f_date_of_married"]').val(data.datemarried);
            $('[name="f_religion"]').val(data.religion);
            $('[name="f_blood_type"]').val(data.blood_type);
            $('[name="f_number_child"]').val(data.numberofchild);
            $('[name="f_departement"]').val(data.departement).trigger("change");
            /*$("#f_departement").addClass("selected");$("#e1").val("UT").trigger("change");*/
            $('[name="f_termination_date"]').val(data.dateterminate);
            $('[name="f_position"]').val(data.position);
            $('[name="f_jamsostek_no"]').val(data.nojamsostek);
            $('[name="f_life_insurance_no"]').val(data.lifeinsuranceno);
            $('[name="f_bank_account"]').val(data.bankaccountno);
            $('[name="f_bank_name"]').val(data.bankname);
            $('[name="f_bank_account_name"]').val(data.bankaccountname);
            $('[name="f_emp_status"]').val(data.employeetype).trigger("change");
            $('[name="f_npwp"]').val(data.npwp);
            $('[name="f_id_card"]').val(data.no_identitas);
            $('[name="f_labour_union"]').val(data.labour_union);
            $('[name="f_address"]').val(data.address);
            $('[name="f_province"]').val(data.province);
            $('[name="f_city"]').val(data.city);
            $('[name="f_zipcode"]').val(data.zipcode);
            $('[name="f_phoneno"]').val(data.homephoneno);
            $('[name="f_mobilephoneno"]').val(data.mobilephoneno);
            $('[name="f_email"]').val(data.emailaddr);
            $('[name="f_company_begin"]').val(data.companybegin);
            $('[name="f_hire_date"]').val(data.hire_date);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Employee Bio Data'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.photo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove photo when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }


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
        url = "<?php echo site_url('payroll/absensi_add')?>";
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