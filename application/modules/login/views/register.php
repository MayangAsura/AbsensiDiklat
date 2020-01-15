<!-- MODAL ADD -->
<div class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			               <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h3 class="text-center title"></h3>
						   <form class="forms-sample" action="#" method="POST" id="form">
							<small id="auth"></small>
							<div class="form-group">
								<label>Username</label> 
								<input type="text" class="form-control username" id="username" name="username" placeholder="Username">
								<small class="help-block text-danger" id="pesanRegis"></small>
							</div>
							<small id="penjelasan"></small>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control password" id="password" name="password" placeholder="Password">
										<input type="checkbox" onchange="tick(this)" /> <small>Cek Password</small><br/>
										<small class="help-block text-danger"></small>
										<small id="messagepassword"></small>
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
										<input type="email" class="form-control" id="email" name="email" placeholder="Email"><small class="help-block text-danger" id="pesanEmail"></small>
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
										<small id="pesanHP"></small>
									</div>
								</div>
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

		$('.username').blur(function(){
			$('#pesanRegis').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
			var username = $(this).val();

			$.ajax({
				type    : 'POST',
				url     : "<?php echo site_url('user/cek_username')?>",
				data    : {username: username},
				success : function(data){
					$('#pesanRegis').html(data);
				}
			})

		});
		$('#password').blur(function(){			
			if(this.value.length < 6) {
				$('#messagepassword').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
				$('#messagepassword').html("Harus lebih dari 5 karakter").css('color', 'red');
				$('#btnSave').attr('disabled',true);
			} else {
				$('#messagepassword').html(" ");
				$('#btnSave').attr('disabled',false);
			}
		});

		$('#no_hp').blur(function(){
			var no_hp = $(this).val();	
			if ($.isNumeric(no_hp)) {
				$('#btnSave').attr('disabled',false);
				$('#pesanHP').html("No. HP Diizinkan.").css('color', 'green');
			} else {
				$('#btnSave').attr('disabled',true);
				$('#pesanHP').html("No. HP Tidak Diizinkan.").css('color', 'red');
			}

		});

		$('#email').blur(function(){
			$('#pesanEmail').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Loading...');
			var email = $(this).val();
			if (isValidEmailAddress(email)) {
				$('#btnSave').attr('disabled',false);
				$.ajax({
					type    : 'POST',
					url     : "<?php echo site_url('user/cek_email')?>",
					data    : {email: email},
					success : function(data){
						$('#pesanEmail').html(data);
					}
				});
			} else {
				$('#btnSave').attr('disabled',true);
				$('#pesanEmail').html("Format email tidak sesuai.");
			}
		});

		$('#confirm').on('keyup', function () {
			if ($(this).val() == $('.password').val()) {
				$('#message').html('Password Cocok').css('color', 'green');
			} else $('#message').html('Password tidak cocok').css('color', 'red');
		});
	});

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}

	function tick(el) {
		$('#password').attr('type',el.checked ? 'text' : 'password');
	}

	function tick1(el) {
		$('#confirm').attr('type',el.checked ? 'text' : 'password');
	}
	
	function register()
	{
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('#modal_register').modal('show'); // show bootstrap modal
    $('.title').html('<b>Daftar User</b>'); // Set Title to Bootstrap modal title
}


function save()
{

	$('#btnSave').html('<img src="<?=base_url('images/load.gif')?>" width="40"> Please wait ...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    var url = "<?php echo site_url('login/ajax_add')?>"; // ajax adding data to database
    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
    	url : url,
    	type: "POST",
    	data: $('#form').serialize(),
    	dataType: "JSON",	
    	success: function(data)
    	{
            if(data.status) //if success close modal and reload ajax table
            {
            	$('#modal_register').modal('hide');
            	swal("Success !", "Anda Berhasil Daftar!", "success");
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

        	swal("Error !", "Anda Gagal Menyimpan!", "error");
        	
            $('#btnSave').text('Simpan Lagi...'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>