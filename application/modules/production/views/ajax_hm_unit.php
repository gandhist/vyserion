
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
    $("#last_km").hide();
    $("#f_nap_f").val(null).trigger('change');
            });

                // untuk setting sidebar active
                $("#prod").addClass("treeview active");
                $("#input_prod").addClass("treeview active");
                $("#hm_unit").addClass("active");
                var curr_date = moment().format("DD-MM-YYYY");
                console.log(curr_date);
                <?php echo $show_input; ?>
                
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


/*untuk bulan di javascript menggunakan angkan 0 = 1, jadi di bawah di kurangi 1*/

  $('#fl_valid_until').change(function(){

//get start date value from input form where id = f_start_date 
      var start = $('#f_start_date').val();
      var get_start_year = parseInt(start.substring(6,10));
      var get_start_mount = parseInt(start.substring(3,5));
      var get_start_day = parseInt(start.substring(0,2));
//get end date value from input form where id = f_end_date 
      var end = $('#f_valid_until').val();
      var get_end_year = parseInt(end.substring(6,10));
      var get_end_mount = parseInt(end.substring(3,5));
      var get_end_day = parseInt(end.substring(0,2));
/*var a = moment("20170810", "YYYYMMDD").fromNow();
            console.log(a);
console.log(end);*/
    var a = moment([get_end_year, get_end_mount-1, get_end_day]); // duedate
    //var a = moment([2018, 7, 18]); // duedate
    //console.log(a);
    var b = moment([get_start_year, get_start_mount-1, get_start_day-1]); // tanggal awal
    //var b = moment([2018, 1, 17]); // tanggal awal
    //console.log(a);
    var years = a.diff(b, 'year');
    b.add(years, 'years');
    var months = a.diff(b, 'months');
    b.add(months, 'months');
    var days = a.diff(b, 'days');
    //console.log(years + ' years ' + months + ' months ' + days + ' days');

      $('#f_masa_kerja').val(years + ' Tahun ' + months + ' Bulan ' + days + ' Hari');
});

  $('#f_valid_until').change(function(){

    var start = moment().format("DD-MM-YYYY");  
    var get_start_year = parseInt(start.substring(6,10));
      var get_start_mount = parseInt(start.substring(3,5));
      var get_start_day = parseInt(start.substring(0,2));

      var b = moment([get_start_year, get_start_mount-1, get_start_day]);
   /* console.log(b);*/

      var end = $('#f_valid_until').val();
      var get_end_year = parseInt(end.substring(6,10));
      var get_end_mount = parseInt(end.substring(3,5));
      var get_end_day = parseInt(end.substring(0,2));
      var a = moment([get_end_year, get_end_mount-1, get_end_day]); // duedate

      var years = a.diff(b, 'year');
    b.add(years, 'years');
    var months = a.diff(b, 'months');
    b.add(months, 'months');
    var days = a.diff(b, 'days');
    /*console.log(years + ' years ' + months + ' months ' + days + ' days');*/

      $('#f_masa_berlaku').val(years + ' Tahun ' + months + ' Bulan ' + days + ' Hari');
      
});


