<!doctype html>
<html>

<head>
	<title>Graphic Karyawan Masuk-Keluar <?php echo $tahun;  ?></title>
	<script src="<?php echo base_url() ?>assets/chartjs/Chart.bundle.js"></script>
	<script src="<?php echo base_url() ?>assets/chartjs/utils.js"></script>
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
    <div style="width:50%;">
		<canvas id="mycanvas"></canvas>
	</div>
    <br>


<?php 
for ($i=0; $i <= 11 ; $i++) { 
    switch ($i) {
        case 0:
            $nama_bulan = "January";
            break;
            case 1:
            $nama_bulan = "February";
            break;
            case 2:
            $nama_bulan = "March";
            break;
            case 3:
            $nama_bulan = "April";
            break;
            case 4:
            $nama_bulan = "May";
            break;
            case 5:
            $nama_bulan = "June";
            break;
            case 6:
            $nama_bulan = "July";
            break;
            case 7:
            $nama_bulan = "August";
            break;
            case 8:
            $nama_bulan = "September";
            break;
            case 9:
            $nama_bulan = "October";
            break;
            case 10:
            $nama_bulan = "November";
            break;
            case 11:
            $nama_bulan = "December";
            break;

    }
    echo "<table border=2>
            <tr>
                <th colspan=6>".$nama_bulan."-".$tahun."</th>
            </tr>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Date of Join</th>
                <th>Status</th>
            </tr>";
            $no=1;
            if (!empty($emp_in_monthly[$i])) {
                foreach ($emp_in_monthly[$i] as $key) {
                    echo "<tr><td>".$no."</td>";
                    echo "<td>".$key->empcode."</td>";
                    echo "<td>".$key->empname."</td>";
                    echo "<td>".$key->position."</td>";
                    echo "<td>".date_indonesia($key->hire_date)."</td>";
                    echo "<td>".$key->employeetype."</td></tr>";
                    $no++;
            }
            }
            else{
                echo "<tr><td colspan=6 align='center'>*Tidak Ada Data*</td></tr>";
            }
        echo "
    </tr>
    </table>";
	}
?>
	<br>
	<!-- <button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button>
	<button id="addData">Add Data</button>
    <button id="removeData">Remove Data</button> -->
    <script>
    $(document).ready(function() {
        $.ajax({
                url : "<?php echo site_url('hr/test_data'); ?>",
                type : "GET",
                dataType : "JSON",
                success:function(data)
                {
                    //console.log(data);
                    var keluar = [];
                    var masuk = [];
                    for (var i = 0; i < data.length; i++) {
                        masuk.push(data[i].emp_in);
                        keluar.push(data[i].emp_out);
                } 
                console.log(masuk);
                //alert('dapat data'+data[0].jml_emp);
                var chartdata = {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				datasets : [
					{
						label: 'Karyawan Masuk',
						backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
                        fill: false,
						data: masuk
					},
                    {
					label: 'Karyawan Keluar',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: keluar,
					fill: false,
				}
                    
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'line',
                options: {
                    responsive: true,
                    title: {
					display: true,
					text: 'Graphic Karyawan Masuk-Keluar periode <?php echo $tahun;  ?>'
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
				},
				data: chartdata
			});

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                alert('Error Showing data');
                }
        });

    });
    </script>
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
</body>

</html>