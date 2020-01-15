<!-- MODAL ADD -->
<div class="modal fade" id="modal_lupa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						<form class="forms-sample" action="#" method="POST" id="formLupa">
							<div class="form-group">
								<small class="help-block text-danger" id="keteranganEmail"></small> <br/>
								<small class="text">Masukkan Email yg sudah didaftarkan</small> 
								<input type="text" class="form-control email" id="email" name="l_email" placeholder="Masukkan Email" autocomplete="off">
							</div>
							<div id="showBtn"></div>
							<div class="collapse" id="collapseExample">
								<div class="card card-body">
									<div class="form-group">
										<h5 class="label">Password Baru</h5>
										<div class="input-group">
											<input type="password" class="form-control" name="l_pass" id="l_pass" placeholder="*********">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-lock text-primary"></i>
												</span>
											</div>
										</div>
										<input type="checkbox" onchange="lupa_pass(this)" /> <small>Cek Password</small><br/>
										<small id="l_messagepassword"></small>
									</div>
									<div class="form-group">
										<h5 class="label">Konfirmasi Password Baru</h5>
										<div class="input-group">
											<input type="password" class="form-control" name="l_con" id="l_con" placeholder="*********">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-lock text-primary"></i>
												</span>
											</div>
										</div>
										<input type="checkbox" onchange="lupa_con(this)" /> <small>Cek Password</small><br/>
									</div>
									<small id="lupa_message"></small>
								</div>
							</form>
							<button  type="submit" id="btnLupaSimpan" onclick="save_lupa()" class="btn btn-primary btn-block">
								<i class="mdi mdi-content-save"></i>Simpan
							</button>
						</div>
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
		$('.email').blur(function(){
			//$('#keteranganEmail').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
			var email = $(this).val();
			$.ajax({
				type    : 'POST',
				url     : "<?php echo site_url('user/cek_email_lupa')?>",
				data    : {email: email},
				success : function(data){
					if (data == "1") {
						$('#showBtn').html('<p>'+
							'<a class="btn btn-success btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="mdi mdi-eye"></i> Show'+
							'</a>'+
							'</p>');
						$(".email").prop('disabled', true);
					} else {
						$('#showBtn').html("");
					}
				}
			});

		});

		$('#l_pass').blur(function(){			
			if(this.value.length < 6) {
				$('#l_messagepassword').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
				$('#l_messagepassword').html("Harus lebih dari 5 karakter").css('color', 'red');
				$('#btnLupaSimpan').attr('disabled',true);
			} else {
				$('#l_messagepassword').html(" ");
				$('#btnLupaSimpan').attr('disabled',false);
			}
		});

		$('#l_con').on('keyup', function () {
			if ($(this).val() == $('#l_pass').val()) {
				$('#lupa_message').html('Password Cocok').css('color', 'green');
			} else $('#lupa_message').html('Password tidak cocok').css('color', 'red');
		});

	});

	function lupa_pass(el) {
		$('#l_pass').attr('type',el.checked ? 'text' : 'password');
	}

	function lupa_con(el) {
		$('#l_con').attr('type',el.checked ? 'text' : 'password');
	}

	function lupa_password()
	{
	    $('#formLupa')[0].reset(); // reset form on modals
	    $('.form-group').removeClass('has-error'); // clear error class
	    $('#modal_lupa').modal('show'); // show bootstrap modal
	    $('.title').text('Lupa Password'); // Set Title to Bootstrap modal title
	}

	function save_lupa()
	{
	$('#btnLupaSimpan').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnLupaSimpan').attr('disabled',true); //set button disable 	

    var url = "<?php echo site_url('user/lupa_pass')?>";

    // ajax adding data to database
    $.ajax({
    	url : url,
    	type: "POST",
    	data: $('#formLupa').serialize(),
    	dataType: "JSON",	
    	success: function(data)
    	{

            if(data.status) //if success close modal and reload ajax table
            {
            	swal("Success !", "Password Berhasil Diganti!", "success");
            	$('#modal_lupa').modal('hide');
            	location.reload(true);
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	swal("Error !", "Gagal Ganti Password!", "error");	

            $('#btnSave').text('Simpan Lagi...'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>