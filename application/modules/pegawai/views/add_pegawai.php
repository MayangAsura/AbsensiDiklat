<!-- MODAL ADD -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						   <form class="forms-sample" method="POST" action="javascript:tambah()" id="form" enctype="multipart/form-data">
							<input type="hidden" value="" name="id_pegawai" id="id_pegawai"/> 
							<div class="form-group">
                                <label>Nomor Induk Pegawai (NIP)</label> 
                                <input type="text" class="form-control" id="nip" name="nip" placeholder="Nomor Induk Pegawai (NIP)">
                                <small class="help-block text-danger" id="pesan"></small>
                            </div>
                            <div class="form-group">
                                <label>Nama Pegawai</label> 
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Pegawai">
                                <small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"><small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit"><small class="help-block text-danger"></small>
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
                swal("Warning !", "Nomor Induk Pegawai Tidak Boleh Spasi", "error");
                $('#btnSave').attr('disabled',true);
            }
            $('#btnSave').attr('disabled',false);
        });


    });

    $('#nip').change(function(){
        $('#pesan').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
        var nip = $(this).val();

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url('pegawai/cek_nip')?>",
            data    : {nip: nip},
            dataType: "JSON",
            success : function(data){  
                if (data.status == true) {
                    $('#btnSave').attr('disabled',true);
                    $('#pesan').html('<br/><label class="alert alert-danger" style="width:100%"><span>NIP sudah terdaftar. Harap Ganti NIP Baru.</span></label>');
                } else {
                    $('#btnSave').attr('disabled',false);
                    $('#pesan').html('<br/><label class="alert alert-success" style="width:100%"><span> NIP Tersedia</span></label>');
                }
                
            }
        })

    });

    function tambah()
    {
        $('[name="tag"]').val("");
        save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.title').text('Tambah Data Pegawai'); // Set Title to Bootstrap modal title
}

function save()
{
    $('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    if(save_method == 'add') {
    	var url = "<?php echo site_url('pegawai/ajax_add')?>";
    } else {
    	var url = "<?php echo site_url('pegawai/ajax_update')?>";
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