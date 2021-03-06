<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data absensi</h3>
				<hr/>
				<div class="form-group">
					<label>Kode dan Nama Diklat</label> 
					<select class="form-control" id="diklat_id" name="diklat_id" style="width: 100%">
						<option value=""></option>
						<?php foreach ($get_diklat as $key => $value): ?>
						<option value="<?= $value->id?>"><?=$value->kode_diklat.' - '.$value->nama_diklat?></option>
						<?php endforeach ?>
					</select>
					<small class="help-block text-danger"></small>
                </div>
				<hr/>
				<input name="qr_nip" id="qr_nip" onmouseover="this.focus();" type="text" class="form-control" >

				<div id="autoSave"></div> 

				<div class="table-responsive">
					<table class="table table-hover" id="mydata" style="text-align: center;">
						<thead>
							<tr class="bg-primary" style="color: white;">
								<th>
									#
								</th>
								<th>
									NIP - Nama Pegawai
								</th>
								<th>
									Kode - Nama Diklat
								</th>
								<th>
									Tanggal
								</th>
								<th>
									Jam Masuk
								</th>
								<th>
									Keterangan
								</th>
								<th>Aksi</th>
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
<?php include('add_absensi.php'); ?>

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){

	// setTimeout(function(){
   	// 	window.location.reload(1);
	// }, 5000);

	function autoSave()  
	{  
		var diklat_id2 = $('#diklat_id').val();
		var qr_nip = $('#qr_nip').val();

		if(qr_nip != '' && diklat_id2 != "")  
		{  		
				$.ajax({  
					url: "<?php echo site_url('absensi/scan_kehadiran/')?>",  
					method:"POST",  
					data:{qr_nip:qr_nip, diklat_id:diklat_id2},  
					dataType:"JSON",  
					success:function(data)  
					{  	
						console.log(data);
						var alert = data.alert;
						if(data.status == true){
							swal("Success !", "Anda Berhasil Absen!", "success");
							$('#autoSave').html("<div class='alert alert-success'>"+alert+"</div>"); 
						}else{
							swal("Error !", alert , "error");
							$('#autoSave').html("<div class='alert alert-danger'>"+alert+"</div>"); 
						}
						 
						setInterval(function(){  
							$('#autoSave').html(''); 
							$('#qr_nip').val('');  
						}, 3000);  
					}  
				});  
			// }
			// else{
			// $('#autoSave').html("<div class='alert alert-danger'>Jadwal Tidak Sesuai</div>");
			// }
		}            
	}  

	setInterval(function(){   
		autoSave(); 
		reload_table();  
	}, 3000);  

	table = $("#mydata").dataTable({
		processing: false,
		language: {
			searchPlaceholder: "Cari Data",
			processing: '<img src="<?=base_url('images/load.gif')?>" width="100"><span class="text-success">Loading...</span>',
		},
		"serverSide": true,
		"ajax": {
			"url": "<?php echo base_url()?>index.php/absensi/ajax_list",
			"type": "POST"
		},
		"columnDefs":[{    
			targets: [ -1 ],
			"orderable":false,  
		},  
		],  
			//"pageLength": 30,
		});	
});

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

function reload_table()
{
    table.api().ajax.reload(null,false); //reload datatable ajax 
}

    function edit(id)
    {
    	save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
    	url : "<?php echo site_url('absensi/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_absensi"]').val(data.id);
    		$('[name="pegawai_id"]').val(data.pegawai_id).trigger('change');
    		$('[name="diklat_id"]').val(data.diklat_id).trigger('change');
    		$('[name="tgl"]').val(data.tgl);
    		$('[name="jam_masuk"]').val(data.jam_masuk);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Edit Data : '+data.nama); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function hapus(id)
{	
	swal({
		title: "Are you sure delete this data?",
		icon: "warning",
		buttons: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url : "<?php echo site_url('absensi/ajax_delete')?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					$('#modal_form').modal('hide');
					reload_table();
					swal("Success !", "Data Berhasil Dihapus!", "success");
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