$('#f_date').change(function(){
    var date = $('#f_date').val();

    //alert(date);
    //alert(curr_date);
    if (date > curr_date) {
        alert('jangan galak gilo');
    }
});
/*fungsi jqduery untuk mendapatkan total KM pada shift1*/
  $('#f_start').change(function(){
    //alert('fucking shit');
    validasi_shift_dua();
  });
  /*fungsi jquery untuk mendapatkan total KM pada shift2*/
  $('#f_stop').change(function(){
    //alert('fucking shit');
    validasi_shift_dua();
  });

  $('#f_7').change(function(){
    hitung_total_ritase();
  });
  $('#f_8').change(function(){
    hitung_total_ritase();
  });
  $('#f_9').change(function(){
    hitung_total_ritase();
  });
  $('#f_10').change(function(){
    hitung_total_ritase();
  });
  $('#f_11').change(function(){
    hitung_total_ritase();
  });
  $('#f_11').change(function(){
    hitung_total_ritase();
  });
  $('#f_1').change(function(){
    hitung_total_ritase();
  });
  $('#f_2').change(function(){
    hitung_total_ritase();
  });
  $('#f_3').change(function(){
    hitung_total_ritase();
  });
  $('#f_4').change(function(){
    hitung_total_ritase();
  });
  $('#f_5').change(function(){
    hitung_total_ritase();
  });

  function validasi_shift_satu(){
    var a = parseFloat($('#f_start').val());
    var b = parseFloat($('#f_stop').val());
    var tot = $('#f_total_hm');
    console.log(a);
    console.log(b);
    console.log(b-a);
    if (b < a) {
        alert('HM Stop tidak boleh lebih kecil dari HM Start!!');
        $('#f_start').focus();
    }
    else{
    tot.val(b-a);
    }
  }

  function validasi_shift_dua(){
    var a = parseFloat($('#f_start').val());
    var b = parseFloat($('#f_stop').val());
    var tot = $('#f_total_hm');
    if (isNaN(b)) {
        //alert('shit, is nan');
        tot.val(a-a);
    }
    else {
        if (b < a) {
        alert('HM Stop tidak boleh lebih kecil dari HM Start!!');
        $('#f_start').focus();
    }
    else{
        var jumlah_hm = b-a;
    tot.val(jumlah_hm.toFixed(1));
    }
    }
    console.log(a);
  }

  function hitung_total_ritase()
  {
    var tj = parseInt($('#f_7').val());
    var dlpn = parseInt($('#f_8').val());
    var sem = parseInt($('#f_9').val());
    var sep = parseInt($('#f_10').val());
    var seb = parseInt($('#f_11').val());
    var dub = parseInt($('#f_12').val());
    var sat = parseInt($('#f_1').val());
    var dua = parseInt($('#f_2').val());
    var tig = parseInt($('#f_3').val());
    var emp = parseInt($('#f_4').val());
    var lim = parseInt($('#f_5').val());
    var total_ritase = $('#f_total_ritase');
    total_ritase.val(tj+dlpn+sem+sep+seb+dub+sat+dua+tig+emp+lim);
  }

  /*VALIDASI ONLY CHAR ALLOWED*/
    $('#f_start').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_start_satu').val())) {
        }
        $('#f_start').val( $('#f_start').val().replace(/[^0-9.]/g,'.')); // karakter yang di izinkan
    });
    $('#f_stop').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_stop').val())) {
        }
        $('#f_stop').val( $('#f_stop').val().replace(/[^0-9.]/g,'.')); // karakter yang di izinkan
    });

    $('#f_7').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_7').val())) {
        }
        $('#f_7').val( $('#f_7').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_8').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_8').val())) {
        }
        $('#f_8').val( $('#f_8').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_9').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_9').val())) {
        }
        $('#f_9').val( $('#f_9').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_10').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_10').val())) {
        }
        $('#f_10').val( $('#f_10').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_11').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_11').val())) {
        }
        $('#f_11').val( $('#f_11').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_12').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_12').val())) {
        }
        $('#f_12').val( $('#f_12').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_1').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_1').val())) {
        }
        $('#f_1').val( $('#f_1').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_2').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_2').val())) {
        }
        $('#f_2').val( $('#f_2').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_3').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_3').val())) {
        }
        $('#f_3').val( $('#f_3').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_4').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_4').val())) {
        }
        $('#f_4').val( $('#f_4').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });

    $('#f_5').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_5').val())) {
        }
        $('#f_5').val( $('#f_5').val().replace(/[^0-9]/g,'')); // karakter yang di izinkan
    });
    $('#f_total_hm').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_total_hm').val())) {
        }
        $('#f_total_hm').val( $('#f_total_hm').val().replace(/[^0-9]/g,'.')); // karakter yang di izinkan
    });
    $('#f_total_ritase').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_total_ritase').val())) {
        }
        $('#f_total_ritase').val( $('#f_total_ritase').val().replace(/[^0-9]/g,'.')); // karakter yang di izinkan
    });
    $('#f_total_bcm_ton').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_total_bcm_ton').val())) {
        }
        $('#f_total_bcm_ton').val( $('#f_total_bcm_ton').val().replace(/[^0-9]/g,'.')); // karakter yang di izinkan
    });
    $('#f_distance').bind('keyup blur',function(){
        var regillegal = /[/A-Za-z';'/.]/ // karakter yang tidak di izinkan di letakan di regex
        if (regillegal.test($('#f_distance').val())) {
        }
        $('#f_distance').val( $('#f_distance').val().replace(/[^0-9]/g,'.')); // karakter yang di izinkan
    });

