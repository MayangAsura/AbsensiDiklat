<div class="row">
	<div class="col-lg-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h3><?= $profil->f_name.' '.$profil->l_name;?></h3>
				<hr/>
				<center>
					<img class="img-sm rounded-circle" src="<?= base_url('images/user/'.$profil->foto)?>" alt="profile image" style="width: 130px; height: 130px">
				</center>
				<br/>
				<center>
					<h3><?= $profil->f_name.' '.$profil->l_name;?></h3>
					<h5 class="text-primary"><?= $profil->nama_level;?></h5>
					<small><?= $profil->email;?> | <?= $profil->no_hp;?></small>
				</center>
			</div>
		</div>
	</div>
	<div class="col-lg-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h3><?= $title?></h3>
				<hr/>
				 <form class="forms-sample" action="#" method="POST" id="form_password">
					<input type="hidden" value="<?= $this->session->userdata("id");?>" name="id_user" id="id_user"/>
					<div class="form-group">
						<label>Password Lama</label>
						<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Password Lama" onkeyup="cekOldPass(this.value);"><small class="help-block text-danger"></small><small id="psn"></small>
					</div>
					<div class="form-group">
						<label>Password Baru</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password Baru"><small class="help-block text-danger"></small>
					</div>
					<div class="form-group">
						<label>Konfirmasi Password</label>
						<input type="password" class="form-control" id="confirm" name="confirm" placeholder="Konfirmasi Password"><small class="help-block text-danger"></small> <small id="message"></small>
					</div>
					<small id="message"></small>
				</form> 
				<button  type="submit" id="btnSave" onclick="save_password()" class="btn btn-primary btn-block">
					<i class="mdi mdi-content-save"></i>Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function cekOldPass(value)
	{
		$.ajax({
			type: "GET",
			url: "<?php echo site_url('login/cekPassOld')?>",
			data: {'old_password' : value},
			dataType: "JSON",
			success: function(msg)
			{
				if (msg === true) {
					$('#psn').html("Password Cocok").css('color', 'green');
					$('#btnSave').attr('disabled',false);
				} else {
					$('#psn').html("Password Tidak Cocok").css('color', 'red');
					$('#btnSave').attr('disabled',true);
				}
			}
		});
	}

	function save_password()
	{
    $('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    var url = "<?php echo site_url('login/ajax_password')?>";

    // ajax adding data to database
    $.ajax({
    	url : url,
    	type: "POST",
    	data: $('#form_password').serialize(),
    	dataType: "JSON",	
    	success: function(data)
    	{

            if(data.status) //if success close modal and reload ajax table
            {
            	alert("Password Berhasil Diganti");
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

        	alert('Gagal Menyimpan Data');
            $('#btnSave').text('Simpan Lagi...'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

$(document).ready(function(){

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
</script>