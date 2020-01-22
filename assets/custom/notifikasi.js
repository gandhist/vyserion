function external_ajax(){
    var xhr = null;
    try {
        xhr = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch (e) {
        try {
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
        catch (e) {
        try {
          xhr = new XMLHttpRequest();
        } catch (e) {
          xhr = false;
        }
        }
    }
    return xhr;
}

function external_aja(){

    var count;
    var jumlah;
$.ajax({
            url : "<?php echo site_url('home/cek_notif')?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              console.log(data);
              if (data == "" || data == "0" ) {
              console.log(data);
                return $('#notif_count').text();
                return $('#v_notif').text('Kamu Punya tidak punya Notifikasi');
              }
              else {
                return count = $('#notif_count').text(data);
                return jumlah = $('#v_notif').text('Kamu Punya '+data+' Notifikasi');
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Showing data');
            }
        });
}