$(document).ready(function() {

    // set form to null values
    //  membuat field nap menjadi null saat load pertamakali
    $(document).ready(function() {
         //reset_form();
         //reset_filter();
    //$("#f_nap").val(null).trigger('change');
    });


        $("#f_doc_type").val(null).trigger('change');
        $("#f_attd_code").val(null).trigger('change');
        $("#f_status").val(null).trigger('change');
        $("#f_nap").val(null).trigger('change');
        $("#f_shift").val(null).trigger('change');
        $("#f_operator").val(null).trigger('change');
        $("#f_material").val(null).trigger('change');
        $("#f_loader").val(null).trigger('change');


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
        /*"language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json"
        },*/
    
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('production/veh_daily_list')?>",
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
                /* end of fungsi ini akan mengkonversi jika value dari start terisi, jika tidak terisi akan menampilkan all data/date, untuk mengkonversi inputan dari form dengan format dd-mm-yyyy menjadi yyy-mm-dd mengikuti format database */
                
                data.f_nap_f = $('#f_nap_f').val();
                //data.f_date_attd = $('#f_date_attd').val();

               /* data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            },
            
        },
        "scrollX": "200px",
        /*"scrollY": "500px",
        
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

        /*mendapatkan entitas nap*/
    $('#f_nap').on('select2:select', function () {
          var data = $('#f_nap').val();
          //alert(data);
          $.ajax({
            url: "<?php echo site_url('production/get_vehicle_entity')?>/"+ data,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                
                //$('#last_km').show();
                //$('#last_km').text('Kilometer Terakhir tanggal '+data.tanggal+' Shift '+data.shift+' : '+data.last_km+' KM');
                $('#f_code_unit').val(data.code_unit);
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data, check vehicle master');
            }
          });
});

    /*on change material*/
    $('#f_material').on('select2:select', function(){
        var material = $('#f_material').val();
        var unit = $('#f_code_unit').val();
        console.log(material);
        console.log(unit); 
    });

    /*on change material*/
    $('#f_loader').on('select2:select', function(){
        var loader = $('#f_loader').val();
        console.log(loader);
    });

    /*when field condition was changed it will change form input too*/
    $('#f_condition').on('select2:select', function () {
        var data = $('#f_condition').val();
        /*if (data == 1) {
            alert('km nya error ya?');
        }
        if (data == 2) {
            alert('emang gak di pake? kalo stand by aja mending buang aja ke got');
        }
        if (data == 3) {
            alert('kasihan amat unitnya breakdown :p');
        }
        if (data == 4) {
            alert('mampus lu unitnya rusak wkwkwk :d');
        }*/
        if (data != 0) {
            disabled_form();
        }
        else
        {
            undisabled_form();
        }
       /* if (data == 2) {
            alert('emang gak di pake? kalo stand by aja mending buang aja ke got');
        }
        if (data == 3) {
            alert('kasihan amat unitnya breakdown :p');
        }
        if (data == 4) {
            alert('mampus lu unitnya rusak wkwkwk :d');
        }*/
    });
    /*end of condition onchange*/

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#loading_import').hide();
    $('#btn_import').click(function(){
        var url = "<?php echo site_url('production/import_daily_hmkm')?>";
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
                    
                    /*get error and do stuff*/      
                    console.log(data);
                    /*jika data sudah terinput maka akan tampil javascript confirm jika yes maka data lama akan di hapus dan input data baru*/
                      if (data.error_string == "Tanggal sudah terinput") {
                    $('#loading_import').show();
                          delete_all_data(data.date); 
                      }
                    }
                    $('#loading_import').hide();

                }
            },
            error: function(jqXHR, textStatus, errorThrown){
            alert('Error Importing Data, check your file type');
                    $('#loading_import').hide();

            }
        });
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
    $('#f_input_by').val('<?php echo $username; ?>');
   /* $('#f_input_date').val('<?php echo date("Y-m-d h:i:s"); ?>');*/
    //alert(save_method);
    time_stamp_input();
    sav();
}

