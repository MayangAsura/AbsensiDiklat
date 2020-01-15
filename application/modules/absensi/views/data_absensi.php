<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data absensi</h3>
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

	function autoSave()  
	{  
		var qr_nip = $('#qr_nip').val();  

		if(qr_nip != '')  
		{  
			$.ajax({  
				url: "<?php echo site_url('absensi/scan_kehadiran/')?>",  
				method:"POST",  
				data:{qr_nip:qr_nip},  
				dataType:"JSON",  
				success:function(data)  
				{  
					$('#autoSave').html("<div class='alert alert-success'>Successfully</div>");  

					setInterval(function(){  
						$('#autoSave').html(''); 
						$('#qr_nip').val('');  
					}, 1000);  
				}  
			});  
		}            
	}  

	setInterval(function(){   
		autoSave(); 
		reload_table();  
	}, 1000);  

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