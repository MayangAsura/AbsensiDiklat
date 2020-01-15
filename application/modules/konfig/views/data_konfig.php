<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-primary btn-fw" onclick="tambah()"><span class="fa fa-plus"></span><i class="mdi mdi-plus"></i>Tambah</button>
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data Konfig</h3>
				<hr/>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Nama Aplikasi
								</th>
								<th>
									Tgl
								</th>
								<th>
									Klien
								</th>
								<th>
									Pembuat
								</th>
								<th>
									Footer
								</th>
								<th>
									Logo
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
<?php include('add_konfig.php'); ?>
<?php include('upload_img.php'); ?>

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){

	table = $("#mydata").dataTable({
		processing: true,
		language: {
			searchPlaceholder: "Cari Data",
			processing: '<img src="<?=base_url('images/load.gif')?>" width="100"><span class="text-success">Loading...</span>',
		},
		"serverSide": true,
		"ajax": {
			"url": "<?php echo base_url()?>index.php/konfig/ajax_list",
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
    	url : "<?php echo site_url('konfig/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_konfig"]').val(data.id_konfig);
    		$('[name="nama"]').val(data.nama_aplikasi);
    		$('[name="tgl"]').val(data.tgl);
    		$('[name="klien"]').val(data.klien);
    		$('[name="pembuat"]').val(data.created_by);
    		$('[name="footer"]').val(data.footer);
    		//$('[name="logo"]').val(data.logo);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Edit Data : '+data.nama_aplikasi); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function ganti(id)
{

    //Ajax Load data from ajax
    $.ajax({
    	url : "<?php echo site_url('konfig/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{
    		//var img = "<img src='<?= base_url()?>images/"+data.logo+"' width='300px'>";
    		$('[name="id_upload"]').val(data.id_konfig);
    		$('#blah').attr('src', '<?= base_url()?>images/'+data.logo);

            $('#modal_upload').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Ganti Logo : '+data.nama_aplikasi); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function upload(id)
{	
	 $('#form')[0].reset(); // reset form on modals
    $('#modal_upload').modal('show'); // show bootstrap modal
    $('.title').text('Upload Gambar'); // Set Title to Bootstrap modal title
    $('[name="id_upload"]').val(id);
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
        	url : "<?php echo site_url('konfig/ajax_delete')?>/"+id,
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