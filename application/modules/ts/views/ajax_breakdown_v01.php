
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
 <!-- script untuk membuat datatable yang menampung lebih dari 1 juta rows -->
<script src="<?php echo base_url(); ?>assets/datatables/scroller/dataTables.scroller.min.js"></script>



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
                //readonly_add(param= true);


            });
                // untuk setting sidebar active
                $("#ts").addClass("treeview active");
                $("#input_ts").addClass("treeview active");
                $("#ts_bd_v01").addClass("active");
                
                
        </script>

  <!-- start of crud employee datatable -->
  <script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

/*fungsi untuk menghitung interval hari*/

Date.getFormattedDateDiff = function(date1, date2) {
  var b = moment(date1),
      a = moment(date2),
      intervals = ['years','months','days'],
      out = [];

  for(var i=0; i<intervals.length; i++)
  {
      var diff = a.diff(b, intervals[i]);
      b.add(diff, intervals[i]);
      out.push(diff + ' ' + intervals[i]);
  }
  return out.join(', ');
};
/**/
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
function pw()
    {
        var now = "04/09/2013 15:00:00";
        var then = "02/09/2013 14:20:00";

        var ms = moment(now, "DD/MM/YYYY HH:mm:ss").diff(moment(then, "DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
        console.log(s);
    }

$(document).ready(function() {

  
    // set form to null values
    $(document).ready(function(){
        reset_form();
        $('#status_operasi').hide();
      /*  $("#f_empcode_f").val(null).trigger('change');
        $("#f_empcode").val(null).trigger('change');
        $("#f_attd_code").val(null).trigger('change');*/
    });

    /*$.ajax({
        url : ,
        type : "GET",
        contentType : false,
        processData :  false,
        dataType : "JSON",
        success : function(data)
        {
            alert('get data from ajax');
        },
        error : function (jqXHR, textStatus, errorThrown)
        {
            alert('error get data from ajax');
        },
    });*/

  


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
        

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('ts/bd_list')?>",
            "type": "POST",
            "data": function (data) {


                /*fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
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
                data.filter_show = $('#filter_show').val();
                data.filter_code_unit = $('#filter_code_unit').val();
                /* end of fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
                
                //data.f_empcode_f = $('#f_empcode_f').val();
                //data.f_date_attd = $('#f_date_attd').val();

               /* data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            },
            
        },
       /* "scrollX": "200px",*/
        /*"scrollX": "200px",*/
        /*"scrollY": "200px",
        "scroller": {
            "loadingIndicator": true
        },*/
         

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
    $('#loading_import').hide();
    $('#btn_import').click(function(){
        var url = "<?php echo site_url('payroll/import_gang_activity')?>";
        var formData = new FormData($('#form-import')[0]);
        $('#loading_import').show();
        $.ajax({
            url : url,
            type : "POST",
            data : formData,
            contentType : false,
            processData : false,
            dataType : "JSON",
            success: function(data){
                if (data.status) {
                    $('#loading_import').hide();
                    alert('Import Data Successfully!!');
                    //reload_table();
                    $('#form-import')[0].reset(); // reset form on modals

                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) {
                         $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
            alert('Error Importing Data, check your file type');
            }
        });
    });

    /*hotkey*/
    /*$(document).bind('keydown', 's', function(){
        alert('save data');
    });*/
    /*hotkey*/

    /*validasi nomor kuitansi*/
     $('#f_kwitansi').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z,]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_kwitansi').val())) {
            alert('illegal character, input only number!!');
        }
        $('#f_kwitansi').val( $('#f_kwitansi').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    /*$('#f_kwitansi').change(function(){
        var no_kwitansi = $('#f_kwitansi').val(); 
        alert('holyshit');
        $.ajax({
            url : "<?php echo base_url(); ?>ts/cek_kwitansi/"+ no_kwitansi,
            type: "GET",
            dateType: "JSON",
            success: function(data)
            {
                console.log(data);
                if (data.status === true) {
                    alert('boleh input');
                }
                else
                {
                    alert('cant input');
                }
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            },
            error : function(jqXHR, textStatus, errorThrown)
            {
                alert("error get data from ajax");
            }
        })
    });*/


     /*mendapatkan data master vehicle*/
     $('#f_code_unit').on('select2:select', function(){
        var code_unit = $('#f_code_unit').val();
        var tanggal = $('#f_date_bd').val();
        var a = moment(tanggal, 'DD-MM-YYYY');
        var tgl = moment(tanggal, 'DD-MM-YYYY hh:ss').format('YYYY-MM-DD');
        var bln = a.format('M');
        var thn = a.format('YYYY');
        //alert('fucking shit '+code_unit);
        $.ajax({
            url: "<?php echo site_url('ts/get_status_unit')?>/"+ code_unit,
            type: "GET",
            dataType: "JSON",
            success : function(data)
            {
                $('#status_operasi').show();
                $('#sts_opr_bd').text(data[0].status_bd+" at "+data[0].date_start +", No.Kwitansi: "+data[0].no_kwitansi);
                if (data[0].status_bd ==="0") {
                    alert("tidak ada record breakdown.");
                }
                if (data[0].status_bd === "BREAKDOWN" || data[0].date_start === "0" ) {
                    $('#btnSave').attr('disabled',false);
                }
               /* if (data[0].status_bd === "BREAKDOWN") {
                    $('#btnSave').attr('disabled',true);
                }*/

                //console.log(data.nap);
                //alert(data.status_bd);
            },
            error : function(jqXHR, textStatus, errorThrown)
            {
                $('#status_operasi').hide();
                //alert('Error get data from ajax');
                alert('Data tidak ditemukan!');
            }
        }); // end of ajax request

        $.ajax({
            url: "<?php echo site_url('ts/get_pw'); ?>/"+code_unit+"/"+tgl,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#f_pw').val(data.total);
                hitung_ma();
            },
            error : function ()
            {
                alert('error get data from ajax');
            }
        });
        //hitung_ma();

        
        
        
     });
     /*end of mendapatkan data master vehicle*/

     /*jika status level closed maka status breakdown juga akan closed*/
     $('#f_status_level').on('select2:select', function(){
        var sts_lvl = $('#f_status_level').val();
        if (sts_lvl == 4) {
            $('#status_lvl_temp').val(4);
            $('#f_status_bd').val(1).trigger("change");
            $('#status_bd_temp').val(1);
            $('#f_status_bd').prop("disabled", true);
            console.log($('#f_status_bd').val());
        }
        else
        {
            var sts_lvl = $('#f_status_level').val();
            $('#f_status_bd').prop("disabled", false);
            $('#f_status_bd').val(0).trigger("change");
            $('#status_bd_temp').val(0);
            $('#status_lvl_temp').val(sts_lvl);
        }
        
     });


/*jika status bd di klik maka akan mengubah isi field status_bd_temp*/
     $('#f_status_bd').on('select2:select', function(){
            var status_bd = $('#f_status_bd').val();
            /*jika open*/
            if (status_bd == 0) {
            $('#status_bd_temp').val(0);
            $('#f_status_level').val(null).trigger("change"); // merubah nilai status level menjadi closed
            $('#f_status_level').prop("disabled", false);
            } 
            else
            {
            $('#status_bd_temp').val(1); //merubah nilai status bd temp menjadi closed
            $('#f_status_level').val(4).trigger("change"); // merubah nilai status level menjadi closed
            $('#f_status_level').prop("disabled", true); // merubah sstatus level disabled
            }
     });
     /*jika status level closed maka status breakdown juga akan closed*/

     /*
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
            $('#f_wh').val(data.work_hour);
            $('#f_losstime').val(data.losstime);
            $('#f_reguler_hour').val(data.reg_hour);
            $('#f_shw').val(data.short_work_hour);
            $('#f_whtl').val(data.whtl);
            $('#f_off_day').val(data.off_day);
            $('#f_first_ot').val(data.first_ot);
            $('#f_bantu_dua_satu').val(data.bantu_satu_ot);
            $('#f_bantu22').val(data.bantu_dua_ot);
            $('#f_second_ot').val(data.second_ot);
            $('#f_third_ot').val(data.third_ot);
            $('#f_fourth_ot').val(data.fourth_ot);
            $('#f_total_lembur').val(data.total_jam_lembur);
            $('[name="f_remarks"]').val(data.remarks);
            
            //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            //$('.modal-title').text('Edit Employee Bio Data'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

     */
     $('#f_date_bd').change(function()
     {
        //hitung_ma_day(); // mengambil hm terupdate di daily hmkm
        hitung_downtime();
        test();
        hitung_ma();
        hitung_tdy();
        hitung_total_day();
        hitung_standby();
     });

     $('#f_hm').change(function()
     {
        //hitung_ma_day(); // mengambil hm terupdate di daily hmkm
        hitung_downtime();
        hitung_ma();
        hitung_tdy();
        hitung_total_day();
        hitung_standby();

     });

     $('#f_date_finish').change(function(){
        hitung_downtime();
        test();
        hitung_ma();
        hitung_total_day();
        hitung_tdy();
        hitung_standby();
        close_bd_level();
        //cek_tdy();

     });

     $('#f_pw').change(function()
     {
        //hitung_ma_day(); // mengambil hm terupdate di daily hmkm
        hitung_downtime();
        test();
        hitung_standby();
        hitung_ma();
     });

     $('#f_tdr').change(function()
     {
        //hitung_ma_day(); // mengambil hm terupdate di daily hmkm
        test();
        
        hitung_standby();
        hitung_ma();
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

/*
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
}*/

function close_bd_level()
     {
            $('#f_status_bd').val(1).trigger("change");
            $('#status_bd_temp').val(1);
            $('#f_status_bd').prop("disabled", true);
            
            $('#f_status_level').val(4).trigger("change");
            //$('#f_status_level').prop("disabled", true);

     }

function add()
{
    var time_stamp = $('#f_input_date');
      time = moment().format('YYYY-MM-DD H:mm:ss');
    time_stamp.val(time);
    save_method = 'add';
    $('#f_input_by').val('<?php echo $username; ?>');
    //$('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    //$('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');
    //alert(save_method);
    sav();
}

function edit_emp_attribute(id)
{
    readonly_update();
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $("#f_empcode").val(null).trigger('change').focus();
    $("#f_attd_code").val(null).trigger('change');
    $("#btnSave").attr("onclick","edit()");
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('ts/edit_vehicle_bd')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            
            //===== left side is input name and then right side is field name
            $('[name="f_kwitansi"]').val(data.no_kwitansi);
            $('[name="f_id_emp_act_sk"]').val(data.id_rn);
            $('[name="f_date_bd"]').val(data.date_start);
            $('[name="f_code_unit"]').val(data.nap).trigger('change');
            $('[name="f_task"]').val(data.task).trigger("change");
            $('[name="f_schedule"]').val(data.schedule).trigger("change");
            $('[name="f_damage"]').val(data.status_damage).trigger("change");
            $('[name="f_pm"]').val(data.pm).trigger("change");
            $('[name="f_status_level"]').val(data.status_level).trigger("change");
            $('[name="f_status_bd"]').val(data.status_bd).trigger("change");
            $('[name="f_sts_part_job"]').val(data.status_parts_job).trigger("change");
            $('[name="status_bd_temp"]').val(data.status_bd);
            $('[name="status_lvl_temp"]').val(data.status_level);
            $('[name="f_vendor"]').val(data.progress_by).trigger("change");
            $('[name="f_mechanic"]').val(data.mechanic_name);
            $('[name="location"]').val(data.location);
            $('#f_hm').val(data.hm);
            $('#f_hm_start').val(data.hm_start);
            $('#f_hm_finish').val(data.hm_finish);
            $('#f_shift').val(data.shift).trigger("change");
            $('#f_operator').val(data.operator).trigger("change");
            $('#f_remarks_machine').val(data.remarks_machine);
            $('#f_reason_bd').val(data.reason_bd);
            $('#f_part').val(data.part_replacment);
            $('#f_date_estimate').val(data.date_finish_estimate);
            $('#f_date_finish').val(data.date_finished);
            $('#f_pr').val(data.no_pr_sr);
            $('#f_po').val(data.no_po);
            $('#f_cost_estimate').val(data.cost_estimate);
            $('#f_status_cost').val(data.status_cost).trigger("change");
            $('#f_pw').val(data.possible_work);
            $('#f_tdr').val(data.total_down_time);
            $('#f_tdy').val(data.tdy);
            $('#f_ma').val(data.ma);
            $('#f_stby').val(data.stand_by);
            $('#f_ua').val(data.ua);
            $('#f_pa').val(data.pa);
            if (data.status_bd == 1) {
                $('#btnSave').attr('disabled',true);
            }
            else
            {
                $('#btnSave').attr('disabled',false);
                $('#f_status_bd').prop("disabled", false);


            }

            if (data.status_level == 4) {
                // jika bd
            $('#f_status_level').prop("disabled", true);
            }
            else
            {
            $('#f_status_level').prop("disabled", false);

            }

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
            url : "<?php echo site_url('ts/bd_delete')?>/"+id,
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

function sav()
{
    //save_method = 'add';
    //alert(save_method);
        var formData = new FormData($('#form')[0]);
    if (save_method == 'add') {
        /* memanggil fungsi timestamp*/
        time_stamp_input();
        url = "<?php echo site_url('ts/add_vehicle_bd') ?>";
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
              //console.log(data);
                reset_form();

              //  reload_table();
                //$('#form')[0].reset();
                alert('data berhasil disimpan');
                //reset_lov_add();
                //readonly_add();
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
    time_stamp_update();
        url = "<?php echo site_url('ts/update_bd')?>";
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
                reset_form();
                //alert(save_method);
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
        $("#filter_code_unit").val(null).trigger('change');
       /* $("#f_empcode").val(null).trigger('change');
        $("#f_attd_code").val(null).trigger('change');*/
        $("#btnSave").attr("onclick","add()");
                    $('#btnSave').attr('disabled',false);
        table.ajax.reload();  //just reload table
        reset_lov_add();
        readonly_add(param = true);

}



function reset_lov_add()
{
    $('#f_code_unit').val(null).trigger('change');
    $('#f_task').val(null).trigger('change');
    $('#f_schedule').val(null).trigger('change');
    $('#f_damage').val(null).trigger('change');
    $('#f_pm').val(null).trigger('change');
    $('#f_status_level').val(null).trigger('change');
    $('#f_status_bd').val(null).trigger('change');
    $('#f_vendor').val(null).trigger('change');
    $('#f_shift').val(null).trigger('change');
    $('#f_operator').val(null).trigger('change');
    $('#f_sts_part_job').val(null).trigger('change');
}

function reset_lov_update()
{
    $('#f_status_cost').val(null).trigger('change');
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

function is_closed()
{
    alert("ini closed");
    $('#form : input').attr("disabled", true);
}

function readonly_update()
{
    $('#f_status_cost').prop('disabled', false);
    readonly_add(param = false);
}

function readonly_add(param)
{
    $('#f_date_finish').attr('readonly', param);
    $('#f_pr').attr('readonly', param);
    $('#f_po').attr('readonly', param);
    $('#f_cost_estimate').attr('readonly', param);
    $('#f_status_cost').prop('disabled', param);

}

function hitung_downtime()
{
    /*var then = "02-10-2018 07:58:00";
    var now  = "02-10-2018 08:30:00";*/
    var then = $('#f_date_bd').val();
    var now = $('#f_date_finish').val();
    var ms = moment(now,"DD/MM/YYYY HH:mm:ss").diff(moment(then,"DD/MM/YYYY HH:mm:ss"));
    var d = moment.duration(ms);
    var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
    var ho = d.asHours().toFixed(2);
    /*console.log(then);
    console.log(now);
    console.log(ms);
    console.log(d);
    console.log(s);
    console.log(ho);*/
    if (isNaN(ho)) {
        var ho = 0;
    }
    $('#f_tdr').val(ho);
}

function hitung_downtime_kurang(param, date_start)
{
        var then = date_start;
        var now = param;
        var ms = moment(now,"DD/MM/YYYY HH:mm:ss").diff(moment(then,"DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
        var ho = d.asHours().toFixed(2);
        /*console.log(then);
        console.log(now);
        console.log(ms);
        console.log(d);
        console.log(s);
        console.log(ho);*/
        if (isNaN(ho)) {
            var ho = 0;
        }
        $('#f_tdr').val(ho);
}

function hitung_ma()
{
    var tdr = $('#f_tdr').val();
    var pw = $('#f_pw').val();
    var ma = parseFloat(pw) / (parseFloat(pw) + parseFloat(tdr));
    var maa = parseFloat(ma) * parseFloat(100); 
    if (isNaN(maa)) {
        var maa = 0;
    $('#f_ma').val(maa.toFixed(2));
    }
    $('#f_ma').val(maa.toFixed(2));
}

function get_backdate_wh(code_unit, tgl)
{
    $.ajax({
            url: "<?php echo site_url('ts/get_pw'); ?>/"+code_unit+"/"+tgl,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#f_pw').val(data.total);
                hitung_standby();
            },
            error : function ()
            {
                alert('error get data from ajax');
            }
        });
}

function hitung_ma_day()
{
        var code_unit = $('#f_code_unit').val();
        var tanggal = $('#f_date_bd').val();
        var a = moment(tanggal, 'DD-MM-YYYY');
        var bln = a.format('M');
        var thn = a.format('YYYY');
        /*ajax request ke 2 untuk mendapatkan hm finish atau hm awal di tanggal berikutnya dari tanggal bd*/
        $.ajax({
            url : "<?php echo site_url('ts/get_hm_update'); ?>/"+code_unit+"/"+bln+"/"+thn,
            type : "GET",
            dataType : "JSON",
            success : function(data)
            {
                var hm_bd = $('#f_hm').val();
                $('#f_hm_start').val(hm_bd);
                $('#f_hm_finish').val(data.hm_update);
                var hm_update = $('#f_hm_finish').val();
                var pw = hm_update - hm_bd;
                if (isNaN(pw)) {
                    var pw = 0;
                }
                $('#f_pw').val(pw.toFixed(2));
                hitung_ma();
                //console.log(hm_update);
            },
            error : function(jqXHR, textStatus, errorThrown)
            {
                alert('error get data from ajax');
                $('#btnSave').attr('disabled',false);
            }
        });
}

function hitung_total_day()
{
    var a = $('#f_date_bd').val();
        var get_start_year = parseInt(a.substring(6,10));
        var get_start_mount = parseInt(a.substring(3,5));
        var get_start_day = parseInt(a.substring(0,2));
        //var start = moment([get_start_year, get_start_mount-1, get_start_day]).subtract(1,'days').format('YYYY-MM-DD');
        var start = moment([get_start_year, get_start_mount-1, get_start_day]).format('YYYY-MM-DD');
        /*substract unutk mengurangi 1 hari, karena javasccript tidak menghitung dari tanggal awal*/
        var b = $('#f_date_finish').val();
        var get_end_year = parseInt(b.substring(6,10));
        var get_end_mount = parseInt(b.substring(3,5));
        var get_end_day = parseInt(b.substring(0,2));
        var end = moment([get_end_year, get_end_mount-1, get_end_day]).format('YYYY-MM-DD');
    //var date = new date(get_start_year+ "-" +get_start_mount+ "-" + get_start_day);
    /*console.log(a);
    console.log(b);
    //console.log(date);
    console.log(start);
    console.log(xa);
    console.log(end);
    console.log(Date.getFormattedDateDiff(start, end));*/
      //$('#f_tdy').val(Date.getFormattedDateDiff(start, end));
}

function hitung_tdy()
{
    var then = $('#f_date_bd').val();
    var now = $('#f_date_finish').val();
    var ms = moment(now,"DD/MM/YYYY").diff(moment(then,"DD/MM/YYYY"));
    var duration = moment.duration(ms).asDays();
    //console.log(duration);
    if (isNaN(duration)) {
        var duration = 0;
    }
    $('#f_tdy').val(duration+ ' Days');
}

function cek_tdy()
{
    var tdy = parseInt($('#f_tdy').val());
        if (tdy > 0) {
            $('#f_pw').val(19);
        }
        else
        {
            hitung_ma_day();
        }
}

function hitung_standby()
{
    var nap = $('f_nap').val();
    /*validasi jika itu 913 left nap maka parameter jam aktual nya 24 jam selain itu 19 jam*/
    var wh_default = parseFloat(19);
    var wh_actual = parseFloat($('#f_pw').val());
    if (wh_actual > 19) {
        wh_actual = 0;
    }
    else
    {   
    var bd = parseFloat($('#f_tdr').val());
    var stby = wh_default - wh_actual - bd;
    $('#f_stby').val(stby.toFixed(2));
    }
    hitung_ua();
}

function hitung_ua()
{
    //var wh_default = parseFloat(19);
    var wh_actual = parseFloat($('#f_pw').val());
    var stby = parseFloat($('#f_stby').val());
    var a = wh_actual + stby;
    var ua = wh_actual / a * parseFloat(100); 
    $('#f_ua').val(ua.toFixed(2));
    hitung_pa();
}

function hitung_pa()
{
    var wh_actual = parseFloat($('#f_pw').val());
    var stby = parseFloat($('#f_stby').val());
    var bd = parseFloat($('#f_tdr').val());
    var a = wh_actual + stby;
    var b = a + bd;
    var pa = a / b * parseFloat(100);
    if (wh_actual == 0) {
        $('#f_pa').val(0);
    }
    else if(wh_actual > 0)
    {
    $('#f_pa').val(pa.toFixed(2));
    }


}

function test()
{   
    var date_bd = $('#f_date_bd').val();
    var date_start = moment(date_bd,"DD-MM-YYYY HH:mm").format('DD-MM-YYYY HH:mm');

    var date_end = $('#f_date_finish').val();
    var date_finish = moment(date_end,"DD-MM-YYYY HH:mm").format('DD-MM-YYYY HH:mm');

    /*cek jumlah hari dari bd sampai ready*/
    var day = moment(date_end, "DD-MM-YYYY").diff(moment(date_bd, "DD-MM-YYYY"));
    var day_duration = moment.duration(day).asDays();

    var get_tanggal_start = moment(date_bd,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY');
    var get_tanggal_finish = moment(date_end, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY');
    var get_hour_start = moment(date_start, 'DD-MM-YYYY HH:mm').format('HH:mm');
    var get_hour_finish = moment(date_end, 'DD-MM-YYYY HH:mm').format('HH:mm');

    /*parameter jam*/
    var jam_satu = moment("01:00",'HH:mm').format('HH:mm');
    var jam_lima = moment("05:00",'HH:mm').format('HH:mm');
    var jam_tujuh = moment("07:00",'HH:mm').format('HH:mm');
    var jam_duabelas = moment('12:00','HH:mm').format('HH:mm');
    var jam_tigabelas = moment('13:00','HH:mm').format('HH:mm');
    var jam_tujuhbelas = moment('17:00','HH:mm').format('HH:mm');
    var jam_delapanbelas = moment('18:00','HH:mm').format('HH:mm');
    var jam_sembilanbelas = moment('19:00','HH:mm').format('HH:mm');
    var jam_duaempat = moment('23:59','HH:mm').format('HH:mm');

    var shift_satu_tujuh = moment(get_tanggal_start+" "+ jam_tujuh ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_satu_duabelas = moment(get_tanggal_finish+" "+ jam_duabelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_satu_tigabelas = moment(get_tanggal_start+" "+ jam_tigabelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_satu_tujuhbelas = moment(get_tanggal_finish+" "+ jam_tujuhbelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_satu_delapanbelas = moment(get_tanggal_finish+" "+ jam_delapanbelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_dua_satu = moment(get_tanggal_start+" "+ jam_satu ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_dua_lima = moment(get_tanggal_finish+" "+ jam_lima ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_dua_sembilanbelas = moment(get_tanggal_start+" "+ jam_sembilanbelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_dua_duaempat = moment(get_tanggal_finish+" "+ jam_duaempat ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_dua_satu_tgl_plus_satu = moment(get_tanggal_finish+" "+ jam_satu ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    

    var besok_sampai_duabelas = moment(get_tanggal_start+" "+ jam_satu ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')
    var shift_satu_tujuh_finish = moment(get_tanggal_finish+" "+ jam_tujuh ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm')

    /*parameter jam*/

    /*breakdown kurang 1 jam*/
    var bd_min_satu = moment(get_hour_finish, 'HH:mm').add('-1','hours').format('HH:mm');
    var par_min_satu = moment(get_tanggal_finish+ " "+bd_min_satu, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');
    /*breakdown kurang 2 jam*/
    var bd_min_dua = moment(get_hour_finish, 'HH:mm').add('-2','hours').format('HH:mm');
    var par_min_dua = moment(get_tanggal_finish+ " "+bd_min_dua, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');
    /*breakdown kurang 3 jam*/
    var bd_min_tiga = moment(get_hour_finish, 'HH:mm').add('-3','hours').format('HH:mm');
    var par_min_tiga = moment(get_tanggal_finish+ " "+bd_min_tiga, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');
    /*breakdown kurang 4 jam*/
    var bd_min_empat = moment(get_hour_finish, 'HH:mm').add('-4','hours').format('HH:mm');
    var par_min_empat = moment(get_tanggal_finish+ " "+bd_min_empat, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');
    var par_min_empat_awal = moment(get_tanggal_start+ " "+bd_min_empat, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');
    
    var bd_min_lima = moment(get_hour_finish, 'HH:mm').add('-5','hours').format('HH:mm');
    var par_min_lima = moment(get_tanggal_finish+ " "+bd_min_lima, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');

    /*ubah date_start menjadi jam 07:00 jika bd > 1*/
    var set_jam__tujuh_bd_more_one_day = moment(get_tanggal_finish+" "+jam_tujuh, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm'); 
    /**/
    var shift_satu_duabelas = moment(get_tanggal_finish+" "+ jam_duabelas ,'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');

    /*backdate 1 day*/
    var backdate = moment(get_tanggal_finish, 'DD-MM-YYYY').add('-1','day').format('DD-MM-YYYY');
    //var par_min_satu = moment(get_tanggal_finish+ " "+bd_min_satu, 'DD-MM-YYYY HH:mm').format('DD-MM-YYYY HH:mm');



    if (day_duration > 1) {
        console.log('this is breakdown more than one day, so date_start BD start on 07:00');
        /*<= 12:00*/
        if (date_finish <= shift_satu_duabelas) {
            console.log('12:00 hitung ma seperti biasa');
            hitung_downtime_kurang(date_finish, set_jam__tujuh_bd_more_one_day);
        }
        /*<= 17:00, potong 1 jam*/
        else if(date_finish <= shift_satu_tujuhbelas)
        {
            console.log('<= 17:00, potong 1 jam istirahat');
            hitung_downtime_kurang(par_min_satu, set_jam__tujuh_bd_more_one_day);
        }
        /*<= 24:00, potong 3 jam*/
        else if(date_finish <= shift_dua_duaempat)
        {
            console.log('<= 23:59, potong 3 jam istirahat');
            hitung_downtime_kurang(par_min_tiga, set_jam__tujuh_bd_more_one_day);
        }
    }
    /*jika breakdown 1 hari atau pindah tanggal, overhaul atau shift 2 malam*/
    else if(day_duration === 1){
        console.log('ini breakdown 1 hari atau seberang tanggal');
        


        /*19:00 - +1 05:00*/
        if(date_start >= shift_dua_sembilanbelas && date_start <= shift_dua_duaempat && date_finish <= shift_dua_lima)
        {
            console.log('19:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_satu, date_start);
        }
        /*13:00 - besok jam 05:00*/
        else if(date_start >= shift_satu_tigabelas && date_start <= shift_satu_tujuhbelas && date_finish <= shift_dua_lima)
        {
            console.log('13:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_tiga, date_start);
        }
        /*13:00 - besok jam 12:00*/
        else if(date_start >= shift_satu_tigabelas && date_start <= shift_satu_tujuhbelas && date_finish >= shift_satu_tujuh && date_finish <= shift_satu_duabelas){
            console.log('13:00 - besok jam 12:00, hitung hanya breakdown pada tanggal finish jam 07:00');
            hitung_downtime_kurang(date_finish, shift_satu_tujuh_finish);
        }
        /*07:00 - besok jam 05:00*/
        else if (date_start >= shift_satu_tujuh && date_start <= shift_satu_duabelas && date_finish >= shift_dua_satu && date_finish <= shift_dua_lima) {
            console.log('07:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_empat_awal, date_start);
        }
        /*13:00 - besok 05:00*/
        else if(date_start >= shift_dua_duaempat && date_start <= shift_dua_duaempat && date_finish <= shift_dua_lima)
        {
            console.log('13:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_tiga, date_start);
        }
        /*19:00 - +1 12:00*/
        else if(date_start >= shift_dua_duaempat && date_start <= shift_dua_duaempat && date_finish <= shift_dua_lima)
        {
            console.log('19:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_satu, date_start);
        }
        
        /*13:00 - besok jam 05:00*/
        else if(date_start >= shift_satu_tigabelas && date_start <= shift_satu_tujuhbelas && date_finish <= shift_dua_lima)
        {
            console.log('13:00 - besok jam 05:00');
            hitung_downtime_kurang(par_min_tiga, date_start);
        }
        /*19:00 - +1 date 05:00*/
        else if(date_start >= shift_dua_sembilanbelas && date_start <= shift_dua_duaempat && date_finish >= shift_dua_satu && date_finish <= shift_dua_lima)
        {
            console.log('19:00 - +1 date 05:00, potong 1 jam');
            hitung_downtime_kurang(par_min_satu, date_start);
        }
        /*01:00 - esok 05:00*/
        else if (date_start >= shift_dua_satu && date_finish <= shift_dua_lima) {
            console.log('01:00 - esok 05:00, potong 4 jam');
            hitung_downtime_kurang(par_min_empat_awal, shift_satu_tujuh);
            //hitung_ma();
        }
        /*+1 01:00 - +1 05:00*/
        else if(date_start >= shift_dua_satu_tgl_plus_satu && date_finish <= shift_dua_lima) {
            console.log('ini breakdown lebih dari 1 hari, antara jam 01 hari breakdown +1 s/d tanggal besok jam 05:00.');
            hitung_ma();
        }

    }
    /*jika breakdown selesai di hari yang sama*/
    else
    {
        /*shift 1 jam 07:00-12:00*/
        console.log('shit, this is fucking awesome same day');
        /*07:00 - 12:00*/
        if (date_start >= shift_satu_tujuh && date_finish <= shift_satu_duabelas) {
            console.log('07:00 - 12:00 hitung ma seperti biasa');
            hitung_ma();
        }
        /*07:00 - 17:00 dan melewati range jam istirahat 12:00-13:00*/
        else if(date_start >= shift_satu_tujuh && date_start <= shift_satu_duabelas && date_finish >= shift_satu_tigabelas && date_finish <= shift_satu_tujuhbelas ) {
            console.log('07:00 - 17:00 breakdown shift pagi, melewati jam istirahat, potong 1 jam');
            hitung_downtime_kurang(par_min_satu, date_start);
        }
        /*13:00 - 17:00*/
        else if (date_start >= shift_satu_tigabelas && date_finish <= shift_satu_tujuhbelas) {
            console.log('range 13:00 - 17:00, hitung ma seperti biasa');
            hitung_ma();
        }
        /*13:00 - 18:00*/
        else if (date_start >= shift_satu_tigabelas && date_start <= shift_satu_delapanbelas &&  date_finish <= shift_satu_delapanbelas) {
            console.log('range 13:00 - 18:00, potong 1 jam');
            hitung_downtime_kurang(par_min_satu, date_start);
        }
        /*13:00 - 24:00*/
        else if (date_start >= shift_satu_tigabelas && date_start <= shift_satu_tujuhbelas && date_finish >= shift_dua_sembilanbelas && date_finish <= shift_dua_duaempat) {
            console.log('range 13:00 - 24:00, potong 2 jam');
            hitung_downtime_kurang(par_min_dua, date_start);
        }
        /*19:00 - 24:00*/
        else if(date_start >= shift_dua_sembilanbelas && date_finish <= shift_dua_duaempat)
        {
            console.log('range 19:00 - 24:00, hitung ma biasa');
            hitung_ma();
        }
        /*07:00 - 24:00 dan melewati range jam istirahat 12:00-13:00, 17:00 - 19:00, 1jam + 2 jam = 3 jam*/
        else if(date_start >= shift_satu_tujuh && date_finish <= shift_dua_duaempat ) {
            console.log('07:00 - 24:00 breakdown shift pagi, melewati jam istirahat, potong 3 jam');
            hitung_downtime_kurang(par_min_tiga, date_start);
        }
        
        

        /*mengupdate data breakdown di tanggal -1 nya, karena ini adalah lanjutan shift 2 tanggal sebelumnya*/
        /*01:00 - 05:00*/
        else if(date_start >= shift_dua_satu && date_finish <= shift_dua_lima) {
            console.log('01:00 - 05:00 ambil pw backdate, karena ini masih range shift dua backdate');
            //$('#f_tdr').val(0.00);
            var code_unit = $('#f_code_unit').val();
            get_backdate_wh(code_unit, backdate);
            //hitung_ma();
        }
        /*01:00 - 12:00, maka di hitung breakdown dari jam 07:00 - selesai bd*/
        else if(date_start >= shift_dua_satu && date_finish <= shift_satu_duabelas)
        {
            console.log('01:00 - 12:00 jam awal breakdown di buat baku jam 07:00');
            hitung_downtime_kurang(date_finish, shift_satu_tujuh);
        }
        /*01:00 - 17:00, maka jam awal breakdown dari jam 07:00 dan di potong jam istirahat 1 jam*/
        else if(date_start >= shift_dua_satu && date_start <= shift_satu_duabelas && date_finish >= shift_satu_tigabelas && date_finish <= shift_satu_tujuhbelas)
        {
            console.log('01:00 - 17:00 jam awal breakdown di buat baku jam 07:00 dan di potong 1 jam istirahat');
            hitung_downtime_kurang(par_min_satu, shift_satu_tujuh);

        }
        /*01:00 - 24:00, maka jam awal breakdown dari jam 07:00 dan di potong jam istirahat siang 1 jam, jam kosong overshift 17:00 - 19:00 2 jam. total potong 3 jam*/
        else if(date_start >= shift_dua_satu && date_finish <= shift_dua_duaempat)
        {
            console.log('01:00 - 24:00 jam awal breakdown di buat baku jam 07:00, dan di potong 3 jam, dari 1 jam istirahat siang dan 2 jam overshift 1 ke 2');
            hitung_downtime_kurang(par_min_tiga, shift_satu_tujuh);

        }
    }
    
    //console.log(tgl_jam_satu);
    /*console.log(get_tanggal_start);
    console.log(jam_satu);*/
    //$('#f_hm').val(par_min_satu);
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
                                   <span class="help-block"></span>
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

    // membuat input mask by id input form
    $('#f_date_bd').inputmask("datetime",{
    mask: "1-2-y h:s", 
    placeholder: "dd-mm-yyyy hh:mm", 
    leapday: "-02-29", 
    separator: "-", 
    alias: "dd-mm-yyyy"
  });
     $('#f_date_finish').inputmask("datetime",{
    mask: "1-2-y h:s", 
    placeholder: "dd-mm-yyyy hh:mm", 
    leapday: "-02-29", 
    separator: "-", 
    alias: "dd-mm-yyyy"
  });
     $('#f_date_estimate').inputmask("datetime",{
    mask: "1-2-y h:s", 
    placeholder: "dd-mm-yyyy hh:mm", 
    leapday: "-02-29", 
    separator: "-", 
    alias: "dd-mm-yyyy"
  });


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