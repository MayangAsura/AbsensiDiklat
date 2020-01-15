<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div style="float: right;">
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data log</h3>
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
			"url": "<?php echo base_url()?>index.php/log/ajax_list",
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
    	url : "<?php echo site_url('log/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_log"]').val(data.id_log);
    		$('[name="log"]').val(data.log);
    		$('[name="keterangan"]').val(data.keterangan);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Edit Data : '+data.log); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	alert('Error get data from ajax');
        }
    });
}

function hapus(id)
{	
	if(confirm('Are you sure delete this data?'))
	{
        // ajax delete data to database
        $.ajax({
        	url : "<?php echo site_url('log/ajax_delete')?>/"+id,
        	type: "POST",
        	dataType: "JSON",
        	success: function(data)
        	{
        		$('#modal_form').modal('hide');
        		reload_table();
        		alert("Data Berhasil Dihapus");
        	},
        	error: function (jqXHR, textStatus, errorThrown)
        	{
        		alert('Error deleting data');
        	}
        });

    }
}
</script>