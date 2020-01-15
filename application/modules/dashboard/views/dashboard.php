<style type="text/css">
	#watch {
		color: #5983e8;
		z-index: 1;
		height: 1.4em;
		width: 4.0em;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		font-size: 5vw;
	}
</style>
<h3>Selamat Datang, <?=$this->session->userdata("f_name").' '.$this->session->userdata("l_name");?></h3>
<hr/>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div id="watch"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<b>Pilih Nama Diklat Untuk Export Excel</b>
				<form method="post" action="<?=base_url('absensi/export_excel')?>">
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-sm-6">
							<div class="form-group">
								<select class="form-control diklat_id" id="diklat_id" name="diklat_id" style="width: 100%">
									<option value=""></option>
									<<?php foreach ($get_diklat as $key => $value): ?>
									<option value="<?= $value->id?>"><?=$value->kode_diklat.' - '.$value->nama_diklat?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-xl-6 col-sm-6">
						<button type="submit" class="btn btn-success btn-fw"><span class="fa fa-plus"></span><i class="mdi mdi-download"></i>Export Excel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<div class="row">
	<div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 grid-margin stretch-card">
		<div class="card card-statistics">
			<div class="card-body">
				<center><b>Jumlah Pegawai Pada Kegiatan Diklat</b></center>
				<hr/>
				<div class="form-group">
					<select class="form-control diklat_id" id="diklat" name="diklat" style="width: 100%">
						<option value=""></option>
						<<?php foreach ($get_diklat as $key => $value): ?>
						<option value="<?= $value->id?>"><?=$value->kode_diklat.' - '.$value->nama_diklat?></option>
					<?php endforeach ?>
				</select>
			</div>
			<br/>
			<div id="ket"></div>
			<canvas id="pieChart" width="400" height="400"></canvas>
		</div>
	</div>
</div>
<div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 grid-margin stretch-card">
	<div class="card card-statistics">
		<div class="card-body">
			<center><b>Jumlah Pegawai Per Unit</b></center>
			<hr/>
			<br/><br/><br/>
			<canvas id="pieChart1" width="400" height="400"></canvas>
		</div>
	</div>
</div>
</div>
<?php if($this->session->userdata("id_level") == 1) { ?>
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body card-statistics">
					<h3>Log Aktivitas User</h3>
					<hr/>
					<div class="table-responsive">
						<table class="table table-hover" id="mydata">
							<thead>
								<tr>
									<th>
										#
									</th>
									<th>
										Time Log
									</th>
									<th>
										User Log
									</th>
									<th>
										Tipe Log
									</th>
									<th>
										Desc Log
									</th>
								</tr>
							</thead>
							<tbody id="show_data">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- MODAL ADD -->
<script type="text/javascript">
	var table;

	$(document).ready(function(){
		$("#ket").html("<center><h3 style='color:red'>Pilih Nama Diklat Dahulu</h3></center>");
		$(".diklat_id").select2({
			placeholder: "Pilih Nama Diklat",
			allowClear: true 
		});

		table = $("#mydata").dataTable({
			processing: true,
			language: {
				searchPlaceholder: "Cari Data",
				processing: '<img src="<?=base_url('images/load.gif')?>" width="100"><span class="text-success">Loading...</span>',
			},
			"serverSide": true,
			"ajax": {
				"url": "<?php echo base_url()?>index.php/dashboard/ajax_list",
				"type": "POST"
			},
			"columnDefs":[{    
				targets: [ -1 ],
				"orderable":false,  
			},  
			],  
			"pageLength": 30,
		});	 

		function clock() {
			var now = new Date();
			var secs = ('0' + now.getSeconds()).slice(-2);
			var mins = ('0' + now.getMinutes()).slice(-2);
			var hr = now.getHours();
			var Time = hr + ":" + mins + ":" + secs;
			document.getElementById("watch").innerHTML = Time;
			requestAnimationFrame(clock);
		}

		requestAnimationFrame(clock);
		$('#diklat').change(function(){
			
			var id = $("#diklat").val();

			$.ajax({
				url: "<?php echo base_url()?>index.php/dashboard/hadir_chart/" + id,
				method: "GET",
				dataType: "JSON",	
				success: function(data) {
					$("#ket").text('');
					var status = [];
					var jml = [];
					var tot = 0;
					for(var i in data) {
						status.push(data[i].status);
						jml.push(data[i].jml);

						tot = tot + 1;
					}

					var data_hadir = {
						labels: status,
						datasets: [{
							data: jml,
							backgroundColor: [
							'rgba(75, 192, 192, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							],
							borderColor: [
							'rgba(75, 192, 192, 1)',
							'rgba(153, 102, 255, 1)',
							],
							borderWidth: 1
						}]
					};

					var pilihan_1 = {
						scales: {
							yAxes: [{
								display: true,
								ticks: {
									beginAtZero: true,
									steps: 10,
									stepValue: 5,
									max: tot
								}
							}]
						},
						legend: {
							display: false,
						},
						elements: {
							point: {
								radius: 0
							}
						}

					};

					if ($("#pieChart").length) {
						var barChartCanvas = document.getElementById("pieChart").getContext('2d');
						var barChart = new Chart(barChartCanvas, {
							type: 'bar',
							data: data_hadir,
							options: pilihan_1
						});
					}
				}, error: function(data) {
					console.log(data);
				}
			});
		});
		$.ajax({
			url: "<?php echo base_url()?>index.php/dashboard/pegawai_chart",
			method: "GET",
			dataType: "JSON",	
			success: function(data) {
				var unit = [];
				var jml = [];
				var tot = 0;
				for(var i in data) {
					unit.push(data[i].unit);
					jml.push(data[i].jml);

					tot = tot + 1;
				}

				var data_unit = {
					labels: unit,
					datasets: [{
						data: jml,
						backgroundColor: [
						'rgba(255, 0, 0, 0.2)',
						'rgba(59, 12, 232, 0.2)',
						'rgba(232, 160, 12, 0.2)',
						],
						borderColor: [
						'rgba(255,0,0,1)',
						'rgba(59, 12, 232, 1)',
						'rgba(232, 160, 12, 1)',
						],
						borderWidth: 1
					}]
				};

				var pilihan = {
					scales: {
						yAxes: [{
							display: true,
								ticks: {
									beginAtZero: true,
									steps: 10,
									stepValue: 5,
									max: tot
								}
						}]
					},
					legend: {
						display: false
					},
					elements: {
						point: {
							radius: 0
						}
					}

				};

				if ($("#pieChart1").length) {
					var barChartCanvas1 = $("#pieChart1").get(0).getContext("2d");
					var barChart = new Chart(barChartCanvas1, {
						type: 'bar',
						data: data_unit,
						options: pilihan
					});
				}
			}, error: function(data) {
				console.log(data);
			}
		});
	});
</script>