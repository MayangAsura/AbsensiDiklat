<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $konfig->nama_aplikasi?></title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="<?= base_url()?>assets/admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?= base_url()?>assets/admin/vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= base_url()?>assets/admin/vendors/css/vendor.bundle.addons.css">
	<script src="<?= base_url()?>assets/admin/vendors/js/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" href="<?= base_url()?>assets/admin/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<!-- endinject -->
	<link rel="shortcut icon" href="<?= base_url('images/'.$konfig->logo)?>" />
	<style type="text/css">
		.card-login{
			border-radius: 30px;
		}
	</style>
</head>

<body>
	<div>
		<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
			<div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
				<div class="row w-100">
					<div class="col-lg-4 mx-auto">
						<div class="auto-form-wrapper" style="border-radius: 30px;box-shadow: 0 4px 8px 0 rgba(48, 142, 224, 0.2), 0 6px 20px 0 rgba(48, 142, 224, 0.2);">
							<center>
								<img class="img-responsive" src="<?= base_url('images/'.$konfig->logo)?>" alt="logo" width="300"/>
								<br/><br/>
								<h4 class="text-primary"><b><?= $konfig->nama_aplikasi?></b></h4>
							</center>
							<br/>
							<div id="msg"></div>
							<?php 
							if ($this->session->flashdata('sukses')) { ?>
								<center><h5 class="text-danger"><?= $this->session->flashdata('sukses')?> </h5></center>
							<?php } ?>
							<form method="POST" name="LoginAdmin" id="LoginAdmin">
								<div class="form-group">
									<h5 class="label">Username</h5>
									<div class="input-group">
										<input type="text" class="form-control" name="username" id="username" placeholder="Username">
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="mdi mdi-account text-primary"></i>
											</span>
										</div><br/><br/>
										<small class="help-block text-danger" id="pesan"></small>
									</div>
								</div>
								<div class="form-group">
									<h5 class="label">Password</h5>
									<div class="input-group">
										<input type="password" class="form-control" name="password" id="Lgnpassword" placeholder="*********">
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="mdi mdi-lock text-primary"></i>
											</span>
										</div>
									</div>
									<input type="checkbox" onchange="cekPassword(this)" /> <small>Cek Password</small><br/>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary submit-btn btn-block" id="btnLogin" onclick="login()">Login</button>
								</div>
								<div class="form-group d-flex justify-content-between">
									<a href="#" class="text-small forgot-password text-black" onclick="lupa_password()">Lupa Kata Sandi ?</a>
								</div>
								<div class="form-group">
								</form>
							</div>
							<p class="footer-text text-center text-primary"><?=$konfig->footer?></p>
						</div>
					</div>
				</div>
				<!-- content-wrapper ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<?php //include('register.php');?>
		<?php //include('lupa_password.php');?>
		<!-- container-scroller -->
		<!-- plugins:js -->
		<script src="<?= base_url()?>assets/admin/vendors/js/vendor.bundle.base.js"></script>
		<script src="<?= base_url()?>assets/admin/vendors/js/vendor.bundle.addons.js"></script>
		<!-- endinject -->
		<!-- inject:js -->
		<script src="<?= base_url()?>assets/admin/js/off-canvas.js"></script>
		<script src="<?= base_url()?>assets/admin/js/misc.js"></script>
		<script type="text/javascript">
			function cekPassword(el) {
				$('#Lgnpassword').attr('type',el.checked ? 'text' : 'password');
			}

			function login()
			{
				event.preventDefault();
				
				$('#btnLogin').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Please wait ...');
				$('#btnLogin').attr('disabled',true); //set button disable

				$.ajax({
					url:"<?php echo site_url('login/cekLogin');?>",
					type: "POST",
					data: $('#LoginAdmin').serialize(),
					dataType: "JSON",
					success: function(data) {
						var result=data.split("_");
						if(result[0]=="0") 
						{
							swal("Error !", "Username / Password Salah!", "error");
							$('#msg').html("<center><h5 class='text-danger'> Username / Password Salah! </h5></center>");
							$('#btnLogin').html('Login Kembali ...');
							$('#btnLogin').attr('disabled',false);
						} 
						else if(result[0]=="1") 
						{
							swal("Success !", "Anda Berhasil Masuk!", "success");
							$('#btnLogin').html('<img src="<?=base_url('images/load.gif')?>" width="30"> Success! Mohon Tunggu...'); 
							window.location.href="<?php echo base_url('dashboard');?>"; 
						}
					}, error: function (jqXHR, textStatus, errorThrown) {
						swal("Error !", "Silakan Login Kembali!!", "error");
					}
				});
			}
		</script>
	</body>
	</html>