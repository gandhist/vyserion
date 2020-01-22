
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
    $(document).ready(function() {
        var table;
        reset_filter();

    });

    table = $('#dt_emp_in').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "lengthMenu" : [[10,25,50,-1],[10,25,50,"ALL"]],
        "dom" : 'Blrftip',
        "buttons" : ['copy','csv','excel','pdf','print'],
        
        "ajax" : {
            "url" : "<?php echo site_url('hr/emp_masuk_list') ?>",
            "type" : "POST",
            "data" : function(data){
                var start = $('#filter_start').val();
                var end = $('#filter_end').val();
                var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
 
            
        
                if (!start || !end) {
                data.filter_start = $('#filter_start').val();
                data.filter_end = $('#filter_end').val();

                }
                else
                {
                    var date_s = start.split('-');
                    var date_st = date_s[2] + '-' + date_s[1] + '-' + date_s[0].slice(-2);
                    var date_e = end.split('-');
                    var date_en = date_e[2] + '-' + date_e[1] + '-' + date_e[0].slice(-2);
                    data.filter_start = date_st;
                    data.filter_end = date_en;
                }
                /* end of fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
                /*console.log(data.filter_start);
                console.log(data.filter_end);*/
                /*data.filter_bulan = $('#filter_bulan').val();
                data.filter_tahun = $('#filter_tahun').val();
                data.f_nap_f = $('#f_nap_f').val();
                 data.parameter_bulan = $('#parameter_bulan').val();
                 data.parameter_tahun = $('#parameter_tahun').val();*/
                 //$('#karyawan_masuk').replaceWith('Daftar Karyawan Masuk '+data.parameter_bulan+'-'+data.parameter_tahun);
            }
        },
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
    table_out = $('#dt_emp_out').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "lengthMenu" : [[10,25,50,-1],[10,25,50,"ALL"]],
        "dom" : 'Blrftip',
        "buttons" : ['copy','csv','excel','pdf','print'],
        
        "ajax" : {
            "url" : "<?php echo site_url('hr/emp_keluar_list') ?>",
            "type" : "POST",
            "data" : function(data){
                var start = $('#filter_start').val();
                var end = $('#filter_end').val();
                var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
 
            
        
                if (!start || !end) {
                data.filter_start = $('#filter_start').val();
                data.filter_end = $('#filter_end').val();

                }
                else
                {
                    var date_s = start.split('-');
                    var date_st = date_s[2] + '-' + date_s[1] + '-' + date_s[0].slice(-2);
                    var date_e = end.split('-');
                    var date_en = date_e[2] + '-' + date_e[1] + '-' + date_e[0].slice(-2);
                    data.filter_start = date_st;
                    data.filter_end = date_en;
                }
                /* end of fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
                /*console.log(data.filter_start);
                console.log(data.filter_end);
                 data.parameter_bulan = $('#parameter_bulan').val();
                 data.parameter_tahun = $('#parameter_tahun').val();*/
                 //$('#karyawan_keluar').replaceWith('Daftar Karyawan Keluar '+data.parameter_bulan+'-'+data.parameter_tahun);
            }
        },
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


    
    </script>
