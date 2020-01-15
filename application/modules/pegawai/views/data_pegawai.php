<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-primary btn-fw" onclick="tambah()"><span class="fa fa-plus"></span><i class="mdi mdi-plus"></i>Tambah</button>
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data Pegawai</h3>
				<hr/>
				<form method="post" id="import_form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-5 col-xl-5 col-sm-6">
							<div class="form-group">
								<label>Upload Excel Pegawai (<a href="<?=base_url('file/data_pegawai.xlsx')?>">Klik Disini</a> Untuk Melihat Contoh File Excel)</label> 
								<input type="file" class="form-control" id="excel_pegawai" name="excel_pegawai" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
								<small class="help-block text-danger"></small>
							</div>
						</div>
						<div class="col-lg-2 col-xl-2 col-sm-2">
							<br/>
							<button type="submit" class="btn btn-info btn-fw" id="btnUpload"><span class="fa fa-plus"></span><i class="mdi mdi-upload"></i>Upload</button>
						</div>
					</div>
				</form>
				<br/>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata" style="text-align: center;">
						<thead>
							<tr class="bg-primary" style="color: white;">
								<th>
									#
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
									Qrcode
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
<?php include('add_pegawai.php'); ?>

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() 
{
	
	$('#import_form').on('submit', function(event){
		var excel = $('#excel_pegawai').val();
		if(excel == '') {
			swal("Warning !","Harap upload file dahulu.", "error");
		} else {
			reload_table();
			event.preventDefault();
			$.ajax({
				url:"<?php echo base_url()?>index.php/pegawai/data_excel",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					swal("Success !",data, "success");
					$('#excel_pegawai').val('');
					reload_table();

				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}
	});

	table = $("#mydata").dataTable({
		processing: true,
		language: {
			searchPlaceholder: "Cari Data",
			processing: '<img src="<?=base_url('images/load.gif')?>" width="100"><span class="text-success">Loading...</span>',
		},
		"serverSide": true,
		"ajax": {
			"url": "<?php echo base_url()?>index.php/pegawai/ajax_list",
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
    	url : "<?php echo site_url('pegawai/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_pegawai"]').val(data.id);
    		$('[name="nama_lengkap"]').val(data.nama_lengkap);
    		$('[name="unit"]').val(data.unit);
    		$('[name="nip"]').val(data.nip);
    		$('[name="email"]').val(data.email);

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
				url : "<?php echo site_url('pegawai/ajax_delete')?>/"+id,
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