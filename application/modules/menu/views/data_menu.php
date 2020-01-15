<div class="row">
	<?php 
	$no=1;
	foreach($level as $lev) {
		if ($no % 2 == 1) {
			$text = "text-success";
		} else {
			$text = "text-warning";
		}
		?>
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
		<div class="card card-statistics">
			<div class="card-body">
				<div class="clearfix">
					<div class="float-left">
						<i class="mdi mdi-account-switch <?=$text?> icon-lg"></i>
					</div>
					<div class="float-right">
						<p class="mb-0 text-right"><?= strtoupper($lev->level)?></p>
						<div class="fluid-container">
							<a href="javascript:tambah(<?= $lev->id_level;?>)"><span class="fa fa-plus"></span><i class="mdi mdi-settings"></i> Atur Menu</a>
						</div>
					</div>
				</div>
				<p class="text-muted mt-3 mb-0">
					<i class="mdi mdi-account mr-1" aria-hidden="true"></i><?= $lev->keterangan;?>
				</p>
			</div>
		</div>
	</div>
	<?php 
	$no++;
	} ?>
</div>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body card-statistics">
				<div style="float: right;">
					<button class="btn btn-info" onclick="reload_table()"><i class="mdi mdi-refresh m"></i></button>
				</div>
				<h3>Data Menu</h3>
				<hr/>
				<div class="table-responsive">
					<table class="table table-hover" id="mydata">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Menu
								</th>
								<th>
									Level
								</th>
								<th>
									Link
								</th>
								<th>
									Sub Menu Dari
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
<?php include('add_menu.php'); ?>
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
			"url": "<?php echo base_url()?>index.php/menu/ajax_list",
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
    	url : "<?php echo site_url('menu/ajax_edit/')?>/" + id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data)
    	{

    		$('[name="id_menu"]').val(data.id_menu);
    		$('[name="menu"]').val(data.menu);
    		$('[name="level"]').val(data.level);
    		$('[name="icon"]').val(data.icon);
    		$('[name="link"]').val(data.link);
    		$('[name="id_parents"]').val(data.id_parents);
    		if(data.id_parents == 0) {
    			$('[name="l_menu"]').val(1);
    			$("#subMenu").hide();
    		} else {
    			$('[name="l_menu"]').val(2);
    			$("#subMenu").show();
    		}
    		

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.title').text('Edit Data : '+data.menu); // Set title to Bootstrap modal title

            $.ajax({
            	type: "POST",
            	dataType: "JSON",
            	url: "<?php echo site_url('menu/ajax_sub_menu/')?>/" + data.level,
            	success: function(result){
            		var selOpts = "";
            		for (i=0;i<result.length;i++)
            		{
            			var id = result[i]['id_menu'];
            			var val = result[i]['menu'];
            			selOpts += "<option value='"+id+"'>"+val+"</option>";
            		}
            		$('#id_parents').append(selOpts);
            	}
            });

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
        	url : "<?php echo site_url('menu/ajax_delete')?>/"+id,
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