<script>
            $(document).ready(function () {
                $(".select2").select2({
                    placeholder: "Please Select"
                });

            });
            // untuk setting sidebar active
                $("#vehicle").addClass("treeview active");
                $("#rpt_vehicle").addClass("treeview active");
                $("#rpt_veh_fuel_graph").addClass("active");
            
        </script>
  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
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

  $('#btn-filter').click(function(){ //button filter event click
        //$('#form_filters').attr('method','#');
        //table.ajax.reload();  //just reload table
        //table_out.ajax.reload();  //just reload table
        //alert('goddamnit');
        graph();
    });

  $('#download').click(function(){
    $('#form_filters').attr('method','POST');
    alert('ini harusnya method post');
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



function graph()
{
    $("canvas#mycanvas").remove(); // remove canvas pada div
    $("#divcanvas").append('<canvas id="mycanvas"></canvas>'); // membuat canvas dengan id mycanvas pada tag div divmycanvas
    /*digunakan karena saat filter data canvas harus di remove terlebih dahulu lantas generate canvas baru*/
    /*$("canvas#mycanvas").remove();
    $("div.mycanvas").append('<canvas id="mycanvas"></canvas>');*/
     var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    var chartdata;
    return "rgb(" + r + "," + g + "," + b + ")";
}
/*start ajax graph*/
    var formData = new FormData($('#form_filters')[0]);
        $.ajax({
                url : "<?php echo site_url('vehicle/data_fuel_sarana'); ?>",
                type : "POST",
                data : formData,
                processData : false,
                contentType : false,
                dataType : "JSON",
                success:function(data)
                {
            var ctx = $("#mycanvas");

                var start = $('#filter_start').val();
                var end = $('#filter_end').val();
                var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
                if (!start || !end) {
                data.filter_start = $('#filter_start').val();
                data.filter_end = $('#filter_end').val();

                }
                else
                {
                    var date_s = start.split('-');
                    var date_st = date_s[2] + '-' + date_s[1] + '-' + date_s[0].slice(-2);
                    var date_e = end.split('-');
                    var date_en = date_e[2] + '-' + date_e[1] + '-' + date_e[0].slice(-2);
                    data.filter_start = date_st;
                    data.filter_end = date_en;
                }
                console.log(date_st);
                console.log(date_en);
                    //console.log(data);
                    var nap = [];
                    var qty = [];
                    var warna = [];
                    for (var i = 0; i < data.length; i++) {
                        nap.push(data[i].nap);
                        qty.push(data[i].qty);
                        warna.push(dynamicColors());
                        var chartdata = {
                //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                labels: nap,
                datasets : [
                    {
                        label: 'BBM ',
                        //backgroundColor: [window.chartColors.blue,window.chartColors.red,window.chartColors.green],
                        backgroundColor: warna,
                    borderColor: window.chartColors.red,
                        fill: false,
                        data: qty
                    }
                ]
            };
                console.log(data[i].nap);
                console.log(data[i].qty);
                console.log(dynamicColors);
                } 
            
                
                //alert('dapat data'+data[0].jml_emp);
                /*var chartdata = {
                //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                labels: nap,
                datasets : [
                    {
                        label: 'BBM',
                        backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.red,
                        fill: false,
                        data: qty
                    }
                ]
            };*/

            /*var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}*/

            var barGraph = new Chart(ctx, {
                type: 'bar',
                options: {
                    responsive: true,
                    title: {
                    display: true,
                    text: 'Graphic Fuel Consumption'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'NAP'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Litre'
                        }
                    }]
                }
                },
                data: chartdata
            });

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                alert('Error Showing data');
                }
        }); 
/*end of ajax graph*/
    

}


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

function reset_form()
{
    $('#form_filters')[0].reset();
    $("#f_nap").val(null).trigger('change');
    table.ajax.reload();
    //table_out.ajax.reload();
}

function reset_export()
{
    $('#form_export')[0].reset();
}

