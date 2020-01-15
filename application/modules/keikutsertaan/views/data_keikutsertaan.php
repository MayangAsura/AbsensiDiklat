<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-primary btn-fw" onclick="tambah()"><span class="fa fa-plus"></span><i class="mdi mdi-plus"></i>Tambah</button>
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data Keikutsertaan</h3>
				<hr/>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata" style="text-align: center;">
						<thead>
							<tr class="bg-primary" style="color: white;">
								<th>
									#
								</th>
								<th>
									Kode Diklat
								</th>
								<th>
									Nama Diklat
								</th>
								<th>Detail Pegawai Diklat</th>
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
<?php include('add_keikutsertaan.php'); ?>
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
			"url": "<?php echo base_url()?>index.php/keikutsertaan/ajax_list",
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

 
</script>