function disabled_form()
{
    $('#f_start_satu').attr('readonly', true);
    $('#f_stop_satu').attr('readonly', true);
    $('#f_start_dua').attr('readonly', true);
    $('#f_stop_dua').attr('readonly', true);
    $('#f_remarks_dua').attr('readonly', true);
}
function undisabled_form()
{
    $('#f_start_satu').attr('readonly', false);
    $('#f_stop_satu').attr('readonly', false);
    $('#f_start_dua').attr('readonly', false);
    $('#f_stop_dua').attr('readonly', false);
    $('#f_remarks_dua').attr('readonly', false);
}

function edit_data(id)
{
    
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $("#f_nap").val(null).trigger('change');
    $("#f_doc_type").val(null).trigger('change');
    $("#btnSave").attr("onclick","edit()");
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('production/veh_daily_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_id_vehicle_doc"]').val(data.id);
            $('[name="f_condition"]').val(data.kondisi).trigger("change");
            $('[name="f_date"]').val(data.tanggal);
            $('[name="f_nap"]').val(data.nap).trigger("change");
            $('[name="f_shift_satu"]').val(data.shift1);
            $('[name="f_start_satu"]').val(data.start_satu);
            $('[name="f_stop_satu"]').val(data.stop_satu);
            $('[name="f_km_total_satu"]').val(data.total_satu);
            $('[name="f_remarks_satu"]').val(data.remarks_satu);
            $('[name="f_shift_dua"]').val(data.shift2);
            $('[name="f_start_dua"]').val(data.start_dua);
            $('[name="f_stop_dua"]').val(data.stop_dua);
            $('[name="f_km_total_dua"]').val(data.total_dua);
            $('[name="f_remarks_dua"]').val(data.remarks_dua);
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
    /*$('#f_update_date').val('<?php echo date("Y-m-d h:i:s"); ?>');*/
    //alert('onclick has changed when click edit button');
    sav();
}

function delete_data(id)
{
  if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
    
        $.ajax({
            url : "<?php echo site_url('production/veh_daily_delete')?>/"+id,
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

function delete_all_data(date)
{
        $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
  if (confirm('are you wanna replace old data on date ' +date +'?')) {
    /*hapus data pada tanggal tersebut lalu input data baru*/
    var url = "<?php echo site_url('production/import_daily_hmkm')?>";
            var formData = new FormData($('#form-import')[0]);

            /*delete old data*/
    $.ajax({
      url: "<?php echo site_url('production/delete_masal'); ?>/" +date,
      type: "POST",
      dataType: "JSON",
      success :function(data)
      {
        $('#loading_import').show();
            
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        alert("error deleteing data from ajax");
      }
    });

            /*ajax for input or replace new data*/
            $.ajax({
                url : url,
                type : "POST",
                data : formData,
                contentType : false,
                processData : false,
                dataType : "JSON",
                success: function(data){
                    if (data.status) {
                        alert('delete and Import Data Successfully!!');
                        //reload_table();
                        $('#form-import')[0].reset(); // reset form on modals
                        $('#loading_import').hide();

                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++) {
                             $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                        //$('#loading_import').hide();

                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                alert('Error Importing Data, check your file type');
                $('#loading_import').hide();

                }
            });


  }
  $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
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
        time_stamp_input(); // fungsi timestamp
        url = "<?php echo site_url('production/veh_daily_add') ?>";
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
                $("#f_date").focus();
                $("#f_nap").val(null).trigger('change');
                $("#f_condition").val(null).trigger('change');
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
        time_stamp_update(); // fungsi timestamp
        url = "<?php echo site_url('production/veh_daily_update')?>";
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
                $("#f_nap").focus();
                $("#f_nap").val(null).trigger('change');
                $("#f_status").val(null).trigger('change');
                $("#f_doc_type").val(null).trigger('change');
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
        $("#f_nap").val(null).trigger('change');
        $("#f_status").val(null).trigger('change');
        $("#f_doc_type").val(null).trigger('change');
        $("#f_shift").val(null).trigger('change');
        $("#f_operator").val(null).trigger('change');
        $("#f_material").val(null).trigger('change');
        $("#f_loader").val(null).trigger('change');
        $("#btnSave").attr("onclick","add()");
        table.ajax.reload();  //just reload table

}

function reset_filter()
{
    //alert('fuckyou');
        $('#form_filters')[0].reset();
        $("#f_nap_f").val(null).trigger('change');
        table.ajax.reload();  //just reload table di remarks karena ketika reset di klik maka akan menreset form lalu reload table ikut membawa valu yang sebelumnya di inputkan.

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