function reset_filter()
{
    //alert('fuckyou');
        $('#form_filters')[0].reset();
        $("#f_nap_f").val(null).trigger('change');
        table.ajax.reload();  //just reload table di remarks karena ketika reset di klik maka akan menreset form lalu reload table ikut membawa valu yang sebelumnya di inputkan.
}
function download_xls()
{
    alert('god damn it');
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
        url : "<?php echo site_url('hr/hr/doc_status_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('#f_contract_id').val(data.contract_id);
            $('[name="f_empcode"]').val(data.empcode).trigger("change");
            $('#f_empcode_edit').val(data.empcode).trigger("change");
            $('#f_empcode_4_update').val(data.empcode);
            $('[name="f_start_date"]').val(data.start_date);
            $('[name="f_end_date"]').val(data.end_date);
            $('[name="f_masa_kerja"]').val(data.masa_kerja);
            $('[name="f_sign_date"]').val(data.sign_date);
            $('[name="f_approved_id"]').val(data.approved_id);
            $('[name="f_status"]').val(data.status).trigger('change');
            $('[name="f_contract_no"]').val(data.contract_no);
            $('[name="f_remarks"]').val(data.remarks);

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

function time_stamp_input()
{
    /**/
    var time_stamp = $('#f_input_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
        
    /* panggil fungsinya dengan time_stamp_input(); */
}

function close_data(id)
{
  if(confirm('Are you sure to close this data?'))
    {
        // ajax delete data to database
    time_stamp_update(); // fungsi timestamp
        $.ajax({
            url : "<?php echo site_url('hr/close_data')?>/"+id,
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

function time_stamp_update()
{
    /**/
    var time_stamp = $('#f_update_date');
    time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    /**/
    /* panggil fungsinya dengan time_stamp_input(); */
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
      time_stamp_input(); // fungsi timestamp
        url = "<?php echo site_url('hr/hr/doc_add')?>";
    } else {
      time_stamp_input(); // fungsi timestamp
        url = "<?php echo site_url('hr/hr/doc_update')?>";
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
        <input type="text" style="display:none;" name="f_contract_id" id="f_contract_id" value="">
                              <tr>
                                <td>Empcode </td>
                                <td id="td_empcode">
                                 <?php
                                  $dd_emp = 'class="form-control select2" id="f_empcode" style="width: 100%; display:none;"';
                                  /*$empcode_selected_edit digunakan untuk manipulasa saat edit data, jadi saat edit data menggunakan ajax empcode dengan id f_empcode akan di destory dan di hiddenkan, lalu di replace dengan empcode id f_empcode_edit
                                  lebih jelasnya lihat source ajax di atas*/
                                  $empcode_selected_edit = 'class="form-control select2" id="f_empcode_edit" style="width: 100%; display:none;"';
                                  ?><span class="help-block"></span>
                                </td>
                              </tr>
                              
                             <!--  <tr>
                                <td>Empcode 2 </td>
                                <td>
                                  <?php
                                  $empcode_selected_edit = 'class="form-control select2" id="f_empcode_edit" style="width: 100%;"';
                                  
                                  ?>
                                </td>
                              </tr> -->
                              <tr>
                                <td>Contract No</td>
                                <td><input type="text" name="f_contract_no" class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Document Date</td>
                                <td><input type="text" id="f_doc_date" name="f_start_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Start Date</td>
                                <td>
                                  <div class="col-xs-4">
                                    <input type="text" id="f_start_date" name="f_start_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder="Start Date"><span class="help-block"></span>
                                  </div>
                                  <div class="col-xs-4">
                                    <input type="text" id="f_end_date" name="f_end_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask placeholder="End Date"><span class="help-block"></span>
                                  </div>
                                </td>
                              </tr>
                              
                              <tr>
                                <td>Sign Date </td>
                                <td><input type="text" id="f_sign_date" name="f_sign_date" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Masa Kerja </td>
                                <td><input type="text" name="f_masa_kerja" id="f_masa_kerja" readonly class="form-control"><span class="help-block"></span></td>
                              </tr>
                              <tr>
                                <td>Approved Id</td>
                                <td><input type="text" name="f_approved_id" class="form-control"><span class="help-block"></span></td>
                              </tr>                              
                            </table>
                          
      </td>
      <td>
        <table>
          
          <tr>
            <td>Remarks</td>
            <td>
                <textarea id="f_remarks" name="f_remarks"></textarea><span class="help-block"></span>                
            </td>
          </tr>
          <tr>
            <td>Action</td>
            <td>
          <select class="form-control select2" style="width: 100%;" name="f_status">
            <option value="draft">Draft</option>
            <option value="submit">Submit</option>
            <option value="approve">Approve</option>
            <option value="closed">Closed</option>
          </select><span class="help-block"></span>
          </td>
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