<html>
<head>
    <title>ITX.WEB.ID</title>
    <base href="<?php echo base_url(); ?>" />

</head>
<body>
<center><h2> Book & Member List</h2></center>
<input type="text" name="f_empcode" id="f_empcode">
<input type="text" name="f_empname" id="f_empname">
<div id="div">
    
</div>
<table border="1" id="ajx">
    <tr>
        <td id="c">1</td>
        <td>2</td>
    </tr>
    <tr>
        <td id="a"></td>
        <td id="b"></td>
    </tr>
</table>
<div id="tabs">

    <ul>
        <li><a href="#read">Book List</a></li>
		<li><a href="#read2">Member List</a></li>
    </ul>

    <div id="read">
        <table id="tabel"></table>
    </div>

	<div id="read2">
        <table id="tabel2"></table>
    </div>

</div>



<script type="text/template" id="readTemp">
    <tr>
        <td>${id}</td>
        <td>${title}</td>
        <td>${author}</td>
    </tr>

</script>
<script type="text/template" id="test">
    <tr>
        <td>${id_position}</td>
        <td>${position_desc}</td>

    </tr>

</script>

<script type="text/template" id="readTemp2">
    <tr>
        <td>${no}</td>
        <td>${name}</td>
        <td>${address}</td>
    </tr>

</script>
<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    

<script>
        //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('payroll/ajax_rpt_sallary')?>/" ,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //===== left side is input name and then right side is field name
            $('[name="f_empcode"]').val(data.empcode);
            $('[name="f_empname"]').val(data.inputby);
            $('#a').html(data.inputby);

        //alert(data.empode);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });


</script>

</body>
</html>