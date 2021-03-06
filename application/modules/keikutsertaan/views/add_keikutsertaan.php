<!-- MODAL ADD -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog modal-lg" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						   <form class="forms-sample" method="POST" action="javascript:tambah()" id="form" enctype="multipart/form-data">
							<input type="hidden" value="" name="id_keikutsertaan" id="id_keikutsertaan"/> 
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
                        <div class="form-group">
                            <label>Nama Pegawai</label> 
                            <select class="form-control" id="pegawai_id" multiple name="pegawai_id[]" style="width: 100%">
                                <option value=""></option>
                                <<?php foreach ($get_pegawai as $key => $value): ?>
                                <option value="<?= $value->id?>"><?=$value->nip.' - '.$value->nama_lengkap?></option>
                            <?php endforeach ?>
                        </select>
                        <small class="help-block text-danger"></small>
                    </div>
                </form> 
                <button  type="submit" id="btnSave" onclick="save()" class="btn btn-primary btn-block">
                 <i class="mdi mdi-content-save"></i>Simpan
             </button>
             <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                 <i class="mdi mdi-close"></i>Keluar
             </button>
         </div>
     </div>
                   </div>
         
                </div>
              </div>
            </div>
        <!--END MODAL ADD-->
<script type="text/javascript">
    $(document).ready( function() {
        $('#nip').bind('keypress', function(e) {
            if (e.which == 32){//space bar
                swal("Warning !", "Nomor Induk keikutsertaan Tidak Boleh Spasi", "error");
                $('#btnSave').attr('disabled',true);
            }
            $('#btnSave').attr('disabled',false);
        });

        $("#diklat_id").select2({
            placeholder: "Pilih Nama Diklat",
            allowClear: true 
        });
        $("#pegawai_id").select2({
            placeholder: "Pilih Pegawai",
            allowClear: true,
            multiple: true,
        });
    });

    function tambah()
    {
        $('[name="tag"]').val("");
        save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.title').text('Tambah Data Keikutsertaan Pegawai Diklat'); // Set Title to Bootstrap modal title
}

function save()
{
    $('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    if(save_method == 'add') {
    	var url = "<?php echo site_url('keikutsertaan/ajax_add')?>";
    } else {
    	var url = "<?php echo site_url('keikutsertaan/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
    	url : url,
    	type: "POST",
    	data: $('#form').serialize(),
    	dataType: "JSON",	
    	success: function(data)
    	{

            if(data.status) //if success close modal and reload ajax table
            {
            	$('#modal_form').modal('hide');
            	reload_table();
            	if(save_method == 'add') {
            		swal("Success !", "Data Berhasil Ditambahkan!", "success");
            	} else {
            		swal("Success !", "Data Berhasil Diganti!", "success");
            	}
            }
            else
            {
            	for (var i = 0; i < data.inputerror.length; i++) 
            	{
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Simpan Lagi...'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	if(save_method == 'add') {
        		swal("Gagal !", "Gagal Menyimpan Data!", "error");
        	} else {
        		swal("Gagal !", "Gagal Menyimpan Data!", "error");
        	}	
            $('#btnSave').text('Simpan Lagi...'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>