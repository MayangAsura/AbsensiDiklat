<!-- MODAL ADD -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						   <form class="forms-sample" action="#" method="POST" id="form">
							<input type="hidden" value="" name="id_user" id="id_user"/> 
							<div class="form-group">
								<label>Username</label> 
								<input type="text" class="form-control" id="username" name="username" placeholder="Username">
								<small class="help-block text-danger" id="pesan"></small>
							</div>
                            <small id="penjelasan"></small>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <input type="checkbox" onchange="tick(this)" /> <small>Cek Password</small>
                                        <br/>
                                        <small class="help-block text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Confirm Password">
                                        <input type="checkbox" onchange="tick1(this)" /> <small>Cek Password</small><br/>
                                        <small class="help-block text-danger"></small> 
                                        <small id="message"></small>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off"><small class="help-block text-danger" id="pesanEmail"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name"><small class="help-block text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name"><small class="help-block text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP"><small class="help-block text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Level</label> 
                            <small class="help-block text-danger"></small>
                            <select class="form-control" id="level" name="level">
                                <option value="">-- Pilih Level User --</option>
                                <?php foreach($level as $lev) { ?>
                                <option value="<?= $lev->id_level;?>">
                                    <?= $lev->level;?>
                                </option>
                                <?php } ?>
                            </select>
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

    $(document).ready(function(){

        $('#username').blur(function(){
            $('#pesan').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
            var username = $(this).val();

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url('user/cek_username')?>",
                data    : {username: username},
                success : function(data){
                    $('#pesan').html(data);
                }
            })

        });

        $('#email').blur(function(){
            $('#pesanEmail').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
            var email = $(this).val();

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url('user/cek_email')?>",
                data    : {email: email},
                success : function(data){
                    $('#pesanEmail').html(data);
                }
            })

        });

        $('#confirm').on('keyup', function () {
            if ($(this).val() == $('#password').val()) {
                $('#message').html('Sama Dengan Password').css('color', 'green');
                $('#btnSave').attr('disabled',false); 
            } else {
                $('#message').html('Tidak Sama Dengan Password').css('color', 'red'); 
                $('#btnSave').attr('disabled',true); 
            }
        });
    });

    function tick(el) {
        $('#password').attr('type',el.checked ? 'text' : 'password');
    }

    function tick1(el) {
        $('#confirm').attr('type',el.checked ? 'text' : 'password');
    }

    function tambah()
    {
        save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.title').text('Tambah Data'); // Set Title to Bootstrap modal title
    $('#penjelasan').html('');
}

function save()
{
    $('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    if(save_method == 'add') {
        var url = "<?php echo site_url('user/ajax_add')?>";
    } else {
        var url = "<?php echo site_url('user/ajax_update')?>";
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
                $('#pesan').text('');
                $('#pesanEmail').text('');
                $('#message').text('');
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