<style type="text/css">
	/* Styling Checkbox Starts */
	.checkbox-label {
		display: block;
		position: relative;
		margin: auto;
		cursor: pointer;
		font-size: 22px;
		line-height: 24px;
		height: 24px;
		width: 24px;
		clear: both;
	}

	.checkbox-label input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
	}

	.checkbox-label .checkbox-custom {
		position: absolute;
		top: 0px;
		left: 0px;
		height: 24px;
		width: 24px;
		background-color: transparent;
		border-radius: 5px;
		transition: all 0.3s ease-out;
		-webkit-transition: all 0.3s ease-out;
		-moz-transition: all 0.3s ease-out;
		-ms-transition: all 0.3s ease-out;
		-o-transition: all 0.3s ease-out;
		border: 2px solid #eee;
	}


	.checkbox-label input:checked ~ .checkbox-custom {
		background-color: #fff;
		border-radius: 5px;
		-webkit-transform: rotate(0deg) scale(1);
		-ms-transform: rotate(0deg) scale(1);
		transform: rotate(0deg) scale(1);
		opacity:1;
		border: 2px solid #5983e8;
	}


	.checkbox-label .checkbox-custom::after {
		position: absolute;
		content: "";
		left: 12px;
		top: 12px;
		height: 0px;
		width: 0px;
		border-radius: 5px;
		border: solid #009BFF;
		border-width: 0 3px 3px 0;
		-webkit-transform: rotate(0deg) scale(0);
		-ms-transform: rotate(0deg) scale(0);
		transform: rotate(0deg) scale(0);
		opacity:1;
		transition: all 0.3s ease-out;
		-webkit-transition: all 0.3s ease-out;
		-moz-transition: all 0.3s ease-out;
		-ms-transition: all 0.3s ease-out;
		-o-transition: all 0.3s ease-out;
	}


	.checkbox-label input:checked ~ .checkbox-custom::after {
		-webkit-transform: rotate(45deg) scale(1);
		-ms-transform: rotate(45deg) scale(1);
		transform: rotate(45deg) scale(1);
		opacity:1;
		left: 8px;
		top: 3px;
		width: 6px;
		height: 12px;
		border: solid #009BFF;
		border-width: 0 2px 2px 0;
		background-color: transparent;
		border-radius: 0;
	}

</style>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<a href="javascript:void(0);" class="btn btn-success btn-fw" onclick="kirim_all(<?=$diklat_id?>)">SEND ALL</a>
					<a class="btn btn-info" href="<?=site_url('keikutsertaan')?>" class="mdi mdi-arrow-left m"></i>Back</a>
				</div>
				<h3>Data Pegawai Mengikuti Diklat</h3>
				<hr/>
				<div style="float: right;">
					<button class="btn btn-primary btn-sm sendQR" id="sendQR" style="display: none" onclick="kirim_qr()"><i class="mdi mdi-send"></i> Send QR</button>
					<a href="<?=base_url('format')?>" class="btn btn-info"><i class="mdi mdi-file m"></i> Format Email</a>
				</div>
				<div id="keterangan"></div>
				<br/><br/>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata" style="text-align: center;">
						<thead>
							<tr class="bg-primary" style="color: white;">
								<th>
									#
								</th>
								<th>
									Pilih
								</th>
								<th>
									NIP
								</th>
								<th>
									Nama Pegawai
								</th>
								<th>
									Email
								</th>
								<th>
									Unit
								</th>
								<th>
									Kirim QR Code
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no=0;
							foreach ($get_pegawai as $key => $value) { ?>
								<tr onclick="selectRow(this)">
									<td><?= ++$no?></td>
									<td>
										<center>
											<label class="checkbox-label">
												<input type="checkbox"  class="checkbox" name="pilih[]" value="<?=$value->id?>">
												<span class="checkbox-custom rectangular"></span>
											</label>
										</center>
									</td>
									<td><?=$value->nip?></td>
									<td><?=$value->nama_lengkap?></td>
									<td><?=$value->email?></td>
									<td><?=$value->unit?></td>
									<td>
										<a href="javascript:void(0);" class="btn btn-icons btn-success btn-rounded" title="Kirim QR Code" onclick="kirim(<?=$value->id?>, <?=$diklat_id?>)"><i class="mdi mdi-send"></i></a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){
	table = $("#mydata").dataTable({});	
});

function selectRow(row)
{
	var firstInput = row.getElementsByTagName('input')[0];
	firstInput.checked = !firstInput.checked;
	if($(".checkbox").length == $(".checkbox:checked").length) {
		$(".sendQR").show();
		row.style.backgroundColor=(row.style.backgroundColor == '#eee')?('transparent'):('#eee');
	} else {
		$(".sendQR").hide();
		row.style.backgroundColor=(row.style.backgroundColor == '#fff')?('transparent'):('#fff');
	}
}

function kirim(id, diklat_id)
{	
	swal({
		title: "Apakah Anda Yakin Ingin Mengirim QR Code ?",
		icon: "warning",
		buttons: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url : "<?php echo site_url('pegawai/send_qr')?>/"+id+"/"+diklat_id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal("Success !", "QR Code Berhasil Dikirim", "success");
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error deleting data');
				}
			});
		} 
	});
}

function kirim_qr() 
{
	var pegawai_arr = [];
	$(".checkbox:checked").each(function(){
		var pegawai_id = $(this).val();
		pegawai_arr.push(pegawai_id);
	});

	var len = pegawai_arr.length;

	swal({
		title: "Apakah Anda Yakin Ingin Kirim Ke "+len+" Peserta ?",
		icon: "warning",
		buttons: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			var pegawai_arr = [];
			$(".checkbox:checked").each(function(){
				var pegawai_id = $(this).val();
				pegawai_arr.push(pegawai_id);
			});

			var length = pegawai_arr.length;

			if(length > 0){

                 $.ajax({
                 	url: '<?= base_url() ?>index.php/pegawai/sendQR',
                 	type: 'post',
                 	data: {pegawai_ids: pegawai_arr},
                 	dataType: "JSON",
                 	success: function(data){
                 		console.log(data);
                 		return;
                 		windows.location.reload(false);
                 		swal("Success !", len+"QR Code Berhasil Dikirim !", "success");
                 	},
                 	error: function (jqXHR, textStatus, errorThrown)
                 	{
                 		alert('Error get data from ajax');
                 	}
                 });
             }
         } 
     });
}

function kirim_all(id)
{	
	swal({
		title: "Apakah Anda Yakin Ingin Kirim Ke Semua Peserta ?",
		icon: "warning",
		buttons: true,
	})
	.then((willDelete) => {
		if (willDelete) {	
			$.ajax({
				url : "<?php echo site_url('pegawai/all_peserta')?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					swal("Success !", "QR Code Berhasil Dikirim Ke " + data.jml + " Peserta", "success");
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error deleting data');
				}
			});
		} 
	});
}
</script>