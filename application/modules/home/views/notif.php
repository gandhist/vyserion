<script type="text/javascript">
  $(document).ready(function() {
    /*ajax untuk menampillkan notifikasi angka pada bell icon*/
$.ajax({
            url : "<?php echo site_url('home/cek_notif')?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //console.log(data);
              if (data == "" || data == "0" ) {
              //console.log(data);
                $('#notif_vehicle').text();
                $('#notif_count').text();
                $('#v_notif').text('Kamu Punya tidak punya Notifikasi');
              }
              else {
                $('#notif_count').text(data);
                $('#notif_count_h').text(data);
                $('#v_notif').text('Kamu Punya '+data+' Notifikasi');
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Showing data');
            }
        });

/*ajax untuk menampilkan data jumlah kendaraan yang akan habis pajak di menu utama atau dashboard*/
$.ajax({
            url : "<?php echo site_url('vehicle/cek_notif')?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //console.log(data);
              if (data == "" || data == "0" ) {
              //console.log(data);
                /*$('#notif_count').text();
                $('#v_notif').text('Kamu Punya tidak punya Notifikasi');*/
                $('#notif_vehicle').text(data);
              
              }
              else {
                /*$('#notif_count').text(data);
                $('#v_notif').text('Kamu Punya '+data+' Notifikasi');*/
                $('#notif_vehicle').text(data);
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Showing data');
            }
        });


// ajax daftar kontrak habis
$.ajax({
            url : "<?php echo site_url('home/list_notif_exp')?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              for(var i =0;i < data.length;i++)
                  {
                    var item = data[i];
                    //console.log(item.empcode + item.empname + item.end_date + item.due_date);
                    $('#list_notif').append('<a href= "<?php echo base_url('hr/list_expierd'); ?>"><i class="fa fa fa-warning text-yellow"></i><b>'+ item.empcode + ' ' + item.empname + '</b> akan habis kontrak dalam <b>' + item.due_date+'</b> Hari</a>')
                    //$('#list1').text(item.empcode+ item.empname + ' akan expired dalam ' +item.due_date+ ' Hari');
                    //$('#list2').text(item.empcode+ item.empname + ' akan expired dalam ' +item.due_date+ ' Hari');
                  }
              //console.log(data.empcode);
                //$('#v_notif').text('Kamu Punya '+data+' Notifikasi');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#list_notif').append('<a href= "#"><i class="fa fa fa-warning text-blur"></i>tidak ada kontrak yang due date</a>');
            }
        });
});

  /*fungsi untuk membuat tanggal dan jam*/
$(function () {

  /*fungsi untuk mendapatkan timestamp intuk input dan update*/
  var time_stamp = $('#time_stamp');
  time = moment().format('YYYY-MM-DD H:mm:ss');
  time_stamp.val(time);
  /*fungsi untuk mendapatkan timestamp intuk input dan update*/


                 /*real time now*/
    //$('#real_time').moment().format('D M YYYY, h:mm:ss a');
  setInterval(function(){


  var divLocal = $('#divLocal');
local = moment().format('DD MMMM YYYY, h:mm:ss a');
divLocal.text(local);

  },1000);
            });
/* end of fungsi untuk membuat tanggal dan jam*/

/*ajax untuk menampilkan jumlah karyawan baru bulan ini*/
$.ajax({
            url : "<?php echo site_url('home/new_employee')?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              //console.log(data);
              if (data == "" || data == "0" ) {
              //console.log(data);
                $('#notif_new_employee').text(0);
              }
              else {
                //$('#notif_count').text(data);
                $('#notif_new_employee').text(data);
                //$('#v_notif').text('Kamu Punya '+data+' Notifikasi');
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Showing data');
            }
        });
/*ajax untuk menampilkan jumlah karyawan baru bulan ini*/

</script> 