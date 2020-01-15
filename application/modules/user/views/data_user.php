<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-primary btn-fw" onclick="tambah()"><span class="fa fa-plus"></span><i class="mdi mdi-plus"></i>Tambah</button>
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data user</h3>
				<hr/>
				<blockquote class="blockquote blockquote-primary">
					<b>Keterangan : </b>
					<table>
						<tr>
							<td width="30%"><span class='btn btn-success btn-sm'></span></td>
							<td width="4%">:</td>
							<td> online</td>
						</tr>
						<tr>
							<td><span class='btn btn-danger btn-sm'></span></td>
							<td>:</td>
							<td> offline</td>
						</tr>
					</table>
				</blockquote>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>Aksi</th>
								<th>Status</th>
								<th>
									Username
								</th>
								<th>
									Nama Lengkap
								</th>
								<th>
									Email
								</th>
								<th>
									No. HP
								</th>
								<th>
									Level
								</th>
								<th>
									Last Login
								</th>
								<th>
									Created User
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
<?php include('add_user.php'); ?>

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){

	table = $("#mydata").dataTable({
		processing: false,
		language: {
			searchPlaceholder: "Cari Data",
			processing: '<img src="<?=base_url('images/load.gif')?>" width="100"><span class="text-success">Loading...</span>',
		},
		"serverSide": true,
		"ajax": {
			"url": "<?php echo base_url()?>index.php/user/ajax_list",
			"type": "POST",
			dataType: "json",
		},
		"columnDefs":[{    
			targets: [ -1 ],
			"orderable":false,  
		},  
		],  
			//"pageLength": 30,
		});	
});

setInterval(function() {
	table.api().ajax.reload(null,true); 
}, 1000);

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
    	url : "<?php echo site_url('user/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_user"]').val(data.id_user);
    		$('[name="username"]').val(data.username);
    		$('[name="f_name"]').val(data.f_name);
    		$('[name="l_name"]').val(data.l_name);
    		$('[name="email"]').val(data.email);
    		$('[name="no_hp"]').val(data.no_hp);
    		$('[name="level"]').val(data.level);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Edit Data : '+data.user); // Set title to Bootstrap modal title
            $('#penjelasan').html('<center><span class="text-danger">Kosongkan password, Jika tidak mengganti password</span></center><br/>');

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
				url : "<?php echo site_url('user/ajax_delete')?>/"+id,
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