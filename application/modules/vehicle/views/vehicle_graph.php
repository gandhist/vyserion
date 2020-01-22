<!doctype html>
<html>

<head>
	<title>Graphic Karyawan Masuk-Keluar <?php echo "2018";  ?></title>
	
	<script src="<?php echo base_url() ?>assets/bower_components/chart.js/Chart.bundle.js"></script>
	<script src="<?php echo base_url() ?>assets/bower_components/chart.js/utils.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>
<body>
	<!-- <div style="width:50%;">
		<canvas id="canvas"></canvas>
    </div> -->
    <p>goddamnit</p>
	<button class="btn btn-default" onclick="reload()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>

    <div style="width:80%;">
		<canvas id="mycanvas"></canvas>
	</div>
	
    <br>
	<br>
	<!-- <button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button>
	<button id="addData">Add Data</button>
    <button id="removeData">Remove Data</button> -->
    <script>
    
    $(document).ready(function() {
    	var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    var chartdata;
    return "rgb(" + r + "," + g + "," + b + ")";
}
        $.ajax({
                url : "<?php echo site_url('vehicle/data_fuel_sarana'); ?>",
                type : "POST",
                dataType : "JSON",
                success:function(data)
                {
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

			var ctx = $("#mycanvas");
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
							labelString: 'Nap'
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
        $('#btnSave').click(function(){
                	var start = $('#awal').val();
                	var end = $('#akhir').val();
        	$.ajax({
                url : "<?php echo site_url('vehicle/data_fuel_sarana')?>/"+start+"/"+end,
                type : "POST",
                dataType : "JSON",
                success:function(data)
                {
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
						label: 'BBM',
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

			var ctx = $("#mycanvas");
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
							labelString: 'Nap'
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
        }); // end ajax
        }); // end function on click filter
        $("#btn1").on("click", function() {
     var context1 = document.querySelector('#graph').getContext('2d');
    new Chart(context1).Line(data);
  });
        /*function reload()
    	{
    		alert('goddamnit');
    	}*/

    });


    </script>
    <input type="text" name="awal" id="awal" value="2018-08-01"> awal
    <input type="text" name="akhir" id="akhir" value="2018-08-31"> akhir
                            <button type="button" id="btnSave" class="btn btn-primary">Save</button>

	<!-- <script>
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var config = {
			type: 'line',
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'Karyawan Keluar',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [12, 19, 3, 5, 2, 3],
					fill: false,
				}, {
					label: 'Karyawan Masuk',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [22, 29, 23, 25, 22, 23],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Graphic Karyawan Masuk-Keluar'
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
							labelString: 'Bulan'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Jumlah'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});

			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});
	</script> -->
	<!-- page script -->

</body>

</html>