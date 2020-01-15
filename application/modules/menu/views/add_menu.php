<!-- MODAL ADD -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						   <form class="forms-sample" action="#" method="POST" id="form">
							<input type="hidden" value="" name="id_menu" id="id_menu"/> 
                            <div class="form-group">
                                <label>ID Level</label>
                                <input type="text" class="form-control" id="level" name="level" placeholder="Level" readonly=""><small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Menu Utama</label> 
                                <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Utama">
                                <small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Icon</label> 
                                <select class="form-control" id="icon" name="icon">
                                    <?php foreach($icon as $ic) {?>
                                        <option value="<?= $ic->id_icon;?>">
                                            <?= $ic->icon;?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Link</label> 
                                <input type="text" class="form-control" id="link" name="link" placeholder="Link Menu">
                                <small class="help-block text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Level Menu</label> 
                                <select class="form-control" id="l_menu" name="l_menu">
                                 <option value="1">Menu Utama</option>
                                 <option value="2">Sub Menu Dari ...</option>
                             </select>
                             <small class="help-block text-danger"></small>
                         </div>
                         <div class="form-group" style="display: none" id="subMenu">
                            <label>Sub Menu</label> 
                            <select class="form-control" id="id_parents" name="id_parents">
                                <option value="">-- PILIH SUB MENU --</option>

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

    $(document).ready(function()
    {
        $("#l_menu").change(function() {
            if($(this).val() == 2) {
                $("#subMenu").show();
            }
            else {
                $("#subMenu").hide();
            }
        });
    });

    function tambah(id)
    {
      save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('level/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="level"]').val(data.id_level);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.title').text('Tambah Data Menu'); // Set title to Bootstrap modal title

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?php echo site_url('menu/ajax_sub_menu/')?>/" + data.id_level,
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

    function save()
    {
    $('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    if(save_method == 'add') {
    	var url = "<?php echo site_url('menu/ajax_add')?>";
    } else {
    	var url = "<?php echo site_url('menu/ajax_update')?>";
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
                location.reload(true);
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